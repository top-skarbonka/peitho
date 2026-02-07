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
    background:linear-gradient(
        180deg,
        #2b1a12 0%,
        #3a1f14 40%,
        #4a2415 70%,
        #2b1a12 100%
    );
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
    background:rgba(255,255,255,.2);
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
    color:#666;
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
    font-size:34px;
    opacity:.25;
}

.sticker span{
    display:inline-block;
    transform:scaleX(-1);
}

.sticker.active{
    opacity:1;
    filter:drop-shadow(0 0 8px rgba(255,140,0,.7));
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
    background:rgba(255,255,255,.85);
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
    background:#ddd;
    border-radius:999px;
    overflow:hidden;
    margin-top:10px;
}

.progress-fill{
    height:100%;
    background:linear-gradient(90deg,#ffb347,#ff8c00);
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
<span style="font-size:48px;display:inline-block;transform:scaleX(-1)">🥙</span>
@endif
</div>

{{-- CARD --}}
<div class="card">
<h1>{{ $firm->name }}</h1>
<div class="subtitle">Karta lojalnościowa kebaba</div>

<div class="stickers-grid">
@for($i=1;$i<=$maxStamps;$i++)
<div class="sticker {{ $i <= $current ? 'active' : '' }}">
    <span>🥙</span>
</div>
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

{{-- NAGRODA --}}
<div class="glass-box">
<details open>
<summary>🎁 Nagroda</summary>
<div>
<strong>{{ $maxStamps }} zamówień</strong> = <strong>🥙 Kebab gratis</strong>
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
</div>
</details>
</div>

</div>
</body>
</html>
