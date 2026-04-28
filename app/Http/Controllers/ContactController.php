<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactSubmissionNotification;
use App\Models\ContactSubmission;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(ContactRequest $request): JsonResponse
    {
        if ($started = $request->integer('started_at')) {
            $elapsed = (int) round(microtime(true) * 1000) - $started;
            if ($elapsed < 2000) {
                return response()->json(['ok' => false, 'error' => 'too_fast'], 422);
            }
        }

        $subscriber = Subscriber::firstOrCreate(
            ['email' => mb_strtolower(trim($request->string('email')))],
            [
                'name' => $request->string('name'),
                'status' => Subscriber::STATUS_SUBSCRIBED,
                'source' => 'contact_form',
                'subscribed_at' => now(),
            ]
        );

        $submission = ContactSubmission::create([
            'name' => $request->string('name'),
            'email' => mb_strtolower(trim($request->string('email'))),
            'company' => $request->string('company')->toString() ?: null,
            'scope' => $request->string('scope')->toString() ?: null,
            'message' => $request->string('message'),
            'ip' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 255),
            'subscriber_id' => $subscriber->id,
        ]);

        Mail::to(config('services.contact.recipient'))->send(new ContactSubmissionNotification($submission));

        return response()->json(['ok' => true]);
    }
}
