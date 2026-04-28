<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostmarkWebhookController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\UnsubscribeController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->file(public_path('landing.html')));

Route::post('contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.store');

Route::post('subscribe', [SubscribeController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('subscribe.store');

Route::get('unsubscribe/{token}', [UnsubscribeController::class, 'show'])
    ->name('unsubscribe');

Route::post('unsubscribe/{token}', [UnsubscribeController::class, 'post'])
    ->name('unsubscribe.post');

Route::post('webhooks/postmark', [PostmarkWebhookController::class, 'handle'])
    ->middleware('postmark.basic')
    ->name('webhooks.postmark');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
