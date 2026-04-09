<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{{ $firm->name }} – karta klienta</title>

<link rel="icon" type="image/png" href="/favicon.png">
<link rel="shortcut icon" href="/favicon.png">
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#5b63d3">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ $firm->name }}">
<link rel="apple-touch-icon" href="/icons/icon-192.png">

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
}

body{
    background:linear-gradient(180deg,#84c6f4 0%,#58a8ea 45%,#4f92e8 100%);
    min-height:100vh;
    color:#182033;
}

.page{
    width:100%;
    max-width:360px;
    margin:0 auto;
    padding:10px 8px 18px;
}

.phone-shell{
    background:#f7f8fc;
    border-radius:28px;
    box-shadow:0 18px 40px rgba(9,30,66,.20);
    overflow:hidden;
    min-height:calc(100vh - 20px);
    border:1px solid rgba(255,255,255,.35);
}

.app-header{
    background:linear-gradient(180deg,#6873dc 0%,#5964d1 100%);
    color:#fff;
    padding:12px 12px 14px;
}

.topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:10px;
}

.back-link{
    color:#fff;
    text-decoration:none;
    font-weight:800;
    font-size:13px;
    display:inline-flex;
    align-items:center;
    gap:6px;
}

.firm-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:rgba(255,255,255,.14);
    border:1px solid rgba(255,255,255,.16);
    padding:6px 10px;
    border-radius:999px;
    font-size:11px;
    font-weight:800;
}

.hero-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:10px;
}

.hero-copy{
    flex:1;
}

.hello{
    font-size:15px;
    font-weight:800;
    margin-bottom:3px;
    line-height:1.15;
}

.points-line{
    font-size:12px;
    color:rgba(255,255,255,.88);
}

.header-logo{
    width:42px;
    height:42px;
    border-radius:14px;
    background:rgba(255,255,255,.14);
    border:1px solid rgba(255,255,255,.16);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
    font-weight:900;
    color:#fff;
    flex:0 0 42px;
}

.barcode-card{
    margin-top:10px;
    background:#fff;
    border-radius:18px;
    padding:10px 10px 10px;
    box-shadow:0 8px 20px rgba(25,35,80,.10);
}

.barcode-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:8px;
    margin-bottom:6px;
}

.client-mini{
    font-size:11px;
    color:#5d6785;
    font-weight:700;
    line-height:1.15;
}

.client-points-mini{
    font-size:10px;
    color:#7a84a3;
    margin-top:2px;
    line-height:1.2;
}

.brand-mini{
    font-size:11px;
    font-weight:900;
    color:#5d64d2;
    text-align:right;
    line-height:1.15;
    max-width:120px;
}

.qr-wrap{
    display:flex;
    justify-content:center;
    align-items:center;
    padding:4px 0 2px;
}

.qr-wrap svg{
    width:122px;
    height:122px;
}

.phone-code{
    text-align:center;
    font-size:12px;
    letter-spacing:2px;
    font-weight:900;
    color:#1d2438;
    margin-top:2px;
}

.scan-note{
    margin-top:6px;
    text-align:center;
    font-size:11px;
    line-height:1.35;
    color:#6b7280;
}

.stats-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
    margin-top:10px;
}

.stat-card{
    background:rgba(255,255,255,.14);
    border:1px solid rgba(255,255,255,.16);
    color:#fff;
    border-radius:16px;
    padding:10px;
    min-height:78px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.stat-label{
    font-size:10px;
    color:rgba(255,255,255,.82);
    margin-bottom:4px;
}

.stat-value{
    font-size:22px;
    line-height:1;
    font-weight:900;
    word-break:break-word;
}

.stat-sub{
    margin-top:4px;
    font-size:10px;
    color:rgba(255,255,255,.82);
}

.thresholds-card{
    margin-top:8px;
    background:rgba(255,255,255,.10);
    border:1px solid rgba(255,255,255,.14);
    border-radius:16px;
    overflow:hidden;
}

.thresholds-summary{
    list-style:none;
    cursor:pointer;
    padding:11px 12px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
}

.thresholds-summary::-webkit-details-marker{
    display:none;
}

.thresholds-summary-left{
    display:flex;
    flex-direction:column;
    gap:2px;
}

.thresholds-title{
    font-size:11px;
    font-weight:800;
    color:#fff;
}

.thresholds-subtitle{
    font-size:10px;
    color:rgba(255,255,255,.82);
}

.thresholds-arrow{
    font-size:14px;
    color:#fff;
    transition:transform .2s ease;
}

.thresholds-card[open] .thresholds-arrow{
    transform:rotate(180deg);
}

.thresholds-list{
    display:grid;
    gap:6px;
    padding:0 10px 10px;
}

.threshold-item{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:10px;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.10);
    border-radius:12px;
    padding:8px 9px;
}

