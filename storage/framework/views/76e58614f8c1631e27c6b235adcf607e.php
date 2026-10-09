<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/clinic/patient-files.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('title', 'ملفات المرضى | دليل الأطباء'); ?>

<?php $__env->startSection('content'); ?>

    
    <?php if (isset($component)) { $__componentOriginal9daf3aebfe8a92984db53b580c8633c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9daf3aebfe8a92984db53b580c8633c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.file-upload-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.file-upload-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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

    
    <main x-data class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        
        <?php if (isset($component)) { $__componentOriginalcbacafbc245a17c0a27a4b6359a97253 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbacafbc245a17c0a27a4b6359a97253 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.storage-upsell','data' => ['stats' => $stats]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.storage-upsell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats)]); ?>
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

        <div class="clinic-surface-card mb-4 p-4 sm:p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-3">
                    <div class="grid size-12 shrink-0 place-items-center rounded-2xl bg-primary-soft text-primary">
                        <i data-lucide="folder-open" class="size-6"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-foreground sm:text-2xl">ملفات المرضى</h1>
                        <p class="mt-1 text-sm text-muted-foreground" id="pf-count"><?php echo e($files->total()); ?> ملف</p>
                    </div>
                </div>
                <div class="flex w-full flex-col gap-2 sm:flex-row sm:items-center lg:w-auto">
                    <div class="relative w-full sm:w-80 lg:w-[26rem]">
                        <i data-lucide="search"
                            class="pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground"></i>
                        <input type="text" name="search" value="<?php echo e($search); ?>" class="field-input w-full ps-9"
                            placeholder="ابحث باسم المريض أو رقم الهاتف" autocomplete="off" data-live-search
                            data-live-search-url="<?php echo e(route('clinic.files.index')); ?>"
                            data-live-search-target="#pf-list" data-live-search-pagination="#pf-pagination"
                            data-live-search-count="#pf-count">
                    </div>

                    <button type="button" class="btn btn-default" @click="$dispatch('pf-upload-open')">
                        <i data-lucide="upload" class="size-4"></i>
                        رفع ملف جديد
                    </button>
                </div>

            </div>
        </div>

        <div class="mb-4">
            <?php if (isset($component)) { $__componentOriginalca7ccef8be7e12d4f030ee719d819fc8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca7ccef8be7e12d4f030ee719d819fc8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.doctor.clinic.storage-card','data' => ['stats' => $stats]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('doctor.clinic.storage-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats)]); ?>
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

        <div id="pf-list">
            <?php echo $__env->make('doctor.clinic.files._list', ['files' => $files, 'showPatient' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div id="pf-pagination" class="bq-no-print mt-4">
            <?php echo e($files->links('vendor.pagination.custom')); ?>

        </div>

    </main>

    <?php $__env->startPush('extra_java'); ?>
        <script src="<?php echo e(asset('js/clinic/live_search.js')); ?>"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app_clinc', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/files/index.blade.php ENDPATH**/ ?>