<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title', 'Panel Firmy — Looply')</title>

    <link rel="icon" type="image/png" href="{{ asset('branding/icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('branding/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('branding/icon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { background: #f6f8fc; }

        .sidebar {
            width: 240px;
        }

        .nav-section-title {
            font-size: 11px;
            letter-spacing: .08em;
            font-weight: 600;
            text-transform: uppercase;
            color: #94a3b8;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all .15s ease;
            color: #334155;
            font-weight: 500;
        }

        .nav-link:hover {
            background: #f1f5f9;
        }

        .sidebar-shadow {
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }

        @media (max-width: 768px) {
            aside { display: none; }
        }
    </style>
</head>

<body class="text-slate-800">

@php
$firm = auth()->guard('company')->user();
@endphp

{{-- MOBILE TOP BAR --}}
<div class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b sidebar-shadow">
    <img src="{{ asset('branding/logo.png') }}" class="h-7">
    <button onclick="toggleMenu()" class="text-xl text-slate-700">☰</button>
</div>

{{-- MOBILE MENU --}}
<div id="mobileMenu"
     class="fixed inset-0 bg-black/40 z-50 hidden md:hidden"
     onclick="toggleMenu()">

    <div class="bg-white w-64 h-full p-6 overflow-y-auto"
         onclick="event.stopPropagation()">

        <img src="{{ asset('branding/logo.png') }}" class="h-7 mb-8">

        <nav class="space-y-6 text-sm">

            <div>
                <p class="nav-section-title mb-2">Główne</p>
                <a href="{{ route('company.dashboard') }}" class="nav-link">📊 Dashboard</a>
            </div>

            {{-- PROGRAM LOJALNOŚCIOWY --}}
            @if($firm->has_stickers || $firm->has_points)
            <div>
                <p class="nav-section-title mb-2">Program lojalnościowy</p>
                <div class="space-y-1">

                    @if($firm->has_stickers)
                    <a href="{{ route('company.loyalty.cards') }}" class="nav-link">⭐ Karty</a>
                    <a href="{{ route('company.scan.form') }}" class="nav-link">📷 Skanuj QR</a>
                    @endif

                    @if($firm->has_points)
                    <a href="{{ route('company.points.form') }}" class="nav-link">💎 Punkty</a>
                    <a href="{{ route('company.transactions') }}" class="nav-link">📜 Transakcje</a>
                    @endif

                </div>
            </div>
            @endif

            {{-- KARNETY --}}
            @if($firm->has_passes)
            <div>
                <p class="nav-section-title mb-2">Karnety</p>
                <div class="space-y-1">
                    <a href="{{ route('company.pass_types') }}" class="nav-link">🎫 Typy karnetów</a>
                    <a href="{{ route('company.passes.issue_form') }}" class="nav-link">➕ Wydaj karnet</a>
                    <a href="{{ route('company.passes.index') }}" class="nav-link">📋 Wydane karnety</a>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('company.logout') }}" class="pt-6 border-t">
                @csrf
                <button class="w-full text-left nav-link text-red-600 hover:bg-red-50">
                    🚪 Wyloguj
                </button>
            </form>

        </nav>
    </div>
</div>

<div class="min-h-screen flex">

    {{-- DESKTOP SIDEBAR --}}
    <aside class="hidden md:flex md:flex-col sidebar bg-white border-r sidebar-shadow px-6 py-8">

        <div class="mb-10 flex justify-center">
            <img src="{{ asset('branding/logo.png') }}" class="h-7 object-contain">
        </div>

        <nav class="space-y-6 text-sm flex-1">

            <div>
                <p class="nav-section-title mb-3">Główne</p>
                <a href="{{ route('company.dashboard') }}" class="nav-link">📊 Dashboard</a>
            </div>

            {{-- PROGRAM LOJALNOŚCIOWY --}}
            @if($firm->has_stickers || $firm->has_points)
            <div>
                <p class="nav-section-title mb-3">Program lojalnościowy</p>
                <div class="space-y-1">

                    @if($firm->has_stickers)
                    <a href="{{ route('company.loyalty.cards') }}" class="nav-link">⭐ Karty</a>
                    <a href="{{ route('company.scan.form') }}" class="nav-link">📷 Skanuj QR</a>
                    @endif

                    @if($firm->has_points)
                    <a href="{{ route('company.points.form') }}" class="nav-link">💎 Punkty</a>
                    <a href="{{ route('company.transactions') }}" class="nav-link">📜 Transakcje</a>
                    @endif

                </div>
            </div>
            @endif

            {{-- KARNETY --}}
            @if($firm->has_passes)
            <div>
                <p class="nav-section-title mb-3">Karnety</p>
                <div class="space-y-1">
                    <a href="{{ route('company.pass_types') }}" class="nav-link">🎫 Typy karnetów</a>
                    <a href="{{ route('company.passes.issue_form') }}" class="nav-link">➕ Wydaj karnet</a>
                    <a href="{{ route('company.passes.index') }}" class="nav-link">📋 Wydane karnety</a>
                </div>
            </div>
            @endif

        </nav>

        <form method="POST" action="{{ route('company.logout') }}" class="pt-6 border-t">
            @csrf
            <button class="w-full text-left nav-link text-red-600 hover:bg-red-50">
                🚪 Wyloguj
            </button>
        </form>

    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 px-6 md:px-10 py-8">
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
