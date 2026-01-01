<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Karta lojalnościowa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            background: #f3f4f6;
            font-family: system-ui, sans-serif;
        }

        .screen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 380px;
            background: linear-gradient(135deg, #fff7ed, #fef3c7);
            border-radius: 24px;
            padding: 20px;
            box-shadow: 0 30px 60px rgba(0,0,0,.15);
        }

        .header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .logo {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fde68a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .firm {
            font-weight: 700;
            font-size: 18px;
        }

        .subtitle {
            font-size: 13px;
            opacity: .7;
        }

        .stamps {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin: 20px 0;
        }

        .stamp {
            aspect-ratio: 1/1;
            border-radius: 50%;
            background: #e5e7eb;
            box-shadow: inset 0 4px 8px rgba(0,0,0,.12);
        }

        .stamp.active {
            background: #22c55e;
            box-shadow: 0 6px 14px rgba(34,197,94,.6);
        }

        .footer {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 16px;
        }

        .qr {
            background: #fff;
            padding: 8px;
            border-radius: 12px;
        }

        .number {
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

<div class="screen">
    <div class="card">

        <div class="header">
            <div class="logo">🌸</div>
            <div>
                <div class="firm">{{ $card->firm->name }}</div>
                <div class="subtitle">Karta lojalnościowa – Peitho</div>
            </div>
        </div>

        <div class="stamps">
            @for ($i = 1; $i <= $card->max_stamps; $i++)
                <div class="stamp {{ $i <= $card->current_stamps ? 'active' : '' }}"></div>
            @endfor
        </div>

        <div class="footer">
            <div class="qr">
                {!! QrCode::size(80)->generate($card->qr_code ?? $card->id) !!}
            </div>
            <div>
                <div class="subtitle">Pokaż przy kasie</div>
                <div class="number">{{ str_pad($card->id, 8, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
