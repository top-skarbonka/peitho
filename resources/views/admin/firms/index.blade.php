@extends('layouts.public')

@section('content')
@php
    $firms = $firms ?? \App\Models\Firm::orderByDesc('id')->get();
@endphp

<div style="max-width:1100px;margin:40px auto;padding:30px;background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.15)">

    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <div>
            <h2 style="margin-bottom:6px;">🏢 Lista firm</h2>
            <p style="color:#666;margin:0;">Zarządzanie firmami / linki rejestracji / QR</p>
        </div>

        <a href="{{ route('admin.firms.create') }}"
           style="display:inline-block;padding:12px 18px;border-radius:14px;
                  background:linear-gradient(135deg,#6a5af9,#ff5fa2);
                  color:#fff;font-weight:800;">
            ➕ Dodaj firmę
        </a>
    </div>

    {{-- 🔍 FILTR --}}
    <div style="margin-top:20px;">
        <input
            type="text"
            id="firmSearch"
            placeholder="🔍 Szukaj po nazwie, telefonie lub slugu..."
            style="width:100%;padding:14px 16px;border-radius:14px;border:1px solid #e5e7eb;font-size:15px;"
            onkeyup="filterFirms()"
        >
    </div>

    {{-- TABLE --}}
    <div style="margin-top:18px;overflow:auto;border:1px solid #eee;border-radius:14px;">
        <table style="width:100%;border-collapse:collapse;min-width:980px;">
            <thead>
            <tr style="background:#f8f8ff;border-bottom:1px solid #eee;">
                <th style="padding:12px;">ID</th>
                <th style="padding:12px;">Logo</th>
                <th style="padding:12px;">Nazwa</th>
                <th style="padding:12px;">Slug</th>
                <th style="padding:12px;">Miasto</th>
                <th style="padding:12px;">Telefon</th>
                <th style="padding:12px;">Szablon</th>
                <th style="padding:12px;">Google</th>
                <th style="padding:12px;text-align:right;">Akcje</th>
            </tr>
            </thead>

            <tbody id="firmsTable">
            @foreach($firms as $firm)
                <tr style="border-bottom:1px solid #f1f1f1;">
                    <td style="padding:12px;">{{ $firm->id }}</td>

                    <td style="padding:12px;">
                        <div style="width:46px;height:46px;border-radius:12px;background:#f3f4f6;
                                    display:flex;align-items:center;justify-content:center;overflow:hidden;">
                            @if($firm->logo_path)
                                <img src="{{ asset('storage/'.$firm->logo_path) }}"
                                     style="max-width:100%;max-height:100%;object-fit:contain;">
                            @else
                                🏷️
                            @endif
                        </div>
                    </td>

                    <td class="firm-name" style="padding:12px;font-weight:700;">
                        {{ $firm->name }}
                    </td>

                    {{-- SLUG --}}
                    <td class="firm-slug" style="padding:12px;">
                        <div style="
                            font-family:monospace;
                            font-size:13px;
                            background:#f3f4f6;
                            padding:6px 10px;
                            border-radius:8px;
                            display:inline-block;
                            color:#111;
                        ">
                            {{ $firm->slug }}
                        </div>
                    </td>

                    <td style="padding:12px;">{{ $firm->city }}</td>

                    <td class="firm-phone" style="padding:12px;">
                        {{ $firm->phone ?? '' }}
                    </td>

                    <td style="padding:12px;">{{ $firm->card_template }}</td>

                    <td style="padding:12px;">
                        @if($firm->google_url)
                            <span style="padding:4px 10px;border-radius:999px;background:#e7f0ff;color:#1d4ed8;font-weight:700;font-size:12px;">
                                ✔
                            </span>
                        @else
                            —
                        @endif
                    </td>

                    <td style="padding:12px;text-align:right;">
                        <a href="{{ route('admin.firms.edit', $firm) }}"
                           style="
                                display:inline-flex;
                                align-items:center;
                                gap:8px;
                                padding:10px 16px;
                                border-radius:14px;
                                font-weight:800;
                                font-size:14px;
                                color:#fff;
                                background:linear-gradient(135deg,#111827,#374151);
                                box-shadow:0 8px 20px rgba(17,24,39,.25);
                           ">
                            ✏️ Edytuj
                        </a>
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
        row.style.display = (name.includes(q) || phone.includes(q) || slug.includes(q)) ? '' : 'none';
    });
}
</script>
@endsection
