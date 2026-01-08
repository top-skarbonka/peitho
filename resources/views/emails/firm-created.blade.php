<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dostęp do panelu – Peitho</title>
</head>
<body style="margin:0;padding:0;background:#f4f6fb;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding:40px 10px;">
            <table width="600" style="background:#ffffff;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,.08);">
                <tr>
                    <td style="padding:40px;">
                        <h1 style="margin:0 0 10px;color:#4f46e5;">
                            🎉 Witaj {{ $firm->name }}
                        </h1>

                        <p style="color:#555;font-size:15px;line-height:1.6;">
                            Twoja firma została pomyślnie dodana do programu lojalnościowego <strong>Peitho</strong>.
                        </p>

                        <div style="background:#f3f4ff;padding:20px;border-radius:10px;margin:25px 0;">
                            <h3 style="margin-top:0;color:#4f46e5;">🔐 Dane logowania</h3>
                            <p style="margin:6px 0;"><strong>ID firmy:</strong> {{ $firm->firm_id }}</p>
                            <p style="margin:6px 0;"><strong>Email:</strong> {{ $firm->email }}</p>
                            <p style="margin:6px 0;"><strong>Hasło:</strong> {{ $password }}</p>
                        </div>

                        <p style="text-align:center;margin:30px 0;">
                            <a href="{{ url('/company/login') }}"
                               style="background:#4f46e5;color:#fff;text-decoration:none;
                                      padding:14px 28px;border-radius:30px;font-weight:bold;display:inline-block;">
                                👉 Zaloguj się do panelu
                            </a>
                        </p>

                        <p style="color:#777;font-size:13px;line-height:1.6;">
                            Po zalogowaniu możesz zarządzać kartami lojalnościowymi, klientami oraz statystykami.
                        </p>

                        <hr style="border:none;border-top:1px solid #eee;margin:30px 0;">

                        <p style="color:#999;font-size:12px;">
                            Jeśli masz pytania – odpisz na tego maila.<br>
                            Zespół <strong>Peitho 💜</strong>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
