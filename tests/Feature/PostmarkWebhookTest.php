<?php

use App\Models\EmailEvent;
use App\Models\Newsletter;
use App\Models\NewsletterRecipient;
use App\Models\Subscriber;

beforeEach(function () {
    config([
        'services.postmark.webhook_user' => 'postmark',
        'services.postmark.webhook_password' => 'test-secret',
    ]);
});

function postWebhook(array $payload): \Illuminate\Testing\TestResponse
{
    return test()->withHeaders([
        'Authorization' => 'Basic '.base64_encode('postmark:test-secret'),
    ])->postJson('/webhooks/postmark', $payload);
}

test('webhook requires basic auth', function () {
    $this->postJson('/webhooks/postmark', ['RecordType' => 'Bounce'])->assertStatus(401);
});

test('webhook rejects bad credentials', function () {
    $this->withHeaders(['Authorization' => 'Basic '.base64_encode('postmark:wrong')])
        ->postJson('/webhooks/postmark', ['RecordType' => 'Bounce'])
        ->assertStatus(401);
});

test('hard bounce marks subscriber and recipient bounced', function () {
    $subscriber = Subscriber::factory()->create(['email' => 'bouncy@example.com']);
    $newsletter = Newsletter::factory()->sent()->create();
    $recipient = NewsletterRecipient::create([
        'newsletter_id' => $newsletter->id,
        'subscriber_id' => $subscriber->id,
        'email' => $subscriber->email,
        'postmark_message_id' => 'msg-123',
        'status' => NewsletterRecipient::STATUS_SENT,
    ]);

    postWebhook([
        'RecordType' => 'Bounce',
        'Type' => 'HardBounce',
        'Email' => 'bouncy@example.com',
        'MessageID' => 'msg-123',
        'BouncedAt' => '2026-04-28T12:00:00Z',
        'Description' => 'mailbox does not exist',
    ])->assertOk();

    expect($subscriber->fresh()->status)->toBe(Subscriber::STATUS_BOUNCED);
    expect($recipient->fresh()->status)->toBe(NewsletterRecipient::STATUS_BOUNCED);
    expect($newsletter->fresh()->bounces_count)->toBe(1);
    expect(EmailEvent::where('record_type', 'Bounce')->count())->toBe(1);
});

test('spam complaint marks subscriber complained', function () {
    $subscriber = Subscriber::factory()->create(['email' => 'angry@example.com']);
    $newsletter = Newsletter::factory()->sent()->create();
    $recipient = NewsletterRecipient::create([
        'newsletter_id' => $newsletter->id,
        'subscriber_id' => $subscriber->id,
        'email' => $subscriber->email,
        'postmark_message_id' => 'msg-456',
        'status' => NewsletterRecipient::STATUS_DELIVERED,
    ]);

    postWebhook([
        'RecordType' => 'SpamComplaint',
        'Email' => 'angry@example.com',
        'MessageID' => 'msg-456',
    ])->assertOk();

    expect($subscriber->fresh()->status)->toBe(Subscriber::STATUS_COMPLAINED);
    expect($newsletter->fresh()->complaints_count)->toBe(1);
});

test('subscription change suppression unsubscribes', function () {
    $subscriber = Subscriber::factory()->create(['email' => 'leaving@example.com']);

    postWebhook([
        'RecordType' => 'SubscriptionChange',
        'Recipient' => 'leaving@example.com',
        'SuppressSending' => true,
        'ChangedAt' => '2026-04-28T12:00:00Z',
    ])->assertOk();

    expect($subscriber->fresh()->status)->toBe(Subscriber::STATUS_UNSUBSCRIBED);
});

test('open event increments counters', function () {
    $newsletter = Newsletter::factory()->sent()->create();
    $subscriber = Subscriber::factory()->create();
    $recipient = NewsletterRecipient::create([
        'newsletter_id' => $newsletter->id,
        'subscriber_id' => $subscriber->id,
        'email' => $subscriber->email,
        'postmark_message_id' => 'msg-789',
        'status' => NewsletterRecipient::STATUS_DELIVERED,
    ]);

    postWebhook([
        'RecordType' => 'Open',
        'Email' => $subscriber->email,
        'MessageID' => 'msg-789',
        'ReceivedAt' => '2026-04-28T12:00:00Z',
    ])->assertOk();

    postWebhook([
        'RecordType' => 'Open',
        'Email' => $subscriber->email,
        'MessageID' => 'msg-789',
        'ReceivedAt' => '2026-04-28T12:01:00Z',
    ])->assertOk();

    expect($recipient->fresh()->opens_count)->toBe(2);
    expect($newsletter->fresh()->opens_count)->toBe(2);
    expect($newsletter->fresh()->unique_opens_count)->toBe(1);
});

test('click event increments counters', function () {
    $newsletter = Newsletter::factory()->sent()->create();
    $subscriber = Subscriber::factory()->create();
    $recipient = NewsletterRecipient::create([
        'newsletter_id' => $newsletter->id,
        'subscriber_id' => $subscriber->id,
        'email' => $subscriber->email,
        'postmark_message_id' => 'msg-click',
        'status' => NewsletterRecipient::STATUS_DELIVERED,
    ]);

    postWebhook([
        'RecordType' => 'Click',
        'Email' => $subscriber->email,
        'MessageID' => 'msg-click',
    ])->assertOk();

    expect($recipient->fresh()->clicks_count)->toBe(1);
    expect($newsletter->fresh()->unique_clicks_count)->toBe(1);
});

test('delivery event marks recipient delivered', function () {
    $newsletter = Newsletter::factory()->sent()->create();
    $subscriber = Subscriber::factory()->create();
    $recipient = NewsletterRecipient::create([
        'newsletter_id' => $newsletter->id,
        'subscriber_id' => $subscriber->id,
        'email' => $subscriber->email,
        'postmark_message_id' => 'msg-delivered',
        'status' => NewsletterRecipient::STATUS_SENT,
    ]);

    postWebhook([
        'RecordType' => 'Delivery',
        'Recipient' => $subscriber->email,
        'MessageID' => 'msg-delivered',
        'DeliveredAt' => '2026-04-28T12:00:00Z',
    ])->assertOk();

    expect($recipient->fresh()->status)->toBe(NewsletterRecipient::STATUS_DELIVERED);
    expect($newsletter->fresh()->delivered_count)->toBe(1);
});
