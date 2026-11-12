<!doctype html>
<html lang="{{ app()->getLocale() === 'zh_CN' ? 'zh-Hans' : app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', __("ريالتشي — رحلة استيراد واضحة من اختيار المنتج إلى استلام الشحنة."))">
    <meta name="theme-color" content="#1a2135">
        <link rel="icon" type="image/png" href="{{ asset("assets/images/brand/logo-rialchi.png") }}">
    <title>@yield('title', __("Rialchi — شحنتك، أولويتنا"))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @php(app(\Illuminate\Foundation\Vite::class)->useHotFile(storage_path('framework/rialchi.hot')))
    @vite(['resources/css/rialchi/app.css', 'resources/js/rialchi/app.js'], 'build/rialchi')
    @stack('page-styles')
</head>
<body data-whatsapp="{{ config('rialchi.whatsapp') }}">
    @php($translations = json_decode(file_get_contents(lang_path(app()->getLocale().'.json')), true))
    <script id="rialchi-translations" type="application/json">@json($translations)</script>
    <div class="progress" aria-hidden="true"></div>
    <a class="skip" href="#main">{{ __("انتقل إلى المحتوى") }}</a>
    <div class="site-frame">
        @include('rialchi.partials.header')
        <main id="main">@yield('content')</main>
        @include('rialchi.partials.footer')
    </div>
    @include('rialchi.components.quote-dialog')
    @unless(request()->routeIs('rialchi.tracking'))
        <a class="floating-wa" data-wa="{{ __("السلام عليكم فريق ريالتشي، لدي استفسار عن الاستيراد.") }}" href="https://wa.me/{{ config('rialchi.whatsapp') }}" target="_blank" rel="noopener noreferrer"><span aria-hidden="true">◉</span> {{ __("تواصل واتساب") }} @include('rialchi.components.icons.arrow-up-right')</a>
    @endunless
</body>
</html>
