
{{-- resources/views/settings/sections/password.blade.php --}}

<div class="profile-form">

    <div class="profile-form-header">

        <div>

            <h2>
                تغيير كلمة المرور
            </h2>

            <p>
                حافظ على أمان حسابك باستخدام كلمة مرور قوية.
            </p>

        </div>

    </div>


    <form method="post"
          action="{{ route('password.update') }}"
          class="settings-form">

        @csrf
        @method('put')


        {{-- Current Password --}}

        <div class="settings-field">

            <label for="update_password_current_password">
                كلمة المرور الحالية
            </label>

            <div class="settings-input-wrapper">

                <i class="fa-solid fa-lock"></i>

                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    autocomplete="current-password"
                    required>

            </div>

            <x-input-error
                class="settings-error"
                :messages="$errors->get('current_password')" />

        </div>


        {{-- New Password --}}

        <div class="settings-field">

            <label for="update_password_password">
                كلمة المرور الجديدة
            </label>

            <div class="settings-input-wrapper">

                <i class="fa-solid fa-key"></i>

                <input
                    id="update_password_password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    required>

            </div>

            <x-input-error
                class="settings-error"
                :messages="$errors->get('password')" />

        </div>


        {{-- Confirmation --}}

        <div class="settings-field">

            <label for="update_password_password_confirmation">
                تأكيد كلمة المرور الجديدة
            </label>

            <div class="settings-input-wrapper">

                <i class="fa-solid fa-shield-halved"></i>

                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    required>

            </div>

            <x-input-error
                class="settings-error"
                :messages="$errors->get('password_confirmation')" />

        </div>


        <div class="password-security-note">

            <div class="password-security-icon">

                <i class="fa-solid fa-shield-heart"></i>

            </div>

            <div>

                <strong>
                    حافظ على أمان حسابك
                </strong>

                <p>
                    استخدم كلمة مرور طويلة وفريدة ولا تشاركها مع أي شخص.
                </p>

            </div>

        </div>


        <div class="settings-form-actions">

            <button type="submit"
                    class="settings-primary-button">

                <i class="fa-solid fa-key"></i>

                تحديث كلمة المرور

            </button>

            @if (session('status') === 'password-updated')

                <span class="settings-success">

                    <i class="fa-solid fa-circle-check"></i>

                    تم تحديث كلمة المرور بنجاح

                </span>

            @endif

        </div>

    </form>

</div>

