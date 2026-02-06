<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ $firm->name ?? 'Karta lojalnościowa' }}</title>

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(180deg,#8b0000 0%,#b11212 50%,#6f0000 100%);
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding:20px 16px 40px;
}

.container{
    width:100%;
    max-width:400px;
}

/* LOGO */
.logo-section{
    background:rgba(255,255,255,.25);
    border-radius:28px;
    padding:18px;
    margin-bottom:12px;
    display:flex;
    justify-content:center;
}

.logo-section img{
    max-height:90px;
}

/* CARD */
.card{
    background:#fff;
    border-radius:32px;
    padding:28px 20px;
    box-shadow:0 25px 60px rgba(0,0,0,.35);
    margin-bottom:16px;
    text-align:center;
}

.subtitle{
    color:#777;
    font-size:.9rem;
    margin:6px 0 18px;
    border-bottom:1px solid #eee;
    padding-bottom:16px;
}

/* STICKERS */
.stickers-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:12px;
    margin-bottom:18px;
}

.sticker{
    font-size:30px;
    opacity:.25;
}

.sticker.active{
    opacity:1;
    filter:drop-shadow(0 0 6px rgba(255,90,90,.6));
}

/* QR */
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

/* GLASS BOX */
.glass-box{
    background:rgba(255,255,255,.35);
    backdrop-filter:blur(10px);
    border-radius:26px;
    padding:16px;
    color:#111;
    margin-bottom:14px;
}

/* ACCORDION */
details summary{
    cursor:pointer;
    font-weight:700;
    list-style:none;
    display:flex;
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
    margin-top:12px;
    font-size:.9rem;
    line-height:1.5;
    text-align:center;
}

/* PROGRESS */
.progress-bar{
    height:10px;
    background:rgba(255,255,255,.5);
    border-radius:999px;
    overflow:hidden;
    margin-top:10px;
}

.progress-fill{
    height:100%;
    background:linear-gradient(90deg,#ffb347,#ff5f00);
}

/* SOCIAL */
.social-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    margin-top:12px;
}

.social-btn{
    background:#fff;
    color:#111;
    padding:10px;
    border-radius:999px;
    font-weight:600;
    text-decoration:none;
}
</style>
</head>

<body>
<div class="container">

{{-- LOGO --}}
<div class="logo-section">
@if($firm->logo_path)
<img src="{{ asset('storage/'.$firm->logo_path) }}" alt="{{ $firm->name }}">
@else
<span style="font-size:48px">🍕</span>
@endif
</div>

{{-- CARD --}}
<div class="card">
<h1>{{ $firm->name }}</h1>
<div class="subtitle">Karta lojalnościowa pizzerii</div>

<div class="stickers-grid">
@for($i=1;$i<=$maxStamps;$i++)
<div class="sticker {{ $i <= $current ? 'active' : '' }}">🍕</div>
@endfor
</div>

<div class="qr-section">
{!! $qr !!}
<div class="code-number">{{ $displayCode }}</div>
</div>
</div>

{{-- NAGRODA --}}
<div class="glass-box">
<details open>
<summary>🎁 Nagroda</summary>
<div>
<strong>{{ $maxStamps }} zamówień</strong> = 🍕 <strong>Pizza gratis</strong><br>
<small>Warunki nagrody ustala pizzeria.</small>
</div>
</details>
</div>

{{-- POSTĘP --}}
<div class="glass-box">
<details>
<summary>📊 Postęp</summary>
<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} zamówień
<div class="progress-bar">
<div class="progress-fill" style="width:{{ ($current/$maxStamps)*100 }}%"></div>
</div>
</div>
</details>
</div>

{{-- KONTAKT --}}
<div class="glass-box">
<details>
<summary>📞 Kontakt i social media</summary>
<div>
📞 {{ $firm->phone }}<br>
📍 {{ $firm->address }}

<div class="social-grid">
@if($firm->facebook_url)
<a class="social-btn" href="{{ $firm->facebook_url }}" target="_blank">Facebook</a>
@endif
@if($firm->instagram_url)
<a class="social-btn" href="{{ $firm->instagram_url }}" target="_blank">Instagram</a>
@endif
@if($firm->google_url)
<a class="social-btn" href="{{ $firm->google_url }}" target="_blank">Google</a>
@endif
</div>
</div>
</details>
</div>

{{-- ZGODY --}}
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

<hr style="margin:12px 0;opacity:.3;">

Cofnięcie zgód:  
<a href="mailto:zgody@looply.net.pl" style="color:#111;font-weight:600">
zgody@looply.net.pl
</a>
</div>
</details>
</div>

</div>
</body>
</html>
