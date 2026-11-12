import { t } from './i18n.js';
export function initMotion() {
    const preference = matchMedia('(prefers-reduced-motion: reduce)');
    const elements = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && !preference.matches) {
        document.documentElement.classList.add('js');
        const observer = new IntersectionObserver((entries) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) continue;
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        }, { threshold: 0.12 });
        elements.forEach((element) => observer.observe(element));
    }
    const control = document.querySelector('#motion');
    control?.addEventListener('click', () => {
        const paused = document.body.classList.toggle('paused');
        control.setAttribute('aria-pressed', String(paused));
        control.textContent = paused ? t('تشغيل الحركة') : t('إيقاف الحركة');
    });
    const applyPreference = () => {
        if (control) {
            control.disabled = preference.matches;
            control.textContent = preference.matches ? t('الحركة مخفّضة') : (document.body.classList.contains('paused') ? t('تشغيل الحركة') : t('إيقاف الحركة'));
        }
        if (preference.matches) elements.forEach((element) => element.classList.add('visible'));
    };
    preference.addEventListener('change', applyPreference);
    applyPreference();
    let scheduled = false;
    const update = () => {
        const total = document.documentElement.scrollHeight - innerHeight;
        const progress = document.querySelector('.progress');
        if (progress) progress.style.width = `${total > 0 ? scrollY / total * 100 : 0}%`;
        scheduled = false;
    };
    addEventListener('scroll', () => {
        if (!scheduled) { scheduled = true; requestAnimationFrame(update); }
    }, { passive: true });
    update();
}
