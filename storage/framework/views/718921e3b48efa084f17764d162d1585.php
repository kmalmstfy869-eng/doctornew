<?php use \App\Support\Money; ?>


<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/clinic/print.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/clinic/clinic-payments.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/clinic/patient-files.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'بيانات المريض | دليل الأطباء'); ?>

<?php $__env->startSection('content'); ?>



    <?php
        $fmtMoney = [Money::class, 'fmt'];
    ?>


    <?php if (isset($component)) { $__componentOriginal74b46d77aa27a401d95abc07d00c1ff9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal74b46d77aa27a401d95abc07d00c1ff9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.print-letterhead','data' => ['doctor' => $doctor]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.print-letterhead'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['doctor' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($doctor)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal74b46d77aa27a401d95abc07d00c1ff9)): ?>
<?php $attributes = $__attributesOriginal74b46d77aa27a401d95abc07d00c1ff9; ?>
<?php unset($__attributesOriginal74b46d77aa27a401d95abc07d00c1ff9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal74b46d77aa27a401d95abc07d00c1ff9)): ?>
<?php $component = $__componentOriginal74b46d77aa27a401d95abc07d00c1ff9; ?>
<?php unset($__componentOriginal74b46d77aa27a401d95abc07d00c1ff9); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal88c553753d1dacfad57e787957b8e054 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88c553753d1dacfad57e787957b8e054 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.visit-form','data' => ['patient' => $patient,'showTrigger' => false,'action' => route('clinic.visits.store'),'method' => 'POST']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.visit-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['patient' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($patient),'show-trigger' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('clinic.visits.store')),'method' => 'POST']); ?>

        <main id="patient-print-area" class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

            

            <div class="clinic-surface-card mb-4 overflow-hidden">

                <div class="p-4 sm:p-6">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                        
                        <div class="flex min-w-0 items-start gap-4">

                            <div
                                class="grid size-16 shrink-0 place-items-center rounded-2xl bg-primary-soft text-xl font-bold text-primary sm:size-[72px] sm:text-2xl">

                                <?php echo e(mb_substr($patient->name, 0, 2)); ?>


                            </div>

                            <div class="min-w-0">

                                <h1 class="text-xl font-bold text-foreground sm:text-2xl">
                                    <?php echo e($patient->name); ?>

                                </h1>

                                <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-muted-foreground">

                                    <span class="inline-flex items-center gap-1.5">
                                        <i data-lucide="phone" class="size-4"></i>
                                        <?php echo e($patient->phone ?: 'لا يوجد رقم هاتف'); ?>

                                    </span>

                                    <span class="hidden sm:inline">•</span>

                                    <span class="inline-flex items-center gap-1.5">

                                        <i data-lucide="cake" class="size-4"></i>

                                        <?php if($patient->birth_date): ?>
                                            <?php echo e($patient->birth_date->age); ?> سنة
                                        <?php else: ?>
                                            العمر غير محدد
                                        <?php endif; ?>

                                    </span>

                                    <span class="hidden sm:inline">•</span>

                                    <span class="inline-flex items-center gap-1.5">

                                        <i data-lucide="user-round" class="size-4"></i>

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


                        
                        <div class="bq-no-print flex flex-wrap gap-2">

                            
                            <?php if (! ($isAssistant)): ?>
                                <button type="button" class="btn btn-default btn-sm" @click="openCreate()">

                                    <i data-lucide="stethoscope" class="size-4"></i>

                                    زيارة جديدة

                                </button>


                                <button type="button" class="btn btn-default btn-sm" @click="$dispatch('bq-rx-create')">

                                    <i data-lucide="file-plus" class="size-4"></i>

                                    روشتة جديدة

                                </button>


                                <?php if (isset($component)) { $__componentOriginaldcdbb4f6fad68979a3502fa04b546a9c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldcdbb4f6fad68979a3502fa04b546a9c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.invoice-form','data' => ['patient' => $patient]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.invoice-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['patient' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($patient)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldcdbb4f6fad68979a3502fa04b546a9c)): ?>
<?php $attributes = $__attributesOriginaldcdbb4f6fad68979a3502fa04b546a9c; ?>
<?php unset($__attributesOriginaldcdbb4f6fad68979a3502fa04b546a9c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldcdbb4f6fad68979a3502fa04b546a9c)): ?>
<?php $component = $__componentOriginaldcdbb4f6fad68979a3502fa04b546a9c; ?>
<?php unset($__componentOriginaldcdbb4f6fad68979a3502fa04b546a9c); ?>
<?php endif; ?>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>


                
                <div class="grid border-t border-border/60 <?php echo e($isAssistant ? 'sm:grid-cols-2' : 'sm:grid-cols-3'); ?>">

                    
                    <div class="flex items-center gap-3 p-4">

                        <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">
                            <i data-lucide="calendar-plus" class="size-5"></i>
                        </div>

                        <div>

                            <p class="text-xs text-muted-foreground">
                                تاريخ التسجيل
                            </p>

                            <p class="mt-0.5 text-sm font-semibold">
                                <?php echo e($patient->created_at->locale('ar')->translatedFormat('d M Y')); ?>

                            </p>

                        </div>

                    </div>

                    <?php if (! ($isAssistant)): ?>
                        
                        <div
                            class="flex items-center gap-3 border-t border-border/60 p-4 sm:border-t-0 <?php echo e($isAssistant ? '' : 'sm:border-x'); ?>">

                            <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">
                                <i data-lucide="stethoscope" class="size-5"></i>
                            </div>

                            <div>

                                <p class="text-xs text-muted-foreground">
                                    عدد الزيارات
                                </p>

                                <p class="mt-0.5 text-sm font-semibold">
                                    <?php echo e($visits->total()); ?> زيارة
                                </p>

                            </div>

                        </div>
                    <?php endif; ?>

                    
                    <?php if (! ($isAssistant)): ?>
                        <div class="flex items-center gap-3 border-t border-border/60 p-4 sm:border-t-0">

                            <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">
                                <i data-lucide="wallet" class="size-5"></i>
                            </div>

                            <div>

                                <p class="text-xs text-muted-foreground">
                                    إجمالي المدفوع
                                </p>

                                <p class="mt-0.5 text-sm font-semibold tabular-nums">
                                    <?php echo e(number_format($totalPaid, 2)); ?> ج.م
                                </p>

                            </div>

                        </div>
                    <?php endif; ?>

                </div>

            </div>


            

            <div data-patient-tabs class="w-full">

                <div class="bq-no-print tabs-list w-full overflow-x-auto" style="scrollbar-width:none;">

                    <button type="button" class="tab-trigger active shrink-0" data-patient-tab="overview">

                        <i data-lucide="layout-dashboard" class="size-4"></i>

                        ملخص

                    </button>


                    
                    <?php if (! ($isAssistant)): ?>
                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="visits">

                            <i data-lucide="stethoscope" class="size-4"></i>

                            الزيارات

                            <span class="tab-count">
                                <?php echo e($visits->total()); ?>

                            </span>

                        </button>


                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="documents">

                            <i data-lucide="folder-open" class="size-4"></i>

                            الملفات

                            <span class="tab-count">
                                <?php echo e($patientFiles->total()); ?>

                            </span>

                        </button>


                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="prescriptions">

                            <i data-lucide="file-text" class="size-4"></i>

                            الروشتات

                            <span class="tab-count">
                                <?php echo e($prescriptions->total()); ?>

                            </span>

                        </button>
                    <?php endif; ?>


                    <button type="button" class="tab-trigger shrink-0" data-patient-tab="bookings">

                        <i data-lucide="calendar-days" class="size-4"></i>

                        الحجوزات

                        <span class="tab-count">
                            <?php echo e($bookings->total()); ?>

                        </span>

                    </button>


                    <?php if (! ($isAssistant)): ?>
                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="payments">

                            <i data-lucide="wallet" class="size-4"></i>

                            المدفوعات

                            <span class="tab-count">
                                <?php echo e($payments->total()); ?>

                            </span>

                        </button>


                        <button type="button" class="tab-trigger shrink-0" data-patient-tab="notes">

                            <i data-lucide="sticky-note" class="size-4"></i>

                            ملاحظات

                            <span class="tab-count">
                                <?php echo e($notes->total()); ?>

                            </span>

                        </button>
                    <?php endif; ?>

                </div>


                

                <div class="mt-4 patient-tab-panel active" data-patient-panel="overview">

                    <h2 class="bq-print-heading">
                        ملخص
                    </h2>

                    <div class="grid gap-4 <?php echo e($isAssistant ? 'lg:grid-cols-1' : 'lg:grid-cols-3'); ?>">

                        
                        <div class="section-card">

                            <div class="section-card-header">

                                <div class="flex items-center gap-2">

                                    <div class="grid size-9 place-items-center rounded-lg bg-primary-soft text-primary">
                                        <i data-lucide="user-round" class="size-4"></i>
                                    </div>

                                    <h2 class="text-sm font-bold sm:text-base">
                                        البيانات الأساسية
                                    </h2>

                                </div>

                            </div>


                            <div class="section-card-body">

                                <dl class="space-y-3 text-sm">

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">الاسم</dt>
                                        <dd class="text-end font-medium">
                                            <?php echo e($patient->name); ?>

                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">الهاتف</dt>
                                        <dd class="text-end font-medium tabular-nums">
                                            <?php echo e($patient->phone ?: 'لا يوجد رقم هاتف'); ?>

                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">تاريخ الميلاد</dt>
                                        <dd class="text-end font-medium">
                                            <?php echo e($patient->birth_date ? $patient->birth_date->format('d/m/Y') : 'غير محدد'); ?>

                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">النوع</dt>
                                        <dd class="text-end font-medium">
                                            <?php if($patient->gender === 'male'): ?>
                                                ذكر
                                            <?php elseif($patient->gender === 'female'): ?>
                                                أنثى
                                            <?php else: ?>
                                                غير محدد
                                            <?php endif; ?>
                                        </dd>
                                    </div>

                                    <div class="flex items-start justify-between gap-4">
                                        <dt class="text-muted-foreground">العنوان</dt>
                                        <dd class="max-w-[60%] text-end font-medium">
                                            <?php echo e($patient->address ?: 'لم يضع عنوانًا'); ?>

                                        </dd>
                                    </div>

                                </dl>

                            </div>

                        </div>


                        
                        <?php if (! ($isAssistant)): ?>

                            
                            <div class="section-card">

                                <div class="section-card-header">

                                    <div class="flex items-center gap-2">

                                        <div class="grid size-9 place-items-center rounded-lg bg-primary-soft text-primary">
                                            <i data-lucide="activity" class="size-4"></i>
                                        </div>

                                        <h2 class="text-sm font-bold sm:text-base">
                                            آخر زيارة
                                        </h2>

                                    </div>

                                </div>


                                <div class="section-card-body">

                                    <?php if($visits->isNotEmpty()): ?>
                                        <?php
                                            $lastVisit = $visits->first();
                                        ?>

                                        <div class="space-y-4">

                                            <div>

                                                <p class="text-base font-bold">
                                                    <?php echo e($lastVisit->diagnosis ?: 'بدون تشخيص'); ?>

                                                </p>

                                                <p class="mt-1 text-xs text-muted-foreground">
                                                    <?php echo e(\Carbon\Carbon::parse($lastVisit->visit_date)->locale('ar')->translatedFormat('l، d M Y')); ?>

                                                </p>

                                            </div>

                                            <?php if($lastVisit->complaint): ?>
                                                <div class="rounded-xl bg-muted/40 p-3">

                                                    <p class="text-xs text-muted-foreground">
                                                        الشكوى
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium">
                                                        <?php echo e($lastVisit->complaint); ?>

                                                    </p>

                                                </div>
                                            <?php endif; ?>

                                            <?php if($lastVisit->notes): ?>
                                                <div class="rounded-xl bg-muted/40 p-3">

                                                    <p class="text-xs text-muted-foreground">
                                                        ملاحظات
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium">
                                                        <?php echo e($lastVisit->notes); ?>

                                                    </p>

                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    <?php else: ?>
                                        <div class="clinic-surface-card p-6">

                                            <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد زيارات','content' => 'لم يتم تسجيل أي زيارات لهذا المريض حتى الآن.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد زيارات','content' => 'لم يتم تسجيل أي زيارات لهذا المريض حتى الآن.']); ?>
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

                                        </div>
                                    <?php endif; ?>

                                </div>

                            </div>


                            
                            <div class="section-card">

                                <div class="section-card-header">

                                    <div class="flex items-center gap-2">

                                        <div class="grid size-9 place-items-center rounded-lg bg-primary-soft text-primary">
                                            <i data-lucide="wallet" class="size-4"></i>
                                        </div>

                                        <h2 class="text-sm font-bold sm:text-base">
                                            الملخص المالي
                                        </h2>

                                    </div>

                                </div>


                                <div class="section-card-body">

                                    <div class="space-y-4">

                                        <div class="rounded-2xl bg-primary-soft p-4">

                                            <p class="text-xs text-muted-foreground">
                                                إجمالي المدفوع
                                            </p>

                                            <p class="mt-1 text-2xl font-bold text-primary tabular-nums">
                                                <?php echo e(number_format($totalPaid, 2)); ?>

                                                ج.م
                                            </p>

                                        </div>


                                        <dl class="space-y-3 text-sm">

                                            <div class="flex justify-between gap-3">
                                                <dt class="text-muted-foreground">عدد الحجوزات</dt>
                                                <dd class="font-semibold">
                                                    <?php echo e($bookings->total()); ?>

                                                </dd>
                                            </div>

                                            <div class="flex justify-between gap-3">
                                                <dt class="text-muted-foreground">عدد الزيارات</dt>
                                                <dd class="font-semibold">
                                                    <?php echo e($visits->total()); ?>

                                                </dd>
                                            </div>

                                            <div class="flex justify-between gap-3">
                                                <dt class="text-muted-foreground">عدد الروشتات</dt>
                                                <dd class="font-semibold">
                                                    <?php echo e($prescriptions->total()); ?>

                                                </dd>
                                            </div>

                                            <div class="flex justify-between gap-3">
                                                <dt class="text-muted-foreground">عدد الملفات</dt>
                                                <dd class="font-semibold">
                                                    <?php echo e($patientFiles->total()); ?>

                                                </dd>
                                            </div>

                                        </dl>

                                    </div>

                                </div>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>


                

                <?php if (! ($isAssistant)): ?>

                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="visits">

                        <h2 class="bq-print-heading">
                            الزيارات
                        </h2>

                        <?php if($visits->isNotEmpty()): ?>
                            <?php

                                $fmtInline = fn($value) => is_array($value)
                                    ? collect($value)->filter()->join('، ')
                                    : $value;

                                $fmtLines = fn($value) => is_array($value)
                                    ? collect($value)->filter()->join("\n")
                                    : (string) ($value ?? '');

                            ?>


                            <div class="space-y-3">

                                <?php $__currentLoopData = $visits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php

                                        $visitDate = \Carbon\Carbon::parse($visit->visit_date);

                                        $visitDateInput = $visitDate->format('Y-m-d');

                                        $visitDateLabel = $visitDate->locale('ar')->translatedFormat('l، d M Y');

                                        $nextVisitInput = '';

                                        $nextVisitLabel = null;

                                        if ($visit->next_visit_date) {
                                            $nextVisit = \Carbon\Carbon::parse($visit->next_visit_date);

                                            $nextVisitInput = $nextVisit->format('Y-m-d');

                                            $nextVisitLabel = $nextVisit->locale('ar')->translatedFormat('l، d M Y');
                                        }

                                        $requiredTests = $fmtInline($visit->required_tests);

                                        $requiredRadiology = $fmtInline($visit->required_radiology);

                                        $visitPayload = [
                                            'id' => $visit->id,

                                            'patient_id' => $visit->patient_id,

                                            'patient_name' => $patient->name,

                                            'patient_phone' => $patient->phone,

                                            'visit_date' => $visitDateInput,

                                            'complaint' => (string) ($visit->complaint ?? ''),

                                            'symptoms' => (string) ($visit->symptoms ?? ''),

                                            'diagnosis' => (string) ($visit->diagnosis ?? ''),

                                            'required_tests' => $fmtLines($visit->required_tests),

                                            'required_radiology' => $fmtLines($visit->required_radiology),

                                            'notes' => (string) ($visit->notes ?? ''),

                                            'next_visit_date' => $nextVisitInput,
                                        ];

                                        $printFields = [
                                            ['الشكوى الرئيسية', $visit->complaint, false, true],

                                            ['الأعراض', $visit->symptoms, false, true],

                                            ['التشخيص', $visit->diagnosis, true, true],

                                            ['التحاليل المطلوبة', $requiredTests, false, false],

                                            ['الأشعة', $requiredRadiology, false, false],

                                            ['ملاحظات الزيارة', $visit->notes, true, false],

                                            ['موعد المتابعة', $nextVisitLabel, false, false],
                                        ];

                                    ?>


                                    <article class="clinic-surface-card bq-visit-card"
                                        data-print-target="visit-<?php echo e($visit->id); ?>">

                                        <div class="bq-screen-only">

                                            <div
                                                class="flex flex-col gap-4 border-b border-border/60 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">

                                                <div class="flex min-w-0 items-center gap-3">

                                                    <div
                                                        class="bq-visit-icon grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">

                                                        <i data-lucide="stethoscope" class="size-5"></i>

                                                    </div>

                                                    <div class="min-w-0">

                                                        <h3 class="bq-visit-title font-bold">
                                                            <?php echo e($visit->diagnosis ?: 'بدون تشخيص'); ?>

                                                        </h3>

                                                        <div class="mt-1 flex flex-wrap items-center gap-2">

                                                            <span class="badge badge-muted">
                                                                <?php echo e($visitDateLabel); ?>

                                                            </span>

                                                        </div>

                                                    </div>

                                                </div>


                                                <div class="bq-no-print flex shrink-0 flex-wrap items-center gap-2">

                                                    <button type="button" class="btn btn-default btn-sm"
                                                        @click="openEdit(<?php echo \Illuminate\Support\Js::from($visitPayload)->toHtml() ?>)">

                                                        <i data-lucide="pencil" class="size-4"></i>

                                                        تعديل الزيارة

                                                    </button>


                                                    <button type="button" class="btn btn-outline btn-sm"
                                                        data-print-trigger="visit-<?php echo e($visit->id); ?>"
                                                        data-print-mode="visit">

                                                        <i data-lucide="printer" class="size-4"></i>

                                                        طباعة الزيارة

                                                    </button>


                                                    <form method="POST" action="<?php echo e(route('clinic.visit.destroy', $visit)); ?>"
                                                        onsubmit="return confirm('حذف هذه الزياره نهائيًا؟')">

                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>

                                                        <button type="submit" class="btn btn-outline btn-sm">

                                                            <i data-lucide="trash-2" class="size-4"></i>

                                                            حذف

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>


                                            
                                            <div class="grid gap-3 p-4 sm:grid-cols-2 sm:p-5">

                                                <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                    <p class="text-xs text-muted-foreground">
                                                        الشكوى
                                                    </p>

                                                    <p class="bq-visit-text mt-1 text-sm font-medium">
                                                        <?php echo e($visit->complaint ?: '—'); ?>

                                                    </p>

                                                </div>


                                                <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                    <p class="text-xs text-muted-foreground">
                                                        الأعراض
                                                    </p>

                                                    <p class="bq-visit-text mt-1 text-sm font-medium">
                                                        <?php echo e($visit->symptoms ?: '—'); ?>

                                                    </p>

                                                </div>


                                                <?php if($requiredTests): ?>
                                                    <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                        <p class="text-xs text-muted-foreground">
                                                            التحاليل المطلوبة
                                                        </p>

                                                        <p class="bq-visit-text mt-1 text-sm font-medium">
                                                            <?php echo e($requiredTests); ?>

                                                        </p>

                                                    </div>
                                                <?php endif; ?>


                                                <?php if($requiredRadiology): ?>
                                                    <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                        <p class="text-xs text-muted-foreground">
                                                            الأشعة
                                                        </p>

                                                        <p class="bq-visit-text mt-1 text-sm font-medium">
                                                            <?php echo e($requiredRadiology); ?>

                                                        </p>

                                                    </div>
                                                <?php endif; ?>


                                                <?php if($visit->notes): ?>
                                                    <div class="bq-visit-field rounded-xl bg-muted/40 p-3 sm:col-span-2">

                                                        <p class="text-xs text-muted-foreground">
                                                            ملاحظات الزيارة
                                                        </p>

                                                        <p class="bq-visit-text mt-1 text-sm font-medium">
                                                            <?php echo e($visit->notes); ?>

                                                        </p>

                                                    </div>
                                                <?php endif; ?>


                                                <?php if($nextVisitLabel): ?>
                                                    <div class="bq-visit-field rounded-xl bg-muted/40 p-3">

                                                        <p class="text-xs text-muted-foreground">
                                                            موعد المتابعة
                                                        </p>

                                                        <p class="mt-1 text-sm font-medium">
                                                            <?php echo e($nextVisitLabel); ?>

                                                        </p>

                                                    </div>
                                                <?php endif; ?>

                                            </div>

                                        </div>


                                        
                                        <div class="bq-print-only">

                                            <h2 class="bq-sheet-title">
                                                <span>تقرير زيارة طبية</span>
                                            </h2>


                                            <div class="bq-sheet-meta">

                                                <span class="bq-sheet-meta-wide">
                                                    <b>المريض:</b>
                                                    <?php echo e($patient->name); ?>

                                                </span>

                                                <?php if($patientAge): ?>
                                                    <span>
                                                        <b>السن:</b>
                                                        <?php echo e($patientAge); ?> سنة
                                                    </span>
                                                <?php endif; ?>

                                                <?php if($patient->phone): ?>
                                                    <span>
                                                        <b>الهاتف:</b>
                                                        <?php echo e($patient->phone); ?>

                                                    </span>
                                                <?php endif; ?>

                                                <span>
                                                    <b>تاريخ الزيارة:</b>
                                                    <?php echo e($visitDate->format('Y/m/d')); ?>

                                                </span>

                                            </div>


                                            <div class="bq-sheet-fields">

                                                <?php $__currentLoopData = $printFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $full, $always]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(filled($value) || $always): ?>
                                                        <div class="bq-sheet-field <?php echo e($full ? 'bq-sheet-field-full' : ''); ?>">

                                                            <p class="bq-sheet-field-label">
                                                                <?php echo e($label); ?>

                                                            </p>

                                                            <p class="bq-sheet-field-text">
                                                                <?php echo e(filled($value) ? $value : '—'); ?>

                                                            </p>

                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>

                                        </div>

                                    </article>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                <div class="bq-no-print">

                                    <?php echo e($visits->appends(['tab' => 'visits'])->links('vendor.pagination.custom')); ?>


                                </div>

                            </div>
                        <?php else: ?>
                            <div class="clinic-surface-card p-6">

                                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد زيارات','content' => 'لم يتم تسجيل أي زيارات لهذا المريض حتى الآن.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-stethoscope','title' => 'لا توجد زيارات','content' => 'لم يتم تسجيل أي زيارات لهذا المريض حتى الآن.']); ?>
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

                            </div>
                        <?php endif; ?>

                    </div>

                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="documents">

                        <h2 class="bq-print-heading">
                            الملفات
                        </h2>
                        
                        <div class="bq-no-print">
                            <?php if (isset($component)) { $__componentOriginalcbacafbc245a17c0a27a4b6359a97253 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbacafbc245a17c0a27a4b6359a97253 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.storage-upsell','data' => ['stats' => $fileStats]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.storage-upsell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($fileStats)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcbacafbc245a17c0a27a4b6359a97253)): ?>
<?php $attributes = $__attributesOriginalcbacafbc245a17c0a27a4b6359a97253; ?>
<?php unset($__attributesOriginalcbacafbc245a17c0a27a4b6359a97253); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcbacafbc245a17c0a27a4b6359a97253)): ?>
<?php $component = $__componentOriginalcbacafbc245a17c0a27a4b6359a97253; ?>
<?php unset($__componentOriginalcbacafbc245a17c0a27a4b6359a97253); ?>
<?php endif; ?>
                        </div>
                        <div class="bq-no-print mb-4">
                            <?php if (isset($component)) { $__componentOriginalca7ccef8be7e12d4f030ee719d819fc8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca7ccef8be7e12d4f030ee719d819fc8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.storage-card','data' => ['stats' => $fileStats,'compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.storage-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($fileStats),'compact' => true]); ?>
                                <button type="button" class="btn btn-default btn-sm pf-upload-btn"
                                    @click="$dispatch('pf-upload-open')">
                                    <i data-lucide="upload" class="size-4"></i>
                                    <span>رفع ملف جديد</span>
                                </button>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalca7ccef8be7e12d4f030ee719d819fc8)): ?>