.threshold-label{
    font-size:10px;
    color:rgba(255,255,255,.82);
    line-height:1.25;
}

.threshold-value{
    text-align:right;
    font-size:11px;
    font-weight:900;
    color:#fff;
    line-height:1.2;
    white-space:nowrap;
}

.threshold-reward-list{
    display:grid;
    gap:6px;
    padding-top:2px;
}

.threshold-reward-item{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:10px;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.10);
    border-radius:12px;
    padding:8px 9px;
}

.threshold-reward-points{
    font-size:10px;
    color:rgba(255,255,255,.82);
    line-height:1.25;
}

.threshold-reward-name{
    text-align:right;
    font-size:11px;
    font-weight:900;
    color:#fff;
    line-height:1.2;
}

.content{
    padding:12px 10px 14px;
}

.section{
    margin-bottom:14px;
}

.section-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:8px;
    margin-bottom:8px;
}

.section-title{
    font-size:15px;
    font-weight:900;
    color:#182033;
}

.section-link{
    font-size:11px;
    color:#6570d8;
    font-weight:800;
    text-decoration:none;
}

.promo-row{
    display:flex;
    gap:8px;
    overflow-x:auto;
    padding-bottom:6px;
    scrollbar-width:none;
}
.promo-row::-webkit-scrollbar{
    display:none;
}

.promo-card{
    min-width:132px;
    max-width:132px;
    background:#fff;
    border:1px solid #e9ebf3;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(15,23,42,.06);
    flex:0 0 auto;
}

.promo-image{
    width:100%;
    height:86px;
    object-fit:cover;
    display:block;
    background:#edf1f7;
}

.promo-body{
    padding:9px;
}

.promo-title{
    font-size:11px;
    line-height:1.2;
    font-weight:900;
    color:#1b2238;
    min-height:26px;
    margin-bottom:4px;
}

.promo-text{
    font-size:10px;
    line-height:1.28;
    color:#6b7280;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
    min-height:25px;
}

.scroll-hint{
    margin-top:6px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    font-size:11px;
    color:#7a84a3;
}

.scroll-arrow{
    font-size:14px;
    line-height:1;
}

.tabs{
    display:flex;
    gap:6px;
    overflow-x:auto;
    padding-bottom:2px;
    scrollbar-width:none;
}
.tabs::-webkit-scrollbar{
    display:none;
}

.tab{
    flex:0 0 auto;
    padding:9px 11px;
    border-radius:14px;
    background:#eef1f8;
    color:#44506e;
    font-size:11px;
    font-weight:800;
    border:1px solid #e3e7f0;
    text-decoration:none;
}

.tab.active{
    background:#5d64d2;
    color:#fff;
    border-color:#5d64d2;
    box-shadow:0 6px 16px rgba(93,100,210,.22);
}

.cards-stack{
    margin-top:8px;
}

.info-card{
    background:#fff;
    border:1px solid #e8ebf3;
    border-radius:16px;
    padding:11px;
    margin-bottom:8px;
    box-shadow:0 6px 16px rgba(15,23,42,.05);
}

.info-card-top{
    display:flex;
    gap:10px;
    align-items:flex-start;
}

.info-thumb{
    width:44px;
    height:44px;
    border-radius:12px;
    object-fit:cover;
    background:#eef2f7;
    border:1px solid #e5e7eb;
    flex:0 0 44px;
}

.info-thumb-fallback{
    width:44px;
    height:44px;
    border-radius:12px;
    background:#eef1ff;
    color:#5d64d2;
    border:1px solid #dbe1ff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:14px;
    font-weight:900;
    flex:0 0 44px;
}

