<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function index(Request $request): View
    {
        $allowedStatuses = [
            Subscriber::STATUS_SUBSCRIBED,
            Subscriber::STATUS_UNSUBSCRIBED,
            Subscriber::STATUS_BOUNCED,
            Subscriber::STATUS_COMPLAINED,
        ];

        $status = $request->string('status')->toString();
        $search = trim($request->string('q')->toString());

        $subscribers = Subscriber::query()
            ->when(in_array($status, $allowedStatuses, true), fn ($q) => $q->where('status', $status))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(50)
            ->withQueryString();

        return view('admin.subscribers.index', [
            'subscribers' => $subscribers,
            'status' => $status,
            'search' => $search,
            'statuses' => $allowedStatuses,
        ]);
    }

    public function update(Request $request, Subscriber $subscriber): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:subscribed,unsubscribed,bounced,complained'],
        ]);

        $subscriber->update([
            'status' => $data['status'],
            'subscribed_at' => $data['status'] === Subscriber::STATUS_SUBSCRIBED ? now() : $subscriber->subscribed_at,
            'unsubscribed_at' => $data['status'] === Subscriber::STATUS_UNSUBSCRIBED ? now() : null,
        ]);

        return back()->with('status', 'Subscriber updated.');
    }

    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')->with('status', 'Subscriber deleted.');
    }
}
