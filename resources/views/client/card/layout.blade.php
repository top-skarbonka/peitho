<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Karta lojalnościowa</title>

    <style>
        body{
            margin:0;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#f2f4f8;
            font-family:system-ui,-apple-system,BlinkMacSystemFont;
        }

        .wrapper{
            width:100%;
            max-width:420px;
            padding:16px;
            display:flex;
            flex-direction:column;
            align-items:center;
        }

        .card{
            width:100%;
            border-radius:22px;
            padding:22px;
            text-align:center;
            box-shadow:0 12px 30px rgba(0,0,0,.12);
        }

        .header{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:12px;
            margin-bottom:14px;
        }

        .avatar{
            width:44px;
            height:44px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:900;
            font-size:20px;
        }

        .stamps{
            display:grid;
            grid-template-columns:repeat(6,1fr);
            gap:14px;
            margin:20px 0;
            justify-items:center;
        }

        .stamp{
            width:100%;
            aspect-ratio:1/1;
            border-radius:50%;
        }

        .qr{
            display:flex;
            justify-content:center;
            margin:18px 0;
        }

        .code{
            font-weight:800;
            letter-spacing:2px;
            font-size:18px;
            margin-top:6px;
        }

        .card-meta{
            margin-top:16px;
            text-align:center;
        }

        .icons{
            display:flex;
            justify-content:center;
            gap:12px;
            margin-top:10px;
        }

        .icon{
            width:38px;
            height:38px;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:800;
            text-decoration:none;
            color:#fff;
        }

        .opinion{
            margin-top:8px;
            font-size:13px;
            opacity:.75;
        }

        .addr{
            font-size:14px;
            margin-top:4px;
            opacity:.8;
        }
    </style>
</head>

<body>

<div class="wrapper">

    {{-- TUTAJ WSTRZYKIWANY JEST KONKRETNY SZABLON --}}
    @yield('card')

    {{-- SEKCJA POD KARTĄ --}}
    <div class="card-meta">

        @if(!empty($address))
            <div class="addr">📍 {{ $address }}</div>
        @endif

        @if(!empty($phone))
            <div class="addr">📞 {{ $phone }}</div>
        @endif

        <div class="icons">
            @if(!empty($facebook))
                <a class="icon" style="background:#1877f2" href="{{ $facebook }}" target="_blank">f</a>
            @endif

            @if(!empty($instagram))
                <a class="icon" style="background:#e1306c" href="{{ $instagram }}" target="_blank">ig</a>
            @endif

            @if(!empty($google))
                <a class="icon" style="background:#fbbc05" href="{{ $google }}" target="_blank">G</a>
            @endif
        </div>

        @if(!empty($google))
            <div class="opinion">⭐ Zostaw nam opinię</div>
        @endif

    </div>

</div>

</body>
</html>
