@extends('layouts.firm')

@section('content')
<div class="container-fluid">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold mb-1">🎫 Wydane karnety</h4>
                    <p class="text-muted mb-0">
                        Lista aktywnych i zakończonych karnetów klientów
                    </p>
                </div>

                <a href="{{ route('company.passes.issue_form') }}"
                   class="btn btn-primary rounded-pill px-4">
                    + Wydaj karnet
                </a>
            </div>

            <form method="GET"
                  action="{{ route('company.passes.index') }}"
                  class="row g-3 mb-4">

                <div class="col-md-4">
                    <input type="text"
                           name="q"
                           value="{{ $q ?? '' }}"
                           class="form-control rounded-pill"
                           placeholder="Szukaj po numerze telefonu np. 732287103">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100 rounded-pill">
                        Szukaj
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('company.passes.index') }}"
                       class="btn btn-outline-secondary w-100 rounded-pill">
                        Reset
                    </a>
                </div>

            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Telefon</th>
                            <th>Typ</th>
                            <th>Wejścia</th>
                            <th>Pozostało</th>
                            <th>Status</th>
                            <th>Aktywacja</th>
                            <th>Utworzono</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($passes as $p)
                            <tr>
                                <td>#{{ $p->id }}</td>
                                <td>{{ $p->phone }}</td>
                                <td>{{ $p->pass_type_name }}</td>
                                <td>{{ $p->total_entries }}</td>
                                <td>{{ $p->remaining_entries }}</td>
                                <td>
                                    @if($p->status === 'active')
                                        <span class="badge bg-success-subtle text-success">
                                            Aktywny
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $p->activated_at
                                        ? \Illuminate\Support\Carbon::parse($p->activated_at)->format('d.m.Y H:i')
                                        : '-' }}
                                </td>
                                <td>
                                    {{ $p->created_at
                                        ? \Illuminate\Support\Carbon::parse($p->created_at)->format('d.m.Y H:i')
                                        : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    Brak karnetów do wyświetlenia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($passes, 'links'))
                <div class="mt-4">
                    {{ $passes->links() }}
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
