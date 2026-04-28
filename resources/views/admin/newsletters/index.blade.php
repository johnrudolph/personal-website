@extends('admin.layout', ['title' => 'Newsletters'])

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Newsletters</h1>
        <a href="{{ route('admin.newsletters.create') }}" class="rounded bg-stone-900 px-4 py-2 text-sm font-medium text-white hover:bg-stone-700">New newsletter</a>
    </div>

    <div class="overflow-hidden rounded border border-stone-200 bg-white">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-left text-xs uppercase tracking-wide text-stone-500">
                <tr>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Recipients</th>
                    <th class="px-4 py-3">Opens</th>
                    <th class="px-4 py-3">Clicks</th>
                    <th class="px-4 py-3">Bounces</th>
                    <th class="px-4 py-3">Sent</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($newsletters as $n)
                    <tr class="border-t border-stone-100 hover:bg-stone-50">
                        <td class="px-4 py-3"><a href="{{ route('admin.newsletters.show', $n) }}" class="font-medium underline-offset-2 hover:underline">{{ $n->subject }}</a></td>
                        <td class="px-4 py-3">
                            <span @class([
                                'inline-flex rounded px-2 py-0.5 text-xs font-medium',
                                'bg-stone-200 text-stone-700' => $n->status === 'draft',
                                'bg-amber-100 text-amber-800' => $n->status === 'sending',
                                'bg-emerald-100 text-emerald-800' => $n->status === 'sent',
                            ])>{{ $n->status }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $n->recipients_count }}</td>
                        <td class="px-4 py-3">{{ $n->unique_opens_count }}</td>
                        <td class="px-4 py-3">{{ $n->unique_clicks_count }}</td>
                        <td class="px-4 py-3">{{ $n->bounces_count }}</td>
                        <td class="px-4 py-3 text-stone-600">{{ optional($n->sent_at)->format('Y-m-d H:i') ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-stone-500">No newsletters yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $newsletters->links() }}</div>
@endsection
