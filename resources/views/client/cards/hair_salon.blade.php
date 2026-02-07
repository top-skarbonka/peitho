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
    background:
        linear-gradient(
            180deg,
            #f6efe8 0%,
            #e9d8c8 35%,
            #dcc2a8 65%,
            #cfad8f 100%
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

/* ===== KARTA ===== */
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
    filter:drop-shadow(0 0 6px rgba(120,84,72,.45));
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
    background:rgba(255,255,255,.35);
    backdrop-filter:blur(10px);
    border-radius:26px;
    padding:16px;
    color:#111;
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
    text-align:center;
}

details summary::before{
    content:"▶";
    transition:.2s;
}
details[open] summary::before{
    transform:rotate(90deg);
}

details summary::-webkit-details-marker{display:none;}

details > div{
    text-align:center;
    margin-top:12px;
    font-size:.9rem;
    line-height:1.5;
}

/* ===== PROGRESS ===== */
.progress-bar{
    height:10px;
    background:rgba(255,255,255,.35);
    border-radius:999px;
    overflow:hidden;
    margin-top:10px;
}
.progress-fill{
    height:100%;
    background:linear-gradient(90deg,#c9b6aa,#b08d7d);
}

/* ===== SOCIAL ===== */
.social-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    margin-top:12px;
    justify-items:center;
}

.social-btn{
    width:100%;
    max-width:160px;
    background:#fff;
    color:#222;
    padding:10px;
    border-radius:999px;
    font-weight:600;
    text-align:center;
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
        <span style="font-size:48px">✂️</span>
    @endif
</div>

{{-- KARTA --}}
<div class="card">
    <h1>{{ $firm->name }}</h1>
    <div class="subtitle">Karta lojalnościowa salonu fryzjerskiego</div>

    <div class="stickers-grid">
        @for($i=1;$i<=$maxStamps;$i++)
            <div class="sticker {{ $i <= $current ? 'active' : '' }}">✂️</div>
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
<strong>{{ $maxStamps }} wizyt</strong> = rabat <strong>50 zł</strong><br>
<small>Kwotę/zasady nagrody ustawimy później w panelu firmy.</small>
</div>
</details>
</div>

{{-- KONTAKT + SOCIAL --}}
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
@if($firm->google_review_url)
<a class="social-btn" href="{{ $firm->google_review_url }}" target="_blank">⭐ Opinie</a>
@endif
</div>
</div>
</details>
</div>

{{-- POSTĘP --}}
<div class="glass-box">
<details>
<summary>📊 Postęp karty</summary>

<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} wizyt
<div class="progress-bar">
<div class="progress-fill" style="width:{{ ($current/$maxStamps)*100 }}%"></div>
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
✅ <strong>Zgoda na SMS marketing</strong><br>
<small>Wyrażona: {{ $client->sms_marketing_consent_at?->format('d.m.Y H:i') }}</small>
@else
❌ Brak zgody na SMS marketing
@endif

<hr style="margin:12px 0;opacity:.3;">

<strong>Regulamin i polityka prywatności</strong><br>
<small>Zaakceptowane: {{ $client->terms_accepted_at?->format('d.m.Y H:i') }}</small>

<hr style="margin:12px 0;opacity:.3;">

<strong>Cofnięcie zgód</strong><br>
W każdej chwili możesz cofnąć zgody, pisząc na:<br>
<a href="mailto:zgody@looply.net.pl"
style="color:#111;font-weight:600;text-decoration:underline;">
zgody@looply.net.pl
</a>
</div>
</details>
</div>

</div>
</body>
</html>
