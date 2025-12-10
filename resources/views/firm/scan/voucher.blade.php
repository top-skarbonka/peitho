<h1>Voucher prezentowy</h1>

<p><strong>Typ:</strong> {{ $voucher->type }}</p>

@if($voucher->type === 'amount')
<p><strong>Wartość:</strong> {{ $voucher->amount }} zł</p>
@else
<p><strong>Usługa:</strong> {{ $voucher->service_name }}</p>
@endif

<p><strong>Status:</strong> {{ $voucher->status }}</p>
<p><strong>Ważny do:</strong> {{ $voucher->valid_until }}</p>

<hr>

@if ($voucher->status === 'active')
<form method="POST" action="/firm/voucher/{{ $voucher->id }}/use">
    @csrf
    <button type="submit">🎁 Zrealizuj voucher</button>
</form>
@else
    <p>Voucher nieaktywny lub już wykorzystany.</p>
@endif
