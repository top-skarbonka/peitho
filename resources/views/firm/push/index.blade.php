@extends('layouts.firm')

@section('content')

@php
    $firm = auth()->guard('company')->user();
@endphp

<div class="space-y-8">

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600 text-white shadow-xl">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.22),transparent_35%)]"></div>

        <div class="relative p-8 md:p-10">
            <div class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-sm font-semibold ring-1 ring-white/20 backdrop-blur">
                <span>📢</span>
                <span>Push premium</span>
            </div>

            <h1 class="mt-5 text-3xl md:text-4xl font-black tracking-tight">
                Centrum powiadomień push
            </h1>

            <p class="mt-3 max-w-3xl text-sm md:text-base text-white/90 leading-7">
                Tutaj będziesz zarządzać powiadomieniami push do klientów Twojej firmy.
                Moduł jest już aktywny, a w kolejnym kroku podłączymy gotowe kampanie,
                segmenty odbiorców i wysyłkę zgodną z ustawieniami zgód.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <div class="rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/15 backdrop-blur">
                    <div class="text-xs uppercase tracking-wide text-white/70">Status modułu</div>
                    <div class="mt-1 text-lg font-extrabold">Aktywny</div>
                </div>

                <div class="rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/15 backdrop-blur">
                    <div class="text-xs uppercase tracking-wide text-white/70">Firma</div>
                    <div class="mt-1 text-lg font-extrabold">{{ $firm->name ?? '—' }}</div>
                </div>

                <div class="rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/15 backdrop-blur">
                    <div class="text-xs uppercase tracking-wide text-white/70">Dostęp</div>
                    <div class="mt-1 text-lg font-extrabold">Premium</div>
                </div>
            </div>
        </div>
    </div>

    {{-- KPI PREVIEW --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="text-sm font-semibold text-slate-500">Klienci ze zgodą push</div>
            <div class="mt-3 text-4xl font-black text-slate-900">—</div>
            <div class="mt-2 text-sm text-slate-500">
                W kolejnym etapie pokażemy tu realną liczbę klientów ze zgodą.
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="text-sm font-semibold text-slate-500">Gotowe kampanie</div>
            <div class="mt-3 text-4xl font-black text-slate-900">0</div>
            <div class="mt-2 text-sm text-slate-500">
                Będziesz mieć szybkie szablony typu: nagroda czeka, wróć po bonus, nowa promocja.
            </div>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="text-sm font-semibold text-slate-500">Ostatnia wysyłka</div>
            <div class="mt-3 text-4xl font-black text-slate-900">—</div>
            <div class="mt-2 text-sm text-slate-500">
                Historia wysyłek pojawi się po wdrożeniu panelu kampanii.
            </div>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- LEFT --}}
        <div class="xl:col-span-2 space-y-6">

            <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-slate-200">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900">
                            Co będzie tutaj dostępne
                        </h2>
                        <p class="mt-2 text-slate-600 leading-7">
                            Ten ekran jest gotowym miejscem pod dalszą rozbudowę modułu push.
                            Zadbaliśmy już o fundamenty techniczne i dostęp premium per firma.
                        </p>
                    </div>

                    <div class="hidden md:flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-2xl ring-1 ring-indigo-100">
                        🚀
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <div class="text-base font-bold text-slate-900">Gotowe kampanie</div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Szybka wysyłka do klientów ze zgodą push, np. o dostępnej nagrodzie,
                            promocji dnia albo przypomnieniu o powrocie.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <div class="text-base font-bold text-slate-900">Segmentacja odbiorców</div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Wysyłka tylko do określonych grup, np. klientów z punktami,
                            klientów nieaktywnych albo tych, którzy mają gotową nagrodę.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <div class="text-base font-bold text-slate-900">Historia wysyłek</div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Pełna lista kampanii, statusów i statystyk, żeby wszystko było
                            czytelne i łatwe do kontrolowania.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <div class="text-base font-bold text-slate-900">Bezpieczne zgody</div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            Wysyłka tylko do klientów, którzy mają aktywną zgodę push,
                            niezależną od zgód SMS i e-mail.
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-slate-200">
                <h2 class="text-2xl font-black text-slate-900">
                    Priorytety wdrożenia
                </h2>

                <div class="mt-6 space-y-4">
                    <div class="flex gap-4 rounded-2xl border border-slate-200 p-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white">1</div>
                        <div>
                            <div class="font-bold text-slate-900">Zliczanie odbiorców push</div>
                            <div class="mt-1 text-sm leading-6 text-slate-600">
                                Policzymy klientów z aktywną zgodą push dla tej firmy.
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 rounded-2xl border border-slate-200 p-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-600 text-sm font-black text-white">2</div>
                        <div>
                            <div class="font-bold text-slate-900">Pierwsza kampania testowa</div>
                            <div class="mt-1 text-sm leading-6 text-slate-600">
                                Dodamy bezpieczny formularz wysyłki do klientów ze zgodą.
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 rounded-2xl border border-slate-200 p-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-fuchsia-600 text-sm font-black text-white">3</div>
                        <div>
                            <div class="font-bold text-slate-900">Gotowe scenariusze sprzedażowe</div>
                            <div class="mt-1 text-sm leading-6 text-slate-600">
                                Na przykład: „Masz już nagrodę”, „Wróć po bonus”, „Nowa promocja”.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-slate-200">
                <h3 class="text-xl font-black text-slate-900">Panel aktywny</h3>

                <div class="mt-5 rounded-2xl bg-emerald-50 p-4 ring-1 ring-emerald-100">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-500 text-xl text-white">
                            ✓
                        </div>
                        <div>
                            <div class="font-bold text-emerald-900">Push premium włączony</div>
                            <div class="text-sm text-emerald-700">
                                Firma ma dostęp do modułu push.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-sm leading-6 text-slate-600">
                    Admin aktywował tę funkcję dla Twojej firmy, więc ten moduł jest gotowy
                    pod dalszą rozbudowę.
                </div>
            </div>

            <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-slate-200">
                <h3 class="text-xl font-black text-slate-900">Ważne zasady</h3>

                <ul class="mt-5 space-y-3 text-sm leading-6 text-slate-600">
                    <li class="flex gap-3">
                        <span class="mt-1">•</span>
                        <span>Powiadomienia push są osobnym kanałem i wymagają osobnej zgody klienta.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-1">•</span>
                        <span>Brak zgody push oznacza brak wysyłki, nawet jeśli klient ma zgodę SMS lub e-mail.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-1">•</span>
                        <span>Moduł jest przygotowywany z myślą o zgodności z RODO i polskimi wymogami komunikacji marketingowej.</span>
                    </li>
                </ul>
            </div>

            <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-7">
                <div class="text-sm font-semibold uppercase tracking-wide text-slate-500">
                    Następny etap
                </div>
                <div class="mt-2 text-2xl font-black text-slate-900">
                    Formularz kampanii push
                </div>
                <p class="mt-3 text-sm leading-6 text-slate-600">
                    W następnym kroku podłączymy tutaj pierwszy realny ekran wysyłki.
                </p>
            </div>
        </div>
    </div>
</div>

@endsection
