@extends('firm.layout.app')

@section('content')
<style>
    @media (max-width: 768px) {
        aside { display: none !important; }
        main { padding: 0 !important; }
        body { background: #000; }
    }

    .scanner-wrapper {
        position: relative;
    }

    .scan-frame {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 220px;
        height: 220px;
        transform: translate(-50%, -50%);
        border: 3px solid rgba(99,102,241,0.95);
        border-radius: 18px;
        box-shadow: 0 0 0 9999px rgba(0,0,0,0.45);
        pointer-events: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .scan-frame.success {
        border-color: #22c55e;
        box-shadow:
            0 0 0 9999px rgba(0,0,0,0.45),
            0 0 25px #22c55e;
    }

    .scan-line {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #6366f1, transparent);
        animation: scan 2s linear infinite;
    }

    @keyframes scan {
        0% { top: 0; }
        100% { top: 100%; }
    }
</style>

<div class="min-h-screen flex flex-col items-center justify-center bg-black text-white">

    {{-- HEADER --}}
    <div class="text-center mb-4">
        <h1 class="text-lg font-bold tracking-wide">📷 SKANUJ KARTĘ</h1>
        <p class="text-sm text-slate-300">
            Umieść kod QR w kwadracie
        </p>
    </div>

    {{-- BLOKADA --}}
    @if(session('lock_seconds'))
        <div class="mb-4 px-6 py-4 rounded-2xl bg-yellow-400 text-black text-center font-extrabold text-lg">
            ⏳ Odczekaj <span id="seconds">{{ session('lock_seconds') }}</span> s
        </div>

        <script>
            let seconds = {{ session('lock_seconds') }};
            const el = document.getElementById('seconds');

            const timer = setInterval(() => {
                seconds--;
                if (seconds <= 0) {
                    clearInterval(timer);
                    location.reload();
                } else {
                    el.innerText = seconds;
                }
            }, 1000);
        </script>
    @endif

    {{-- KOMUNIKATY --}}
    @if(session('error') && !session('lock_seconds'))
        <div class="mb-4 px-5 py-3 rounded-xl bg-red-600 text-white text-center font-bold">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 px-5 py-3 rounded-xl bg-green-600 text-white text-center font-bold">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- SKANER --}}
    <div class="scanner-wrapper w-full max-w-sm aspect-square rounded-2xl overflow-hidden border-4 border-indigo-500 shadow-2xl">
        <div id="qr-reader" class="w-full h-full"></div>

        {{-- RAMKA OSTROŚCI --}}
        <div id="frame" class="scan-frame">
            <div class="scan-line"></div>
        </div>
    </div>

    {{-- STOPKA --}}
    <div class="mt-6 text-xs text-slate-400 text-center px-6">
        Jedna karta = jedna naklejka co 120 sekund
    </div>

</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const frame = document.getElementById('frame');

    function feedbackOk() {
        // 📳 WIBRACJA
        if (navigator.vibrate) {
            navigator.vibrate([100, 50, 100]);
        }

        // 🔊 BEEP
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();

            osc.type = 'sine';
            osc.frequency.value = 880;
            gain.gain.value = 0.15;

            osc.connect(gain);
            gain.connect(ctx.destination);

            osc.start();
            setTimeout(() => {
                osc.stop();
                ctx.close();
            }, 120);
        } catch (e) {}

        // 🟢 FLASH RAMKI
        frame.classList.add('success');
    }

    const qr = new Html5Qrcode("qr-reader");

    qr.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: { width: 220, height: 220 } },
        function(decodedText) {

            feedbackOk();
            qr.stop();

            setTimeout(() => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('company.scan') }}";

                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="code" value="${decodedText}">
                `;

                document.body.appendChild(form);
                form.submit();
            }, 350);
        }
    );
});
</script>
@endsection
