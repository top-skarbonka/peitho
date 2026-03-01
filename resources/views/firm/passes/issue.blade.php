@extends('layouts.firm')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-2">
            🎫 Wydaj karnet klientowi
        </h1>
        <p class="text-slate-500 mt-1">
            Wprowadź numer telefonu klienta i wybierz typ karnetu.
        </p>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- BRAK TYPÓW --}}
    @if($passTypes->isEmpty())

        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-5 rounded-2xl">
            <p class="font-semibold mb-2">
                Najpierw musisz utworzyć typ karnetu.
            </p>
            <a href="{{ route('company.pass_types') }}"
               class="inline-block mt-2 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                Przejdź do typów karnetów
            </a>
        </div>

    @else

        {{-- HERO BOX --}}
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-2xl p-8 shadow-lg">

            <h3 class="text-xl font-semibold mb-2">
                🎟️ Wydanie nowego karnetu
            </h3>

            <p class="text-indigo-100 mb-6">
                Po zatwierdzeniu klient otrzyma aktywny karnet w systemie.
            </p>

            <form method="POST"
                  action="{{ route('company.passes.issue') }}"
                  class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <div>
                    <label class="block text-sm mb-1">
                        Telefon klienta
                    </label>
                    <input type="text"
                           name="phone"
                           required
                           class="w-full rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <div>
                    <label class="block text-sm mb-1">
                        Typ karnetu
                    </label>
                    <select name="pass_type_id"
                            required
                            class="w-full rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @foreach($passTypes as $type)
                            <option value="{{ $type->id }}">
                                {{ $type->name }} ({{ $type->entries }} wejść)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <button type="submit"
                            class="mt-4 bg-white text-indigo-600 font-semibold px-6 py-2 rounded-lg hover:bg-indigo-50 transition">
                        🎫 Wydaj karnet
                    </button>
                </div>

            </form>

        </div>

    @endif

</div>

@endsection
