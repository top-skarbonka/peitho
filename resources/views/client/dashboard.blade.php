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
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 14px;
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

        .privacy-link {
            font-size: .85rem;
            padding: 8px 14px;
            border-radius: 999px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            color: #f8fafc;
            text-decoration: none;
        }

        .privacy-link:hover {
            opacity: 1;
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
            padding: 10px 14px;
            border-radius: 999px;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            font-size: .85rem;
            cursor: pointer;
            transition: .2s;
            white-space: nowrap;
            color: #f8fafc;
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
        }

        .brand {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .desc {
            font-size: .9rem;
            line-height: 1.55;
            color: rgba(248,250,252,.85);
        }

        .desc ul {
            margin: 10px 0 10px 18px;
        }

        .desc li {
            margin-bottom: 6px;
        }

        .badge {
            display:inline-block;
            margin-top:12px;
            padding:6px 12px;
            border-radius:999px;
            font-size:.75rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color:#fff;
        }

        .privacy-title {
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 10px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        <a href="{{ route('client.dashboard') }}?view=privacy" class="privacy-link">
            ⚙️ Prywatność i zgody
        </a>
    </header>

    {{-- FTUE --}}
    @if(session('first_time_wallet'))
        <div style="
            margin-bottom:18px;
            padding:16px 18px;
            border-radius:18px;
            background:linear-gradient(135deg,#7c3aed,#ec4899);
            color:#fff;
        ">
            <strong>🎉 Witaj w swoim portfelu kart lojalnościowych</strong><br><br>
            Zbieraj <strong>naklejki</strong>, korzystaj z rabatów i odbieraj nagrody —  
            bez papierowych kart i chaosu.<br><br>
            👉 Wystarczy, że pokażesz kartę przy zakupach.
        </div>
    @endif

    {{-- TRYB: PRYWATNOŚĆ --}}
    @if(request('view') === 'privacy')

        <div class="card">
            <div class="privacy-title">📄 Prywatność i zgody marketingowe</div>

            <div class="desc">
                Każda karta lojalnościowa to <strong>osobna zgoda marketingowa</strong>.<br><br>

                Możesz:
                <ul>
                    <li>✔ cofnąć zgodę dla jednej firmy</li>
                    <li>✔ zostawić zgodę w innej</li>
                </ul>

                Twój numer telefonu jest jeden, ale decyzje podejmujesz
                <strong>osobno dla każdej karty</strong>.
            </div>

            <span class="badge">Zgodne z RODO</span>
        </div>

    @else

        {{-- KATEGORIE --}}
        <div class="categories">
            <div class="category active" data-category="all">Wszystkie</div>
            @foreach($grouped as $category => $cards)
                <div class="category" data-category="{{ $category }}">
                    {{ ucfirst(str_replace('_',' ', $category)) }}
                </div>
            @endforeach
        </div>

        {{-- GRID --}}
        <div class="cards-grid">
            @foreach($grouped as $category => $cards)
                @foreach($cards as $item)
                    <div class="card" data-category="{{ $category }}">
                        <div class="brand">{{ $item['card']->firm->name }}</div>
                        <div class="desc">
                            {{ $item['rewardReady'] ? '🎉 Nagroda gotowa!' : 'Zbieraj dalej naklejki' }}
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

    @endif

</div>

</body>
</html>
