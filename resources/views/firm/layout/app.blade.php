<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Panel Firmy — Peitho')</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background: #f5f7fb; }
    </style>
</head>
<body class="text-slate-800">

<div class="min-h-screen flex">
    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border-r border-slate-200 px-5 py-6">
        <div class="text-lg font-semibold mb-6">🏢 Panel Firmy</div>

        <nav class="space-y-1 text-sm">
            <a href="/company/dashboard" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                📊 <span>Dashboard</span>
            </a>

            <a href="/company/vouchers" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                🎁 <span>Vouchery</span>
            </a>

            <a href="/company/loyalty-cards" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                ⭐ <span>Karty lojalnościowe</span>
            </a>

            <a href="/company/points" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                💎 <span>Dodaj punkty</span>
            </a>

            <a href="/company/transactions" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                📜 <span>Historia transakcji</span>
            </a>

            <a href="/company/statistics" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                📈 <span>Statystyki</span>
            </a>

            <a href="/company/settings" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                ⚙️ <span>Ustawienia</span>
            </a>

            <div class="pt-3 mt-3 border-t border-slate-200">
                <a href="/company/logout" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-red-50 text-red-600">
                    🚪 <span>Wyloguj</span>
                </a>
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
