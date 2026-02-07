@extends('layouts.public')

@section('content')
<div style="
    max-width:420px;
    margin:0 auto;
    padding:20px 16px 40px;
">

<h2 style="text-align:center;margin-bottom:20px;">
    👋 Cześć {{ $client->name ?? '!' }}
</h2>

@foreach($grouped as $category => $cards)
    <h3>{{ ucfirst(str_replace('_',' ', $category)) }}</h3>

    @foreach($cards as $item)
        @php $card = $item['card']; @endphp

        <a href="{{ route('client.loyalty.card.show', $card->id) }}"
           style="display:block;padding:12px;margin-bottom:10px;border-radius:12px;background:#fff">

            <strong>{{ $card->firm->name }}</strong><br>

            {{ $item['current'] }} / {{ $item['max'] }}

            @if($item['rewardReady'])
                <span style="color:green;font-weight:700;"> 🎁 Nagroda gotowa</span>
            @endif
        </a>
    @endforeach
@endforeach
</div>
@endsection
