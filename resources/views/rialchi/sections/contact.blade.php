<section id="contact" class="contact section-pad">
<div class="eyebrow">[خطوتك الأولى]</div>
<div>
<h2 class="reveal">أرسل الصورة.<br>واسأل عن <span>التفاصيل.</span>
</h2>
<a class="primary wa-link" href="{{ route('rialchi.home') }}#contact" data-message="السلام عليكم، أريد البدء في استيراد منتج وأحتاج المساعدة في تحديد الخطوات.
المنتج: 
الكمية: 
مدينة الاستلام: ">أرسل المنتج على واتساب <span>@include('rialchi.components.icons.arrow-up-right')</span>
</a>
</div>
<div class="contact-info">
<p>معلومات الاتصال</p>
<a href="mailto:{{ config('rialchi.email') }}">{{ config('rialchi.email') }} @include('rialchi.components.icons.arrow-up-right')</a>
<a href="tel:+{{ config('rialchi.whatsapp') }}" dir="ltr">+{{ config('rialchi.whatsapp') }}</a>
<span>{{ config('rialchi.location') }}</span>
</div>
</section>
