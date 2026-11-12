import { t } from './i18n.js';
export function initNavigation() {
    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('#nav');
    if (!toggle || !nav) return;
    const label = toggle.querySelector('.menu-label');
    const mobile = matchMedia('(max-width: 580px)');
    const setOpen = (open) => {
        nav.classList.toggle('open', open);
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? t('إغلاق القائمة') : t('فتح القائمة'));
        label.textContent = open ? t('إغلاق') : t('القائمة');
        nav.inert = mobile.matches && !open;
    };
    setOpen(false);
    mobile.addEventListener('change', () => setOpen(false));
    document.addEventListener('click', event => {
        if (!toggle.contains(event.target) && !nav.contains(event.target) && nav.classList.contains('open')) setOpen(false);
    });
    toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));
    nav.addEventListener('click', (event) => {
        if (event.target.closest('a, button')) setOpen(false);
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && nav.classList.contains('open')) {
            setOpen(false);
            toggle.focus();
        }
    });
}
