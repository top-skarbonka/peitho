<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja karty</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<h2>Rejestracja karty – {{ $firm->name }}</h2>

<form method="POST">
    @csrf

    <div>
        <label>Telefon</label><br>
        <input type="text" name="phone" required>
    </div>

    <div>
        <label>Hasło</label><br>
        <input type="password" name="password" required>
    </div>

    <button type="submit">Zarejestruj kartę</button>
</form>

</body>
</html>
