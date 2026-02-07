<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $firm->name ?? 'Karta lojalnościowa' }}</title>
@php
    $coffeeHeight = 0;
    if ($maxStamps > 0) {
        $coffeeHeight = min(($current / $maxStamps) * 85, 85);
    }
@endphp
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">

<style>
:root{
    --coffee:#6F4E37;
    --accent:#D2B48C;
    --glass:rgba(255,255,255,.14);
    --text:#f0f0f0;
}

*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:'Montserrat',sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#1A1A1A,#2C1E12);
    display:flex;
    justify-content:center;
    padding:20px 16px 40px;
    color:var(--text);
}

.container{
    width:100%;
    max-width:360px;
}

/* ===== CARD ===== */
.card{
    background:var(--glass);
    backdrop-filter:blur(18px);
    border-radius:30px;
    padding:28px;
    box-shadow:0 20px 40px rgba(0,0,0,.4);
    text-align:center;
    margin-bottom:16px;
}

/* ===== CUP ===== */
.cup-container{
    position:relative;
    width:150px;
    height:120px;
    margin:20px auto 30px;
}

.coffee-level{
    position:absolute;
    bottom:0;
    left:20px;
    width:110px;
height:{{ $coffeeHeight }}px;
    background:linear-gradient(to bottom,#7B5F4A,var(--coffee));
    border-radius:0 0 40px 40px;
    box-shadow:inset 0 5px 10px rgba(0,0,0,.3);
}

.coffee-level::before{
    content:"";
    position:absolute;
    top:-8px;
    left:0;
    width:100%;
    height:14px;
    background:var(--coffee);
    border-radius:50% / 100%;
    opacity:.9;
}

.cup-svg{
    position:absolute;
    inset:0;
    z-index:2;
}

.cup-path,
.cup-handle{
    stroke:var(--text);
    stroke-width:3;
    fill:none;
}

/* ===== STAMPS ===== */
.stamps-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:12px;
    margin:24px 0 18px;
}

.stamp{
    width:40px;
    height:40px;
    border-radius:50%;
    border:2px dashed rgba(255,255,255,.3);
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    color:rgba(255,255,255,.6);
    background:rgba(255,255,255,.05);
}

.stamp.active{
    background:var(--accent);
    color:#1a1a1a;
    border-color:var(--accent);
}

/* ===== SEPARATOR ===== */
.separator{
    height:1px;
    background:linear-gradient(90deg,transparent,#888,transparent);
    margin:18px 0;
}

/* ===== QR ===== */
.qr-section svg{
    width:150px;
    height:150px;
}
.code-number{
    font-size:1.4rem;
    font-weight:700;
    letter-spacing:2px;
    margin-top:6px;
}

/* ===== BOXES ===== */
.glass-box{
    background:var(--glass);
    backdrop-filter:blur(14px);
    border-radius:22px;
    padding:14px;
    margin-bottom:12px;
    font-size:.9rem;
}

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
details summary::-webkit-details-marker{display:none;}

details>div{
    margin-top:10px;
    text-align:center;
}
</style>
</head>

<body>
<div class="container">

<div class="card">
    <h2>{{ $firm->name }}</h2>
    <small>Karta lojalnościowa kawiarni</small>

    <div class="cup-container">
        <div class="coffee-level"></div>

        <svg class="cup-svg" viewBox="0 0 150 120">
            <path class="cup-path"
                  d="M20,10 L130,10 L120,90 C118,105 100,110 75,110 C50,110 32,105 30,90 Z"/>
            <path class="cup-handle"
                  d="M130,30 C150,30 150,60 130,60"/>
        </svg>
    </div>

    <div class="stamps-grid">
        @for($i=1;$i<=$maxStamps;$i++)
            <div class="stamp {{ $i <= $current ? 'active' : '' }}">☕</div>
        @endfor
    </div>

    <div class="separator"></div>

    <div class="qr-section">
        {!! $qr !!}
        <div class="code-number">{{ $displayCode }}</div>
    </div>
</div>

{{-- NAGRODA --}}
<div class="glass-box">
<details open>
    <summary>🎁 Nagroda</summary>
    <div>{{ $maxStamps }} kaw = <strong>Kawa gratis</strong></div>
</details>
</div>

{{-- KONTAKT --}}
<div class="glass-box">
<details>
    <summary>📍 Kontakt</summary>
    <div>
        @if($firm->phone) 📞 {{ $firm->phone }}<br>@endif
        @if($firm->address) 📍 {{ $firm->address }} @endif
    </div>
</details>
</div>

{{-- POSTĘP --}}
<div class="glass-box">
<details>
    <summary>📊 Postęp</summary>
    <div>{{ $current }} / {{ $maxStamps }} kaw</div>
</details>
</div>

{{-- RODO --}}
<div class="glass-box">
<details>
    <summary>🔔 RODO</summary>
    <div>
@if(isset($client) && $client->sms_marketing_consent)
            ✅ Zgoda SMS
        @else
            ❌ Brak zgody SMS
        @endif
    </div>
</details>
</div>

</div>
</body>
</html>
