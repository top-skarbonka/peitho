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

/* ===== WRAPPER ===== */
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

/* ===== KARTA ===== */
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

/* ===== STEMPLA ===== */
.stickers-grid{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:12px;
    margin-bottom:18px;
    padding-bottom:18px;
    border-bottom:1px solid #eee;
    justify-items:center;
}

.sticker{
    width:100%;
    aspect-ratio:1;
    border-radius:50%;
    background:#ececec;
}
.sticker.active{
    background:#1fb655;
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

/* ===== INFO PANEL ===== */
.info-panel{
    background:rgba(255,255,255,.18);
    backdrop-filter:blur(10px);
    border-radius:26px;
    padding:18px 16px;
    color:#fff;
}

.contact-info{
    font-size:.95rem;
    line-height:1.45;
    margin-bottom:14px;
}

/* ===== SOCIAL ===== */
.social-buttons{
    display:flex;
    gap:12px;
    justify-content:center;
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

.social-btn i{
    font-size:1.3rem;
}

.social-fb i{ color:#1877f2; }
.social-ig i{ color:#e1306c; }

</style>
</head>

<body>

<div class="container">

    {{-- STATUS --}}
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
                <div class="sticker {{ $i <= $current ? 'active' : '' }}"></div>
            @endfor
        </div>

        <div class="qr-section">
            {!! $qr !!}
            <div class="code-label">Kod</div>
            <div class="code-number">{{ $displayCode }}</div>
        </div>
    </div>

    {{-- INFO --}}
    <div class="info-panel">
        <div class="contact-info">
            <i class="fa-solid fa-phone"></i> {{ $firm->phone }} <br>
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

</div>

</body>
</html>
