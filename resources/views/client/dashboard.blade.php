<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Looply – Twój portfel kart</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #a855f7;
            --secondary: #ec4899;
            --glass: rgba(255,255,255,.06);
            --glass-border: rgba(255,255,255,.12);
            --text-main: #f8fafc;
            --text-soft: rgba(248,250,252,.75);
            --text-muted: rgba(248,250,252,.55);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, sans-serif;
            background: radial-gradient(circle at top right, #1e1b4b, #0f172a);
            color: var(--text-main);
            padding: 18px 14px 40px;
        }

        .dashboard { max-width: 1100px; margin: 0 auto; }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: grid;
            place-items: center;
        }

        .top-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            height: 44px;
            padding: 0 14px;
            border-radius: 14px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            text-decoration: none;
            font-weight: 700;
            font-size: .9rem;
            backdrop-filter: blur(14px);
            transition: transform .12s ease, background .12s ease, border-color .12s ease;
            user-select: none;
        }

        .top-action:hover {
            background: rgba(255,255,255,.10);
            border-color: rgba(255,255,255,.18);
            transform: translateY(-1px);
        }

        .top-action i {
            opacity: .95;
        }

        @media (max-width: 520px) {
            .top-action span { display: none; }
            .top-action { width: 44px; padding: 0; border-radius: 14px; }
        }

        .categories {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .category {
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            font-size: .85rem;
            cursor: pointer;
        }

        .category.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-color: transparent;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px,1fr));
            gap: 22px;
        }

        .card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(14px);
            border-radius: 22px;
            padding: 22px;
        }

        .card.hidden { display:none; }

        .brand { font-size: 1.1rem; font-weight: 800; margin-bottom: 4px; }
        .sub { font-size: .9rem; color: var(--text-soft); margin-bottom: 12px; }

        .progress {
            height: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.14);
            overflow: hidden;
            margin-bottom: 14px;
        }

        .progress span {
            display:block;
            height:100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .card-footer {
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .show-btn {
            background:#fff;
            color:#111;
            padding:8px 14px;
            border-radius:12px;
            text-decoration:none;
            font-size:.85rem;
            font-weight:700;
        }
    </style>
</head>
<body>

<div class="dashboard">

<header>
    <div style="display:flex;align-items:center;gap:14px;">
        <div class="logo-icon">
            <i class="fa-solid fa-infinity"></i>
        </div>
        <div>
            <h1>Looply</h1>
            <span>Witaj {{ $client->name ?? '' }}</span>
        </div>
    </div>

    <a href="{{ url('/client/consents') }}" class="top-action" title="Zgody marketingowe">
        <i class="fa-solid fa-shield-halved"></i>
        <span>Zgody</span>
    </a>
</header>

{{-- ===================== KATEGORIE ===================== --}}
<div class="categories">
    <div class="category active" data-filter="all">Wszystkie</div>

    @if(isset($points) && $points->count())
        <div class="category" data-filter="points">
            ⭐ Punkty
        </div>
    @endif

    @foreach($grouped as $category => $cards)
        <div class="category" data-filter="{{ $category }}">
            {{ ucfirst(str_replace('_',' ', $category)) }}
        </div>
    @endforeach

    @if(isset($passes) && $passes->count())
        <div class="category" data-filter="passes">
            🎫 Karnety
        </div>
    @endif
</div>

{{-- ===================== GRID ===================== --}}
<div class="cards-grid">

{{-- PUNKTY --}}
@if(isset($points))
    @foreach($points as $p)

        <div class="card" data-category="points">
            <div class="brand">{{ $p->firm_name }}</div>

            <div class="sub">
                Program punktowy
            </div>

            <div class="sub">
                Saldo punktów:
                <strong>{{ $p->points }}</strong>
            </div>

            <div class="progress">
                <span style="width: 100%"></span>
            </div>
        </div>

    @endforeach
@endif

{{-- KARTY LOJALNOŚCIOWE --}}
@foreach($grouped as $category => $cards)
    @foreach($cards as $item)

        @php $percent = ($item['current'] / $item['max']) * 100; @endphp

        <div class="card" data-category="{{ $category }}">
            <div class="brand">{{ $item['card']->firm->name }}</div>

            <div class="sub">
                {{ $item['current'] }}/{{ $item['max'] }} naklejek
            </div>

            <div class="progress">
                <span style="width: {{ $percent }}%"></span>
            </div>

            <div class="card-footer">
                <a href="{{ route('client.card.show', $item['card']->id) }}" class="show-btn">
                    Pokaż kartę
                </a>
            </div>
        </div>

    @endforeach
@endforeach

{{-- KARNETY --}}
@if(isset($passes))
    @foreach($passes as $pass)

        @php
            $percent = ($pass->remaining_entries / $pass->total_entries) * 100;
        @endphp

        <div class="card" data-category="passes">

            <div class="brand">{{ $pass->firm_name }}</div>
            <div class="sub">{{ $pass->pass_name }}</div>

            <div class="sub">
                Pozostało wejść:
                <strong>{{ $pass->remaining_entries }}</strong>
                / {{ $pass->total_entries }}
            </div>

            <div class="progress">
                <span style="width: {{ $percent }}%"></span>
            </div>

        </div>

    @endforeach
@endif

</div>
</div>

<script>
document.querySelectorAll('.category').forEach(button => {
    button.addEventListener('click', function() {

        document.querySelectorAll('.category').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const filter = this.dataset.filter;

        document.querySelectorAll('.card').forEach(card => {
            if (filter === 'all' || card.dataset.category === filter) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    });
});
</script>

</body>
</html>
