@extends('layouts.firm')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="mb-0">Wydane karnety</h2>
        <a href="{{ route('company.passes.issue_form') }}" class="btn btn-primary">
            + Wydaj karnet
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('company.passes.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input
                type="text"
                name="q"
                value="{{ $q ?? '' }}"
                class="form-control"
                placeholder="Szukaj po telefonie…"
            >
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100" type="submit">Szukaj</button>
        </div>
        <div class="col-md-2">
            <a class="btn btn-outline-light w-100" href="{{ route('company.passes.index') }}">Reset</a>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Telefon</th>
                            <th>Typ karnetu</th>
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
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->phone }}</td>
                                <td>{{ $p->pass_type_name }}</td>
                                <td>{{ $p->total_entries }}</td>
                                <td>{{ $p->remaining_entries }}</td>
                                <td>{{ $p->status }}</td>
                                <td>{{ $p->activated_at ? \Illuminate\Support\Carbon::parse($p->activated_at)->format('d.m.Y H:i') : '-' }}</td>
                                <td>{{ $p->created_at ? \Illuminate\Support\Carbon::parse($p->created_at)->format('d.m.Y H:i') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    Brak karnetów do wyświetlenia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if(method_exists($passes, 'links'))
            <div class="card-footer">
                {{ $passes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
