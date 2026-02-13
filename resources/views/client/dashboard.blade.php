<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <title>Looply – Twój portfel kart lojalnościowych</title>

    <link rel="icon" type="image/png" href="{{ asset('branding/icon.png') }}?v=20260210">
    <link rel="shortcut icon" href="{{ asset('branding/icon.png') }}?v=20260210">
    <link rel="apple-touch-icon" href="{{ asset('branding/icon.png') }}?v=20260210">

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
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: radial-gradient(circle at top right, #1e1b4b, #0f172a);
            color: var(--text-main);
            padding: 18px 14px 40px;
        }

        .dashboard { max-width: 1100px; margin: 0 auto; }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 22px;
        }

        .header-left { display: flex; align-items: center; gap: 14px; }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: grid;
            place-items: center;
            box-shadow: 0 0 18px rgba(168,85,247,.45);
        }

        .privacy-link {
            font-size: .85rem;
            padding: 8px 14px;
            border-radius: 999px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            text-decoration: none;
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
            transition: .2s;
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

        .card.hidden {
            display: none;
        }

        .brand { font-size: 1.15rem; font-weight: 800; margin-bottom: 4px; }
        .sub { font-size: .9rem; color: var(--text-soft); margin-bottom: 12px; }

        .progress {
            height: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.14);
            overflow: hidden;
            margin-bottom: 14px;
        }

        .progress span {
            display: block;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-id { font-size: .75rem; color: var(--text-muted); }

        .show-btn {
            background: #fff;
            color: #111;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: .85rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .add-card {
            border: 2px dashed rgba(255,255,255,.18);
            min-height: 170px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--text-soft);
            padding: 22px;
        }
    </style>
</head>
<body>

<div class="dashboard">

<header>
    <div class="header-left">
        <div class="logo-icon">
            <i class="fa-solid fa-infinity"></i>
        </div>
        <div>
            <h1>Looply</h1>
            <span>Witaj ponownie, {{ $client->name ?? '👋' }}</span>
        </div>
    </div>

    <a href="{{ route('client.consents') }}" class="privacy-link">
        ⚙️ Prywatność i zgody
    </a>
</header>

<div class="categories">
    <div class="category active" data-filter="all">Wszystkie</div>
    @foreach($grouped as $category => $cards)
        <div class="category" data-filter="{{ $category }}">
            {{ ucfirst(str_replace('_',' ', $category)) }}
        </div>
    @endforeach
</div>

<div class="cards-grid">
@foreach($grouped as $category => $cards)
    @foreach($cards as $item)
        @php $percent = ($item['current'] / $item['max']) * 100; @endphp

        <div class="card" data-category="{{ $category }}">
            <div class="brand">{{ $item['card']->firm->name }}</div>
            <div class="sub">
                Zbieraj dalej punkty ({{ $item['current'] }}/{{ $item['max'] }})
            </div>

            <div class="progress">
                <span style="width: {{ $percent }}%"></span>
            </div>

            <div class="card-footer">
                <div class="card-id">ID: {{ $item['card']->id }}</div>

                <a href="{{ route('client.loyalty.card.show', $item['card']->id) }}" class="show-btn">
                    <i class="fa-solid fa-qrcode"></i>
                    Pokaż kartę
                </a>
            </div>
        </div>
    @endforeach
@endforeach

<div class="card add-card" data-category="all">
    <div>
        <strong>Twój portfel jest gotowy na więcej</strong><br><br>
        Zapytaj przy zakupach:<br>
        <em>„Czy mogę dostać kartę lojalnościową w Looply?”</em>
    </div>
</div>

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
