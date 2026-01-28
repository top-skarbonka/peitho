<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Peitho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e9e6ff, #fcecff);
            color: #111827;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* =========================
           🧠 ADMIN BAR – SaaS STYLE
        ========================== */
        .admin-bar {
            position: sticky;
            top: 0;
            z-index: 999;
            backdrop-filter: blur(14px);
            background: rgba(17, 24, 39, 0.85);
            border-bottom: 1px solid rgba(255,255,255,.08);
            padding: 14px 24px;
        }

        .admin-bar-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .admin-left,
        .admin-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-logo {
            font-weight: 800;
            color: #fff;
            letter-spacing: .3px;
            margin-right: 12px;
        }

        .admin-link {
            padding: 8px 14px;
            border-radius: 12px;
            color: #e5e7eb;
            font-weight: 600;
            font-size: 14px;
            transition: all .15s ease;
        }

        .admin-link:hover {
            background: rgba(255,255,255,.12);
            color: #fff;
        }

        .admin-link.primary {
            background: linear-gradient(135deg, #6a5af9, #ff5fa2);
            color: #fff;
        }

        .admin-link.primary:hover {
            opacity: .9;
        }

        .admin-logout button {
            background: transparent;
            border: 1px solid rgba(255,255,255,.2);
            color: #fff;
            padding: 8px 14px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s ease;
        }

        .admin-logout button:hover {
            background: rgba(255,255,255,.12);
        }
    </style>
</head>
<body>

{{-- 🔐 ADMIN PANEL --}}
@if(session('admin_ok'))
    <div class="admin-bar">
        <div class="admin-bar-inner">

            <div class="admin-left">
                <div class="admin-logo">🛠 Peitho Admin</div>

                {{-- 📊 DASHBOARD --}}
                <a href="{{ route('admin.dashboard') }}" class="admin-link">
                    📊 Dashboard
                </a>

                {{-- 🏢 FIRMY --}}
                <a href="{{ route('admin.firms.index') }}" class="admin-link">
                    🏢 Firmy
                </a>

                {{-- ➕ NOWA FIRMA --}}
                <a href="{{ route('admin.firms.create') }}" class="admin-link primary">
                    ➕ Nowa firma
                </a>
            </div>

            <div class="admin-right admin-logout">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit">Wyloguj</button>
                </form>
            </div>

        </div>
    </div>
@endif

{{-- TREŚĆ STRONY --}}
@yield('content')

</body>
</html>
