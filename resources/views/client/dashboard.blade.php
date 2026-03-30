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

        .wallet-popup-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .74);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            z-index: 9999;
            overflow-y: auto;
        }

        .wallet-popup {
            width: 100%;
            max-width: 560px;
            max-height: calc(100vh - 36px);
            overflow-y: auto;
            background: rgba(15, 23, 42, .96);
            color: #f8fafc;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 30px 80px rgba(0,0,0,.40);
        }

        .wallet-popup-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: .82rem;
            font-weight: 800;
            background: rgba(168,85,247,.18);
            border: 1px solid rgba(168,85,247,.30);
            color: #f5d0fe;
            margin-bottom: 14px;
        }

        .wallet-popup-title {
            margin: 0 0 10px;
            font-size: 1.45rem;
            line-height: 1.2;
            font-weight: 900;
        }

        .wallet-popup-desc {
            margin: 0 0 18px;
            color: rgba(248,250,252,.82);
            line-height: 1.6;
            font-size: .96rem;
        }

        .wallet-popup-box {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 18px;
            padding: 16px 16px 14px;
            margin-bottom: 14px;
        }

        .wallet-popup-box h3 {
            margin: 0 0 10px;
            font-size: 1rem;
            font-weight: 800;
        }

        .wallet-popup-box ol,
        .wallet-popup-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .wallet-popup-box li {
            margin-bottom: 8px;
            color: rgba(248,250,252,.84);
            line-height: 1.5;
            font-size: .92rem;
        }

        .wallet-popup-highlight {
            color: #f9a8d4;
            font-weight: 700;
        }

        .wallet-popup-link {
            color: #c084fc;
            font-weight: 700;
            word-break: break-word;
        }

        .wallet-popup-btn {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 14px 16px;
            font-size: .98rem;
            font-weight: 800;
            cursor: pointer;
            color: #fff;
            background: linear-gradient(135deg, #a855f7, #ec4899);
            margin-top: 8px;
        }

        .wallet-popup-note {
            margin-top: 10px;
            text-align: center;
            font-size: .82rem;
            color: rgba(248,250,252,.58);
        }

        @media (max-width: 640px) {
            .wallet-popup-backdrop {
                padding: 12px;
                align-items: flex-start;
            }

            .wallet-popup {
                max-width: 100%;
                max-height: calc(100vh - 24px);
                padding: 20px;
                margin: auto 0;
            }

            .wallet-popup-title {
                font-size: 1.2rem;
            }

            .wallet-popup-desc {
                font-size: .92rem;
            }

            .wallet-popup-box h3 {
                font-size: .96rem;
            }

            .wallet-popup-box li {
                font-size: .89rem;
            }
        }
    </style>
</head>
<body>

<div id="walletInstallPopup" class="wallet-popup-backdrop">
    <div class="wallet-popup">
        <div class="wallet-popup-badge">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>WAŻNE – PRZECZYTAJ</span>
        </div>

        <h2 class="wallet-popup-title">Dodaj portfel Looply do ekranu głównego</h2>

        <p class="wallet-popup-desc">
            Dzięki temu będziesz mieć swój portfel zawsze pod ręką – szybciej otworzysz karty, punkty i karnety jak w mini aplikacji.
        </p>

        <div class="wallet-popup-box">
            <h3>📱 iPhone / iOS</h3>
            <ol>
                <li>Otwórz portfel w <strong>Safari</strong>.</li>
                <li>Kliknij ikonę <strong>Udostępnij</strong>.</li>
                <li>Wybierz <strong>„Do ekranu początkowego”</strong>.</li>
                <li>Zatwierdź przyciskiem <strong>„Dodaj”</strong>.</li>
            </ol>
        </div>

        <div class="wallet-popup-box">
            <h3>🤖 Android</h3>
            <ol>
                <li>Otwórz portfel w <strong>Chrome</strong>.</li>
                <li>Kliknij <strong>3 kropki</strong> w prawym górnym rogu.</li>
                <li>Wybierz <strong>„Dodaj do ekranu głównego”</strong> lub <strong>„Zainstaluj aplikację”</strong>.</li>
                <li>Potwierdź dodanie skrótu.</li>
            </ol>
        </div>

        <div class="wallet-popup-box">
            <h3>🔐 Ważna informacja</h3>
            <ul>
                <li>Zawsze możesz zalogować się do portfela, wpisując w przeglądarce adres <span class="wallet-popup-link">looply.net.pl/client/login</span>.</li>
                <li>Użyj danych podanych podczas rejestracji.</li>
            </ul>
        </div>

        <div class="wallet-popup-box">
            <h3>💜 Warto też włączyć zgody marketingowe</h3>
            <ul>
                <li>Dzięki temu możesz dostawać <span class="wallet-popup-highlight">informacje o promocjach, bonusach i nagrodach</span>.</li>
                <li>To przydatne, jeśli nie chcesz przegapić okazji w swoich programach lojalnościowych.</li>
                <li>Zgody możesz wygodnie zmienić później w zakładce <strong>„Zgody”</strong>.</li>
            </ul>
        </div>

        <button type="button" class="wallet-popup-btn" onclick="closeWalletInstallPopup()">
            Zamknij
        </button>

        <div class="wallet-popup-note">
            To okienko wyłączy się po kliknięciu.
        </div>
    </div>
</div>

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

function closeWalletInstallPopup() {
    localStorage.setItem('looply_wallet_popup_closed', '1');
    document.getElementById('walletInstallPopup').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    const wasClosed = localStorage.getItem('looply_wallet_popup_closed');

    if (!wasClosed) {
        document.getElementById('walletInstallPopup').style.display = 'flex';
    }
});
</script>

</body>
</html>
