<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Panel Firmy — Peitho')</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* ===== GLOBAL ===== */
        body {
            background: #f5f7fb;
        }

        /* ===== SAAS HELPERS (NIE PSUJĄ TAILWIND) ===== */
        .page-header h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .page-desc {
            color: #64748b;
            margin-bottom: 24px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,.05);
        }

        .stat-card span {
            display: block;
            font-size: 13px;
            color: #64748b;
            margin-bottom: 6px;
        }

        .stat-card strong {
            font-size: 28px;
            font-weight: 700;
        }

        .card-box {
            background: #fff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,.06);
            margin-bottom: 24px;
        }

        .card-box.highlight {
            border: 2px dashed #6366f1;
            background: #f8fafc;
        }

        .register-link-box {
            display: flex;
            gap: 12px;
            margin-top: 16px;
        }

        .register-link-box input {
            flex: 1;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #f8fafc;
            font-size: 14px;
        }

        .register-link-box button {
            background: #6366f1;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 12px 18px;
            cursor: pointer;
            font-weight: 600;
        }

        .register-link-box button:hover {
            background: #4f46e5;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .data-table th {
            text-align: left;
            font-size: 13px;
            color: #64748b;
            padding-bottom: 12px;
        }

        .data-table td {
            padding: 14px 0;
            border-top: 1px solid #e5e7eb;
        }

        .data-table .empty {
            text-align: center;
            color: #94a3b8;
            padding: 24px 0;
        }
    </style>
</head>

<body class="text-slate-800">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border-r border-slate-200 px-5 py-6">
        <div class="text-lg font-semibold mb-6">🏢 Panel Firmy</div>

        <nav class="space-y-1 text-sm">
            <a href="/company/dashboard" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                📊 <span>Dashboard</span>
            </a>

            <a href="/company/vouchers" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                🎁 <span>Vouchery</span>
            </a>

            <a href="/company/loyalty-cards" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                ⭐ <span>Karty stałego klienta</span>
            </a>

            <a href="/company/points" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                💎 <span>Dodaj punkty</span>
            </a>

            <a href="/company/transactions" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                📜 <span>Historia transakcji</span>
            </a>

            <a href="/company/statistics" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                📈 <span>Statystyki</span>
            </a>

            <a href="/company/settings" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100">
                ⚙️ <span>Ustawienia</span>
            </a>

            <div class="pt-3 mt-3 border-t border-slate-200">
                <a href="/company/logout" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-red-50 text-red-600">
                    🚪 <span>Wyloguj</span>
                </a>
            </div>
        </nav>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 px-8 py-8">
        @yield('content')
    </main>

</div>

</body>
</html>
