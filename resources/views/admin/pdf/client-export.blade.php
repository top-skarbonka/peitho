<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        h2 {
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 16px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }

        .meta {
            font-size: 11px;
            color: #555;
            margin-bottom: 15px;
        }

        .box {
            background: #f8f8f8;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #eee;
        }

        .ok {
            color: green;
            font-weight: bold;
        }

        .no {
            color: red;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<h1>Raport danych klienta (RODO)</h1>

<div class="meta">
    System: Looply<br>
    Data wygenerowania: {{ now()->format('Y-m-d H:i:s') }}
</div>

<h2>Dane klienta</h2>

<div class="box">
    <strong>ID klienta:</strong> {{ $client->id }}<br>
    <strong>Telefon:</strong> {{ $client->phone }}<br>
    <strong>Email:</strong> {{ $client->email ?? '—' }}
</div>

<h2>Zgody marketingowe i formalne</h2>

<table>
    <tr>
        <th>Typ zgody</th>
        <th>Wartość</th>
        <th>Firma</th>
        <th>IP</th>
        <th>Data</th>
    </tr>
    @foreach($consents as $c)
    <tr>
        <td>
            @if($c->consent_type === 'sms_marketing')
                SMS marketing
            @elseif($c->consent_type === 'email_marketing')
                E-mail marketing
            @elseif($c->consent_type === 'terms_acceptance')
                Akceptacja regulaminu i polityki
            @else
                {{ $c->consent_type }}
            @endif
        </td>
        <td class="{{ $c->value ? 'ok' : 'no' }}">
            {{ $c->value ? 'TAK' : 'NIE' }}
        </td>
        <td>{{ $c->firm_name ?? $c->firm_id }}</td>
        <td>{{ $c->ip_address }}</td>
        <td>{{ $c->created_at }}</td>
    </tr>
    @endforeach
</table>

<h2>Punkty lojalnościowe</h2>

<table>
    <tr>
        <th>Firma</th>
        <th>Punkty</th>
    </tr>
    @foreach($points as $p)
    <tr>
        <td>{{ $p->firm_name ?? $p->firm_id }}</td>
        <td>{{ $p->points }}</td>
    </tr>
    @endforeach
</table>

<h2>Historia transakcji</h2>

<table>
    <tr>
        <th>Punkty</th>
        <th>Kwota</th>
        <th>Data</th>
    </tr>
    @foreach($transactions as $t)
    <tr>
        <td>{{ $t->points }}</td>
        <td>{{ $t->amount }}</td>
        <td>{{ $t->created_at }}</td>
    </tr>
    @endforeach
</table>

<div class="footer">
    Dokument wygenerowany automatycznie przez system Looply.<br>
    Dane przetwarzane zgodnie z RODO (UE 2016/679).<br>
    Klient ma prawo do wglądu, poprawy oraz usunięcia danych.
</div>

</body>
</html>
