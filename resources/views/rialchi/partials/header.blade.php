<header>
    <a class="brand" href="{{ route('rialchi.home') }}#home" aria-label="{{ __("Rialchi الرئيسية") }}">
        <img
            src="{{ asset('assets/images/brand/logo-rialchi.png') }}"
            alt=""
            decoding="async"
            fetchpriority="high">
    </a>

    @include('rialchi.partials.language-switcher')

    <button type="button" class="menu-toggle" aria-expanded="false" aria-controls="nav" aria-label="{{ __("فتح القائمة") }}">
        <span class="menu-icon" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="menu-label">{{ __("القائمة") }}</span>
    </button>

    <nav id="nav" aria-label="{{ __("التنقل الرئيسي") }}">
        <a href="{{ route('rialchi.home') }}#journey">{{ __("كيف أبدأ؟") }} <small aria-hidden="true">@include('rialchi.components.icons.arrow-left')</small></a>
        <a href="{{ route('rialchi.tracking') }}" @if(request()->routeIs('rialchi.tracking')) aria-current="page" @endif>{{ __('تتبع شحنتك') }} <small>@include('rialchi.components.icons.arrow-up-right')</small></a>
        <a href="{{ route('rialchi.home') }}#network">{{ __("قبل أن تدفع") }} <small aria-hidden="true">@include('rialchi.components.icons.arrow-left')</small></a>
        @unless(request()->routeIs('rialchi.tracking'))
            <a class="quote-link" data-wa="{{ __("السلام عليكم فريق ريالتشي، لدي استفسار عن الاستيراد.") }}" href="https://wa.me/{{ config('rialchi.whatsapp') }}">{{ __("تواصل واتساب") }} <small>@include('rialchi.components.icons.arrow-down-left')</small></a>
        @endunless
    </nav>
</header>