@extends('rialchi.layouts.site')
@section('title', 'تتبع شحنتك — Rialchi')
@section('description', 'تتبع شحنتك بسهولة مع ريالتشي. أدخل رقم البوليصة لمعرفة حالة الشحنة.')

@section('content')
<section class="tracking-page">
  <div class="tracking-container">
    
    <!-- 1. واجهة البحث -->
    <div id="search-view" class="tracking-view">
      <div class="tracking-hero">
        <h1>أين شحنتك الآن؟</h1>
        <p>أدخل رقم البوليصة لعرض مسار الشحنة.</p>
        
        <form id="tracking-form" class="search-form">
          <div class="input-group">
            <input type="text" id="tracking-input" dir="ltr" maxlength="80" aria-label="رقم البوليصة" placeholder="RLC-98231-SA" required autocomplete="off">
            <button type="submit" class="primary" id="submit-btn">تتبع الشحنة</button>
          </div>
          <p class="field-help">ما عندك رقم؟ <a data-wa="السلام عليكم، أريد المساعدة في معرفة رقم شحنتي." href="https://wa.me/{{ config('rialchi.whatsapp') }}">تواصل معنا عبر واتساب</a></p>
        </form>
      </div>
    </div>

    <!-- مسار الشحنة -->
    <div id="results-view" class="tracking-view" hidden>
      
      <div class="results-header">
        <button type="button" id="back-to-search" class="back-btn">← بحث جديد</button>
        <div class="status-badge">مثال توضيحي · قيد النقل</div>
      </div>

      <!-- الخط الزمني -->
      <div class="timeline-box">
        <div class="timeline-header">
          <h2 id="route-title" tabindex="-1">مسار الرحلة</h2>
          <span class="mono">بوليصة <bdi id="res-tracking-num">-</bdi></span>
        </div>
        
        <ul class="timeline">
          <li class="timeline-item done">
            <div class="t-marker">✓</div>
            <div class="t-content">
              <h4>تم استلام الشحنة من المورد</h4>
              <p>ميناء شنغهاي، الصين</p>
              <span class="t-date mono">28 أكتوبر - 10:00 ص</span>
            </div>
          </li>
          <li class="timeline-item done">
            <div class="t-marker">✓</div>
            <div class="t-content">
              <h4>مغادرة ميناء الشحن</h4>
              <p>على متن الرحلة SV-892</p>
              <span class="t-date mono">29 أكتوبر - 08:30 م</span>
            </div>
          </li>
          <li class="timeline-item active" aria-current="step">
            <div class="t-marker pulse"></div>
            <div class="t-content">
              <h4>في الطريق إلى الوجهة</h4>
              <p>الشحنة حالياً في الجو</p>
              <span class="t-date mono">متوقع الوصول: 02 نوفمبر</span>
            </div>
          </li>
          <li class="timeline-item">
            <div class="t-marker"></div>
            <div class="t-content">
              <h4>التخليص الجمركي</h4>
              <p>ميناء الملك خالد، الرياض</p>
            </div>
          </li>
          <li class="timeline-item">
            <div class="t-marker"></div>
            <div class="t-content">
              <h4>خرجت للتسليم</h4>
              <p>في طريقها إلى عنوانك</p>
            </div>
          </li>
        </ul>
      </div>
      <details class="shipment-details">
        <summary>تفاصيل الشحنة</summary>
        <dl>
          <div><dt>طريقة الشحن</dt><dd>شحن جوي</dd></div>
          <div><dt>الوزن</dt><dd>450 كجم</dd></div>
          <div><dt>الوجهة</dt><dd>الرياض، السعودية</dd></div>
        </dl>
      </details>
      <p class="field-help">المسار المعروض توضيحي. <a class="tracking-wa-btn" href="https://wa.me/{{ config('rialchi.whatsapp') }}">استفسر عن شحنتك عبر واتساب</a></p>

      
    </div>
  </div>
</section>
@endsection