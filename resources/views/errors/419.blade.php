<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesja wygasła — Looply</title>

    <link rel="icon" type="image/png" href="{{ asset('branding/icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(135deg, #6366f1, #a855f7);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn .6s ease-out;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center text-white">

@php
    $path = request()->path();

    if (str_starts_with($path, 'admin')) {
        $loginRoute = route('admin.login');
    } elseif (str_starts_with($path, 'company')) {
        $loginRoute = route('company.login');
    } elseif (str_starts_with($path, 'client')) {
        $loginRoute = route('client.login');
    } else {
        $loginRoute = route('company.login');
    }
@endphp

<div class="bg-white/10 backdrop-blur-xl rounded-2xl p-10 text-center shadow-2xl max-w-md w-full fade-in">

    <div class="text-5xl mb-4 animate-pulse">⏳</div>

    <h1 class="text-2xl font-bold mb-3">
        Sesja wygasła
    </h1>

    <p class="text-white/80 mb-6">
        Zrobiliśmy krótką przerwę bezpieczeństwa 🔐<br>
        Za chwilę wracamy do panelu logowania…
    </p>

    <a href="{{ $loginRoute }}"
       class="inline-block bg-white text-indigo-600 font-semibold px-6 py-3 rounded-xl shadow hover:scale-105 transition">
        🔁 Zaloguj się teraz
    </a>

    <div class="mt-6 text-sm text-white/60">
        Automatyczne przekierowanie za <span id="countdown">3</span> sekundy…
    </div>

</div>

<script>
    let seconds = 3;
    const countdown = document.getElementById('countdown');

    const timer = setInterval(() => {
        seconds--;
        countdown.innerText = seconds;

        if (seconds <= 0) {
            clearInterval(timer);
            window.location.href = "{{ $loginRoute }}";
        }
    }, 1000);
</script>

</body>
</html>
