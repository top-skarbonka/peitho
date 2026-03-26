@extends('layouts.public')

@section('content')

<div style="width:98%;max-width:1850px;margin:30px auto;padding:26px;background:#fff;border-radius:18px;box-shadow:0 20px 60px rgba(0,0,0,.12)">

    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
        <div>
            <h2 style="margin:0;">🏢 Lista firm</h2>
            <div style="color:#666;font-size:14px;">
                Zarządzanie abonamentami • blokady • aktywność
            </div>
        </div>

        <a href="{{ route('admin.firms.create') }}"
           style="padding:11px 18px;border-radius:12px;
                  background:linear-gradient(135deg,#6a5af9,#ff5fa2);
                  color:#fff;font-weight:700;text-decoration:none;">
            + Dodaj firmę
        </a>
    </div>

    {{-- SEARCH --}}
    <input
        type="text"
        id="firmSearch"
        placeholder="🔍 Szukaj po nazwie, telefonie lub slugu..."
        style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid #e5e7eb;margin-bottom:14px;"
        onkeyup="filterFirms()"
    >

<style>
table{ width:100%; border-collapse:collapse; font-size:14px; }
th{ text-align:left; padding:12px; background:#f7f7fb; font-weight:700; color:#444; }
td{ padding:12px; border-top:1px solid #eee; }
.badge{ padding:5px 10px; border-radius:999px; font-size:12px; font-weight:700; }
.green{ background:#dcfce7; color:#166534; }
.orange{ background:#fff7ed; color:#c2410c; }
.red{ background:#fee2e2; color:#991b1b; }
.mono{ font-family:monospace; font-size:12px; background:#f1f5f9; padding:4px 8px; border-radius:8px; }
details summary{ cursor:pointer; list-style:none; background:#111827; color:#fff; padding:7px 11px; border-radius:10px; font-size:13px; font-weight:700; }
details summary::-webkit-details-marker{ display:none; }
.dropdown{ position:absolute; right:0; margin-top:6px; width:240px; background:#fff; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,.15); border:1px solid #eee; overflow:hidden; z-index:999; }
.dropdown a,.dropdown button{ display:block; width:100%; padding:10px 12px; text-align:left; background:none; border:none; cursor:pointer; font-weight:600; }
.dropdown a:hover,.dropdown button:hover{ background:#f3f4f6; }
</style>

<table>
<thead>
<tr>
    <th>Firma</th>
    <th>Slug</th>
    <th>Miasto</th>
    <th>Telefon</th>
    <th>Status</th>
    <th>Abonament</th>
    <th>Plan</th>
    <th>SMS dziś</th>
    <th>OTP</th>
    <th style="width:80px;"></th>
</tr>
</thead>

<tbody id="firmsTable">
@foreach($firms as $firm)
<tr>

<td class="firm-name" style="font-weight:700;">
    {{ $firm->name }}
</td>

<td class="firm-slug">
    <span class="mono">{{ $firm->slug }}</span>
</td>

<td>{{ $firm->city }}</td>

<td class="firm-phone">
    {{ $firm->phone }}
</td>

<td>
@if($firm->subscription_forced_status === 'blocked')
    <span class="badge red">Zablokowana</span>
@elseif($firm->subscription_ends_at && now()->gt($firm->subscription_ends_at))
    <span class="badge orange">Po terminie</span>
@else
    <span class="badge green">Aktywna</span>
@endif
</td>

<td style="font-weight:700;">
    {{ $firm->subscription_ends_at?->format('d.m.Y') ?? '—' }}
</td>

<td>
    {{ ucfirst($firm->plan ?? '-') }}
</td>

<td>
@php $sms = $firm->sms_today ?? 0; @endphp

@if($sms <= 10)
    <span class="badge green">{{ $sms }}</span>
@elseif($sms <= 30)
    <span class="badge orange">{{ $sms }}</span>
@else
    <span class="badge red">{{ $sms }}</span>
@endif
</td>

<td>
@if($firm->otp_status === 'ok')
    <span class="badge green">OK</span>
@elseif($firm->otp_status === 'error')
    <span class="badge red">Błąd</span>
@else
    <span class="badge orange">Brak</span>
@endif
</td>

<td style="position:relative;text-align:right;">

<details>
<summary>⚙</summary>

<div class="dropdown">

<a href="{{ route('admin.firms.activity', $firm) }}">
📊 Aktywność
</a>

<a href="{{ route('admin.firms.edit', $firm) }}">
✏️ Edytuj
</a>

<hr>

<form method="GET" action="{{ route('admin.consents.export') }}" target="_blank">
<input type="hidden" name="firm_id" value="{{ $firm->id }}">
<button style="color:#2563eb;font-weight:700;">
📥 Eksport zgód (CSV)
</button>
</form>

<hr>

<form method="POST" action="{{ route('admin.firms.extend30', $firm) }}">
@csrf
<button>+30 dni</button>
</form>

<form method="POST" action="{{ route('admin.firms.extend365', $firm) }}">
@csrf
<button>+365 dni</button>
</form>

</div>
</details>

</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<script>
function filterFirms() {
    const q = document.getElementById('firmSearch').value.toLowerCase();

    document.querySelectorAll('#firmsTable tr').forEach(row => {
        const name = row.querySelector('.firm-name')?.innerText.toLowerCase() || '';
        const phone = row.querySelector('.firm-phone')?.innerText.toLowerCase() || '';
        const slug = row.querySelector('.firm-slug')?.innerText.toLowerCase() || '';

        row.style.display =
            name.includes(q) ||
            phone.includes(q) ||
            slug.includes(q)
                ? ''
                : 'none';
    });
}
</script>

@endsection
