@extends('layouts.firm')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-2">
            🎫 Typy karnetów
        </h1>
        <p class="text-slate-500 mt-1">
            Zarządzaj ofertą karnetów i konfiguruj wejścia dla klientów.
        </p>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- HERO BOX --}}
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-2xl p-8 shadow-lg">
        <h3 class="text-xl font-semibold mb-2">
            ➕ Dodaj nowy typ karnetu
        </h3>
        <p class="text-indigo-100 mb-6">
            Skonfiguruj nazwę, liczbę wejść oraz opcjonalną cenę.
        </p>

        <form method="POST" action="{{ route('company.pass_types.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf

            <div>
                <label class="block text-sm mb-1">Nazwa</label>
                <input type="text"
                       name="name"
                       required
                       class="w-full rounded-lg px-3 py-2 text-slate-800">
            </div>

            <div>
                <label class="block text-sm mb-1">Ilość wejść</label>
                <input type="number"
                       name="entries"
                       min="1"
                       required
                       class="w-full rounded-lg px-3 py-2 text-slate-800">
            </div>

            <div>
                <label class="block text-sm mb-1">Cena (grosze)</label>
                <input type="number"
                       name="price_gross_cents"
                       min="0"
                       class="w-full rounded-lg px-3 py-2 text-slate-800">
            </div>

            <div class="md:col-span-3">
                <button type="submit"
                        class="mt-4 bg-white text-indigo-600 font-semibold px-6 py-2 rounded-lg hover:bg-indigo-50 transition">
                    ➕ Dodaj typ
                </button>
            </div>
        </form>
    </div>

    {{-- LISTA --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h3 class="text-lg font-semibold mb-6">
            📋 Lista typów
        </h3>

        @if($passTypes->isEmpty())
            <p class="text-slate-500">
                Brak typów karnetów.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500 border-b">
                        <tr>
                            <th class="py-3">Nazwa</th>
                            <th>Wejścia</th>
                            <th>Cena (gr)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($passTypes as $type)
                            <tr class="border-b hover:bg-slate-50 transition">
                                <td class="py-3 font-medium">
                                    {{ $type->name }}
                                </td>
                                <td>
                                    {{ $type->entries }}
                                </td>
                                <td>
                                    {{ $type->price_gross_cents ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</div>

@endsection
