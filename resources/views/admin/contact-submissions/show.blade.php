@extends('admin.layout', ['title' => 'Submission'])

@section('content')
    <a href="{{ route('admin.contact-submissions.index') }}" class="text-sm text-stone-600 hover:text-stone-900">← All submissions</a>

    <div class="mt-4 rounded border border-stone-200 bg-white p-6">
        <h1 class="text-xl font-semibold">{{ $submission->name }}</h1>
        <p class="text-sm text-stone-600">
            <a href="mailto:{{ $submission->email }}" class="underline">{{ $submission->email }}</a>
            @if ($submission->company) · {{ $submission->company }} @endif
            @if ($submission->scope) · {{ $submission->scope }} @endif
        </p>
        <p class="mt-1 text-xs text-stone-500">
            {{ $submission->created_at->format('Y-m-d H:i') }} · {{ $submission->ip ?: 'unknown ip' }}
            @if ($submission->subscriber)
                · <a href="{{ route('admin.subscribers.index', ['q' => $submission->subscriber->email]) }}" class="underline">subscribed</a>
            @endif
        </p>

        <div class="mt-6 whitespace-pre-wrap rounded border-l-2 border-stone-300 bg-stone-50 p-4 text-sm text-stone-800">{{ $submission->message }}</div>
    </div>
@endsection
