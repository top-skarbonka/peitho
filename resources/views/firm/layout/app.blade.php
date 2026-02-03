<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Panel Firmy — Peitho')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background: #f5f7fb; }

        @media (max-width: 768px) {
            aside { display: none; }
        }
    </style>
</head>

<body class="text-slate-800">

{{-- MOBILE TOP BAR --}}
<div class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b">
    <div class="font-bold">🏢 Panel Firmy</div>
    <button onclick="toggleMenu()" class="text-2xl">☰</button>
</div>

{{-- MOBILE MENU --}}
<div id="mobileMenu"
     class="fixed inset-0 bg-black/40 z-50 hidden md:hidden"
     onclick="toggleMenu()">
    <div class="bg-white w-64 h-full p-5" onclick="event.stopPropagation()">

        <div class="text-lg font-bold mb-6">🏢 Menu</div>

        <nav class="space-y-2 text-sm">
            <a href="{{ route('company.dashboard') }}" class="block px-3 py-2 rounded hover:bg-slate-100">📊 Dashboard</a>
            <a href="{{ route('company.loyalty.cards') }}" class="block px-3 py-2 rounded hover:bg-slate-100">⭐ Karty</a>
            <a href="{{ route('company.scan.form') }}" class="block px-3 py-2 rounded hover:bg-slate-100">📷 Skanuj QR</a>
            <a href="{{ route('company.points.form') }}" class="block px-3 py-2 rounded hover:bg-slate-100">💎 Punkty</a>
            <a href="{{ route('company.transactions') }}" class="block px-3 py-2 rounded hover:bg-slate-100">📜 Transakcje</a>

            <form method="POST" action="{{ route('company.logout') }}" class="pt-3 mt-3 border-t">
                @csrf
                <button class="w-full text-left px-3 py-2 rounded text-red-600 hover:bg-red-50">
                    🚪 Wyloguj
                </button>
            </form>
        </nav>
    </div>
</div>

<div class="min-h-screen flex">

    {{-- DESKTOP SIDEBAR --}}
    <aside class="hidden md:block w-64 bg-white border-r px-5 py-6">
        <div class="text-lg font-semibold mb-6">🏢 Panel Firmy</div>

        <nav class="space-y-1 text-sm">
            <a href="{{ route('company.dashboard') }}" class="block px-3 py-2 rounded hover:bg-slate-100">📊 Dashboard</a>
            <a href="{{ route('company.loyalty.cards') }}" class="block px-3 py-2 rounded hover:bg-slate-100">⭐ Karty</a>
            <a href="{{ route('company.scan.form') }}" class="block px-3 py-2 rounded hover:bg-slate-100">📷 Skanuj QR</a>
            <a href="{{ route('company.points.form') }}" class="block px-3 py-2 rounded hover:bg-slate-100">💎 Punkty</a>
            <a href="{{ route('company.transactions') }}" class="block px-3 py-2 rounded hover:bg-slate-100">📜 Transakcje</a>

            <form method="POST" action="{{ route('company.logout') }}" class="pt-3 mt-3 border-t">
                @csrf
                <button class="w-full text-left px-3 py-2 rounded text-red-600 hover:bg-red-50">
                    🚪 Wyloguj
                </button>
            </form>
        </nav>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 px-4 md:px-8 py-6">
        @yield('content')
    </main>

</div>

<script>
function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('hidden');
}
</script>

</body>
</html>
