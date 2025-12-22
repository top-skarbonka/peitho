@extends('firm.layout.app')

@section('content')

<style>
.page-wrap{
  padding: 28px 28px 40px;
}
.page-head{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  margin-bottom:24px;
}
.title{
  font-size:34px;
  font-weight:800;
  margin:0;
}
.subtitle{
  margin-top:6px;
  color:rgba(0,0,0,.55);
}
.stats{
  display:grid;
  grid-template-columns: repeat(4,1fr);
  gap:16px;
  margin-bottom:24px;
}
.stat{
  background:#fff;
  border-radius:16px;
  padding:16px;
  box-shadow:0 12px 30px rgba(0,0,0,.06);
}
.stat-label{
  font-size:13px;
  color:#777;
}
.stat-value{
  font-size:32px;
  font-weight:800;
}
.card{
  background:#fff;
  border-radius:18px;
  box-shadow:0 18px 50px rgba(0,0,0,.08);
  overflow:hidden;
}
.card-head{
  padding:16px 18px;
  border-bottom:1px solid #eee;
  font-weight:800;
}
table{
  width:100%;
  border-collapse:collapse;
}
th,td{
  padding:14px 18px;
  border-top:1px solid #eee;
}
th{
  font-size:13px;
  color:#777;
  text-align:left;
}
.badge{
  padding:6px 10px;
  border-radius:999px;
  font-size:12px;
  font-weight:800;
}
.badge-active{ background:#ecebff; color:#3a2fff; }
.badge-redeemed{ background:#e8f7ef; color:#1f8f4d; }
.btn{
  background:linear-gradient(135deg,#4a3aff,#9b59ff);
  color:#fff;
  border-radius:999px;
  padding:10px 14px;
  border:0;
  cursor:pointer;
  font-weight:800;
}
</style>

<div class="page-wrap">

  <div class="page-head">
    <div>
      <h1 class="title">⭐ Karty lojalnościowe</h1>
      <p class="subtitle">Karty stałego klienta (wizyty / naklejki)</p>
    </div>
  </div>

  <div class="stats">
    <div class="stat">
      <div class="stat-label">Karty</div>
      <div class="stat-value">{{ $stats['cards'] ?? 0 }}</div>
    </div>
    <div class="stat">
      <div class="stat-label">Naklejki łącznie</div>
      <div class="stat-value">{{ $stats['stamps'] ?? 0 }}</div>
    </div>
    <div class="stat">
      <div class="stat-label">Pełne karty</div>
      <div class="stat-value">{{ $stats['full'] ?? 0 }}</div>
    </div>
    <div class="stat">
      <div class="stat-label">Aktywne (30 dni)</div>
      <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">Lista kart</div>

    <table>
      <thead>
        <tr>
          <th>Klient</th>
          <th>Postęp</th>
          <th>Status</th>
          <th>Utworzono</th>
          <th>Akcja</th>
        </tr>
      </thead>
      <tbody>
        @forelse($cards as $card)
          <tr>
            <td>{{ $card->client->phone ?? '—' }}</td>
            <td>{{ $card->current_stamps }} / {{ $card->max_stamps }}</td>
            <td>
              @if($card->status === 'active')
                <span class="badge badge-active">active</span>
              @elseif($card->status === 'redeemed')
                <span class="badge badge-redeemed">redeemed</span>
              @else
                <span class="badge">—</span>
              @endif
            </td>
            <td>{{ $card->created_at->format('Y-m-d H:i') }}</td>
            <td>
              @if($card->status === 'active')
                <form method="POST" action="{{ route('firm.loyalty-cards.stamp', $card->id) }}">
                  @csrf
                  <button class="btn">+1 naklejka</button>
                </form>
              @else
                —
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5">Brak kart</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>

@endsection