<?php $attributes = $__attributesOriginalca7ccef8be7e12d4f030ee719d819fc8; ?>
<?php unset($__attributesOriginalca7ccef8be7e12d4f030ee719d819fc8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalca7ccef8be7e12d4f030ee719d819fc8)): ?>
<?php $component = $__componentOriginalca7ccef8be7e12d4f030ee719d819fc8; ?>
<?php unset($__componentOriginalca7ccef8be7e12d4f030ee719d819fc8); ?>
<?php endif; ?>
                        </div>

                        <?php echo $__env->make('doctor.clinic.files._list', [
                            'files' => $patientFiles,
                            'showPatient' => false,
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                        <div class="bq-no-print mt-4">
                            <?php echo e($patientFiles->appends(['tab' => 'documents'])->links('vendor.pagination.custom')); ?>

                        </div>

                    </div>

                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="prescriptions">

                        <h2 class="bq-print-heading">
                            الروشتات
                        </h2>

                        <?php if(count($prescriptions)): ?>
                            <div class="space-y-3">

                                <?php $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php

                                        $rxMeds = collect($rx->medications ?? [])
                                            ->map(
                                                fn($m) => [
                                                    'name' => (string) ($m['name'] ?? ''),
                                                    'dose' => (string) ($m['dose'] ?? ''),
                                                    'frequency' => (string) ($m['frequency'] ?? ''),
                                                    'duration' => (string) ($m['duration'] ?? ''),
                                                    'timing' => (string) ($m['timing'] ?? ''),
                                                    'notes' => (string) ($m['notes'] ?? ''),
                                                ],
                                            )
                                            ->values();

                                        $rxPayload = [
                                            'id' => $rx->id,

                                            'patient_id' => $rx->patient_id,

                                            'patient_name' => $patient->name,

                                            'patient_phone' => (string) $patient->phone,

                                            'prescription_date' => $rx->prescription_date?->format('Y-m-d'),

                                            'next_visit_date' => $rx->next_visit_date?->format('Y-m-d'),

                                            'notes' => (string) ($rx->notes ?? ''),

                                            'medications' => $rxMeds->all(),
                                        ];

                                    ?>


                                    <article class="clinic-surface-card p-4 sm:p-5"
                                        data-print-target="rx-<?php echo e($rx->id); ?>">

                                        <div class="bq-screen-only">

                                            <div class="flex flex-wrap items-center justify-between gap-3">

                                                <div>

                                                    <p class="font-bold tabular-nums">
                                                        <?php echo e($rx->ref); ?>

                                                    </p>

                                                    <p class="mt-1 text-xs text-muted-foreground">

                                                        <?php echo e($rx->prescription_date?->locale('ar')->translatedFormat('d M Y')); ?>


                                                    </p>

                                                </div>


                                                <div class="bq-no-print flex flex-wrap items-center gap-2">

                                                    <button type="button" class="btn btn-default btn-sm"
                                                        @click="$dispatch('bq-rx-edit', <?php echo \Illuminate\Support\Js::from($rxPayload)->toHtml() ?>)">

                                                        <i data-lucide="pencil" class="size-4"></i>

                                                        تعديل الروشتة

                                                    </button>


                                                    <button type="button" class="btn btn-outline btn-sm"
                                                        data-print-trigger="rx-<?php echo e($rx->id); ?>" data-print-mode="rx">

                                                        <i data-lucide="printer" class="size-4"></i>

                                                        طباعة الروشتة

                                                    </button>


                                                    <form method="POST"
                                                        action="<?php echo e(route('clinic.prescriptions.destroy', $rx)); ?>"
                                                        onsubmit="return confirm('حذف هذه الروشتة نهائيًا؟')">

                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>

                                                        <button type="submit" class="btn btn-outline btn-sm">

                                                            <i data-lucide="trash-2" class="size-4"></i>

                                                            حذف

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>


                                            <div class="mt-4 overflow-hidden rounded-xl border border-border/60">

                                                <div
                                                    class="hidden grid-cols-[1.5fr_1fr_1fr_1fr_1fr] gap-3 bg-muted/40 px-4 py-3 text-xs font-semibold text-muted-foreground sm:grid">

                                                    <div>الدواء</div>
                                                    <div>الجرعة</div>
                                                    <div>التكرار</div>
                                                    <div>المدة</div>
                                                    <div>التوقيت</div>

                                                </div>


                                                <?php $__currentLoopData = $rxMeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div
                                                        class="grid gap-2 border-b border-border/60 p-4 last:border-b-0 sm:grid-cols-[1.5fr_1fr_1fr_1fr_1fr] sm:items-center sm:gap-3 sm:px-4">

                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                الدواء
                                                            </p>

                                                            <p class="font-semibold">
                                                                <?php echo e($item['name']); ?>

                                                            </p>

                                                            <?php if($item['notes'] !== ''): ?>
                                                                <p class="mt-0.5 text-xs text-muted-foreground">
                                                                    <?php echo e($item['notes']); ?>

                                                                </p>
                                                            <?php endif; ?>

                                                        </div>


                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                الجرعة
                                                            </p>

                                                            <p class="text-sm">
                                                                <?php echo e($item['dose'] !== '' ? $item['dose'] : '—'); ?>

                                                            </p>

                                                        </div>


                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                التكرار
                                                            </p>

                                                            <p class="text-sm">
                                                                <?php echo e($item['frequency'] !== '' ? $item['frequency'] : '—'); ?>

                                                            </p>

                                                        </div>


                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                المدة
                                                            </p>

                                                            <p class="text-sm">
                                                                <?php echo e($item['duration'] !== '' ? $item['duration'] : '—'); ?>

                                                            </p>

                                                        </div>


                                                        <div>

                                                            <p class="text-xs text-muted-foreground sm:hidden">
                                                                التوقيت
                                                            </p>

                                                            <p class="text-sm text-muted-foreground">
                                                                <?php echo e($item['timing'] !== '' ? $item['timing'] : '—'); ?>

                                                            </p>

                                                        </div>

                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>


                                            <?php if($rx->notes || $rx->next_visit_date): ?>
                                                <div class="mt-4 grid gap-3 sm:grid-cols-2">

                                                    <?php if($rx->notes): ?>
                                                        <div
                                                            class="rounded-xl bg-muted/40 p-3 <?php echo e($rx->next_visit_date ? '' : 'sm:col-span-2'); ?>">

                                                            <p class="text-xs font-semibold text-muted-foreground">
                                                                ملاحظات الطبيب
                                                            </p>

                                                            <p class="bq-visit-text mt-1 text-sm">
                                                                <?php echo e($rx->notes); ?>

                                                            </p>

                                                        </div>
                                                    <?php endif; ?>


                                                    <?php if($rx->next_visit_date): ?>
                                                        <div class="rounded-xl bg-muted/40 p-3">

                                                            <p class="text-xs font-semibold text-muted-foreground">
                                                                موعد المتابعة
                                                            </p>

                                                            <p class="mt-1 text-sm">
                                                                <?php echo e($rx->next_visit_date->locale('ar')->translatedFormat('l، d M Y')); ?>

                                                            </p>

                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            <?php endif; ?>

                                        </div>


                                        
                                        <?php if (isset($component)) { $__componentOriginal4d9f717e1cf54ba851e5a1b9e51b5183 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4d9f717e1cf54ba851e5a1b9e51b5183 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.prescription-print','data' => ['rx' => $rx,'name' => $patient->name,'phone' => $patient->phone,'age' => $patientAge]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.prescription-print'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rx' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rx),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($patient->name),'phone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($patient->phone),'age' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($patientAge)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4d9f717e1cf54ba851e5a1b9e51b5183)): ?>
<?php $attributes = $__attributesOriginal4d9f717e1cf54ba851e5a1b9e51b5183; ?>
<?php unset($__attributesOriginal4d9f717e1cf54ba851e5a1b9e51b5183); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4d9f717e1cf54ba851e5a1b9e51b5183)): ?>
<?php $component = $__componentOriginal4d9f717e1cf54ba851e5a1b9e51b5183; ?>
<?php unset($__componentOriginal4d9f717e1cf54ba851e5a1b9e51b5183); ?>
<?php endif; ?>

                                    </article>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                <?php echo e($prescriptions->appends(['tab' => 'prescriptions'])->links('vendor.pagination.custom')); ?>


                            </div>
                        <?php else: ?>
                            <div class="clinic-surface-card p-6">

                                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-prescription-bottle-medical','title' => 'لا توجد روشتات','content' => 'لم يتم تسجيل أي روشتات لهذا المريض حتى الآن.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-prescription-bottle-medical','title' => 'لا توجد روشتات','content' => 'لم يتم تسجيل أي روشتات لهذا المريض حتى الآن.']); ?>
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

                            </div>
                        <?php endif; ?>

                    </div>

                <?php endif; ?>


                

                <div class="mt-4 hidden patient-tab-panel" data-patient-panel="bookings">

                    <h2 class="bq-print-heading">
                        الحجوزات
                    </h2>


                    <?php if($bookings->isNotEmpty()): ?>

                        <div class="space-y-3">

                            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php

                                    $bookingStatus = match ($booking->status) {
                                        'pending' => ['في انتظار الحضور', 'warning'],

                                        'confirmed' => ['حضر للعيادة', 'info'],

                                        'in_progress' => ['جاري الكشف', 'purple'],

                                        'completed' => ['تم الكشف', 'success'],

                                        'cancelled' => ['ملغي', 'danger'],

                                        'no_show' => ['لم يحضر', 'muted'],

                                        default => ['غير معروف', 'muted'],
                                    };

                                ?>


                                <div class="clinic-surface-card p-4">

                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                        
                                        <div class="min-w-0">

                                            <div class="flex flex-wrap items-center gap-2">

                                                <span class="badge badge-<?php echo e($bookingStatus[1]); ?>">
                                                    <?php echo e($bookingStatus[0]); ?>

                                                </span>


                                                <?php if($booking->booking_type === 'online'): ?>
                                                    <span class="badge badge-primary">
                                                        أونلاين
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-purple">
                                                        من العيادة
                                                    </span>
                                                <?php endif; ?>

                                            </div>

                                            <p class="mt-2 text-sm text-muted-foreground">

                                                <?php echo e(\Carbon\Carbon::parse($booking->appointment_date)->locale('ar')->translatedFormat('l، d M Y')); ?>


                                                <?php if($booking->started_at || $booking->completed_at): ?>
                                                    •

                                                    <?php if($booking->started_at): ?>
                                                        بدأ
                                                        <?php echo e(\Carbon\Carbon::parse($booking->started_at)->format('g:i A')); ?>

                                                    <?php endif; ?>

                                                    <?php if($booking->completed_at): ?>
                                                        <?php if($booking->started_at): ?>
                                                            -
                                                        <?php endif; ?>

                                                        انتهى
                                                        <?php echo e(\Carbon\Carbon::parse($booking->completed_at)->format('g:i A')); ?>

                                                    <?php endif; ?>
                                                <?php endif; ?>

                                            </p>


                                            <p class="mt-1 text-xs text-muted-foreground">
                                                <?php echo e($booking->service ?: 'لم تحدد'); ?>

                                            </p>

                                        </div>


                                        
                                        <div class="flex shrink-0 items-center justify-between gap-4 sm:justify-end">

                                            <div class="text-end">

                                                <p class="font-bold tabular-nums">

                                                    <?php echo e(number_format((float) $booking->price, 2)); ?>


                                                    ج.م

                                                </p>


                                                <p class="mt-1 text-xs text-success">

                                                    <?php echo e(number_format((float) $booking->paid, 2)); ?>


                                                    جنيه

                                                </p>

                                            </div>


                                            <?php if (! ($isAssistant)): ?>
                                                <div class="flex items-center gap-2">

                                                    
                                                    <button type="button" class="btn btn-icon" data-edit-payment
                                                        data-id="<?php echo e($booking->id); ?>"
                                                        data-name="<?php echo e($booking->patient_name); ?>"
                                                        data-price="<?php echo e((float) $booking->price); ?>"
                                                        data-paid="<?php echo e((float) $booking->paid); ?>" title="تعديل الدفع"
                                                        aria-label="تعديل الدفع">

                                                        <i data-lucide="wallet" class="size-4"></i>

                                                    </button>



                                                    
                                                    <form method="POST"
                                                        action="<?php echo e(route('clinic.bookings.destroy', $booking)); ?>"
                                                        onsubmit="return confirm('حذف هذا الحجز نهائيًا؟')">

                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>

                                                        <button type="submit" class="btn btn-icon btn-destructive"
                                                            title="حذف الحجز" aria-label="حذف الحجز">

                                                            <i data-lucide="trash-2" class="h-4 w-4">
                                                            </i>

                                                        </button>

                                                    </form>

                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </div>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>


                        <div class="mt-4">

                            <?php echo e($bookings->appends(['tab' => 'bookings'])->links('vendor.pagination.custom')); ?>


                        </div>
                    <?php else: ?>
                        <div class="clinic-surface-card p-6">

                            <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-calendar-check','title' => 'لا توجد حجوزات','content' => 'لم يتم تسجيل أي حجوزات لهذا المريض حتى الآن.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-calendar-check','title' => 'لا توجد حجوزات','content' => 'لم يتم تسجيل أي حجوزات لهذا المريض حتى الآن.']); ?>
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

                        </div>

                    <?php endif; ?>

                </div>


                

                <?php if (! ($isAssistant)): ?>

                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="payments">

                        <div class="bq-no-print mb-3 flex items-center justify-between gap-2">

                            <h2 class="bq-print-heading mb-0">
                                المدفوعات
                            </h2>



                        </div>

                        <?php if($payments->isNotEmpty()): ?>
                            <div class="space-y-3">

                                <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $isBooking = $row->source === 'booking';
                                        $isExpense = $row->type === 'expense';
                                        $remaining = $isBooking
                                            ? max(0, (float) $row->expected - (float) $row->amount)
                                            : 0;
                                        $hasNote = !empty(trim((string) ($row->notes ?? '')));
                                    ?>

                                    <div
                                        class="clinic-surface-card flex flex-col gap-3 p-4 sm:flex-row sm:items-center sm:justify-between">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div
                                                class="grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">

                                                <i data-lucide="wallet" class="size-5"></i>

                                            </div>

                                            <div class="min-w-0">

                                                <div class="flex flex-wrap items-center gap-2">

                                                    <p class="font-bold">
                                                        <?php echo e($row->title ?: 'كشف / خدمة'); ?>

                                                    </p>

                                                    <?php if($isExpense): ?>
                                                        <span class="badge badge-danger">مصروف</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-success">إيراد</span>
                                                    <?php endif; ?>

                                                    <?php if($isBooking && $remaining > 0): ?>
                                                        <span class="badge badge-warning">مستحق</span>
                                                    <?php endif; ?>
                                                </div>

                                                <p class="mt-1 text-xs text-muted-foreground">

                                                    <?php echo e(\Carbon\Carbon::parse($row->row_date)->locale('ar')->translatedFormat('l، d M Y')); ?>


                                                    •

                                                    <?php echo e($isBooking ? 'من الحجز' : 'مسجل يدويًا'); ?>


                                                </p>

                                            </div>

                                        </div>


                                        <div class="flex flex-wrap items-center gap-3 sm:justify-end">

                                            <?php if($isBooking): ?>
                                                <div class="text-end">
                                                    <p class="text-xs text-muted-foreground">الإجمالي</p>
                                                    <p class="mt-0.5 font-bold tabular-nums">
                                                        <?php echo e($fmtMoney($row->expected)); ?> ج.م
                                                    </p>
                                                </div>

                                                <div class="text-end">
                                                    <p class="text-xs text-muted-foreground">المدفوع</p>
                                                    <p class="mt-0.5 font-bold text-success tabular-nums">
                                                        <?php echo e($fmtMoney($row->amount)); ?> ج.م
                                                    </p>
                                                </div>

                                                <?php if($remaining > 0): ?>
                                                    <div class="text-end">
                                                        <p class="text-xs text-muted-foreground">المتبقي</p>
                                                        <p class="mt-0.5 font-semibold tabular-nums text-warning">
                                                            <?php echo e($fmtMoney($remaining)); ?> ج.م
                                                        </p>
                                                    </div>
                                                <?php endif; ?>

                                                <button type="button" class="btn btn-icon" data-edit-payment
                                                    data-id="<?php echo e($row->row_id); ?>" data-name="<?php echo e($patient->name); ?>"
                                                    data-price="<?php echo e((float) $row->expected); ?>"
                                                    data-paid="<?php echo e((float) $row->amount); ?>" title="تعديل الدفع"
                                                    aria-label="تعديل الدفع">
                                                    <i data-lucide="wallet" class="size-4"></i>
                                                </button>
                                            <?php else: ?>
                                                <div class="text-end">
                                                    <p class="text-xs text-muted-foreground">المبلغ</p>
                                                    <p
                                                        class="mt-0.5 font-bold tabular-nums <?php echo e($isExpense ? 'text-destructive' : 'text-success'); ?>">
                                                        <?php echo e($isExpense ? '−' : ''); ?><?php echo e($fmtMoney($row->amount)); ?> ج.م
                                                    </p>
                                                </div>

                                                <div class="flex items-center gap-2">

                                                    <?php if($hasNote): ?>
                                                        <button type="button" class="btn btn-icon" data-payment-note
                                                            data-note="<?php echo e($row->notes); ?>"
                                                            data-title="<?php echo e($row->title ?: 'ملاحظة الحركة'); ?>"
                                                            title="عرض الملاحظة" aria-label="عرض الملاحظة">
                                                            <i data-lucide="message-square-text" class="size-4"></i>
                                                        </button>
                                                    <?php endif; ?>

                                                    <form method="POST"
                                                        action="<?php echo e(route('clinic.payments.destroy', $row->row_id)); ?>"
                                                        onsubmit="return confirm('حذف هذا السجل؟')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-icon btn-destructive"
                                                            title="حذف" aria-label="حذف">
                                                            <i data-lucide="trash-2" class="size-4"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            <?php endif; ?>

                                        </div>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php echo e($payments->appends(['tab' => 'payments'])->links('vendor.pagination.custom')); ?>


                            </div>
                        <?php else: ?>
                            <div class="clinic-surface-card p-6">

                                <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-wallet','title' => 'لا توجد مدفوعات','content' => 'لم يتم تسجيل أي مدفوعات لهذا المريض حتى الآن.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-wallet','title' => 'لا توجد مدفوعات','content' => 'لم يتم تسجيل أي مدفوعات لهذا المريض حتى الآن.']); ?>
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

                            </div>
                        <?php endif; ?>

                    </div>


                    
                    <div class="mt-4 hidden patient-tab-panel" data-patient-panel="notes">

                        <h2 class="bq-print-heading">
                            ملاحظات
                        </h2>

                        <div class="grid gap-4 lg:grid-cols-[1fr_1.5fr]">

                            
                            <div class="bq-no-print clinic-surface-card p-4 sm:p-5">

                                <div class="flex items-center gap-2">

                                    <div class="grid size-9 place-items-center rounded-lg bg-primary-soft text-primary">
                                        <i data-lucide="sticky-note" class="size-4"></i>
                                    </div>

                                    <div>
                                        <h2 class="text-sm font-bold">
                                            إضافة ملاحظة
                                        </h2>

                                        <p class="mt-0.5 text-xs text-muted-foreground">
                                            ملاحظات خاصة بالطبيب
                                        </p>
                                    </div>

                                </div>

                                <form action="<?php echo e(route('clinic.patient.notes.store', $patient)); ?>" method="POST"
                                    class="mt-4">
                                    <?php echo csrf_field(); ?>

                                    <textarea name="note" rows="10"
                                        class="field-input min-h-[240px] resize-y <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="اكتب ملاحظة خاصة بالمريض..."><?php echo e(old('note')); ?></textarea>

                                    <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1.5 text-xs text-red-500">
                                            <?php echo e($message); ?>

                                        </p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                    <button type="submit" class="btn btn-default mt-3 w-full">

                                        <i data-lucide="save" class="size-4"></i>

                                        حفظ الملاحظة

                                    </button>
                                </form>

                            </div>


                            
                            <div>
                                <?php if($notes?->total() > 0): ?>
                                    <div class="space-y-3">

                                        <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="clinic-surface-card p-4">

                                                <div class="flex items-start gap-3">

                                                    <div
                                                        class="grid size-9 shrink-0 place-items-center rounded-lg bg-muted text-muted-foreground">

                                                        <i data-lucide="sticky-note" class="size-4"></i>

                                                    </div>

                                                    <div class="min-w-0 flex-1">

                                                        <p class="text-sm leading-6 whitespace-pre-line">
                                                            <?php echo e($note->note); ?>

                                                        </p>

                                                        <p class="mt-2 text-xs text-muted-foreground">
                                                            <?php echo e($note->created_at?->timezone('Africa/Cairo')->format('Y/m/d - h:i A')); ?>

                                                        </p>

                                                    </div>



                                                    <form action="<?php echo e(route('clinic.patient.notes.destroy', $note)); ?>"
                                                        method="POST"
                                                        onsubmit="return confirm('هل أنت متأكد من حذف هذه الملاحظة؟');">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>

                                                        <button type="submit" class="btn btn-icon-sm shrink-0"
                                                            title="حذف الملاحظة" aria-label="حذف الملاحظة">

                                                            <i data-lucide="trash-2" class="h-4 w-4"></i>

                                                        </button>

                                                    </form>

                                                </div>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php echo e($notes->appends(['tab' => 'notes'])->links('vendor.pagination.custom')); ?>

                                    </div>
                                <?php else: ?>
                                    <div class="clinic-surface-card p-6">

                                        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-note-sticky','title' => 'لا توجد ملاحظات','content' => 'لم يتم تسجيل أي ملاحظات لهذا المريض حتى الآن.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-note-sticky','title' => 'لا توجد ملاحظات','content' => 'لم يتم تسجيل أي ملاحظات لهذا المريض حتى الآن.']); ?>
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

                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </main>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88c553753d1dacfad57e787957b8e054)): ?>
