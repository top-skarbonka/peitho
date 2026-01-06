@extends('layouts.public')

@section('content')
<div style="min-height:100vh;background:#111;display:flex;justify-content:center;align-items:center;padding:16px;">
<div style="width:100%;max-width:420px;background:linear-gradient(135deg,#fff6cc,#e6c87a);border-radius:28px;padding:24px;color:#222">

<h2 style="margin:0">{{ $card->firm->name }}</h2>
<p style="opacity:.7">VIP Card</p>

<div style="display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin:18px 0">
@for($i=1;$i<=$maxStamps;$i++)
<div style="aspect-ratio:1;border-radius:50%;
background:{{ $i <= $current ? '#c9a227' : '#f0e6c0' }}"></div>
@endfor
</div>

<div style="display:flex;align-items:center;gap:14px">
<div>{!! $qr !!}</div>
<div>
<div style="font-size:12px">Kod</div>
<div style="font-size:22px;font-weight:900">{{ $displayCode }}</div>
</div>
</div>

@if($card->firm->google_url)
<div style="margin-top:14px;font-size:14px">
⭐ <a href="{{ $card->firm->google_url }}">Zostaw opinię</a>
</div>
@endif

</div>
</div>
@endsection
