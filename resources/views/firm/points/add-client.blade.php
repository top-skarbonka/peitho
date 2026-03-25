@extends('layouts.app')

@section('content')

<div class="container">

<h2>Dodaj punkty klientowi</h2>

@if(session('success'))
<div style="background:#d4edda;padding:10px;margin-bottom:15px;border-radius:6px;">
{{ session('success') }}
</div>
@endif

@if ($errors->any())
<div style="background:#ffe6e6;padding:10px;margin-bottom:15px;border-radius:6px;">
{{ $errors->first() }}
</div>
@endif

<form method="POST" action="{{ route('company.points.client.store') }}">
@csrf

<div style="margin-bottom:15px;">
<label>Numer telefonu klienta</label>

<input
type="text"
name="phone"
id="phone"
placeholder="np. 732287103"
required
style="padding:8px;width:250px;"
>
</div>

<div style="margin-bottom:15px;">
<label>Kwota paragonu</label>

<input
type="number"
name="amount"
min="1"
required
style="padding:8px;width:150px;"
>
</div>

<button type="submit" style="padding:10px 20px;">
Dodaj punkty
</button>

</form>

<hr style="margin:30px 0;">

<h3>Sprawdź i wykorzystaj punkty</h3>

<div style="margin-bottom:15px;">
<input
type="text"
id="check_phone"
placeholder="Wpisz numer telefonu"
oninput="autoCheckClient()"
style="padding:8px;width:250px;"
>
</div>

<button onclick="checkClient()" style="padding:10px 20px;">
Sprawdź punkty
</button>

<div id="clientBox" style="margin-top:20px;"></div>

</div>

<script>
const redeemUrl = "{{ route('company.points.redeem') }}";

let typingTimer;
const delay = 500;

function autoCheckClient() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
        checkClient();
    }, delay);
}

function checkClient() {
    const phone = document.getElementById('check_phone').value;

    if (phone.length < 6) return;

    fetch('/api/client-points?phone=' + phone)
        .then(res => res.json())
        .then(data => {

            if (!data.success) {
                document.getElementById('clientBox').innerHTML = 'Nie znaleziono klienta';
                return;
            }

            let statusColor = '#ccc';
            let statusText = data.status;

            if (data.status === 'VIP') statusColor = '#28a745';
            if (data.status === 'aktywny') statusColor = '#ffc107';
            if (data.status === 'śpioch') statusColor = '#dc3545';

            let html = `
                <div style="margin-bottom:10px;">
                    <span style="background:${statusColor};color:white;padding:6px 12px;border-radius:20px;font-weight:bold;">
                        ${statusText}
                    </span>
                </div>
            `;

            html += `<h3>Masz: ${data.points} pkt</h3>`;

            if (data.rewards.length > 0) {
                html += `
                <div style="background:#d4edda;padding:12px;margin:10px 0;border-radius:8px;font-weight:bold;">
                    🎉 Klient ma dostępne rabaty!
                </div>
                `;
            } else {
                html += `
                <div style="background:#fff3cd;padding:12px;margin:10px 0;border-radius:8px;">
                    ℹ️ Brak dostępnych rabatów
                </div>
                `;
            }

            if (data.next_reward) {

                const missing = data.next_reward.points_required - data.points;
                const estimatedAmount = missing * data.points_per_currency;

                html += `
                <div style="background:#e2e3ff;padding:12px;margin:10px 0;border-radius:8px;">
                    💡 Brakuje tylko <b>${missing} pkt</b> (~${estimatedAmount} zł zakupów)
                    do nagrody <b>${data.next_reward.label}</b>
                </div>

                <div style="background:#d1ecf1;padding:12px;margin:10px 0;border-radius:8px;font-weight:bold;">
                    🧠 Podpowiedź: Klient może dopłacić tylko ${estimatedAmount} zł i odebrać rabat ${data.next_reward.label}
                </div>
                `;
            }

            html += '<div style="margin-top:10px;">';

            // 🔥 NOWE — znajdź najlepszy reward
            const bestReward = data.rewards.reduce((max, r) => r.reward_value > max.reward_value ? r : max, data.rewards[0]);

            data.rewards.forEach(r => {

                const remaining = data.points - r.points_required;
                const isBest = r.id === bestReward.id;

                const bg = isBest ? '#5aa04f' : '#6a5af9';
                const label = isBest ? '🔥 NAJLEPSZY WYBÓR<br>' : '';

                html += `
                <form method="POST" action="${redeemUrl}" 
                      onsubmit="return confirm('Na pewno wykorzystać ${r.label}? Zostanie ${remaining} pkt.');"
                      style="margin-bottom:10px;">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="client_id" value="${data.client_id}">
                    <input type="hidden" name="points" value="${r.points_required}">

                    <button 
                        type="submit"
                        onclick="this.disabled=true; this.innerText='Przetwarzanie...'; this.form.submit();"
                        style="width:260px;padding:12px;background:${bg};color:white;border:none;border-radius:10px;cursor:pointer;">

                        ${label}
                        ${r.points_required} pkt → ${r.label}<br>
                        <small>Zostanie: ${remaining} pkt</small>

                    </button>
                </form>
                `;
            });

            html += '</div>';

            document.getElementById('clientBox').innerHTML = html;
        });
}
</script>

@endsection
