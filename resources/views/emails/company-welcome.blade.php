<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Witaj w Looply</title>
</head>
<body style="background:#f5f6fa;padding:30px;font-family:Arial,sans-serif;">

<div style="max-width:520px;margin:auto;background:#ffffff;border-radius:16px;padding:28px;">
    <h2 style="color:#6a5af9;margin-top:0;">Witaj w Looply 💜</h2>

    <p>Cześć <b>{{ $firm->name }}</b> 👋</p>

    <p>
        Miło nam powitać Cię w systemie <b>Looply</b> – miejscu, gdzie
        programy lojalnościowe naprawdę pracują na Twój biznes 🚀
    </p>

    <h3>🔐 Twoje dane logowania</h3>

    <div style="background:#f1f5ff;padding:16px;border-radius:12px;">
        <p><b>ID firmy:</b> {{ $firm->slug }}</p>
        <p><b>Login:</b> {{ $firm->email }}</p>
        <p><b>Hasło startowe:</b> {{ $plainPassword }}</p>
        <p>
            <b>Panel logowania:</b><br>
            <a href="{{ url('/company/login') }}">
                {{ url('/company/login') }}
            </a>
        </p>
    </div>

    <p style="margin-top:20px;">
        👉 Po pierwszym logowaniu zalecamy zmianę hasła.
    </p>

    <p>
        Jeśli masz pytania – jesteśmy do dyspozycji 💬
    </p>

    <p style="margin-top:30px;color:#666;font-size:13px;">
        Zespół Looply
    </p>
</div>

</body>
</html>
