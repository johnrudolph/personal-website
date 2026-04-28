<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} — JRD</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-stone-50 text-stone-900 antialiased">
    <div class="min-h-screen">
        <header class="border-b border-stone-200 bg-white">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold tracking-wide uppercase">JRD Admin</a>
                <nav class="flex items-center gap-6 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'font-semibold' : 'text-stone-600 hover:text-stone-900' }}">Dashboard</a>
                    <a href="{{ route('admin.newsletters.index') }}" class="{{ request()->routeIs('admin.newsletters.*') ? 'font-semibold' : 'text-stone-600 hover:text-stone-900' }}">Newsletters</a>
                    <a href="{{ route('admin.subscribers.index') }}" class="{{ request()->routeIs('admin.subscribers.*') ? 'font-semibold' : 'text-stone-600 hover:text-stone-900' }}">Subscribers</a>
                    <a href="{{ route('admin.contact-submissions.index') }}" class="{{ request()->routeIs('admin.contact-submissions.*') ? 'font-semibold' : 'text-stone-600 hover:text-stone-900' }}">Submissions</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-stone-600 hover:text-stone-900">Logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-6 py-8">
            @if (session('status'))
                <div class="mb-6 rounded border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm text-emerald-900">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded border border-red-300 bg-red-50 px-4 py-2 text-sm text-red-900">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</body>
</html>
