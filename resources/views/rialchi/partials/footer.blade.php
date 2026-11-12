<footer class="site-footer">
    <div class="footer-columns">
        <a class="footer-logo" href="{{ route('rialchi.home') }}">
            <img src="{{ asset('assets/images/brand/logo-rialchi.png') }}" alt="{{ __("ريالتشي للاستيراد والشحن") }}" loading="lazy">
        </a>
        <div>
            <h2>{{ __("خدمات ريالتشي") }}</h2>
            <a href="{{ route('rialchi.home') }}#journey">{{ __("كيف أبدأ الاستيراد؟") }}</a>
            <a href="{{ route('rialchi.home') }}#services">{{ __("خدمات الشحن والتخليص") }}</a>
            <a href="{{ route('rialchi.tracking') }}">{{ __("تتبّع شحنتك") }}</a>
        </div>
        <div>
            <h2>{{ __("تواصل معنا") }}</h2>
            <a href="tel:+{{ config('rialchi.whatsapp') }}"><bdi dir="ltr">+{{ config('rialchi.whatsapp') }}</bdi></a>
            <a href="mailto:{{ config('rialchi.email') }}">{{ config('rialchi.email') }}</a>
        </div>
    </div>
    <small>© {{ date('Y') }} {{ __("ريالتشي للاستيراد والشحن") }}</small>
</footer>
