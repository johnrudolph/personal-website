<?php

namespace App\Http\Controllers;

use App\Models\EmailEvent;
use App\Models\NewsletterRecipient;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostmarkWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();
        $type = $payload['RecordType'] ?? null;

        if (! is_string($type)) {
            return response()->json(['ok' => false, 'error' => 'missing RecordType'], 422);
        }

        $email = $this->resolveEmail($type, $payload);
        $messageId = $payload['MessageID'] ?? null;

        $recipient = $messageId
            ? NewsletterRecipient::where('postmark_message_id', $messageId)->first()
            : null;

        $subscriber = $email
            ? Subscriber::where('email', mb_strtolower($email))->first()
            : ($recipient?->subscriber);

        EmailEvent::create([
            'record_type' => $type,
            'postmark_message_id' => is_string($messageId) ? $messageId : null,
            'email' => $email,
            'subscriber_id' => $subscriber?->id,
            'newsletter_id' => $recipient?->newsletter_id,
            'newsletter_recipient_id' => $recipient?->id,
            'payload' => $payload,
            'received_at' => now(),
        ]);

        match ($type) {
            'Bounce' => $this->handleBounce($payload, $subscriber, $recipient),
            'SpamComplaint' => $this->handleComplaint($payload, $subscriber, $recipient),
            'SubscriptionChange' => $this->handleSubscriptionChange($payload, $subscriber),
            'Delivery' => $this->handleDelivery($payload, $recipient),
            'Open' => $this->handleOpen($payload, $recipient),
            'Click' => $this->handleClick($payload, $recipient),
            default => null,
        };

        return response()->json(['ok' => true]);
    }

    private function resolveEmail(string $type, array $payload): ?string
    {
        $candidate = match ($type) {
            'SubscriptionChange' => $payload['Recipient'] ?? null,
            default => $payload['Email'] ?? $payload['Recipient'] ?? null,
        };

        return is_string($candidate) ? mb_strtolower($candidate) : null;
    }

    private function timestamp(array $payload, string ...$keys): Carbon
    {
        foreach ($keys as $key) {
            if (! empty($payload[$key])) {
                try {
                    return Carbon::parse($payload[$key]);
                } catch (\Throwable) {
                    continue;
                }
            }
        }

        return now();
    }

    private function handleBounce(array $payload, ?Subscriber $subscriber, ?NewsletterRecipient $recipient): void
    {
        $occurredAt = $this->timestamp($payload, 'BouncedAt');
        $isHard = ($payload['Type'] ?? null) === 'HardBounce' || (bool) ($payload['Inactive'] ?? false);

        if ($recipient) {
            $recipient->update([
                'status' => NewsletterRecipient::STATUS_BOUNCED,
                'bounced_at' => $occurredAt,
                'error' => mb_substr((string) ($payload['Description'] ?? ''), 0, 1000),
            ]);

            $recipient->newsletter?->increment('bounces_count');
        }

        if ($subscriber && $isHard) {
            $subscriber->update([
                'status' => Subscriber::STATUS_BOUNCED,
                'bounced_at' => $occurredAt,
                'last_event_at' => now(),
            ]);
        } elseif ($subscriber) {
            $subscriber->update(['last_event_at' => now()]);
        }
    }

    private function handleComplaint(array $payload, ?Subscriber $subscriber, ?NewsletterRecipient $recipient): void
    {
        $occurredAt = $this->timestamp($payload, 'BouncedAt');

        if ($recipient) {
            $recipient->update([
                'status' => NewsletterRecipient::STATUS_COMPLAINED,
                'complained_at' => $occurredAt,
            ]);
            $recipient->newsletter?->increment('complaints_count');
        }

        $subscriber?->update([
            'status' => Subscriber::STATUS_COMPLAINED,
            'complained_at' => $occurredAt,
            'last_event_at' => now(),
        ]);
    }

    private function handleSubscriptionChange(array $payload, ?Subscriber $subscriber): void
    {
        if (! $subscriber) {
            return;
        }

        $suppressed = (bool) ($payload['SuppressSending'] ?? false);

        $subscriber->update([
            'status' => $suppressed ? Subscriber::STATUS_UNSUBSCRIBED : Subscriber::STATUS_SUBSCRIBED,
            'unsubscribed_at' => $suppressed ? $this->timestamp($payload, 'ChangedAt') : null,
            'last_event_at' => now(),
        ]);
    }

    private function handleDelivery(array $payload, ?NewsletterRecipient $recipient): void
    {
        if (! $recipient) {
            return;
        }

        $recipient->update([
            'status' => NewsletterRecipient::STATUS_DELIVERED,
            'delivered_at' => $this->timestamp($payload, 'DeliveredAt'),
        ]);

        $recipient->newsletter?->increment('delivered_count');
    }

    private function handleOpen(array $payload, ?NewsletterRecipient $recipient): void
    {
        if (! $recipient) {
            return;
        }

        $isFirst = $recipient->first_opened_at === null;

        $recipient->increment('opens_count');

        if ($isFirst) {
            $recipient->update(['first_opened_at' => $this->timestamp($payload, 'ReceivedAt')]);
            $recipient->newsletter?->increment('unique_opens_count');
        }

        $recipient->newsletter?->increment('opens_count');
    }

    private function handleClick(array $payload, ?NewsletterRecipient $recipient): void
    {
        if (! $recipient) {
            return;
        }

        $isFirst = $recipient->first_clicked_at === null;

        $recipient->increment('clicks_count');

        if ($isFirst) {
            $recipient->update(['first_clicked_at' => $this->timestamp($payload, 'ReceivedAt')]);
            $recipient->newsletter?->increment('unique_clicks_count');
        }

        $recipient->newsletter?->increment('clicks_count');
    }
}
