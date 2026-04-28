<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'subscriberCounts' => [
                'total' => Subscriber::count(),
                'subscribed' => Subscriber::where('status', Subscriber::STATUS_SUBSCRIBED)->count(),
                'unsubscribed' => Subscriber::where('status', Subscriber::STATUS_UNSUBSCRIBED)->count(),
                'bounced' => Subscriber::where('status', Subscriber::STATUS_BOUNCED)->count(),
                'complained' => Subscriber::where('status', Subscriber::STATUS_COMPLAINED)->count(),
            ],
            'recentNewsletters' => Newsletter::orderByDesc('created_at')->limit(5)->get(),
            'recentSubmissions' => ContactSubmission::orderByDesc('created_at')->limit(5)->get(),
        ]);
    }
}
