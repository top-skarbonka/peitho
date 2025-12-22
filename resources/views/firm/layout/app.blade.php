<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel Firmy — Peitho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Inter, Roboto, sans-serif;
            background: linear-gradient(135deg, #f4f6ff, #eef1ff);
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #ffffff;
            padding: 24px 20px;
            box-shadow: 4px 0 24px rgba(0,0,0,.06);
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            padding: 10px 12px;
            margin-bottom: 6px;
            text-decoration: none;
            color: #374151;
            border-radius: 10px;
            font-size: 14px;
        }

        .sidebar a:hover {
            background: #eef2ff;
            color: #4338ca;
        }

        /* CONTENT */
        .content {
            flex: 1;
            padding: 28px 32px 40px;
        }
    </style>
</head>
<body>

<div class="layout">
    <aside class="sidebar">
        <h2>🏢 Panel Firmy</h2>
        <a href="/company/dashboard">📊 Dashboard</a>
        <a href="/company/vouchers">🎁 Vouchery</a>
        <a href="/company/loyalty-cards">⭐ Karty lojalnościowe</a>
        <a href="/company/points">💎 Dodaj punkty</a>
        <a href="/company/transactions">📜 Historia transakcji</a>
        <a href="/company/statistics">📈 Statystyki</a>
        <a href="/company/settings">⚙️ Ustawienia</a>
        <a href="/company/logout" style="color:#dc2626;">🚪 Wyloguj</a>
    </aside>

    <main class="content">
        @yield('content')
    </main>
</div>

</body>
</html>
