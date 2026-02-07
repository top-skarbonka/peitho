<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<title>{{ $firm->name }} – karta lojalnościowa</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;}

body{
    min-height:100vh;
    background:linear-gradient(180deg,#6f47ff 0%,#9b5cff 55%,#ff7aa2 100%);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:16px;
}

.container{width:100%;max-width:400px;text-align:center;}

.card{
    background:#fff;
    border-radius:32px;
    padding:28px 20px;
    box-shadow:0 25px 60px rgba(0,0,0,.25);
    margin-bottom:16px;
}

.icon-box{
    width:54px;height:54px;border-radius:18px;
    background:#f3efff;display:flex;
    justify-content:center;align-items:center;
    margin:0 auto 14px;font-size:26px;
}

.subtitle{
    color:#888;font-size:.9rem;
    margin:6px 0 20px;
    border-bottom:1px solid #eee;
    padding-bottom:18px;
}

/* ===== GWIAZDKI ===== */
.stickers-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:14px;
    max-width:320px;
    margin:0 auto 18px;
    padding-bottom:18px;
    border-bottom:1px solid #eee;
}

.sticker{
    font-size:34px;
    color:#d1d5db;
    opacity:.4;
    transform:scale(.8);
}

.sticker.active{
    color:#facc15;
    opacity:1;
    transform:scale(1);
    text-shadow:0 0 10px rgba(250,204,21,.6);
}

/* ===== QR ===== */
.qr-section svg{width:150px;height:150px;}
.code-number{font-size:1.7rem;font-weight:800;letter-spacing:2px;color:#222;margin-top:6px;}

/* ===== GLASS ===== */
.glass-box{
    background:rgba(255,255,255,.18);
    backdrop-filter:blur(10px);
    border-radius:26px;
    padding:18px 16px;
    color:#fff;
    margin-bottom:16px;
}

.progress-bar{
    height:10px;
    background:rgba(255,255,255,.3);
    border-radius:999px;
    overflow:hidden;
    margin-top:10px;
}
.progress-fill{
    height:100%;
    background:linear-gradient(90deg,#22c55e,#4ade80);
}
details summary{cursor:pointer;font-weight:600;}
</style>
</head>

<body>
<div class="container">

<div class="card">
    <div class="icon-box">🎁</div>
    <h1>{{ $firm->name }}</h1>
    <div class="subtitle">Twoja karta lojalnościowa</div>

    {{-- ⭐ GWIAZDKI --}}
    <div class="stickers-grid">
        @for($i=1;$i<=$maxStamps;$i++)
            <div class="sticker {{ $i <= $current ? 'active' : '' }}">★</div>
        @endfor
    </div>

    <div class="qr-section">
        {!! $qr !!}
        <div class="code-number">{{ $displayCode }}</div>
    </div>
</div>

{{-- ⭐ OPINIE GOOGLE --}}
@if($firm->google_url)
<div class="glass-box">
    <details>
        <summary>⭐ Opinie Google</summary>
        <div style="margin-top:12px;font-size:.95rem;line-height:1.5;">
            Sprawdź lub dodaj opinię o <strong>{{ $firm->name }}</strong><br><br>

            <a href="{{ $firm->google_url }}"
               target="_blank"
               rel="noopener"
               style="
                   display:inline-block;
                   padding:10px 20px;
                   border-radius:999px;
                   background:#fbbc05;
                   color:#000;
                   font-weight:700;
                   text-decoration:none;
               ">
                ⭐ Zobacz / dodaj opinię
            </a>
        </div>
    </details>
</div>
@endif

{{-- POSTĘP --}}
<div class="glass-box">
    🎯 Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} gwiazdek
    <div class="progress-bar">
        <div class="progress-fill" style="width:{{ ($current/$maxStamps)*100 }}%"></div>
    </div>
</div>

{{-- HISTORIA --}}
@if($card->stamps->count())
<div class="glass-box">
    <details>
        <summary>📊 Ostatnie wizyty</summary>
        <div style="margin-top:10px;font-size:.9rem;">
            @foreach($card->stamps->sortByDesc('created_at')->take(3) as $stamp)
                ✔ {{ $stamp->created_at->format('d.m.Y H:i') }}<br>
            @endforeach
        </div>
    </details>
</div>
@endif

{{-- ZGODY --}}
<div class="glass-box">
    <details>
        <summary>🔔 Zgody marketingowe i RODO</summary>

        <div style="margin-top:12px;font-size:.9rem;line-height:1.5;">

            @if($client->sms_marketing_consent)
                <div>
                    ✅ <strong>Zgoda na SMS marketing</strong><br>
                    <small>
                        Wyrażona: {{ $client->sms_marketing_consent_at->format('d.m.Y H:i') }}
                    </small>
                </div>
            @else
                <div>❌ Brak zgody na SMS marketing</div>
            @endif

            <hr style="margin:12px 0;opacity:.3;">

            <div>
                📄 <strong>Regulamin i polityka prywatności</strong><br>
                <small>
                    Zaakceptowane: {{ $client->terms_accepted_at->format('d.m.Y H:i') }}
                </small>
            </div>

            <hr style="margin:12px 0;opacity:.3;">

            <div style="font-size:.85rem;opacity:.9;">
                🔐 <strong>Cofnięcie zgód</strong><br>
                W każdej chwili możesz cofnąć udzielone zgody,
                wysyłając wiadomość e-mail na adres:<br>

                <a href="mailto:zgody@looply.net.pl"
                   style="color:#fff;font-weight:600;text-decoration:underline;">
                    zgody@looply.net.pl
                </a>

                <div style="margin-top:6px;opacity:.8;">
                    Cofnięcie zgody nie wpływa na zgodność
                    z wcześniej wykonanym przetwarzaniem danych.
                </div>
            </div>

        </div>
    </details>
</div>

</div>
</body>
</html>
