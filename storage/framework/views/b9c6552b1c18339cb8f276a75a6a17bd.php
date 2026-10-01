<?php $__env->startSection('title', 'مركز المساعدة | لوحة تحكم الطبيب'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/dashboard/help.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="doc-help-container">

        
        <div class="doc-help-header">
            <div class="doc-help-header-badge">
                <i class="fa-solid fa-headset"></i>
                مركز مساعدة الطبيب
            </div>
            <h1>مركز المساعدة والخدمات</h1>
            <p>دليلك الشامل لإدارة حسابك وعيادتك ومواعيدك ومرضاك. اختر القسم المناسب للوصول إلى الإجابة المطلوبة.</p>
        </div>

        
        <h2 class="doc-help-section-title">
            <i class="fa-solid fa-layer-group"></i>
            اختر القسم للوصول السريع
        </h2>

        <div class="doc-help-category-grid">

            <button type="button" class="doc-help-category-card active" data-category="all">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-border-all"></i></div>
                <h4>عرض الكل</h4>
                <p>جميع الأسئلة</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="account">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-user-circle"></i></div>
                <h4>الحساب</h4>
                <p>البيانات والملف الشخصي</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="subscription">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-crown"></i></div>
                <h4>الاشتراك</h4>
                <p>الباقات والمميزات</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="bookings">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <h4>الحجوزات</h4>
                <p>المواعيد وإدارة الحجز</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="patients">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-user-group"></i></div>
                <h4>المرضى</h4>
                <p>الملفات والبيانات الطبية</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="visits">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-file-medical"></i></div>
                <h4>الزيارات</h4>
                <p>الكشف والروشتات والمتابعة</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="files">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-folder-open"></i></div>
                <h4>الملفات الطبية</h4>
                <p>رفع التحاليل والأشعة</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="assistant">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-user-gear"></i></div>
                <h4>مساعد الدكتور</h4>
                <p>الصلاحيات والحسابات</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="payments">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
                <h4>المدفوعات</h4>
                <p>الإيرادات والمبالغ</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="schedule">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-clock"></i></div>
                <h4>الجدول</h4>
                <p>مواعيد العمل والسلوتات</p>
            </button>

            <button type="button" class="doc-help-category-card" data-category="notifications">
                <div class="doc-help-cat-icon"><i class="fa-solid fa-bell"></i></div>
                <h4>الإشعارات</h4>
                <p>متابعة وإعدادات التنبيهات</p>
            </button>

        </div>

        
        <div class="doc-help-questions-wrap">

            
            <div class="doc-help-category-group show" data-category="account">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-user-circle"></i></div>
                    <div class="doc-help-group-info">
                        <h3>الحساب والملف الشخصي</h3>
                        <p>تعديل البيانات وما يظهر للمرضى</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إزاي أعدّل بيانات الحساب اللي بسجل بيها؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                يمكنك تعديل بيانات الحساب من <strong>الإعدادات</strong>، ثم حفظ التغييرات لتحديث بياناتك.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">إزاي أغيّر صورتي أو بيانات العيادة؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                يمكنك تعديل بيانات ملفك الطبي وصور العيادة من قسم <strong>تعديل ملفي الطبي</strong>، حسب
                                المميزات المتاحة في اشتراكك.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">03</span>
                                <span class="doc-help-q-text">هل بيانات حسابي ظاهرة للمرضى؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                البيانات التي تظهر للمرضى هي البيانات المعروضة في <strong>ملفي الطبي</strong>، بينما بيانات
                                الحساب الخاصة تظل مرتبطة بحسابك فقط.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            
            <div class="doc-help-category-group show" data-category="subscription">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-crown"></i></div>
                    <div class="doc-help-group-info">
                        <h3>الاشتراك والمميزات</h3>
                        <p>الباقات والمميزات المتاحة لحسابك</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إزاي أعرف الباقة الحالية والمميزات المتاحة لي؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                يمكنك معرفة الباقة الحالية وتاريخ انتهائها والمميزات المتاحة لحسابك من قسم
                                <strong>الاشتراك</strong>.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">هل أقدر أضيف مساعد للدكتور؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                يمكنك إضافة وإدارة <strong>مساعد الدكتور</strong> إذا كانت ميزة المساعد متوفرة في اشتراكك،
                                وتتوفر هذه الميزة ضمن <strong>نظام العيادة الكامل</strong> عند اشتراكك فيه.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">03</span>
                                <span class="doc-help-q-text">هل أقدر أستقبل حجوزات أونلاين؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                يمكنك استقبال وإدارة الحجوزات الأونلاين إذا كانت ميزة الحجز الإلكتروني متوفرة في اشتراكك.
                                عند توفرها، يمكنك الوصول إلى <strong>إدارة الحجوزات</strong> من النظام واستخدام المميزات
                                المتاحة.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">04</span>
                                <span class="doc-help-q-text">هل كل مميزات العيادة متاحة لكل الباقات؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                لا، تختلف المميزات المتاحة حسب الباقة ونوع النظام. يمكنك مراجعة قسم
                                <strong>الاشتراك</strong> لمعرفة المميزات المتاحة لحسابك.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">05</span>
                                <span class="doc-help-q-text">ماذا يحدث عند انتهاء الاشتراك؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                عند انتهاء الاشتراك، سيتواصل معك فريق الدعم بخصوص التجديد. وفي حالة عدم الرغبة في التجديد،
                                يعود حسابك إلى <strong>النسخة المجانية</strong> وفق المميزات المتاحة لها.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            
            <div class="doc-help-category-group show" data-category="bookings">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="doc-help-group-info">
                        <h3>الحجوزات والمواعيد</h3>
                        <p>متاحة إذا كانت إدارة الحجوزات في اشتراكك</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إزاي أضيف حجز لمريض؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت إدارة الحجوزات متوفرة في اشتراكك، يمكنك إضافة الحجز من <strong>نظام العيادة أو
                                    إدارة الحجوزات</strong>، ثم إدخال بيانات المريض وتحديد نوع الحجز والخدمة والسعر وحفظ
                                الحجز.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">إزاي أتعامل مع المريض لما يحضر العيادة؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كان نظام العيادة متوفرًا في اشتراكك، يمكنك من قائمة الحجوزات تسجيل وصول المريض، وبعدها
                                يظهر ضمن قائمة الانتظار لاتخاذ الإجراء المناسب.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">03</span>
                                <span class="doc-help-q-text">إزاي أبدأ الكشف؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كان نظام العيادة متوفرًا في اشتراكك، يمكنك بعد تسجيل حضور المريض بدء الكشف من إجراءات
                                الحجز، ليتم نقله إلى حالة الكشف الحالية.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">04</span>
                                <span class="doc-help-q-text">إزاي أنهي الكشف؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كان نظام العيادة متوفرًا في اشتراكك، يمكنك بعد الانتهاء من الكشف إنهاء الحجز من إجراءات
                                قائمة الانتظار، ثم ينتقل إلى السجل المناسب.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">05</span>
                                <span class="doc-help-q-text">إيه الفرق بين الحجز الأونلاين وحجز العيادة؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                الحجز الأونلاين يتم من خلال نظام الحجز الإلكتروني إذا كان متوفرًا في اشتراكك، بينما حجز
                                العيادة يتم إدخاله من داخل <strong>نظام العيادة</strong> إذا كانت هذه الميزة متاحة.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">06</span>
                                <span class="doc-help-q-text">هل أقدر أعدّل سعر الحجز أو المبلغ المدفوع؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت إدارة الحجوزات متوفرة في اشتراكك، يمكنك تعديل بيانات الدفع من الإجراءات المتاحة
                                للحجز، مع مراعاة أن المبلغ المدفوع لا يتجاوز قيمة الحجز.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            
            <div class="doc-help-category-group show" data-category="patients">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-user-group"></i></div>
                    <div class="doc-help-group-info">
                        <h3>المرضى</h3>
                        <p>متاحة إذا كانت إدارة المرضى في اشتراكك</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إزاي أضيف مريض جديد؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت ميزة إدارة المرضى متوفرة في اشتراكك، يمكنك إضافة المريض من <strong>نظام
                                    العيادة</strong> وإدخال بياناته الأساسية، ثم استخدام ملفه للوصول إلى البيانات الطبية
                                المرتبطة به.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">هل لازم كل مريض يكون مسجل؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                لا، يمكن التعامل مع بعض الحجوزات أو الزيارات لشخص غير مسجل كمريض، حسب الإجراء المتاح داخل
                                النظام.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">03</span>
                                <span class="doc-help-q-text">إزاي أوصل لملف المريض؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت إدارة المرضى متوفرة في اشتراكك، يمكنك من قسم المرضى البحث عن اسم المريض أو رقم
                                الهاتف، ثم فتح ملفه للوصول إلى البيانات والزيارات والملفات والروشتات والحجوزات المتاحة.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">04</span>
                                <span class="doc-help-q-text">هل أقدر أبحث عن مريض برقم الهاتف؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                نعم، إذا كانت إدارة المرضى متوفرة في اشتراكك، يمكنك استخدام رقم الهاتف للعثور على المريض
                                المسجل والوصول إلى ملفه.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            
            <div class="doc-help-category-group show" data-category="visits">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-file-medical"></i></div>
                    <div class="doc-help-group-info">
                        <h3>الزيارات والملف الطبي</h3>
                        <p>متاحة إذا كان نظام العيادة في اشتراكك</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إزاي أسجّل زيارة للمريض؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كان نظام العيادة متوفرًا في اشتراكك، افتح ملف المريض وانتقل إلى قسم الزيارات لإضافة
                                بيانات الزيارة وتسجيل تفاصيل الكشف.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">إزاي أضيف موعد متابعة؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت الزيارات متوفرة ضمن نظام العيادة في اشتراكك، يمكنك أثناء تسجيل الزيارة تحديد موعد
                                المتابعة إذا كان هناك موعد لاحق للمريض.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">03</span>
                                <span class="doc-help-q-text">إزاي أضيف روشتة؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت ميزة الروشتات متوفرة في نظام العيادة الخاص باشتراكك، يمكنك من ملف المريض إنشاء
                                روشتة وإضافة الأدوية والتعليمات المطلوبة ثم حفظها.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">04</span>
                                <span class="doc-help-q-text">هل أقدر أشوف الزيارات السابقة؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كان نظام العيادة متوفرًا في اشتراكك، يمكنك مراجعة سجل الزيارات السابقة من داخل ملف
                                المريض.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            
            <div class="doc-help-category-group show" data-category="files">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-folder-open"></i></div>
                    <div class="doc-help-group-info">
                        <h3>الملفات الطبية</h3>
                        <p>متاحة إذا كانت ميزة الملفات في اشتراكك</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إيه الملفات اللي أقدر أرفعها؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت ميزة الملفات الطبية متوفرة في اشتراكك، يمكنك رفع الملفات الطبية المسموح بها داخل
                                النظام مثل <strong>PDF والصور</strong>، وفق الصيغ والحدود المحددة للرفع.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">إزاي أضيف تحليل أو أشعة لملف المريض؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت الملفات الطبية متوفرة في اشتراكك، افتح ملف المريض وانتقل إلى قسم الملفات الطبية، ثم
                                ارفع الملف وأضفه إلى سجل المريض.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">03</span>
                                <span class="doc-help-q-text">هل الملفات الطبية مرتبطة بالمريض؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                نعم، إذا كانت ميزة الملفات الطبية متوفرة في اشتراكك، يتم حفظ الملفات التي تضيفها ضمن سجل
                                المريض.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            
            <div class="doc-help-category-group show" data-category="assistant">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-user-gear"></i></div>
                    <div class="doc-help-group-info">
                        <h3>مساعد الدكتور</h3>
                        <p>إدارة حسابات المساعدين والصلاحيات</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إيه وظيفة مساعد الدكتور؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                مساعد الدكتور هو حساب مخصص للمساعدة في تنفيذ المهام المسموح بها داخل النظام، مثل التعامل مع
                                الحجوزات وبعض إجراءات المرضى، وفق الصلاحيات المحددة له.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">هل المساعد يقدر يدخل على حساب الدكتور؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                لا، المساعد يستخدم حسابه الخاص ولا يحتاج إلى استخدام بيانات دخول الدكتور.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">03</span>
                                <span class="doc-help-q-text">هل أقدر أوقف حساب المساعد؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                نعم، يمكنك إيقاف حساب المساعد من إدارة المساعدين، وعند إيقافه لن يتمكن من استخدام النظام
                                المخصص له.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">04</span>
                                <span class="doc-help-q-text">هل أقدر أضيف أكثر من مساعد؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                يمكنك إضافة وإدارة المساعدين إذا كانت ميزة المساعدين متوفرة في اشتراكك، مع الالتزام بالحد
                                المسموح به في النظام.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            
            <div class="doc-help-category-group show" data-category="payments">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-money-bill-wave"></i></div>
                    <div class="doc-help-group-info">
                        <h3>المدفوعات والإيرادات</h3>
                        <p>متاحة إذا كانت التقارير المالية في اشتراكك</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إزاي أعرف المبلغ المدفوع والمتبقي؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت إدارة الحجوزات والمدفوعات متوفرة في اشتراكك، يمكنك من بيانات الحجز والمدفوعات معرفة
                                قيمة الحجز والمبلغ المدفوع والبيانات المالية المرتبطة به.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">إزاي أراجع إيرادات العيادة؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كان نظام العيادة والتقارير المالية متوفرًا في اشتراكك، يمكنك من قسم <strong>الإيرادات
                                    والتقارير</strong> مراجعة البيانات المالية للفترة التي تريدها وفق الحجوزات المسجلة في
                                النظام.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">03</span>
                                <span class="doc-help-q-text">هل الحجوزات الملغاة تدخل في الإيرادات؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                يتم احتساب البيانات المالية وفق حالة الحجز والقواعد المستخدمة في التقارير، ولا يتم التعامل
                                مع الحجز الملغي كحجز مكتمل.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            
            <div class="doc-help-category-group show" data-category="schedule">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-clock"></i></div>
                    <div class="doc-help-group-info">
                        <h3>الجدول والمواعيد</h3>
                        <p>متاحة إذا كانت إدارة الجدول في اشتراكك</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إزاي أحدّد مواعيد العمل؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كان نظام العيادة متوفرًا في اشتراكك، يمكنك من إعدادات جدول العيادة تحديد أيام العمل
                                وساعات البداية والنهاية ومدة الموعد.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">إزاي أحدّد مدة كل حجز؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                إذا كانت إدارة جدول العيادة متوفرة في اشتراكك، يمكنك تحديد مدة الـSlot من إعدادات جدول
                                العيادة لتنظيم المواعيد المتاحة.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">03</span>
                                <span class="doc-help-q-text">هل أقدر أوقف يوم معين من جدول العيادة؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                نعم، إذا كانت إدارة جدول العيادة متوفرة في اشتراكك، يمكنك تعطيل اليوم من إعدادات الجدول
                                بدلًا من حذفه.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

            
            <div class="doc-help-category-group show" data-category="notifications">
                <div class="doc-help-group-header">
                    <div class="doc-help-group-badge"><i class="fa-solid fa-bell"></i></div>
                    <div class="doc-help-group-info">
                        <h3>الإشعارات</h3>
                        <p>متابعة وإعدادات تنبيهات حسابك</p>
                    </div>
                </div>
                <div class="doc-help-faq-list">

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">01</span>
                                <span class="doc-help-q-text">إزاي أعرف إن عندي إشعار جديد؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                تظهر الإشعارات الجديدة داخل لوحة التحكم من خلال قسم <strong>الإشعارات</strong>، ويمكنك فتح
                                الإشعار للوصول إلى التفاصيل المرتبطة به.
                            </div>
                        </div>
                    </article>

                    <article class="doc-help-faq-item">
                        <button type="button" class="doc-help-faq-question">
                            <div class="doc-help-q-right">
                                <span class="doc-help-q-num">02</span>
                                <span class="doc-help-q-text">هل أقدر أتحكم في إشعارات الحساب؟</span>
                            </div>
                            <span class="doc-help-q-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </button>
                        <div class="doc-help-faq-answer">
                            <div class="doc-help-faq-answer-inner">
                                يمكنك التحكم في إعدادات الإشعارات المتاحة لحسابك من <strong>إعدادات الحساب</strong>.
                            </div>
                        </div>
                    </article>

                </div>
            </div>

        </div>

        
        <div class="doc-help-support-card">
            <div class="doc-help-support-icon">
                <i class="fa-brands fa-whatsapp"></i>
            </div>
            <h3>لم تجد إجابة لسؤالك؟</h3>
            <p>فريق الدعم الفني لدليل الأطباء جاهز لمساعدتك في أي وقت خلال ساعات العمل للرد على كافة استفساراتك.</p>
            <a href="https://wa.me/201093796014" target="_blank" rel="noopener noreferrer"
                class="doc-help-whatsapp-btn">
                <i class="fa-brands fa-whatsapp"></i>
                تواصل معنا عبر واتساب
            </a>
        </div>

    </div>

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* ─ Category switching ─ */
            var catBtns = document.querySelectorAll('.doc-help-category-card');
            var catGroups = document.querySelectorAll('.doc-help-category-group');

            catBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var target = btn.getAttribute('data-category');

                    /* update active tab */
                    catBtns.forEach(function(b) {
                        b.classList.toggle('active', b === btn);
                    });

                    /* show / hide groups */
                    catGroups.forEach(function(g) {
                        var show = (target === 'all' || g.getAttribute('data-category') ===
                            target);
                        g.classList.toggle('show', show);
                    });

                    /* close any open accordion when switching category */
                    document.querySelectorAll('.doc-help-faq-item.active')
                        .forEach(function(i) {
                            i.classList.remove('active');
                        });
                });
            });

            /* ─ Accordion ─ */
            var faqItems = document.querySelectorAll('.doc-help-faq-item');

            faqItems.forEach(function(item) {
                var btn = item.querySelector('.doc-help-faq-question');
                if (!btn) return;

                btn.addEventListener('click', function() {
                    var isOpen = item.classList.contains('active');

                    /* close all */
                    faqItems.forEach(function(i) {
                        i.classList.remove('active');
                    });

                    /* open current if it was closed */
                    if (!isOpen) {
                        item.classList.add('active');
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/dashboard/help/index.blade.php ENDPATH**/ ?>