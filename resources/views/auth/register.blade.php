@extends('home.layout.app')

@section('title', 'إنشاء حساب | دليل الأطباء')

@section('content')

<div class="doctor-login-page">

    <!-- MAIN -->

    <main class="doctor-login-main">

        <div class="doctor-login-wrapper">


            <!-- HERO -->

            <section class="doctor-login-hero">

                <div class="doctor-login-hero-content">


                    <div class="doctor-login-online-badge">

                        <span class="doctor-login-online-dot"></span>

                        انضم إلى دليل الأطباء

                    </div>


                    <div class="doctor-login-hero-title">

                        <h1>

                            أنشئ حسابك
                            <br>

                            <span>
                                وابدأ رحلتك معنا
                            </span>

                        </h1>


                        <p>

                            أنشئ حسابك في دقائق للوصول
                            إلى خدمات دليل الأطباء وإدارة
                            تجربتك الطبية بسهولة وأمان.

                        </p>

                    </div>


                    <!-- Medical Visual -->

                    <div class="doctor-login-medical-visual">

                        <div class="doctor-login-visual-ring"></div>

                        <div class="doctor-login-visual-ring-two"></div>


                        <div class="doctor-login-floating-icon doctor-login-floating-one">

                            <svg viewBox="0 0 24 24" fill="none">

                                <path d="M12 21C12 21 19 17.5 19 11V5.5L12 3L5 5.5V11C5 17.5 12 21 12 21Z"
                                      stroke="currentColor"
                                      stroke-width="1.6"/>

                                <path d="M9 12L11 14L15.5 9.5"
                                      stroke="currentColor"
                                      stroke-width="1.6"
                                      stroke-linecap="round"/>

                            </svg>

                        </div>


                        <div class="doctor-login-floating-icon doctor-login-floating-two">

                            <svg viewBox="0 0 24 24" fill="none">

                                <path d="M4 12H8L10 5L14 19L16 12H20"
                                      stroke="currentColor"
                                      stroke-width="1.7"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>

                            </svg>

                        </div>


                        <div class="doctor-login-floating-icon doctor-login-floating-three">

                            <svg viewBox="0 0 24 24" fill="none">

                                <circle cx="12"
                                        cy="12"
                                        r="8"
                                        stroke="currentColor"
                                        stroke-width="1.6"/>

                                <path d="M12 8V12L15 14"
                                      stroke="currentColor"
                                      stroke-width="1.6"
                                      stroke-linecap="round"/>

                            </svg>

                        </div>


                        <div class="doctor-login-medical-card">

                            <div class="doctor-login-medical-cross">

                                <svg viewBox="0 0 24 24" fill="none">

                                    <path d="M12 4V20"
                                          stroke="currentColor"
                                          stroke-width="2.4"
                                          stroke-linecap="round"/>

                                    <path d="M4 12H20"
                                          stroke="currentColor"
                                          stroke-width="2.4"
                                          stroke-linecap="round"/>

                                </svg>

                            </div>

                        </div>

                    </div>


                    <!-- Stats -->

                    <div class="doctor-login-hero-stats">

                        <div class="doctor-login-stat">

                            <strong>
                                +1K
                            </strong>

                            <span>
                                طبيب موثوق
                            </span>

                        </div>


                        <div class="doctor-login-stat">

                            <strong>
                                +50K
                            </strong>

                            <span>
                                مريض
                            </span>

                        </div>


                        <div class="doctor-login-stat">

                            <strong>
                                24/7
                            </strong>

                            <span>
                                دعم مستمر
                            </span>

                        </div>

                    </div>

                </div>

            </section>


            <!-- REGISTER FORM -->

            <section class="doctor-login-form-panel">

                <div class="doctor-login-form-container">


                    <div class="doctor-login-welcome">

                        <div class="doctor-login-welcome-icon">

                            <svg viewBox="0 0 24 24" fill="none">

                                <circle cx="12"
                                        cy="7"
                                        r="3.5"
                                        stroke="currentColor"
                                        stroke-width="1.7"/>

                                <path d="M5 20C5.6 15.9 8.1 13.5 12 13.5C15.9 13.5 18.4 15.9 19 20"
                                      stroke="currentColor"
                                      stroke-width="1.7"
                                      stroke-linecap="round"/>

                            </svg>

                        </div>


                        <h2>
                            إنشاء حساب جديد
                        </h2>


                        <p>
                            أنشئ حسابك وابدأ استخدام منصة دليل الأطباء.
                        </p>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('register') }}"
                        id="doctorRegisterAuthForm"
                    >

                        @csrf


                        <!-- NAME -->

                        <div class="doctor-login-field">

                            <label for="registerName">
                                الاسم
                            </label>


                            <div class="doctor-login-input">

                                <span class="doctor-login-input-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <circle cx="12"
                                                cy="7"
                                                r="3.5"
                                                stroke="currentColor"
                                                stroke-width="1.7"/>

                                        <path d="M5 20C5.6 15.9 8.1 13.5 12 13.5C15.9 13.5 18.4 15.9 19 20"
                                              stroke="currentColor"
                                              stroke-width="1.7"
                                              stroke-linecap="round"/>

                                    </svg>

                                </span>


                                <input
                                    type="text"
                                    id="registerName"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="اكتب اسمك"
                                    autocomplete="name"
                                    required
                                    autofocus
                                >

                            </div>

                            @error('name')
                                <div class="doctor-register-auth-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- EMAIL -->

                        <div class="doctor-login-field">

                            <label for="registerEmail">
                                البريد الإلكتروني
                            </label>


                            <div class="doctor-login-input">

                                <span class="doctor-login-input-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <rect x="3"
                                              y="5"
                                              width="18"
                                              height="14"
                                              rx="2"
                                              stroke="currentColor"
                                              stroke-width="1.7"/>

                                        <path d="M3 7L10.2 12.2C11.27 12.97 12.73 12.97 13.8 12.2L21 7"
                                              stroke="currentColor"
                                              stroke-width="1.7"
                                              stroke-linecap="round"/>

                                    </svg>

                                </span>


                                <input
                                    type="email"
                                    id="registerEmail"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="example@email.com"
                                    autocomplete="username"
                                    required
                                    oninput="this.value = this.value.toLowerCase()"
                                >

                            </div>

                            @error('email')
                                <div class="doctor-register-auth-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- PASSWORD -->

                        <div class="doctor-login-field">

                            <label for="registerPassword">
                                كلمة المرور
                            </label>


                            <div class="doctor-login-input">

                                <span class="doctor-login-input-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <rect x="5"
                                              y="10"
                                              width="14"
                                              height="10"
                                              rx="2"
                                              stroke="currentColor"
                                              stroke-width="1.7"/>

                                        <path d="M8 10V7.5C8 5.29 9.79 3.5 12 3.5C14.21 3.5 16 5.29 16 7.5V10"
                                              stroke="currentColor"
                                              stroke-width="1.7"/>

                                    </svg>

                                </span>


                                <input
                                    type="password"
                                    id="registerPassword"
                                    name="password"
                                    placeholder="أدخل كلمة المرور"
                                    autocomplete="new-password"
                                    required
                                >


                                <button
                                    type="button"
                                    class="doctor-login-password-toggle"
                                    id="doctorRegisterTogglePassword"
                                    aria-label="إظهار كلمة المرور">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <path d="M2.5 12C4.5 8 8 6 12 6C16 6 19.5 8 21.5 12C19.5 16 16 18 12 18C8 18 4.5 16 2.5 12Z"
                                              stroke="currentColor"
                                              stroke-width="1.6"/>

                                        <circle cx="12"
                                                cy="12"
                                                r="2.5"
                                                stroke="currentColor"
                                                stroke-width="1.6"/>

                                    </svg>

                                </button>

                            </div>

                            @error('password')
                                <div class="doctor-register-auth-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- CONFIRM PASSWORD -->

                        <div class="doctor-login-field">

                            <label for="registerPasswordConfirmation">
                                تأكيد كلمة المرور
                            </label>


                            <div class="doctor-login-input">

                                <span class="doctor-login-input-icon">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <path d="M5 12L10 17L19 7"
                                              stroke="currentColor"
                                              stroke-width="1.8"
                                              stroke-linecap="round"
                                              stroke-linejoin="round"/>

                                    </svg>

                                </span>


                                <input
                                    type="password"
                                    id="registerPasswordConfirmation"
                                    name="password_confirmation"
                                    placeholder="أعد كتابة كلمة المرور"
                                    autocomplete="new-password"
                                    required
                                >


                                <button
                                    type="button"
                                    class="doctor-login-password-toggle"
                                    id="doctorRegisterTogglePasswordConfirmation"
                                    aria-label="إظهار كلمة المرور">

                                    <svg viewBox="0 0 24 24" fill="none">

                                        <path d="M2.5 12C4.5 8 8 6 12 6C16 6 19.5 8 21.5 12C19.5 16 16 18 12 18C8 18 4.5 16 2.5 12Z"
                                              stroke="currentColor"
                                              stroke-width="1.6"/>

                                        <circle cx="12"
                                                cy="12"
                                                r="2.5"
                                                stroke="currentColor"
                                                stroke-width="1.6"/>

                                    </svg>

                                </button>

                            </div>

                            @error('password_confirmation')
                                <div class="doctor-register-auth-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <!-- BUTTON -->

                        <button
                            type="submit"
                            class="doctor-login-button"
                        >

                            إنشاء حساب

                            <svg viewBox="0 0 24 24" fill="none">

                                <path d="M5 12H19"
                                      stroke="currentColor"
                                      stroke-width="1.8"
                                      stroke-linecap="round"/>

                                <path d="M13 6L19 12L13 18"
                                      stroke="currentColor"
                                      stroke-width="1.8"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>

                            </svg>

                        </button>

                    </form>


                    <div class="doctor-login-divider">
                        أو
                    </div>


                    <div class="doctor-login-create-account">

                        لديك حساب بالفعل؟

                        <a href="{{ route('login') }}">
                            تسجيل الدخول
                        </a>

                    </div>


                    <div class="doctor-login-secure-note">

                        <svg viewBox="0 0 24 24" fill="none">

                            <path d="M12 21C12 21 19 17.5 19 11V5.5L12 3L5 5.5V11C5 17.5 12 21 12 21Z"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linejoin="round"/>

                            <path d="M9 12L11 14L15 10"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linecap="round"/>

                        </svg>

                        بياناتك محمية ومشفرة بشكل آمن

                    </div>


                </div>

            </section>


        </div>

    </main>

</div>

@endsection
