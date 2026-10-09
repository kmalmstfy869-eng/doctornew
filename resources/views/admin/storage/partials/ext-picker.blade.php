{{-- يتطلب في الـ Alpine scope: cfg, period, units, setPeriod(), setUnits(), saving(), money() --}}
<div class="ext-picker">
    <div class="ext-periods">
        <template x-for="p in cfg.plans" :key="p.key">
            <button type="button" class="ext-period" :class="{ 'is-selected': period === p.key }"
                @click="setPeriod(p.key)">
                <span class="ext-period__check"><i class="fa-solid fa-check"></i></span>
                <span class="ext-period__label" x-text="p.label"></span>
                <span class="ext-period__price"><b x-text="money(p.price)"></b>
                    <small>ج.م / <span x-text="p.days >= 360 ? 'سنة' : 'شهر'"></span> لكل <span
                            x-text="cfg.unit_gb"></span> GB</small></span>
                <span class="ext-period__per" x-text="'≈ ' + money(p.price / (p.days / 30)) + ' ج.م / شهر'"></span>
                <span class="ext-period__save" x-show="saving(p) > 0"
                    x-text="'وفّر ' + money(saving(p)) + ' ج.م سنويًا'"></span>
            </button>
        </template>
    </div>

    <div class="ext-units">
        <div>
            <label>عدد الوحدات</label>
            <small x-text="'كل وحدة = ' + cfg.unit_gb + ' GB'"></small>
        </div>
        <div class="ext-stepper">
            <button type="button" @click="setUnits(units - 1)" :disabled="units <= 1">−</button>
            <input type="number" name="units" x-model.number="units" @change="setUnits(units)" min="1"
                :max="cfg.max_units">
            <button type="button" @click="setUnits(units + 1)" :disabled="units >= cfg.max_units">+</button>
        </div>
        <div class="ext-units__gb">+<b x-text="units * cfg.unit_gb"></b> GB</div>
    </div>
</div>
