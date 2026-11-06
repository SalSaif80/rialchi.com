@extends('rialchi.layouts.site')
@section('title', 'تتبع شحنتك — Rialchi')
@section('description', 'تتبع شحنتك بسهولة مع ريالتشي. أدخل رقم البوليصة لمعرفة حالة الشحنة.')

@section('content')
<section class="tracking-page">
  <div class="tracking-container">
    
    <!-- 1. واجهة البحث -->
    <div id="search-view" class="tracking-view">
      <div class="tracking-hero">
        <span class="tracking-kicker">RLC / نظام التتبع</span>
        <h1>أين شحنتك الآن؟</h1>
        <p>أدخل رقم البوليصة (Bill of Lading) لمعرفة تفاصيل الرحلة.</p>
        
        <form id="tracking-form" class="search-form">
          <div class="input-group">
            <input type="text" id="tracking-input" dir="ltr" placeholder="مثال: RLC-98231-SA" required autocomplete="off">
            <button type="submit" class="primary" id="submit-btn">تتبع الشحنة</button>
          </div>
          <p class="field-help">ما عندك رقم؟ <a data-wa="السلام عليكم، أريد المساعدة في معرفة رقم شحنتي." href="https://wa.me/{{ config('rialchi.whatsapp') }}">تواصل معنا عبر واتساب</a></p>
        </form>
      </div>
    </div>

    <!-- 2. واجهة التحميل (تحاكي جلب البيانات) -->
    <div id="loading-view" class="tracking-view" hidden>
      <div class="loading-box">
        <div class="loading-bar"></div>
        <p class="mono">CONNECTING TO SERVER...</p>
        <h3>جاري جلب بيانات الشحنة...</h3>
      </div>
    </div>

    <!-- 3. واجهة النتائج -->
    <div id="results-view" class="tracking-view" hidden>
      
      <div class="results-header">
        <button type="button" id="back-to-search" class="back-btn">← بحث جديد</button>
        <div class="status-badge">الحالة: قيد النقل</div>
      </div>

      <!-- بيانات الشحنة -->
      <div class="shipment-grid">
        <div class="shipment-cell">
          <span class="cell-label">رقم البوليصة</span>
          <strong class="cell-value mono" id="res-tracking-num">-</strong>
        </div>
        <div class="shipment-cell">
          <span class="cell-label">طريقة الشحن</span>
          <strong class="cell-value">شحن جوي</strong>
        </div>
        <div class="shipment-cell">
          <span class="cell-label">الوزن</span>
          <strong class="cell-value">450 كجم</strong>
        </div>
        <div class="shipment-cell">
          <span class="cell-label">الوجهة</span>
          <strong class="cell-value">الرياض، السعودية</strong>
        </div>
      </div>

      <!-- الخط الزمني -->
      <div class="timeline-box">
        <div class="timeline-header">
          <h3>مسار الرحلة</h3>
          <span class="mono">TRACKING ID: <span id="res-tracking-num-2">-</span></span>
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
          <li class="timeline-item active">
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
      
    </div>
  </div>
</section>
@endsection