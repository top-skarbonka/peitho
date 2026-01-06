@extends('layouts.public')

@section('content')
<div style="min-height:100vh;background:linear-gradient(135deg,#6a5af9,#ff5fa2);display:flex;justify-content:center;align-items:center;padding:16px;">
<div style="width:100%;max-width:420px;background:white;border-radius:26px;padding:22px;">

<h2 style="margin:0">{{ $card->firm->name }}</h2>
<p style="color:#777;margin-bottom:16px">Twoja karta</p>

<div style="display:grid;grid-template-columns:repeat(6,1fr);gap:10px;margin-bottom:18px">
@for($i=1;$i<=$maxStamps;$i++)
<div style="aspect-ratio:1;border-radius:50%;
background:{{ $i <= $current ? '#ff5fa2' : '#ddd' }}"></div>
@endfor
</div>

<div style="display:flex;align-items:center;gap:14px">
<div>{!! $qr !!}</div>
<div>
<div style="font-size:12px;color:#777">Kod</div>
<div style="font-size:22px;font-weight:900">{{ $displayCode }}</div>
</div>
</div>

<div style="margin-top:16px;display:flex;gap:10px">
@if($card->firm->facebook_url)<a href="{{ $card->firm->facebook_url }}">FB</a>@endif
@if($card->firm->instagram_url)<a href="{{ $card->firm->instagram_url }}">IG</a>@endif
@if($card->firm->google_url)<a href="{{ $card->firm->google_url }}">Google</a>@endif
</div>

</div>
</div>
@endsection
