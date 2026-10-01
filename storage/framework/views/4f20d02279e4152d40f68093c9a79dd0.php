<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/home/pagination.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('title', 'جدول العيادة | دليل الأطباء'); ?>

<?php
    $dayLabels = [
        0 => 'الأحد',
        1 => 'الإثنين',
        2 => 'الثلاثاء',
        3 => 'الأربعاء',
        4 => 'الخميس',
        5 => 'الجمعة',
        6 => 'السبت',
    ];

    $allDaysAdded = count($usedDays) >= 7;
?>

<?php $__env->startSection('content'); ?>

<main class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div class="min-w-0">

            <h1 class="truncate text-xl font-bold sm:text-2xl">
                جدول العيادة
            </h1>

            <p class="mt-1 text-sm text-muted-foreground">
                حدد أيام العمل وساعاته ومدة الموعد — هذا الجدول هو أساس توليد المواعيد الإلكترونية.
            </p>

        </div>

        <div class="flex flex-wrap items-center gap-2">

            <button
                type="button"
                class="btn btn-default"
                data-modal-open="<?php echo e($allDaysAdded ? 'modal-all-days' : 'modal-new-day'); ?>"
            >
                <i data-lucide="plus" class="size-4"></i>
                إضافة يوم
            </button>

        </div>

    </div>

    <?php if($schedules->count()): ?>

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">

            <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php
                    $dayName = $dayLabels[$schedule->day_of_week];

                    $startTime = $schedule->start_time
                        ? \Illuminate\Support\Str::substr($schedule->start_time, 0, 5)
                        : null;

                    $endTime = $schedule->end_time
                        ? \Illuminate\Support\Str::substr($schedule->end_time, 0, 5)
                        : null;

                    $appointmentCount = null;

                    if ($schedule->is_active && $startTime && $endTime && $schedule->slot_duration) {
                        $start = \Carbon\Carbon::createFromFormat('H:i', $startTime);
                        $end = \Carbon\Carbon::createFromFormat('H:i', $endTime);

                        $minutes = $start->diffInMinutes($end);

                        $appointmentCount = intdiv(
                            $minutes,
                            $schedule->slot_duration
                        );
                    }
                ?>

                <div class="clinic-surface-card p-4">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <h3 class="text-base font-bold">
                                <?php echo e($dayName); ?>

                            </h3>

                            <p class="mt-1 text-sm text-muted-foreground tabular-nums">

                                <?php if($schedule->is_active && $startTime && $endTime): ?>

                                    <?php echo e(\Carbon\Carbon::createFromFormat('H:i', $startTime)->format('h:i')); ?>

                                    <?php echo e(\Carbon\Carbon::createFromFormat('H:i', $startTime)->format('A') === 'AM' ? 'ص' : 'م'); ?>


                                    ←

                                    <?php echo e(\Carbon\Carbon::createFromFormat('H:i', $endTime)->format('h:i')); ?>

                                    <?php echo e(\Carbon\Carbon::createFromFormat('H:i', $endTime)->format('A') === 'AM' ? 'ص' : 'م'); ?>


                                <?php else: ?>
                                    غير محدد
                                <?php endif; ?>

                            </p>

                        </div>

                        <?php if($schedule->is_active): ?>

                            <span class="badge badge-success">
                                مُفعل
                            </span>

                        <?php else: ?>

                            <span class="badge badge-muted">
                                معطل
                            </span>

                        <?php endif; ?>

                    </div>

                    <div class="mt-3 flex flex-wrap gap-2 text-xs">

                        <span class="badge badge-primary">
                            مدة الموعد: <?php echo e($schedule->slot_duration); ?> دقيقة
                        </span>

                        <?php if($appointmentCount !== null): ?>

                            <span class="badge badge-info">
                                <?php echo e($appointmentCount); ?> موعد
                            </span>

                        <?php endif; ?>

                    </div>

                    <div class="mt-4 flex items-center justify-between gap-2 border-t border-border pt-3">

                        <span class="text-xs text-muted-foreground">
                            <?php echo e($schedule->is_active ? 'اليوم مُفعل للحجز' : 'اليوم غير مفعل للحجز'); ?>

                        </span>

                        <div class="flex gap-1">

                            <button
                                type="button"
                                class="btn btn-ghost btn-icon-sm"
                                data-modal-open="modal-edit-<?php echo e($schedule->id); ?>"
                                aria-label="تعديل"
                            >
                                <i data-lucide="pencil" class="size-4"></i>
                            </button>

                            <button
                                type="button"
                                class="btn btn-ghost btn-icon-sm"
                                data-modal-open="modal-delete-<?php echo e($schedule->id); ?>"
                                aria-label="حذف"
                            >
                                <i data-lucide="trash-2" class="size-4 text-destructive"></i>
                            </button>

                        </div>

                    </div>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    <?php else: ?>

        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-calendar-days','title' => 'لا يوجد جدول للعيادة','content' => 'لم يتم إضافة مواعيد العمل بعد. أضف جدول عيادتك الآن لتنظيم مواعيد استقبال المرضى بسهولة.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-calendar-days','title' => 'لا يوجد جدول للعيادة','content' => 'لم يتم إضافة مواعيد العمل بعد. أضف جدول عيادتك الآن لتنظيم مواعيد استقبال المرضى بسهولة.']); ?>
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

