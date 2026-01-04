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
            color: #222;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }
    </style>
</head>
<body>

    @yield('content')

</body>
</html>
