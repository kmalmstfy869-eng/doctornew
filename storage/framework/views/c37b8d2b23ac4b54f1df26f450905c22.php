<?php $__env->startSection('title', 'المرضى | دليل الأطباء'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
<?php $__env->stopPush(); ?>
    <?php if (! $__env->hasRenderedOnce('modal-variants-css')): $__env->markAsRenderedOnce('modal-variants-css'); ?>
        <?php $__env->startPush('extra_style'); ?>
            <link rel="stylesheet" href="<?php echo e(asset('css/clinic/modal_variants.css')); ?>">
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
<?php $__env->startSection('content'); ?>

    <?php
        $formKey = old('_form');
        $isCreateForm = $formKey === 'create';
        $createBag = $errors->getBag('createPatient');
        $editingId = str_starts_with((string) $formKey, 'edit-') ? (int) substr($formKey, 5) : null;

        $openModal = $createBag->any()
            ? 'modal-new-patient'
            : ($editingId && $errors->getBag('editPatient')->any() ? "modal-edit-patient-{$editingId}" : null);
    ?>

    <main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">
                <h1 class="truncate text-xl font-bold sm:text-2xl">المرضى</h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    <span id="patients-count"><?php echo e($patients->total()); ?></span>
                    ملف مريض مسجل في عيادتك
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button" class="btn btn-default" data-modal-open="modal-new-patient">
                    <i data-lucide="user-plus" class="size-4"></i>
                    مريض جديد
                </button>
            </div>

        </div>

        <div class="relative mb-4 max-w-md">

            <input id="patients-live-search" type="text" name="search" value="<?php echo e(request('search')); ?>"
                placeholder="ابحث بالاسم أو رقم الملف أو الهاتف" autocomplete="off" data-live-search
                data-live-search-url="<?php echo e(route('clinic.patients')); ?>" data-live-search-target="#patients-results"
                data-live-search-pagination="#patients-pagination" data-live-search-count="#patients-count"
                class="field-input pe-9">

        </div>

        <div id="patients-results">

            <?php if($patients->count()): ?>

                <div id="patients-grid" class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">

                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $initials = mb_substr(trim($patient->name), 0, 2);
                            $isThis = $editingId === $patient->id;
                            $editBag = $isThis ? $errors->getBag('editPatient') : new \Illuminate\Support\MessageBag();
                            $val = fn($key, $default = null) => $isThis ? old($key, $default) : $default;
                        ?>

                        <div class="clinic-surface-card p-4" data-search-text="<?php echo e($patient->name); ?> <?php echo e($patient->phone); ?>">

                            <div class="flex items-start gap-3">

                                <span
                                    class="grid size-11 shrink-0 place-items-center rounded-full bg-primary-soft font-bold text-primary">
                                    <?php echo e($initials ?: '؟'); ?>

                                </span>

                                <div class="min-w-0 flex-1">

                                    <a href="<?php echo e(route('clinic.patients.show', $patient)); ?>"
                                        class="block truncate font-bold text-primary hover:underline">
                                        <?php echo e($patient->name); ?>

                                    </a>

                                    <p class="text-xs text-muted-foreground tabular-nums" dir="ltr">
                                        <?php if($patient->phone): ?>
                                            <?php echo e($patient->phone); ?>

                                        <?php else: ?>
                                            لا يوجد رقم هاتف
                                        <?php endif; ?>
                                    </p>

                                    <div class="mt-2 flex flex-wrap gap-1.5">

                                        <span class="badge badge-muted">
                                            <?php if($patient->birth_date): ?>
                                                <?php echo e($patient->birth_date->age); ?>

                                                سنة
                                            <?php else: ?>
                                                العمر غير محدد
                                            <?php endif; ?>
                                        </span>

                                        <span class="badge badge-info">
                                            <?php if($patient->gender === 'male'): ?>
                                                ذكر
                                            <?php elseif($patient->gender === 'female'): ?>
                                                أنثى
                                            <?php else: ?>
                                                غير محدد
                                            <?php endif; ?>
                                        </span>

                                    </div>

                                </div>

                            </div>

                            <div class="mt-3 flex items-center justify-between border-t border-border pt-3">

                                <p class="text-xs text-muted-foreground">
                                    سُجل
                                    <?php echo e($patient->created_at->locale('ar')->translatedFormat('d M Y')); ?>

                                </p>

                                <div class="flex gap-1">

                                    <a href="<?php echo e(route('clinic.patients.show', $patient)); ?>" class="btn btn-outline btn-sm">
                                        الملف
                                    </a>

                                    <button type="button" class="btn btn-ghost btn-icon-sm"
                                        data-modal-open="modal-edit-patient-<?php echo e($patient->id); ?>" aria-label="تعديل">
                                        <i data-lucide="pencil" class="size-4"></i>
                                    </button>

                                    <?php if (! ((bool) Auth::user()?->doctorAssistant)): ?>
                                        <form method="POST" action="<?php echo e(route('clinic.patient.destroy', $patient)); ?>"
                                            class="inline"
                                            onsubmit="return confirm('هل أنت متأكد من حذف ملف المريض؟ سيتم حذف بياناته المرتبطة بالعيادة أيضًا .');">

                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button type="submit"
                                                class="btn btn-ghost btn-icon-sm text-destructive hover:text-destructive"
                                                aria-label="حذف" title="حذف المريض">
                                                <i data-lucide="trash-2" class="size-4"></i>
                                            </button>

                                        </form>
                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                        
                        <div id="modal-edit-patient-<?php echo e($patient->id); ?>" class="modal-overlay">

                            <div class="modal-panel modal-panel--edit">

                                <div class="modal-head">
                                    <span class="modal-head__icon">
                                        <i data-lucide="pencil" class="size-5"></i>
                                    </span>
                                    <div>
                                        <h2 class="modal-head__title">تعديل بيانات المريض</h2>
                                        <p class="modal-head__sub"><?php echo e($patient->name); ?></p>
                                    </div>
                                </div>

                                <form method="POST" action="<?php echo e(route('clinic.patients.update', $patient)); ?>">

                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="hidden" name="_form" value="edit-<?php echo e($patient->id); ?>">

                                    <div class="grid gap-4 sm:grid-cols-2">

                                        <div class="sm:col-span-2">
                                            <label class="field-label">الاسم الكامل *</label>
                                            <input type="text" name="name"
                                                class="field-input <?php echo e($editBag->has('name') ? 'border-destructive' : ''); ?>"
                                                value="<?php echo e($val('name', $patient->name)); ?>" required>
                                            <?php if($editBag->has('name')): ?>
                                                <p class="mt-1 text-xs text-destructive"><?php echo e($editBag->first('name')); ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <div>
                                            <label class="field-label">الهاتف *</label>
                                            <input type="text" name="phone" dir="ltr"
                                                class="field-input <?php echo e($editBag->has('phone') ? 'border-destructive' : ''); ?>"
                                                value="<?php echo e($val('phone', $patient->phone)); ?>" placeholder="01xxxxxxxxx">
                                            <?php if($editBag->has('phone')): ?>
                                                <p class="mt-1 text-xs text-destructive"><?php echo e($editBag->first('phone')); ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <div>
                                            <label class="field-label">تاريخ الميلاد</label>
                                            <input type="date" name="birth_date"
                                                class="field-input <?php echo e($editBag->has('birth_date') ? 'border-destructive' : ''); ?>"
                                                value="<?php echo e($val('birth_date', $patient->birth_date?->format('Y-m-d'))); ?>">
                                            <?php if($editBag->has('birth_date')): ?>
                                                <p class="mt-1 text-xs text-destructive"><?php echo e($editBag->first('birth_date')); ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <div>
                                            <label class="field-label">الجنس</label>
                                            <select name="gender"
                                                class="field-select <?php echo e($editBag->has('gender') ? 'border-destructive' : ''); ?>">
                                                <option value="">اختر الجنس</option>
                                                <option value="male" <?php if($val('gender', $patient->gender) === 'male'): echo 'selected'; endif; ?>>ذكر</option>
                                                <option value="female" <?php if($val('gender', $patient->gender) === 'female'): echo 'selected'; endif; ?>>أنثى</option>
                                            </select>
                                            <?php if($editBag->has('gender')): ?>
                                                <p class="mt-1 text-xs text-destructive"><?php echo e($editBag->first('gender')); ?></p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label class="field-label">العنوان</label>
                                            <textarea name="address" class="field-textarea <?php echo e($editBag->has('address') ? 'border-destructive' : ''); ?>"
                                                rows="2" placeholder="عنوان المريض"><?php echo e($val('address', $patient->address)); ?></textarea>
                                            <?php if($editBag->has('address')): ?>
                                                <p class="mt-1 text-xs text-destructive"><?php echo e($editBag->first('address')); ?></p>
                                            <?php endif; ?>
                                        </div>

                                    </div>

                                    <div class="modal-foot">
                                        <button type="button" class="btn btn-outline" data-modal-close>إلغاء</button>
                                        <button type="submit" class="btn btn-default btn-submit">حفظ التعديلات</button>
                                    </div>

                                </form>

                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-magnifying-glass','title' => 'لا يوجد مرضى','content' => 'لم يتم العثور على مرضى مطابقين للبحث أو لا يوجد مرضى مسجلين في عيادتك.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-magnifying-glass','title' => 'لا يوجد مرضى','content' => 'لم يتم العثور على مرضى مطابقين للبحث أو لا يوجد مرضى مسجلين في عيادتك.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $attributes = $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f)): ?>
