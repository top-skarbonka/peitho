<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Looply | Dashboard</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #a855f7;
            --secondary: #ec4899;
            --glass: rgba(255,255,255,.06);
            --glass-border: rgba(255,255,255,.12);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: radial-gradient(circle at top right, #1e1b4b, #0f172a);
            color: #f8fafc;
            padding: 18px 14px 40px;
        }

        .dashboard {
            max-width: 1100px;
            margin: 0 auto;
        }

        header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: grid;
            place-items: center;
            box-shadow: 0 0 18px rgba(168,85,247,.45);
        }

        .logo-icon i {
            color: #fff;
            font-size: 1.3rem;
        }

        header h1 {
            font-size: 1.4rem;
            margin: 0;
        }

        header span {
            font-size: .85rem;
            opacity: .65;
        }

        .categories {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding: 6px 2px 14px;
            margin-bottom: 18px;
            scrollbar-width: none;
        }

        .categories::-webkit-scrollbar { display: none; }

        .category {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            font-size: .85rem;
            white-space: nowrap;
            cursor: pointer;
            transition: .2s;
        }

        .category.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-color: transparent;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px,1fr));
            gap: 20px;
        }

        .card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(14px);
            border-radius: 22px;
            padding: 22px;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content:'';
            position:absolute;
            top:-60%;
            right:-60%;
            width:220px;
            height:220px;
            background:linear-gradient(135deg,var(--primary),var(--secondary));
            filter:blur(90px);
            opacity:.15;
        }

        .card-content { position: relative; z-index: 1; }

        .brand {
            display:flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .badge {
            font-size:.75rem;
            padding:4px 10px;
            border-radius:999px;
            border:1px solid var(--secondary);
            color:var(--secondary);
            background:rgba(255,255,255,.08);
        }

        .desc {
            font-size:.9rem;
            opacity:.65;
        }

        .progress {
            margin: 18px 0 14px;
            height: 8px;
            background: rgba(255,255,255,.12);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress > div {
            height: 100%;
            background: linear-gradient(90deg,var(--primary),var(--secondary));
        }

        .qr-row {
            display:flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 14px;
        }

        .qr-btn {
            border:none;
            background:#fff;
            color:#000;
            font-weight:700;
            padding:10px 16px;
            border-radius:12px;
            display:flex;
            gap:8px;
            align-items:center;
            cursor:pointer;
            text-decoration: none;
        }

        .add-card {
            border:2px dashed var(--glass-border);
            border-radius:22px;
            display:grid;
            place-items:center;
            min-height:180px;
            color:var(--glass-border);
        }

        @keyframes fadeIn {
            from { opacity:0; transform:translateY(6px); }
            to { opacity:1; transform:none; }
        }
    </style>
</head>
<body>

<div class="dashboard">

    <header>
        <div class="logo-icon">
            <i class="fa-solid fa-infinity"></i>
        </div>
        <div>
            <h1>Looply</h1>
            <span>Witaj ponownie, {{ $client->name ?? '👋' }}</span>
        </div>
    </header>

    {{-- 🎉 FIRST TIME USER EXPERIENCE --}}
    @if(session('first_card_welcome'))
        <div style="
            margin-bottom:18px;
            padding:16px 18px;
            border-radius:18px;
            background:linear-gradient(135deg,#7c3aed,#ec4899);
            color:#fff;
            box-shadow:0 12px 30px rgba(0,0,0,.35);
        ">
            <div style="font-size:1.1rem;font-weight:800;margin-bottom:6px;">
                🎉 Witaj w swoim portfelu kart lojalnościowych
            </div>

            <div style="font-size:.9rem;opacity:.9;margin-bottom:12px;">
                Tutaj będą wszystkie Twoje karty z kawiarni, salonów i sklepów.
            </div>

            <span style="
                display:inline-block;
                padding:10px 16px;
                border-radius:999px;
                background:#fff;
                color:#000;
                font-weight:700;
                font-size:.85rem;
            ">
                ➕ Dodaj kolejną kartę
            </span>
        </div>
    @endif

    {{-- KATEGORIE --}}
    <div class="categories">
        <div class="category active" data-category="all">Wszystkie</div>
        @foreach($grouped as $category => $cards)
            <div class="category" data-category="{{ $category }}">
                {{ ucfirst(str_replace('_',' ', $category)) }}
            </div>
        @endforeach
    </div>

    {{-- KARTY --}}
    <div class="cards-grid">
        @foreach($grouped as $category => $cards)
            @foreach($cards as $item)
                @php $percent = ($item['current'] / $item['max']) * 100; @endphp
                <div class="card" data-category="{{ $category }}">
                    <div class="card-content">
                        <div class="brand">
                            {{ $item['card']->firm->name }}
                            <span class="badge">{{ $item['current'] }} / {{ $item['max'] }}</span>
                        </div>

                        <div class="desc">
                            {{ $item['rewardReady'] ? '🎉 Nagroda gotowa!' : 'Zbieraj dalej punkty' }}
                        </div>

                        <div class="progress">
                            <div style="width: {{ $percent }}%"></div>
                        </div>

                        <div class="qr-row">
                            <a href="{{ route('client.loyalty.card.show', $item['card']->id) }}" class="qr-btn">
                                <i class="fa-solid fa-qrcode"></i> Pokaż kartę
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

        <div class="add-card">
            <div style="text-align:center">
                <i class="fa-solid fa-plus" style="font-size:2.2rem"></i>
                <p style="margin-top:10px">Dodaj nową kartę</p>
            </div>
        </div>
    </div>
</div>

<script>
    const categories = document.querySelectorAll('.category');
    const cards = document.querySelectorAll('.card');

    categories.forEach(cat => {
        cat.addEventListener('click', () => {
            categories.forEach(c => c.classList.remove('active'));
            cat.classList.add('active');

            const selected = cat.dataset.category;

            cards.forEach(card => {
                if (selected === 'all' || card.dataset.category === selected) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn .25s ease';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>

</body>
</html>
