@extends('firm.layout.app')

@section('content')

@php
    // 🔐 Bezpieczne generowanie linku (bez kontrolera)
    $firmId = session('firm_id');
    $registerUrl = $firmId ? url('/register/card/' . $firmId) : '';
@endphp

<div class="max-w-7xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">
            ⭐ Karty stałego klienta
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Rejestruj klientów i zarządzaj kartami stałego klienta przypisanymi wyłącznie do Twojej firmy.
        </p>
    </div>

    {{-- STATYSTYKI --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="text-sm text-slate-500">Karty</div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['cards'] ?? 0 }}</div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="text-sm text-slate-500">Naklejki łącznie</div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['stamps'] ?? 0 }}</div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="text-sm text-slate-500">Pełne karty</div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['full'] ?? 0 }}</div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="text-sm text-slate-500">Aktywne (30 dni)</div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['active30'] ?? 0 }}</div>
        </div>
    </div>

    {{-- BOX REJESTRACJI --}}
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
        <h3 class="text-lg font-semibold">
            🔗 Rejestracja karty stałego klienta
        </h3>
        <p class="text-sm opacity-90 mt-1">
            Udostępnij klientowi link lub wygeneruj kod QR w lokalu.
        </p>

        <div class="mt-4 flex flex-col md:flex-row gap-3">
            <input
                type="text"
                readonly
                value="{{ $registerUrl }}"
                class="flex-1 rounded-lg px-4 py-2 text-slate-900 text-sm"
            >

            <button
                onclick="navigator.clipboard.writeText('{{ $registerUrl }}')"
                class="bg-white text-indigo-600 font-semibold px-4 py-2 rounded-lg hover:bg-slate-100 transition"
            >
                📋 Kopiuj link
            </button>
        </div>
    </div>

    {{-- LISTA KART --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-slate-900">📋 Lista kart</h3>
            <p class="text-sm text-slate-500">
                Wszystkie karty przypisane do Twojej firmy.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-3 text-left">Telefon</th>
                        <th class="px-6 py-3 text-left">Postęp</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Utworzono</th>
                        <th class="px-6 py-3 text-left">Akcja</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($cards ?? [] as $card)
                    <tr>
                        <td class="px-6 py-3">{{ $card->client->phone ?? '-' }}</td>
                        <td class="px-6 py-3 font-medium">
                            {{ $card->current_stamps ?? 0 }}/10
                        </td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs bg-slate-100">
                                {{ $card->status ?? 'aktywna' }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            {{ optional($card->created_at)->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-3">
                            <a href="#" class="text-indigo-600 font-semibold hover:underline">
                                ➕ Naklejka
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-slate-400">
                            Brak kart stałego klienta
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
