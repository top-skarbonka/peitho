<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Witaj w Looply – zacznij w kilka minut</title>
</head>
<body style="background:#f5f6fa;padding:30px;font-family:Arial,sans-serif;">

<div style="max-width:520px;margin:auto;background:#ffffff;border-radius:16px;padding:28px;">

    <!-- LOGO -->
    <div style="text-align:center;margin-bottom:20px;">
        <img src="{{ asset('branding/logo.png') }}" alt="Looply" style="max-height:48px;">
    </div>

    <h2 style="color:#6a5af9;margin-top:0;">
        Witamy w Looply 🚀
    </h2>

    <p>
        Cześć <b>{{ $firm->name }}</b> 👋
    </p>

    <p>
        Świetnie, że jesteś z nami!  
        <b>Looply</b> to prosty system kart lojalnościowych, który pomaga
        <b>zwiększać powroty klientów</b> – bez aplikacji, bez papieru i bez komplikacji.
    </p>

    <hr style="border:none;border-top:1px solid #eee;margin:24px 0;">

    <h3 style="margin-top:0;">⚡ Jak zacząć w 3 krokach</h3>

    <ol style="padding-left:18px;">
        <li>
            <b>Zaloguj się do panelu firmy</b><br>
            <a href="{{ url('/company/login') }}">
                {{ url('/company/login') }}
            </a>
        </li>
        <li style="margin-top:10px;">
            <b>Wygeneruj link lub QR do rejestracji klientów</b><br>
            (Panel → Karty lojalnościowe)
        </li>
        <li style="margin-top:10px;">
            <b>Zacznij rozdawać karty klientom przy zakupach</b><br>
            Klient zapisuje się w 30 sekund 📱
        </li>
    </ol>

    <hr style="border:none;border-top:1px solid #eee;margin:24px 0;">

    <h3 style="margin-top:0;">💬 Jak zachęcić klientów? (gotowe teksty)</h3>

    <div style="background:#f8f9ff;padding:16px;border-radius:12px;font-size:14px;">

        <p style="margin-top:0;">
            <b>1️⃣ Klasycznie przy kasie</b><br>
            „Mamy darmową kartę lojalnościową – zbiera Pan/Pani punkty i odbiera nagrody.
            Wystarczy numer telefonu.”
        </p>

        <p>
            <b>2️⃣ Na szybką decyzję</b><br>
            „Do tego zakupu mogę dodać kartę lojalnościową – kolejna wizyta będzie się bardziej opłacać.”
        </p>

        <p style="margin-bottom:0;">
            <b>3️⃣ Dla stałych klientów</b><br>
            „Wprowadziliśmy cyfrowe karty lojalnościowe – bez papieru, wszystko w telefonie.
            Chce Pan/Pani dołączyć?”
        </p>

    </div>

    <hr style="border:none;border-top:1px solid #eee;margin:24px 0;">

    <p>
        📈 Firmy korzystające z kart lojalnościowych Looply notują
        <b>więcej powrotów klientów już po kilku tygodniach</b>.
    </p>

    <p>
        Jeśli będziesz mieć pytania lub wątpliwości – jesteśmy do dyspozycji 💬
    </p>

    <p style="margin-top:30px;color:#666;font-size:13px;">
        Zespół Looply<br>
        <b>Twój system kart lojalnościowych</b>
    </p>

</div>

</body>
</html>
