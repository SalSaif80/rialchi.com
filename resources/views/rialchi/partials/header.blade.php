<header class="site-header">
    <a class="brand" href="{{ route('rialchi.home') }}#home" aria-label="{{ __('Rialchi الرئيسية') }}">
        <img src="{{ asset('assets/images/brand/logo-rialchi.png') }}" alt="" decoding="async" fetchpriority="high">
    </a>

    <nav id="nav" class="site-nav" aria-label="{{ __('التنقل الرئيسي') }}">
        <span class="nav-caption">{{ __('التنقل الرئيسي') }}</span>
        <a href="{{ route('rialchi.home') }}#journey"><span>{{ __('كيف أبدأ؟') }}</span><small aria-hidden="true">@include('rialchi.components.icons.arrow-left')</small></a>
        <a class="tracking-link" href="{{ route('rialchi.tracking') }}" @if(request()->routeIs('rialchi.tracking')) aria-current="page" @endif><span>{{ __('تتبع شحنتك') }}</span><small aria-hidden="true">@include('rialchi.components.icons.arrow-up-right')</small></a>
        <a href="{{ route('rialchi.home') }}#network"><span>{{ __('قبل أن تدفع') }}</span><small aria-hidden="true">@include('rialchi.components.icons.arrow-left')</small></a>
        @unless(request()->routeIs('rialchi.tracking'))
            <a class="quote-link" data-wa="{{ __('السلام عليكم فريق ريالتشي، لدي استفسار عن الاستيراد.') }}" href="https://wa.me/{{ config('rialchi.whatsapp') }}"><span>{{ __('تواصل واتساب') }}</span><small aria-hidden="true">@include('rialchi.components.icons.whatsapp')</small></a>
        @endunless
    </nav>

    <div class="header-actions">
        <details class="header-language">
            <summary aria-label="{{ __('اللغة') }}">
                <svg class="language-globe" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><ellipse cx="12" cy="12" rx="4" ry="9"/><path d="M3 12h18"/></svg>
                <span>{{ ['ar' => 'العربية', 'en' => 'EN', 'zh_CN' => '中文'][app()->getLocale()] }}</span>
                <svg class="language-chevron" aria-hidden="true" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m4 6 4 4 4-4"/></svg>
            </summary>
            <div class="language-options">
                <span class="language-caption">{{ __('اللغة') }}</span>
                @foreach(['ar' => 'العربية', 'en' => 'English', 'zh_CN' => '简体中文'] as $code => $label)
                    <a href="{{ request()->fullUrlWithQuery(['locale' => $code]) }}" lang="{{ str_replace('_', '-', $code) }}" @if(app()->getLocale() === $code) aria-current="true" @endif><span>{{ $label }}</span><span aria-hidden="true">{{ app()->getLocale() === $code ? '✓' : '' }}</span></a>
                @endforeach
            </div>
        </details>
        <button type="button" class="menu-toggle" aria-expanded="false" aria-controls="nav" aria-label="{{ __('فتح القائمة') }}">
            <span class="menu-icon" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="menu-label">{{ __('القائمة') }}</span>
        </button>
    </div>
</header>
