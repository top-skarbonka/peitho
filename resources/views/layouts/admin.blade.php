<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Peitho – Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body{
            margin:0;
            font-family:system-ui,-apple-system,BlinkMacSystemFont;
            background:#f4f6ff;
        }
        header{
            background:#111827;
            color:#fff;
            padding:16px 28px;
            display:flex;
            align-items:center;
            justify-content:space-between;
        }
        .logo{
            font-weight:800;
            font-size:18px;
        }
        nav a{
            color:#e5e7eb;
            text-decoration:none;
            margin-left:22px;
            font-weight:600;
        }
        nav a:hover{
            color:#fff;
        }
        main{
            padding:30px;
        }
        .logout-btn{
            background:none;
            border:0;
            color:#e5e7eb;
            font-weight:600;
            cursor:pointer;
        }
        .logout-btn:hover{
            color:#fff;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">🛠 Peitho Admin</div>

    <nav>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.firms.index') }}">Firmy</a>
        <a href="{{ route('admin.firms.create') }}">Dodaj firmę</a>

        <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
            @csrf
            <button class="logout-btn">Wyloguj</button>
        </form>
    </nav>
</header>

<main>
    @yield('content')
</main>

</body>
</html>
