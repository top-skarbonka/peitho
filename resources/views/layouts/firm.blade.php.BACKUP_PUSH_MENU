<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel firmy</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="hidden lg:flex lg:w-72 lg:flex-col bg-white border-r">
        <div class="h-16 flex items-center px-6 border-b">
            <strong>Looply</strong>
        </div>

        <nav class="p-4 space-y-2">
            <a href="/company/dashboard" class="block px-4 py-2 rounded-lg hover:bg-slate-100">
                📊 Dashboard
            </a>

            <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-100">
                🧾 Transakcje
            </a>
<a href="/company/points" class="block px-4 py-2 rounded-lg hover:bg-slate-100">
    💰 Dodaj punkty
</a>
        </nav>

        <div class="mt-auto p-4">
            <form method="POST" action="/company/logout">
                @csrf
                <button class="w-full bg-slate-900 text-white py-2 rounded-lg">
                    Wyloguj
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="h-16 bg-white border-b flex items-center justify-between px-6">
            <div>
                <h2 class="font-semibold">Panel firmy</h2>
                <p class="text-xs text-slate-500">Looply</p>
            </div>

            <div class="text-sm text-green-600 flex items-center gap-2">
                ● System aktywny
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="p-6">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="text-center text-xs text-slate-400 py-4">
            © {{ date('Y') }} Looply • Panel firmy
        </footer>

    </div>

</div>

</body>
</html>
