@extends('admin.layout', ['title' => 'Contact submissions'])

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Contact submissions</h1>
        <span class="text-sm text-stone-500">{{ $submissions->total() }} total</span>
    </div>

    <div class="overflow-hidden rounded border border-stone-200 bg-white">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-left text-xs uppercase tracking-wide text-stone-500">
                <tr>
                    <th class="px-4 py-3">When</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Company</th>
                    <th class="px-4 py-3">Scope</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $s)
                    <tr class="border-t border-stone-100 hover:bg-stone-50">
                        <td class="px-4 py-3 text-stone-600 whitespace-nowrap">{{ $s->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3"><a href="{{ route('admin.contact-submissions.show', $s) }}" class="font-medium underline-offset-2 hover:underline">{{ $s->name }}</a></td>
                        <td class="px-4 py-3 text-stone-600">{{ $s->email }}</td>
                        <td class="px-4 py-3 text-stone-600">{{ $s->company }}</td>
                        <td class="px-4 py-3 text-stone-600">{{ $s->scope }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-stone-500">No submissions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $submissions->links() }}</div>
@endsection
