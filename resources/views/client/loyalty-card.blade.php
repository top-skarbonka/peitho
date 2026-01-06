<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Karta lojalnościowa – {{ $firm->name }}</title>

<style>
*{box-sizing:border-box}
body{
    margin:0;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:radial-gradient(circle at top,#ffffff,#eef1f6);
    font-family:-apple-system,BlinkMacSystemFont,Inter,Segoe UI,Roboto,Arial;
}

/* KARTA */
.card{
    width:420px;
    border-radius:28px;
    padding:22px;
    background:linear-gradient(135deg,#fff6ee,#f9f1ff);
    box-shadow:
        0 45px 90px rgba(0,0,0,.18),
        inset 0 1px 0 rgba(255,255,255,.7);
}

/* HEADER */
.header{
    display:flex;
    align-items:center;
    gap:14px;
}

.logo{
    width:48px;
    height:48px;
    border-radius:50%;
    background:#ffe16a;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    box-shadow:0 12px 24px rgba(0,0,0,.18);
}

.title{
    font-size:22px;
    font-weight:800;
}
.subtitle{
    font-size:13px;
    color:#666;
}

/* LINIA */
.hr{
    height:1px;
    background:rgba(0,0,0,.08);
    margin:16px 0 18px;
}

/* STEMPLE */
.stamps{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:14px;
    margin-bottom:18px;
}

.stamp{
    aspect-ratio:1/1;
    border-radius:50%;
    background:#f1f1f1;
    box-shadow:
        inset 0 4px 8px rgba(0,0,0,.12),
        0 3px 6px rgba(255,255,255,.9);
}

/* DOL */
.footer{
    display:flex;
    align-items:center;
    gap:16px;
}

/* QR */
.qr-box{
    padding:10px;
    border-radius:18px;
    background:#fff;
    box-shadow:0 16px 34px rgba(0,0,0,.28);
}

.code-info{
    flex:1;
}
.label{
    font-size:13px;
    color:#666;
}
.code{
    font-size:22px;
    font-weight:900;
    letter-spacing:1px;
}

/* PRAWA */
.right{
    text-align:right;
    font-size:13px;
    color:#555;
}

.icons{
    display:flex;
    gap:8px;
    justify-content:flex-end;
    margin-top:6px;
}

.icon{
    width:34px;
    height:34px;
    border-radius:12px;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
    text-decoration:none;
    box-shadow:0 10px 18px rgba(0,0,0,.22);
}

.fb{color:#1877F2}
.ig{
    background:linear-gradient(135deg,#f58529,#dd2a7b,#8134af,#515bd4);
    color:#fff;
}
.google{
    background:#f4b400;
    color:#000;
}

.opinia{
    font-size:11px;
    color:#777;
    margin-top:4px;
}
</style>
</head>

<body>

<div class="card">

    <div class="header">
        <div class="logo">🌸</div>
        <div>
            <div class="title">{{ $firm->name }}</div>
            <div class="subtitle">Karta lojalnościowa · Peitho</div>
        </div>
    </div>

    <div class="hr"></div>

    <div class="stamps">
        @for($i=1;$i<=12;$i++)
            <div class="stamp"></div>
        @endfor
    </div>

    <div class="footer">
        <div class="qr-box">
            {!! QrCode::size(88)->generate($card->code) !!}
        </div>

        <div class="code-info">
            <div class="label">Pokaż przy kasie</div>
            <div class="code">{{ $card->code }}</div>
        </div>

        <div class="right">
            @if($firm->address)
                📍 {{ $firm->address }}<br>
            @endif
            @if($firm->phone)
                ☎ {{ $firm->phone }}
            @endif

            <div class="icons">
                <a class="icon fb" href="#">f</a>
                <a class="icon ig" href="#">ig</a>
                <a class="icon google" href="#">G</a>
            </div>

            <div class="opinia">Zostaw nam opinię</div>
        </div>
    </div>

</div>

</body>
</html>
