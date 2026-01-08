k<!DOCTYPE html>
<div style="background:red;color:white;padding:10px;">
    TEMPLATE: {{ $firm->card_template ?? 'BRAK' }}
</div>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Karta lojalnościowa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="
    margin:0;
    min-height:100vh;
    background:linear-gradient(180deg,#6a00ff,#b832a6);
    font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,sans-serif;
">

{{-- KOMUNIKAT NAGRODY --}}
@if($stamps >= ($program->stamps_required ?? 10))
    <div style="
        text-align:center;
        color:#00ff88;
        font-weight:700;
        padding:16px 0;
        font-size:18px;
    ">
        🎉 Masz {{ $stamps }} z {{ $program->stamps_required }} naklejek<br>
        Nagroda gotowa do odbioru!
    </div>
@endif

{{-- WYBÓR SZABLONU --}}
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

</body>
</html>
