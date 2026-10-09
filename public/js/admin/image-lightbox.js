(function () {
    const SELECTOR = '.profile-image-wrapper img.profile-image, .clinic-images-preview img';

    let group = [];
    let index = 0;
    let overlay, imgEl, counter, prevBtn, nextBtn;

    function build() {
        overlay = document.createElement('div');
        overlay.className = 'lb-overlay';
        overlay.hidden = true;
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');

        overlay.innerHTML = `
            <button type="button" class="lb-btn lb-close" aria-label="إغلاق">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <button type="button" class="lb-btn lb-prev" aria-label="السابقة">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
            <img class="lb-img" alt="">
            <button type="button" class="lb-btn lb-next" aria-label="التالية">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="lb-counter"></div>
        `;

        document.body.appendChild(overlay);

        imgEl = overlay.querySelector('.lb-img');
        counter = overlay.querySelector('.lb-counter');
        prevBtn = overlay.querySelector('.lb-prev');
        nextBtn = overlay.querySelector('.lb-next');

        overlay.querySelector('.lb-close').addEventListener('click', close);
        prevBtn.addEventListener('click', () => go(-1));
        nextBtn.addEventListener('click', () => go(1));

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) close();
        });
    }

    function render() {
        imgEl.src = group[index].src;

        const multi = group.length > 1;
        prevBtn.hidden = !multi;
        nextBtn.hidden = !multi;
        counter.hidden = !multi;
        counter.textContent = (index + 1) + ' / ' + group.length;
    }

    function open(images, start) {
        if (!overlay) build();
        group = images;
        index = start;
        render();
        overlay.hidden = false;
        document.body.style.overflow = 'hidden';
    }

    function close() {
        if (!overlay || overlay.hidden) return;
        overlay.hidden = true;
        imgEl.src = '';
        document.body.style.overflow = '';
    }

    function go(step) {
        index = (index + step + group.length) % group.length;
        render();
    }

    // الصور الجديدة (المعاينة) بتشتغل تلقائي لأن الربط على document
    document.addEventListener('click', function (e) {
        const img = e.target.closest(SELECTOR);
        if (!img || !img.getAttribute('src')) return;

        const images = img.closest('.clinic-images-preview')
            ? Array.from(document.querySelectorAll('.clinic-images-preview img'))
            : [img];

        open(images, images.indexOf(img));
    });

    document.addEventListener('keydown', function (e) {
        if (!overlay || overlay.hidden) return;

        if (e.key === 'Escape') close();
        if (group.length > 1) {
            if (e.key === 'ArrowLeft') go(1);   // RTL: الشمال = التالي
            if (e.key === 'ArrowRight') go(-1);
        }
    });
})();
