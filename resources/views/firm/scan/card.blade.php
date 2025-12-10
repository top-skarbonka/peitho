<h1>Karta stałego klienta</h1>

<p><strong>Klient ID:</strong> {{ $card->client_id }}</p>
<p><strong>Maksymalna liczba naklejek:</strong> {{ $card->max_stamps }}</p>
<p><strong>Aktualna liczba naklejek:</strong> {{ $card->current_stamps }}</p>
<p><strong>Nagroda:</strong> {{ $card->reward }}</p>
<p><strong>Status:</strong> {{ $card->status }}</p>

<hr>

@if ($card->current_stamps < $card->max_stamps)
    <form method="POST" action="/firm/card/{{ $card->id }}/add-stamp">
        @csrf
        <button type="submit">➕ Dodaj naklejkę</button>
    </form>
@else
    <p>Karta kompletna! 🎉</p>
    <form method="POST" action="/firm/card/{{ $card->id }}/reset">
        @csrf
        <button type="submit">🔄 Resetuj kartę (przyznano nagrodę)</button>
    </form>
@endif
