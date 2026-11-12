@extends('rialchi.layouts.site')
@section('title', __("تتبع شحنتك — Rialchi"))
@section('description', __("أدخل رقم البوليصة لمعرفة مسار الشحنة وتفاصيلها."))

@section('content')
<section class="tracking-page">
    <div class="tracking-container">
        @if (!$shipment)
            <div class="tracking-hero">
                <h1>{{ __("أين شحنتك الآن؟") }}</h1>
                <p>{{ __("أدخل رقم التتبع الذي وصلك من ريالتشي.") }}</p>
                <form id="tracking-form" class="search-form" method="get" action="{{ route('rialchi.tracking') }}">
                    <div class="input-group">
                        <input type="text" id="tracking-input" name="number" dir="ltr" value="{{ $valid ? $number : '' }}"
                               maxlength="80" aria-label="{{ __("رقم البوليصة") }}" placeholder="RLC-…" required autocomplete="off">
                        <button type="submit" class="primary" id="submit-btn">{{ __("تتبع الشحنة") }}</button>
                    </div>
                    <p id="search-progress" class="field-help" role="status" hidden>{{ __("جارٍ البحث عن الشحنة…") }}</p>
                    @if ($searched)
                        <p class="field-help" role="status">{{ $valid ? __("لم نجد شحنة بهذا الرقم. تأكد من رقم التتبع وأعد البحث.") : __("أدخل رقم التتبع.") }}</p>
                    @endif
                </form>
            </div>
        @else
            <div id="results-view" class="tracking-view">
                <div class="results-header">
                    <div class="status-badge">{{ __("الحالة الحالية ·") }} {{ $shipment->events->last()?->status?->translated_name ?? __("تم التسجيل") }}</div>
                    <a class="new-search" href="{{ route('rialchi.tracking') }}">
                        <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="10" cy="10" r="6"/><path d="m15 15 6 6"/></svg>
                        {{ __("بحث جديد") }}
                    </a>
                </div>
                <div class="timeline-box">
                    <div class="timeline-header">
                        <h2>{{ __("مسار الرحلة") }}</h2>
                        <span class="mono">{{ __("بوليصة") }} <bdi>{{ $number }}</bdi></span>
                    </div>
                    <ol class="timeline">
                        <li class="timeline-item done">
                            <div class="t-marker" aria-hidden="true">✓</div>
                            <div class="t-content">
                                <h4>{{ __("تم تسجيل الشحنة وإصدار رقم التتبع") }}</h4>
                                <time class="t-date" datetime="{{ $shipment->created_at->toAtomString() }}">{{ $shipment->created_at->timezone('Asia/Riyadh')->locale(app()->getLocale())->translatedFormat(__("j F Y، H:i")) }}</time>
                            </div>
                        </li>
                        @foreach ($shipment->events as $event)
                            <li class="timeline-item {{ $loop->last ? 'active' : 'done' }}" @if ($loop->last) aria-current="step" @endif>
                                <div class="t-marker" aria-hidden="true">{{ $loop->last ? '' : '✓' }}</div>
                                <div class="t-content">
                                    <h4>{{ $event->status->translated_name }}</h4>
                                    @if ($event->location)<p>{{ $event->location }}</p>@endif
                                    @if ($event->created_at)
                                        <time class="t-date" datetime="{{ $event->created_at->toAtomString() }}">{{ $event->created_at->timezone('Asia/Riyadh')->locale(app()->getLocale())->translatedFormat(__("j F Y، H:i")) }}</time>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <section class="shipment-details" aria-labelledby="shipment-details-title">
                    <h3 id="shipment-details-title">{{ __("تفاصيل الشحنة") }}</h3>
                    <dl>
                        <div><dt>{{ __("طريقة الشحن") }}</dt><dd>{{ __($shipment->method ?? '—') }}</dd></div>
                        <div><dt>{{ __("الوزن") }}</dt><dd>{{ $shipment->weight ?? '—' }}</dd></div>
                        <div><dt>{{ __("الوجهة") }}</dt><dd>{{ $shipment->destination ?? '—' }}</dd></div>
                    </dl>
                    @if ($shipment->details)
                        <div class="shipment-description">
                            <h4>{{ __("وصف الشحنة") }}</h4>
                            <p>{{ $shipment->details }}</p>
                        </div>
                    @endif
                </section>
            </div>
        @endif
    </div>
</section>
@endsection