.info-main{
    flex:1;
    min-width:0;
}

.info-title{
    font-size:13px;
    font-weight:900;
    color:#182033;
    margin-bottom:3px;
    line-height:1.2;
}

.info-text{
    font-size:11px;
    color:#5f6780;
    line-height:1.35;
}

.info-meta{
    margin-top:6px;
    font-size:10px;
    color:#8a93aa;
}

.info-link{
    display:inline-flex;
    margin-top:8px;
    text-decoration:none;
    padding:8px 10px;
    border-radius:12px;
    background:#eef1ff;
    color:#4d57c8;
    font-size:11px;
    font-weight:800;
}

.info-link.secondary{
    background:#f3f4f6;
    color:#374151;
}

.location-line{
    font-size:11px;
    color:#5f6780;
    line-height:1.4;
    margin-top:2px;
}

.location-badge{
    display:inline-flex;
    margin-top:7px;
    padding:4px 8px;
    border-radius:999px;
    background:#eef1ff;
    color:#5d64d2;
    font-size:10px;
    font-weight:800;
}

.empty-box{
    background:#fff;
    border:1px dashed #d7dce8;
    border-radius:14px;
    padding:12px;
    font-size:11px;
    color:#6b7280;
}

.pdf-card{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    width:100%;
    padding:14px 12px;
    border-radius:16px;
    text-decoration:none;
    background:#4a4f73;
    border:1px solid rgba(0,0,0,.08);
    color:#fff;
    box-shadow:0 6px 16px rgba(15,23,42,.08);
}

.pdf-card-icon{
    font-size:18px;
    line-height:1;
}

.pdf-card-text{
    font-size:13px;
    font-weight:900;
    line-height:1.15;
}

.bottom-nav{
    position:sticky;
    bottom:0;
    background:#ffffffee;
    backdrop-filter:blur(10px);
    border-top:1px solid #e8ebf3;
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:4px;
    padding:8px 6px max(8px, env(safe-area-inset-bottom));
}

.bottom-item{
    text-align:center;
    font-size:9px;
    color:#6b7280;
    font-weight:700;
}

.bottom-item .icon{
    display:block;
    font-size:15px;
    margin-bottom:2px;
}

.bottom-item.active{
    color:#5d64d2;
}

