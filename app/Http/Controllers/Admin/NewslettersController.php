<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewsletterJob;
use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class NewslettersController extends Controller
{
    public function index(): View
    {
        return view('admin.newsletters.index', [
            'newsletters' => Newsletter::orderByDesc('created_at')->paginate(25),
        ]);
    }

    public function create(): View
    {
        return view('admin.newsletters.edit', [
            'newsletter' => new Newsletter(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $newsletter = Newsletter::create($this->validated($request));

        return redirect()->route('admin.newsletters.show', $newsletter)
            ->with('status', 'Newsletter saved.');
    }

    public function show(Newsletter $newsletter): View
    {
        return view('admin.newsletters.show', [
            'newsletter' => $newsletter->load('recipients.subscriber'),
        ]);
    }

    public function edit(Newsletter $newsletter): View
    {
        abort_unless($newsletter->isDraft(), 403, 'Cannot edit a sent newsletter.');

        return view('admin.newsletters.edit', ['newsletter' => $newsletter]);
    }

    public function update(Request $request, Newsletter $newsletter): RedirectResponse
    {
        abort_unless($newsletter->isDraft(), 403, 'Cannot edit a sent newsletter.');

        $newsletter->update($this->validated($request));

        return redirect()->route('admin.newsletters.show', $newsletter)
            ->with('status', 'Newsletter saved.');
    }

    public function destroy(Newsletter $newsletter): RedirectResponse
    {
        abort_unless($newsletter->isDraft(), 403, 'Cannot delete a sent newsletter.');

        $newsletter->delete();

        return redirect()->route('admin.newsletters.index')->with('status', 'Newsletter deleted.');
    }

    public function testSend(Request $request, Newsletter $newsletter): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc'],
        ]);

        $unsubscribeUrl = URL::signedRoute('unsubscribe', [
            'token' => 'preview-'.Str::random(16),
        ]);

        Mail::mailer('postmark-broadcast')->to($data['email'])->send(new NewsletterMail(
            newsletter: $newsletter,
            unsubscribeUrl: $unsubscribeUrl,
            isTest: true,
        ));

        return back()->with('status', "Test email sent to {$data['email']}.");
    }

    public function send(Newsletter $newsletter): RedirectResponse
    {
        abort_unless($newsletter->isDraft(), 422, 'This newsletter has already been sent.');

        SendNewsletterJob::dispatch($newsletter->id);

        return redirect()->route('admin.newsletters.show', $newsletter)
            ->with('status', 'Newsletter queued for sending.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'html' => ['required', 'string'],
        ]);
    }
}
