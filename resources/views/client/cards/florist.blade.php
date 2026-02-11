<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>{{ $firm->name ?? 'Karta lojalnościowa' }} – Looply</title>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<link rel="icon" type="image/png" href="/favicon.png">
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#f472b6">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;}

body{
min-height:100vh;
background:linear-gradient(180deg,#fbcfe8 0%,#f9a8d4 50%,#f472b6 100%);
display:flex;justify-content:center;align-items:flex-start;
padding:20px 16px 40px;
}

.container{width:100%;max-width:400px;}

.logo-section{
width:100%;
background:rgba(255,255,255,.35);
border-radius:28px;
padding:18px;
margin-bottom:12px;
display:flex;justify-content:center;
}

.card{
background:#fff;
border-radius:32px;
padding:28px 20px;
box-shadow:0 25px 60px rgba(0,0,0,.25);
margin-bottom:16px;
text-align:center;
position:relative;
overflow:hidden;
}

.subtitle{
color:#888;font-size:.9rem;margin:6px 0 18px;
border-bottom:1px solid #eee;padding-bottom:16px;
}

.stickers-grid{
display:grid;grid-template-columns:repeat(5,1fr);
gap:12px;margin:0 auto 18px;
}

.sticker{font-size:30px;opacity:.25;transition:.3s;}
.sticker.active{opacity:1;filter:drop-shadow(0 0 6px rgba(236,72,153,.6));}
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
background:linear-gradient(90deg,#ec4899,#db2777);
color:#fff;font-weight:900;font-size:.98rem;
box-shadow:0 10px 24px rgba(236,72,153,.18);
}

.central-motivation.success{
background:linear-gradient(90deg,#22c55e,#16a34a);
box-shadow:0 0 20px rgba(34,197,94,.45);
}

.central-sub{
margin-top:6px;font-size:.84rem;font-weight:600;
}

/* VIP BADGE — UX 5.0 (JEDYNA ZMIANA) */
.vip-badge{
display:inline-flex;
align-items:center;
gap:6px;
margin-top:10px;
padding:6px 14px;
border-radius:999px;
font-size:.75rem;
font-weight:800;
letter-spacing:.4px;
background:linear-gradient(90deg,#f59e0b,#fbbf24,#fde68a);
color:#111;
box-shadow:
0 4px 12px rgba(245,158,11,.35),
inset 0 0 0 1px rgba(255,255,255,.4);
animation:vipGlow 2.4s ease-in-out infinite;
}

@keyframes vipGlow{
0%{box-shadow:0 4px 12px rgba(245,158,11,.25), inset 0 0 0 1px rgba(255,255,255,.4);}
50%{box-shadow:0 6px 18px rgba(245,158,11,.45), inset 0 0 0 1px rgba(255,255,255,.45);}
100%{box-shadow:0 4px 12px rgba(245,158,11,.25), inset 0 0 0 1px rgba(255,255,255,.4);}
}

/* QR */
.qr-section svg{width:150px;height:150px;}
.code-number{font-size:1.6rem;font-weight:900;letter-spacing:2px;margin-top:6px;}

/* GLASS */
.glass-box{
background:rgba(255,255,255,.18);
backdrop-filter:blur(8px);
border-radius:22px;
padding:14px;
color:#fff;
margin-bottom:12px;
}

/* ACCORDION */
details summary{
cursor:pointer;
font-weight:800;
list-style:none;
display:flex;justify-content:center;align-items:center;
gap:8px;
padding:8px 10px;
border-radius:14px;
background:rgba(255,255,255,.12);
}

details summary::before{content:"▶";transition:.2s;}
details[open] summary::before{transform:rotate(90deg);}
details summary::-webkit-details-marker{display:none;}

details > div{text-align:center;margin-top:12px;font-size:.95rem;line-height:1.5;}

/* CONTACT */
.contact-list{display:flex;flex-direction:column;gap:8px;align-items:center;}
.contact-row{display:flex;gap:8px;font-weight:700;}

/* PROGRESS */
.progress-bar-wrapper{
width:100%;height:8px;
background:rgba(255,255,255,.25);
border-radius:999px;margin-top:10px;overflow:hidden;
}

.progress-bar{
height:100%;
background:linear-gradient(90deg,#ec4899,#be185d);
border-radius:999px;
transition:width .6s ease;
position:relative;
}

.progress-bar.full{background:linear-gradient(90deg,#22c55e,#16a34a);}

/* shimmer when 85%+ */
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
background:rgba(255,255,255,.15);
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

/* SOCIAL */
.social-icons{display:flex;justify-content:center;gap:14px;margin-top:8px;}
.social-icons a{
width:42px;height:42px;border-radius:50%;
display:flex;align-items:center;justify-content:center;
background:rgba(255,255,255,.18);
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
<span style="font-size:48px">💐</span>
@endif
</div>

@php
$percent = ($maxStamps ?? 0) > 0 ? (int) round(($current / $maxStamps) * 100) : 0;
$remaining = max(0, (int)$maxStamps - (int)$current);

$bukiet = function($l){
if($l==1)return 'bukiet';
if($l%10>=2&&$l%10<=4&&!($l%100>=12&&$l%100<=14))return 'bukiety';
return 'bukietów';
};
@endphp

<div class="card">
<h1>{{ $firm->name }}</h1>
<div class="subtitle">Karta lojalnościowa kwiaciarni</div>

<div class="stickers-grid">
@for($i=1;$i<=$maxStamps;$i++)
<div class="sticker {{ $i <= $current ? ($percent===100?'active success':'active') : '' }}">💐</div>
@endfor
</div>

<div class="central-motivation {{ $percent===100?'success':'' }}">
@if($percent===100)
🎉 GRATULACJE!
<div class="central-sub">Odbierz swój darmowy bukiet 🌸</div>
<div class="vip-badge">👑 KLIENT VIP</div>
@else
💐 Jeszcze {{ $remaining }} {{ $bukiet($remaining) }} i nagroda jest Twoja!
<div class="central-sub">Przy następnej wizycie będziesz jeszcze bliżej 🌸</div>
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
<summary>📊 Postęp karty</summary>
<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }}
<div class="progress-bar-wrapper">
<div class="progress-bar {{ $percent>=85?'shimmer':'' }} {{ $percent===100?'full':'' }}" style="width: {{ $percent }}%;"></div>
</div>
<div class="progress-chip">
@if($percent===100)
✅ Nagroda gotowa
@else
Brakuje {{ $remaining }} {{ $bukiet($remaining) }}
@endif
</div>
</div>
</details>
</div>

{{-- 🎁 PROMOCJA --}}
@if($firm->promotion_text)
<div class="glass-box">
<details {{ $percent===100?'open':'' }}>
<summary>🎁 Nagroda / Promocja</summary>
<div>{!! nl2br(e($firm->promotion_text)) !!}</div>
</details>
</div>
@endif

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

{{-- ⭐ GOOGLE --}}
@if($firm->google_url)
<div class="glass-box">
<details>
<summary>⭐ Opinie Google</summary>
<div>
<a class="google-btn" href="{{ \Illuminate\Support\Str::startsWith($firm->google_url,['http://','https://'])?$firm->google_url:'https://'.$firm->google_url }}" target="_blank">
⭐ Zobacz / dodaj opinię
</a>
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
<a href="{{ $firm->facebook_url }}" target="_blank">
<svg viewBox="0 0 24 24"><path fill="#1877F2" d="M22 12a10 10 0 10-11.5 9.9v-7H8v-3h2.5V9.5c0-2.5 1.5-3.9 3.8-3.9z"/></svg>
</a>
@endif
@if($firm->instagram_url)
<a href="{{ $firm->instagram_url }}" target="_blank">
<svg viewBox="0 0 24 24"><path fill="#E1306C" d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7z"/></svg>
</a>
@endif
@if($firm->youtube_url)
<a href="{{ $firm->youtube_url }}" target="_blank">
<svg viewBox="0 0 24 24"><path fill="#FF0000" d="M23 12s0-3.5-.4-5.2a3 3 0 00-2.1-2.1z"/></svg>
</a>
@endif
</div>
</details>
</div>
@endif

{{-- 🕒 GODZINY --}}
@if($firm->opening_hours)
<div class="glass-box">
<details>
<summary>🕒 Godziny otwarcia</summary>
<div>{!! nl2br(e($firm->opening_hours)) !!}</div>
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
