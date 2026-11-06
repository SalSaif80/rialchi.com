export function whatsappUrl(message, phone = document.body.dataset.whatsapp) {
    const digits = String(phone ?? '').replace(/[^0-9]/g, '');
    if (!/^[1-9][0-9]{7,14}$/.test(digits)) return null;
    return `https://wa.me/${digits}?text=${encodeURIComponent(message)}`;
}

export function configureWhatsAppLink(link, message) {
    const url = whatsappUrl(message);
    if (!url) {
        link.removeAttribute('href');
        link.setAttribute('aria-disabled', 'true');
        return;
    }
    link.href = url;
    link.target = '_blank';
    link.rel = 'noopener noreferrer';
}
