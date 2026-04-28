<?php

namespace App\Jobs;

use App\Models\Newsletter;
use App\Models\NewsletterRecipient;
use App\Models\Subscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNewsletterJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $newsletterId) {}

    public function handle(): void
    {
        $newsletter = Newsletter::find($this->newsletterId);

        if (! $newsletter || $newsletter->status === Newsletter::STATUS_SENT) {
            return;
        }

        $newsletter->update([
            'status' => Newsletter::STATUS_SENDING,
            'sent_at' => $newsletter->sent_at ?? now(),
        ]);

        Subscriber::query()
            ->where('status', Subscriber::STATUS_SUBSCRIBED)
            ->orderBy('id')
            ->chunkById(500, function ($subscribers) use ($newsletter) {
                foreach ($subscribers as $subscriber) {
                    $recipient = NewsletterRecipient::firstOrCreate(
                        [
                            'newsletter_id' => $newsletter->id,
                            'subscriber_id' => $subscriber->id,
                        ],
                        [
                            'email' => $subscriber->email,
                            'status' => NewsletterRecipient::STATUS_PENDING,
                        ]
                    );

                    if ($recipient->status === NewsletterRecipient::STATUS_PENDING) {
                        SendNewsletterRecipientJob::dispatch($recipient->id);
                    }
                }
            });

        $newsletter->update([
            'recipients_count' => $newsletter->recipients()->count(),
            'status' => Newsletter::STATUS_SENT,
        ]);
    }
}
