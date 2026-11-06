import { configureWhatsAppLink } from './whatsapp.js';

export function trackingMessage(number) {
    return `السلام عليكم فريق ريالتشي، أريد الاستفسار عن حالة شحنتي.\nرقم الشحنة أو الطلب: ${number.trim()}`;
}

export function initTracking() {
    const steps = [...document.querySelectorAll('[data-tracking-step]')];
    steps.forEach((button, index) => button.addEventListener('click', () => {
        steps.forEach((step, position) => {
            step.setAttribute('aria-pressed', String(position === index));
            step.closest('li').classList.toggle('is-complete', position < index);
            step.closest('li').classList.toggle('is-current', position === index);
            step.querySelector('.step-state').textContent = position < index ? 'تمّت' : position === index ? 'الآن' : 'لاحقًا';
        });
        const title = button.querySelector('strong').textContent;
        document.querySelector('#demo-current').textContent = title;
        document.querySelector('#demo-count').textContent = `0${index + 1} / 06`;
        document.querySelector('#demo-announcement').textContent = `مثال توضيحي: ${title}`;
    }));
    const form = document.querySelector('#tracking-form');
    if (!form) return;
    const input = form.querySelector('#tracking-number');
    const result = document.querySelector('#tracking-result');
    input.addEventListener('input', () => {
        input.setCustomValidity('');
        result.hidden = true;
    });
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const number = input.value.trim();
        if (!number || number.length > 80) {
            input.setCustomValidity('أدخل رقم شحنة من 1 إلى 80 حرفًا.');
            input.reportValidity();
            return;
        }
        input.setCustomValidity('');
        const message = trackingMessage(number);
        // User input is always text, never HTML, and no shipment status is fabricated.
        document.querySelector('#tracking-message').textContent = message;
        configureWhatsAppLink(document.querySelector('#tracking-whatsapp'), message);
        result.hidden = false;
    });
}
