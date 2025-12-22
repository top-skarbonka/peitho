<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Admin – logowanie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{
            font-family:system-ui;
            background:#f4f6ff;
            display:flex;
            align-items:center;
            justify-content:center;
            height:100vh;
        }
        .box{
            background:#fff;
            padding:30px;
            border-radius:16px;
            width:320px;
            box-shadow:0 20px 50px rgba(0,0,0,.15);
        }
        h1{margin:0 0 20px;}
        input,button{
            width:100%;
            padding:12px;
            border-radius:10px;
            border:1px solid #ddd;
            margin-bottom:12px;
            font-size:15px;
        }
        button{
            background:#4a3aff;
            color:#fff;
            font-weight:700;
            border:0;
        }
        .error{color:red;font-size:14px;}
    </style>
</head>
<body>
<div class="box">
    <h1>Admin</h1>

    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <input type="password" name="password" placeholder="Hasło admina">
        <button>Zaloguj</button>
    </form>
</div>
</body>
</html>
