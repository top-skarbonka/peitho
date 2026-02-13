<!DOCTYPE html>
<html>
<head>
    <title>Logowanie firmy</title>
</head>
<body>
    <h1>Logowanie firmy</h1>

    {{-- 🔥 SESJA WYGASŁA --}}
    @if(session('session_expired'))
        <div style="
            margin-bottom:15px;
            padding:12px;
            border-radius:10px;
            background:#eef2ff;
            border:1px solid #6366f1;
            color:#1e293b;
            font-weight:700;
        ">
            ⚡ Sesja wygasła. Zaloguj się ponownie i lecimy dalej 🚀
        </div>
    @endif

    @if($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('company.login.submit') }}">
        @csrf
        <label>ID firmy:</label><br>
        <input type="text" name="firm_id"><br><br>

        <label>Hasło:</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Zaloguj</button>
    </form>
</body>
</html>
