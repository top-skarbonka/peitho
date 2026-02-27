<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel firmy</title>

    {{-- Tailwind CDN (MVP). Jak będziesz chciał wersję pod Vite/build — zrobimy to później. --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* małe dopieszczenie fontów */
        body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="hidden lg:flex lg:w-72 lg:flex-col bg-white border-r border-slate-200">
            <div class="h-16 flex items-center px-6 border-b border-slate-200">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold">
                        L
                    </div>
                    <div>
                        <div class="text-sm font-semibold leading-5">Looply</div>
                        <div class="text-xs text-slate-500">Panel firmy</div>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">
                <a href="{{ route('company.dashboard') }}"
                   class="group flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100">
                    <span class="text-slate-500 group-hover:text-slate-900">📊</span>
                    <span>Dashboard</span>
                </a>

                <div class="pt-3 pb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Karnety
                </div>

                <a href="{{ route('company.pass_types') }}"
                   class="group flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100">
                    <span class="text-slate-500 group-hover:text-slate-900">🎫</span>
                    <span>Typy karnetów</span>
                </a>

                <a href="{{ route('company.passes.issue_form') }}"
                   class="group flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100">
                    <span class="text-slate-500 group-hover:text-slate-900">➕</span>
                    <span>Wydaj karnet</span>
                </a>

                {{-- Jeśli później dodasz route do listy wydanych karnetów, tu podłączymy --}}
                {{-- <a href="{{ route('company.passes.index') }}" class="...">Lista karnetów</a> --}}

                <div class="pt-3 pb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Karty / QR
                </div>

                <a href="{{ route('company.loyalty.cards') }}"
                   class="group flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100">
                    <span class="text-slate-500 group-hover:text-slate-900">💳</span>
                    <span>Karty stałego klienta</span>
                </a>

                <a href="{{ route('company.scan.form') }}"
                   class="group flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100">
                    <span class="text-slate-500 group-hover:text-slate-900">📷</span>
                    <span>Skan QR</span>
                </a>

                <div class="pt-3 pb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Inne
                </div>

                <a href="{{ route('company.transactions') }}"
                   class="group flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100">
                    <span class="text-slate-500 group-hover:text-slate-900">🧾</span>
                    <span>Transakcje</span>
                </a>

                <a href="{{ route('company.points.form') }}"
                   class="group flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium hover:bg-slate-100">
                    <span class="text-slate-500 group-hover:text-slate-900">⭐</span>
                    <span>Punkty</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-200">
                <form method="POST" action="{{ route('company.logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-xl bg-slate-900 text-white px-4 py-2 text-sm font-semibold hover:bg-slate-800">
                        Wyloguj
                    </button>
                </form>
            </div>
        </aside>

        {{-- Mobile header + content --}}
        <div class="flex-1 flex flex-col">
            {{-- Topbar --}}
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8">
                <div class="flex items-center gap-3">
                    <div class="lg:hidden h-10 w-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold">
                        L
                    </div>
                    <div>
                        <div class="text-sm font-semibold leading-5">Panel firmy</div>
                        <div class="text-xs text-slate-500">Looply</div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500">
                        <span class="inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                        <span>System aktywny</span>
                    </div>
                </div>
            </header>

            {{-- Page --}}
            <main class="flex-1 px-4 lg:px-8 py-6">
                {{-- Flash messages --}}
                @if (session('success'))
                    <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                        <div class="font-semibold">✅ Sukces</div>
                        <div class="text-sm">{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                        <div class="font-semibold">⛔ Błąd</div>
                        <div class="text-sm">{{ session('error') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-amber-900">
                        <div class="font-semibold">⚠️ Popraw dane</div>
                        <ul class="mt-2 list-disc pl-5 text-sm space-y-1">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Content card --}}
                <div class="rounded-2xl bg-white border border-slate-200 shadow-sm">
                    <div class="p-4 lg:p-6">
                        @yield('content')
                    </div>
                </div>

                <div class="mt-6 text-xs text-slate-400">
                    © {{ date('Y') }} Looply • Panel firmy
                </div>
            </main>
        </div>
    </div>
</body>
</html>
