@extends('admin.layout', ['title' => $newsletter->exists ? 'Edit newsletter' : 'New newsletter'])

@section('content')
    <h1 class="mb-6 text-2xl font-semibold">{{ $newsletter->exists ? 'Edit newsletter' : 'New newsletter' }}</h1>

    <form method="POST" action="{{ $newsletter->exists ? route('admin.newsletters.update', $newsletter) : route('admin.newsletters.store') }}" class="space-y-4">
        @csrf
        @if ($newsletter->exists)
            @method('PATCH')
        @endif

        <div>
            <label class="block text-sm font-medium text-stone-700">Subject</label>
            <input type="text" name="subject" value="{{ old('subject', $newsletter->subject) }}" required class="mt-1 block w-full rounded border-stone-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700">HTML body</label>
            <textarea name="html" rows="18" required class="mt-1 block w-full rounded border-stone-300 font-mono text-sm shadow-sm" placeholder="<p>Hello there…</p>">{{ old('html', $newsletter->html) }}</textarea>
            <p class="mt-1 text-xs text-stone-500">Plain HTML. The wrapper, footer, and unsubscribe link are added automatically.</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded bg-stone-900 px-4 py-2 text-sm font-medium text-white hover:bg-stone-700">Save</button>
            @if ($newsletter->exists)
                <a href="{{ route('admin.newsletters.show', $newsletter) }}" class="text-sm text-stone-600 hover:text-stone-900">Cancel</a>
            @else
                <a href="{{ route('admin.newsletters.index') }}" class="text-sm text-stone-600 hover:text-stone-900">Cancel</a>
            @endif
        </div>
    </form>
@endsection
