<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>{{ $firm->name }} – Karta warsztatowa</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;}

body{
background:#222;
display:flex;
justify-content:center;
padding:20px;
}

.container{
width:100%;
max-width:400px;
}

.card{
background:#fff;
border-radius:22px;
overflow:hidden;
box-shadow:0 25px 60px rgba(0,0,0,.4);
}

.header1{
background:#1a242f;
color:#fff;
padding:25px 15px;
text-align:center;
}

.header1 h1{
font-size:1.2rem;
font-weight:700;
}

.header2{
background:#3b4d61;
color:#fff;
padding:20px;
text-align:center;
}

.icon{
display:flex;
justify-content:center;
align-items:center;
margin-bottom:6px;
}

.header2 h2{
font-size:1.1rem;
font-weight:800;
}

/* HEADER AUTO */
.car-icon{
width:48px;
height:48px;
fill:#ffffff;
}

/* NOWE PROFESJONALNE KLUCZE */
.stamp-icon{
width:26px;
height:26px;
stroke:#3b4d61;
stroke-width:3;
stroke-linecap:round;
stroke-linejoin:round;
fill:none;
}

/* STAMPY */
.stamps{
display:grid;
grid-template-columns:repeat(5,1fr);
gap:12px;
padding:30px 20px;
}

.circle{
aspect-ratio:1;
border:2px solid #ccc;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
overflow:hidden;
transition:.25s;
}

.circle.on{
background:#e6e6e6;
border-color:#999;
transform:scale(1.05);
}

/* INFO O NAGRODZIE */
.rules{
font-weight:900;
text-transform:uppercase;
font-size:.85rem;
text-align:center;
padding:0 20px;
line-height:1.4;
margin-bottom:25px;
}

/* QR */
.qr-area{
background:#f9f9f9;
padding:20px;
border-top:1px solid #eee;
text-align:center;
}

.qr-area svg{
width:140px;
height:140px;
}

.code-number{
font-size:1.4rem;
font-weight:900;
letter-spacing:2px;
margin-top:6px;
}

/* BOXY */
.glass-box{
background:rgba(255,255,255,.06);
border-radius:18px;
padding:14px;
color:#fff;
margin-top:14px;
border:1px solid rgba(255,255,255,.08);
}

details summary{
cursor:pointer;
font-weight:800;
list-style:none;
padding:8px 10px;
}

details summary::-webkit-details-marker{
display:none;
}

details > div{
margin-top:12px;
font-size:.9rem;
line-height:1.5;
}

.contact-list{
display:flex;
flex-direction:column;
gap:6px;
}

.google-btn{
display:inline-flex;
align-items:center;
gap:8px;
padding:10px 14px;
border-radius:999px;
background:#fff;
color:#111;
font-weight:800;
font-size:.95rem;
text-decoration:none;
box-shadow:0 4px 12px rgba(0,0,0,.18);
}

.social-icons{
display:flex;
justify-content:center;
gap:14px;
margin-top:10px;
}

.social-icons a{
width:44px;
height:44px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
background:rgba(255,255,255,.14);
transition:.2s;
text-decoration:none;
color:#fff;
font-weight:800;
}

.social-icons a:hover{
background:#fff;
color:#111;
transform:translateY(-2px);
}
</style>
</head>

<body>
<div class="container">

@php
$carSvgHeader = '
<svg viewBox="0 0 64 64" class="car-icon" xmlns="http://www.w3.org/2000/svg">
<path d="M10 38l4-12c1-3 3-5 6-5h24c3 0 5 2 6 5l4 12v10h-6a4 4 0 0 1-8 0H24a4 4 0 0 1-8 0H10z"/>
<circle cx="20" cy="48" r="4"/>
<circle cx="44" cy="48" r="4"/>
</svg>
';

