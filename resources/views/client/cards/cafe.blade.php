<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">

<title>{{ $firm->name }} – karta lojalnościowa | Looply</title>

<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<!-- ===== FAVICON (tylko ikonka w karcie / przeglądarce) ===== -->
<link rel="icon" type="image/png" href="/favicon.png">
<link rel="shortcut icon" href="/favicon.png">

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(180deg,#f2f2f2 0%,#cfcfcf 100%);
    display:flex;
    justify-content:center;
    padding:20px 16px 40px;
}

.container{
    width:100%;
    max-width:400px;
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
    color:#666;
    font-size:.9rem;
    margin:6px 0 18px;
    border-bottom:1px solid #eee;
    padding-bottom:16px;
}

/* ===== STAMPS ===== */
.coffee-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:14px;
    margin-bottom:16px;
}

.cup{
    font-size:30px;
    opacity:.25;
}
.cup.active{
    opacity:1;
}

/* ===== SEPARATOR ===== */
.separator{
    height:1px;
    background:linear-gradient(90deg,transparent,#ddd,transparent);
    margin:18px 0;
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

/* ===== BOX ===== */
.glass-box{
    background:#fff;
    border-radius:26px;
    padding:16px;
    margin-bottom:14px;
}

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
    margin-top:12px;
    font-size:.9rem;
    line-height:1.5;
    text-align:center;
}
</style>
</head>

<body>
<div class="container">

<!-- KARTA -->
<div class="card">
    <h1>{{ $firm->name }}</h1>
    <div class="subtitle">Karta lojalnościowa kawiarni</div>

    <div class="coffee-grid">
        @for($i=1;$i<=$maxStamps;$i++)
            <div class="cup {{ $i <= $current ? 'active' : '' }}">☕</div>
        @endfor
    </div>

    <div class="separator"></div>

    <div class="qr-section">
        {!! $qr !!}
        <div class="code-number">{{ $displayCode }}</div>
    </div>
</div>

<!-- ⭐ OPINIE GOOGLE -->
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

<!-- NAGRODA -->
<div class="glass-box">
<details open>
<summary>🎁 Nagroda</summary>
<div>
{{ $maxStamps }} kaw = <strong>Kawa gratis ☕</strong>
</div>
</details>
</div>

<!-- KONTAKT -->
<div class="glass-box">
<details>
<summary>📍 Kontakt</summary>
<div>
@if($firm->phone)
📞 {{ $firm->phone }}<br>
@endif
@if($firm->address)
📍 {{ $firm->address }}
@endif
</div>
</details>
</div>

<!-- POSTĘP -->
<div class="glass-box">
<details>
<summary>📊 Postęp</summary>
<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} kaw
</div>
</details>
</div>

<!-- RODO -->
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
