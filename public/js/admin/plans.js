const plFmt = (n) => Number(n).toLocaleString('en-US', { maximumFractionDigits: 2 });
const plParse = (s) => {
    try { return s && s !== 'null' ? JSON.parse(s) : null; } catch (e) { return null; }
};

/* ============ مودال تعديل الباقة ============ */
function apPlanTier() {
    let uid = 0;
    const row = (text = '') => ({ id: ++uid, text: text });

    return {
        show: false,
        busy: false,
        plan: null,
        description: '',
        features: [],
        bestPlan: '',
        prices: {},

        init() {
            // لو الصفحة رجعت من كاش المتصفح بعد submit ما يفضلش الزرار معطّل
            window.addEventListener('pageshow', () => { this.busy = false; });

            const reopen = plParse(this.$el.dataset.reopen);
            if (reopen) {
                // فيه أخطاء من السيرفر: افتح المودال تاني بالقيم اللي اتكتبت
                this.$nextTick(() => this.open(reopen, plParse(this.$el.dataset.old)));
            }
        },

        open(p, old = null) {
            const v = old || {};
            const pick = (a, b) => (a !== undefined && a !== null ? a : b);

            this.plan = p;
            this.busy = false;
            this.description = pick(v.description, p.description);
            // المدة اللي متعلّمة «الأفضل» (id) أو فاضي = مفيش
            this.bestPlan = String(old ? (v.best_plan ?? '') : (p.best_plan_id ?? ''));

            const pr = {};
            p.plans.forEach((x) => { pr[x.id] = pick((v.prices || {})[x.id], x.price); });
            this.prices = pr;

            const list = old ? (v.features || []) : (p.features || []);
            this.features = list.map((t) => row(t));
            if (!this.features.length) this.features.push(row());

            this.show = true;
        },

        perMonth(pl) {
            const v = parseFloat(this.prices[pl.id]);
            if (!isFinite(v) || this.prices[pl.id] === '' || !pl.duration) return '';
            return plFmt(v / (pl.duration / 30));
        },

        ladderWarn() {
            if (!this.plan || this.plan.is_free) return '';

            // رتّب بالمدة وتجاهل الأسعار الفاضية أو غير الصالحة
            const rows = this.plan.plans
                .slice()
                .sort((a, b) => a.duration - b.duration)
                .map((r) => ({ r, v: parseFloat(this.prices[r.id]) }))
                .filter((x) => isFinite(x.v) && x.v > 0);

            for (let i = 1; i < rows.length; i++) {
                if (rows[i].v < rows[i - 1].v) {
                    return 'سعر ' + rows[i].r.label + ' لازم يكون أكبر من سعر ' + rows[i - 1].r.label + '.';
                }
            }
            return '';
        },

        submit(e) {
            if (this.ladderWarn()) { e.preventDefault(); return; }
            this.busy = true;
        },

        addFeature() {
            if (this.features.length < 12) this.features.push(row());
        },

        removeFeature(i) {
            this.features.splice(i, 1);
            if (!this.features.length) this.features.push(row());
        },

        move(i, dir) {
            const j = i + dir;
            if (j < 0 || j >= this.features.length) return;
            const copy = this.features.slice();
            [copy[i], copy[j]] = [copy[j], copy[i]];
            this.features = copy;
        },
    };
}

/* ============ ترتيب الظهور ============ */
function apPlanOrder() {
    return {
        items: [],
        initial: '',

        init() {
            this.items = plParse(this.$el.dataset.items) || [];
            this.initial = this.ids();
        },

        ids() {
            return this.items.map((i) => i.id).join(',');
        },

        dirty() {
            return this.ids() !== this.initial;
        },

        move(i, dir) {
            const j = i + dir;
            if (j < 0 || j >= this.items.length) return;
            const copy = this.items.slice();
            [copy[i], copy[j]] = [copy[j], copy[i]];
            this.items = copy;
        },
    };
}
