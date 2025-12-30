<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Karta lojalnościowa – Peitho</title>

<style>
:root{
    --bg1:#f4f6fb;
    --card:#fffdf7;
    --line:rgba(0,0,0,.08);
    --muted:rgba(0,0,0,.55);
}

/* TŁO */
body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:var(--bg1);
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Inter,Arial;
}

/* KARTA */
.card{
    width:520px;
    border-radius:22px;
    background:linear-gradient(135deg,#f7f2ff,#fff8e3);
    box-shadow:0 30px 70px rgba(0,0,0,.18);
    overflow:hidden;
}

/* HEADER */
.header{
    display:flex;
    align-items:center;
    gap:14px;
    padding:20px 22px 14px;
}

.avatar{
    width:44px;
    height:44px;
    border-radius:50%;
    background:#f0e9c8;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:900;
}

.title{
    font-size:22px;
    font-weight:900;
    margin:0;
}

.subtitle{
    font-size:14px;
    color:var(--muted);
    margin-top:2px;
}

.hr{
    height:1px;
    background:var(--line);
    margin:0 22px;
}

/* STEMPLES */
.stamps{
    padding:22px;
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:16px;
}

.stamp{
    width:100%;
    aspect-ratio:1/1;
    border-radius:50%;
    background:#f2f2f2;
    box-shadow:
        inset 0 3px 6px rgba(0,0,0,.12),
        0 2px 6px rgba(255,255,255,.7);
}

/* ZIELONE */
.stamp.filled{
    background:radial-gradient(circle at 30% 30%,#b6e59a,#6fbf4b);
    box-shadow:
        inset 0 4px 8px rgba(255,255,255,.4),
        inset 0 -4px 8px rgba(0,0,0,.18);
}

/* ZŁOTE */
.card.complete{
    background:linear-gradient(135deg,#fff6cc,#ffe08a);
}

.stamp.gold{
    background:radial-gradient(circle at 30% 30%,#fff2b0,#d4a20f);
    box-shadow:
        inset 0 4px 8px rgba(255,255,255,.55),
        inset 0 -4px 10px rgba(0,0,0,.35);
}

/* NAGRODA */
.reward{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    font-weight:800;
    padding:10px 0;
}

/* DOLNY PASEK */
.footer{
    display:flex;
    align-items:center;
    gap:18px;
    padding:16px 22px;
    background:#fffdf8;
}

/* QR */
.qr{
    width:64px;
    height:64px;
    background:#fff;
    border-radius:14px;
    box-shadow:0 10px 22px rgba(0,0,0,.18);
    display:flex;
    align-items:center;
    justify-content:center;
}

/* INFO */
.info{
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.label{
    font-size:12px;
    color:var(--muted);
}

.code{
    font-size:18px;
    font-weight:900;
}

/* PRAWA STRONA */
.right{
    margin-left:auto;
    display:flex;
    flex-direction:column;
    gap:6px;
    text-align:right;
}

.addr{
    font-size:12px;
    color:var(--muted);
}

/* IKONY */
.icons{
    display:flex;
    gap:8px;
    justify-content:flex-end;
}

.icon{
    width:28px;
    height:28px;
    border-radius:9px;
    background:#fff;
    border:1px solid var(--line);
    box-shadow:0 6px 14px rgba(0,0,0,.15);
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    font-size:14px;
    font-weight:900;
}

.icon.fb{ color:#1877F2; }
.icon.ig{
    color:#fff;
    background:linear-gradient(135deg,#f58529,#dd2a7b,#8134af,#515bd4);
}
.icon.google{
    background:linear-gradient(
        90deg,
        #4285F4 0%,
        #DB4437 25%,
        #F4B400 50%,
        #4285F4 75%,
        #0F9D58 100%
    );
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}
</style>
</head>

<body>

@php
    $total = 12;
    $stampsCount = $stampsCount ?? 0;
    $complete = $stampsCount >= $total;
@endphp

<div class="card {{ $complete ? 'complete' : '' }}">

    <div class="header">
        <div class="avatar">🌸</div>
        <div>
            <div class="title">{{ $companyName ?? 'Kwiaciarnia Ania' }}</div>
            <div class="subtitle">Karta lojalnościowa · Peitho</div>
        </div>
    </div>

    <div class="hr"></div>

    <div class="stamps">
        @for($i=1;$i<=$total;$i++)
            <div class="stamp
                {{ $complete ? 'gold' : ($i <= $stampsCount ? 'filled' : '') }}">
            </div>
        @endfor
    </div>

    @if($complete)
        <div class="reward">🎁 Nagroda gotowa do odbioru</div>
    @endif

    <div class="footer">
        <div class="qr">
            {!! QrCode::size(52)->generate($code ?? '000000000') !!}
        </div>

        <div class="info">
            <div class="label">Pokaż przy kasie</div>
            <div class="code">{{ $code ?? '000000000' }}</div>
        </div>

        <div class="right">
            <div class="addr">📍 {{ $address ?? 'ul. Kwiatowa 12' }}</div>
            <div class="addr">📞 {{ $phone ?? '500 600 700' }}</div>

            <div class="icons">
                <a class="icon fb" href="{{ $facebook ?? '#' }}" target="_blank">f</a>
                <a class="icon ig" href="{{ $instagram ?? '#' }}" target="_blank">ig</a>
                <a class="icon google" href="{{ $google ?? '#' }}" target="_blank">G</a>
            </div>
            <div style="font-size:11px;color:var(--muted);">Zostaw nam opinię</div>
        </div>
    </div>

</div>

</body>
</html>
