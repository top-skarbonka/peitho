@extends('layouts.firm')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-2">
            📊 Statystyki programu lojalnościowego
        </h1>
        <p class="text-slate-500 mt-1">
            Podgląd kondycji programu: klienci, punkty, aktywność.
        </p>
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl p-6 shadow">
            <p class="text-slate-500 text-sm">Klienci</p>
            <p class="text-3xl font-bold">{{ $totalClients ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow">
            <p class="text-slate-500 text-sm">Transakcje</p>
            <p class="text-3xl font-bold">{{ $totalTransactions ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow">
            <p class="text-slate-500 text-sm">Suma punktów</p>
            <p class="text-3xl font-bold">{{ number_format($totalPoints ?? 0, 2, ',', ' ') }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow">
            <p class="text-slate-500 text-sm">Średnio / transakcję</p>
            <p class="text-3xl font-bold">{{ number_format($avgPoints ?? 0, 2, ',', ' ') }}</p>
        </div>

    </div>

</div>

@endsection
