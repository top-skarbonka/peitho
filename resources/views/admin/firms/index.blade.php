@extends('layouts.public')

@section('content')
@php
    $firms = $firms ?? \App\Models\Firm::orderByDesc('id')->get();
@endphp

<div style="width:96%;max-width:1750px;margin:40px auto;padding:34px;background:#fff;border-radius:18px;box-shadow:0 25px 70px rgba(0,0,0,.12)">

    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <div>
            <h2 style="margin-bottom:6px;font-size:26px;font-weight:900;">
                🏢 Lista firm
            </h2>

            <p style="color:#666;margin:0;">
                Zarządzanie abonamentami • blokady • aktywność
            </p>
        </div>

        <a href="{{ route('admin.firms.create') }}"
           style="
                display:inline-block;
                padding:14px 22px;
                border-radius:14px;
                background:linear-gradient(135deg,#6a5af9,#ff5fa2);
                color:#fff;
                font-weight:800;
                letter-spacing:.3px;
                box-shadow:0 10px 30px rgba(106,90,249,.35);
           ">
            ➕ Dodaj firmę
        </a>
    </div>

    {{-- SEARCH --}}
    <div style="margin-top:26px;">
        <input
            type="text"
            id="firmSearch"
            placeholder="🔍 Szukaj po nazwie, telefonie lub slugu..."
            style="
                width:100%;
                padding:16px 18px;
                border-radius:14px;
                border:1px solid #e5e7eb;
                font-size:15px;
                outline:none;
            "
            onkeyup="filterFirms()"
        >
    </div>

    {{-- TABLE --}}
    <div style="margin-top:22px;overflow:auto;border:1px solid #eee;border-radius:16px;">
        <table style="width:100%;border-collapse:collapse;min-width:1350px;">

            <thead>
            <tr style="background:#f7f8ff;border-bottom:1px solid #eee;">
                <th style="padding:14px;">ID</th>
                <th style="padding:14px;">Logo</th>
                <th style="padding:14px;">Nazwa</th>
                <th style="padding:14px;">Slug</th>
                <th style="padding:14px;">Miasto</th>
                <th style="padding:14px;">Telefon</th>
                <th style="padding:14px;">Status</th>
                <th style="padding:14px;">Abonament do</th>
                <th style="padding:14px;">Plan</th>
                <th style="padding:14px;text-align:right;">Akcje</th>
            </tr>
            </thead>

            <tbody id="firmsTable">

            @foreach($firms as $firm)

                @php
                    $isBlocked = $firm->subscription_forced_status === 'blocked';
                    $isExpired = $firm->subscription_ends_at && now()->gt($firm->subscription_ends_at);
                @endphp

                <tr style="border-bottom:1px solid #f1f1f1;transition:.15s;"
                    onmouseover="this.style.background='#fafbff'"
                    onmouseout="this.style.background='white'">

                    <td style="padding:14px;font-weight:700;">
                        {{ $firm->id }}
                    </td>

                    {{-- LOGO --}}
                    <td style="padding:14px;">
                        <div style="width:50px;height:50px;border-radius:12px;background:#f3f4f6;
                                    display:flex;align-items:center;justify-content:center;overflow:hidden;">
                            @if($firm->logo_path)
                                <img src="{{ asset('storage/'.$firm->logo_path) }}"
                                     style="max-width:100%;max-height:100%;object-fit:contain;">
                            @else
                                🏷️
                            @endif
                        </div>
                    </td>

                    <td class="firm-name" style="padding:14px;font-weight:800;">
                        {{ $firm->name }}
                    </td>

                    <td class="firm-slug" style="padding:14px;">
                        <span style="
                            font-family:monospace;
                            font-size:13px;
                            background:#eef2ff;
                            padding:6px 10px;
                            border-radius:8px;
                        ">
                            {{ $firm->slug }}
                        </span>
                    </td>

                    <td style="padding:14px;">
                        {{ $firm->city }}
                    </td>

                    <td class="firm-phone" style="padding:14px;">
                        {{ $firm->phone ?? '—' }}
                    </td>

                    {{-- STATUS --}}
                    <td style="padding:14px;">
                        @if($isBlocked)

                            <span style="padding:7px 14px;border-radius:999px;
                                         background:#fee2e2;color:#b91c1c;
                                         font-weight:900;font-size:12px;">
                                🔴 Zablokowana
                            </span>

                        @elseif($isExpired)

                            <span style="padding:7px 14px;border-radius:999px;
                                         background:#fff7ed;color:#c2410c;
                                         font-weight:900;font-size:12px;">
                                ⚠️ Po terminie
                            </span>

                        @else

                            <span style="padding:7px 14px;border-radius:999px;
                                         background:#dcfce7;color:#166534;
                                         font-weight:900;font-size:12px;">
                                🟢 Aktywna
                            </span>

                        @endif
                    </td>

                    {{-- DATA --}}
                    <td style="padding:14px;font-weight:700;">
                        {{ $firm->subscription_ends_at?->format('d.m.Y') ?? '—' }}
                    </td>

                    <td style="padding:14px;font-weight:700;">
                        {{ ucfirst($firm->plan ?? 'starter') }}
                    </td>

                    {{-- AKCJE --}}
                    <td style="padding:14px;text-align:right;white-space:nowrap;">

                        {{-- AKTYWNOŚĆ --}}
                        <a href="{{ route('admin.firms.activity', $firm->slug) }}"
                           style="
                                padding:10px 14px;
                                border-radius:12px;
                                font-weight:800;
                                color:#4338ca;
                                background:#eef2ff;
                                margin-right:6px;
                           ">
                            📊
                        </a>

                        {{-- EDYCJA --}}
                        <a href="{{ route('admin.firms.edit', $firm) }}"
                           style="
                                padding:10px 14px;
                                border-radius:12px;
                                font-weight:800;
                                color:#fff;
                                background:#111827;
                                margin-right:6px;
                           ">
                            ✏️
                        </a>

                        {{-- BLOCK / UNBLOCK --}}
                        @if($isBlocked)

                            <form method="POST"
                                  action="{{ route('admin.firms.unblock', $firm) }}"
                                  style="display:inline;">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Odblokować firmę?')"
                                        style="
                                            padding:10px 14px;
                                            border-radius:12px;
                                            font-weight:900;
                                            border:none;
                                            color:#065f46;
                                            background:#d1fae5;
                                            cursor:pointer;
                                        ">
                                    🟢
                                </button>
                            </form>

                        @else

                            <form method="POST"
                                  action="{{ route('admin.firms.block', $firm) }}"
                                  style="display:inline;">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Na pewno ZABLOKOWAĆ firmę?')"
                                        style="
                                            padding:10px 14px;
                                            border-radius:12px;
                                            font-weight:900;
                                            border:none;
                                            color:#7f1d1d;
                                            background:#fee2e2;
                                            cursor:pointer;
                                        ">
                                    🔴
                                </button>
                            </form>

                        @endif

                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function filterFirms() {
    const q = document.getElementById('firmSearch').value.toLowerCase();

    document.querySelectorAll('#firmsTable tr').forEach(row => {
        const name = row.querySelector('.firm-name')?.innerText.toLowerCase() || '';
        const phone = row.querySelector('.firm-phone')?.innerText.toLowerCase() || '';
        const slug = row.querySelector('.firm-slug')?.innerText.toLowerCase() || '';

        row.style.display =
            (name.includes(q) || phone.includes(q) || slug.includes(q))
            ? ''
            : 'none';
    });
}
</script>

@endsection
