<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>{{ $firm->name }} – karta lojalnościowa | Looply</title>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<link rel="icon" type="image/png" href="/favicon.png">
<link rel="shortcut icon" href="/favicon.png">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;}

body{
min-height:100vh;
background:linear-gradient(180deg,#8b0000 0%,#b11212 50%,#6f0000 100%);
display:flex;justify-content:center;align-items:flex-start;
padding:20px 16px 40px;
}

.container{width:100%;max-width:400px;}

.logo-section{
width:100%;
background:rgba(255,255,255,.25);
border-radius:28px;
padding:18px;
margin-bottom:12px;
display:flex;
justify-content:center;
align-items:center;
overflow:hidden;
}

.logo-section img{
max-width:100%;
max-height:90px;
object-fit:contain;
display:block;
}

.card{
background:#fff;border-radius:32px;padding:28px 20px;
box-shadow:0 25px 60px rgba(0,0,0,.35);
margin-bottom:16px;text-align:center;
}

.subtitle{
color:#777;font-size:.9rem;margin:6px 0 18px;
border-bottom:1px solid #eee;padding-bottom:16px;
}

.stickers-grid{
display:grid;grid-template-columns:repeat(5,1fr);
gap:12px;margin:0 auto 18px;
}

.sticker{font-size:30px;opacity:.25;transition:.3s;}
.sticker.active{opacity:1;filter:drop-shadow(0 0 6px rgba(255,140,0,.7));}
.sticker.success{animation:celebrate 1.2s infinite;}

@keyframes celebrate{
0%{transform:scale(1);}
50%{transform:scale(1.15);}
100%{transform:scale(1);}
}

.central-motivation{
margin:14px 0 18px;
padding:14px;
border-radius:18px;
background:linear-gradient(90deg,#ff5f00,#ffb347);
color:#111;font-weight:900;font-size:.98rem;
box-shadow:0 10px 24px rgba(255,95,0,.25);
}

.central-motivation.success{
background:linear-gradient(90deg,#22c55e,#16a34a);
color:#fff;
}

.central-sub{margin-top:6px;font-size:.84rem;font-weight:600;}

.vip-badge{
display:inline-block;margin-top:8px;
padding:6px 12px;border-radius:999px;
background:#111;color:#fff;
font-size:.75rem;font-weight:800;
letter-spacing:.5px;
}

.qr-section svg{width:150px;height:150px;}
.code-number{font-size:1.6rem;font-weight:900;letter-spacing:2px;margin-top:6px;}

.glass-box{
background:rgba(255,255,255,.35);
backdrop-filter:blur(10px);
border-radius:26px;
padding:16px;color:#111;
margin-bottom:14px;
}

details summary{
cursor:pointer;font-weight:800;
list-style:none;display:flex;
justify-content:center;align-items:center;
gap:8px;
}

details summary::before{content:"▶";transition:.2s;}
details[open] summary::before{transform:rotate(90deg);}
details summary::-webkit-details-marker{display:none;}

details > div{
margin-top:12px;font-size:.9rem;
line-height:1.5;text-align:center;
}

.progress-bar-wrapper{
width:100%;height:8px;
background:rgba(0,0,0,.1);
border-radius:999px;margin-top:10px;
overflow:hidden;
}

.progress-fill{
height:100%;
background:linear-gradient(90deg,#ffb347,#ff5f00);
transition:width .6s ease;
position:relative;
}

.progress-fill.shimmer::after{
content:"";position:absolute;top:0;left:-40%;
width:40%;height:100%;
background:linear-gradient(90deg,transparent,rgba(255,255,255,.6),transparent);
animation:shine 2s infinite;
}

@keyframes shine{
0%{left:-40%;}
100%{left:120%;}
}

.progress-chip{
display:inline-block;margin-top:8px;
padding:6px 12px;border-radius:999px;
background:rgba(0,0,0,.08);
font-weight:800;font-size:.82rem;
}

.google-btn{
display:inline-flex;align-items:center;gap:6px;
padding:8px 14px;border-radius:999px;
background:#fff;color:#111;
font-weight:800;font-size:.9rem;
text-decoration:none;
box-shadow:0 4px 12px rgba(0,0,0,.15);
}

.social-icons{display:flex;justify-content:center;gap:14px;margin-top:8px;}
.social-icons a{
width:42px;height:42px;border-radius:50%;
display:flex;align-items:center;justify-content:center;
background:rgba(0,0,0,.05);
transition:.2s;
}
.social-icons a:hover{background:#fff;transform:translateY(-2px);}
.social-icons svg{width:20px;height:20px;}

.contact-list{display:flex;flex-direction:column;gap:8px;align-items:center;}
.contact-row{display:flex;gap:8px;font-weight:700;}
</style>
</head>
<body>
<div class="container">

@php
$percent = ($maxStamps ?? 0) > 0 ? (int) round(($current / $maxStamps) * 100) : 0;
$remaining = max(0, (int)$maxStamps - (int)$current);

$pizza = function($l){
if($l==1)return 'zamówienie';
if($l%10>=2&&$l%10<=4&&!($l%100>=12&&$l%100<=14))return 'zamówienia';
return 'zamówień';
};
@endphp

<div class="logo-section">
@if($firm->logo_path)
<img src="{{ asset('storage/'.$firm->logo_path) }}" alt="{{ $firm->name }}">
@else
<span style="font-size:48px">🍕</span>
@endif
</div>

<div class="card">
<h1>{{ $firm->name }}</h1>
<div class="subtitle">Karta lojalnościowa pizzerii</div>

<div class="stickers-grid">
@for($i=1;$i<=$maxStamps;$i++)
<div class="sticker {{ $i <= $current ? ($percent===100?'active success':'active') : '' }}">🍕</div>
@endfor
</div>

<div class="central-motivation {{ $percent===100?'success':'' }}">
@if($percent===100)
🎉 GRATISOWA PIZZA CZEKA!
<div class="central-sub">Pokaż kod przy kasie 🍕</div>
<div class="vip-badge">👑 STAŁY KLIENT</div>
@else
🍕 Jeszcze {{ $remaining }} {{ $pizza($remaining) }} i pizza gratis!
<div class="central-sub">Zamów jeszcze trochę i odbierz nagrodę 🔥</div>
@endif
</div>

<div class="qr-section">
{!! $qr !!}
<div class="code-number">{{ $displayCode }}</div>
</div>
</div>

{{-- 📍 DANE --}}
@if($firm->address || $firm->city || $firm->phone)
<div class="glass-box">
<details>
<summary>📍 Dane kontaktowe</summary>
<div class="contact-list">
@if($firm->address)<div class="contact-row">📍 {{ $firm->address }}</div>@endif
@if($firm->postal_code || $firm->city)<div class="contact-row">🏙 {{ $firm->postal_code }} {{ $firm->city }}</div>@endif
@if($firm->phone)<div class="contact-row">📞 {{ $firm->phone }}</div>@endif
</div>
</details>
</div>
@endif

{{-- 🌍 SOCIAL --}}
@if($firm->facebook_url || $firm->instagram_url || $firm->youtube_url)
<div class="glass-box">
<details>
<summary>🌍 Social Media</summary>
<div class="social-icons">

@if($firm->facebook_url)
<a href="{{ $firm->facebook_url }}" target="_blank" aria-label="Facebook">
<svg viewBox="0 0 24 24"><path fill="#1877F2" d="M22 12a10 10 0 1 0-11.5 9.9v-7H8v-3h2.5V9.5c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.3.2 2.3.2v2.5h-1.3c-1.3 0-1.7.8-1.7 1.6V12H17l-.4 3h-2.5v7A10 10 0 0 0 22 12z"/></svg>
</a>
@endif

@if($firm->instagram_url)
<a href="{{ $firm->instagram_url }}" target="_blank" aria-label="Instagram">
<svg viewBox="0 0 24 24">
<path fill="#E1306C" d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7z"/>
<path fill="#fff" d="M12 8.2A3.8 3.8 0 1 0 15.8 12 3.8 3.8 0 0 0 12 8.2zm0 6.2A2.4 2.4 0 1 1 14.4 12 2.4 2.4 0 0 1 12 14.4z"/>
<circle cx="17.6" cy="6.4" r="1.1" fill="#fff"/>
</svg>
</a>
@endif

@if($firm->youtube_url)
<a href="{{ $firm->youtube_url }}" target="_blank" aria-label="YouTube">
<svg viewBox="0 0 24 24">
<path fill="#FF0000" d="M23 12s0-3.5-.4-5.2a3 3 0 0 0-2.1-2.1C18.8 4 12 4 12 4s-6.8 0-8.5.7A3 3 0 0 0 1.4 6.8C1 8.5 1 12 1 12s0 3.5.4 5.2a3 3 0 0 0 2.1 2.1C5.2 20 12 20 12 20s6.8 0 8.5-.7a3 3 0 0 0 2.1-2.1C23 15.5 23 12 23 12z"/>
<path fill="#fff" d="M10 15.5v-7l6 3.5-6 3.5z"/>
</svg>
</a>
@endif

</div>
</details>
</div>
@endif

{{-- 🔔 RODO --}}
<div class="glass-box">
<details>
<summary>🔔 Zgody marketingowe i RODO</summary>
<div>
@if($client->sms_marketing_consent)
✅ Zgoda na SMS marketing
@else
❌ Brak zgody
@endif
</div>
</details>
</div>

</div>
</body>
</html>
