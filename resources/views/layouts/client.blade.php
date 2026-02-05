<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Karta lojalnościowa')</title>

    <link rel="icon" href="{{ asset('assets/branding/favicon.ico') }}">
</head>

<body style="
    min-height:100vh;
    background:linear-gradient(180deg,#fbcfe8 0%,#f9a8d4 50%,#f472b6 100%);
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding:20px 16px 40px;
">
    <div class="container" style="width:100%; max-width:400px;">
        @yield('content')

        {{-- STOPKA LOOPLY --}}
        <div style="margin-top:22px;">
            @include('partials.client-footer')
        </div>
    </div>
</body>
</html>
