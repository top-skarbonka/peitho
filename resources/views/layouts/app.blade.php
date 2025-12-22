<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel admina – Peitho')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f5f7fb;
        }

        .topbar {
            background: #4f46e5;
            color: #fff;
            padding: 14px 24px;
            font-weight: 600;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        input, select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #ddd;
            font-size: 15px;
        }

        button {
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 14px;
            padding: 14px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            opacity: .9;
        }

        .error {
            color: #dc2626;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>

    <div class="topbar">
        Peitho – Panel administratora
    </div>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
