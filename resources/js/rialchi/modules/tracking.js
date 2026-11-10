import { configureWhatsAppLink } from './whatsapp.js';

export function trackingMessage(number) {
    return `السلام عليكم فريق ريالتشي، أريد الاستفسار عن حالة شحنتي.\nرقم الشحنة أو الطلب: ${number.trim()}`;
}

export function initTracking() {
    const form = document.querySelector('#tracking-form');
    if (!form) return;

    const input = form.querySelector('#tracking-input');
    const search = document.querySelector('#search-view');
    const results = document.querySelector('#results-view');
    const routeTitle = results.querySelector('#route-title');
    const details = results.querySelector('.shipment-details');

    input.addEventListener('input', () => input.setCustomValidity(''));
    form.addEventListener('submit', event => {
        event.preventDefault();
        const number = input.value.trim();
        if (!number || number.length > 80) {
            input.setCustomValidity('أدخل رقم شحنة من 1 إلى 80 حرفًا.');
            input.reportValidity();
            return;
        }

        results.querySelector('#res-tracking-num').textContent = number;
        configureWhatsAppLink(results.querySelector('.tracking-wa-btn'), trackingMessage(number));
        search.hidden = true;
        results.hidden = false;
        details.open = false;
        routeTitle.focus();
    });

    results.querySelector('#back-to-search').addEventListener('click', () => {
        results.hidden = true;
        search.hidden = false;
        form.reset();
        input.focus();
    });
}
