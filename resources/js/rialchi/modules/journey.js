export function initJourney() {
    const steps = [...document.querySelectorAll('.journey-step')];
    const visual = document.querySelector('.journey-visual');
    if (!steps.length || !visual) return;
    const labels = ['فكرة تبدأ منها الرحلة', 'تفاصيل تعرف بها منتجك ومورّده', 'مواصفات تتحقق منها قبل الشحن', 'طريق تختاره وفق الوقت والتكلفة', 'شحنة تصل، وتفاصيل تراجعها'];
    let active = -1;
    let scheduled = false;
    const update = () => {
        scheduled = false;
        const focus = innerWidth <= 580 ? visual.getBoundingClientRect().bottom + 110 : innerHeight * 0.48;
        let next = 0;
        steps.forEach((step, index) => { if (step.getBoundingClientRect().top <= focus) next = index; });
        if (next === active) return;
        active = next;
        document.querySelectorAll('[data-scene]').forEach((scene, i) => scene.classList.toggle('active', i === next));
        steps.forEach((step, i) => step.classList.toggle('is-current', i === next));
        document.querySelectorAll('[data-stop]').forEach((stop, i) => {
            stop.classList.toggle('active', i === next);
            stop.classList.toggle('passed', i < next);
            if (i === next) stop.setAttribute('aria-current', 'step');
            else stop.removeAttribute('aria-current');
        });
        document.querySelector('#scene-code').textContent = `0${next + 1} / 05`;
        document.querySelector('#scene-label').textContent = labels[next];
        document.querySelector('#journey-fill').style.width = `${next / 4 * 90}%`;
    };
    const schedule = () => {
        if (!scheduled) { scheduled = true; requestAnimationFrame(update); }
    };
    addEventListener('scroll', schedule, { passive: true });
    addEventListener('resize', schedule);
    addEventListener('load', schedule);
    document.fonts?.ready.then(schedule);
    update();
}
