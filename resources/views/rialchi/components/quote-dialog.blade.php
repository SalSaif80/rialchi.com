<dialog id="quote">
<form id="quote-form">
<div class="dialog-top">
<span class="eyebrow">لنخطط لشحنتك</span>
<button type="button" class="close" aria-label="إغلاق">×</button>
</div>
<h2>اطلب عرض سعر<span>.</span>
</h2>
<p>أدخل تفاصيل شحنتك، وسنجهّز لك رسالة واتساب لفريق ريالتشي. راجعها ثم اضغط إرسال من واتساب.</p>
<label>الاسم<input name="name" autocomplete="name" required placeholder="اسمك الكامل">
</label>
<label>نوع الخدمة<select name="service">
<option>الشحن البحري</option>
<option>الشحن الجوي</option>
<option>النقل البري</option>
<option>التخليص الجمركي</option>
<option>التخزين</option>
<option>سلسلة التوريد</option>
</select>
</label>
<div class="form-row">
<label>من<input name="origin" required placeholder="مدينة المنشأ">
</label>
<label>إلى<input name="destination" required placeholder="مدينة الوصول">
</label>
</div>
<label>تفاصيل الشحنة<textarea name="details" required rows="3" placeholder="نوع البضاعة، الكمية، والموعد المطلوب">
</textarea>
</label>
<button class="primary" type="submit">متابعة عبر واتساب @include('rialchi.components.icons.arrow-up-right')</button>
<p id="form-status" role="status">
</p>
</form>
</dialog>
