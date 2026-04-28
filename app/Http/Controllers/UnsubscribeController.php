<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnsubscribeController extends Controller
{
    public function show(Request $request, string $token): View|Response
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or expired unsubscribe link.');
        }

        $subscriber = Subscriber::where('unsubscribe_token', $token)->first();

        if (! $subscriber) {
            abort(404);
        }

        if ($subscriber->status !== Subscriber::STATUS_UNSUBSCRIBED) {
            $subscriber->update([
                'status' => Subscriber::STATUS_UNSUBSCRIBED,
                'unsubscribed_at' => now(),
            ]);
        }

        return view('unsubscribe', ['email' => $subscriber->email]);
    }

    public function post(Request $request, string $token): Response
    {
        if (! $request->hasValidSignature()) {
            abort(403);
        }

        $subscriber = Subscriber::where('unsubscribe_token', $token)->first();

        if ($subscriber && $subscriber->status !== Subscriber::STATUS_UNSUBSCRIBED) {
            $subscriber->update([
                'status' => Subscriber::STATUS_UNSUBSCRIBED,
                'unsubscribed_at' => now(),
            ]);
        }

        return response('', 200);
    }
}
