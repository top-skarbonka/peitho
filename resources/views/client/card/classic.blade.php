@extends('layouts.public')

@section('content')
<div style="min-height:100vh;background:#f4f6fb;display:flex;justify-content:center;align-items:center;padding:16px;">
<div style="width:100%;max-width:420px;background:white;border-radius:22px;box-shadow:0 25px 60px rgba(0,0,0,.15);overflow:hidden">

<div style="padding:20px;">
<h2 style="margin:0">{{ $card->firm->name }}</h2>
<p style="color:#777;margin-top:4px">Karta lojalnościowa</p>
</div>

<div style="display:grid;grid-template-columns:repeat(6,1fr);gap:12px;padding:0 20px 20px">
@for($i=1;$i<=$maxStamps;$i++)
<div style="aspect-ratio:1;border-radius:50%;background:
{{ $i <= $current ? '#6fbf4b' : '#eee' }}"></div>
@endfor
</div>

<div style="padding:16px 20px;border-top:1px solid #eee;display:flex;align-items:center;gap:14px">
<div style="background:white;padding:8px;border-radius:12px">{!! $qr !!}</div>

<div>
<div style="font-size:12px;color:#777">Pokaż przy kasie</div>
<div style="font-size:20px;font-weight:800">{{ $displayCode }}</div>
</div>

<div style="margin-left:auto;text-align:right;font-size:13px;color:#555">
@if($card->firm->google_url)
<a href="{{ $card->firm->google_url }}" target="_blank" style="display:block">⭐ Zostaw opinię</a>
@endif
</div>
</div>

</div>
</div>
@endsection
