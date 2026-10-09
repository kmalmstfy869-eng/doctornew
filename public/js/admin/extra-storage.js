(() => {
    'use strict';

    const parse = (v, fb) => { try { return v ? JSON.parse(v) : fb; } catch (e) { return fb; } };
    const round2 = (n) => Math.round((Number(n) || 0) * 100) / 100;
    const money = (n) => Number(n || 0).toLocaleString('en-US', { maximumFractionDigits: 2 });
    const addDays = (d, n) => {
        if (!d) return '';
        const t = new Date(d + 'T00:00:00Z');
        if (isNaN(t)) return '';
        t.setUTCDate(t.getUTCDate() + Number(n || 0));
        return t.toISOString().slice(0, 10);
    };

    // دوال مشتركة (methods فقط، مفيش getters عشان الـ spread)
    const common = () => ({
        money,
        planOf(k) { return this.cfg.plans.find(p => p.key === k) || null; },
        saving(p) {
            const m = this.cfg.plans.find(x => x.days <= 31);
            return m && p.days >= 360 ? Math.max(round2(m.price * 12 - p.price), 0) : 0;
        },
        clampUnits(n) {
            n = Math.floor(Number(n) || 1);
            return Math.min(Math.max(n, 1), this.cfg.max_units);
        },
        setUnits(n) { this.units = this.clampUnits(n); this.onConfig(); },
        setPeriod(k) { this.period = k; this.onConfig(); },
    });

    /* ---------------- إضافة ---------------- */
    window.apExtAdd = () => ({
        ...common(),
        show: false, busy: false,
        cfg: { plans: [], unit_gb: 25, max_units: 20, base_gb: 25 },
        period: '', units: 1, start: '', amount: '',
        doctor: null, q: '', results: [], searched: false, loading: false, ctrl: null, searchUrl: '',

        init() {
            const d = this.$el.dataset;
            this.cfg = parse(d.cfg, this.cfg);
            this.cfg.today = d.today || '';
            this.searchUrl = d.searchUrl || '';
            this.start = d.today || '';
            this.period = (this.cfg.plans[0] || {}).key || '';
            this.onConfig();

            if (d.hasErrors === '1') {
                this.period = d.oldPeriod || this.period;
                this.units = this.clampUnits(d.oldUnits || 1);
                this.start = d.oldStart || this.start;
                this.amount = d.oldAmount || this.catalog;
                if (d.oldDoctorId) this.doctor = { id: d.oldDoctorId, name: d.oldDoctorName || '' };
                this.show = true;
                if (!this.doctor) this.search();
            }
        },

        get plan() { return this.planOf(this.period); },
        get catalog() { return this.plan ? round2(this.plan.price * this.units) : 0; },
        get end() { return this.plan ? addDays(this.start, this.plan.days) : ''; },

        onConfig() { this.amount = this.catalog; },
        open(detail) {
            this.busy = false;
            if (detail && detail.period && this.planOf(detail.period)) { this.period = detail.period; this.onConfig(); }
            this.show = true;
            if (!this.doctor) this.search();
        },
        pick(d) { this.doctor = d; this.results = []; this.q = ''; this.searched = false; },

        async search() {
            if (!this.searchUrl) return;
            if (this.ctrl) this.ctrl.abort();
            this.ctrl = new AbortController();
            this.loading = true;
            try {
                const res = await fetch(this.searchUrl + '?q=' + encodeURIComponent(this.q.trim()), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    credentials: 'same-origin', signal: this.ctrl.signal,
                });
                if (!res.ok) throw new Error('bad status');
                const list = await res.json();
                this.results = Array.isArray(list) ? list : [];
                this.searched = true; this.loading = false;
            } catch (e) {
                if (e.name === 'AbortError') return;
                this.results = []; this.searched = true; this.loading = false;
            }
        },
    });

    /* ---------------- تعديل (الحساب النهائي على السيرفر، ده عرض فقط) ---------------- */
    window.apExtChange = () => ({
        ...common(),
        show: false, busy: false,
        cfg: { plans: [], unit_gb: 25, max_units: 20, base_gb: 25 },
        sub: null, period: '', units: 1, newPrice: 0, collected: 0, today: '',

        init() {
            const d = this.$el.dataset;
            this.cfg = parse(d.cfg, this.cfg);
            this.today = d.today || '';
            if (d.hasErrors === '1') {
                const s = parse(d.reopen, null);
                if (s) this.open(s, { period: d.oldPeriod, units: d.oldUnits, price: d.oldPrice, collected: d.oldCollected });
            }
        },

        get plan() { return this.planOf(this.period); },
        get catalog() { return this.plan ? round2(this.plan.price * this.units) : 0; },
        get same() { return !!this.sub && this.period === this.sub.period && Number(this.units) === Number(this.sub.units); },
        get credit() { return this.sub ? round2(this.sub.credit) : 0; },
        get due() { return Math.max(round2(Number(this.newPrice || 0) - this.credit), 0); },
        get bonus() {
            const price = Number(this.newPrice || 0);
            const leftover = Math.max(round2(this.credit - price), 0);
            return this.plan && price > 0 && leftover > 0 ? Math.floor(leftover / (price / this.plan.days)) : 0;
        },
        get end() { return this.plan ? addDays(this.today, this.plan.days + this.bonus) : ''; },
        get newGb() { return this.units * this.cfg.unit_gb; },
        get shrink() { return !!this.sub && this.newGb < Number(this.sub.used_gb); },

        onConfig() { this.newPrice = this.catalog; this.collected = this.due; },
        onPrice() { this.collected = this.due; },

        open(s, old) {
            this.sub = s; this.busy = false;
            this.period = (old && old.period) || s.period;
            this.units = this.clampUnits((old && old.units) || s.units);
            this.onConfig();
            if (old && old.price !== undefined && old.price !== '') this.newPrice = Number(old.price);
            if (old && old.collected !== undefined && old.collected !== '') this.collected = Number(old.collected);
            this.show = true;
        },
    });

    /* ---------------- تجديد ---------------- */
    window.apExtRenew = () => ({
        ...common(),
        show: false, busy: false,
        cfg: { plans: [], unit_gb: 25, max_units: 20, base_gb: 25 },
        sub: null, period: '', units: 1, start: '', amount: '', today: '',

        init() {
            const d = this.$el.dataset;
            this.cfg = parse(d.cfg, this.cfg);
            this.today = d.today || '';
            if (d.hasErrors === '1') {
                const s = parse(d.reopen, null);
                if (s) this.open(s, { period: d.oldPeriod, units: d.oldUnits, start: d.oldStart, amount: d.oldAmount });
            }
        },

        get plan() { return this.planOf(this.period); },
        get catalog() {
            if (!this.sub) return 0;
            const p = this.sub.running ? this.planOf(this.sub.period) : this.plan;
            const u = this.sub.running ? this.sub.units : this.units;
            return p ? round2(p.price * u) : 0;
        },
        get days() {
            const p = this.sub && this.sub.running ? this.planOf(this.sub.period) : this.plan;
            return p ? p.days : 0;
        },
        get end() {
            if (!this.sub) return '';
            return addDays(this.sub.running ? this.sub.end : this.start, this.days);
        },

        // نفس الاشتراك = السعر الثابت، غير كده = سعر الباقة الحالي
        onConfig() {
            if (!this.sub) return;
            this.amount = (this.period === this.sub.period && Number(this.units) === Number(this.sub.units))
                ? this.sub.price : this.catalog;
        },

        open(s, old) {
            this.sub = s; this.busy = false;
            this.period = (old && old.period) || s.period;
            this.units = this.clampUnits((old && old.units) || s.units);
            this.start = (old && old.start) || this.today;
            this.amount = (old && old.amount !== undefined && old.amount !== '') ? old.amount : s.price;
            this.show = true;
        },
    });

    /* ---------------- بحث لايف + تبويبات + ترقيم ---------------- */
    const boot = () => {
        const input = document.getElementById('ext-search');
        const box = document.getElementById('ext-results');
        if (!input || !box) return;

        let timer = null, controller = null;

        const load = async (url) => {
            if (controller) controller.abort();
            controller = new AbortController();
            box.style.opacity = '.5';
            box.style.pointerEvents = 'none';
            try {
                const res = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
                    credentials: 'same-origin', signal: controller.signal,
                });
                if (!res.ok) throw new Error('bad status');
                const doc = new DOMParser().parseFromString(await res.text(), 'text/html');
                const fresh = doc.getElementById('ext-results');
                if (!fresh) throw new Error('no results block');
                box.innerHTML = fresh.innerHTML;
                history.replaceState(null, '', url);
            } catch (e) {
                if (e.name === 'AbortError') return;
                window.location.href = url;
            } finally {
                box.style.opacity = '';
                box.style.pointerEvents = '';
            }
        };

        input.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const u = new URL(window.location.href);
                const q = input.value.trim();
                q ? u.searchParams.set('search', q) : u.searchParams.delete('search');
                u.searchParams.delete('page');
                load(u.toString());
            }, 350);
        });

        box.addEventListener('click', (e) => {
            const a = e.target.closest('a[data-ext-nav], .ap-card__foot a[href]');
            if (!a) return;
            const u = new URL(a.href, window.location.origin);
            if (u.origin !== window.location.origin) return;
            e.preventDefault();
            load(u.toString());
        });
    };

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
    else boot();

    window.addEventListener('pageshow', (e) => { if (e.persisted) window.location.reload(); });
})();
