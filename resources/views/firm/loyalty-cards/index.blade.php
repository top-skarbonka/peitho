@extends('firm.layout.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">⭐ Karty stałego klienta</h1>
        <p class="text-sm text-slate-500 mt-1">
            Zarządzaj kartami, dodawaj naklejki i wyszukuj klientów po numerze telefonu.
        </p>
    </div>

    {{-- LINK REJESTRACJI --}}
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl p-5 text-white shadow">
        <h3 class="text-base font-semibold">🔗 Rejestracja nowego klienta</h3>
        <p class="text-xs opacity-90 mt-1">
            Wygeneruj link i pozwól klientowi samodzielnie zapisać się do programu.
        </p>

        <form method="POST" action="{{ route('company.loyalty.cards.generate') }}" class="mt-3">
            @csrf
            <button
                type="submit"
                class="bg-white text-indigo-700 font-semibold px-4 py-2 rounded-lg hover:bg-slate-100 transition text-sm"
            >
                🔐 Wygeneruj link
            </button>
        </form>

        @if(session('registration_link'))
            <div class="mt-3 bg-white/10 p-3 rounded-lg">
                <p class="text-[11px] opacity-90">Link rejestracji:</p>
                <input
                    type="text"
                    readonly
                    value="{{ session('registration_link') }}"
                    class="w-full mt-1 px-3 py-2 rounded text-slate-900 text-xs"
                >
            </div>
        @endif
    </div>

    {{-- FILTR --}}
    <div class="bg-white rounded-xl shadow-sm p-3">
        <input
            type="text"
            id="phoneFilter"
            placeholder="🔍 Wpisz numer telefonu klienta…"
            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm"
        >
    </div>

    {{-- LISTA KART --}}
    {{-- MOBILE: 1 | TABLET: 2 | LAPTOP: 3 | DESKTOP: 4 --}}
    <div
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
        id="cardsList"
    >
        @forelse($cards as $card)
            <div
                class="bg-white rounded-xl shadow-sm p-4 space-y-3 card-item"
                data-phone="{{ preg_replace('/\D/', '', $card->client->phone ?? '') }}"
            >
                {{-- GÓRA --}}
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[11px] text-slate-500">Telefon</p>
                        <p class="text-base font-semibold leading-tight">
                            {{ $card->client->phone ?? '-' }}
                        </p>
                    </div>

                    <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold
                        {{ $card->status === 'completed'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-slate-100 text-slate-700' }}">
                        {{ $card->status }}
                    </span>
                </div>

                {{-- POSTĘP --}}
                <div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        <div
                            class="h-1.5 rounded-full bg-indigo-600 transition-all"
                            style="width: {{ ($card->current_stamps / $card->max_stamps) * 100 }}%;"
                        ></div>
                    </div>
                    <p class="text-xs mt-1 font-medium text-slate-600">
                        {{ $card->current_stamps }} / {{ $card->max_stamps }} naklejek
                    </p>
                </div>

                {{-- AKCJA --}}
                <form method="POST" action="{{ route('company.loyalty.cards.stamp', $card) }}">
                    @csrf
                    <button
                        class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold text-sm hover:bg-indigo-700 transition"
                    >
                        ➕ Dodaj naklejkę
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-full text-center text-slate-400 py-10">
                Brak kart stałego klienta
            </div>
        @endforelse
    </div>
</div>

{{-- FILTR JS --}}
<script>
document.getElementById('phoneFilter').addEventListener('input', function () {
    const query = this.value.replace(/\D/g, '');
    document.querySelectorAll('.card-item').forEach(card => {
        const phone = card.dataset.phone;
        card.style.display = phone.includes(query) ? 'block' : 'none';
    });
});
</script>
@endsection
