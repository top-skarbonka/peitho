<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Zaloguj się do swojego portfela kart</title>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<link rel="icon" type="image/png" href="{{ asset('icons/icon-512.png') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;}
body{min-height:100vh;background:linear-gradient(180deg,#6f47ff 0%,#9b5cff 55%,#ff7aa2 100%);display:flex;align-items:center;justify-content:center;padding:16px;}
.login-container{width:100%;max-width:380px;text-align:center;}
.login-card{background:#fff;border-radius:32px;padding:30px 22px;box-shadow:0 25px 60px rgba(0,0,0,.25);}
.logo{width:160px;margin:0 auto 18px;display:block;}
.icon-box{width:56px;height:56px;border-radius:18px;background:#f3efff;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:26px;}
h1{font-size:1.45rem;color:#222;}
.subtitle{color:#888;font-size:.9rem;margin:6px 0 22px;}
.form-group{text-align:left;margin-bottom:14px;position:relative;}
label{font-size:.8rem;color:#555;margin-bottom:4px;display:block;}
input{width:100%;padding:14px;border-radius:14px;border:1px solid #ddd;font-size:1rem;}
input:focus{border-color:#8b5cf6;box-shadow:0 0 0 3px rgba(139,92,246,.15);}
.toggle-password{position:absolute;right:14px;top:36px;cursor:pointer;color:#888;font-size:1.1rem;}
.remember{display:flex;align-items:center;gap:8px;font-size:.85rem;color:#555;margin:10px 0 10px;}
button{width:100%;padding:14px;border:none;border-radius:999px;background:linear-gradient(90deg,#7c3aed,#ec4899);color:#fff;font-size:1rem;font-weight:700;cursor:pointer;}
.error-box{background:#fee2e2;color:#991b1b;padding:10px 14px;border-radius:14px;font-size:.85rem;margin-bottom:14px;}
.reset-link{font-size:.8rem;color:#7c3aed;text-decoration:underline;cursor:pointer;margin-bottom:14px;display:block;text-align:right;}

/* 🔥 NOWE UX */
.input-error{
    border:2px solid red !important;
}
.error-text{
    color:red;
    font-size:12px;
    margin-top:6px;
}
</style>
</head>

<body>

<div class="login-container">

    <div class="login-card">

        <img src="{{ asset('branding/logo.png') }}" alt="Looply" class="logo">

        <div class="icon-box">🔐</div>

        <h1>Zaloguj się</h1>
        <div class="subtitle">Zaloguj się do swojego portfela kart lojalnościowych</div>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('client.login.submit') }}">
            @csrf

            <div class="form-group">
                <label>Numer telefonu</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
                <div id="phoneError" class="error-text" style="display:none;">
                    📱 Najpierw wpisz swój numer telefonu
                </div>
            </div>

            <div class="form-group">
                <label>Hasło</label>
                <input type="password" name="password" id="password" required>
                <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
            </div>

            <div class="remember">
                <input type="checkbox" name="remember">
                <label>Zapamiętaj mnie</label>
            </div>

            <span class="reset-link" onclick="resetPassword()">Nie pamiętasz hasła?</span>

            <button type="submit">Zaloguj się</button>
        </form>

        <form method="POST" action="{{ route('client.reset_password') }}" id="resetForm" style="display:none;">
            @csrf
            <input type="hidden" name="phone" id="resetPhone">
        </form>

    </div>

</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
});

function resetPassword() {
    const phoneInput = document.getElementById('phone');
    const errorBox = document.getElementById('phoneError');
    const phone = phoneInput.value;

    if (!phone) {
        phoneInput.classList.add('input-error');
        errorBox.style.display = 'block';
        phoneInput.focus();
        return;
    }

    document.getElementById('resetPhone').value = phone;
    document.getElementById('resetForm').submit();
}

// 🔥 usuwa błąd jak użytkownik zacznie pisać
document.getElementById('phone').addEventListener('input', function () {
    this.classList.remove('input-error');
    document.getElementById('phoneError').style.display = 'none';
});
</script>

</body>
</html>
