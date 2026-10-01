{{-- resources/views/settings/sections/personal.blade.php --}}

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


    {{-- Email Verification --}}

    <form id="send-verification"
          method="post"
          action="{{ route('verification.send') }}">

        @csrf

    </form>


    {{-- Profile Update --}}

    <form method="post"
          action="{{ route('profile.update') }}"
          class="settings-form">

        @csrf
        @method('patch')


        {{-- Name --}}

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
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name">

            </div>

            <x-input-error
                class="settings-error"
                :messages="$errors->get('name')" />

        </div>


        {{-- Email --}}

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
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="username">

            </div>

            <x-input-error
                class="settings-error"
                :messages="$errors->get('email')" />


            {{-- Pending Email --}}

            @if ($user->hasValidPendingEmail())

                <div class="pending-email-box">

                    <div class="pending-email-icon">
                        <i class="fa-solid fa-envelope-circle-check"></i>
                    </div>

                    <div class="pending-email-content">

                        <strong>
                            في انتظار تأكيد البريد الجديد
                        </strong>

                        <span class="pending-email-address" dir="ltr">
                            {{ $user->pending_email }}
                        </span>

                        <p>
                            أرسلنا رابط تأكيد إلى هذا البريد. افتح الرسالة واضغط على الرابط
                            لتأكيد أن البريد يخصك، وبعدها يتغير بريد حسابك.
                            يظل بريدك الحالي هو المعتمد حتى ذلك الحين.
                        </p>

                        <small>
                            <i class="fa-regular fa-clock"></i>
                            ينتهي الطلب
                            {{ $user->pending_email_requested_at->copy()->addMinutes(\App\Models\User::PENDING_EMAIL_TTL_MINUTES)->diffForHumans() }}
                        </small>

                    </div>

                </div>

            @endif


            @if (
                $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
                && ! $user->hasVerifiedEmail()
            )

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


                @if (session('status') === 'verification-link-sent')

                    <div class="verification-success">

                        <i class="fa-solid fa-circle-check"></i>

                        تم إرسال رابط تفعيل جديد إلى بريدك الإلكتروني.

                    </div>

                @endif

            @endif

        </div>


        {{-- Actions --}}

        <div class="settings-form-actions">

            <button type="submit"
                    class="settings-primary-button">

                <i class="fa-solid fa-floppy-disk"></i>

                حفظ التعديلات

            </button>

            @if (session('status') === 'profile-updated')

                <span class="settings-success">

                    <i class="fa-solid fa-circle-check"></i>

                    تم حفظ البيانات بنجاح

                </span>

            @endif

        </div>

    </form>

</div>
