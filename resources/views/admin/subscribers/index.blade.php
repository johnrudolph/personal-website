@extends('admin.layout', ['title' => 'Subscribers'])

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Subscribers</h1>
        <span class="text-sm text-stone-500">{{ $subscribers->total() }} total</span>
    </div>

    <form method="GET" class="mb-4 flex flex-wrap items-center gap-3">
        <input type="search" name="q" value="{{ $search }}" placeholder="Search email or name…" class="w-64 rounded border-stone-300 text-sm shadow-sm">
        <select name="status" class="rounded border-stone-300 text-sm shadow-sm">
            <option value="">All statuses</option>
            @foreach ($statuses as $s)
                <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded bg-stone-900 px-4 py-1.5 text-sm font-medium text-white hover:bg-stone-700">Filter</button>
        @if ($status || $search)
            <a href="{{ route('admin.subscribers.index') }}" class="text-sm text-stone-600 hover:text-stone-900">Reset</a>
        @endif
    </form>

    <div class="overflow-hidden rounded border border-stone-200 bg-white">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-left text-xs uppercase tracking-wide text-stone-500">
                <tr>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Source</th>
                    <th class="px-4 py-3">Subscribed</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subscribers as $sub)
                    <tr class="border-t border-stone-100">
                        <td class="px-4 py-3">{{ $sub->email }}</td>
                        <td class="px-4 py-3 text-stone-600">{{ $sub->name }}</td>
                        <td class="px-4 py-3">
                            <span @class([
                                'inline-flex rounded px-2 py-0.5 text-xs font-medium',
                                'bg-emerald-100 text-emerald-800' => $sub->status === 'subscribed',
                                'bg-stone-200 text-stone-700' => $sub->status === 'unsubscribed',
                                'bg-amber-100 text-amber-800' => $sub->status === 'bounced',
                                'bg-red-100 text-red-800' => $sub->status === 'complained',
                            ])>{{ $sub->status }}</span>
                        </td>
                        <td class="px-4 py-3 text-stone-600">{{ $sub->source }}</td>
                        <td class="px-4 py-3 text-stone-600">{{ optional($sub->subscribed_at)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.subscribers.update', $sub) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="rounded border-stone-300 text-xs">
                                    @foreach ($statuses as $s)
                                        <option value="{{ $s }}" @selected($sub->status === $s)>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="ml-1 rounded bg-stone-100 px-2 py-1 text-xs hover:bg-stone-200">Save</button>
                            </form>
                            <form method="POST" action="{{ route('admin.subscribers.destroy', $sub) }}" class="inline" onsubmit="return confirm('Delete this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-1 rounded bg-red-50 px-2 py-1 text-xs text-red-700 hover:bg-red-100">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-stone-500">No subscribers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $subscribers->links() }}</div>
@endsection
