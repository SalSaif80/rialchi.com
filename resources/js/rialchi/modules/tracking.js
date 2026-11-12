import { t } from './i18n.js';
export function initTracking() {
    const form = document.querySelector('#tracking-form');
    if (!form) return;

    const input = form.querySelector('#tracking-input');
    const submit = form.querySelector('#submit-btn');
    const progress = form.querySelector('#search-progress');

    let pending;

    input.addEventListener('input', () => input.setCustomValidity(''));
    form.addEventListener('submit', event => {
        event.preventDefault();
        if (submit.disabled) return;
        input.value = input.value.trim();
        if (!input.value) {
            input.setCustomValidity(t('أدخل رقم البوليصة.'));
            input.reportValidity();
            return;
        }

        input.readOnly = true;
        submit.disabled = true;
        form.setAttribute('aria-busy', 'true');
        progress.hidden = false;
        pending = window.setTimeout(() => form.submit(), 2500);
    });

    window.addEventListener('pagehide', () => window.clearTimeout(pending));
    window.addEventListener('pageshow', () => {
        input.readOnly = false;
        submit.disabled = false;
        form.removeAttribute('aria-busy');
        progress.hidden = true;
    });
}
