<section id="home" class="hero">
<div class="port-experience"><div class="hero-art">
<div class="cross top-right">+</div>
<div class="cross top-left">+</div>
<div class="cross bottom-right">+</div>
<div class="cross bottom-left">+</div>
<div class="art-meta mono">
<span>RIALCHI / GLOBAL LOGISTICS</span>
<span>01 — CONNECTING THE WORLD</span>
</div>
<div class="port-wrap">
<div class="port">@include('rialchi.components.illustrations.port')</div>
<div class="hero-plane" aria-hidden="true">@include('rialchi.components.illustrations.plane')</div>
<div class="scan" aria-hidden="true">
</div>
</div>


<div class="art-bottom mono">
<span>
<i class="status-dot">
</i> من المنتج إلى التسليم</span>
<a href="{{ route('rialchi.home') }}#journey">كيف أبدأ؟ @include('rialchi.components.icons.arrow-down')</a>
<button id="motion" aria-pressed="false">إيقاف الحركة</button>
</div>
</div>
<div class="port-controls"><span id="port-status" role="status" aria-live="polite">اختر حاوية من أعلى الرصّة ليحملها الونش</span><button id="unload-button" type="button">تفريغ حاوية متاحة</button><button id="port-reset" type="button">إعادة الميناء</button></div>
</div>
<div class="start-hero"><div class="start-copy"><div class="eyebrow">ريالتشي / استيراد وشحن</div><h1>تبي تستورد؟<br><span>ابدأ بصورة المنتج.</span></h1><p>أرسل صورة أو رابط المنتج على واتساب، واذكر الكمية ومدينة الاستلام. اسأل فريق ريالتشي عن الخيارات والتكلفة والخطوة التالية.</p><a class="primary" href="https://wa.me/{{ config('rialchi.whatsapp') }}" data-wa="السلام عليكم، أرغب في استيراد منتج. سأرفق صورته أو رابطه.
الكمية التقريبية: 
مدينة الاستلام: ">أرسل صورة المنتج على واتساب <span>@include('rialchi.components.icons.arrow-up-right')</span></a><small>يفتح واتساب برسالة جاهزة؛ أضف الصورة قبل الإرسال.</small></div>
<aside class="start-options"><span class="eyebrow">أين وصلت في طلبك؟</span><h2>اختر ما يناسبك.</h2><a class="start-option" href="https://wa.me/{{ config('rialchi.whatsapp') }}" data-wa="السلام عليكم، هذه أول تجربة استيراد لي وأحتاج المساعدة في اختيار المنتج وفهم الخطوات.">أول مرة أستورد، أحتاج مساعدة <span>@include('rialchi.components.icons.arrow-up-right')</span></a><a class="start-option" href="https://wa.me/{{ config('rialchi.whatsapp') }}" data-wa="السلام عليكم، لدي بضاعة جاهزة وأحتاج عرض شحن.
موقع البضاعة: 
مدينة الاستلام: ">عندي بضاعة وأحتاج شحنها <span>@include('rialchi.components.icons.arrow-up-right')</span></a><a class="start-option" href="{{ route('rialchi.tracking') }}">عندي شحنة وأريد متابعتها @include('rialchi.components.icons.arrow-left')</a><a class="start-explain" href="#journey">كيف تتم العملية؟ 3 خطوات بسيطة ↓</a></aside></div>
</section>