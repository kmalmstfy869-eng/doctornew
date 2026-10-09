
<?php
    $showPatient = $showPatient ?? true;
?>

<?php if($files->isNotEmpty()): ?>

    <div class="space-y-3">

        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $viewUrl = route('clinic.files.view', $file);
                $downloadUrl = route('clinic.files.download', $file);
            ?>

            <article class="clinic-surface-card pf-row">

                <div class="pf-row__main">

                    <div class="pf-icon bg-primary-soft text-primary">
                        <i data-lucide="<?php echo e($file->is_image ? 'image' : 'file-text'); ?>" class="size-5"></i>
                    </div>

                    <div class="pf-row__info">

                        <p class="pf-name"><?php echo e($file->original_name); ?></p>

                        <?php if($showPatient && $file->patient): ?>
                            <a href="<?php echo e(route('clinic.patients.show', $file->patient_id)); ?>"
                                class="pf-patient hover:underline">
                                <?php echo e($file->patient->name); ?>

                                <?php if($file->patient->phone): ?>
                                    <span class="tabular-nums">• <?php echo e($file->patient->phone); ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>

                        <div class="pf-meta text-muted-foreground">
                            <span class="badge badge-info"><?php echo e($file->kind_label); ?></span>
                            <span class="tabular-nums"><?php echo e($file->size_label); ?></span>
                            <span><?php echo e($file->date_label); ?></span>
                        </div>

                    </div>

                </div>

                <div class="pf-actions bq-no-print">

                    
                    <?php if($file->is_image): ?>
                        <button type="button" class="btn btn-default btn-sm"
                            @click="$dispatch('pf-view', <?php echo \Illuminate\Support\Js::from(['name' => $file->original_name, 'url' => $viewUrl, 'download' => $downloadUrl])->toHtml() ?>)">
                            <i data-lucide="eye" class="size-4"></i>
                            عرض
                        </button>
                    <?php else: ?>
                        <a href="<?php echo e($viewUrl); ?>" target="_blank" rel="noopener noreferrer"
                            class="btn btn-default btn-sm">
                            <i data-lucide="eye" class="size-4"></i>
                            عرض
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo e($downloadUrl); ?>" class="btn btn-outline btn-sm">
                        <i data-lucide="download" class="size-4"></i>
                        تحميل
                    </a>

                    <form method="POST" action="<?php echo e(route('clinic.files.destroy', $file)); ?>"
                        onsubmit="return confirm('حذف هذا الملف نهائيًا؟')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline btn-sm">
                            <i data-lucide="trash-2" class="size-4"></i>
                            حذف
                        </button>
                    </form>

                </div>

            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
<?php else: ?>
    <div class="clinic-surface-card p-6">
        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-folder-open','title' => request('search') ? 'لا توجد نتائج مطابقة للبحث' : 'لا توجد ملفات','content' => request('search')
                ? 'جرّب اسمًا أو رقم هاتف مختلف.'
                : ($showPatient
                    ? 'لم يتم رفع أي ملفات طبية حتى الآن.'
                    : 'لم يتم رفع أي ملفات طبية لهذا المريض حتى الآن.')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-folder-open','title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('search') ? 'لا توجد نتائج مطابقة للبحث' : 'لا توجد ملفات'),'content' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('search')
                ? 'جرّب اسمًا أو رقم هاتف مختلف.'
                : ($showPatient
                    ? 'لم يتم رفع أي ملفات طبية حتى الآن.'
                    : 'لم يتم رفع أي ملفات طبية لهذا المريض حتى الآن.'))]); ?>
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
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/files/_list.blade.php ENDPATH**/ ?>