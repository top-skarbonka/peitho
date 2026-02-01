{{-- ===============================
📊 STATYSTYKI – DASHBOARD FIRMY
Mobile-first, KPI boxes
=============================== --}}

<div style="
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
    gap:16px;
    margin-top:24px;
">

    {{-- KLIENCI --}}
    <div style="
        background:#fff;
        padding:20px;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    ">
        <div style="color:#64748b;font-size:15px;margin-bottom:8px;">
            Klienci
        </div>
        <div style="font-size:36px;font-weight:800;color:#0f172a;">
            {{ $stats['clients'] ?? 0 }}
        </div>
    </div>

    {{-- TRANSAKCJE --}}
    <div style="
        background:#fff;
        padding:20px;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    ">
        <div style="color:#64748b;font-size:15px;margin-bottom:8px;">
            Transakcje
        </div>
        <div style="font-size:36px;font-weight:800;color:#0f172a;">
            {{ $stats['transactions'] ?? 0 }}
        </div>
    </div>

    {{-- SUMA PUNKTÓW --}}
    <div style="
        background:#fff;
        padding:20px;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    ">
        <div style="color:#64748b;font-size:15px;margin-bottom:8px;">
            Suma punktów
        </div>
        <div style="font-size:36px;font-weight:800;color:#0f172a;">
            {{ number_format($stats['points'] ?? 0, 2, ',', ' ') }}
        </div>
    </div>

    {{-- ŚREDNIO / TRANSAKCJĘ --}}
    <div style="
        background:#fff;
        padding:20px;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    ">
        <div style="color:#64748b;font-size:15px;margin-bottom:8px;">
            Średnio / transakcję
        </div>
        <div style="font-size:36px;font-weight:800;color:#0f172a;">
            {{ number_format($stats['avg'] ?? 0, 2, ',', ' ') }}
        </div>
    </div>

</div>
