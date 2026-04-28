<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Contracts\View\View;

class ContactSubmissionsController extends Controller
{
    public function index(): View
    {
        return view('admin.contact-submissions.index', [
            'submissions' => ContactSubmission::orderByDesc('created_at')->paginate(50),
        ]);
    }

    public function show(ContactSubmission $contactSubmission): View
    {
        return view('admin.contact-submissions.show', [
            'submission' => $contactSubmission->load('subscriber'),
        ]);
    }
}
