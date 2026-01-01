<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie firmy</title>
</head>
<body>

<h1>Logowanie firmy</h1>

@if ($errors->any())
    <div style="color:red;">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('company.login.submit') }}">
    @csrf

    <div>
        <label>ID firmy</label><br>
        <input type="text" name="firm_id" value="{{ old('firm_id') }}" required>
    </div>

    <br>

    <div>
        <label>Hasło</label><br>
        <input type="password" name="password" required>
    </div>

    <br>

    <button type="submit">Zaloguj</button>
</form>

</body>
</html>
