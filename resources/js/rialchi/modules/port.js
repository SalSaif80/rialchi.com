// Only the highest remaining container in a column can be unloaded.
export function isAccessible(target, containers) {
    return !target.removed && !containers.some(item => !item.removed && item.col === target.col && item.row > target.row);
}
export function initPort() {
    const scene = document.querySelector('#interactive-port');
    if (!scene) return;
    const status = document.querySelector('#port-status');
    const truck = scene.querySelector('#port-truck');
    const trolley = scene.querySelector('#hoist-trolley');
    const cable = scene.querySelector('#hoist-cable');
    const spreader = scene.querySelector('#hoist-spreader');
    const preference = matchMedia('(prefers-reduced-motion: reduce)');
    const containers = [...scene.querySelectorAll('.cargo-container')].map(el => ({el, col:+el.dataset.col, row:+el.dataset.row, x:+el.dataset.x, y:+el.dataset.y, removed:false}));
    let busy = false, hoistX = 900, hoistY = 150, truckX = 1250;
    const drawHoist = () => {
        trolley.setAttribute('transform', `translate(${hoistX} 0)`);
        cable.setAttribute('d', `M${hoistX} 90V${hoistY}`);
        spreader.setAttribute('transform', `translate(${hoistX} ${hoistY})`);
    };
    const refresh = () => {
        containers.forEach(c => {
            const available = isAccessible(c, containers);
            c.el.classList.toggle('is-available', available);
            c.el.setAttribute('aria-disabled', String(!available || busy));
            c.el.setAttribute('aria-label', `حاوية ${c.col+1}، مستوى ${c.row+1}، ${available ? 'متاحة للتفريغ' : 'أزل الحاوية التي فوقها أولًا'}`);
        });
    };
    // A single clock keeps cable, trolley, spreader and cargo physically connected.
    const tween = (duration, paint) => new Promise(resolve => {
        let elapsed = 0, previous;
        const frame = now => {
            const reduced = preference.matches;
            const paused = document.body.classList.contains('paused');
            if (reduced) elapsed = duration;
            else if (!paused && previous !== undefined) elapsed += now-previous;
            previous = now;
            const t = Math.min(elapsed/duration,1), eased = t*t*(3-2*t);
            paint(eased);
            if(t===1) resolve(); else requestAnimationFrame(frame);
        };
        requestAnimationFrame(frame);
    });
    const moveHoist = (x,y,duration,cargo=null) => {
        const startX = hoistX, startY = hoistY;
        return tween(duration, t => {
            hoistX = startX+(x-startX)*t; hoistY = startY+(y-startY)*t; drawHoist();
            if(cargo) cargo.el.setAttribute('transform', `translate(${hoistX-39-cargo.x} ${hoistY+8-cargo.y})`);
        });
    };
    const moveTruck = (x,duration,cargo=null) => {
        const start = truckX;
        return tween(duration,t=> {
            truckX = start+(x-start)*t;
            truck.setAttribute('transform',`translate(${truckX} 0)`);
            if(cargo) cargo.el.setAttribute('transform',`translate(${truckX+5-cargo.x} ${372-cargo.y})`);
        });
    };
    const unload = async cargo => {
        if(busy || cargo.removed) return;
        if(!isAccessible(cargo,containers)) {
            status.textContent = 'هذه الحاوية تحت حاوية أخرى. أزل الحاوية التي فوقها أولًا.';
            return;
        }
        if(document.body.classList.contains('paused') && !preference.matches) {
            status.textContent = 'الحركة متوقفة. اضغط «تشغيل الحركة» ثم اختر الحاوية.';
            return;
        }
        busy=true; refresh(); scene.classList.add('is-working'); cargo.el.classList.add('is-selected');
        status.textContent='الونش يتحرك إلى الحاوية المختارة وينزل الحبل.';
        await moveHoist(cargo.x+39,150,850);
        await moveHoist(cargo.x+39,cargo.y-8,650);
        status.textContent='تم تثبيت الحاوية. الونش يرفعها وينقلها إلى الرصيف.';
        await moveHoist(cargo.x+39,150,800,cargo);
        scene.classList.add('workers-guiding');
        await moveHoist(939,150,1200,cargo);
        await moveHoist(939,370,850,cargo);
        await moveHoist(939,150,650);
        status.textContent='الحاوية على الرصيف. الشاحنة تصل لاستلامها.';
        await moveTruck(895,1200);
        scene.classList.add('workers-loading');
        await moveHoist(939,370,650);
        await moveHoist(939,300,500,cargo);
        await moveHoist(939,364,550,cargo);
        await moveHoist(939,150,650);
        status.textContent='ثبّت العمال الحاوية على الشاحنة. الشاحنة تغادر الميناء.';
        scene.classList.remove('workers-guiding','workers-loading');
        await moveTruck(1250,1500,cargo);
        const hadFocus = document.activeElement === cargo.el;
        cargo.removed=true; cargo.el.style.display='none'; cargo.el.classList.remove('is-selected');
        scene.classList.remove('is-working','workers-loading','workers-guiding');
        busy=false; refresh();
        if (hadFocus) (containers.find(item => isAccessible(item, containers))?.el ?? document.querySelector('.start-copy .primary')).focus();
        const remaining=containers.filter(c=>!c.removed).length;
        status.textContent=remaining ? `غادرت الشاحنة. بقيت ${remaining} حاوية؛ اختر التالية من أعلى الرصّة.` : 'اكتمل تفريغ السفينة.';

    };
    containers.forEach(c=> {
        c.el.addEventListener('click',()=>unload(c));
        c.el.addEventListener('keydown',e=>{ if(e.key==='Enter'||e.key===' '){e.preventDefault();unload(c);} });
    });
    refresh();
}
