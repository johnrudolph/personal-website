<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'prohibited'],
            'started_at' => ['nullable', 'integer'],
        ]);

        if ($started = (int) ($data['started_at'] ?? 0)) {
            $elapsed = (int) round(microtime(true) * 1000) - $started;
            if ($elapsed < 1500) {
                return response()->json(['ok' => false, 'error' => 'too_fast'], 422);
            }
        }

        $email = mb_strtolower(trim($data['email']));

        $subscriber = Subscriber::firstOrCreate(
            ['email' => $email],
            [
                'name' => $data['name'] ?? null,
                'status' => Subscriber::STATUS_SUBSCRIBED,
                'source' => 'footer_form',
                'subscribed_at' => now(),
            ]
        );

        if (in_array($subscriber->status, [Subscriber::STATUS_UNSUBSCRIBED, Subscriber::STATUS_BOUNCED, Subscriber::STATUS_COMPLAINED], true)) {
            $subscriber->update([
                'status' => Subscriber::STATUS_SUBSCRIBED,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);
        }

        return response()->json(['ok' => true]);
    }
}
