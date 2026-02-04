<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Abonament wygasł — Looply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" href="/branding/icon.png">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">

    <div class="bg-white/95 backdrop-blur-xl shadow-2xl rounded-3xl p-10 max-w-lg w-full text-center">

        {{-- 🔥 DUŻE LOGO --}}
        <img src="/branding/logo.png"
             class="mx-auto mb-8"
             style="height:70px;"
             alt="Looply">

        {{-- ALERT IKONA — POD LOGO --}}
        <div class="flex justify-center mb-6">
            <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center shadow-inner">
                <span class="text-2xl">🔒</span>
            </div>
        </div>

        {{-- TYTUŁ --}}
        <h1 class="text-3xl font-bold text-red-500 mb-4">
            Abonament wygasł
        </h1>

        {{-- OPIS --}}
        <p class="text-slate-600 mb-6 leading-relaxed">
            Twój dostęp do panelu firmy został tymczasowo zablokowany,
            ponieważ nie odnotowaliśmy płatności za abonament.
        </p>

        {{-- BENEFITY --}}
        <div class="bg-slate-50 rounded-2xl p-5 mb-8 text-left">
            <p class="font-semibold mb-3 text-center">
                Po opłaceniu odzyskasz dostęp do:
            </p>

            <ul class="space-y-2 text-slate-700">
                <li>✅ klientów</li>
                <li>✅ kart lojalnościowych</li>
                <li>✅ skanera QR</li>
                <li>✅ statystyk</li>
            </ul>
        </div>

        {{-- CTA --}}
        <a href="#"
           class="block w-full py-4 rounded-xl text-white font-semibold text-lg
                  bg-gradient-to-r from-indigo-500 to-pink-500
                  hover:scale-[1.02] transition shadow-lg">
            Opłać abonament
        </a>

        {{-- STOPKA --}}
        <p class="text-xs text-slate-400 mt-6">
            Masz pytania? Skontaktuj się z administratorem systemu.
        </p>

    </div>

</body>
</html>
