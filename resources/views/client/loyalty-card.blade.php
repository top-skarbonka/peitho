<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Karta lojalnościowa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-violet-700 via-fuchsia-600 to-purple-700 flex items-center justify-center px-4 py-10 text-white">

    <div class="w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-6">
            <div class="text-sm opacity-80">Twój portfel</div>
            <div class="text-xl font-bold">{{ $firm->name ?? 'Karta lojalnościowa' }}</div>
        </div>

        {{-- Reward banner --}}
        @if($stamps >= ($program->stamps_required ?? 10))
            <div class="mb-6 rounded-2xl bg-emerald-400/20 border border-emerald-300/40 backdrop-blur px-4 py-4 text-center">
                <div class="text-lg font-bold text-emerald-200">
                    🎉 Nagroda gotowa!
                </div>
                <div class="text-sm text-emerald-100 mt-1">
                    Masz {{ $stamps }} / {{ $program->stamps_required }} naklejek
                </div>
            </div>
        @endif

        {{-- Card container --}}
        <div class="rounded-3xl shadow-2xl overflow-hidden backdrop-blur-xl bg-white/10 border border-white/20">

            <div class="p-6">

                {{-- Progress --}}
                <div class="mb-6">
                    <div class="flex justify-between text-sm mb-2 opacity-90">
                        <span>Postęp</span>
                        <span>{{ $stamps }} / {{ $program->stamps_required ?? 10 }}</span>
                    </div>

                    @php
                        $max = $program->stamps_required ?? 10;
                        $percent = $max > 0 ? min(100, ($stamps / $max) * 100) : 0;
                    @endphp

                    <div class="w-full h-3 bg-white/20 rounded-full overflow-hidden">
                        <div class="h-full bg-white transition-all duration-500"
                             style="width: {{ $percent }}%"></div>
                    </div>
                </div>

                {{-- Template switch (nie ruszamy logiki) --}}
                @switch($firm->card_template)

                    @case('classic')
                        @include('client.cards.classic')
                        @break

                    @case('gold')
                        @include('client.cards.gold')
                        @break

                    @default
                        @include('client.cards.classic')

                @endswitch

            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center text-xs mt-6 opacity-60">
            Powered by Looply
        </div>

    </div>

</body>
</html>
