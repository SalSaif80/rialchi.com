@extends('rialchi.layouts.site')
@section('title', 'تتبع شحنتك — Rialchi')
@section('description', 'أدخل رقم البوليصة لمعرفة مسار الشحنة وتفاصيلها.')

@section('content')
<section class="tracking-page">
    <div class="tracking-container">
        @if (!$shipment)
            <div class="tracking-hero">
                <h1>أين شحنتك الآن؟</h1>
                <p>أدخل رقم التتبع الذي وصلك من ريالتشي.</p>
                <form id="tracking-form" class="search-form" method="get" action="{{ route('rialchi.tracking') }}">
                    <div class="input-group">
                        <input type="text" id="tracking-input" name="number" dir="ltr" value="{{ $valid ? $number : '' }}"
                               maxlength="80" aria-label="رقم البوليصة" placeholder="RLC-…" required autocomplete="off">
                        <button type="submit" class="primary" id="submit-btn">تتبع الشحنة</button>
                    </div>
                    <p id="search-progress" class="field-help" role="status" hidden>جارٍ البحث عن الشحنة…</p>
                    @if ($searched)
                        <p class="field-help" role="status">{{ $valid ? 'لم نجد شحنة بهذا الرقم. تأكد من رقم التتبع وأعد البحث.' : 'أدخل رقم التتبع.' }}</p>
                    @endif
                </form>
            </div>
        @else
            <div id="results-view" class="tracking-view">
                <div class="results-header">
                    <div class="status-badge">{{ $shipment->events->last()?->status?->name ?? 'تم التسجيل' }}</div>
                    <a class="new-search" href="{{ route('rialchi.tracking') }}">
                        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="10" cy="10" r="6"/><path d="m15 15 6 6"/></svg>
                        بحث جديد
                    </a>
                </div>
                <div class="timeline-box">
                    <div class="timeline-header">
                        <h2>مسار الرحلة</h2>
                        <span class="mono">بوليصة <bdi>{{ $number }}</bdi></span>
                    </div>
                    <ol class="timeline">
                        @foreach ($shipment->events as $event)
                            <li class="timeline-item {{ $loop->last ? 'active' : 'done' }}" @if ($loop->last) aria-current="step" @endif>
                                <div class="t-marker" aria-hidden="true">{{ $loop->last ? '' : '✓' }}</div>
                                <div class="t-content">
                                    <h4>{{ $event->status->name }}</h4>
                                    <p>{{ $event->location }}</p>
                                    @if ($event->created_at)
                                        <span class="t-date mono">{{ $event->created_at->timezone('Asia/Riyadh')->format('Y-m-d H:i') }}</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <section class="shipment-details" aria-labelledby="shipment-details-title">
                    <h3 id="shipment-details-title">تفاصيل الشحنة</h3>
                    <dl>
                        <div><dt>طريقة الشحن</dt><dd>{{ $shipment->method ?? '—' }}</dd></div>
                        <div><dt>الوزن</dt><dd>{{ $shipment->weight ?? '—' }}</dd></div>
                        <div><dt>الوجهة</dt><dd>{{ $shipment->destination ?? '—' }}</dd></div>
                    </dl>
                    @if ($shipment->details)
                        <p>{{ $shipment->details }}</p>
                    @endif
                    @foreach ($shipment->photos ?? [] as $photo)
                        <img loading="lazy" width="180" style="max-width:100%;height:auto" alt="صورة الشحنة {{ $loop->iteration }}"
                             src="{{ route('rialchi.shipment-photo', [$shipment->number, $loop->index]) }}">
                    @endforeach
                </section>
            </div>
        @endif
    </div>
</section>
@endsection
