<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ $firm->name }} – karta lojalnościowa</title>

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
    max-width:420px;
}

.card{
    background:#fff;
    border-radius:32px;
    padding:26px 22px;
    box-shadow:0 25px 60px rgba(0,0,0,.25);
    text-align:center;
}

.card h1{
    font-size:1.4rem;
    color:#222;
}

.subtitle{
    color:#777;
    font-size:.9rem;
    margin:6px 0 18px;
}

/* ===== STARS ===== */
.stars-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:14px;
    justify-items:center;
    margin:22px 0;
}

.star{
    width:48px;
    height:48px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    color:#d1d5db;
}

.star.active{
    color:#facc15;
}

/* ===== INFO ===== */
.info{
    margin-top:12px;
    font-size:.95rem;
    color:#333;
}
.info strong{
    font-weight:800;
}
</style>
</head>

<body>

<div class="container">
    <div class="card">

        <h1>{{ $firm->name }}</h1>
        <div class="subtitle">Twoja karta lojalnościowa</div>

        <div class="stars-grid">
            @for($i = 1; $i <= $maxStamps; $i++)
                <div class="star {{ $i <= $current ? 'active' : '' }}">
                    ★
                </div>
            @endfor
        </div>

        <div class="info">
            Masz <strong>{{ $current }}</strong> z <strong>{{ $maxStamps }}</strong> naklejek<br>
            @if($current < $maxStamps)
                Do nagrody brakuje <strong>{{ $maxStamps - $current }}</strong>
            @else
                🎉 Nagroda gotowa do odbioru
            @endif
        </div>

    </div>
</div>

</body>
</html>
