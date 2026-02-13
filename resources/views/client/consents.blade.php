<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Looply | Zgody marketingowe</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            display:flex;
            align-items:center;
            gap:14px;
            margin-bottom:24px;
        }

        .icon {
            width:44px;
            height:44px;
            border-radius:12px;
            background:linear-gradient(135deg,var(--primary),var(--secondary));
            display:grid;
            place-items:center;
        }

        h1 {
            font-size:1.4rem;
            margin:0;
        }

        .intro {
            font-size:.9rem;
            opacity:.9;
            line-height:1.5;
            margin-bottom:24px;
            max-width:800px;
        }

        .grid {
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap:16px;
        }

        @media (max-width: 1000px) {
            .grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 520px) {
            .grid { grid-template-columns: 1fr; }
        }

        .card {
            background:var(--glass);
            border:1px solid var(--glass-border);
            border-radius:18px;
            padding:18px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            min-height:140px;
        }

        .firm {
            font-weight:700;
            font-size:1rem;
            margin-bottom:6px;
        }

        .desc {
            font-size:.8rem;
            opacity:.75;
            line-height:1.4;
        }

        .footer {
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-top:18px;
        }

        .status {
            font-size:.75rem;
            opacity:.7;
        }

        .switch {
            position: relative;
            width: 48px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position:absolute;
            cursor:pointer;
            top:0;
            left:0;
            right:0;
            bottom:0;
            background:#555;
            transition:.2s;
            border-radius:999px;
        }

        .slider:before {
            position:absolute;
            content:"";
            height:20px;
            width:20px;
            left:3px;
            bottom:3px;
            background:white;
            transition:.2s;
            border-radius:50%;
        }

        input:checked + .slider {
            background:linear-gradient(135deg,var(--primary),var(--secondary));
        }

        input:checked + .slider:before {
            transform:translateX(22px);
        }

        .note {
            margin-top:28px;
            font-size:.75rem;
            opacity:.7;
            line-height:1.4;
        }
    </style>
</head>
<body>

<div class="container">

    <header>
        <div class="icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div>
            <h1>Zgody marketingowe</h1>
        </div>
    </header>

    <div class="intro">
        Twój numer telefonu jest jeden, ale <strong>zgody są osobne dla każdej firmy</strong>.<br>
        Możesz w każdej chwili cofnąć lub przywrócić zgodę — bez wpływu na inne karty.
    </div>

    <div class="grid">
        @foreach($cards as $card)
            <div class="card">
                <div>
                    <div class="firm">{{ $card->firm->name }}</div>
                    <div class="desc">
                        Zgoda na SMS / komunikację marketingową
                    </div>
                </div>

                <div class="footer">
                    <span class="status" id="status-{{ $card->id }}">
                        {{ $card->marketing_consent ? 'Aktywna' : 'Nieaktywna' }}
                    </span>

                    <label class="switch">
                        <input
                            type="checkbox"
                            data-id="{{ $card->id }}"
                            {{ $card->marketing_consent ? 'checked' : '' }}
                        >
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    <div class="note">
        ℹ️ Zmiany będą zapisywane automatycznie.<br>
        Każda karta ma swoją niezależną zgodę (RODO).
    </div>

</div>

<script>
document.querySelectorAll('.switch input').forEach(toggle => {
    toggle.addEventListener('change', function() {

        const cardId = this.dataset.id;
        const statusLabel = document.getElementById('status-' + cardId);
        const consent = this.checked ? 1 : 0;

        fetch(`/client/consents/${cardId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                marketing_consent: consent
            })
        })
        .then(res => res.json())
        .then(data => {
            statusLabel.textContent = consent ? 'Aktywna' : 'Nieaktywna';
        })
        .catch(() => {
            alert('Błąd zapisu. Spróbuj ponownie.');
            toggle.checked = !consent;
        });

    });
});
</script>

</body>
</html>
