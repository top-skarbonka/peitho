<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Karta lojalnościowa – {{ $firm->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Inter, sans-serif;
            background: linear-gradient(135deg, #f5f7ff, #eef1ff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #fff;
            width: 100%;
            max-width: 420px;
            border-radius: 22px;
            box-shadow: 0 30px 80px rgba(0,0,0,.12);
            padding: 28px;
        }

        .logo {
            text-align: center;
            margin-bottom: 16px;
            font-size: 22px;
            font-weight: 700;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-bottom: 22px;
        }

        .field {
            margin-bottom: 14px;
        }

        .field label {
            display: block;
            font-size: 13px;
            margin-bottom: 6px;
            color: #333;
        }

        .field input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid #d0d4ff;
            font-size: 15px;
            outline: none;
        }

        .field input:focus {
            border-color: #4a3aff;
            box-shadow: 0 0 0 2px rgba(74,58,255,.15);
        }

        .checkbox {
            display: flex;
            gap: 10px;
            font-size: 13px;
            margin-top: 10px;
        }

        .checkbox input {
            margin-top: 3px;
        }

        .submit {
            margin-top: 20px;
            width: 100%;
            padding: 14px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg,#4a3aff,#9b59ff);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(74,58,255,.35);
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 18px;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="logo">{{ $firm->name }}</div>

    <div class="subtitle">
        Dołącz do programu lojalnościowego<br>
        i zbieraj <strong>10 naklejek = nagroda 🎁</strong>
    </div>

    <form method="POST" action="{{ route('public.join.submit', $firm) }}">
        @csrf

        <div class="field">
            <label>Imię</label>
            <input type="text" name="name" required>
        </div>

        <div class="field">
            <label>Telefon (identyfikator karty)</label>
            <input type="text" name="phone" required>
        </div>

        <div class="field">
            <label>Kod pocztowy</label>
            <input type="text" name="postal_code" placeholder="np. 00-123" required>
        </div>

        <div class="field">
            <label>E-mail</label>
            <input type="email" name="email" required>
        </div>

        <div class="field">
            <label>Data urodzenia (opcjonalnie)</label>
            <input type="date" name="birthday">
        </div>

        <div class="checkbox">
            <input type="checkbox" name="terms" required>
            <span>Akceptuję regulamin</span>
        </div>

        <div class="checkbox">
            <input type="checkbox" name="privacy" required>
            <span>Akceptuję politykę prywatności</span>
        </div>

        <div class="checkbox">
            <input type="checkbox" name="marketing" value="1">
            <span>Wyrażam zgodę na informacje marketingowe</span>
        </div>

        <button class="submit">
            Odbierz kartę lojalnościową
        </button>
    </form>

    <div class="footer">
        {{ $firm->address ?? '' }}<br>
        {{ $firm->phone ?? '' }}
    </div>
</div>

</body>
</html>