<?php $attributes = $__attributesOriginal88c553753d1dacfad57e787957b8e054; ?>
<?php unset($__attributesOriginal88c553753d1dacfad57e787957b8e054); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88c553753d1dacfad57e787957b8e054)): ?>
<?php $component = $__componentOriginal88c553753d1dacfad57e787957b8e054; ?>
<?php unset($__componentOriginal88c553753d1dacfad57e787957b8e054); ?>
<?php endif; ?>


    
    <?php if (! ($isAssistant)): ?>
        
        <?php if (isset($component)) { $__componentOriginalfa971874f0cc23530af77fd742593001 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa971874f0cc23530af77fd742593001 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.edit-payment-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.edit-payment-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa971874f0cc23530af77fd742593001)): ?>
<?php $attributes = $__attributesOriginalfa971874f0cc23530af77fd742593001; ?>
<?php unset($__attributesOriginalfa971874f0cc23530af77fd742593001); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa971874f0cc23530af77fd742593001)): ?>
<?php $component = $__componentOriginalfa971874f0cc23530af77fd742593001; ?>
<?php unset($__componentOriginalfa971874f0cc23530af77fd742593001); ?>
<?php endif; ?>


        
        <?php if (isset($component)) { $__componentOriginalc582acabef3e87c0211345f29753d199 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc582acabef3e87c0211345f29753d199 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.prescription-form','data' => ['patient' => $patient]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.prescription-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['patient' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($patient)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc582acabef3e87c0211345f29753d199)): ?>
<?php $attributes = $__attributesOriginalc582acabef3e87c0211345f29753d199; ?>
<?php unset($__attributesOriginalc582acabef3e87c0211345f29753d199); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc582acabef3e87c0211345f29753d199)): ?>
<?php $component = $__componentOriginalc582acabef3e87c0211345f29753d199; ?>
<?php unset($__componentOriginalc582acabef3e87c0211345f29753d199); ?>
<?php endif; ?>
        
        <?php if (isset($component)) { $__componentOriginal9daf3aebfe8a92984db53b580c8633c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9daf3aebfe8a92984db53b580c8633c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.file-upload-modal','data' => ['patient' => $patient]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.file-upload-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['patient' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($patient)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9daf3aebfe8a92984db53b580c8633c0)): ?>
<?php $attributes = $__attributesOriginal9daf3aebfe8a92984db53b580c8633c0; ?>
<?php unset($__attributesOriginal9daf3aebfe8a92984db53b580c8633c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9daf3aebfe8a92984db53b580c8633c0)): ?>
<?php $component = $__componentOriginal9daf3aebfe8a92984db53b580c8633c0; ?>
<?php unset($__componentOriginal9daf3aebfe8a92984db53b580c8633c0); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalb9e57ad79fc20bbcd41f1c781dbd9bec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb9e57ad79fc20bbcd41f1c781dbd9bec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.file-viewer-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.file-viewer-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb9e57ad79fc20bbcd41f1c781dbd9bec)): ?>
<?php $attributes = $__attributesOriginalb9e57ad79fc20bbcd41f1c781dbd9bec; ?>
<?php unset($__attributesOriginalb9e57ad79fc20bbcd41f1c781dbd9bec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb9e57ad79fc20bbcd41f1c781dbd9bec)): ?>
<?php $component = $__componentOriginalb9e57ad79fc20bbcd41f1c781dbd9bec; ?>
<?php unset($__componentOriginalb9e57ad79fc20bbcd41f1c781dbd9bec); ?>
<?php endif; ?>

        
        <div class="payment-note-modal" data-payment-note-modal aria-hidden="true">
            <div class="payment-note-panel" role="dialog" aria-modal="true" aria-labelledby="payment-note-modal-title"
                dir="rtl">
                <div class="payment-note-header">
                    <div class="payment-note-title-wrap">
                        <div class="payment-note-icon">
                            <i data-lucide="notebook-pen" class="size-5"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 id="payment-note-modal-title" class="truncate text-lg font-bold">ملاحظة الحركة</h3>
                            <p class="mt-1 text-xs text-muted-foreground">التفاصيل الإضافية المسجلة مع الحركة المالية</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-icon" data-payment-note-close aria-label="إغلاق" title="إغلاق">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>
                <div class="payment-note-body">
                    <div class="payment-note-content" data-payment-note-content></div>
                    <div class="payment-note-meta" data-payment-note-meta></div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php $__env->startPush('extra_java'); ?>
        <script src="<?php echo e(asset('js/clinic/print.js')); ?>"></script>
        <script src="<?php echo e(asset('js/clinic/clinic-payments.js')); ?>"></script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /*
                |--------------------------------------------------------------------------
                | Patient Details Tabs
                |--------------------------------------------------------------------------
                */

                const tabsWrapper =
                    document.querySelector('[data-patient-tabs]');

                if (tabsWrapper) {

                    const triggers =
                        tabsWrapper.querySelectorAll('[data-patient-tab]');

                    const panels =
                        tabsWrapper.querySelectorAll('[data-patient-panel]');


                    function activateTab(target, updateUrl = true) {

                        const exists =
                            Array.prototype.some.call(
                                triggers,
                                function(trigger) {

                                    return trigger.getAttribute(
                                        'data-patient-tab'
                                    ) === target;

                                }
                            ) &&
                            Array.prototype.some.call(
                                panels,
                                function(panel) {

                                    return panel.getAttribute(
                                        'data-patient-panel'
                                    ) === target;

                                }
                            );


                        if (!exists) {
                            target = 'overview';
                        }


                        triggers.forEach(function(trigger) {

                            trigger.classList.toggle(
                                'active',
                                trigger.getAttribute(
                                    'data-patient-tab'
                                ) === target
                            );

                        });


                        panels.forEach(function(panel) {

                            const isTarget =
                                panel.getAttribute(
                                    'data-patient-panel'
                                ) === target;


                            panel.classList.toggle(
                                'hidden',
                                !isTarget
                            );

                            panel.classList.toggle(
                                'active',
                                isTarget
                            );

                        });


                        if (updateUrl) {

                            const url =
                                new URL(window.location.href);

                            url.searchParams.set(
                                'tab',
                                target
                            );

                            url.searchParams.delete('page');

                            window.history.replaceState({},
                                '',
                                url.toString()
                            );

                        }

                    }


                    triggers.forEach(function(trigger) {

                        trigger.addEventListener(
                            'click',
                            function() {

                                activateTab(
                                    trigger.getAttribute(
                                        'data-patient-tab'
                                    ),
                                    true
                                );

                            }
                        );

                    });


                    const urlParams =
                        new URLSearchParams(
                            window.location.search
                        );


                    activateTab(
                        urlParams.get('tab') || 'overview',
                        false
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Edit Payment Modal
                |--------------------------------------------------------------------------
                */

                const paymentModal =
                    document.getElementById(
                        'edit-payment-modal'
                    );

                const paymentForm =
                    document.getElementById(
                        'edit-payment-form'
                    );

                const paymentPatient =
                    document.getElementById(
                        'edit-payment-patient'
                    );

                const paymentPrice =
                    document.getElementById(
                        'edit-payment-price'
                    );

                const paymentPaid =
                    document.getElementById(
                        'edit-payment-paid'
                    );

                const paymentTotalPreview =
                    document.getElementById(
                        'edit-payment-total-preview'
                    );

                const paymentPaidPreview =
                    document.getElementById(
                        'edit-payment-paid-preview'
                    );

                const paymentRemainingPreview =
                    document.getElementById(
                        'edit-payment-remaining-preview'
                    );


                function updatePaymentPreview() {

                    if (
                        !paymentPrice ||
                        !paymentPaid
                    ) {
                        return;
                    }


                    const price =
                        Math.max(
                            0,
                            Number(paymentPrice.value) || 0
                        );

                    const paid =
                        Math.max(
                            0,
                            Number(paymentPaid.value) || 0
                        );

                    const remaining =
                        Math.max(
                            0,
                            price - paid
                        );


                    if (paymentTotalPreview) {

                        paymentTotalPreview.textContent =
                            `${price.toFixed(2)} ج.م`;

                    }


                    if (paymentPaidPreview) {

                        paymentPaidPreview.textContent =
                            `${paid.toFixed(2)} ج.م`;

                    }


                    if (paymentRemainingPreview) {

                        paymentRemainingPreview.textContent =
                            `${remaining.toFixed(2)} ج.م`;

                    }

                }


                function openPaymentModal(button) {

                    if (
                        !paymentModal ||
                        !paymentForm
                    ) {
                        return;
                    }


                    const id =
                        button.dataset.id;

                    const name =
                        button.dataset.name || '';

                    const price =
                        Number(button.dataset.price || 0);

                    const paid =
                        Number(button.dataset.paid || 0);


                    paymentForm.action =
                        <?php echo json_encode(route('clinic.bookings.payment', [
                                'booking' => '__BOOKING_ID__', ])) ?>.replace(
                            '__BOOKING_ID__',
                            encodeURIComponent(id)
                        );


                    if (paymentPatient) {

                        paymentPatient.textContent =
                            `تعديل الدفع للحجز للمريض ${name}`;

                    }


                    if (paymentPrice) {

                        paymentPrice.value =
                            price;

                    }


                    if (paymentPaid) {

                        paymentPaid.value =
                            paid;

                    }


                    updatePaymentPreview();


                    paymentModal.classList.add('open');

                    document.body.classList.add(
                        'overflow-hidden'
                    );


                    if (window.lucide) {
                        window.lucide.createIcons();
                    }

                }


                function closePaymentModal() {

                    if (!paymentModal) {
                        return;
                    }


                    paymentModal.classList.remove('open');

                    document.body.classList.remove(
                        'overflow-hidden'
                    );

                }


                document.addEventListener(
                    'click',
                    function(event) {

                        const editButton =
                            event.target.closest(
                                '[data-edit-payment]'
                            );


                        if (editButton) {

                            openPaymentModal(
                                editButton
                            );

                            return;

                        }


                        const closeButton =
                            event.target.closest(
                                '[data-modal-close]'
                            );


                        if (closeButton) {

                            closePaymentModal();

                            return;

                        }


                        if (
                            paymentModal &&
                            event.target === paymentModal
                        ) {

                            closePaymentModal();

                        }

                    }
                );


                if (paymentPrice) {

                    paymentPrice.addEventListener(
                        'input',
                        updatePaymentPreview
                    );

                }


                if (paymentPaid) {

                    paymentPaid.addEventListener(
                        'input',
                        updatePaymentPreview
                    );

                }


                document.addEventListener(
                    'keydown',
                    function(event) {

                        if (
                            event.key === 'Escape' &&
                            paymentModal &&
                            paymentModal.classList.contains('open')
                        ) {

                            closePaymentModal();

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Lucide
                |--------------------------------------------------------------------------
                */

                if (window.lucide) {

                    window.lucide.createIcons();

                }

            });
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app_clinc', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/patients/patient_details.blade.php ENDPATH**/ ?>