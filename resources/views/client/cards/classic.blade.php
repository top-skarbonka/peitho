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
.status-msg h2{
    font-size:1.05rem;
    font-weight:600;
}
.status-msg p{
    color:#00ff9c;
    font-size:.9rem;
    margin-top:4px;
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

.card h1{
    font-size:1.45rem;
    color:#222;
}

.subtitle{
    color:#888;
    font-size:.9rem;
    margin:6px 0 20px;
    border-bottom:1px solid #eee;
    padding-bottom:18px;
}

/* ===== STAMPS ===== */
.stickers-grid{
    display:grid;
    grid-template-columns:repeat(5, 1fr);
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

.sticker.last{
    animation:blink 1.8s ease-in-out infinite;
}

@keyframes stampPop{
    0%{ transform:scale(.6); opacity:0; }
    70%{ transform:scale(1.2); opacity:1; }
    100%{ transform:scale(1); opacity:1; }
}

@keyframes blink{
    0%,100%{ filter:brightness(1); }
    50%{ filter:brightness(1.7); }
}

/* ===== QR ===== */
.qr-section{
    padding-top:6px;
}
.qr-section svg{
    width:150px;
    height:150px;
}
.code-label{
    color:#777;
    font-size:.8rem;
    margin-top:8px;
}
.code-number{
    font-size:1.7rem;
    font-weight:800;
    letter-spacing:2px;
    color:#222;
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
    transition:width .6s ease;
}

/* ===== TIMELINE ===== */
details{ margin-top:10px; }
summary{ cursor:pointer; font-weight:600; }

.timeline{
    display:flex;
    flex-direction:column;
    gap:12px;
    margin-top:14px;
}
.timeline-item{
    display:flex;
    align-items:center;
    gap:12px;
    background:rgba(255,255,255,.25);
    padding:12px 14px;
    border-radius:16px;
}
.timeline-dot{
    width:36px;
    height:36px;
    border-radius:50%;
    background:#22c55e;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
    color:#fff;
}

/* ===== TOAST ===== */
.toast{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%) scale(.9);
    background:linear-gradient(180deg,#fff4b0,#facc15,#f59e0b);
    color:#3b2f00;
    padding:16px 26px;
    border-radius:999px;
    font-weight:800;
    box-shadow:0 20px 50px rgba(0,0,0,.35);
    opacity:0;
    pointer-events:none;
    transition:all .35s ease;
    z-index:9999;
}

.toast.show{
    opacity:1;
    transform:translate(-50%,-50%) scale(1);
}
</style>
</head>

<body>

<div class="container">

@if($current >= $maxStamps)
<div class="status-msg">
    <h2>Masz {{ $current }} z {{ $maxStamps }} naklejek</h2>
    <p>🎉 Nagroda gotowa do odbioru!</p>
</div>
@endif

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
        <div class="code-label">Kod</div>
        <div class="code-number">{{ $displayCode }}</div>
    </div>
</div>

<div class="glass-box">
    <i class="fa-solid fa-phone"></i> {{ $firm->phone }}<br>
    <i class="fa-solid fa-location-dot"></i> {{ $firm->address }}
</div>

<div class="glass-box">
    <strong>🎯 Postęp do nagrody</strong>
    <div style="margin-top:6px;">
        Masz <strong>{{ $current }}</strong> / {{ $maxStamps }} naklejek
    </div>
    <div class="progress-bar">
        <div class="progress-fill" style="width: {{ ($current/$maxStamps)*100 }}%"></div>
    </div>
</div>

@if($card->stamps->count())
<div class="glass-box">
    <details>
        <summary>📊 Ostatnie wizyty</summary>
        <div class="timeline">
            @foreach($card->stamps->sortByDesc('created_at')->take(3) as $stamp)
            <div class="timeline-item">
                <div class="timeline-dot">✔</div>
                <div>
                    <div>Ostatnia wizyta</div>
                    <small>{{ $stamp->created_at->format('d.m.Y H:i') }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </details>
</div>
@endif

</div>

<div id="toast" class="toast">⭐ Dodano nową naklejkę!</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const total = {{ $current }};
    const stickers = document.querySelectorAll('.sticker');
    const toast = document.getElementById('toast');

    stickers.forEach((el, i) => {
        if(i < total){
            setTimeout(() => {
                el.classList.add('active');
                if(i === total - 1){
                    el.classList.add('last');
                }
            }, i * 120);
        }
    });

    const prev = localStorage.getItem('looply_stamps');
    if(prev !== null && parseInt(prev) < total){
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2000);
    }
    localStorage.setItem('looply_stamps', total);
});
</script>

</body>
</html>
