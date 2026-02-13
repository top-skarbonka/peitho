<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>{{ $firm->name ?? 'Karta lojalnościowa' }} – Looply</title>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<link rel="icon" type="image/png" href="/favicon.png">
<link rel="manifest" href="/manifest.json">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;}

body{
min-height:100vh;
background:linear-gradient(180deg,#2b1a12 0%,#3a1f14 40%,#4a2415 70%,#2b1a12 100%);
display:flex;justify-content:center;align-items:flex-start;
padding:20px 16px 40px;
}

.container{width:100%;max-width:400px;}

/* LOGO */
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
color:#666;font-size:.9rem;margin:6px 0 18px;
border-bottom:1px solid #eee;padding-bottom:16px;
}

.stickers-grid{
display:grid;grid-template-columns:repeat(5,1fr);
gap:12px;margin:0 auto 18px;
}

.sticker{font-size:34px;opacity:.25;transition:.3s;}
.sticker span{display:inline-block;transform:scaleX(-1);}
.sticker.active{opacity:1;filter:drop-shadow(0 0 8px rgba(255,140,0,.7));}
.sticker.success{animation:celebrate 1.2s infinite;}

@keyframes celebrate{
0%{transform:scale(1);}
50%{transform:scale(1.15);}
100%{transform:scale(1);}
}

/* CENTRAL BANNER */
.central-motivation{
margin:14px 0 18px;
padding:14px;
border-radius:18px;
background:linear-gradient(90deg,#ff8c00,#ffb347);
color:#111;font-weight:900;font-size:.98rem;
box-shadow:0 10px 24px rgba(255,140,0,.25);
}

.central-motivation.success{
background:linear-gradient(90deg,#22c55e,#16a34a);
color:#fff;
box-shadow:0 0 20px rgba(34,197,94,.45);
}

.central-sub{margin-top:6px;font-size:.84rem;font-weight:600;}

.vip-badge{
display:inline-block;
margin-top:8px;
padding:6px 12px;
border-radius:999px;
background:#111;
color:#fff;
font-size:.75rem;
font-weight:800;
letter-spacing:.5px;
}

/* QR */
.qr-section svg{width:150px;height:150px;}
.code-number{font-size:1.6rem;font-weight:900;letter-spacing:2px;margin-top:6px;}

/* GLASS */
.glass-box{
background:rgba(255,255,255,.85);
border-radius:22px;
padding:14px;
color:#111;
margin-bottom:12px;
}

details summary{
cursor:pointer;
font-weight:800;
list-style:none;
display:flex;justify-content:center;align-items:center;
gap:8px;
padding:8px 10px;
border-radius:14px;
background:rgba(0,0,0,.05);
}

details summary::before{content:"▶";transition:.2s;}
details[open] summary::before{transform:rotate(90deg);}
details summary::-webkit-details-marker{display:none;}
details > div{text-align:center;margin-top:12px;font-size:.95rem;line-height:1.5;}

/* PROGRESS */
.progress-bar-wrapper{
width:100%;height:8px;
background:rgba(0,0,0,.1);
border-radius:999px;margin-top:10px;overflow:hidden;
}

.progress-bar{
height:100%;
background:linear-gradient(90deg,#ffb347,#ff8c00);
border-radius:999px;
transition:width .6s ease;
position:relative;
}

.progress-bar.full{background:linear-gradient(90deg,#22c55e,#16a34a);}

.progress-bar.shimmer::after{
content:"";
position:absolute;
top:0;left:-40%;
width:40%;height:100%;
background:linear-gradient(90deg,transparent,rgba(255,255,255,.5),transparent);
animation:shine 2s infinite;
}

@keyframes shine{
0%{left:-40%;}
100%{left:120%;}
}

.progress-chip{
display:inline-block;
margin-top:8px;
padding:6px 12px;
border-radius:999px;
background:rgba(0,0,0,.05);
font-weight:800;font-size:.82rem;
}

/* GOOGLE */
.google-btn{
display:inline-flex;align-items:center;gap:6px;
padding:8px 14px;
border-radius:999px;
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
</style>
</head>

<body>
<div class="container">

<div class="logo-section">
@if($firm->logo_path)
<img src="{{ asset('storage/'.$firm->logo_path) }}" alt="{{ $firm->name }}">
@else
<span style="font-size:48px;display:inline-block;transform:scaleX(-1)">🥙</span>
@endif
</div>

@php
$percent = ($maxStamps ?? 0) > 0 ? (int) round(($current / $maxStamps) * 100) : 0;
$remaining = max(0, (int)$maxStamps - (int)$current);

$kebab = function($l){
if($l==1)return 'zamówienie';
if($l%10>=2&&$l%10<=4&&!($l%100>=12&&$l%100<=14))return 'zamówienia';
return 'zamówień';
};
@endphp

<div class="card">
<h1>{{ $firm->name }}</h1>
<div class="subtitle">Karta lojalnościowa kebaba</div>

<div class="stickers-grid">
@for($i=1;$i<=$maxStamps;$i++)
<div class="sticker {{ $i <= $current ? ($percent===100?'active success':'active') : '' }}"><span>🥙</span></div>
@endfor
</div>

<div class="central-motivation {{ $percent===100?'success':'' }}">
@if($percent===100)
🎉 KEBAB GRATIS CZEKA!
<div class="central-sub">Pokaż kod przy kasie 🔥</div>
<div class="vip-badge">👑 STAŁY KLIENT</div>
@else
🥙 Jeszcze {{ $remaining }} {{ $kebab($remaining) }} i kebab gratis!
<div class="central-sub">Wpadnij jeszcze raz i odbierz nagrodę 🔥</div>
@endif
</div>

<div class="qr-section">
{!! $qr !!}
<div class="code-number">{{ $displayCode }}</div>
</div>
</div>

{{-- 📊 POSTĘP --}}
<div class="glass-box">
<details>
<summary>📊 Postęp</summary>
<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} zamówień
<div class="progress-bar-wrapper">
<div class="progress-bar {{ $percent>=85?'shimmer':'' }} {{ $percent===100?'full':'' }}" style="width: {{ $percent }}%;"></div>
</div>
<div class="progress-chip">
@if($percent===100)
✅ Gotowe do odbioru
@else
Brakuje {{ $remaining }} {{ $kebab($remaining) }}
@endif
</div>
</div>
</details>
</div>

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
