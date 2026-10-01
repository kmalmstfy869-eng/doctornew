
{{-- resources/views/settings/sections/delete-account.blade.php --}}

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


    <x-modal
        name="confirm-user-deletion"
        :show="$errors->userDeletion->isNotEmpty()"
        focusable>

        <form
            method="post"
            action="{{ route('profile.destroy') }}"
            class="delete-modal-form">

            @csrf
            @method('delete')


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

                <x-input-error
                    :messages="$errors->userDeletion->get('password')"
                    class="settings-error" />

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

    </x-modal>

</div>

