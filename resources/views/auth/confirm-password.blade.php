@extends('home.layout.app')

@section('title', 'تأكيد كلمة المرور | دليل الأطباء')

@section('content')

<div class="doctor-confirm-page">

    <div class="doctor-confirm-bg-circle doctor-confirm-circle-one"></div>
    <div class="doctor-confirm-bg-circle doctor-confirm-circle-two"></div>

    <main class="doctor-confirm-main">

        <div class="doctor-confirm-card">

            <!-- ICON -->

            <div class="doctor-confirm-icon">

                <svg viewBox="0 0 24 24" fill="none">

                    <rect
                        x="5"
                        y="10"
                        width="14"
                        height="10"
                        rx="2"
                        stroke="currentColor"
                        stroke-width="1.7"
                    />

                    <path
                        d="M8 10V7C8 4.8 9.8 3 12 3C14.2 3 16 4.8 16 7V10"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                    />

                    <path
                        d="M12 14V16"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                    />

                </svg>

            </div>


            <!-- TITLE -->

            <h1>
                تأكيد كلمة المرور
            </h1>

            <p class="doctor-confirm-description">

                هذه منطقة آمنة من الموقع.
                للتأكيد أنك صاحب الحساب، يرجى إدخال كلمة المرور
                قبل المتابعة.

            </p>


            <!-- FORM -->

            <form
                method="POST"
                action="{{ route('password.confirm') }}"
                class="doctor-confirm-form"
            >

                @csrf


                <div class="doctor-confirm-field">

                    <label for="doctorConfirmPassword">
                        كلمة المرور
                    </label>

                    <div class="doctor-confirm-input">

                        <span class="doctor-confirm-input-icon">

                            <svg viewBox="0 0 24 24" fill="none">

                                <rect
                                    x="5"
                                    y="10"
                                    width="14"
                                    height="10"
                                    rx="2"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                />

                                <path
                                    d="M8 10V7C8 4.8 9.8 3 12 3C14.2 3 16 4.8 16 7V10"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                />

                            </svg>

                        </span>


                        <input
                            type="password"
                            id="doctorConfirmPassword"
                            name="password"
                            placeholder="أدخل كلمة المرور"
                            autocomplete="current-password"
                            required
                            autofocus
                        />

                        <button
                            type="button"
                            class="doctor-confirm-password-toggle"
                            id="doctorConfirmTogglePassword"
                            aria-label="إظهار كلمة المرور"
                        >

                            <svg viewBox="0 0 24 24" fill="none">

                                <path
                                    d="M2.5 12C4.5 8 8 6 12 6C16 6 19.5 8 21.5 12C19.5 16 16 18 12 18C8 18 4.5 16 2.5 12Z"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="2.5"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                />

                            </svg>

                        </button>

                    </div>


                    @error('password')

                        <div class="doctor-register-auth-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <button
                    type="submit"
                    class="doctor-confirm-button"
                >

                    تأكيد كلمة المرور

                    <svg viewBox="0 0 24 24" fill="none">

                        <path
                            d="M5 12H19"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />

                        <path
                            d="M13 6L19 12L13 18"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                    </svg>

                </button>

            </form>


            <!-- SECURITY -->

            <div class="doctor-confirm-security">

                <div class="doctor-confirm-security-icon">

                    <svg viewBox="0 0 24 24" fill="none">

                        <path
                            d="M12 21C12 21 19 17.5 19 11V5.5L12 3L5 5.5V11C5 17.5 12 21 12 21Z"
                            stroke="currentColor"
                            stroke-width="1.7"
                        />

                        <path
                            d="M9 12L11 14L15 10"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                        />

                    </svg>

                </div>

                <p>
                    كلمة المرور تستخدم للتحقق من هويتك
                    وحماية إعدادات حسابك.
                </p>

            </div>

        </div>

    </main>

</div>

@endsection
