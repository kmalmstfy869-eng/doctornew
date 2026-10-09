function apFinance() {
    return {
        show: false,
        busy: false,
        type: 'income',
        cats: { income: {}, expense: {} },
        category: '',

        init() {
            const el = this.$el;

            try {
                this.cats = JSON.parse(el.dataset.categories || '{}');
            } catch (e) {
                this.cats = { income: {}, expense: {} };
            }

            // رجّع النوع والتصنيف القديم (old) لو في خطأ
            const oldType = el.dataset.oldType;
            this.type = this.cats[oldType] ? oldType : 'income';

            const keys = Object.keys(this.cats[this.type] || {});
            const oldCat = el.dataset.oldCategory;
            this.category = keys.includes(oldCat) ? oldCat : (keys[0] || '');

            // لو الفاليديشن فشل: افتح المودال تاني
            if (el.dataset.hasErrors === '1') this.show = true;
        },

        setType(t) {
            this.type = t;
            this.category = Object.keys(this.cats[t] || {})[0] || '';
        },
    };
}

// بحث وفلاتر لايف: بيجيب نفس الصفحة ويبدّل حاوية النتائج بس.
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('finance-filters');
    const box = document.getElementById('finance-results');
    if (!form || !box) return;

    const baseUrl = form.getAttribute('action');
    let timer = null;
    let controller = null;

    function buildUrl(page) {
        const params = new URLSearchParams();
        new FormData(form).forEach((v, k) => {
            v = String(v).trim();
            if (v !== '') params.set(k, v);
        });
        if (page) params.set('page', page);
        const qs = params.toString();
        return qs ? baseUrl + '?' + qs : baseUrl;
    }

    async function load(url) {
        if (controller) controller.abort(); // يلغي الطلب القديم عشان ميحصلش تداخل
        controller = new AbortController();
        box.style.opacity = '.5';
        box.style.pointerEvents = 'none';

        try {
            const res = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                credentials: 'same-origin',
                signal: controller.signal,
            });
            if (!res.ok) throw new Error('bad status');

            // DOMParser مش بينفذ سكربتات، فآمن.
            const doc = new DOMParser().parseFromString(await res.text(), 'text/html');
            const fresh = doc.getElementById('finance-results');
            if (!fresh) throw new Error('no results block'); // مثلًا الجلسة انتهت

            box.innerHTML = fresh.innerHTML;
            history.replaceState(null, '', url);
        } catch (err) {
            if (err.name === 'AbortError') return;
            window.location.href = url; // لو حصل أي خطأ، تحميل عادي للصفحة
            return;
        } finally {
            box.style.opacity = '';
            box.style.pointerEvents = '';
        }
    }

    // الكتابة في البحث (مع تأخير بسيط)
    form.elements['search'].addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => load(buildUrl()), 350);
    });

    // باقي الفلاتر فورًا
    ['from', 'to', 'type', 'category'].forEach((name) => {
        form.elements[name].addEventListener('change', () => load(buildUrl()));
    });

    // Enter ميعملش ريفرش للصفحة
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        clearTimeout(timer);
        load(buildUrl());
    });

    // الصفحات (pagination) من غير ريفرش
    box.addEventListener('click', (e) => {
        const a = e.target.closest('.ap-card__foot a[href]');
        if (!a) return;
        const url = new URL(a.href, window.location.origin);
        if (url.origin !== window.location.origin) return;
        e.preventDefault();
        load(buildUrl(url.searchParams.get('page')));
    });
});
