import { configureWhatsAppLink, whatsappUrl } from './whatsapp.js';

export function initContact() {
    document.querySelectorAll('.wa-link, [data-wa]').forEach((link) => {
        configureWhatsAppLink(link, link.dataset.message ?? link.dataset.wa ?? 'السلام عليكم فريق ريالتشي');
    });
    const dialog = document.querySelector('#quote');
    const form = document.querySelector('#quote-form');
    if (!dialog || !form) return;
    let trigger;
    document.querySelectorAll('[data-service], [data-quote]').forEach((button) => {
        button.addEventListener('click', () => {
            trigger = button;
            if (button.dataset.service) form.elements.service.value = button.dataset.service;
            document.querySelector('#form-status').textContent = '';
            dialog.showModal();
        });
    });
    dialog.querySelector('.close')?.addEventListener('click', () => dialog.close());
    dialog.addEventListener('close', () => trigger?.focus());
    dialog.addEventListener('click', (event) => {
        if (event.target !== dialog) return;
        const bounds = dialog.getBoundingClientRect();
        if (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom) dialog.close();
    });
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const data = new FormData(form);
        const message = `السلام عليكم، أريد عرض سعر.\nالخدمة: ${data.get('service')}\nالاسم: ${data.get('name')}\nمن: ${data.get('origin')}\nإلى: ${data.get('destination')}\nالتفاصيل: ${data.get('details')}`;
        const url = whatsappUrl(message);
        if (!url) { document.querySelector('#form-status').textContent = 'رقم التواصل غير متاح حاليًا.'; return; }
        location.assign(url);
    });
}
