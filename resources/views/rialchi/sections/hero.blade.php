<section id="home" class="hero">
    <div class="port-experience">
        <div class="hero-art">
            <div class="port-wrap">
                <div class="port">@include('rialchi.components.illustrations.port')</div>
            </div>
        </div>
        <div class="port-controls">
            <span id="port-status" role="status">{{ __("اختر حاوية من أعلى الرصّة ليحملها الونش") }}</span>
        </div>
    </div>
    <div class="start-hero">
        <div class="start-copy">
            <h1>{{ __("تبي تستورد؟") }}<br><span>{{ __("ابدأ بصورة المنتج.") }}</span></h1>
            <p>{{ __("أرسل صورة المنتج أو رابطه، وقل لنا كم قطعة تحتاج ووين تبي تستلمها. نساعدك تعرف خياراتك وتكلفتها.") }}</p>
            <a class="primary" href="https://wa.me/{{ config('rialchi.whatsapp') }}" data-wa="{{ __("السلام عليكم، أرغب في استيراد منتج. سأرفق صورته أو رابطه.") }}">
                @include('rialchi.components.icons.whatsapp')
                {{ __("أرسل صورة المنتج على واتساب") }}
            </a>
        </div>
        <aside class="entry-options" aria-labelledby="entry-title">
            <h2 id="entry-title">{{ __("وش تحتاج اليوم؟") }}</h2>
            <a href="#journey">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 7 9-5 9 5v10l-9 5-9-5Zm0 0 9 5 9-5m-9 5v10M8 4l9 5"/></svg>
                <span><strong>{{ __("أبي أستورد لأول مرة") }}</strong><small>{{ __("تعرّف على الخطوات من اختيار المنتج إلى استلامه.") }}</small></span>
                @include('rialchi.components.icons.arrow-left')
            </a>
            <a href="https://wa.me/{{ config('rialchi.whatsapp') }}" data-wa="{{ __("السلام عليكم، بضاعتي جاهزة وأحتاج عرض سعر للشحن.") }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 5h13v12H2zm13 5h4l3 4v3h-7"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>
                <span><strong>{{ __("بضاعتي جاهزة للشحن") }}</strong><small>{{ __("اطلب عرض شحن من الفريق على واتساب.") }}</small></span>
                @include('rialchi.components.icons.arrow-left')
            </a>
            <a href="{{ route('rialchi.tracking') }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                <span><strong>{{ __("أبي أتتبّع شحنتي") }}</strong><small>{{ __("أدخل رقم البوليصة وشوف آخر تحديث.") }}</small></span>
                @include('rialchi.components.icons.arrow-left')
            </a>
        </aside>
    </div>
</section>
