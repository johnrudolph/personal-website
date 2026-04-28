@extends('admin.layout', ['title' => 'Dashboard'])

@section('content')
    <h1 class="mb-6 text-2xl font-semibold">Dashboard</h1>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-5">
        @foreach ($subscriberCounts as $label => $count)
            <div class="rounded border border-stone-200 bg-white p-4">
                <div class="text-xs uppercase tracking-wide text-stone-500">{{ str_replace('_', ' ', $label) }}</div>
                <div class="mt-1 text-2xl font-semibold">{{ $count }}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-10 grid gap-8 md:grid-cols-2">
        <section>
            <div class="mb-3 flex items-baseline justify-between">
                <h2 class="text-lg font-semibold">Recent newsletters</h2>
                <a class="text-sm text-stone-600 hover:text-stone-900" href="{{ route('admin.newsletters.index') }}">All →</a>
            </div>
            <div class="overflow-hidden rounded border border-stone-200 bg-white">
                @forelse ($recentNewsletters as $n)
                    <a href="{{ route('admin.newsletters.show', $n) }}" class="flex items-center justify-between border-b border-stone-100 px-4 py-3 last:border-b-0 hover:bg-stone-50">
                        <span class="truncate">{{ $n->subject }}</span>
                        <span class="ml-4 text-xs uppercase tracking-wide text-stone-500">{{ $n->status }}</span>
                    </a>
                @empty
                    <div class="px-4 py-6 text-sm text-stone-500">No newsletters yet.</div>
                @endforelse
            </div>
        </section>

        <section>
            <div class="mb-3 flex items-baseline justify-between">
                <h2 class="text-lg font-semibold">Recent submissions</h2>
                <a class="text-sm text-stone-600 hover:text-stone-900" href="{{ route('admin.contact-submissions.index') }}">All →</a>
            </div>
            <div class="overflow-hidden rounded border border-stone-200 bg-white">
                @forelse ($recentSubmissions as $s)
                    <a href="{{ route('admin.contact-submissions.show', $s) }}" class="flex items-center justify-between border-b border-stone-100 px-4 py-3 last:border-b-0 hover:bg-stone-50">
                        <span class="truncate">{{ $s->name }} <span class="text-stone-400">— {{ $s->email }}</span></span>
                        <span class="ml-4 whitespace-nowrap text-xs text-stone-500">{{ $s->created_at->diffForHumans() }}</span>
                    </a>
                @empty
                    <div class="px-4 py-6 text-sm text-stone-500">No submissions yet.</div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
