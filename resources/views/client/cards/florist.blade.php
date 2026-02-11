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
body{min-height:100vh;background:linear-gradient(180deg,#fbcfe8 0%,#f9a8d4 50%,#f472b6 100%);display:flex;justify-content:center;align-items:flex-start;padding:20px 16px 40px;}
.container{width:100%;max-width:400px;}
.logo-section{width:100%;background:rgba(255,255,255,.35);border-radius:28px;padding:18px;margin-bottom:12px;display:flex;justify-content:center;}
.card{background:#fff;border-radius:32px;padding:28px 20px;box-shadow:0 25px 60px rgba(0,0,0,.25);margin-bottom:16px;text-align:center;}
.subtitle{color:#888;font-size:.9rem;margin:6px 0 18px;border-bottom:1px solid #eee;padding-bottom:16px;}

.stickers-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin:0 auto 18px;}
.sticker{font-size:30px;opacity:.25;transform:scale(.96);transition:opacity .25s ease, transform .25s ease, filter .25s ease;}
.sticker.active{opacity:1;transform:scale(1);filter:drop-shadow(0 0 6px rgba(236,72,153,.6));}
.sticker.active.new{animation:pop .35s ease;}
@keyframes pop{0%{transform:scale(.85);} 60%{transform:scale(1.08);} 100%{transform:scale(1);} }

.central-motivation{
margin:14px 0 20px;
padding:14px;
border-radius:18px;
background:linear-gradient(90deg,#ec4899,#db2777);
color:#fff;
font-weight:900;
font-size:1rem;
}
.central-motivation.near{background:linear-gradient(90deg,#f97316,#ea580c);}
.central-motivation.ready{background:linear-gradient(90deg,#22c55e,#16a34a); box-shadow:0 0 18px rgba(34,197,94,.35);}
.central-sub{margin-top:6px;font-size:.84rem;opacity:.95;font-weight:600;}

.qr-section svg{width:150px;height:150px;}
.code-number{font-size:1.6rem;font-weight:800;letter-spacing:2px;margin-top:6px;}

.glass-box{background:rgba(255,255,255,.22);backdrop-filter:blur(10px);border-radius:26px;padding:16px;color:#fff;margin-bottom:14px;}
details summary{cursor:pointer;font-weight:900;list-style:none;display:flex;align-items:center;justify-content:center;gap:8px;}
details summary::before{content:"▶";transition:.2s;}
details[open] summary::before{transform:rotate(90deg);}
details summary::-webkit-details-marker{display:none;}
details > div{text-align:center;margin-top:14px;font-size:1rem;line-height:1.6;}

.contact-row{
display:flex;
align-items:center;
justify-content:center;
gap:10px;
margin-bottom:10px;
font-weight:800;
font-size:1.02rem;
}
.contact-row svg{width:20px;height:20px;flex-shrink:0;opacity:.95;}

.progress-bar-wrapper{width:100%;height:12px;background:rgba(255,255,255,.35);border-radius:999px;margin-top:12px;overflow:hidden;position:relative;}
.progress-bar{height:100%;background:linear-gradient(90deg,#ec4899,#be185d);border-radius:999px;transition:width .6s ease;}
.progress-bar.near{background:linear-gradient(90deg,#f97316,#ea580c);}
.progress-bar.full{background:linear-gradient(90deg,#22c55e,#16a34a);}
.progress-shimmer{
position:absolute;inset:0;
background:linear-gradient(90deg, transparent, rgba(255,255,255,.28), transparent);
transform:translateX(-120%);
animation:shimmer 1.6s infinite;
}
@keyframes shimmer{0%{transform:translateX(-120%);} 100%{transform:translateX(120%);} }

.social-icons{display:flex;justify-content:center;gap:18px;margin-top:10px;}
.social-icons a{width:46px;height:46px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:rgba(255,255,255,.28);transition:.2s;box-shadow:0 10px 25px rgba(0,0,0,.12);}
.social-icons a:hover{background:#fff;transform:translateY(-1px) scale(1.02);}
.social-icons svg{width:22px;height:22px;display:block;}

.mini-hint{margin-top:8px;font-size:.8rem;opacity:.9;font-weight:700;}
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
$near = ($percent >= 80 && $percent < 100);

function bukietOdmiana($liczba){
    if($liczba == 1) return 'bukiet';
    if($liczba % 10 >= 2 && $liczba % 10 <= 4 && !($liczba % 100 >= 12 && $liczba % 100 <= 14)) return 'bukiety';
    return 'bukietów';
}

$fb = $firm->facebook_url ?? null;
$ig = $firm->instagram_url ?? null;
$yt = $firm->youtube_url ?? null;

$fbLink = $fb ? (\Illuminate\Support\Str::startsWith($fb, ['http://','https://']) ? $fb : 'https://'.$fb) : null;
$igLink = $ig ? (\Illuminate\Support\Str::startsWith($ig, ['http://','https://']) ? $ig : 'https://'.$ig) : null;
$ytLink = $yt ? (\Illuminate\Support\Str::startsWith($yt, ['http://','https://']) ? $yt : 'https://'.$yt) : null;
@endphp

<div class="card">
<h1>{{ $firm->name }}</h1>
<div class="subtitle">Karta lojalnościowa kwiaciarni</div>

<div class="stickers-grid">
@for($i=1;$i<=$maxStamps;$i++)
<div class="sticker {{ $i <= $current ? 'active' : '' }} {{ $i === $current ? 'new' : '' }}">💐</div>
@endfor
</div>

<div class="central-motivation {{ $percent === 100 ? 'ready' : ($near ? 'near' : '') }}">
@if($percent === 100)
🎉 Nagroda gotowa!
<div class="central-sub">Pokaż kartę przy kasie i odbierz prezent 💚</div>
@elseif($remaining > 0)
💐 Jeszcze {{ $remaining }} {{ bukietOdmiana($remaining) }} i nagroda jest Twoja!
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
<details open>
<summary>📊 Postęp karty</summary>
<div>
Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} bukietów
<div class="progress-bar-wrapper">
<div class="progress-bar {{ $percent === 100 ? 'full' : ($near ? 'near' : '') }}" style="width: {{ $percent }}%;"></div>
<div class="progress-shimmer"></div>
</div>
<div class="mini-hint">
@if($percent === 100)
✅ Gotowe – podejdź do obsługi po nagrodę!
@elseif($near)
🔥 Ostatnia prosta – już naprawdę blisko!
@else
✨ Zbieraj dalej – każda wizyta przybliża do nagrody.
@endif
</div>
</div>
</details>
</div>

{{-- 🎁 PROMOCJA --}}
@if($firm->promotion_text)
<div class="glass-box">
<details>
<summary>🎁 Nagroda / Promocja</summary>
<div>{!! nl2br(e($firm->promotion_text)) !!}</div>
</details>
</div>
@endif

{{-- 📍 DANE KONTAKTOWE --}}
@if($firm->address || $firm->city || $firm->phone)
<div class="glass-box">
<details>
<summary>📍 Dane kontaktowe</summary>
<div>

@if($firm->address)
<div class="contact-row">
<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#ffffff" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/></svg>
<span>{{ $firm->address }}</span>
</div>
@endif

@if($firm->postal_code || $firm->city)
<div class="contact-row">
<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#ffffff" d="M4 4h16v16H4V4zm2 2v12h12V6H6zm2 2h8v2H8V8zm0 4h6v2H8v-2z"/></svg>
<span>{{ $firm->postal_code }} {{ $firm->city }}</span>
</div>
@endif

@if($firm->phone)
<div class="contact-row">
<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#ffffff" d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C11.85 21 3 12.15 3 1a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.24 1.01l-2.21 2.2z"/></svg>
<span>{{ $firm->phone }}</span>
</div>
@endif

</div>
</details>
</div>
@endif

{{-- 🌍 SOCIAL MEDIA --}}
@if($fbLink || $igLink || $ytLink)
<div class="glass-box">
<details>
<summary>🌍 Social Media</summary>
<div class="social-icons">

@if($fbLink)
<a href="{{ $fbLink }}" target="_blank" rel="noopener" aria-label="Facebook">
<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#1877F2" d="M22 12a10 10 0 1 0-11.5 9.9v-7H8v-3h2.5V9.5c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.3.2 2.3.2v2.5h-1.3c-1.3 0-1.7.8-1.7 1.6V12H17l-.4 3h-2.5v7A10 10 0 0 0 22 12z"/></svg>
</a>
@endif

@if($igLink)
<a href="{{ $igLink }}" target="_blank" rel="noopener" aria-label="Instagram">
<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#E1306C" d="M7 2C4 2 2 4 2 7v10c0 3 2 5 5 5h10c3 0 5-2 5-5V7c0-3-2-5-5-5H7zm5 5a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm6-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>
</a>
@endif

@if($ytLink)
<a href="{{ $ytLink }}" target="_blank" rel="noopener" aria-label="YouTube">
<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#FF0000" d="M21.8 8s-.2-1.4-.8-2a2.9 2.9 0 0 0-2-1C16.2 4.5 12 4.5 12 4.5h0s-4.2 0-7 .5a2.9 2.9 0 0 0-2 1c-.6.6-.8 2-.8 2S2 9.6 2 11.3v1.4C2 14.4 2.2 16 2.2 16s.2 1.4.8 2a2.9 2.9 0 0 0 2 1c2.8.5 7 .5 7 .5s4.2 0 7-.5a2.9 2.9 0 0 0 2-1c.6-.6.8-2 .8-2s.2-1.6.2-3.3v-1.4C22 9.6 21.8 8 21.8 8zM10 14.5v-5l5 2.5-5 2.5z"/></svg>
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

{{-- 🔔 ZGODY --}}
<div class="glass-box">
<details>
<summary>🔔 Zgody marketingowe i RODO</summary>
<div>
@if($client->sms_marketing_consent)
✅ Zgoda na SMS marketing
@else
❌ Brak zgody na SMS marketing
@endif
</div>
</details>
</div>

</div>
</body>
</html>
