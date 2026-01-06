<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Karta lojalnościowa – {{ $card->firm->name ?? 'Peitho' }}</title>

<style>
:root{
    --bg:#f4f6fb;
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
    background:var(--bg);
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Inter,Arial;
    padding:18px;
}

/* KARTA */
.card{
    width: min(520px, 100%);
    border-radius:22px;
    background:linear-gradient(135deg,#f7f2ff,#fff8e3);
    box-shadow:0 30px 70px rgba(0,0,0,.18);
    overflow:hidden;
}

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

/* STEMPLE */
.stamps{
    padding:22px;
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:14px;
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

.stamp.filled{
    background:radial-gradient(circle at 30% 30%,#b6e59a,#6fbf4b);
    box-shadow:
        inset 0 4px 8px rgba(255,255,255,.4),
        inset 0 -4px 8px rgba(0,0,0,.18);
}

.card.complete{
    background:linear-gradient(135deg,#fff6cc,#ffe08a);
}

.stamp.gold{
    background:radial-gradient(circle at 30% 30%,#fff2b0,#d4a20f);
    box-shadow:
        inset 0 4px 8px rgba(255,255,255,.55),
        inset 0 -4px 10px rgba(0,0,0,.35);
}

.reward{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    font-weight:800;
    padding:10px 0 0;
}

/* FOOTER */
.footer{
    display:flex;
    align-items:center;
    gap:16px;
    padding:16px 22px;
    background:#fffdf8;
    flex-wrap:wrap;
}

.qr{
    width:78px;
    height:78px;
    background:#fff;
    border-radius:16px;
    box-shadow:0 10px 22px rgba(0,0,0,.18);
    display:flex;
    align-items:center;
    justify-content:center;
    flex:0 0 auto;
}

.qr svg{
    width:60px;
    height:60px;
}

.info{
    display:flex;
    flex-direction:column;
    justify-content:center;
    min-width: 160px;
}

.label{
    font-size:12px;
    color:var(--muted);
}

.code{
    font-size:18px;
    font-weight:900;
}

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

.icons{
    display:flex;
    gap:8px;
    justify-content:flex-end;
    flex-wrap:wrap;
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
    color:#111;
    background:#fff;
}

.opinion{
    font-size:11px;
    color:var(--muted);
}

/* MOBILE */
@media (max-width: 420px){
    body{ padding:12px; }
    .header{ padding:18px 16px 12px; }
    .hr{ margin:0 16px; }
    .stamps{ padding:16px; gap:12px; }
    .footer{ padding:14px 16px; gap:12px; }
    .info{ min-width: 140px; }
    .right{ width:100%; margin-left:0; text-align:left; }
    .icons{ justify-content:flex-start; }
}
</style>
</head>

<body>
@php
    $total = $maxStamps ?? 12;
    $stampsCount = (int) ($current ?? 0);
    if ($stampsCount < 0) $stampsCount = 0;
    if ($stampsCount > $total) $stampsCount = $total;
    $complete = $stampsCount >= $total;

    $firm = $card->firm;

    // linki social (z DB, jeśli dodałeś kolumny)
    $facebook = $firm->facebook_url ?? null;
    $instagram = $firm->instagram_url ?? null;
    $google = $firm->google_url ?? null;

    $addr = trim(($firm->address ?? '') . (isset($firm->city) && $firm->city ? ', ' . $firm->city : ''));
    $phone = $firm->phone ?? '';
@endphp

<div class="card {{ $complete ? 'complete' : '' }}">

    <div class="header">
        <div class="avatar">🎁</div>
        <div>
            <div class="title">{{ $firm->name ?? 'Firma' }}</div>
            <div class="subtitle">Karta lojalnościowa · Peitho</div>
        </div>
    </div>

    <div class="hr"></div>

    <div class="stamps">
        @for($i=1;$i<=$total;$i++)
            <div class="stamp {{ $complete ? 'gold' : ($i <= $stampsCount ? 'filled' : '') }}"></div>
        @endfor
    </div>

    @if($complete)
        <div class="reward">🎁 Nagroda gotowa do odbioru</div>
    @endif

    <div class="footer">
        <div class="qr">
            {!! $qr !!}
        </div>

        <div class="info">
            <div class="label">Pokaż przy kasie</div>
            <div class="code">{{ $displayCode ?? '00000000' }}</div>
        </div>

        <div class="right">
            @if($addr)
                <div class="addr">📍 {{ $addr }}</div>
            @endif
            @if($phone)
                <div class="addr">📞 {{ $phone }}</div>
            @endif

            <div class="icons">
                @if($facebook)
                    <a class="icon fb" href="{{ $facebook }}" target="_blank" rel="noopener">f</a>
                @endif
                @if($instagram)
                    <a class="icon ig" href="{{ $instagram }}" target="_blank" rel="noopener">ig</a>
                @endif
                @if($google)
                    <a class="icon google" href="{{ $google }}" target="_blank" rel="noopener">G</a>
                @endif
            </div>

            @if($google)
                <div class="opinion">⭐ Zostaw nam opinię</div>
            @endif
        </div>
    </div>

</div>

</body>
</html>
