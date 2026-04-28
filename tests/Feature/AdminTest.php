<?php

use App\Mail\NewsletterMail;
use App\Models\ContactSubmission;
use App\Models\Newsletter;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('admin routes require authentication', function () {
    $this->get('/admin')->assertRedirect('/login');
    $this->get('/admin/subscribers')->assertRedirect('/login');
    $this->get('/admin/newsletters')->assertRedirect('/login');
});

test('admin dashboard renders for authenticated user', function () {
    $user = User::factory()->create();

    Subscriber::factory()->count(2)->create();
    Subscriber::factory()->unsubscribed()->create();
    Newsletter::factory()->create();
    ContactSubmission::factory()->create();

    $this->actingAs($user)->get('/admin')
        ->assertOk()
        ->assertSee('Dashboard');
});

test('admin can list and filter subscribers', function () {
    $user = User::factory()->create();
    Subscriber::factory()->create(['email' => 'active@example.com']);
    Subscriber::factory()->unsubscribed()->create(['email' => 'gone@example.com']);

    $this->actingAs($user)->get('/admin/subscribers?status=subscribed')
        ->assertOk()
        ->assertSee('active@example.com')
        ->assertDontSee('gone@example.com');
});

test('admin can create a newsletter draft', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/admin/newsletters', [
        'subject' => 'Hi there',
        'html' => '<p>Hello.</p>',
    ])->assertRedirect();

    expect(Newsletter::where('subject', 'Hi there')->exists())->toBeTrue();
});

test('admin can send a test email', function () {
    Mail::fake();
    $user = User::factory()->create();
    $newsletter = Newsletter::factory()->create();

    $this->actingAs($user)->post("/admin/newsletters/{$newsletter->id}/test-send", [
        'email' => 'me@example.com',
    ])->assertRedirect();

    Mail::assertSent(NewsletterMail::class, function (NewsletterMail $mail) {
        return $mail->isTest === true && $mail->hasTo('me@example.com');
    });
});

test('admin cannot edit a sent newsletter', function () {
    $user = User::factory()->create();
    $newsletter = Newsletter::factory()->sent()->create();

    $this->actingAs($user)->get("/admin/newsletters/{$newsletter->id}/edit")
        ->assertStatus(403);
});

test('sending a draft transitions to sent and creates recipients', function () {
    $user = User::factory()->create();
    Subscriber::factory()->count(2)->create();
    $newsletter = Newsletter::factory()->create();

    Mail::fake();

    $this->actingAs($user)->post("/admin/newsletters/{$newsletter->id}/send")
        ->assertRedirect();

    expect($newsletter->fresh()->status)->toBe(Newsletter::STATUS_SENT);
    Mail::assertSent(NewsletterMail::class, 2);
});
