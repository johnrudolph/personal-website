<?php

use App\Models\Subscriber;

test('valid subscribe creates subscriber', function () {
    $response = $this->postJson('/subscribe', [
        'email' => 'reader@example.com',
        'started_at' => (int) round(microtime(true) * 1000) - 3000,
    ]);

    $response->assertOk()->assertJson(['ok' => true]);

    $subscriber = Subscriber::where('email', 'reader@example.com')->first();
    expect($subscriber)->not->toBeNull();
    expect($subscriber->status)->toBe(Subscriber::STATUS_SUBSCRIBED);
    expect($subscriber->source)->toBe('footer_form');
});

test('honeypot blocks subscribe', function () {
    $response = $this->postJson('/subscribe', [
        'email' => 'bot@example.com',
        'website' => 'spam',
        'started_at' => (int) round(microtime(true) * 1000) - 3000,
    ]);

    $response->assertStatus(422);
    expect(Subscriber::count())->toBe(0);
});

test('previously unsubscribed user is resubscribed', function () {
    Subscriber::factory()->unsubscribed()->create(['email' => 'returning@example.com']);

    $response = $this->postJson('/subscribe', [
        'email' => 'returning@example.com',
        'started_at' => (int) round(microtime(true) * 1000) - 3000,
    ]);

    $response->assertOk();

    $subscriber = Subscriber::where('email', 'returning@example.com')->first();
    expect($subscriber->status)->toBe(Subscriber::STATUS_SUBSCRIBED);
    expect($subscriber->unsubscribed_at)->toBeNull();
});

test('invalid email is rejected', function () {
    $this->postJson('/subscribe', ['email' => 'not-an-email'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});
