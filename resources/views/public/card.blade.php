<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Karta lojalnościowa – {{ $firm->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Inter, sans-serif;
            background: radial-gradient(circle at top, #f7f7fb, #eceef7);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 720px;
            background: linear-gradient(135deg, #f4f6ff 0%, #fff8ea 100%);
            border-radius: 26px;
            box-shadow: 0 40px 90px rgba(0,0,0,.15);
            padding: 26px 28px 22px;
        }

        /* ===== HEADER ===== */
        .header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
        }

        .logo {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 20px rgba(0,0,0,.12);
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.1;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
        }

        .divider {
            height: 1px;
            background: rgba(0,0,0,.08);
            margin: 14px 0 18px;
        }

        /* ===== STAMPS ===== */
        .stamps-wrapper {
            display: flex;
            justify-content: center; /* 🔥 TO JEST KLUCZ */
            margin-bottom: 18px;
        }

        .stamps {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }

        .stamp {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background: radial-gradient(circle at top, #f5f6fc, #e8ebf6);
            box-shadow:
                inset 0 2px 6px rgba(255,255,255,.8),
                inset 0 -6px 12px rgba(0,0,0,.05);
        }

        /* ===== FOOTER ===== */
        .footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding-top: 14px;
            border-top: 1px solid rgba(0,0,0,.08);
        }

        .qr-box {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .qr {
            background: #fff;
            padding: 8px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,.18);
        }

        .qr svg {
            width: 88px;
            height: 88px;
            display: block;
        }

        .qr-text {
            font-size: 14px;
            color: #555;
            line-height: 1.4;
        }

        .qr-text strong {
            font-size: 18px;
            color: #222;
        }

        .icons {
            display: flex;
            gap: 16px;
            font-size: 20px;
            opacity: .75;
        }

        @media (max-width: 760px) {
            .card {
                width: 94%;
            }

            .stamp {
                width: 64px;
                height: 64px;
            }
        }
    </style>
</head>
<body>

<div class="card">

    <!-- HEADER -->
    <div class="header">
        <div class="logo">🌸</div>
        <div>
            <div class="title">{{ $firm->name }}</div>
            <div class="subtitle">Karta lojalnościowa • Peitho</div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- STAMPS (WYŚRODKOWANE) -->
    <div class="stamps-wrapper">
        <div class="stamps">
            @for ($i = 1; $i <= 10; $i++)
                <div class="stamp"></div>
            @endfor
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="qr-box">
            <div class="qr">
                {!! $qrSvg !!}
            </div>
            <div class="qr-text">
                Pokaż przy kasie<br>
                <strong>{{ $client->phone }}</strong>
            </div>
        </div>

        <div class="icons">
            📍 ☎️
        </div>
    </div>

</div>

</body>
</html>