$wrenchStamp = '
<svg viewBox="0 0 24 24" class="stamp-icon" xmlns="http://www.w3.org/2000/svg">
<path d="M3 21l6-6"/>
<path d="M9 15l-2-2a4 4 0 115.6-5.6l2 2"/>
<path d="M21 3l-6 6"/>
<path d="M15 9l2 2a4 4 0 11-5.6 5.6l-2-2"/>
</svg>
';
@endphp

<div class="card">

<div class="header1">
<h1>{{ $firm->name }}</h1>
</div>

<div class="header2">
<div class="icon">
@if($firm->logo_path)
<img src="{{ asset('storage/'.$firm->logo_path) }}" style="max-height:60px;">
@else
{!! $carSvgHeader !!}
@endif
</div>
<h2>KARTA STAŁEGO KLIENTA WARSZTATU</h2>
</div>

<div class="stamps">
@for($i=1;$i<=$maxStamps;$i++)
<div class="circle {{ $i <= $current ? 'on' : '' }}">
{!! $wrenchStamp !!}
</div>
@endfor
</div>

<div class="rules">
@if(!empty($firm->promotion_text))
{!! nl2br(e($firm->promotion_text)) !!}
@else
1 NAKLEJKA ZA KAŻDĄ NAPRAWĘ.<br>
{{ $maxStamps }} NAKLEJEK = DARMOWY PRZEGLĄD LUB ZNIŻKA.
@endif
</div>

<div class="qr-area">
{!! $qr !!}
<div class="code-number">{{ $displayCode }}</div>
</div>

</div>

{{-- 1️⃣ DANE KONTAKTOWE --}}
@if($firm->address || $firm->city || $firm->phone)
<div class="glass-box">
<details>
<summary>📍 Dane kontaktowe</summary>
<div class="contact-list">
@if($firm->address)<div>📍 {{ $firm->address }}</div>@endif
@if($firm->postal_code || $firm->city)<div>🏙 {{ $firm->postal_code }} {{ $firm->city }}</div>@endif
@if($firm->phone)<div>📞 {{ $firm->phone }}</div>@endif
</div>
</details>
</div>
@endif

{{-- 2️⃣ GODZINY OTWARCIA --}}
@if(!empty($firm->opening_hours))
<div class="glass-box">
<details>
<summary>🕒 Godziny otwarcia</summary>
<div>{!! nl2br(e($firm->opening_hours)) !!}</div>
</details>
</div>
@endif

{{-- 3️⃣ NAGRODA --}}
@if(!empty($firm->promotion_text))
<div class="glass-box">
<details>
<summary>🎁 Nagroda / Promocja</summary>
<div>{!! nl2br(e($firm->promotion_text)) !!}</div>
</details>
</div>
@endif

{{-- 4️⃣ POSTĘP --}}
<div class="glass-box">
<details>
<summary>📊 Postęp karty</summary>
<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} naklejek.
</div>
</details>
</div>

{{-- 5️⃣ GOOGLE --}}
@if(!empty($firm->google_url))
<div class="glass-box">
<details>
<summary>⭐ Opinie Google</summary>
<div style="text-align:center;">
<a class="google-btn" href="{{ $firm->google_url }}" target="_blank" rel="noopener">
⭐ Zobacz opinie
</a>
</div>
</details>
</div>
@endif

{{-- 6️⃣ SOCIAL --}}
@if(!empty($firm->facebook_url) || !empty($firm->instagram_url) || !empty($firm->youtube_url))
<div class="glass-box">
<details>
<summary>🌐 Social media</summary>
<div class="social-icons">

@if(!empty($firm->facebook_url))
<a href="{{ $firm->facebook_url }}" target="_blank" rel="noopener">F</a>
@endif

@if(!empty($firm->instagram_url))
<a href="{{ $firm->instagram_url }}" target="_blank" rel="noopener">I</a>
@endif

@if(!empty($firm->youtube_url))
<a href="{{ $firm->youtube_url }}" target="_blank" rel="noopener">Y</a>
@endif

</div>
</details>
</div>
@endif

</div>
</body>
</html>
