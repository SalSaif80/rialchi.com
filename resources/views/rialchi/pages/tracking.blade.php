@extends('rialchi.layouts.site')
@section('title', 'تتبع شحنتك — Rialchi')
@section('description', 'أدخل رقم البوليصة لمعرفة مسار الشحنة وتفاصيلها.')

@section('content')
<section class="tracking-page">
    <div class="tracking-container">
        @if (!$shipment)
            <div class="tracking-hero">
                <h1>أين شحنتك الآن؟</h1>
                <p>أدخل رقم البوليصة لعرض مسار الشحنة.</p>
                <form id="tracking-form" class="search-form" method="get" action="{{ route('rialchi.tracking') }}">
                    <div class="input-group">
                        <input type="text" id="tracking-input" name="number" dir="ltr" value="{{ $valid ? $number : '' }}"
                               maxlength="80" aria-label="رقم البوليصة" placeholder="RLC-98231-SA" required autocomplete="off">
                        <button type="submit" class="primary" id="submit-btn">تتبع الشحنة</button>
                    </div>
                    <p id="search-progress" class="field-help" role="status" hidden>جارٍ البحث عن الشحنة…</p>
                    @if ($searched)
                        <p class="field-help" role="status">{{ $valid ? 'لم نجد شحنة بهذا الرقم. تأكد من رقم البوليصة وأعد البحث.' : 'أدخل رقم بوليصة من 1 إلى 80 حرفًا.' }}</p>
                    @endif
                    <p class="field-help"><a href="{{ route('rialchi.tracking', ['number' => 'RLC-98231-SA']) }}">جرّب رقم التتبع التوضيحي</a></p>
                </form>
            </div>
        @else
            <div id="results-view" class="tracking-view">
                <div class="results-header">
                    <div class="status-badge">{{ $shipment['demo'] ? 'مثال توضيحي · ' : '' }}{{ $shipment['status'] }}</div>
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
                        @foreach ($shipment['events'] as $event)
                            <li class="timeline-item {{ $event['state'] }}" @if ($event['state'] === 'active') aria-current="step" @endif>
                                <div class="t-marker" aria-hidden="true">{{ $event['state'] === 'done' ? '✓' : '' }}</div>
                                <div class="t-content">
                                    <h4>{{ $event['title'] }}</h4>
                                    <p>{{ $event['location'] }}</p>
                                    @isset($event['time'])
                                        <span class="t-date mono">{{ $event['time'] }}</span>
                                    @endisset
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <section class="shipment-details" aria-labelledby="shipment-details-title">
                    <h3 id="shipment-details-title">تفاصيل الشحنة</h3>
                    <dl>
                        <div><dt>طريقة الشحن</dt><dd>{{ $shipment['method'] }}</dd></div>
                        <div><dt>الوزن</dt><dd>{{ $shipment['weight'] }}</dd></div>
                        <div><dt>الوجهة</dt><dd>{{ $shipment['destination'] }}</dd></div>
                    </dl>
                </section>
            </div>
        @endif
    </div>
</section>
@endsection
