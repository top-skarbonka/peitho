<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>{{ $firm->name }} – Wejście</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            padding: 36px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
            text-align: center;
        }

        .logo {
            height: 28px;
            margin-bottom: 20px;
            opacity: 0.85;
        }

        h1 {
            font-size: 22px;
            margin: 0 0 6px 0;
            font-weight: 700;
            color: #111827;
        }

        .sub {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 24px;
        }

        .firm-phone {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .firm-phone a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            font-size: 16px;
            margin-bottom: 16px;
            transition: all 0.2s ease;
        }

        input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        button {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            background: #4f46e5;
            color: #fff;
            transition: all 0.2s ease;
        }

        button:hover {
            background: #4338ca;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .success {
            margin-top: 16px;
            background: #ecfdf5;
            color: #047857;
            padding: 12px;
            border-radius: 12px;
            font-size: 14px;
        }

        .error {
            margin-top: 16px;
            background: #fef2f2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 12px;
            font-size: 14px;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 24px 0;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

<div class="card">

    <img src="{{ asset('branding/logo.png') }}" class="logo">

    <h1>{{ $firm->name }}</h1>
    <div class="sub">System wejść aktywny 🟢</div>

    @if($firm->phone)
        <div class="firm-phone">
            Kontakt z obiektem:
            <a href="tel:{{ $firm->phone }}">{{ $firm->phone }}</a>
        </div>
    @endif

    <div class="divider"></div>

    <div id="phone-step">
        <input type="text" id="phone" placeholder="Wpisz numer telefonu">
        <button id="sendBtn" onclick="sendOtp()">Wyślij kod bezpieczeństwa</button>
    </div>

    <div id="otp-step" style="display:none;">
        <input type="text" id="otp" placeholder="Wpisz 6-cyfrowy kod SMS">
        <button id="verifyBtn" onclick="verifyOtp()">Potwierdź wejście</button>
    </div>

    <div id="message"></div>

    <div class="footer">
        Obsługiwane przez Looply
    </div>

</div>

<script>
const slug = "{{ $slug }}";
const token = "{{ $token }}";
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function showMessage(text, type = 'error') {
    const el = document.getElementById('message');
    el.className = type;
    el.innerText = text;
}

async function sendOtp() {
    const btn = document.getElementById('sendBtn');
    btn.disabled = true;

    try {
        const phone = document.getElementById('phone').value;

        const res = await fetch(`/public-pass/${slug}/${token}/send-otp`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ phone })
        });

        const data = await res.json();

        if (!data.success) {
            showMessage(data.message);
            btn.disabled = false;
            return;
        }

        document.getElementById('phone-step').style.display = 'none';
        document.getElementById('otp-step').style.display = 'block';
        showMessage("📩 Wysłaliśmy Ci kod bezpieczeństwa. Sprawdź SMS i wpisz go poniżej.", "success");

    } catch (e) {
        showMessage("⚠ Wystąpił problem z połączeniem. Spróbuj ponownie.");
        btn.disabled = false;
    }
}

async function verifyOtp() {
    const btn = document.getElementById('verifyBtn');
    btn.disabled = true;

    try {
        const phone = document.getElementById('phone').value;
        const otp = document.getElementById('otp').value;

        const res = await fetch(`/public-pass/${slug}/${token}/verify-otp`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ phone, otp })
        });

        const data = await res.json();

        if (!data.success) {
            showMessage(data.message);
            btn.disabled = false;
            return;
        }

        showMessage("✅ Wejście przyznane. Miłego korzystania!", "success");
        document.getElementById('otp-step').style.display = 'none';

    } catch (e) {
        showMessage("⚠ Wystąpił problem z połączeniem. Spróbuj ponownie.");
        btn.disabled = false;
    }
}
</script>

</body>
</html>
