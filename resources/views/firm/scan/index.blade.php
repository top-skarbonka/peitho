@extends('firm.layout.app')

@section('content')

{{-- 🔥 MOBILE ONLY: chowamy boczne menu TYLKO w tej zakładce --}}
<style>
@media (max-width: 768px) {
    aside {
        display: none !important;
    }
    main {
        padding: 12px !important;
    }
}
</style>

<div class="mx-auto max-w-md">

    <h1 class="text-xl font-bold mb-3 flex items-center gap-2">
        📷 Skanuj kartę klienta
    </h1>

    <p class="text-sm text-slate-600 mb-4">
        Najedź kamerą na kod QR z karty klienta. Naklejka zostanie dodana automatycznie.
    </p>

    {{-- KOMUNIKATY --}}
    @if(session('error'))
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- SKANER --}}
    <div id="qr-reader" class="w-full"></div>

    {{-- FALLBACK --}}
    <form method="POST" action="{{ route('company.scan') }}" class="mt-5">
        @csrf
        <label class="block mb-1 text-xs text-slate-500">
            Lub wklej kod ręcznie:
        </label>
        <input
            type="text"
            name="code"
            placeholder="np. CARD:123"
            class="w-full text-lg p-3 border border-slate-300 rounded-xl"
        >
    </form>
</div>

{{-- QR LIB --}}
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const qr = new Html5Qrcode("qr-reader");

    qr.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: { width: 280, height: 280 }
        },
        function(decodedText) {
            qr.stop();

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('company.scan') }}";

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";

            const code = document.createElement('input');
            code.type = 'hidden';
            code.name = 'code';
            code.value = decodedText;

            form.appendChild(csrf);
            form.appendChild(code);
            document.body.appendChild(form);
            form.submit();
        }
    );
});
</script>
@endsection
