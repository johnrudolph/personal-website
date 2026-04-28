<?php

use App\Models\Subscriber;
use Illuminate\Support\Facades\URL;

test('signed unsubscribe link sets subscriber status to unsubscribed', function () {
    $subscriber = Subscriber::factory()->create();

    $url = URL::signedRoute('unsubscribe', ['token' => $subscriber->unsubscribe_token]);

    $this->get($url)->assertOk()->assertSee($subscriber->email);

    expect($subscriber->fresh()->status)->toBe(Subscriber::STATUS_UNSUBSCRIBED);
    expect($subscriber->fresh()->unsubscribed_at)->not->toBeNull();
});

test('unsigned unsubscribe link is rejected', function () {
    $subscriber = Subscriber::factory()->create();

    $this->get('/unsubscribe/'.$subscriber->unsubscribe_token)->assertStatus(403);

    expect($subscriber->fresh()->status)->toBe(Subscriber::STATUS_SUBSCRIBED);
});

test('one-click POST unsubscribe works', function () {
    $subscriber = Subscriber::factory()->create();

    $url = URL::signedRoute('unsubscribe.post', ['token' => $subscriber->unsubscribe_token]);

    $this->post($url)->assertOk();

    expect($subscriber->fresh()->status)->toBe(Subscriber::STATUS_UNSUBSCRIBED);
});
