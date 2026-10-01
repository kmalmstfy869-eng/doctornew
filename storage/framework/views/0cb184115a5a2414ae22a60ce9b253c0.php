

<div class="profile-form">

    <div class="profile-form-header">

        <div>
            <h2>
                البيانات الشخصية
            </h2>

            <p>
                تحديث اسم الحساب والبريد الإلكتروني.
            </p>
        </div>

    </div>


    

    <form id="send-verification"
          method="post"
          action="<?php echo e(route('verification.send')); ?>">

        <?php echo csrf_field(); ?>

    </form>


    

    <form method="post"
          action="<?php echo e(route('profile.update')); ?>"
          class="settings-form">

        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>


        

        <div class="settings-field">

            <label for="name">
                الاسم
            </label>

            <div class="settings-input-wrapper">

                <i class="fa-solid fa-user"></i>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="<?php echo e(old('name', $user->name)); ?>"
                    required
                    autofocus
                    autocomplete="name">

            </div>

            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'settings-error','messages' => $errors->get('name')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'settings-error','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('name'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>

        </div>


        

        <div class="settings-field">

            <label for="email">
                البريد الإلكتروني
            </label>

            <div class="settings-input-wrapper">

                <i class="fa-solid fa-envelope"></i>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="<?php echo e(old('email', $user->email)); ?>"
                    required
                    autocomplete="username">

            </div>

            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'settings-error','messages' => $errors->get('email')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'settings-error','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>


            

            <?php if($user->hasValidPendingEmail()): ?>

                <div class="pending-email-box">

                    <div class="pending-email-icon">
                        <i class="fa-solid fa-envelope-circle-check"></i>
                    </div>

                    <div class="pending-email-content">

                        <strong>
                            في انتظار تأكيد البريد الجديد
                        </strong>

                        <span class="pending-email-address" dir="ltr">
                            <?php echo e($user->pending_email); ?>

                        </span>

                        <p>
                            أرسلنا رابط تأكيد إلى هذا البريد. افتح الرسالة واضغط على الرابط
                            لتأكيد أن البريد يخصك، وبعدها يتغير بريد حسابك.
                            يظل بريدك الحالي هو المعتمد حتى ذلك الحين.
                        </p>

                        <small>
                            <i class="fa-regular fa-clock"></i>
                            ينتهي الطلب
                            <?php echo e($user->pending_email_requested_at->copy()->addMinutes(\App\Models\User::PENDING_EMAIL_TTL_MINUTES)->diffForHumans()); ?>

                        </small>

                    </div>

                </div>

            <?php endif; ?>


            <?php if(
                $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
                && ! $user->hasVerifiedEmail()
            ): ?>

                <div class="verification-box">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <div>

                        <p>
                            البريد الإلكتروني غير مُفعّل.
                        </p>

                        <button
                            form="send-verification"
                            class="verification-button">

                            إعادة إرسال رابط التفعيل

                        </button>

                    </div>

                </div>


                <?php if(session('status') === 'verification-link-sent'): ?>

                    <div class="verification-success">

                        <i class="fa-solid fa-circle-check"></i>

                        تم إرسال رابط تفعيل جديد إلى بريدك الإلكتروني.

                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </div>


        

        <div class="settings-form-actions">

            <button type="submit"
                    class="settings-primary-button">

                <i class="fa-solid fa-floppy-disk"></i>

                حفظ التعديلات

            </button>

            <?php if(session('status') === 'profile-updated'): ?>

                <span class="settings-success">

                    <i class="fa-solid fa-circle-check"></i>

                    تم حفظ البيانات بنجاح

                </span>

            <?php endif; ?>

        </div>

    </form>

</div>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/settings/sections/personal.blade.php ENDPATH**/ ?>