@extends('layouts.app')

@section('content')

<div class="container">

<h2>Program punktowy</h2>

@if(session('success'))
<div style="background:#d4edda;padding:10px;margin-bottom:15px;border-radius:6px;">
{{ session('success') }}
</div>
@endif

<div style="background:#f8f9fa;padding:15px;margin-bottom:20px;border-radius:8px;border:1px solid #e5e7eb;">
    <p style="margin:0 0 8px 0;"><strong>Aktualny przelicznik:</strong></p>
    <p style="margin:0;font-size:18px;">
        {{ $settings->points_per_currency ?? 10 }} zł = 1 punkt
    </p>
</div>

<p style="margin-bottom:20px;color:#666;">
    Przelicznik punktów jest ustawiany przez administratora systemu.
</p>

<hr style="margin:30px 0;">

<a href="{{ route('company.points.client.form') }}">
<button style="padding:10px 20px;">
Dodaj punkty klientowi
</button>
</a>

<hr style="margin:30px 0;">

<p>Przykład działania:</p>

<ul>
<li>1 punkt = {{ $settings->points_per_currency ?? 10 }} zł</li>
<li>Klient kupuje za 120 zł</li>
<li>Dostaje {{ floor(120 / ($settings->points_per_currency ?? 10)) }} punktów</li>
</ul>

</div>

@endsection
