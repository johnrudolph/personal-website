<?php

use App\Jobs\SendNewsletterJob;
use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use App\Models\NewsletterRecipient;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Mail::fake();
});

test('SendNewsletterJob fans out to all subscribed users', function () {
    $newsletter = Newsletter::factory()->create();
    Subscriber::factory()->count(3)->create();
    Subscriber::factory()->unsubscribed()->create();
    Subscriber::factory()->bounced()->create();

    SendNewsletterJob::dispatchSync($newsletter->id);

    expect($newsletter->fresh()->status)->toBe(Newsletter::STATUS_SENT);
    expect($newsletter->fresh()->recipients_count)->toBe(3);
    expect(NewsletterRecipient::where('newsletter_id', $newsletter->id)->count())->toBe(3);

    Mail::assertSent(NewsletterMail::class, 3);
});

test('SendNewsletterJob skips already-sent newsletter', function () {
    $newsletter = Newsletter::factory()->sent()->create();
    Subscriber::factory()->create();

    SendNewsletterJob::dispatchSync($newsletter->id);

    Mail::assertNothingSent();
});

test('SendNewsletterJob does not duplicate recipients on re-run', function () {
    $newsletter = Newsletter::factory()->create();
    Subscriber::factory()->count(2)->create();

    SendNewsletterJob::dispatchSync($newsletter->id);
    expect(NewsletterRecipient::where('newsletter_id', $newsletter->id)->count())->toBe(2);

    // Force back to draft and re-run; existing rows should not duplicate.
    $newsletter->update(['status' => Newsletter::STATUS_DRAFT]);
    SendNewsletterJob::dispatchSync($newsletter->id);

    expect(NewsletterRecipient::where('newsletter_id', $newsletter->id)->count())->toBe(2);
});
