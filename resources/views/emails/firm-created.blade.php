<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Twoje konto w Peitho</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0"
                   style="background:#ffffff;border-radius:14px;box-shadow:0 20px 40px rgba(0,0,0,.08);overflow:hidden;">

                <!-- HEADER -->
                <tr>
                    <td style="background:linear-gradient(135deg,#6a5af9,#8f5cff,#ff7ab6);
                               padding:28px;color:#ffffff;">
                        <h1 style="margin:0;font-size:24px;">🎉 Witaj w Peitho</h1>
                        <p style="margin:8px 0 0;font-size:14px;opacity:.95;">
                            Twoje konto firmowe zostało utworzone
                        </p>
                    </td>
                </tr>

                <!-- CONTENT -->
                <tr>
                    <td style="padding:32px;color:#1f2937;font-size:15px;line-height:1.6;">

                        <p>
                            Cześć <strong>{{ $firm->name }}</strong>,
                        </p>

                        <p>
                            Twoje konto w systemie <strong>Peitho</strong> jest już aktywne.
                            Od teraz możesz korzystać z kart lojalnościowych,
                            budować bazę klientów i śledzić realne efekty programu.
                        </p>

                        <!-- CREDENTIALS -->
                        <div style="margin:24px 0;padding:20px;
                                    background:#f1f3ff;border-radius:12px;">

                            <h3 style="margin:0 0 12px;font-size:16px;">
                                🔐 Dane startowe do panelu
                            </h3>

                            <p style="margin:6px 0;">
                                <strong>ID firmy:</strong><br>
                                <span style="font-size:16px;">{{ $firm->firm_id }}</span>
                            </p>

                            <p style="margin:6px 0;">
                                <strong>Hasło startowe:</strong><br>
                                <span style="font-size:16px;">{{ $plainPassword }}</span>
                            </p>

                            <p style="margin-top:12px;font-size:13px;color:#555;">
                                Ze względów bezpieczeństwa zalecamy zmianę hasła po pierwszym logowaniu.
                            </p>
                        </div>

                        <!-- BUTTON -->
                        <div style="text-align:center;margin:30px 0;">
                            <a href="{{ url('/company/login') }}"
                               style="display:inline-block;padding:14px 28px;
                                      background:#6a5af9;color:#ffffff;
                                      text-decoration:none;border-radius:10px;
                                      font-weight:600;">
                                🔐 Zaloguj się do panelu
                            </a>
                        </div>

                        <!-- INFO -->
                        <hr style="border:none;border-top:1px solid #e5e7eb;margin:30px 0;">

                        <h3 style="font-size:16px;margin-bottom:10px;">📊 Co możesz zrobić po zalogowaniu?</h3>
                        <ul style="padding-left:18px;margin:0;color:#374151;">
                            <li>zarządzać kartami lojalnościowymi klientów</li>
                            <li>nabijać naklejki i punkty</li>
                            <li>śledzić statystyki i powroty klientów</li>
                            <li>kontrolować skuteczność promocji</li>
                        </ul>

                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td style="background:#f8fafc;padding:18px;
                               text-align:center;font-size:12px;color:#6b7280;">
                        © {{ date('Y') }} Peitho — system kart lojalnościowych<br>
                        W razie pytań napisz do nas: <a href="mailto:kontakt@looply.net.pl"
                        style="color:#6a5af9;text-decoration:none;">kontakt@looply.net.pl</a>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
