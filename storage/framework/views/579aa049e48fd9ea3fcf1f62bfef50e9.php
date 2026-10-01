<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'nav',
    'title',
    'title_continue',
    'note1',
    'anser1',
    'note2',
    'anser2',
    'home' => false,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'nav',
    'title',
    'title_continue',
    'note1',
    'anser1',
    'note2',
    'anser2',
    'home' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>


<section class="home-hero">

    <div class="site-container home-hero-grid">


        
        <div class="home-hero-content">


            
            <div class="home-hero-badge">

                <i class="fa-solid fa-circle-check"></i>

                <?php echo e($nav); ?>


            </div>


            
            <h2>

                <?php echo e($title); ?>


                <span>

                    <?php echo e($title_continue); ?>


                </span>

            </h2>


            
            <p>

                <?php echo e($slot); ?>


            </p>


            
            <?php if($home): ?>


                
                <form
                    class="home-search-form"
                    id="homeSearchForm"
                >

                    <div class="home-search-field">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input
                            type="text"
                            id="doctorSearchInput"
                            placeholder="ابحث باسم الطبيب أو التخصص"
                        >

                    </div>


                    <div class="home-search-field">

                        <i class="fa-solid fa-location-dot"></i>

                        <select id="governorateSelect">

                            <option value="">

                                اختر المحافظة

                            </option>

                            <option value="beheira">

                                البحيرة

                            </option>

                            <option value="cairo">

                                القاهرة

                            </option>

                            <option value="alexandria">

                                الإسكندرية

                            </option>

                            <option value="giza">

                                الجيزة

                            </option>

                        </select>

                    </div>


                    <button
                        type="submit"
                        class="home-search-button"
                    >

                        <i class="fa-solid fa-search"></i>

                        ابحث الآن

                    </button>

                </form>


                
                <div class="home-hero-trust">


                    <div class="home-trust-item">

                        <div class="home-trust-icon">

                            <i class="fa-solid fa-circle-check"></i>

                        </div>

                        <div>

                            <strong>

                                أطباء معتمدون

                            </strong>

                            <span>

                                بيانات تمت مراجعتها

                            </span>

                        </div>

                    </div>


                    <div class="home-trust-line"></div>


                    <div class="home-trust-item">

                        <div class="home-trust-icon">

                            <i class="fa-solid fa-stethoscope"></i>

                        </div>

                        <div>

                            <strong>

                                تخصصات متنوعة

                            </strong>

                            <span>

                                اختر ما يناسبك

                            </span>

                        </div>

                    </div>


                    <div class="home-trust-line"></div>


                    <div class="home-trust-item">

                        <div class="home-trust-icon">

                            <i class="fa-solid fa-location-dot"></i>

                        </div>

                        <div>

                            <strong>

                                بحث حسب المنطقة

                            </strong>

                            <span>

                                طبيب قريب منك

                            </span>

                        </div>

                    </div>


                </div>


            <?php else: ?>


                
                <div class="hero-buttons">


                    <a
                        href="<?php echo e(route('doctors.index')); ?>"
                        class="btn btn-primary"
                    >

                        اكتشف الأطباء

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>


                    <span
                        class="btn btn-outline"
                        role="button"
                        tabindex="0"
                    >

                        تواصل معنا

                        <i class="fa-solid fa-headset"></i>

                    </span>


                </div>


            <?php endif; ?>


        </div>


        
        <div class="home-hero-visual">


            <div class="home-visual-circle">

                <div class="home-doctor-visual">

                    <i class="fa-solid fa-user-doctor"></i>

                </div>

            </div>


            
            <div class="home-floating-card home-floating-card-one">


                <div class="home-floating-icon">

                    <i class="fa-solid fa-circle-check"></i>

                </div>


                <div>

                    <h4>

                        <?php echo e($note1); ?>


                    </h4>

                    <p>

                        <?php echo e($anser1); ?>


                    </p>

                </div>


            </div>


            
            <div class="home-floating-card home-floating-card-two">


                <div class="home-floating-icon">

                    <i class="fa-solid fa-star"></i>

                </div>


                <div>

                    <h4>

                        <?php echo e($note2); ?>


                    </h4>

                    <p>

                        <?php echo e($anser2); ?>


                    </p>

                </div>


            </div>


        </div>


    </div>

</section>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/home/hero/firsthero.blade.php ENDPATH**/ ?>