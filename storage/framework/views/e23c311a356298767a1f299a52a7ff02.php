<?php $__env->startSection('title', 'مساعدو الطبيب | دليل الأطباء'); ?>

<?php $__env->startPush('extra_style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/doctor/clinic/clinic-assistants.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="w-full min-w-0 px-4 py-6 sm:px-6 lg:px-8">

        <div class="mx-auto w-full max-w-[1360px]">

            <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <h1 class="text-2xl font-bold tracking-tight text-foreground sm:text-3xl">
                        مساعدو الطبيب

                    </h1>

                    <p class="mt-1 text-sm text-muted-foreground">
                        إدارة مساعدي الطبيب وحساباتهم داخل نظام العيادة.
                    </p>

                </div>

                <?php if($assistants->count() < 5): ?>

                    <div class="flex flex-wrap items-center gap-2">

                        <button type="button" class="btn btn-default" data-modal-open="add-assistant-modal">

                            <i data-lucide="user-plus" class="h-4 w-4"></i>

                            إضافة مساعد

                        </button>

                    </div>

                <?php endif; ?>

            </div>


            

            <div id="assistant-edit-panel"
                class="clinic-surface-card mb-6 p-4 sm:p-6 <?php echo e(old('_form') === 'edit' ? '' : 'hidden'); ?>">

                <div class="mb-5 flex items-center justify-between gap-3">

                    <div class="flex items-center gap-3">

                        <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">
                            <i data-lucide="pencil" class="h-5 w-5"></i>
                        </div>

                        <div>

                            <h2 class="text-lg font-bold text-foreground">
                                تعديل بيانات المساعد
                            </h2>

                            <p id="assistant-edit-subtitle" class="mt-0.5 text-sm text-muted-foreground">
                                <?php echo e(old('_form') === 'edit' ? old('name') : ''); ?>

                            </p>

                        </div>

                    </div>

                    <button type="button" class="btn btn-icon" id="assistant-edit-close" title="إغلاق"
                        aria-label="إغلاق">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>

                </div>


                <form method="POST"
                    action="<?php echo e(old('_form') === 'edit' && old('assistant_id') ? route('clinic.assistants.update', old('assistant_id')) : '#'); ?>"
                    id="assistant-edit-form">

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <input type="hidden" name="_form" value="edit">

                    <input type="hidden" name="assistant_id" id="assistant-edit-id"
                        value="<?php echo e(old('_form') === 'edit' ? old('assistant_id') : ''); ?>">

                    <div class="grid gap-4 sm:grid-cols-2">

                        <div>

                            <label class="field-label">
                                الاسم
                            </label>

                            <div class="relative mt-2">

                                <input type="text" name="name" id="assistant-edit-name"
                                    class="field-input pr-10 <?php echo e(old('_form') === 'edit' && $errors->has('name') ? 'border-red-500' : ''); ?>"
                                    value="<?php echo e(old('_form') === 'edit' ? old('name') : ''); ?>">

                            </div>

                            <?php if(old('_form') === 'edit' && $errors->has('name')): ?>
                                <p class="mt-1.5 text-xs text-red-500">
                                    <?php echo e($errors->first('name')); ?>

                                </p>
                            <?php endif; ?>

                        </div>


                        <div>

                            <label class="field-label">
                                البريد الإلكتروني
                            </label>

                            <div class="relative mt-2">

                                <input type="email" name="email" id="assistant-edit-email" dir="ltr"
                                    class="field-input pr-10 <?php echo e(old('_form') === 'edit' && $errors->has('email') ? 'border-red-500' : ''); ?>"
                                    value="<?php echo e(old('_form') === 'edit' ? old('email') : ''); ?>">

                            </div>

                            <?php if(old('_form') === 'edit' && $errors->has('email')): ?>
                                <p class="mt-1.5 text-xs text-red-500">
                                    <?php echo e($errors->first('email')); ?>

                                </p>
                            <?php endif; ?>

                            <p class="mt-1.5 text-[11px] leading-5 text-muted-foreground">
                                عند تغيير البريد يظل البريد الحالي هو المعتمد حتى يضغط المساعد على رابط التأكيد
                                المرسل إلى البريد الجديد.
                            </p>

                        </div>


                        <div>

                            <label class="field-label">
                                رقم الهاتف
                            </label>

                            <div class="relative mt-2">

                                <input type="text" name="phone" id="assistant-edit-phone" inputmode="tel"
                                    dir="ltr"
                                    class="field-input pr-10 <?php echo e(old('_form') === 'edit' && $errors->has('phone') ? 'border-red-500' : ''); ?>"
                                    value="<?php echo e(old('_form') === 'edit' ? old('phone') : ''); ?>">

                            </div>

                            <?php if(old('_form') === 'edit' && $errors->has('phone')): ?>
                                <p class="mt-1.5 text-xs text-red-500">
                                    <?php echo e($errors->first('phone')); ?>

                                </p>
                            <?php endif; ?>

                        </div>


                        <div>

                            <label class="field-label">
                                حالة الحساب
                            </label>

                            <select name="status" id="assistant-edit-status"
                                class="field-select mt-2 <?php echo e(old('_form') === 'edit' && $errors->has('status') ? 'border-red-500' : ''); ?>">

                                <option value="active"
                                    <?php if(old('_form') === 'edit' && old('status') === 'active'): echo 'selected'; endif; ?>>
                                    نشط
                                </option>

                                <option value="inactive"
                                    <?php if(old('_form') === 'edit' && old('status') === 'inactive'): echo 'selected'; endif; ?>>
                                    معطل
                                </option>

                            </select>

                            <?php if(old('_form') === 'edit' && $errors->has('status')): ?>
                                <p class="mt-1.5 text-xs text-red-500">
                                    <?php echo e($errors->first('status')); ?>

                                </p>
                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="mt-5 rounded-xl border border-border p-4">

                        <button type="button" id="assistant-toggle-password"
                            class="flex w-full items-center justify-between gap-3 text-start">

                            <span>

                                <span class="block text-sm font-semibold text-foreground">
                                    تغيير كلمة المرور
                                </span>

                                <span class="mt-1 block text-xs text-muted-foreground">
                                    اترك الحقول فارغة إذا كنت لا تريد تغيير كلمة المرور.
                                </span>

                            </span>

                            <i data-lucide="chevron-down" class="h-4 w-4 shrink-0 assistant-toggle-icon"
                                id="assistant-toggle-password-icon"></i>

                        </button>


                        <div id="assistant-password-fields"
                            class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 <?php echo e(old('_form') === 'edit' && $errors->has('password') ? '' : 'hidden'); ?>">

                            <div>

                                <label class="field-label">
                                    كلمة المرور الجديدة
                                </label>

                                <div class="relative mt-2">

                                    <input type="password" name="password"
                                        id="assistant-edit-password"
                                        class="field-input pr-10 <?php echo e(old('_form') === 'edit' && $errors->has('password') ? 'border-red-500' : ''); ?>"
                                        placeholder="••••••••">

                                    <button type="button" class="password-eye"
                                        data-password-toggle="assistant-edit-password"
                                        aria-label="إظهار كلمة المرور">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>

                                </div>

                                <?php if(old('_form') === 'edit' && $errors->has('password')): ?>
                                    <p class="mt-1.5 text-xs text-red-500">
                                        <?php echo e($errors->first('password')); ?>

                                    </p>
                                <?php endif; ?>

                            </div>


                            <div>

                                <label class="field-label">
                                    تأكيد كلمة المرور
                                </label>

                                <div class="relative mt-2">

                                    <input type="password" name="password_confirmation"
                                        id="assistant-edit-password-confirmation" class="field-input pr-10"
                                        placeholder="••••••••">

                                    <button type="button" class="password-eye"
                                        data-password-toggle="assistant-edit-password-confirmation"
                                        aria-label="إظهار كلمة المرور">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="bq-modal-footer">

                        <button type="button" class="btn btn-ghost" id="assistant-edit-cancel">
                            إلغاء
                        </button>

                        <button type="submit" class="btn btn-default">

                            <i data-lucide="save" class="h-4 w-4"></i>

                            حفظ التعديلات

                        </button>

                    </div>

                </form>

            </div>


            <?php if($assistants->isNotEmpty()): ?>

                
                <div class="mb-6">

                    <div class="clinic-surface-card overflow-hidden">

                        <div
                            class="grid grid-cols-1 divide-y divide-border sm:grid-cols-3 sm:divide-x sm:divide-y-0 sm:divide-x-reverse">

                            <div class="flex items-center gap-3 p-4">

                                <div class="badge-info flex h-9 w-9 shrink-0 items-center justify-center rounded-lg">

                                    <i data-lucide="users-round" class="h-4 w-4"></i>

                                </div>

                                <div>

                                    <p class="text-xs text-muted-foreground">
                                        إجمالي المساعدين
                                    </p>

                                    <div class="mt-0.5 flex items-baseline gap-1.5">

                                        <p class="text-lg font-bold text-foreground">
                                            <?php echo e($assistants->count()); ?>

                                        </p>

                                        <span class="text-xs font-medium text-muted-foreground">
                                            من أصل 5
                                        </span>

                                    </div>

                                    <p class="mt-1 text-[11px] text-muted-foreground">
                                        الحد الأقصى المسموح به 5 مساعدين
                                    </p>

                                </div>

                            </div>


                            <div class="flex items-center gap-3 p-4">

                                <div class="badge-success flex h-9 w-9 shrink-0 items-center justify-center rounded-lg">

                                    <i data-lucide="circle-check-big" class="h-4 w-4"></i>

                                </div>

                                <div>

                                    <p class="text-xs text-muted-foreground">
                                        الحسابات النشطة
                                    </p>

                                    <p class="mt-0.5 text-lg font-bold text-foreground">
                                        <?php echo e($active_assistants); ?>

                                    </p>

                                </div>

                            </div>


                            <div class="flex items-center gap-3 p-4">

                                <div class="badge-danger flex h-9 w-9 shrink-0 items-center justify-center rounded-lg">

                                    <i data-lucide="circle-x" class="h-4 w-4"></i>

                                </div>

                                <div>

                                    <p class="text-xs text-muted-foreground">
                                        الحسابات المعطلة
                                    </p>

                                    <p class="mt-0.5 text-lg font-bold text-foreground">
                                        <?php echo e($assistants->count() - $active_assistants); ?>

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                
                <div class="clinic-surface-card overflow-hidden">

                    <div class="section-card-header">

                        <div>

                            <h2 class="text-lg font-bold text-foreground">
                                قائمة المساعدين
                            </h2>

                            <p class="mt-1 text-sm text-muted-foreground">
                                جميع مساعدي الطبيب المسجلين في النظام.
                            </p>

                        </div>

                        <span class="badge badge-info">

                            <?php echo e($assistants->count()); ?>


                            <?php echo e($assistants->count() == 1 ? 'مساعد' : 'مساعدين'); ?>


                        </span>

                    </div>


                    
                    <div class="hidden overflow-x-auto lg:block">

                        <table class="clinic-table w-full">

                            <thead>

                                <tr>

                                    <th>الاسم</th>

                                    <th>البريد الإلكتروني</th>

                                    <th>رقم الهاتف</th>

                                    <th>تاريخ الإضافة</th>

                                    <th>الحالة</th>

                                    <th class="text-center">
                                        إجراءات
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php $__currentLoopData = $assistants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assistant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>

                                        <td>

                                            <div class="flex min-w-[180px] items-center gap-3">

                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-soft text-sm font-bold text-primary">

                                                    <?php echo e(mb_substr($assistant->user?->name ?? 'مساعد', 0, 2)); ?>


                                                </div>

                                                <div class="min-w-0">

                                                    <div class="truncate font-semibold text-foreground">
                                                        <?php echo e($assistant->user?->name ?? 'لا يوجد اسم للمساعد'); ?>

                                                    </div>

                                                    <div class="mt-0.5 text-xs text-muted-foreground">
                                                        مساعد طبيب
                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        <td>

                                            <span class="whitespace-nowrap text-sm text-foreground">
                                                <?php echo e($assistant->user?->email ?? 'لا يوجد بريد إلكتروني للمساعد'); ?>

                                            </span>

                                            <?php if($assistant->user?->hasValidPendingEmail()): ?>

                                                <div class="max-w-[290px]">

                                                    <div class="assistant-pending-email">

                                                        <i data-lucide="mail-check"
                                                            class="assistant-pending-icon h-4 w-4"></i>

                                                        <div class="min-w-0">

                                                            <p class="text-xs font-bold text-foreground">
                                                                في انتظار تأكيد البريد الجديد
                                                            </p>

                                                            <p class="assistant-pending-address text-xs font-semibold text-foreground"
                                                                dir="ltr">
                                                                <?php echo e($assistant->user->pending_email); ?>

                                                            </p>

                                                            <p class="text-[11px] leading-5 text-muted-foreground">
                                                                لن يتغير بريد المساعد الحالي إلا بعد أن يفتح الرسالة
                                                                المرسلة إلى هذا البريد ويضغط على رابط التأكيد.
                                                            </p>

                                                            <p class="assistant-pending-time text-[11px]">
                                                                <i data-lucide="clock" class="h-3 w-3"></i>
                                                                ينتهي الطلب
                                                                <?php echo e($assistant->user->pending_email_requested_at->copy()->addMinutes(\App\Models\User::PENDING_EMAIL_TTL_MINUTES)->diffForHumans()); ?>

                                                            </p>

                                                        </div>

                                                    </div>

                                                </div>

                                            <?php endif; ?>

                                        </td>


                                        <td>

                                            <span class="whitespace-nowrap text-sm text-foreground" dir="ltr">
                                                <?php echo e($assistant->phone ?? 'لا يوجد رقم هاتف للمساعد'); ?>

                                            </span>

                                        </td>


                                        <td>

                                            <span class="whitespace-nowrap text-sm text-muted-foreground">
                                                <?php echo e($assistant->created_at?->format('Y-m-d') ?? 'لا يوجد تاريخ إضافة'); ?>

                                            </span>

                                        </td>


                                        <td>

                                            <?php if($assistant->is_active): ?>

                                                <span class="badge badge-success">
                                                    نشط
                                                </span>

                                            <?php else: ?>

                                                <span class="badge badge-danger">
                                                    معطل
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <td>

                                            <div class="flex items-center justify-center gap-1.5">

                                                <button type="button" class="btn btn-icon-sm" title="تعديل"
                                                    data-edit-assistant
                                                    data-id="<?php echo e($assistant->id); ?>"
                                                    data-name="<?php echo e($assistant->user?->name); ?>"
                                                    data-email="<?php echo e($assistant->user?->email); ?>"
                                                    data-phone="<?php echo e($assistant->phone); ?>"
                                                    data-status="<?php echo e($assistant->is_active ? 'active' : 'inactive'); ?>">

                                                    <i data-lucide="pencil" class="h-4 w-4"></i>

                                                </button>


                                                <form method="POST"
                                                    action="<?php echo e(route('clinic.assistants.toggle-status', $assistant)); ?>"
                                                    onsubmit="return confirm('<?php echo e($assistant->is_active ? 'هل تريد تعطيل حساب هذا المساعد؟' : 'هل تريد تفعيل حساب هذا المساعد؟'); ?>')">

                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>

                                                    <button type="submit" class="btn btn-icon-sm"
                                                        title="<?php echo e($assistant->is_active ? 'تعطيل الحساب' : 'تفعيل الحساب'); ?>">

                                                        <i data-lucide="<?php echo e($assistant->is_active ? 'power-off' : 'power'); ?>"
                                                            class="h-4 w-4"></i>

                                                    </button>

                                                </form>


                                                <button type="button" class="btn btn-icon-sm text-destructive"
                                                    title="حذف"
                                                    data-delete-assistant
                                                    data-id="<?php echo e($assistant->id); ?>"
                                                    data-name="<?php echo e($assistant->user?->name); ?>">

                                                    <i data-lucide="trash-2" class="h-4 w-4"></i>

                                                </button>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>

                        </table>

                    </div>


                    
                    <div class="grid gap-3 p-4 lg:hidden">

                        <?php $__currentLoopData = $assistants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assistant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="clinic-surface-card border border-border p-4">

                                <div class="flex items-start justify-between gap-3">

                                    <div class="flex min-w-0 items-center gap-3">

                                        <div
                                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-soft text-sm font-bold text-primary">

                                            <?php echo e(mb_substr($assistant->user?->name ?? 'مساعد', 0, 2)); ?>


                                        </div>

                                        <div class="min-w-0">

                                            <h3 class="truncate font-bold text-foreground">
                                                <?php echo e($assistant->user?->name ?? 'لا يوجد اسم للمساعد'); ?>

                                            </h3>

                                            <p class="mt-0.5 text-xs text-muted-foreground">
                                                مساعد طبيب
                                            </p>

                                        </div>

                                    </div>


                                    <?php if($assistant->is_active): ?>

                                        <span class="badge badge-success shrink-0">
                                            نشط
                                        </span>

                                    <?php else: ?>

                                        <span class="badge badge-danger shrink-0">
                                            معطل
                                        </span>

                                    <?php endif; ?>

                                </div>


                                <div class="mt-4 grid grid-cols-1 gap-3">

                                    <div class="rounded-xl bg-muted p-3">

                                        <p class="text-xs text-muted-foreground">
                                            البريد الإلكتروني
                                        </p>

                                        <p class="mt-1 truncate text-sm font-semibold text-foreground">
                                            <?php echo e($assistant->user?->email ?? 'لا يوجد بريد إلكتروني للمساعد'); ?>

                                        </p>

                                        <?php if($assistant->user?->hasValidPendingEmail()): ?>

                                            <div class="assistant-pending-email">

                                                <i data-lucide="mail-check"
                                                    class="assistant-pending-icon h-4 w-4"></i>

                                                <div class="min-w-0">

                                                    <p class="text-xs font-bold text-foreground">
                                                        في انتظار تأكيد البريد الجديد
                                                    </p>

                                                    <p class="assistant-pending-address text-xs font-semibold text-foreground"
                                                        dir="ltr">
                                                        <?php echo e($assistant->user->pending_email); ?>

                                                    </p>

                                                    <p class="text-[11px] leading-5 text-muted-foreground">
                                                        لن يتغير بريد المساعد الحالي إلا بعد أن يفتح الرسالة
                                                        المرسلة إلى هذا البريد ويضغط على رابط التأكيد.
                                                    </p>

                                                    <p class="assistant-pending-time text-[11px]">
                                                        <i data-lucide="clock" class="h-3 w-3"></i>
                                                        ينتهي الطلب
                                                        <?php echo e($assistant->user->pending_email_requested_at->copy()->addMinutes(\App\Models\User::PENDING_EMAIL_TTL_MINUTES)->diffForHumans()); ?>

                                                    </p>

                                                </div>

                                            </div>

                                        <?php endif; ?>

                                    </div>


                                    <div class="grid grid-cols-2 gap-3">

                                        <div class="rounded-xl bg-muted p-3">

                                            <p class="text-xs text-muted-foreground">
                                                رقم الهاتف
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-foreground" dir="ltr">
                                                <?php echo e($assistant->phone ?? 'لا يوجد رقم هاتف للمساعد'); ?>

                                            </p>

                                        </div>


                                        <div class="rounded-xl bg-muted p-3">

                                            <p class="text-xs text-muted-foreground">
                                                تاريخ الإضافة
                                            </p>

                                            <p class="mt-1 text-sm font-semibold text-foreground">
                                                <?php echo e($assistant->created_at?->format('Y-m-d') ?? 'لا يوجد تاريخ إضافة'); ?>

                                            </p>

                                        </div>

                                    </div>

                                </div>


                                <div class="mt-3 flex items-center gap-2 border-t border-border pt-3">

                                    <button type="button" class="btn btn-outline btn-sm w-full"
                                        data-edit-assistant
                                        data-id="<?php echo e($assistant->id); ?>"
                                        data-name="<?php echo e($assistant->user?->name); ?>"
                                        data-email="<?php echo e($assistant->user?->email); ?>"
                                        data-phone="<?php echo e($assistant->phone); ?>"
                                        data-status="<?php echo e($assistant->is_active ? 'active' : 'inactive'); ?>">

                                        <i data-lucide="pencil" class="h-4 w-4"></i>

                                        تعديل

                                    </button>


                                    <form method="POST" class="w-full"
                                        action="<?php echo e(route('clinic.assistants.toggle-status', $assistant)); ?>"
                                        onsubmit="return confirm('<?php echo e($assistant->is_active ? 'هل تريد تعطيل حساب هذا المساعد؟' : 'هل تريد تفعيل حساب هذا المساعد؟'); ?>')">

                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>

                                        <button type="submit" class="btn btn-outline btn-sm w-full">

                                            <i data-lucide="<?php echo e($assistant->is_active ? 'power-off' : 'power'); ?>"
                                                class="h-4 w-4"></i>

                                            <?php echo e($assistant->is_active ? 'تعطيل' : 'تفعيل'); ?>


                                        </button>

                                    </form>


                                    <button type="button" class="btn btn-destructive btn-sm w-full"
                                        data-delete-assistant
                                        data-id="<?php echo e($assistant->id); ?>"
                                        data-name="<?php echo e($assistant->user?->name); ?>">

                                        <i data-lucide="trash-2" class="h-4 w-4"></i>

                                        حذف

                                    </button>

                                </div>

                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                </div>

            <?php else: ?>

                
                <div class="clinic-surface-card overflow-hidden">

                    <div class="p-4 sm:p-5">

                        <?php if (isset($component)) { $__componentOriginal0b5ccf9b11eebc2718e227842e6d306f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0b5ccf9b11eebc2718e227842e6d306f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.home.banner.no_results','data' => ['logo' => 'fa-solid fa-user-nurse','title' => 'لا يوجد مساعدين حتى الآن','content' => 'لم تقم بإضافة أي مساعدين لعيادتك حتى الآن.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('home.banner.no_results'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => 'fa-solid fa-user-nurse','title' => 'لا يوجد مساعدين حتى الآن','content' => 'لم تقم بإضافة أي مساعدين لعيادتك حتى الآن.']); ?>
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

                        <div class="mt-4 flex justify-center">

                            <button type="button" class="btn btn-default" data-modal-open="add-assistant-modal">

                                <i data-lucide="user-round-plus" class="h-4 w-4"></i>

                                إضافة أول مساعد

                            </button>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>




<div id="add-assistant-modal" class="modal-overlay <?php echo e($errors->assistantAdd->any() ? 'active' : ''); ?>">

    <div class="modal-panel modal-lg">

        <div class="bq-modal-header">

            <div>

                <h3 class="text-lg font-bold text-foreground">
                    إضافة مساعد جديد
                </h3>

                <p class="mt-1 text-sm text-muted-foreground">
                    أنشئ حسابًا جديدًا لمساعد الطبيب للوصول إلى نظام العيادة.
                </p>

            </div>

            <button type="button" class="btn btn-icon" data-modal-close>
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>

        </div>


        <form method="POST"
            action="<?php echo e(route('clinic.assistants.store')); ?>"
            id="add-assistant-form">

            <?php echo csrf_field(); ?>

            <input type="hidden" name="_form" value="add">


            <div>

                <label class="field-label">
                    الاسم الكامل
                </label>

                <div class="relative mt-2">

                    <input type="text"
                        name="name"
                        class="field-input pr-10 <?php echo e($errors->assistantAdd->has('name') ? 'border-red-500' : ''); ?>"
                        placeholder="اكتب الاسم الكامل"
                        value="<?php echo e(old('_form') === 'add' ? old('name') : ''); ?>">

                </div>

                <?php if($errors->assistantAdd->has('name')): ?>
                    <p class="mt-1.5 text-xs text-red-500">
                        <?php echo e($errors->assistantAdd->first('name')); ?>

                    </p>
                <?php endif; ?>

            </div>


            <div class="mt-4">

                <label class="field-label">
                    البريد الإلكتروني
                </label>

                <div class="relative mt-2">

                    <input type="email"
                        name="email"
                        dir="ltr"
                        class="field-input pr-10 <?php echo e($errors->assistantAdd->has('email') ? 'border-red-500' : ''); ?>"
                        placeholder="example@mail.com"
                        value="<?php echo e(old('_form') === 'add' ? old('email') : ''); ?>">

                </div>

                <?php if($errors->assistantAdd->has('email')): ?>
                    <p class="mt-1.5 text-xs text-red-500">
                        <?php echo e($errors->assistantAdd->first('email')); ?>

                    </p>
                <?php endif; ?>

            </div>


            <div class="mt-4">

                <label class="field-label">
                    رقم الهاتف
                </label>

                <div class="relative mt-2">

                    <input type="text"
                        name="phone"
                        inputmode="tel"
                        dir="ltr"
                        maxlength="11"
                        class="field-input pr-10 <?php echo e($errors->assistantAdd->has('phone') ? 'border-red-500' : ''); ?>"
                        placeholder="01xxxxxxxxx"
                        value="<?php echo e(old('_form') === 'add' ? old('phone') : ''); ?>">

                </div>

                <?php if($errors->assistantAdd->has('phone')): ?>
                    <p class="mt-1.5 text-xs text-red-500">
                        <?php echo e($errors->assistantAdd->first('phone')); ?>

                    </p>
                <?php endif; ?>

            </div>


            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div>

                    <label class="field-label">
                        كلمة المرور
                    </label>

                    <div class="relative mt-2">

                        <input type="password"
                            name="password"
                            id="assistant-add-password"
                            class="field-input pr-10 <?php echo e($errors->assistantAdd->has('password') ? 'border-red-500' : ''); ?>"
                            placeholder="••••••••">

                        <button type="button" class="password-eye"
                            data-password-toggle="assistant-add-password"
                            aria-label="إظهار كلمة المرور">
                            <i data-lucide="eye" class="h-4 w-4"></i>
                        </button>

                    </div>

                    <?php if($errors->assistantAdd->has('password')): ?>
                        <p class="mt-1.5 text-xs text-red-500">
                            <?php echo e($errors->assistantAdd->first('password')); ?>

                        </p>
                    <?php endif; ?>

                </div>


                <div>

                    <label class="field-label">
                        تأكيد كلمة المرور
                    </label>

                    <div class="relative mt-2">

                        <input type="password"
                            name="password_confirmation"
                            id="assistant-add-password-confirmation"
                            class="field-input pr-10"
                            placeholder="••••••••">

                        <button type="button" class="password-eye"
                            data-password-toggle="assistant-add-password-confirmation"
                            aria-label="إظهار كلمة المرور">
                            <i data-lucide="eye" class="h-4 w-4"></i>
                        </button>

                    </div>

                </div>

            </div>


            <div class="bq-modal-footer">

                <button type="button"
                    class="btn btn-ghost"
                    data-modal-close>
                    إلغاء
                </button>

                <button type="submit" class="btn btn-default">

                    <i data-lucide="user-plus" class="h-4 w-4"></i>

                    إضافة المساعد

                </button>

            </div>

        </form>

    </div>

</div>

    
    <div id="delete-assistant-modal" class="modal-overlay">

        <div class="modal-panel max-w-lg">

            <div class="bq-modal-header">

                <div>

                    <h3 class="text-lg font-bold text-foreground">
                        حذف المساعد؟
                    </h3>

                </div>

                <button type="button" class="btn btn-icon" data-modal-close>

                    <i data-lucide="x" class="h-5 w-5"></i>

                </button>

            </div>


            <div class="rounded-xl border border-destructive/20 bg-destructive/5 p-4">

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-destructive/10 text-destructive">

                        <i data-lucide="triangle-alert" class="h-5 w-5"></i>

                    </div>

                    <div>

                        <p class="font-semibold text-foreground">
                            تأكيد حذف
                            <span id="delete-assistant-name"></span>
                        </p>

                        <p class="mt-1 text-sm leading-6 text-muted-foreground">
                            سيتم حذف حساب هذا المساعد نهائيًا ولن يتمكن من الوصول إلى نظام العيادة بعد ذلك، ولا يمكن
                            التراجع عن هذا الإجراء.
                        </p>

                    </div>

                </div>

            </div>


            <form id="delete-assistant-form" method="POST">

                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>

                <div class="bq-modal-footer">

                    <button type="button" class="btn btn-ghost" data-modal-close>
                        إلغاء
                    </button>

                    <button type="submit" class="btn btn-destructive">

                        <i data-lucide="trash-2" class="h-4 w-4"></i>

                        حذف المساعد

                    </button>

                </div>

            </form>

        </div>

    </div>


    <?php $__env->startPush('extra_java'); ?>

<script>
    window.AssistantsPageConfig = {
        updateUrlTemplate: <?php echo json_encode(route('clinic.assistants.update', ['assistant' => '__ASSISTANT_ID__']), 512) ?>,
        destroyUrlTemplate: <?php echo json_encode(route('clinic.assistants.destroy', ['assistant' => '__ASSISTANT_ID__']), 512) ?>,
        reopenEdit: <?php echo json_encode(old('_form') === 'edit', 15, 512) ?>,
        reopenAdd: <?php echo json_encode($errors->assistantAdd->any(), 15, 512) ?>,
    };
</script>

        <script src="<?php echo e(asset('js/clinic/assistants.js')); ?>"></script>

    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('doctor.layouts.app_clinc', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/assistants/index.blade.php ENDPATH**/ ?>