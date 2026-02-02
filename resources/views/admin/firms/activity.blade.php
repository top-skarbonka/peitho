@extends('layouts.public')

@section('content')
@php
    use Carbon\Carbon;

    // 🛡️ zabezpieczenie
    $stamps = $stamps ?? collect();

    $lastActivity = $firm->last_activity_at
        ? Carbon::parse($firm->last_activity_at)
        : null;

    $totalStamps = $stamps->sum('actions');

    $isActive = $lastActivity && $lastActivity->gt(now()->subDays(7));
@endphp
<div style="
    max-width:900px;
    margin:60px auto;
    padding:40px;
    background:#fff;
    border-radius:18px;
    box-shadow:0 20px 60px rgba(0,0,0,.12);
">

    <h1 style="margin-bottom:10px;">🕒 Aktywność firmy</h1>

    <p style="color:#555;margin-top:0;">
        <strong>Nazwa:</strong> {{ $firm->name }} <br>
        <strong>Slug:</strong> {{ $firm->slug }}
    </p>

    {{-- STATUS --}}
    <div style="
        margin-top:24px;
        padding:20px;
        border-radius:14px;
        background:#f8fafc;
        border:1px solid #e5e7eb;
    ">
        <h3 style="margin-top:0;">📊 Status aktywności</h3>

        <p>
            <strong>Status:</strong>
            @if($isActive)
                <span style="color:#16a34a;font-weight:800;">AKTYWNA</span>
            @else
                <span style="color:#dc2626;font-weight:800;">NIEAKTYWNA</span>
            @endif
        </p>

        <p>
            <strong>Ostatnia aktywność:</strong>
            @if($lastActivity)
                {{ $lastActivity->format('d.m.Y H:i') }}
                <span style="color:#666;">
                    ({{ $lastActivity->diffForHumans() }})
                </span>
            @else
                —
            @endif
        </p>
    </div>

    {{-- NAKLEJKI --}}
    <div style="
        margin-top:24px;
        padding:20px;
        border-radius:14px;
        background:#f8fafc;
        border:1px solid #e5e7eb;
    ">
        <h3 style="margin-top:0;">🏷️ Naklejki (ostatnie 30 dni)</h3>

        <p>
            <strong>Łącznie dodano:</strong>
            <span style="font-weight:800;font-size:18px;">
                {{ $totalStamps }}
            </span>
        </p>

        @if($totalStamps === 0)
            <p style="color:#666;">Brak aktywności w ostatnich 30 dniach.</p>
        @endif
    </div>

    {{-- POWRÓT --}}
    <div style="margin-top:30px;">
        <a href="{{ route('admin.firms.index') }}"
           style="
                display:inline-block;
                padding:12px 18px;
                border-radius:14px;
                background:#111827;
                color:#fff;
                font-weight:800;
                text-decoration:none;
           ">
            ← Wróć do listy firm
        </a>
    </div>

</div>
@endsection