@media (max-width:380px){
    .page{
        max-width:340px;
        padding:8px 6px 14px;
    }

    .phone-shell{
        border-radius:24px;
    }

    .hello{
        font-size:14px;
    }

    .stat-value{
        font-size:20px;
    }

    .promo-card{
        min-width:124px;
        max-width:124px;
    }

    .qr-wrap svg{
        width:112px;
        height:112px;
    }
}
</style>
</head>
<body>
<div class="page">
    <div class="phone-shell">

        <header class="app-header">
            <div class="topbar">
                <a href="{{ route('client.dashboard') }}" class="back-link">← Wróć</a>
                <div class="firm-badge">Karta firmy</div>
            </div>

            <div class="hero-head">
                <div class="hero-copy">
                    <div class="hello">{{ $firm->name }}</div>
                    <div class="points-line">Masz obecnie {{ $clientPoints ?? 0 }} pkt w programie</div>
                </div>

                <div class="header-logo">
                    {{ mb_strtoupper(mb_substr($firm->name, 0, 1)) }}
                </div>
            </div>

            @php
                $availableRewardDisplay = 'Brak';

                if (!empty($availableReward)) {
                    $rewardName = trim((string) ($availableReward->reward_name ?? ''));

                    if ($rewardName !== '') {
                        if (preg_match('/(\d+(?:[.,]\d+)?)\s*zł/iu', $rewardName, $matches)) {
                            $amount = str_replace('.', ',', $matches[1]);
                            $availableRewardDisplay = $amount . ' zł';
                        } else {
                            $availableRewardDisplay = $rewardName;
                        }
                    }
                }
            @endphp

            <div class="barcode-card">
                <div class="barcode-top">
                    <div>
                        <div class="client-mini">Cześć, Klubowiczu</div>
                        <div class="client-points-mini">Telefon klienta do skanowania</div>
                    </div>

                    <div class="brand-mini">{{ $firm->name }}</div>
                </div>

                <div class="qr-wrap">
                    {!! $qr !!}
                </div>

                <div class="phone-code">{{ $client->phone }}</div>
                <div class="scan-note">
                    Pokaż ten kod przy kasie, aby odebrać rabat i zbierać punkty
                </div>
            </div>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-label">Liczba punktów</div>
                    <div class="stat-value">{{ $clientPoints ?? 0 }}</div>
                    <div class="stat-sub">Aktualny stan</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Dostępny rabat</div>
                    <div class="stat-value">{{ $availableRewardDisplay }}</div>
                    <div class="stat-sub">Do wykorzystania teraz</div>
                </div>
            </div>

            <details class="thresholds-card">
                <summary class="thresholds-summary">
                    <div class="thresholds-summary-left">
                        <div class="thresholds-title">Progi rabatowe</div>
                        <div class="thresholds-subtitle">Rozwiń, aby zobaczyć prawdziwe progi programu</div>
                    </div>
                    <div class="thresholds-arrow">⌄</div>
                </summary>

                <div class="thresholds-list">
                    <div class="threshold-item">
                        <div class="threshold-label">Kolejny próg</div>
                        <div class="threshold-value">
                            {{ $nextReward ? ($nextReward->reward_name ?? ($nextReward->points_required . ' pkt')) : 'Ostatni próg' }}
                        </div>
                    </div>

                    <div class="threshold-item">
                        <div class="threshold-label">Brakuje do kolejnego</div>
                        <div class="threshold-value">
                            {{ $nextReward ? ($pointsToNextReward . ' pkt') : '0 pkt' }}
                        </div>
                    </div>
                </div>

                @if(!empty($rewards) && count($rewards))
                    <div class="thresholds-list">
                        <div class="thresholds-title" style="padding:0 2px 2px;">Lista progów</div>

                        <div class="threshold-reward-list">
                            @foreach($rewards as $reward)
                                <div class="threshold-reward-item">
                                    <div class="threshold-reward-points">
                                        {{ $reward->points_required }} pkt
                                    </div>
                                    <div class="threshold-reward-name">
                                        {{ $reward->reward_name ?? 'Nagroda' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </details>
        </header>

        <main class="content">
            @php
                $promotionsList = collect($firm->promotions ?? [])->filter(fn($item) => $item->is_active);
                $locationsList = collect($firm->locations ?? [])->filter(fn($item) => $item->is_active);
                $recommendationsList = collect($firm->recommendations ?? []);
                $groupedRecommendations = $recommendationsList->groupBy(function ($item) {
                    return $item->category->name ?? 'Pozostałe';
                });
            @endphp

            <section class="section">
                <div class="section-header">
                    <div class="section-title">Promocje</div>
                    <div class="section-link">Przesuń</div>
                </div>

                @if($promotionsList->count())
                    <div class="promo-row">
                        @foreach($promotionsList as $promotion)
                            <div class="promo-card">
                                @if($promotion->image_path)
                                    <img
                                        src="{{ asset('storage/' . $promotion->image_path) }}"
                                        alt="{{ $promotion->title }}"
                                        class="promo-image"
                                    >
                                @else
                                    <div class="promo-image"></div>
                                @endif

                                <div class="promo-body">
                                    <div class="promo-title">{{ $promotion->title }}</div>
                                    <div class="promo-text">{{ $promotion->promo_text ?: 'Oferta specjalna dla klientów programu.' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="scroll-hint">
                        <span class="scroll-arrow">↓</span>
                        <span>Przewiń niżej, aby zobaczyć kolejne sekcje</span>
                    </div>
                @else
                    <div class="empty-box">
                        Brak aktywnych promocji dla tej firmy.
                    </div>
                @endif
            </section>

            <section class="section">
                <div class="tabs">
                    <a href="#polecane" class="tab active">⭐ Polecane</a>
                    <a href="#dojazd" class="tab">📍 Dojazd</a>
                    <a href="#regulamin" class="tab">📄 Regulamin</a>
                </div>
            </section>

            <section class="section" id="polecane">
                <div class="section-header">
                    <div class="section-title">Polecane</div>
                </div>

                @if($groupedRecommendations->count())
                    <div class="cards-stack">
                        @foreach($groupedRecommendations as $categoryName => $items)
                            @foreach($items->take(3) as $recommendation)
                                <div class="info-card">
                                    <div class="info-card-top">
                                        @if(!empty($recommendation->recommendedFirm?->logo_path))
                                            <img
                                                src="{{ asset('storage/' . $recommendation->recommendedFirm->logo_path) }}"
                                                alt="{{ $recommendation->recommendedFirm->name ?? 'Firma' }}"
                                                class="info-thumb"
                                            >
                                        @else
                                            <div class="info-thumb-fallback">
                                                {{ mb_strtoupper(mb_substr($recommendation->recommendedFirm->name ?? 'F', 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="info-main">
                                            <div class="info-title">
                                                {{ $recommendation->recommendedFirm->name ?? 'Polecana firma' }}
                                            </div>

                                            <div class="info-text">
                                                {{ $recommendation->promo_text ?: 'Sprawdź partnera polecanego przez tę firmę.' }}
                                            </div>

                                            <div class="info-meta">
                                                Kategoria: {{ $categoryName }}
                                            </div>

                                            @if(!empty($recommendation->recommendedFirm?->id))
                                                <a href="{{ route('client.card.show', ['card' => $card->id]) }}" class="info-link">
                                                    Przejdź do karty firmy
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                @else
                    <div class="empty-box">
                        Brak polecanych firm dla tej karty.
                    </div>
                @endif
            </section>

            <section class="section" id="dojazd">
                <div class="section-header">
                    <div class="section-title">Dojazd</div>
                </div>

                @if($locationsList->count() === 1)
                    @foreach($locationsList as $location)
                        <div class="info-card">
                            <div class="info-title">{{ $location->name ?: $firm->name }}</div>

                            <div class="location-line">
                                {{ $location->address }}
                                @if($location->city), {{ $location->city }}@endif
                                @if($location->postal_code), {{ $location->postal_code }}@endif
                            </div>

                            <div class="location-badge">1 lokalizacja</div>

                            @if($location->google_maps_url)
                                <a href="{{ $location->google_maps_url }}" target="_blank" class="info-link">
                                    Otwórz Google Maps
                                </a>
                            @endif
                        </div>
                    @endforeach
                @elseif($locationsList->count() > 1)
                    @foreach($locationsList as $location)
                        <div class="info-card">
                            <div class="info-title">{{ $location->name ?: $firm->name }}</div>

                            <div class="location-line">
                                {{ $location->address }}
                                @if($location->city), {{ $location->city }}@endif
                                @if($location->postal_code), {{ $location->postal_code }}@endif
                            </div>

                            <div class="info-meta">
                                @if(!is_null($location->latitude) && !is_null($location->longitude))
                                    LAT: {{ $location->latitude }} | LNG: {{ $location->longitude }}
                                @endif
                            </div>

                            @if($location->google_maps_url)
                                <a href="{{ $location->google_maps_url }}" target="_blank" class="info-link secondary">
                                    Wybierz tę lokalizację
                                </a>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="empty-box">
                        Brak dostępnych lokalizacji.
                    </div>
                @endif
            </section>

            <section class="section" id="regulamin">
                <div class="section-header">
                    <div class="section-title">Regulamin</div>
                </div>

                <a href="https://looply.net.pl/regulaminy/regulamin-mocne-branie.pdf" target="_blank" class="pdf-card">
                    <span class="pdf-card-icon">📄</span>
                    <span class="pdf-card-text">Regulamin PDF</span>
                </a>
            </section>
        </main>

        <div class="bottom-nav">
            <div class="bottom-item active">
                <span class="icon">🏷</span>
                Karta
            </div>
            <div class="bottom-item">
                <span class="icon">🎁</span>
                Oferty
            </div>
            <div class="bottom-item">
                <span class="icon">📍</span>
                Mapy
            </div>
            <div class="bottom-item">
                <span class="icon">☰</span>
                Więcej
            </div>
        </div>

    </div>
</div>
</body>
</html>
