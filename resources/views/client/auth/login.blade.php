<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie klienta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="max-width:420px;margin:40px auto;font-family:sans-serif">

    <h2>🔐 Logowanie klienta</h2>

    @if ($errors->any())
        <div style="color:red;margin-bottom:10px">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('client.login.submit') }}">
        @csrf

        <div style="margin-bottom:10px">
            <label>Telefon</label><br>
            <input type="text" name="phone" value="{{ old('phone') }}" required>
        </div>

        <div style="margin-bottom:10px">
            <label>Hasło</label><br>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Zaloguj się</button>
    </form>

</body>
</html>