</main>

<div id="modal-new-day" class="modal-overlay">

    <div class="modal-panel">

        <div class="mb-4">

            <h2 class="text-base font-bold">
                إضافة يوم عمل
            </h2>

            <p class="mt-1 text-sm text-muted-foreground">
                أضف يومًا جديدًا إلى جدول العيادة.
            </p>

        </div>

        <form action="<?php echo e(route('clinic.schedules.store')); ?>" method="POST">

            <?php echo csrf_field(); ?>

            <div class="space-y-4">

                <div>

                    <label class="field-label">
                        اليوم
                    </label>

                    <select name="day_of_week" class="field-select" required>

                        <?php $__currentLoopData = $dayLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayNumber => $dayName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if(!in_array($dayNumber, $usedDays)): ?>

                                <option
                                    value="<?php echo e($dayNumber); ?>"
                                    <?php echo e((string) old('day_of_week') === (string) $dayNumber ? 'selected' : ''); ?>

                                >
                                    <?php echo e($dayName); ?>

                                </option>

                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>

                    <?php $__errorArgs = ['day_of_week'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                        <div class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span><?php echo e($message); ?></span>
                        </div>

                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>

                <div class="grid grid-cols-2 gap-3">

                    <div>

                        <label class="field-label">
                            بداية العمل
                        </label>

                        <input
                            type="time"
                            name="start_time"
                            class="field-input"
                            value="<?php echo e(old('start_time', '09:00')); ?>"
                            required
                        >

                        <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                            <div class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span><?php echo e($message); ?></span>
                            </div>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                    <div>

                        <label class="field-label">
                            نهاية العمل
                        </label>

                        <input
                            type="time"
                            name="end_time"
                            class="field-input"
                            value="<?php echo e(old('end_time', '14:00')); ?>"
                            required
                        >

                        <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                            <div class="field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span><?php echo e($message); ?></span>
                            </div>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                </div>

                <div>

                    <label class="field-label">
                        مدة الموعد بالدقائق
                    </label>

                    <input
                        type="number"
                        name="slot_duration"
                        class="field-input"
                        value="<?php echo e(old('slot_duration', 30)); ?>"
                        min="5"
                        max="240"
                        step="5"
                        required
                    >

                    <?php $__errorArgs = ['slot_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                        <div class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span><?php echo e($message); ?></span>
                        </div>

                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>

                <div>

                    <label class="flex items-center gap-2">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            <?php echo e(old('is_active', '1') ? 'checked' : ''); ?>

                        >

                        <span>
                            تفعيل اليوم
                        </span>

                    </label>

                    <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                        <div class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span><?php echo e($message); ?></span>
                        </div>

                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                </div>

            </div>

            <div class="mt-6 flex justify-end gap-2">

                <button
                    type="button"
                    class="btn btn-outline"
                    data-modal-close
                >
                    إلغاء
                </button>

                <button
                    type="submit"
                    class="btn btn-default"
                >
                    حفظ
                </button>

            </div>

        </form>

    </div>

</div>

<div id="modal-all-days" class="modal-overlay">

    <div class="modal-panel">

        <div class="mb-4">

            <h2 class="text-base font-bold">
                تم إضافة جميع الأيام
            </h2>

            <p class="mt-2 text-sm text-muted-foreground">
                لقد أضفت جميع أيام الأسبوع إلى جدول العيادة.
                يمكنك تعديل أوقات العمل أو مدة المواعيد من خلال زر التعديل.
            </p>

        </div>

        <div class="mt-6 flex justify-end">

            <button
                type="button"
                class="btn btn-default"
                data-modal-close
            >
                حسنًا
            </button>

        </div>

    </div>

</div>

<?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php
        $dayName = $dayLabels[$schedule->day_of_week];

        $startTime = $schedule->start_time
            ? \Illuminate\Support\Str::substr($schedule->start_time, 0, 5)
            : '09:00';

        $endTime = $schedule->end_time
            ? \Illuminate\Support\Str::substr($schedule->end_time, 0, 5)
            : '14:00';

        $editStartTime = old('edit_schedule_id') == $schedule->id
            ? old('start_time', $startTime)
            : $startTime;

        $editEndTime = old('edit_schedule_id') == $schedule->id
            ? old('end_time', $endTime)
            : $endTime;

        $editSlotDuration = old('edit_schedule_id') == $schedule->id
            ? old('slot_duration', $schedule->slot_duration)
            : $schedule->slot_duration;

        $editIsActive = old('edit_schedule_id') == $schedule->id
            ? old('is_active')
            : $schedule->is_active;
    ?>

    <div id="modal-edit-<?php echo e($schedule->id); ?>" class="modal-overlay">

        <div class="modal-panel">

            <div class="mb-4">

                <h2 class="text-base font-bold">
                    تعديل يوم <?php echo e($dayName); ?>

                </h2>

                <p class="mt-1 text-sm text-muted-foreground">
                    تعديل أوقات العمل ومدة الموعد وحالة اليوم.
                </p>

            </div>

            <form
                action="<?php echo e(route('clinic.schedules.update', $schedule->id)); ?>"
                method="POST"
            >

                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <input
                    type="hidden"
                    name="edit_schedule_id"
                    value="<?php echo e($schedule->id); ?>"
                >

                <div class="space-y-4">

                    <div>

                        <label class="field-label">
                            اليوم
                        </label>

                        <input
                            type="text"
                            class="field-input"
                            value="<?php echo e($dayName); ?>"
                            disabled
                        >

                    </div>

                    <div class="grid grid-cols-2 gap-3">

                        <div>

                            <label class="field-label">
                                بداية العمل
                            </label>

                            <input
                                type="time"
                                name="start_time"
                                class="field-input"
                                value="<?php echo e($editStartTime); ?>"
                                required
                            >

                            <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                                <?php if(old('edit_schedule_id') == $schedule->id): ?>

                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>

                                <?php endif; ?>

                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>

                        <div>

                            <label class="field-label">
                                نهاية العمل
                            </label>

                            <input
                                type="time"
                                name="end_time"
                                class="field-input"
                                value="<?php echo e($editEndTime); ?>"
                                required
                            >

                            <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                                <?php if(old('edit_schedule_id') == $schedule->id): ?>

                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span><?php echo e($message); ?></span>
                                    </div>

                                <?php endif; ?>

                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>

                    </div>

                    <div>

                        <label class="field-label">
                            مدة الموعد بالدقائق
                        </label>

                        <input
                            type="number"
                            name="slot_duration"
                            class="field-input"
                            value="<?php echo e($editSlotDuration); ?>"
                            min="5"
                            max="240"
                            step="5"
                            required
                        >

                        <?php $__errorArgs = ['slot_duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                            <?php if(old('edit_schedule_id') == $schedule->id): ?>

                                <div class="field-error">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span><?php echo e($message); ?></span>
                                </div>

                            <?php endif; ?>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                    <div>

                        <label class="flex items-center gap-2">

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                <?php echo e($editIsActive ? 'checked' : ''); ?>

                            >

                            <span>
                                تفعيل اليوم
                            </span>

                        </label>

                        <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                            <?php if(old('edit_schedule_id') == $schedule->id): ?>

                                <div class="field-error">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span><?php echo e($message); ?></span>
                                </div>

                            <?php endif; ?>

                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">

                    <button
                        type="button"
                        class="btn btn-outline"
                        data-modal-close
                    >
                        إلغاء
                    </button>

                    <button
                        type="submit"
                        class="btn btn-default"
                    >
                        حفظ التعديل
                    </button>

                </div>

            </form>

        </div>

    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php
        $dayName = $dayLabels[$schedule->day_of_week];
    ?>

    <div id="modal-delete-<?php echo e($schedule->id); ?>" class="modal-overlay">

        <div class="modal-panel">

            <h2 class="text-base font-bold">
                حذف يوم <?php echo e($dayName); ?>؟
            </h2>

            <p class="mt-2 text-sm text-muted-foreground">
                لن تظهر مواعيد هذا اليوم للحجز الإلكتروني. الحجوزات القائمة لن تُحذف.
            </p>

            <form
                action="<?php echo e(route('clinic.schedules.destroy', $schedule->id)); ?>"
                method="POST"
            >

                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>

                <div class="mt-6 flex justify-end gap-2">

                    <button
                        type="button"
                        class="btn btn-outline"
                        data-modal-close
                    >
                        إلغاء
                    </button>

                    <button
                        type="submit"
                        class="btn btn-destructive"
                    >
                        حذف
                    </button>

                </div>

            </form>

        </div>

    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php if($errors->any()): ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            <?php if(old('edit_schedule_id')): ?>

                const editModal = document.getElementById(
                    'modal-edit-<?php echo e(old('edit_schedule_id')); ?>'
                );

                if (editModal) {
                    editModal.classList.add('open');
                }

            <?php else: ?>

                const newDayModal = document.getElementById('modal-new-day');

                if (newDayModal) {
                    newDayModal.classList.add('open');
                }

            <?php endif; ?>

        });
    </script>

<?php endif; ?>




<?php $__env->stopSection(); ?>


<?php echo $__env->make('doctor.layouts.app_clinc', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/schedules/index.blade.php ENDPATH**/ ?>