@extends('firm.layout.app')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">⭐ Karty stałego klienta</h1>
        <p class="text-sm text-slate-500 mt-1">
            Lista kart przypisanych do Twojej firmy + rejestracja nowych klientów.
        </p>
    </div>

    {{-- LINK REJESTRACJI --}}
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
        <h3 class="text-lg font-semibold">🔗 Rejestracja karty stałego klienta</h3>
        <p class="text-sm opacity-90 mt-1">
            Wygeneruj bezpieczny link rejestracji klienta (token).
        </p>

        <form method="POST" action="{{ route('company.loyalty.cards.generate') }}" class="mt-4">
            @csrf

            <button
                type="submit"
                class="bg-white text-indigo-700 font-semibold px-4 py-2 rounded-lg hover:bg-slate-100 transition"
            >
                🔐 Wygeneruj link rejestracji
            </button>
        </form>

        @if(session('registration_link'))
            <div class="mt-4 bg-white/10 p-3 rounded-lg">
                <p class="text-xs opacity-90">Link rejestracji:</p>
                <input
                    type="text"
                    readonly
                    value="{{ session('registration_link') }}"
                    class="w-full mt-1 px-3 py-2 rounded text-slate-900 text-sm"
                >
            </div>
        @endif
    </div>

    {{-- LISTA KART --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-slate-900">📋 Lista kart</h3>
            <p class="text-sm text-slate-500">Karty przypisane do Twojej firmy</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-3 text-left">Telefon</th>
                        <th class="px-6 py-3 text-left">Postęp</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Akcja</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                @forelse($cards as $card)
                    <tr>
                        <td class="px-6 py-3">
                            {{ $card->client->phone ?? '-' }}
                        </td>

                        <td class="px-6 py-3 font-semibold">
                            {{ $card->current_stamps }} / {{ $card->max_stamps }}
                        </td>

                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ $card->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-slate-100' }}">
                                {{ $card->status }}
                            </span>
                        </td>

                        <td class="px-6 py-3 flex gap-2">
                            <form method="POST" action="{{ route('company.loyalty.cards.stamp', $card) }}">
                                @csrf
                                <button class="text-indigo-600 hover:underline">
                                    ➕ Naklejka
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-slate-400">
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
