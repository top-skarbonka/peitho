@extends('firm.layout.app')

@section('title', 'Zmiana hasła')

@section('content')
<div class="max-w-xl mx-auto">

    <div class="page-header">
        <h1>🔐 Zmiana hasła</h1>
        <p class="page-desc">
            Ustaw nowe hasło do swojego konta firmowego.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-box">
        <form method="POST" action="{{ route('company.password.update') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nowe hasło</label>
                <input
                    type="password"
                    name="password"
                    class="w-full px-4 py-2 border rounded-lg"
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Powtórz hasło</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full px-4 py-2 border rounded-lg"
                    required
                >
            </div>

            <button
                type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold"
            >
                Zapisz nowe hasło
            </button>
        </form>
    </div>
</div>
@endsection
