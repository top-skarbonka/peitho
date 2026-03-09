@extends('layouts.app')

@section('content')

<div class="container">

<h2>Program punktowy</h2>

@if(session('success'))
<div style="background:#d4edda;padding:10px;margin-bottom:15px;border-radius:6px;">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('company.points.add') }}">
@csrf

<div style="margin-bottom:15px;">
<label>Ile zł = 1 punkt</label>

<input
type="number"
name="points_per_currency"
value="{{ $settings->points_per_currency ?? 10 }}"
min="1"
required
style="padding:8px;width:200px;"
>

</div>

<button type="submit" style="padding:10px 20px;">
Zapisz ustawienia
</button>

</form>

<hr style="margin:30px 0;">

<a href="{{ route('company.points.client.form') }}">
<button style="padding:10px 20px;">
Dodaj punkty klientowi
</button>
</a>

<hr style="margin:30px 0;">

<p>Przykład działania:</p>

<ul>
<li>1 punkt = 10 zł</li>
<li>Klient kupuje za 120 zł</li>
<li>Dostaje 12 punktów</li>
</ul>

</div>

@endsection
