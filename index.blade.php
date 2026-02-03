@extends('firm.layout')

@section('content')
<h1>📷 Skanuj kartę</h1>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('company.scan') }}">
    @csrf
    <input
        type="text"
        name="code"
        autofocus
        placeholder="Zeskanuj kod (QR lub czytnik)"
        style="font-size:20px; padding:12px; width:100%;"
    >
</form>

<p style="margin-top:10px; color:#666;">
    Możesz użyć kamery w telefonie lub czytnika kodów na komputerze
</p>
@endsection
