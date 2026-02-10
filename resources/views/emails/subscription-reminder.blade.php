<div style="font-family:Arial,sans-serif;background:#0f172a;padding:40px;">
    
    <div style="max-width:600px;margin:auto;background:#111827;border-radius:16px;padding:40px;box-shadow:0 10px 40px rgba(0,0,0,.4);color:#f8fafc;">

        <!-- LOGO -->
        <div style="text-align:center;margin-bottom:30px;">
            <img src="{{ asset('branding/logo-mail-white.png') }}"
                 alt="Looply"
                 style="max-width:180px;">
        </div>

        <h1 style="margin-top:0;font-size:26px;">
            Zaczynamy z Looply 🚀
        </h1>

        <p style="font-size:16px;color:#e5e7eb;">
            Cześć <strong>{{ $firm->name }}</strong>,
        </p>

        <p style="font-size:16px;color:#e5e7eb;">
            Właśnie uruchomiliśmy dla Ciebie <strong>okres startowy w Looply</strong>.
            To czas, w którym możesz spokojnie poznać system, przetestować go w praktyce
            i zacząć zbierać pierwszych lojalnych klientów.
        </p>

        <div style="background:#1f2937;border-radius:12px;padding:18px;margin:25px 0;">
            <strong>Co warto wiedzieć na start:</strong>
            <ul style="margin:12px 0;padding-left:18px;">
                <li>✅ Masz <strong>7 dni okresu przygotowawczego</strong></li>
                <li>✅ W tym czasie system działa w pełni</li>
                <li>✅ Możesz rejestrować klientów i dodawać punkty</li>
                <li>✅ Abonament zacznie się liczyć dopiero po tym okresie</li>
            </ul>
        </div>

        <p style="font-size:16px;color:#e5e7eb;">
            W kolejnych dniach podpowiemy Ci:
        </p>

        <ul style="color:#e5e7eb;">
            <li>jak najłatwiej zachęcać klientów do kart lojalnościowych</li>
            <li>jak mówić o Looply przy kasie (gotowe teksty)</li>
            <li>jak zwiększać powroty klientów bez rabatów</li>
        </ul>

        <div style="text-align:center;margin:35px 0;">
            <a href="{{ url('/company/login') }}"
               style="background:#6a5af9;color:white;padding:16px 28px;border-radius:10px;
               text-decoration:none;font-weight:bold;display:inline-block;">
                Przejdź do panelu →
            </a>
        </div>

        <p style="font-size:14px;color:#9ca3af;">
            Jeśli masz pytania — po prostu odpisz na tego maila.
            Jesteśmy tu, żeby pomóc 🙂
        </p>

        <hr style="border:none;border-top:1px solid #374151;margin:30px 0;">

        <p style="font-size:13px;color:#9ca3af;">
            Looply — Twój system kart lojalnościowych bez papieru 💜
        </p>

    </div>

</div>
