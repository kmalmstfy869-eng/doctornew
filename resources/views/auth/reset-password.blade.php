@extends('home.layout.app')

@section('title', 'إعادة تعيين كلمة المرور | دليل الأطباء')

@section('content')

    <div class="doctor-forgot-page">

        <!-- =========================================
             BACKGROUND
        ========================================== -->

        <div class="doctor-forgot-bg-circle doctor-forgot-circle-one"></div>
        <div class="doctor-forgot-bg-circle doctor-forgot-circle-two"></div>
        <div class="doctor-forgot-bg-circle doctor-forgot-circle-three"></div>


        <!-- =========================================
             MAIN
        ========================================== -->

        <main class="doctor-forgot-main">

            <div class="doctor-forgot-wrapper">


                <!-- =========================================
                     CREATIVE PANEL
                ========================================== -->

                <section class="doctor-forgot-creative">

                    <div class="doctor-forgot-creative-content">


                        <div class="doctor-forgot-security-badge">

                            <span></span>

                            حماية حسابك أولويتنا

                        </div>


                        <div class="doctor-forgot-creative-title">

                            <h2>

                                كلمة مرور جديدة،

                                <br>

                                <span>
                                    وحسابك أكثر أمانًا
                                </span>

                            </h2>


                            <p>

                                اختر كلمة مرور قوية وجديدة لحماية
                                حسابك والاستمرار في استخدام منصة
                                دليل الأطباء بأمان.

                            </p>

                        </div>


                        <!-- LOCK -->

                        <div class="doctor-forgot-lock-area">

                            <div class="doctor-forgot-lock-glow"></div>


                            <span class="doctor-forgot-floating-dot doctor-forgot-dot-one">
                            </span>


                            <span class="doctor-forgot-floating-dot doctor-forgot-dot-two">
                            </span>


                            <span class="doctor-forgot-floating-dot doctor-forgot-dot-three">
                            </span>


                            <div class="doctor-forgot-lock">

                                <svg viewBox="0 0 24 24" fill="none">

                                    <path d="M7 10V7.5C7 4.74 9.24 2.5 12 2.5C14.76 2.5 17 4.74 17 7.5V10"
                                        stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />

                                    <rect x="4" y="10" width="16" height="11" rx="2.5" stroke="currentColor"
                                        stroke-width="1.7" />

                                    <circle cx="12" cy="15.5" r="1.3" fill="currentColor" />

                                </svg>

                            </div>

                        </div>

                    </div>

                </section>



                <!-- =========================================
                     RESET FORM
                ========================================== -->

                <section class="doctor-forgot-form-panel">

                    <div class="doctor-forgot-form-container">


                        <!-- ICON -->

                        <div class="doctor-forgot-form-icon">

                            <svg viewBox="0 0 24 24" fill="none">

                                <rect x="4" y="5" width="16" height="14" rx="2" stroke="currentColor"
                                    stroke-width="1.7" />

                                <path d="M8 11L10.5 13.5L16 8" stroke="currentColor" stroke-width="1.7"
                                    stroke-linecap="round" stroke-linejoin="round" />

                            </svg>

                        </div>



                        <!-- HEADER -->

                        <div class="doctor-forgot-form-header">

                            <h1>
                                إعادة تعيين كلمة المرور
                            </h1>


                            <p>

                                أدخل كلمة المرور الجديدة لحسابك،
                                ثم أكدها مرة أخرى لإتمام عملية التغيير.

                            </p>

                        </div>



                        <!-- FORM -->

                        <form method="POST" action="{{ route('password.store') }}" id="doctorResetPasswordForm">

                            @csrf


                            <!-- =====================================
                                 TOKEN
                            ====================================== -->
                            <input type="hidden" name="token" value="{{ $request->token }}">



                            <!-- =====================================
                                 EMAIL
                            ====================================== -->

                            <div class="doctor-forgot-email-group">

                                <label for="doctorResetEmail">

                                    البريد الإلكتروني

                                </label>


                                <div class="doctor-forgot-input-wrapper">


                                    <span class="doctor-forgot-email-icon">

                                        <svg viewBox="0 0 24 24" fill="none">

                                            <rect x="3" y="5" width="18" height="14" rx="2"
                                                stroke="currentColor" stroke-width="1.7" />

                                            <path d="M3 7L10.2 12.2C11.27 12.97 12.73 12.97 13.8 12.2L21 7"
                                                stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />

                                        </svg>

                                    </span>


                                    <input type="email" id="doctorResetEmail" name="email"
                                        value="{{ old('email', $request->email) }}" placeholder="example@email.com"
                                        autocomplete="username" required autofocus>

                                </div>


                                @error('email')
                                    <div class="doctor-register-auth-error">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>



                            <!-- =====================================
                                 PASSWORD
                            ====================================== -->

                            <div class="doctor-login-field doctor-reset-password-field">

                                <label for="doctorResetPassword">

                                    كلمة المرور الجديدة

                                </label>


                                <div class="doctor-login-input">


                                    <span class="doctor-login-input-icon">

                                        <svg viewBox="0 0 24 24" fill="none">

                                            <rect x="5" y="10" width="14" height="10" rx="2"
                                                stroke="currentColor" stroke-width="1.7" />

                                            <path d="M8 10V7.5C8 5.29 9.79 3.5 12 3.5C14.21 3.5 16 5.29 16 7.5V10"
                                                stroke="currentColor" stroke-width="1.7" />

                                        </svg>

                                    </span>


                                    <input type="password" id="doctorResetPassword" name="password"
                                        placeholder="أدخل كلمة المرور الجديدة" autocomplete="new-password" required>


                                    <button type="button" class="doctor-login-password-toggle"
                                        id="doctorResetPasswordToggle" aria-label="إظهار كلمة المرور">

                                        <svg viewBox="0 0 24 24" fill="none">

                                            <path
                                                d="M2.5 12C4.5 8 8 6 12 6C16 6 19.5 8 21.5 12C19.5 16 16 18 12 18C8 18 4.5 16 2.5 12Z"
                                                stroke="currentColor" stroke-width="1.6" />

                                            <circle cx="12" cy="12" r="2.5" stroke="currentColor"
                                                stroke-width="1.6" />

                                        </svg>

                                    </button>

                                </div>


                                @error('password')
                                    <div class="doctor-register-auth-error">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>



                            <!-- =====================================
                                 CONFIRM PASSWORD
                            ====================================== -->

                            <div class="doctor-login-field">

                                <label for="doctorResetPasswordConfirmation">

                                    تأكيد كلمة المرور

                                </label>


                                <div class="doctor-login-input">


                                    <span class="doctor-login-input-icon">

                                        <svg viewBox="0 0 24 24" fill="none">

                                            <path d="M5 12L10 17L19 7" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round" />

                                        </svg>

                                    </span>


                                    <input type="password" id="doctorResetPasswordConfirmation"
                                        name="password_confirmation" placeholder="أعد كتابة كلمة المرور"
                                        autocomplete="new-password" required>


                                    <button type="button" class="doctor-login-password-toggle"
                                        id="doctorResetPasswordConfirmationToggle" aria-label="إظهار كلمة المرور">

                                        <svg viewBox="0 0 24 24" fill="none">

                                            <path
                                                d="M2.5 12C4.5 8 8 6 12 6C16 6 19.5 8 21.5 12C19.5 16 16 18 12 18C8 18 4.5 16 2.5 12Z"
                                                stroke="currentColor" stroke-width="1.6" />

                                            <circle cx="12" cy="12" r="2.5" stroke="currentColor"
                                                stroke-width="1.6" />

                                        </svg>

                                    </button>

                                </div>


                                @error('password_confirmation')
                                    <div class="doctor-register-auth-error">

                                        {{ $message }}

                                    </div>
                                @enderror

                            </div>



                            <!-- =====================================
                                 SUBMIT
                            ====================================== -->

                            <button type="submit" class="doctor-forgot-send-button">

                                تحديث كلمة المرور


                                <svg viewBox="0 0 24 24" fill="none">

                                    <path d="M5 12H19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />

                                    <path d="M13 6L19 12L13 18" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" />

                                </svg>

                            </button>

                        </form>



                        <!-- =====================================
                             BACK TO LOGIN
                        ====================================== -->

                        <div class="doctor-forgot-back-link">

                            <span>
                                تذكرت كلمة المرور؟
                            </span>


                            <a href="{{ route('login') }}">

                                العودة لتسجيل الدخول

                            </a>

                        </div>



                        <!-- =====================================
                             SECURITY NOTE
                        ====================================== -->

                        <div class="doctor-forgot-security-note">


                            <div class="doctor-forgot-security-icon">

                                <svg viewBox="0 0 24 24" fill="none">

                                    <path d="M12 21C12 21 19 17.5 19 11V5.5L12 3L5 5.5V11C5 17.5 12 21 12 21Z"
                                        stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />

                                    <path d="M8.5 12L10.7 14.2L15.5 9.5" stroke="currentColor" stroke-width="1.7"
                                        stroke-linecap="round" stroke-linejoin="round" />

                                </svg>

                            </div>


                            <p>

                                <strong>
                                    حسابك محمي
                                </strong>

                                استخدم كلمة مرور قوية تحتوي على
                                حروف وأرقام ورموز لحماية حسابك.

                            </p>

                        </div>


                    </div>

                </section>

            </div>

        </main>

    </div>

@endsection
