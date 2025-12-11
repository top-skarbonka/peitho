<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Firmy — Peitho</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0f3ff, #e8ecff);
            min-height: 100vh;
            display: flex;
        }

        /* LEWY PANEL */
        .sidebar {
            width: 260px;
            background: #ffffff;
            padding: 30px 20px;
            box-shadow: 6px 0 18px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            color: #3c4aad;
        }

        .menu a {
            display: block;
            padding: 12px 15px;
            border-radius: 10px;
            text-decoration: none;
            margin-bottom: 8px;
            font-size: 15px;
            color: #3c3c3c;
            transition: 0.2s;
        }

        .menu a:hover {
            background: #eef1ff;
            color: #2c39d1;
            transform: translateX(4px);
        }

        /* GŁÓWNY PANEL */
        .content {
            margin-left: 260px;
            padding: 40px;
            width: calc(100% - 260px);
        }

        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.08);
            text-align: center;
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <!-- LEWY PANEL -->
    <div class="sidebar">
        <div class="logo">🏢 Panel Firmy</div>

        <div class="menu">
            <a href="/company/dashboard">📊 Dashboard</a>
            <a href="#">🎁 Vouchery</a>
            <a href="#">⭐ Karty lojalnościowe</a>

            <a href="/company/points">💎 Dodaj punkty</a>

            <!-- NOWOŚĆ -->
            <a href="/company/transactions">📜 Historia transakcji</a>

            <a href="#">📈 Statystyki</a>
            <a href="#">⚙️ Ustawienia</a>

            <a href="/company/logout" style="color:#d13c3c;">🚪 Wyloguj</a>
        </div>
    </div>

    <!-- GŁÓWNE OKNO -->
    <div class="content">
        @yield('content')
    </div>

</body>
</html>
