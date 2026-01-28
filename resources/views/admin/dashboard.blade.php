@extends('layouts.public')

@section('content')
<div style="max-width:1100px;margin:40px auto;padding:30px;">

    {{-- HEADER --}}
    <div style="margin-bottom:30px;">
        <h2 style="margin:0 0 6px;">📊 Panel administracyjny</h2>
        <p style="color:#666;margin:0;">Statystyki globalne systemu</p>
    </div>

    {{-- KAFELKI --}}
    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:20px;
        margin-bottom:34px;
    ">

        {{-- FIRMY --}}
        <div style="background:#fff;padding:20px;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.08);">
            <div style="font-size:13px;color:#666;">Firmy (łącznie)</div>
            <div style="font-size:34px;font-weight:800;margin-top:6px;">{{ $firmsCount }}</div>
            <div style="font-size:13px;color:#22c55e;margin-top:4px;">
                +{{ $firmsThisMonth }} w tym miesiącu
            </div>
        </div>

        {{-- KLIENCI --}}
        <div style="background:#fff;padding:20px;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.08);">
            <div style="font-size:13px;color:#666;">Klienci</div>
            <div style="font-size:34px;font-weight:800;margin-top:6px;">{{ $clientsCount }}</div>
            <div style="font-size:13px;color:#22c55e;margin-top:4px;">
                +{{ $clientsThisMonth }} w tym miesiącu
            </div>
        </div>

        {{-- NAKLEJKI --}}
        <div style="background:#fff;padding:20px;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.08);">
            <div style="font-size:13px;color:#666;">Naklejki</div>
            <div style="font-size:34px;font-weight:800;margin-top:6px;">{{ $stampsCount }}</div>
            <div style="font-size:13px;color:#6366f1;margin-top:4px;">
                suma wszystkich
            </div>
        </div>

    </div>

    {{-- WYKRES --}}
    <div style="background:#fff;padding:24px;border-radius:18px;box-shadow:0 20px 50px rgba(0,0,0,.12);">
        <h4 style="margin:0 0 14px;">📅 Naklejki – bieżący miesiąc</h4>

        @if($stampsByDay->isEmpty())
            <p style="color:#666;">Brak danych w tym miesiącu.</p>
        @else
            <div style="display:flex;align-items:flex-end;gap:8px;height:220px;">

                @php
                    $max = $stampsByDay->max('total') ?: 1;
                @endphp

                @foreach($stampsByDay as $row)
                    @php $height = round(($row->total / $max) * 100); @endphp

                    <div style="flex:1;text-align:center;">
                        <div style="
                            height:{{ $height }}%;
                            background:linear-gradient(180deg,#6a5af9,#ff5fa2);
                            border-radius:8px 8px 0 0;
                        "></div>

                        <div style="font-size:11px;color:#666;margin-top:6px;">
                            {{ \Carbon\Carbon::parse($row->day)->format('d') }}
                        </div>
                        <div style="font-size:12px;font-weight:700;">
                            {{ $row->total }}
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </div>


    {{-- 🏆 TOP FIRMY (SaaS UI) --}}
    <div style="margin-top:60px;">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:18px;">
            <div>
                <h3 style="margin:0;">🏆 Top firmy</h3>
                <div style="font-size:13px;color:#6b7280;margin-top:6px;">
                    Ranking po liczbie naklejek (łącznie) + szybki podgląd klientów
                </div>
            </div>
        </div>

        <div style="
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
            gap:20px;
        ">

            @forelse($topFirms as $index => $firm)
                <div style="
                    background:#ffffff;
                    border-radius:18px;
                    padding:20px;
                    box-shadow:0 12px 30px rgba(0,0,0,.08);
                    position:relative;
                    overflow:hidden;
                ">

                    {{-- RANK --}}
                    <div style="
                        position:absolute;
                        top:-12px;
                        right:-12px;
                        background:linear-gradient(135deg,#6a5af9,#ff5fa2);
                        color:#fff;
                        font-weight:800;
                        border-radius:999px;
                        width:38px;
                        height:38px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        box-shadow:0 10px 20px rgba(0,0,0,.15);
                    ">
                        {{ $index + 1 }}
                    </div>

                    {{-- FIRMA --}}
                    <div style="font-size:18px;font-weight:800;margin-bottom:4px;">
                        {{ $firm->name }}
                    </div>

                    <div style="font-size:13px;color:#6b7280;margin-bottom:14px;">
                        slug: <b>{{ $firm->slug }}</b>
                    </div>

                    {{-- METRYKI --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">

                        <div style="background:#f9fafb;padding:12px;border-radius:12px;">
                            <div style="font-size:12px;color:#6b7280;">Naklejki</div>
                            <div style="font-size:22px;font-weight:800;">
                                {{ $firm->total_stamps }}
                            </div>
                            <div style="font-size:12px;color:#6366f1;">
                                +{{ $firm->month_stamps }} w tym miesiącu
                            </div>
                        </div>

                        <div style="background:#f9fafb;padding:12px;border-radius:12px;">
                            <div style="font-size:12px;color:#6b7280;">Klienci</div>
                            <div style="font-size:22px;font-weight:800;">
                                {{ $firm->total_clients }}
                            </div>
                            <div style="font-size:12px;color:#22c55e;">
                                +{{ $firm->month_clients }} w tym miesiącu
                            </div>
                        </div>

                    </div>

                    {{-- CTA --}}
                    <a href="{{ route('admin.firms.edit', $firm->slug) }}"
                       style="
                            display:block;
                            margin-top:14px;
                            text-align:center;
                            padding:10px 12px;
                            border-radius:12px;
                            background:#f1f5f9;
                            font-weight:700;
                            color:#111827;
                            transition:all .15s ease;
                       ">
                        Zarządzaj firmą →
                    </a>

                </div>
            @empty
                <div style="background:#fff;padding:20px;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.08);color:#666;">
                    Brak danych do rankingu.
                </div>
            @endforelse

        </div>
    </div>

</div>
@endsection
