<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Karta lojalnościowa</title>

    <style>
        :root{
            --bg: #eef2f7;
            --cardRadius: 28px;
            --shadow: 0 30px 80px rgba(0,0,0,.18);
            --softShadow: 0 16px 40px rgba(0,0,0,.12);

            /* gradient jak we wzorze */
            --g1: #f2eaf4;
            --g2: #f8efdd;
            --g3: #fbf6e8;

            --line: rgba(20, 20, 20, .10);

            --text: #111;
            --muted: rgba(17,17,17,.62);

            --stampFill: rgba(255,255,255,.78);
            --stampEmpty: rgba(255,255,255,.45);
            --stampShadow: inset 0 3px 10px rgba(0,0,0,.10);

            --footerBg: rgba(255,255,255,.45);
            --footerLine: rgba(20,20,20,.08);
        }

        *{box-sizing:border-box}
        body{
            margin:0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
            background: radial-gradient(1200px 600px at 50% 40%, rgba(0,0,0,.08), transparent 55%),
                        linear-gradient(#f3f6fb, #edf2f7);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding: 28px 18px;
        }

        /* KARTA – proporcje “bankowe” na desktop */
        .wrap{
            width:min(780px, 96vw);
            display:flex;
            justify-content:center;
        }
        .card{
            position:relative;
            width: min(720px, 96vw);
            aspect-ratio: 1.65 / 1; /* bardzo blisko karty płatniczej w odbiorze */
            border-radius: var(--cardRadius);
            overflow:hidden;
            box-shadow: var(--shadow);
            background: linear-gradient(120deg, var(--g1) 0%, var(--g2) 55%, var(--g3) 100%);
        }

        .inner{padding: 28px 30px 0 30px;}
        .top{
            display:flex;
            gap:14px;
            align-items:center;
        }
        .logo{
            width:44px;height:44px;
            border-radius:999px;
            background: #f3df5a;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow: 0 10px 25px rgba(0,0,0,.14);
            flex:0 0 auto;
        }
        .logo span{font-size:18px}
        .title{
            display:flex;
            flex-direction:column;
            line-height:1.05;
        }
        .title .name{
            font-weight:800;
            font-size:28px;
            color:var(--text);
            letter-spacing:.2px;
        }
        .title .sub{
            margin-top:4px;
            font-size:14px;
            color:var(--muted);
        }

        .hr{
            margin:18px 0 18px;
            height:1px;
            background: var(--line);
        }

        /* STEMPle – 12 okienek jak we wzorze (2 rzędy po 6) */
        .stamps{
            display:grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 18px 22px;
            padding: 2px 6px 18px;
        }
        .stamp{
            width:100%;
            aspect-ratio: 1 / 1;
            border-radius:999px;
            background: var(--stampEmpty);
            box-shadow: var(--stampShadow);
            position:relative;
            overflow:hidden;
        }
        .stamp.filled{
            background: var(--stampFill);
        }

        /* subtelny “wow” – następna naklejka oddycha */
        .stamp.next{
            background: var(--stampFill);
            animation: pulse 1.8s ease-in-out infinite;
        }
        @keyframes pulse{
            0%,100%{ transform: scale(1); filter: brightness(1); }
            50%{ transform: scale(1.04); filter: brightness(1.06); }
        }

        /* DOLNA SEKCJA – odcięta kolorystycznie + kreska (jak we wzorze) */
        .footer{
            border-top: 1px solid var(--footerLine);
            background: linear-gradient(180deg, rgba(255,255,255,.35), rgba(255,255,255,.55));
            padding: 18px 22px;
            display:flex;
            justify-content:space-between;
            align-items:flex-end;
            gap:18px;
        }

        .qrbox{
            display:flex;
            gap:14px;
            align-items:flex-end;
            min-width: 280px;
        }
        .qrSquare{
            width: 126px;
            height: 106px;
            border-radius: 14px;
            background: rgba(255,255,255,.88);
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow: 0 14px 30px rgba(0,0,0,.12);
            overflow:hidden;
        }
        .qrSquare svg{
            width: 84%;
            height: 84%;
            display:block;
        }
        .codeBlock{
            display:flex;
            flex-direction:column;
            gap:6px;
            padding-bottom:4px;
        }
        .codeBlock .label{
            font-size:14px;
            color:var(--muted);
        }
        .codeBlock .code{
            font-weight:900;
            letter-spacing:3px;
            font-size:28px;
            color:var(--text);
        }

        .contact{
            margin-left:auto;
            text-align:right;
            display:flex;
            flex-direction:column;
            gap:8px;
            min-width: 240px;
        }
        .lineItem{
            display:flex;
            justify-content:flex-end;
            gap:8px;
            font-size:14px;
            color:rgba(17,17,17,.75);
            align-items:center;
        }
        .lineItem .ico{opacity:.85}
        .social{
            display:flex;
            justify-content:flex-end;
            gap:10px;
        }

        /* kolorowe ikonki jak na wzorze */
        .sbtn{
            width:30px;height:30px;
            border-radius:10px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:800;
            color:white;
            box-shadow: 0 10px 18px rgba(0,0,0,.14);
            user-select:none;
        }
        .fb{ background:#1877F2; }
        .ig{ background: radial-gradient(circle at 30% 110%, #fdf497 0%, #fdf497 5%, #fd5949 35%, #d6249f 60%, #285AEB 90%); }
        .g { background:#F4B400; color:#111; }

        .review{
            font-size:12px;
            color: rgba(17,17,17,.65);
        }

        /* MOBILE FULLSCREEN (pion) – “wallet mode” */
        @media (max-width: 640px) and (orientation: portrait){
            body{
                padding: 0;
                align-items:stretch;
                justify-content:stretch;
            }
            .wrap{
                width:100vw;
                height:100dvh;
                padding: 14px 14px calc(14px + env(safe-area-inset-bottom));
                display:flex;
                align-items:center;
                justify-content:center;
            }
            .card{
                width:100%;
                height:100%;
                aspect-ratio: auto;
                border-radius: 26px;
                display:flex;
                flex-direction:column;
            }
            .inner{
                padding: 22px 20px 0 20px;
            }
            .title .name{font-size:24px}
            .stamps{
                gap: 14px 14px;
                padding: 0 2px 14px;
            }
            .footer{
                margin-top:auto;
                padding: 16px 16px;
                align-items:flex-end;
            }
            .qrbox{min-width:auto}
            .qrSquare{
                width: 120px;
                height: 104px;
            }
            .codeBlock .code{
                font-size:24px;
                letter-spacing:2.5px;
            }
            .contact{min-width:auto}
        }
    </style>
</head>
<body>
    @php
        $firm = $card->firm ?? null;

        $firmName = $firm->name ?? 'Firma';
        $address  = $firm->address ?? null;
        $phone    = $firm->phone ?? null;

        // opcjonalne linki (jeśli masz w DB)
        $facebook = $firm->facebook_url ?? null;
        $instagram = $firm->instagram_url ?? null;
        $google = $firm->google_url ?? null;

        $filled = (int) ($current ?? 0);
        $max = (int) ($maxStamps ?? 12);
        if ($filled < 0) $filled = 0;
        if ($filled > $max) $filled = $max;

        // “następna” do efektu wow
        $nextIndex = $filled + 1;
    @endphp

    <div class="wrap">
        <div class="card" role="img" aria-label="Karta lojalnościowa">
            <div class="inner">
                <div class="top">
                    <div class="logo"><span>🌸</span></div>
                    <div class="title">
                        <div class="name">{{ $firmName }}</div>
                        <div class="sub">Karta lojalnościowa – Peitho</div>
                    </div>
                </div>

                <div class="hr"></div>

                <div class="stamps" aria-label="Postęp naklejek">
                    @for ($i = 1; $i <= $max; $i++)
                        @php
                            $cls = 'stamp';
                            if ($i <= $filled) $cls .= ' filled';
                            if ($i === $nextIndex && $filled < $max) $cls .= ' next';
                        @endphp
                        <div class="{{ $cls }}"></div>
                    @endfor
                </div>
            </div>

            <div class="footer">
                <div class="qrbox">
                    <div class="qrSquare">
                        {!! $qr !!}
                    </div>
                    <div class="codeBlock">
                        <div class="label">Pokaż przy kasie</div>
                        <div class="code">{{ $displayCode ?? '00000000' }}</div>
                    </div>
                </div>

                <div class="contact">
                    @if($address)
                        <div class="lineItem"><span class="ico">📍</span><span>{{ $address }}</span></div>
                    @endif
                    @if($phone)
                        <div class="lineItem"><span class="ico">📞</span><span>{{ $phone }}</span></div>
                    @endif

                    <div class="social" aria-label="Social media">
                        @if($facebook)
                            <a class="sbtn fb" href="{{ $facebook }}" target="_blank" rel="noopener">f</a>
                        @else
                            <div class="sbtn fb">f</div>
                        @endif

                        @if($instagram)
                            <a class="sbtn ig" href="{{ $instagram }}" target="_blank" rel="noopener">ig</a>
                        @else
                            <div class="sbtn ig">ig</div>
                        @endif

                        @if($google)
                            <a class="sbtn g" href="{{ $google }}" target="_blank" rel="noopener">G</a>
                        @else
                            <div class="sbtn g">G</div>
                        @endif
                    </div>

                    <div class="review">Zostaw nam opinię</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
