@extends('firm.layout.app')

@section('content')
<div class="page-wrap">

    {{-- 🔍 FILTR --}}
    <form method="GET" action="{{ route('company.loyalty.cards') }}" style="margin-bottom:24px;">
        <div style="display:flex; gap:12px; align-items:center;">
            <input
                type="text"
                name="phone"
                value="{{ request('phone') }}"
                placeholder="Wpisz numer telefonu klienta"
                style="
                    padding:12px 14px;
                    border-radius:12px;
                    border:1px solid rgba(0,0,0,.1);
                    font-size:15px;
                    width:260px;
                "
            >
            <button type="submit" class="btn btn-primary">
                Szukaj
            </button>

            @if(request('phone'))
                <a href="{{ route('company.loyalty.cards') }}" class="btn btn-ghost">
                    Wyczyść
                </a>
            @endif
        </div>
    </form>

    {{-- 📊 STATYSTYKI --}}
    <div class="stats">
        <div class="stat">
            <div class="stat-label">Karty</div>
            <div class="stat-value">{{ $stats['cards'] }}</div>
        </div>

        <div class="stat">
            <div class="stat-label">Naklejki łącznie</div>
            <div class="stat-value">{{ $stats['stamps'] }}</div>
        </div>

        <div class="stat">
            <div class="stat-label">Pełne karty</div>
            <div class="stat-value">{{ $stats['full'] }}</div>
        </div>

        <div class="stat">
            <div class="stat-label">Aktywne (30 dni)</div>
            <div class="stat-value">{{ $stats['active30'] }}</div>
        </div>
    </div>

    {{-- 📋 LISTA KART --}}
    <div class="card">
        <div class="card-head">
            <h3 class="card-title">Lista kart</h3>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Klient</th>
                        <th>Postęp</th>
                        <th>Status</th>
                        <th>Utworzono</th>
                        <th>Akcja</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($cards as $card)
                    <tr>
                        <td class="mono">{{ $card->phone }}</td>
                        <td>{{ $card->stamps_count }} / 10</td>
                        <td>
                            @if($card->stamps_count >= 10)
                                <span class="badge badge-redeemed">redeemed</span>
                            @else
                                <span class="badge badge-active">active</span>
                            @endif
                        </td>
                        <td>{{ $card->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($card->stamps_count < 10)
                                <form method="POST" action="{{ route('firm.loyalty-cards.stamp', $card->id) }}">
                                    @csrf
                                    <button class="btn btn-primary btn-mini">+1 naklejka</button>
                                </form>
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:24px;">
                            Brak kart
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
