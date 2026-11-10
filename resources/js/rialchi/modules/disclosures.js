// Animate native details on browsers without intrinsic-size transitions.
export function initDisclosures() {
    if (CSS.supports('interpolate-size: allow-keywords') && CSS.supports('selector(::details-content)')) return;
    const reduced = matchMedia('(prefers-reduced-motion: reduce)');
    document.querySelectorAll('.plain-services details, .beginner-faq details').forEach(details => {
        const summary = details.querySelector('summary');
        let animation;
        let expanding;
        summary.addEventListener('click', event => {
            if (reduced.matches || !details.animate) return;
            event.preventDefault();
            const start = details.getBoundingClientRect().height;
            expanding = animation ? !expanding : !details.open;
            animation?.cancel();
            details.open = true;
            details.style.overflow = 'hidden';
            const end = expanding ? details.getBoundingClientRect().height : summary.offsetHeight;
            animation = details.animate([{height: start + 'px'}, {height: end + 'px'}], {
                duration: 320, easing: 'ease-in-out'
            });
            animation.onfinish = () => {
                details.open = expanding;
                details.style.overflow = '';
                animation = null;
            };
        });
    });
}
