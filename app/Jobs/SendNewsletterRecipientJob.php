<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use App\Models\NewsletterRecipient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Throwable;

class SendNewsletterRecipientJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(public int $recipientId) {}

    public function handle(): void
    {
        $recipient = NewsletterRecipient::with(['newsletter', 'subscriber'])->find($this->recipientId);

        if (! $recipient || ! $recipient->newsletter || ! $recipient->subscriber) {
            return;
        }

        if ($recipient->status !== NewsletterRecipient::STATUS_PENDING) {
            return;
        }

        if (! $recipient->subscriber->isMailable()) {
            $recipient->update([
                'status' => NewsletterRecipient::STATUS_FAILED,
                'error' => 'Subscriber not mailable: '.$recipient->subscriber->status,
            ]);

            return;
        }

        $unsubscribeUrl = URL::signedRoute('unsubscribe', [
            'token' => $recipient->subscriber->unsubscribe_token,
        ]);

        $mail = new NewsletterMail(
            newsletter: $recipient->newsletter,
            unsubscribeUrl: $unsubscribeUrl,
        );

        $sent = Mail::mailer('postmark-broadcast')->to($recipient->email)->send($mail);

        $messageId = null;
        if ($sent && method_exists($sent, 'getMessageId')) {
            $messageId = $sent->getMessageId();
        }

        $recipient->update([
            'status' => NewsletterRecipient::STATUS_SENT,
            'sent_at' => now(),
            'postmark_message_id' => $messageId,
        ]);
    }

    public function failed(Throwable $e): void
    {
        $recipient = NewsletterRecipient::find($this->recipientId);

        if ($recipient) {
            $recipient->update([
                'status' => NewsletterRecipient::STATUS_FAILED,
                'error' => mb_substr($e->getMessage(), 0, 1000),
            ]);
        }
    }
}
