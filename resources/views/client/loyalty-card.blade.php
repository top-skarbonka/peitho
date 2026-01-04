<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Karta stałego klienta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(135deg, #4f46e5, #2563eb);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center text-white">

@php
    /** @var \App\Models\LoyaltyCard $card */
    $max = $card->max_stamps ?? 10;
    $current = $card->current_stamps ?? 0;
@endphp

<div class="w-full h-screen flex items-center justify-center px-4">

    <div class="bg-white text-slate-900 rounded-3xl shadow-2xl w-full max-w-sm p-6 flex flex-col justify-between">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-xl font-semibold">⭐ Karta stałego klienta</h1>
            <p class="text-sm text-slate-500 mt-1">
                Zbieraj naklejki i odbierz nagrodę
            </p>
        </div>

        {{-- NAKLEJKI --}}
        <div class="grid grid-cols-5 gap-4 my-8 justify-items-center">
            @for($i = 1; $i <= $max; $i++)
                <div
                    class="w-12 h-12 rounded-full flex items-center justify-center
                    {{ $i <= $current ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-400' }}"
                >
                    @if($i <= $current)
                        ✓
                    @else
                        {{ $i }}
                    @endif
                </div>
            @endfor
        </div>

        {{-- STATUS --}}
        <div class="text-center">
            @if($current >= $max)
                <div class="text-green-600 font-semibold text-lg">
                    🎉 Nagroda gotowa do odbioru!
                </div>
            @else
                <div class="text-slate-600">
                    Pozostało <strong>{{ $max - $current }}</strong> naklejek
                </div>
            @endif
        </div>

        {{-- STOPKA --}}
        <div class="text-center text-xs text-slate-400 mt-6">
            Pokaż tę kartę obsłudze przy każdej wizycie
        </div>

    </div>
</div>

</body>
</html>
