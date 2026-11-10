export function initTracking() {
    const form = document.querySelector('#tracking-form');
    if (!form) return;

    const input = form.querySelector('#tracking-input');
    const submit = form.querySelector('#submit-btn');
    const progress = form.querySelector('#search-progress');

    input.addEventListener('input', () => input.setCustomValidity(''));
    form.addEventListener('submit', event => {
        input.value = input.value.trim();
        if (!input.value) {
            event.preventDefault();
            input.setCustomValidity('أدخل رقم البوليصة.');
            input.reportValidity();
            return;
        }

        submit.disabled = true;
        form.setAttribute('aria-busy', 'true');
        progress.hidden = false;
    });

    window.addEventListener('pageshow', () => {
        submit.disabled = false;
        form.removeAttribute('aria-busy');
        progress.hidden = true;
    });
}
