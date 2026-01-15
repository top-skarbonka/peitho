<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<title>{{ $firm->name }} – karta lojalnościowa</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(180deg,#6f47ff 0%,#9b5cff 55%,#ff7aa2 100%);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:16px;
}

.container{
    width:100%;
    max-width:400px;
    text-align:center;
}

/* ===== STATUS ===== */
.status-msg{
    color:#fff;
    margin-bottom:16px;
}

/* ===== CARD ===== */
.card{
    background:#fff;
    border-radius:32px;
    padding:28px 20px;
    box-shadow:0 25px 60px rgba(0,0,0,.25);
    margin-bottom:16px;
}

.icon-box{
    width:54px;
    height:54px;
    border-radius:18px;
    background:#f3efff;
    display:flex;
    justify-content:center;
    align-items:center;
    margin:0 auto 14px;
    font-size:26px;
}

.subtitle{
    color:#888;
    font-size:.9rem;
    margin:6px 0 20px;
    border-bottom:1px solid #eee;
    padding-bottom:18px;
}

/* ===== GWIAZDKI ===== */
.stickers-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:14px;
    max-width:320px;
    margin:0 auto 18px;
    padding-bottom:18px;
    border-bottom:1px solid #eee;
    justify-items:center;
}

.sticker{
    width:46px;
    height:46px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
    color:#d1d5db;
    opacity:.55;
    transform:scale(.7);
}

.sticker.active{
    color:#facc15;
    opacity:1;
    text-shadow:
        0 0 6px rgba(250,204,21,.55),
        0 0 14px rgba(250,204,21,.35);
    animation:stampPop .45s cubic-bezier(.34,1.56,.64,1) forwards;
}

@keyframes stampPop{
    0%{ transform:scale(.6); opacity:0; }
    70%{ transform:scale(1.2); opacity:1; }
    100%{ transform:scale(1); opacity:1; }
}

/* ===== QR ===== */
.qr-section svg{ width:150px; height:150px; }
.code-number{
    font-size:1.7rem;
    font-weight:800;
    letter-spacing:2px;
}

/* ===== GLASS BOX ===== */
.glass-box{
    background:rgba(255,255,255,.18);
    backdrop-filter:blur(10px);
    border-radius:26px;
    padding:18px 16px;
    color:#fff;
    margin-bottom:16px;
}

/* ===== PROGRESS ===== */
.progress-bar{
    height:10px;
    background:rgba(255,255,255,.3);
    border-radius:999px;
    overflow:hidden;
    margin:10px 0;
}
.progress-fill{
    height:100%;
    background:linear-gradient(90deg,#22c55e,#4ade80);
    border-radius:999px;
}

/* ===== TIMELINE ===== */
.timeline-item{
    display:flex;
    gap:12px;
    background:rgba(255,255,255,.25);
    padding:12px 14px;
    border-radius:16px;
}

/* ===== UX ETAP II ===== */
.reward-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.55);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:9999;
    animation:fadeIn .4s ease;
}

.reward-box{
    background:#fff;
    border-radius:28px;
    padding:30px 24px;
    text-align:center;
    box-shadow:0 30px 80px rgba(0,0,0,.4);
    animation:pop .45s cubic-bezier(.34,1.56,.64,1);
}

.reward-box h2{
    font-size:1.5rem;
    margin-bottom:10px;
}

.confetti span{
    position:absolute;
    width:8px;
    height:14px;
    background:var(--c);
    animation:fall 1.6s linear forwards;
}

@keyframes fall{
    to{ transform:translateY(100vh) rotate(360deg); opacity:0; }
}
@keyframes fadeIn{ from{opacity:0} to{opacity:1} }
@keyframes pop{ from{transform:scale(.7)} to{transform:scale(1)} }
</style>
</head>

<body>

<div class="container">

<div class="card">
    <div class="icon-box">🎁</div>
    <h1>{{ $firm->name }}</h1>
    <div class="subtitle">Twoja karta lojalnościowa</div>

    <div class="stickers-grid">
        @for($i=1;$i<=$maxStamps;$i++)
            <div class="sticker">★</div>
        @endfor
    </div>

    <div class="qr-section">
        {!! $qr !!}
        <div class="code-number">{{ $displayCode }}</div>
    </div>
</div>

<div class="glass-box">
    <i class="fa-solid fa-phone"></i> {{ $firm->phone }}<br>
    <i class="fa-solid fa-location-dot"></i> {{ $firm->address }}
</div>

<div class="glass-box">
    <strong>🎯 Postęp do nagrody</strong>
    <div>Masz <strong>{{ $current }}</strong> / {{ $maxStamps }}</div>
    <div class="progress-bar">
        <div class="progress-fill" style="width: {{ ($current/$maxStamps)*100 }}%"></div>
    </div>
</div>

@if($card->stamps->count())
<div class="glass-box">
    <details>
        <summary>📊 Ostatnie wizyty</summary>
        @foreach($card->stamps->sortByDesc('created_at')->take(3) as $stamp)
        <div class="timeline-item">
            ✔ {{ $stamp->created_at->format('d.m.Y H:i') }}
        </div>
        @endforeach
    </details>
</div>
@endif

</div>

@if($current == $maxStamps)
<div class="reward-overlay">
    <div class="reward-box">
        <h2>🎉 Nagroda gotowa do odbioru!</h2>
        <p>Pokaż kartę obsłudze</p>
    </div>
    <div class="confetti">
        @for($i=0;$i<80;$i++)
            <span style="left:{{ rand(0,100) }}%;--c:{{ collect(['#facc15','#ec4899','#22c55e'])->random() }}"></span>
        @endfor
    </div>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded',()=>{
    const total={{ $current }};
    document.querySelectorAll('.sticker').forEach((el,i)=>{
        if(i<total){ setTimeout(()=>el.classList.add('active'),i*120); }
    });
});
</script>

</body>
</html>
