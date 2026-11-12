<dialog id="quote">
<form id="quote-form">
<div class="dialog-top">
<span class="eyebrow">{{ __("لنخطط لشحنتك") }}</span>
<button type="button" class="close" aria-label="{{ __("إغلاق") }}">×</button>
</div>
<h2>{{ __("اطلب عرض سعر") }}<span>.</span>
</h2>
<p>{{ __("أدخل تفاصيل شحنتك، وسنجهّز لك رسالة واتساب لفريق ريالتشي. راجعها ثم اضغط إرسال من واتساب.") }}</p>
<label>{{ __("الاسم") }}<input name="name" autocomplete="name" required placeholder="{{ __("اسمك الكامل") }}">
</label>
<label>{{ __("نوع الخدمة") }}<select name="service">
<option>{{ __("الشحن البحري") }}</option>
<option>{{ __("الشحن الجوي") }}</option>
<option>{{ __("النقل البري") }}</option>
<option>{{ __("التخليص الجمركي") }}</option>
<option>{{ __("التخزين") }}</option>
<option>{{ __("سلسلة التوريد") }}</option>
</select>
</label>
<div class="form-row">
<label>{{ __("من") }}<input name="origin" required placeholder="{{ __("مدينة المنشأ") }}">
</label>
<label>{{ __("إلى") }}<input name="destination" required placeholder="{{ __("مدينة الوصول") }}">
</label>
</div>
<label>{{ __("تفاصيل الشحنة") }}<textarea name="details" required rows="3" placeholder="{{ __("نوع البضاعة، الكمية، والموعد المطلوب") }}">
</textarea>
</label>
<button class="primary" type="submit">{{ __("متابعة عبر واتساب") }} @include('rialchi.components.icons.arrow-up-right')</button>
<p id="form-status" role="status">
</p>
</form>
</dialog>
