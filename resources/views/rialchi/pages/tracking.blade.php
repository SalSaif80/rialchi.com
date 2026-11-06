@extends('rialchi.layouts.site')
@section('title', 'تتبع شحنتك — Rialchi')
@section('description', 'رحلة شحنتك خطوة بخطوة، ومتابعة سهلة مع فريق ريالتشي.')
@section('content')
<section class="tracking-page">
  <div class="tracking-heading"><div class="eyebrow">[من المورد إلى بابك]</div><h1>كل خطوة،<br><span>أقرب إليك.</span></h1><p>رقم واحد. تواصل أسهل. ورحلة واضحة.</p></div>
  <div class="tracking-grid">
    <section class="tracking-panel" aria-labelledby="lookup-title">
      <span class="tracking-kicker">01 / متابعة شحنتك</span><h2 id="lookup-title">أين شحنتي؟</h2>
      <p>أدخل رقمك لنجهّز استفسارك لفريق ريالتشي.</p>
      <form id="tracking-form">
        <label for="tracking-number">رقم الشحنة أو الطلب</label>
        <input id="tracking-number" name="tracking_number" dir="ltr" placeholder="RLC-2026-001" maxlength="80" required autocomplete="off" aria-describedby="tracking-help">
        <p id="tracking-help" class="field-help">تجده في رسالة تأكيد الشحن أو مستند الطلب.</p>
        <button class="primary" type="submit">متابعة شحنتي @include('rialchi.components.icons.arrow-left')</button>
      </form>
      <div id="tracking-result" class="tracking-result" hidden role="status" aria-live="polite">
        <strong>استفسارك جاهز للإرسال</strong><p>الحالة المباشرة غير متاحة حاليًا. فريقنا يساعدك بمعرفة آخر تحديث.</p>
        <p id="tracking-message"></p><a id="tracking-whatsapp" class="journey-cta" target="_blank" rel="noopener noreferrer">أرسل عبر واتساب @include('rialchi.components.icons.arrow-up-right')</a>
      </div>
      <a class="tracking-help-link" data-wa="السلام عليكم، أريد المساعدة في معرفة رقم شحنتي. اسم صاحب الطلب: " href="https://wa.me/{{ config('rialchi.whatsapp') }}">ما عندك رقم الشحنة؟ نساعدك</a>
      <div class="tracking-service-note"><i class="status-dot"></i><span>المتابعة حاليًا مع خدمة العملاء عبر واتساب.</span></div>
      <noscript><p>تواصل عبر رابط واتساب أعلاه واذكر رقم شحنتك.</p></noscript>
    </section>
    <section class="shipment-journey" aria-labelledby="journey-title">
      <div class="journey-card-top"><span class="tracking-kicker">02 / افهم مراحل الرحلة</span><span class="demo-badge">مثال توضيحي</span></div>
      <h2 id="journey-title">من هناك… إلى عندك.</h2><p class="demo-disclaimer">هذه مراحل نموذجية، وليست حالة شحنتك الفعلية.</p>
      <div class="route-map" aria-hidden="true"><span>بلد المنشأ</span><div class="route-dots"><i></i><b>RLC</b><i></i></div><span>بلد الوجهة</span></div>
      <div class="journey-current"><span>المحطة في المثال</span><strong id="demo-current">الشحنة في البحر</strong><span id="demo-count">03 / 06</span></div>
      <ol class="shipment-timeline">
        <li class="is-complete"><button type="button" data-tracking-step="0" aria-pressed="false"><span class="step-marker">01</span><span><strong>استلام من المورد</strong><small>تجهيز المنتج وفحصه قبل الشحن.</small></span><span class="step-state">تمّت</span></button></li>
        <li class="is-complete"><button type="button" data-tracking-step="1" aria-pressed="false"><span class="step-marker">02</span><span><strong>مغادرة ميناء الشحن</strong><small>تحميل الحاوية وانطلاقها من بلد المنشأ.</small></span><span class="step-state">تمّت</span></button></li>
        <li class="is-current"><button type="button" data-tracking-step="2" aria-pressed="true"><span class="step-marker">03</span><span><strong>الشحنة في البحر</strong><small>في طريقها إلى ميناء الوجهة.</small></span><span class="step-state">الآن</span></button></li>
        <li class=""><button type="button" data-tracking-step="3" aria-pressed="false"><span class="step-marker">04</span><span><strong>الوصول والتخليص</strong><small>وصول الحاوية وإنهاء الإجراءات الجمركية.</small></span><span class="step-state">لاحقًا</span></button></li>
        <li class=""><button type="button" data-tracking-step="4" aria-pressed="false"><span class="step-marker">05</span><span><strong>خرجت للتسليم</strong><small>نقل الشحنة من الميناء إلى عنوانك.</small></span><span class="step-state">لاحقًا</span></button></li>
        <li class=""><button type="button" data-tracking-step="5" aria-pressed="false"><span class="step-marker">06</span><span><strong>تم التسليم</strong><small>وصول الشحنة واستلامها.</small></span><span class="step-state">لاحقًا</span></button></li>
      </ol>
      <p class="timeline-hint">اضغط على أي محطة لتستكشف الرحلة.</p>
      <p class="demo-live" id="demo-announcement" aria-live="polite"></p>
    </section>
  </div>
  <div class="tracking-note"><span>معلومة على الطريق</span><p>رقم الطلب قد يختلف عن رقم بوليصة الشحن. أرسل الرقم المتوفر لديك، والفريق يساعدك في المتابعة. تختلف مراحل الرحلة حسب طريقة الشحن.</p></div>
</section>
@endsection
