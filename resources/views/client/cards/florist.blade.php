<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">

<title>{{ $firm->name ?? 'Karta lojalnościowa' }} – Looply</title>

<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<!-- ===== FAVICON ===== -->
<link rel="icon" type="image/png" href="/favicon.png">
<link rel="shortcut icon" href="/favicon.png">

<!-- ===== PWA ===== -->
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#f472b6">

<!-- ===== iOS ADD TO HOME ===== -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ $firm->name ?? 'Looply' }}">
<link rel="apple-touch-icon" href="/icons/icon-192.png">

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(180deg,#fbcfe8 0%,#f9a8d4 50%,#f472b6 100%);
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding:20px 16px 40px;
}

.container{
    width:100%;
    max-width:400px;
}

/* ===== LOGO ===== */
.logo-section{
    width:100%;
    background:rgba(255,255,255,.35);
    border-radius:28px;
    padding:18px;
    margin-bottom:12px;
    display:flex;
    justify-content:center;
}

.logo-section img{
    max-width:100%;
    max-height:90px;
    object-fit:contain;
}

/* ===== CARD ===== */
.card{
    background:#fff;
    border-radius:32px;
    padding:28px 20px;
    box-shadow:0 25px 60px rgba(0,0,0,.25);
    margin-bottom:16px;
    text-align:center;
}

.subtitle{
    color:#888;
    font-size:.9rem;
    margin:6px 0 18px;
    border-bottom:1px solid #eee;
    padding-bottom:16px;
}

/* ===== STEMPLE ===== */
.stickers-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:12px;
    margin:0 auto 18px;
}

.sticker{
    font-size:30px;
    opacity:.25;
}
.sticker.active{
    opacity:1;
    filter:drop-shadow(0 0 6px rgba(236,72,153,.6));
}

/* ===== QR ===== */
.qr-section svg{
    width:150px;
    height:150px;
}
.code-number{
    font-size:1.6rem;
    font-weight:800;
    letter-spacing:2px;
    margin-top:6px;
}

/* ===== GLASS BOX ===== */
.glass-box{
    background:rgba(255,255,255,.22);
    backdrop-filter:blur(10px);
    border-radius:26px;
    padding:16px;
    color:#fff;
    margin-bottom:14px;
}

/* ===== ACCORDION ===== */
details summary{
    cursor:pointer;
    font-weight:700;
    list-style:none;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
}

details summary::before{
    content:"▶";
    transition:.2s;
}

details[open] summary::before{
    transform:rotate(90deg);
}

details summary::-webkit-details-marker{
    display:none;
}

details > div{
    text-align:center;
    margin-top:12px;
    font-size:.9rem;
    line-height:1.5;
}
</style>
</head>

<body>
<div class="container">

<!-- LOGO -->
<div class="logo-section">
    @if($firm->logo_path)
        <img src="{{ asset('storage/'.$firm->logo_path) }}" alt="{{ $firm->name }}">
    @else
        <span style="font-size:48px">💐</span>
    @endif
</div>

<!-- KARTA -->
<div class="card">
    <h1>{{ $firm->name }}</h1>
    <div class="subtitle">Karta lojalnościowa kwiaciarni</div>

    <div class="stickers-grid">
        @for($i=1;$i<=$maxStamps;$i++)
            <div class="sticker {{ $i <= $current ? 'active' : '' }}">💐</div>
        @endfor
    </div>

    <div class="qr-section">
        {!! $qr !!}
        <div class="code-number">{{ $displayCode }}</div>
    </div>
</div>

<!-- ⭐ OPINIE GOOGLE (UJEDNOLICONY BOX) -->
@if($firm->google_url)
<div class="glass-box">
<details>
<summary>⭐ Opinie Google</summary>
<div>
Sprawdź lub dodaj opinię o <strong>{{ $firm->name }}</strong><br><br>

<a href="{{ $firm->google_url }}"
   target="_blank"
   rel="noopener"
   style="
       display:inline-block;
       padding:10px 18px;
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

<!-- POSTĘP -->
<div class="glass-box">
<details open>
<summary>📊 Postęp karty</summary>
<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} bukietów
</div>
</details>
</div>

<!-- ZGODY -->
<div class="glass-box">
<details>
<summary>🔔 Zgody marketingowe i RODO</summary>
<div>
@if($client->sms_marketing_consent)
✅ Zgoda na SMS marketing<br>
<small>{{ $client->sms_marketing_consent_at?->format('d.m.Y H:i') }}</small>
@else
❌ Brak zgody na SMS marketing
@endif

<hr style="margin:12px 0;opacity:.3;">

Regulamin i polityka prywatności<br>
<small>{{ $client->terms_accepted_at?->format('d.m.Y H:i') }}</small>
</div>
</details>
</div>

</div>
</body>
</html>
