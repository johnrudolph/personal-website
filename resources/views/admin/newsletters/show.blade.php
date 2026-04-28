@extends('admin.layout', ['title' => $newsletter->subject])

@section('content')
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ $newsletter->subject }}</h1>
            <p class="mt-1 text-sm text-stone-500">
                <span @class([
                    'inline-flex rounded px-2 py-0.5 text-xs font-medium',
                    'bg-stone-200 text-stone-700' => $newsletter->status === 'draft',
                    'bg-amber-100 text-amber-800' => $newsletter->status === 'sending',
                    'bg-emerald-100 text-emerald-800' => $newsletter->status === 'sent',
                ])>{{ $newsletter->status }}</span>
                @if ($newsletter->sent_at)
                    · Sent {{ $newsletter->sent_at->format('Y-m-d H:i') }}
                @endif
            </p>
        </div>
        <div class="flex gap-2">
            @if ($newsletter->isDraft())
                <a href="{{ route('admin.newsletters.edit', $newsletter) }}" class="rounded border border-stone-300 px-3 py-1.5 text-sm hover:bg-stone-100">Edit</a>
                <form method="POST" action="{{ route('admin.newsletters.destroy', $newsletter) }}" onsubmit="return confirm('Delete this draft?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded border border-red-300 px-3 py-1.5 text-sm text-red-700 hover:bg-red-50">Delete</button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-5 mb-8">
        @foreach ([
            'Recipients' => $newsletter->recipients_count,
            'Delivered' => $newsletter->delivered_count,
            'Opens' => $newsletter->unique_opens_count,
            'Clicks' => $newsletter->unique_clicks_count,
            'Bounces' => $newsletter->bounces_count,
        ] as $label => $count)
            <div class="rounded border border-stone-200 bg-white p-4">
                <div class="text-xs uppercase tracking-wide text-stone-500">{{ $label }}</div>
                <div class="mt-1 text-2xl font-semibold">{{ $count }}</div>
            </div>
        @endforeach
    </div>

    <section class="mb-8 rounded border border-stone-200 bg-white p-6">
        <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-stone-500">Test send</h2>
        <form method="POST" action="{{ route('admin.newsletters.test-send', $newsletter) }}" class="flex flex-wrap items-center gap-3">
            @csrf
            <input type="email" name="email" placeholder="you@example.com" required class="w-72 rounded border-stone-300 text-sm shadow-sm">
            <button type="submit" class="rounded bg-stone-900 px-4 py-1.5 text-sm font-medium text-white hover:bg-stone-700">Send test</button>
        </form>
    </section>

    @if ($newsletter->isDraft())
        <section class="mb-8 rounded border border-amber-300 bg-amber-50 p-6">
            <h2 class="mb-2 text-sm font-semibold uppercase tracking-wide text-amber-900">Send to all subscribers</h2>
            <p class="mb-4 text-sm text-amber-900">This sends the newsletter to every subscriber with status "subscribed". Send a test first.</p>
            <form method="POST" action="{{ route('admin.newsletters.send', $newsletter) }}" onsubmit="return confirm('Send to ALL subscribers?');">
                @csrf
                <button type="submit" class="rounded bg-amber-900 px-4 py-2 text-sm font-medium text-white hover:bg-amber-800">Send now</button>
            </form>
        </section>
    @endif

    <section class="mb-8 rounded border border-stone-200 bg-white">
        <h2 class="border-b border-stone-200 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-stone-500">Body preview</h2>
        <div class="prose prose-stone max-w-none p-6">{!! $newsletter->html !!}</div>
    </section>

    @if ($newsletter->recipients->isNotEmpty())
        <section class="rounded border border-stone-200 bg-white">
            <h2 class="border-b border-stone-200 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-stone-500">Recipients ({{ $newsletter->recipients->count() }})</h2>
            <table class="w-full text-sm">
                <thead class="bg-stone-50 text-left text-xs uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Opens</th>
                        <th class="px-4 py-2">Clicks</th>
                        <th class="px-4 py-2">Sent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($newsletter->recipients as $r)
                        <tr class="border-t border-stone-100">
                            <td class="px-4 py-2">{{ $r->email }}</td>
                            <td class="px-4 py-2">{{ $r->status }}</td>
                            <td class="px-4 py-2">{{ $r->opens_count }}</td>
                            <td class="px-4 py-2">{{ $r->clicks_count }}</td>
                            <td class="px-4 py-2 text-stone-600">{{ optional($r->sent_at)->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    @endif
@endsection
