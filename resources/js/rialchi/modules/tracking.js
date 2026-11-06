import { configureWhatsAppLink } from './whatsapp.js';

// دالتك الأصلية (احتفظنا بها)
export function trackingMessage(number) {
    return `السلام عليكم فريق ريالتشي، أريد الاستفسار عن حالة شحنتي.\nرقم الشحنة أو الطلب: ${number.trim()}`;
}

export function initTracking() {
    const form = document.querySelector('#tracking-form');
    if (!form) return; // إذا لم نكن في صفحة التتبع، اخرج

    const input = form.querySelector('#tracking-input');
    const searchView = document.querySelector('#search-view');
    const loadingView = document.querySelector('#loading-view');
    const resultsView = document.querySelector('#results-view');
    const backBtn = document.querySelector('#back-to-search');
    const resNum1 = document.querySelector('#res-tracking-num');
    const resNum2 = document.querySelector('#res-tracking-num-2');
    
    // زر الواتساب الموجود في شاشة النتائج
    const waBtn = resultsView.querySelector('.tracking-wa-btn');

    // عند إرسال النموذج (الضغط على زر تتبع)
    form.addEventListener('submit', (event) => {
        event.preventDefault(); // 🛑 يمنع تحديث الصفحة نهائياً
        
        const number = input.value.trim();
        
        if (!number || number.length > 80) {
            input.setCustomValidity('أدخل رقم شحنة من 1 إلى 80 حرفًا.');
            input.reportValidity();
            return;
        }
        input.setCustomValidity('');

        // 1. إخفاء البحث وإظهار شاشة التحميل
        searchView.hidden = true;
        loadingView.hidden = false;

        // 2. محاكاة جلب البيانات (انتظار 1.5 ثانية)
        setTimeout(() => {
            loadingView.hidden = true;
            resultsView.hidden = false;

            // 3. إدخال رقم الشحنة في واجهة النتائج
            if(resNum1) resNum1.textContent = number;
            if(resNum2) resNum2.textContent = number;

            // 4. تحديث رابط الواتساب برقم الشحنة الحقيقي
            if(waBtn) {
                const message = trackingMessage(number);
                // إذا كانت دالة configureWhatsAppLink تستخدم data-wa أو href
                waBtn.setAttribute('data-wa', message);
                if (typeof configureWhatsAppLink === 'function') {
                    configureWhatsAppLink(waBtn, message);
                } else {
                    // طريقة احتياطية في حال لم يتم استيراد الدالة
                    const phone = waBtn.href.split('?')[0];
                    waBtn.href = `${phone}?text=${encodeURIComponent(message)}`;
                }
            }

        }, 1500);
    });

    // زر العودة للبحث
    if (backBtn) {
        backBtn.addEventListener('click', () => {
            resultsView.hidden = true;
            searchView.hidden = false;
            input.value = ''; // تفريغ الحقل
            input.focus(); // وضع المؤشر في الحقل
        });
    }
}