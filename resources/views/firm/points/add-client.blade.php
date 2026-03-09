@extends('layouts.app')

@section('content')

<div class="container">

<h2>Dodaj punkty klientowi</h2>

@if(session('success'))
<div style="background:#d4edda;padding:10px;margin-bottom:15px;border-radius:6px;">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('company.points.client.store') }}">
@csrf

<div style="margin-bottom:15px;">
<label>Numer telefonu klienta</label>

<input
type="text"
name="phone"
placeholder="np. 732287103"
required
style="padding:8px;width:250px;"
>
</div>

<div style="margin-bottom:15px;">
<label>Kwota paragonu</label>

<input
type="number"
name="amount"
min="1"
required
style="padding:8px;width:150px;"
>
</div>

<button type="submit" style="padding:10px 20px;">
Dodaj punkty
</button>

</form>

</div>

@endsection
