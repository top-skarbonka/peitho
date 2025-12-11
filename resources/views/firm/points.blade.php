@extends('firm.layout.app')

@section('content')
<div class="card">
    <h1 style="font-size: 26px; margin-bottom: 10px;">Dodaj punkty klientowi ✨</h1>
    <p style="color:#666; margin-bottom: 25px;">
        Wpisz numer telefonu klienta oraz kwotę rachunku. System automatycznie przeliczy punkty.
    </p>

    {{-- KOMUNIKAT: SUKCES --}}
    @if(session('success'))
        <div style="
            padding: 12px 16px;
            border-radius: 10px;
            background:#e7f9f0;
            color:#137b3c;
            text-align:left;
            margin-bottom:18px;
            font-size:14px;
        ">
            {{ session('success') }}
        </div>
    @endif

    {{-- KOMUNIKAT: BŁĄD --}}
    @if(session('error'))
        <div style="
            padding: 12px 16px;
            border-radius: 10px;
            background:#ffecec;
            color:#b12222;
            text-align:left;
            margin-bottom:18px;
            font-size:14px;
        ">
            {{ session('error') }}
        </div>
    @endif

    {{-- BŁĘDY WALIDACJI --}}
    @if ($errors->any())
        <div style="
            padding: 12px 16px;
            border-radius: 10px;
            background:#ffecec;
            color:#b12222;
            text-align:left;
            margin-bottom:18px;
            font-size:14px;
        ">
            <strong>Ups! Sprawdź formularz:</strong>
            <ul style="margin-top:8px; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARZ --}}
    <form method="POST" action="{{ route('company.points.add') }}" style="max-width:420px; margin:0 auto; text-align:left;">
        @csrf

        {{-- NUMER TELEFONU --}}
        <label style="display:block; margin-bottom:6px; font-size:14px; font-weight:500;">
            Numer telefonu klienta (ID klienta)
        </label>
        <input
            type="text"
            name="phone"
            value="{{ old('phone') }}"
            placeholder="np. 501234567"
            style="
                width:100%;
                padding:10px 12px;
                border-radius:10px;
                border:1px solid #d0d4ff;
                margin-bottom:14px;
                font-size:14px;
            "
            required
        >

        {{-- KWOTA --}}
        <label style="display:block; margin-bottom:6px; font-size:14px; font-weight:500;">
            Kwota rachunku (PLN)
        </label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="amount"
            value="{{ old('amount') }}"
            placeholder="np. 123.45"
            style="
                width:100%;
                padding:10px 12px;
                border-radius:10px;
                border:1px solid #d0d4ff;
                margin-bottom:14px;
                font-size:14px;
            "
            required
        >

        {{-- NOTATKA --}}
        <label style="display:block; margin-bottom:6px; font-size:14px; font-weight:500;">
            Notatka (opcjonalnie)
        </label>
        <input
            type="text"
            name="note"
            value="{{ old('note') }}"
            placeholder="np. Zakup kosmetyków"
            style="
                width:100%;
                padding:10px 12px;
                border-radius:10px;
                border:1px solid #e0e0e0;
                margin-bottom:18px;
                font-size:14px;
            "
        >

        {{-- SUBMIT --}}
        <button type="submit" style="
            display:inline-block;
            padding:10px 22px;
            border-radius:999px;
            border:none;
            background:linear-gradient(135deg,#4a3aff,#9b59ff);
            color:#fff;
            font-size:15px;
            font-weight:600;
            cursor:pointer;
            box-shadow:0 6px 18px rgba(74,58,255,0.35);
        ">
            ➕ Dodaj punkty
        </button>

    </form>
</div>
@endsection
