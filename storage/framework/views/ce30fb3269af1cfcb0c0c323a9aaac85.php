


<div class="profile-form">

    <div class="profile-form-header">

        <div>

            <h2>
                حذف الحساب
            </h2>

            <p>
                بمجرد حذف حسابك، سيتم حذف جميع بياناتك ومواردك نهائيًا.
                تأكد من الاحتفاظ بأي بيانات تحتاج إليها قبل المتابعة.
            </p>

        </div>

    </div>


    <div class="delete-warning-box">

        <div class="delete-warning-icon">

            <i class="fa-solid fa-triangle-exclamation"></i>

        </div>

        <div>

            <h3>
                انتبه قبل حذف الحساب
            </h3>

            <p>
                لا يمكن التراجع عن هذه العملية بعد تأكيد حذف الحساب.
            </p>

        </div>

    </div>


    <div class="profile-form-actions">

        <button
            type="button"
            class="settings-danger-button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">

            <i class="fa-solid fa-trash"></i>

            حذف الحساب

        </button>

    </div>


    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'confirm-user-deletion','show' => $errors->userDeletion->isNotEmpty(),'focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'confirm-user-deletion','show' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->userDeletion->isNotEmpty()),'focusable' => true]); ?>

        <form
            method="post"
            action="<?php echo e(route('profile.destroy')); ?>"
            class="delete-modal-form">

            <?php echo csrf_field(); ?>
            <?php echo method_field('delete'); ?>


            <div class="delete-modal-icon">

                <i class="fa-solid fa-user-xmark"></i>

            </div>


            <h2>
                هل أنت متأكد من حذف حسابك؟
            </h2>


            <p>
                سيتم حذف حسابك وجميع البيانات المرتبطة به نهائيًا.
                أدخل كلمة المرور لتأكيد عملية الحذف.
            </p>


            <div class="settings-field">

                <label for="password">
                    كلمة المرور
                </label>

                <div class="settings-input-wrapper">

                    <i class="fa-solid fa-lock"></i>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        placeholder="أدخل كلمة المرور">

                </div>

                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->userDeletion->get('password'),'class' => 'settings-error']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->userDeletion->get('password')),'class' => 'settings-error']); ?>
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


            <div class="delete-modal-actions">

                <button
                    type="button"
                    class="settings-secondary-button"
                    x-on:click="$dispatch('close')">

                    إلغاء

                </button>


                <button
                    type="submit"
                    class="settings-danger-button">

                    <i class="fa-solid fa-trash"></i>

                    حذف الحساب

                </button>

            </div>

        </form>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>

</div>

<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/settings/sections/delete-account.blade.php ENDPATH**/ ?>