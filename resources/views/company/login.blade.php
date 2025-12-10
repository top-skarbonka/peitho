<!DOCTYPE html>
<html>
<head>
    <title>Logowanie firmy</title>
</head>
<body>
    <h1>Logowanie firmy</h1>

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
