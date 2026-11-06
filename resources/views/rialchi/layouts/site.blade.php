<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'ريالتشي — رحلة استيراد واضحة من اختيار المنتج إلى استلام الشحنة.')">
    <meta name="theme-color" content="#f2f2e9">
    <title>@yield('title', 'Rialchi — شحنتك، أولويتنا')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @php(app(\Illuminate\Foundation\Vite::class)->useHotFile(storage_path('framework/rialchi.hot')))
    @vite(['resources/css/rialchi/app.css', 'resources/js/rialchi/app.js'], 'build/rialchi')
</head>
<body data-whatsapp="{{ config('rialchi.whatsapp') }}">
    <div class="progress" aria-hidden="true"></div>
    <a class="skip" href="#main">انتقل إلى المحتوى</a>
    <div class="site-frame">
        @include('rialchi.partials.header')
        <main id="main">@yield('content')</main>
        @include('rialchi.partials.footer')
    </div>
    @include('rialchi.components.quote-dialog')
    <a class="floating-wa" data-wa="السلام عليكم فريق ريالتشي، لدي استفسار عن الاستيراد." href="https://wa.me/{{ config('rialchi.whatsapp') }}" target="_blank" rel="noopener noreferrer"><span aria-hidden="true">◉</span> تواصل واتساب @include('rialchi.components.icons.arrow-up-right')</a>
</body>
</html>