<?php $component = $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f; ?>
<?php unset($__componentOriginal0b5ccf9b11eebc2718e227842e6d306f); ?>
<?php endif; ?>
            <?php endif; ?>

        </div>

        <div id="patients-pagination" class="mt-4">
            <?php echo e($patients->withQueryString()->links('vendor.pagination.custom')); ?>

        </div>

        
        <div id="modal-new-patient" class="modal-overlay">

            <div class="modal-panel modal-panel--create">

                <div class="modal-head">
                    <span class="modal-head__icon">
                        <i data-lucide="user-plus" class="size-5"></i>
                    </span>
                    <div>
                        <h2 class="modal-head__title">مريض جديد</h2>
                        <p class="modal-head__sub">هذا الملف خاص بعيادتك فقط ولا يظهر لأطباء آخرين.</p>
                    </div>
                </div>

                <form method="POST" action="<?php echo e(route('clinic.patients.store')); ?>">

                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="_form" value="create">

                    <div class="grid gap-4 sm:grid-cols-2">

                        <div class="sm:col-span-2">
                            <label class="field-label">الاسم الكامل *</label>
                            <input type="text" name="name"
                                class="field-input <?php echo e($createBag->has('name') ? 'border-destructive' : ''); ?>"
                                value="<?php echo e($isCreateForm ? old('name') : ''); ?>" placeholder="اسم المريض" required>
                            <?php if($createBag->has('name')): ?>
                                <p class="mt-1 text-xs text-destructive"><?php echo e($createBag->first('name')); ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="field-label">الهاتف *</label>
                            <input type="text" name="phone" dir="ltr"
                                class="field-input <?php echo e($createBag->has('phone') ? 'border-destructive' : ''); ?>"
                                value="<?php echo e($isCreateForm ? old('phone') : ''); ?>" placeholder="01xxxxxxxxx">
                            <?php if($createBag->has('phone')): ?>
                                <p class="mt-1 text-xs text-destructive"><?php echo e($createBag->first('phone')); ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="field-label">تاريخ الميلاد</label>
                            <input type="date" name="birth_date"
                                class="field-input <?php echo e($createBag->has('birth_date') ? 'border-destructive' : ''); ?>"
                                value="<?php echo e($isCreateForm ? old('birth_date') : ''); ?>">
                            <?php if($createBag->has('birth_date')): ?>
                                <p class="mt-1 text-xs text-destructive"><?php echo e($createBag->first('birth_date')); ?></p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="field-label">الجنس</label>
                            <select name="gender"
                                class="field-select <?php echo e($createBag->has('gender') ? 'border-destructive' : ''); ?>">
                                <option value="">اختر الجنس</option>
                                <option value="male" <?php if($isCreateForm && old('gender') === 'male'): echo 'selected'; endif; ?>>ذكر</option>
                                <option value="female" <?php if($isCreateForm && old('gender') === 'female'): echo 'selected'; endif; ?>>أنثى</option>
                            </select>
                            <?php if($createBag->has('gender')): ?>
                                <p class="mt-1 text-xs text-destructive"><?php echo e($createBag->first('gender')); ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="field-label">العنوان</label>
                            <textarea name="address" class="field-textarea <?php echo e($createBag->has('address') ? 'border-destructive' : ''); ?>"
                                rows="2" placeholder="عنوان المريض"><?php echo e($isCreateForm ? old('address') : ''); ?></textarea>
                            <?php if($createBag->has('address')): ?>
                                <p class="mt-1 text-xs text-destructive"><?php echo e($createBag->first('address')); ?></p>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="modal-foot">
                        <button type="button" class="btn btn-outline" data-modal-close>إلغاء</button>
                        <button type="submit" class="btn btn-default btn-submit">حفظ</button>
                    </div>

                </form>

            </div>

        </div>

    </main>

    <?php $__env->startPush('extra_java'); ?>
        <script>
            window.PatientsPageConfig = {
                openModal: <?php echo json_encode($openModal, 15, 512) ?>,
            };
        </script>

        <script src="<?php echo e(asset('js/clinic/live_search.js')); ?>"></script>
        <script src="<?php echo e(asset('js/clinic/patients_index.js')); ?>"></script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('doctor.layouts.app_clinc', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/patients/index.blade.php ENDPATH**/ ?>