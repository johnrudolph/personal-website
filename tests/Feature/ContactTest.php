<?php

use App\Mail\ContactSubmissionNotification;
use App\Models\ContactSubmission;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Mail::fake();
});

test('valid submission is stored, autosubscribed and emailed', function () {
    $response = $this->postJson('/contact', [
        'name' => 'Jane Hart',
        'email' => 'JANE@example.com',
        'company' => 'Acme',
        'scope' => '30-day assessment',
        'message' => 'Help, our roadmap is chaos.',
        'started_at' => (int) round(microtime(true) * 1000) - 5000,
    ]);

    $response->assertOk()->assertJson(['ok' => true]);

    expect(ContactSubmission::count())->toBe(1);

    $submission = ContactSubmission::first();
    expect($submission->email)->toBe('jane@example.com');

    $subscriber = Subscriber::where('email', 'jane@example.com')->first();
    expect($subscriber)->not->toBeNull();
    expect($subscriber->status)->toBe(Subscriber::STATUS_SUBSCRIBED);
    expect($submission->subscriber_id)->toBe($subscriber->id);

    Mail::assertQueued(ContactSubmissionNotification::class);
});

test('honeypot blocks submission', function () {
    $response = $this->postJson('/contact', [
        'name' => 'Bot',
        'email' => 'bot@example.com',
        'message' => 'Buy my pills',
        'website' => 'http://spam.example',
        'started_at' => (int) round(microtime(true) * 1000) - 5000,
    ]);

    $response->assertStatus(422);

    expect(ContactSubmission::count())->toBe(0);
    Mail::assertNothingQueued();
});

test('time trap blocks submission', function () {
    $response = $this->postJson('/contact', [
        'name' => 'Speed Bot',
        'email' => 'speed@example.com',
        'message' => 'Hi',
        'started_at' => (int) round(microtime(true) * 1000) - 100,
    ]);

    $response->assertStatus(422);

    expect(ContactSubmission::count())->toBe(0);
});

test('validation rejects missing fields', function () {
    $response = $this->postJson('/contact', [
        'name' => '',
        'email' => 'not-an-email',
        'message' => '',
    ]);

    $response->assertStatus(422)->assertJsonValidationErrors(['name', 'email', 'message']);
});

test('repeat submission does not duplicate subscriber', function () {
    Subscriber::factory()->create(['email' => 'jane@example.com']);

    $response = $this->postJson('/contact', [
        'name' => 'Jane',
        'email' => 'jane@example.com',
        'message' => 'Hi again',
        'started_at' => (int) round(microtime(true) * 1000) - 5000,
    ]);

    $response->assertOk();

    expect(Subscriber::where('email', 'jane@example.com')->count())->toBe(1);
});
