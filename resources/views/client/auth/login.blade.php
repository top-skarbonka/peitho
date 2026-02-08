<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Zaloguj się do swojego portfela kart</title>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<!-- ✅ FAVICON (IKONA BEZ TŁA) -->
<link rel="icon" type="image/png" href="{{ asset('icons/icon-512.png') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
}

body{
    min-height:100vh;
    background:linear-gradient(180deg,#6f47ff 0%,#9b5cff 55%,#ff7aa2 100%);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:16px;
}

.login-container{
    width:100%;
    max-width:380px;
    text-align:center;
}

.login-card{
    background:#fff;
    border-radius:32px;
    padding:30px 22px;
    box-shadow:0 25px 60px rgba(0,0,0,.25);
}

/* ✅ LOGO */
.logo{
    width:160px;
    margin:0 auto 18px;
    display:block;
}

.icon-box{
    width:56px;
    height:56px;
    border-radius:18px;
    background:#f3efff;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 16px;
    font-size:26px;
}

h1{
    font-size:1.45rem;
    color:#222;
}

.subtitle{
    color:#888;
    font-size:.9rem;
    margin:6px 0 22px;
}

/* ===== INPUTS ===== */
.form-group{
    text-align:left;
    margin-bottom:14px;
    position:relative;
}

label{
    font-size:.8rem;
    color:#555;
    margin-bottom:4px;
    display:block;
}

input{
    width:100%;
    padding:14px 14px;
    border-radius:14px;
    border:1px solid #ddd;
    font-size:1rem;
    outline:none;
    transition:.2s;
}

input:focus{
    border-color:#8b5cf6;
    box-shadow:0 0 0 3px rgba(139,92,246,.15);
}

/* ===== PASSWORD TOGGLE ===== */
.toggle-password{
    position:absolute;
    right:14px;
    top:36px;
    cursor:pointer;
    color:#888;
    font-size:1.1rem;
}

/* ===== REMEMBER ===== */
.remember{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:.85rem;
    color:#555;
    margin:10px 0 16px;
}

.remember input{
    width:16px;
    height:16px;
}

/* ===== BUTTON ===== */
button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:999px;
    background:linear-gradient(90deg,#7c3aed,#ec4899);
    color:#fff;
    font-size:1rem;
    font-weight:700;
    cursor:pointer;
    transition:.2s;
}

button:hover{
    transform:translateY(-1px);
    box-shadow:0 12px 30px rgba(0,0,0,.25);
}

/* ===== ERROR ===== */
.error-box{
    background:#fee2e2;
    color:#991b1b;
    padding:10px 14px;
    border-radius:14px;
    font-size:.85rem;
    margin-bottom:14px;
}
</style>
</head>

<body>

<div class="login-container">

    <div class="login-card">

        <!-- ✅ LOGO LOOPLY -->
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
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="np. 509 123 456"
                    required
                >
            </div>

            <div class="form-group">
                <label>Hasło</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="••••••••"
                    required
                >
                <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
            </div>

            <div class="remember">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Zapamiętaj mnie</label>
            </div>

            <button type="submit">
                Zaloguj się
            </button>

        </form>

    </div>

</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('password');
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
</script>

</body>
</html>
