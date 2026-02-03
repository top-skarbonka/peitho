<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Peitho Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f5f3ff, #fafafa);
        }
    </style>
</head>
<body class="text-slate-800">

<div class="min-h-screen flex">

    {{-- SIDEBAR ADMIN --}}
    <aside class="w-64 bg-slate-900 text-white px-5 py-6">
        <div class="text-lg font-semibold mb-6">🛠️ Peitho Admin</div>

        <nav class="space-y-2 text-sm">

            <a href="{{ route('admin.dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-slate-800">
                📊 Dashboard
            </a>

            <a href="{{ route('admin.firms.index') }}"
               class="block px-3 py-2 rounded hover:bg-slate-800">
                🏢 Firmy
            </a>

            <div class="pt-4 mt-4 border-t border-slate-700">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-3 py-2 rounded hover:bg-red-600">
                        🚪 Wyloguj
                    </button>
                </form>
            </div>

        </nav>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 px-8 py-8">
        @yield('content')
    </main>

</div>

</body>
</html>
