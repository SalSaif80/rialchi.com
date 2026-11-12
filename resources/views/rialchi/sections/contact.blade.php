<section id="contact" class="contact section-pad">

<div>
<h2 class="reveal">{{ __("أرسل الصورة.") }}<br>{{ __("واسأل عن") }} <span>{{ __("التفاصيل.") }}</span>
</h2>
<a class="primary wa-link" href="{{ route('rialchi.home') }}#contact" data-message="{{ __("السلام عليكم، أريد البدء في استيراد منتج وأحتاج المساعدة في تحديد الخطوات.\nالمنتج: \nالكمية: \nمدينة الاستلام:") }}">{{ __("أرسل المنتج على واتساب") }} <span>@include('rialchi.components.icons.arrow-up-right')</span>
</a>
</div>
<div class="contact-info">
<p>{{ __("معلومات الاتصال") }}</p>
<a href="mailto:{{ config('rialchi.email') }}">{{ config('rialchi.email') }} @include('rialchi.components.icons.arrow-up-right')</a>
<a href="tel:+{{ config('rialchi.whatsapp') }}" dir="ltr">+{{ config('rialchi.whatsapp') }}</a>
<span>{{ __(config('rialchi.location')) }}</span>
</div>
</section>
