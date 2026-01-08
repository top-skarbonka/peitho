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
    grid-template-columns:repeat(6,1fr);
    gap:12px;
    margin-bottom:18px;
    padding-bottom:18px;
    border-bottom:1px solid #eee;
}

.sticker{
    width:100%;
    aspect-ratio:1;
    border-radius:50%;
    background:#ececec;
    transform:scale(.7);
    opacity:.4;
}

.sticker.active{
    background:#1fb655;
    animation:stampPop .45s cubic-bezier(.34,1.56,.64,1) forwards;
}

@keyframes stampPop{
    0%{ transform:scale(.6); opacity:0; }
    70%{ transform:scale(1.15); opacity:1; }
    100%{ transform:scale(1); opacity:1; }
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

/* ===== SOCIAL ===== */
.social-buttons{
    display:flex;
    gap:12px;
    margin-top:14px;
}
.social-btn{
    flex:1;
    background:#fff;
    border-radius:999px;
    padding:12px 18px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    font-weight:600;
    text-decoration:none;
    color:#111;
}
.social-btn i{ font-size:1.3rem; }
.social-fb i{ color:#1877f2; }
.social-ig i{ color:#e1306c; }

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
.timeline-text{ text-align:left; }
.timeline-text small{ opacity:.85; font-size:13px; }
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

{{-- KARTA --}}
<div class="card">
    <div class="icon-box">🎁</div>
    <h1>{{ $firm->name }}</h1>
    <div class="subtitle">Twoja karta lojalnościowa</div>

    <div class="stickers-grid">
        @for($i=1;$i<=$maxStamps;$i++)
            <div class="sticker"></div>
        @endfor
    </div>

    <div class="qr-section">
        {!! $qr !!}
        <div class="code-label">Kod</div>
        <div class="code-number">{{ $displayCode }}</div>
    </div>
</div>

{{-- ✅ NAJPIERW: DANE FIRMY --}}
<div class="glass-box">
    <div>
        <i class="fa-solid fa-phone"></i> {{ $firm->phone }}<br>
        <i class="fa-solid fa-location-dot"></i> {{ $firm->address }}
    </div>

    <div class="social-buttons">
        @if($firm->facebook_url)
        <a href="{{ $firm->facebook_url }}" class="social-btn social-fb">
            <i class="fab fa-facebook"></i> Facebook
        </a>
        @endif
        @if($firm->instagram_url)
        <a href="{{ $firm->instagram_url }}" class="social-btn social-ig">
            <i class="fab fa-instagram"></i> Instagram
        </a>
        @endif
    </div>
</div>

{{-- ✅ POTEM: POSTĘP DO NAGRODY --}}
<div class="glass-box">
    <strong>🎯 Postęp do nagrody</strong>

    <div style="margin-top:6px;">
        Masz <strong>{{ $current }}</strong> / 10 naklejek
    </div>

    <div class="progress-bar">
        <div class="progress-fill" style="width: {{ min(100, ($current/10)*100) }}%"></div>
    </div>

    @if($current < 10)
        Brakuje jeszcze <strong>{{ 10 - $current }}</strong> do nagrody 🎁
    @else
        🎉 Nagroda gotowa!
    @endif
</div>

{{-- HISTORIA (ZW IJANA) --}}
@if($card->stamps->count())
<div class="glass-box">
    <details>
        <summary>📊 Ostatnie wizyty</summary>

        <div class="timeline">
            @foreach($card->stamps->sortByDesc('created_at')->take(3) as $stamp)
            <div class="timeline-item">
                <div class="timeline-dot">✔</div>
                <div class="timeline-text">
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const total = {{ $current }};
    document.querySelectorAll('.sticker').forEach((el, i) => {
        if(i < total){
            setTimeout(() => el.classList.add('active'), i * 120);
        }
    });
});
</script>

</body>
</html>
