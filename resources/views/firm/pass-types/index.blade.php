@extends('layouts.firm')

@section('content')

<h2>🎫 Typy karnetów</h2>

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<hr>

<h3>Dodaj nowy typ karnetu</h3>

<form method="POST" action="{{ route('company.pass_types.store') }}">
    @csrf

    <div>
        <label>Nazwa:</label><br>
        <input type="text" name="name" required>
    </div>

    <div style="margin-top:10px;">
        <label>Ilość wejść:</label><br>
        <input type="number" name="entries" min="1" required>
    </div>

    <div style="margin-top:10px;">
        <label>Cena (grosze, opcjonalnie):</label><br>
        <input type="number" name="price_gross_cents" min="0">
    </div>

    <div style="margin-top:15px;">
        <button type="submit">➕ Dodaj typ</button>
    </div>
</form>

<hr style="margin:30px 0;">

<h3>Lista typów</h3>

@if($passTypes->isEmpty())
    <p>Brak typów karnetów.</p>
@else
    <table border="1" cellpadding="6">
        <tr>
            <th>Nazwa</th>
            <th>Wejścia</th>
            <th>Cena (gr)</th>
        </tr>
        @foreach($passTypes as $type)
            <tr>
                <td>{{ $type->name }}</td>
                <td>{{ $type->entries }}</td>
                <td>{{ $type->price_gross_cents ?? '-' }}</td>
            </tr>
        @endforeach
    </table>
@endif

@endsection
