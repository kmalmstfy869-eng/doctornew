<?php $__env->startSection('title', 'الأسئلة الشائعة | دليل الأطباء'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/public/faq.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal4638470e2252daaacf3a7056bec03606 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4638470e2252daaacf3a7056bec03606 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.hero.secondhero','data' => ['title' => 'الأسئلة الشائعة','address' => 'فريق دليل طبيب','contet1' => ' لديك سؤال؟ لدينا ','contentContinuation' => 'الإجابة','note' => 'اعثر على إجابات واضحة وسريعة لكل ما تحتاج معرفته عن استخدام دليل الأطباء.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.hero.secondhero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'الأسئلة الشائعة','address' => 'فريق دليل طبيب','contet1' => ' لديك سؤال؟ لدينا ','content_continuation' => 'الإجابة','note' => 'اعثر على إجابات واضحة وسريعة لكل ما تحتاج معرفته عن استخدام دليل الأطباء.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4638470e2252daaacf3a7056bec03606)): ?>
<?php $attributes = $__attributesOriginal4638470e2252daaacf3a7056bec03606; ?>
<?php unset($__attributesOriginal4638470e2252daaacf3a7056bec03606); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4638470e2252daaacf3a7056bec03606)): ?>
<?php $component = $__componentOriginal4638470e2252daaacf3a7056bec03606; ?>
<?php unset($__componentOriginal4638470e2252daaacf3a7056bec03606); ?>
<?php endif; ?>


    
    <section class="categories-section">
        <div class="container">

            <div class="section-q-heading">
                <span>اختر القسم</span>
                <h2>كيف يمكننا مساعدتك؟</h2>
                <p>اختر القسم المناسب للوصول إلى الإجابة بسرعة.</p>
            </div>

            <div class="category-grid">

                <button type="button" class="category-card active" data-category="doctors">
                    <div class="category-icon"><i class="fa-solid fa-user-doctor"></i></div>
                    <h3>البحث عن الأطباء</h3>
                    <p>البحث حسب التخصص والمنطقة</p>
                </button>

                <button type="button" class="category-card" data-category="booking">
                    <div class="category-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <h3>الحجز</h3>
                    <p>حجز المواعيد مع الأطباء</p>
                </button>

                <button type="button" class="category-card" data-category="website">
                    <div class="category-icon"><i class="fa-solid fa-globe"></i></div>
                    <h3>الحساب واستخدام الموقع</h3>
                    <p>الحساب والمشاكل والتواصل</p>
                </button>

                <button type="button" class="category-card" data-category="for-doctors">
                    <div class="category-icon"><i class="fa-solid fa-stethoscope"></i></div>
                    <h3>للأطباء</h3>
                    <p>التسجيل والملف والحجوزات</p>
                </button>

            </div>
        </div>
    </section>

    
    <section class="questions-section">
        <div class="container">

            
            <div class="faq-category show" data-category="doctors">
                <div class="faq-title">
                    <div class="faq-title-icon"><i class="fa-solid fa-user-doctor"></i></div>
                    <div>
                        <h2>البحث عن الأطباء</h2>
                        <p>كل ما يخص البحث عن الأطباء</p>
                    </div>
                </div>
                <div class="faq-list">

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">01</span>كيف يمكنني البحث عن طبيب؟
                            </div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">يمكنك البحث عن الطبيب من خلال صفحة الأطباء، ثم استخدام خيارات البحث والتصفية
                            للوصول إلى الطبيب المناسب حسب البيانات المتاحة.</div>
                    </article>

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">02</span>هل يمكنني البحث عن طبيب حسب
                                التخصص والمنطقة؟</div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">نعم، يمكنك تحديد التخصص والمنطقة للوصول إلى الأطباء المتاحين وفقًا لخيارات
                            البحث الموجودة على الموقع.</div>
                    </article>

                </div>
            </div>

            
            <div class="faq-category" data-category="booking">
                <div class="faq-title">
                    <div class="faq-title-icon"><i class="fa-solid fa-calendar-check"></i></div>
                    <div>
                        <h2>الحجز</h2>
                        <p>حجز المواعيد مع الأطباء</p>
                    </div>
                </div>
                <div class="faq-list">

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">01</span>كيف يمكنني حجز موعد مع طبيب؟
                            </div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">يمكنك الدخول إلى ملف الطبيب الذي يوفر خدمة الحجز، ثم اختيار الموعد المناسب
                            واتباع خطوات الحجز الموضحة في صفحة الطبيب.</div>
                    </article>

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">02</span>هل الحجز الإلكتروني متاح مع
                                جميع الأطباء؟</div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">لا، الحجز الإلكتروني متاح فقط للأطباء الذين لديهم خدمة الحجز مفعّلة على
                            ملفاتهم.</div>
                    </article>


                </div>
            </div>

            
            <div class="faq-category" data-category="website">
                <div class="faq-title">
                    <div class="faq-title-icon"><i class="fa-solid fa-globe"></i></div>
                    <div>
                        <h2>الحساب واستخدام الموقع</h2>
                        <p>الحساب والمشاكل التقنية والتواصل</p>
                    </div>
                </div>
                <div class="faq-list">

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">01</span>هل استخدام الموقع مجاني؟
                            </div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">نعم، استخدام الموقع والبحث عن الأطباء وتصفح المعلومات المتاحة للمستخدمين
                            مجاني. أما الخدمات أو الاشتراكات الخاصة بالأطباء فتخضع للنظام والباقات المخصصة لهم.</div>
                    </article>

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">02</span>هل أحتاج إلى إنشاء حساب
                                لاستخدام الموقع؟</div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">لا، يمكنك تصفح الموقع والبحث عن الأطباء والاستفادة من المحتوى المتاح دون
                            إنشاء حساب. ومع ذلك، تتطلب بعض الخدمات التي تعتمد على حساب المستخدم تسجيل الدخول، مثل إضافة
                            وظيفة أو إرسال تقييم، إذا كانت هذه الخدمات متاحة في حسابك.</div>
                    </article>

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">03</span>الموقع لا يعمل لدي، ماذا
                                أفعل؟</div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">جرّب تحديث الصفحة والتأكد من اتصالك بالإنترنت، ثم حاول فتح الموقع باستخدام
                            متصفح آخر. إذا استمرت المشكلة، يمكنك التواصل مع إدارة الموقع لمساعدتك.</div>
                    </article>

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">04</span>كيف يمكنني التواصل مع إدارة
                                الموقع؟</div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">يمكنك التواصل مع إدارة دليل الأطباء من خلال صفحة «تواصل معنا»، وكتابة
                            بياناتك ورسالتك وإرسالها إلى فريق الموقع.</div>
                    </article>

                </div>
            </div>

            
            <div class="faq-category" data-category="for-doctors">
                <div class="faq-title">
                    <div class="faq-title-icon"><i class="fa-solid fa-stethoscope"></i></div>
                    <div>
                        <h2>للأطباء</h2>
                        <p>التسجيل والملف الشخصي والحجوزات</p>
                    </div>
                </div>
                <div class="faq-list">

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">01</span>كيف يمكنني التسجيل كطبيب؟
                            </div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">يمكنك التسجيل من خلال صفحة الانضمام كطبيب وإدخال البيانات المطلوبة الخاصة
                            بالطبيب والعيادة. بعد إرسال الطلب، تتم مراجعة البيانات قبل اعتماد الملف.</div>
                    </article>

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">02</span>هل تظهر بيانات الطبيب
                                مباشرة بعد التسجيل؟</div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">لا، لا تظهر بيانات الطبيب للزوار مباشرة بعد التسجيل. يتم أولًا مراجعة
                            البيانات واعتماد الحساب، وبعد الموافقة يظهر ملف الطبيب على دليل الأطباء.</div>
                    </article>

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">03</span>هل يمكنني تعديل بيانات ملفي
                                بعد التسجيل؟</div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">نعم، بعد اعتماد حساب الطبيب يمكنك تعديل بيانات ملفك من خلال حسابك، وفقًا
                            للصلاحيات والخيارات المتاحة في لوحة الطبيب.</div>
                    </article>

                    <article class="faq-item">
                        <button type="button" class="faq-question">
                            <div class="question-right"><span class="question-number">04</span>هل يمكنني استقبال حجوزات من
                                خلال الموقع؟</div>
                            <span class="arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="faq-answer">نعم، يمكن للطبيب استقبال الحجوزات من خلال الموقع إذا كانت خدمة الحجز متاحة
                            ومفعّلة لحسابه وفقًا للباقات والخصائص المتوفرة له.</div>
                    </article>

                </div>
            </div>

        </div>
    </section>
    <?php if (isset($component)) { $__componentOriginal7467471fa22351805a182d948e9da6fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7467471fa22351805a182d948e9da6fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.firstbanner','data' => ['nav' => 'ما زلت تحتاج مساعدة؟','title' => 'فريق دليل الأطباء جاهز لاستقبال استفسارك ومساعدتك','link' => 'تواصل معنا','route' => route('contact.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.firstbanner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['nav' => 'ما زلت تحتاج مساعدة؟','title' => 'فريق دليل الأطباء جاهز لاستقبال استفسارك ومساعدتك','link' => 'تواصل معنا','route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('contact.index'))]); ?>

        لم تجد إجابة لسؤالك؟

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7467471fa22351805a182d948e9da6fe)): ?>
<?php $attributes = $__attributesOriginal7467471fa22351805a182d948e9da6fe; ?>
<?php unset($__attributesOriginal7467471fa22351805a182d948e9da6fe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7467471fa22351805a182d948e9da6fe)): ?>
<?php $component = $__componentOriginal7467471fa22351805a182d948e9da6fe; ?>
<?php unset($__componentOriginal7467471fa22351805a182d948e9da6fe); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards      = document.querySelectorAll('.category-card');
            const categories = document.querySelectorAll('.faq-category');

            // ── التنقل بين الأقسام ──────────────────────────────
            cards.forEach(card => {
                card.addEventListener('click', () => {
                    const name = card.dataset.category;
                    cards.forEach(c => c.classList.toggle('active', c === card));
                    categories.forEach(c => c.classList.toggle('show', c.dataset.category === name));
                    // إغلاق أي سؤال مفتوح عند تغيير القسم
                    document.querySelectorAll('.faq-item.active').forEach(i => i.classList.remove('active'));
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('home.layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/home/info/faq.blade.php ENDPATH**/ ?>