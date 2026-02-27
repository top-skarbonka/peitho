@extends('layouts.firm')

@section('content')

<h2>🎫 Wydaj karnet klientowi</h2>

@if(session('success'))
    <div style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

@if($passTypes->isEmpty())
    <p style="color:red;">
        Najpierw musisz utworzyć typ karnetu.
        <a href="{{ route('company.pass_types') }}">Przejdź tutaj</a>
    </p>
@else

<form method="POST" action="{{ route('company.passes.issue') }}">
    @csrf

    <div>
        <label>Telefon klienta:</label><br>
        <input type="text" name="phone" required>
    </div>

    <div style="margin-top:10px;">
        <label>Typ karnetu:</label><br>
        <select name="pass_type_id" required>
            @foreach($passTypes as $type)
                <option value="{{ $type->id }}">
                    {{ $type->name }} ({{ $type->entries }} wejść)
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-top:15px;">
        <button type="submit">🎫 Wydaj karnet</button>
    </div>

</form>

@endif

@endsection
