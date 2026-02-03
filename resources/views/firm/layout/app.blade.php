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

{{-- 🔹 MOBILE TOPBAR --}}
<div class="md:hidden fixed top-0 left-0 right-0 z-40 bg-white border-b px-4 py-3 flex items-center justify-between">
    <div class="font-semibold text-lg">🏢 Panel Firmy</div>
    <button onclick="toggleMobileMenu()" class="text-2xl">☰</button>
</div>

{{-- 🔹 MOBILE MENU OVERLAY --}}
<div id="mobileMenuOverlay"
     class="fixed inset-0 bg-black/40 z-40 hidden"
     onclick="toggleMobileMenu()"></div>

{{-- 🔹 MOBILE MENU --}}
<aside id="mobileMenu"
       class="fixed top-0 left-0 h-full w-64 bg-white z-50 transform -translate-x-full transition-transform duration-200 md:hidden px-5 py-6">

    <div class="flex items-center justify-between mb-6">
        <div class="font-semibold text-lg">🏢 Panel Firmy</div>
        <button onclick="toggleMobileMenu()" class="text-xl">✖</button>
    </div>

    <nav class="space-y-1 text-sm">
        <a href="{{ route('company.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">📊 Dashboard</a>
        <a href="{{ route('company.loyalty.cards') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">⭐ Karty klienta</a>
        <a href="{{ route('company.points.form') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">💎 Dodaj punkty</a>
        <a href="{{ route('company.transactions') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">📜 Transakcje</a>
        <a href="/company/change-password" class="block px-3 py-2 rounded-lg hover:bg-slate-100">🔐 Zmień hasło</a>

        <form method="POST" action="{{ route('company.logout') }}" class="pt-3 mt-3 border-t">
            @csrf
            <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-red-50 text-red-600">
                🚪 Wyloguj
            </button>
        </form>
    </nav>
</aside>

<div class="min-h-screen flex pt-14 md:pt-0">

    {{-- 🔹 SIDEBAR DESKTOP --}}
    <aside class="hidden md:block w-64 bg-white border-r border-slate-200 px-5 py-6">
        <div class="text-lg font-semibold mb-6">🏢 Panel Firmy</div>

        <nav class="space-y-1 text-sm">
            <a href="{{ route('company.dashboard') }}" class="flex gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">📊 Dashboard</a>
            <a href="{{ route('company.loyalty.cards') }}" class="flex gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">⭐ Karty stałego klienta</a>
            <a href="{{ route('company.points.form') }}" class="flex gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">💎 Dodaj punkty</a>
            <a href="{{ route('company.transactions') }}" class="flex gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">📜 Historia transakcji</a>
            <a href="/company/change-password" class="flex gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">🔐 Zmień hasło</a>

            <div class="pt-3 mt-3 border-t">
                <form method="POST" action="{{ route('company.logout') }}">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded-lg text-red-600 hover:bg-red-50">
                        🚪 Wyloguj
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    {{-- 🔹 CONTENT --}}
    <main class="flex-1 px-4 md:px-8 py-6 md:py-8">
        @yield('content')
    </main>

</div>

<script>
function toggleMobileMenu() {
    document.getElementById('mobileMenu').classList.toggle('-translate-x-full');
    document.getElementById('mobileMenuOverlay').classList.toggle('hidden');
}
</script>

</body>
</html>
