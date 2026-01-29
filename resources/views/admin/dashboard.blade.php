@extends('layouts.public')

@section('content')
<div style="max-width:1200px;margin:40px auto;padding:32px;">

    {{-- ================= HEADER ================= --}}
    <div style="margin-bottom:32px;">
        <h1 style="margin:0;font-size:28px;font-weight:800;">Panel administracyjny</h1>
        <p style="margin-top:6px;color:#6b7280;">
            Globalny przegląd systemu lojalnościowego
        </p>
    </div>

    {{-- ================= STATUS FIRM ================= --}}
    <div style="
        background:#ffffff;
        padding:20px 24px;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
        display:flex;
        gap:28px;
        margin-bottom:28px;
        align-items:center;
    ">

        <strong>Status firm</strong>

        <div class="status-tooltip active">
            ● Aktywne ({{ $activeCount }})
            <span class="tooltip">
                Firmy regularnie korzystające z programu lojalnościowego
            </span>
        </div>

        <div class="status-tooltip contact">
            ● Do kontaktu ({{ $contactCount }})
            <span class="tooltip">
                Brak aktywności od dłuższego czasu – warto się skontaktować
            </span>
        </div>

        <div class="status-tooltip danger">
            ● Zagrożone ({{ $dangerCount }})
            <span class="tooltip">
                Długa nieaktywność – wysokie ryzyko rezygnacji z programu
            </span>
        </div>

    </div>

    {{-- ================= FIRMY DO REAKCJI ================= --}}
    <div style="
        background:#ffffff;
        padding:22px 24px;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
        margin-bottom:40px;
    ">
        <h3 style="margin:0 0 16px;">📋 Firmy wymagające reakcji</h3>

        @forelse($needActionFirms as $firm)
            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                padding:12px 0;
                border-bottom:1px solid #e5e7eb;
            ">
                <div>
                    <strong>{{ $firm->name }}</strong><br>
                    <small style="color:#6b7280;">
                        Ostatnia aktywność: {{ $firm->last_activity_at->format('d.m.Y') }}
                    </small>
                </div>

                <a href="{{ route('admin.firms.edit', $firm->id) }}"
                   style="font-weight:700;color:#6366f1;">
                    Zarządzaj →
                </a>
            </div>
        @empty
            <p style="color:#6b7280;margin:0;">Brak firm wymagających reakcji 🎉</p>
        @endforelse
    </div>

    {{-- ================= KPI ================= --}}
    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:20px;
        margin-bottom:50px;
    ">
        @php
            $kpis = [
                ['Firmy – łącznie', $firmsTotal, $from->format('d.m.Y').' – '.$to->format('d.m.Y')],
                ['Firmy – dziś', $firmsToday, $today->format('d.m.Y')],
                ['Naklejki – łącznie', $stampsTotal, $from->format('d.m.Y').' – '.$to->format('d.m.Y')],
                ['Naklejki – dziś', $stampsToday, $today->format('d.m.Y')],
            ];
        @endphp

        @foreach($kpis as [$label,$value,$date])
            <div style="
                background:#ffffff;
                padding:22px;
                border-radius:18px;
                box-shadow:0 10px 30px rgba(0,0,0,.08);
            ">
                <div style="color:#6b7280;font-size:13px;">{{ $label }}</div>
                <div style="font-size:32px;font-weight:800;margin:6px 0;">{{ $value }}</div>
                <div style="font-size:12px;color:#9ca3af;">{{ $date }}</div>
            </div>
        @endforeach
    </div>

    {{-- ================= WYKRES ================= --}}
    <div style="
        background:#ffffff;
        padding:28px;
        border-radius:22px;
        box-shadow:0 20px 50px rgba(0,0,0,.12);
        margin-bottom:60px;
    ">
        <h3 style="margin-bottom:18px;">📈 Naklejki – bieżący miesiąc</h3>

        @php
            $max = max($stampsByDay->pluck('total')->max(), 1);
            $count = max($stampsByDay->count(), 2);
            $points = [];

            foreach ($stampsByDay as $i => $row) {
                $x = 60 + ($i / ($count - 1)) * 900;
                $y = 260 - ($row->total / $max) * 180;
                $points[] = [$x, $y];
            }

            $path = '';
            if(count($points)) {
                $path = 'M '.$points[0][0].' '.$points[0][1];
                for ($i = 1; $i < count($points); $i++) {
                    $prev = $points[$i-1];
                    $curr = $points[$i];
                    $cx = ($prev[0] + $curr[0]) / 2;
                    $path .= " Q $cx {$prev[1]} {$curr[0]} {$curr[1]}";
                }
            }
        @endphp

        <svg viewBox="0 0 1020 320" width="100%" height="320">
            <defs>
                <linearGradient id="lineGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#6366f1" stop-opacity="0.35"/>
                    <stop offset="100%" stop-color="#6366f1" stop-opacity="0"/>
                </linearGradient>
            </defs>

            <line x1="40" y1="260" x2="980" y2="260" stroke="#e5e7eb"/>

            @if($path)
                <path d="{{ $path }} L 980 260 L 60 260 Z" fill="url(#lineGrad)"/>
                <path d="{{ $path }}"
                      fill="none"
                      stroke="#6366f1"
                      stroke-width="4"
                      stroke-linecap="round"/>
            @endif
        </svg>
    </div>

    {{-- ================= TOP FIRMY ================= --}}
    <h3 style="margin-bottom:20px;">🏆 Najbardziej aktywne firmy</h3>

    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
        gap:22px;
    ">
        @foreach($topFirms as $i => $firm)
            <div style="
                background:#ffffff;
                padding:22px;
                border-radius:20px;
                box-shadow:0 14px 40px rgba(0,0,0,.10);
            ">
                <strong>#{{ $i+1 }} {{ $firm->name }}</strong><br>
                <small style="color:#6b7280;">{{ $firm->slug }}</small>

                <div style="margin-top:12px;font-size:22px;font-weight:800;">
                    {{ $firm->total_stamps }} naklejek
                </div>

                <a href="{{ route('admin.firms.edit', $firm->id) }}"
                   style="
                        display:block;
                        margin-top:16px;
                        padding:12px;
                        border-radius:14px;
                        background:#6366f1;
                        color:#fff;
                        text-align:center;
                        font-weight:700;
                   ">
                    Zarządzaj firmą →
                </a>
            </div>
        @endforeach
    </div>

</div>

{{-- ================= TOOLTIP CSS ================= --}}
<style>
.status-tooltip {
    position: relative;
    font-weight: 600;
    cursor: default;
}

.status-tooltip .tooltip {
    position: absolute;
    bottom: 140%;
    left: 0;
    background: #111827;
    color: #ffffff;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 13px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transform: translateY(6px);
    transition: all .2s ease;
    box-shadow: 0 12px 30px rgba(0,0,0,.25);
    z-index: 100;
}

.status-tooltip:hover .tooltip {
    opacity: 1;
    transform: translateY(0);
}

.status-tooltip.active { color:#16a34a; }
.status-tooltip.contact { color:#f59e0b; }
.status-tooltip.danger { color:#ef4444; }
</style>
@endsection
