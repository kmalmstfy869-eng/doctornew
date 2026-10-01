@extends('home.layout.app')

@section('title', 'استعادة كلمة المرور | دليل الأطباء')

@section('content')

<div class="doctor-forgot-page">

    <div class="doctor-forgot-bg-circle doctor-forgot-circle-one"></div>
    <div class="doctor-forgot-bg-circle doctor-forgot-circle-two"></div>
    <div class="doctor-forgot-bg-circle doctor-forgot-circle-three"></div>


    <main class="doctor-forgot-main">

        <div class="doctor-forgot-wrapper">


            {{-- الجانب التعريفي --}}
            <section class="doctor-forgot-creative">

                <div class="doctor-forgot-creative-content">


                    <div class="doctor-forgot-security-badge">

                        <span></span>

                        حماية حسابك أولويتنا

                    </div>


                    <div class="doctor-forgot-creative-title">

                        <h2>

                            لا تقلق،
                            <br>

                            <span>
                                سنساعدك على العودة
                            </span>

                        </h2>


                        <p>

                            أدخل البريد الإلكتروني المرتبط
                            بحسابك وسنرسل لك تعليمات
                            آمنة لإعادة تعيين كلمة المرور.

                        </p>

                    </div>


                    <div class="doctor-forgot-lock-area">

                        <div class="doctor-forgot-lock-glow"></div>

                        <span class="doctor-forgot-floating-dot doctor-forgot-dot-one"></span>

                        <span class="doctor-forgot-floating-dot doctor-forgot-dot-two"></span>

                        <span class="doctor-forgot-floating-dot doctor-forgot-dot-three"></span>


                        <div class="doctor-forgot-lock">

                            <svg viewBox="0 0 24 24" fill="none">

                                <path d="M7 10V7.5C7 4.74 9.24 2.5 12 2.5C14.76 2.5 17 4.74 17 7.5V10"
                                      stroke="currentColor"
                                      stroke-width="1.7"
                                      stroke-linecap="round"/>

                                <rect x="4"
                                      y="10"
                                      width="16"
                                      height="11"
                                      rx="2.5"
                                      stroke="currentColor"
                                      stroke-width="1.7"/>

                                <circle cx="12"
                                        cy="15.5"
                                        r="1.3"
                                        fill="currentColor"/>

                            </svg>

                        </div>

                    </div>

                </div>

            </section>



            {{-- فورم الاستعادة --}}
            <section class="doctor-forgot-form-panel">

                <div class="doctor-forgot-form-container">


                    <div class="doctor-forgot-form-icon">

                        <svg viewBox="0 0 24 24" fill="none">

                            <path d="M4 7C4 5.9 4.9 5 6 5H18C19.1 5 20 5.9 20 7V17C20 18.1 19.1 19 18 19H6C4.9 19 4 18.1 4 17V7Z"
                                  stroke="currentColor"
                                  stroke-width="1.7"/>

                            <path d="M4.5 7L10.6 11.5C11.42 12.1 12.58 12.1 13.4 11.5L19.5 7"
                                  stroke="currentColor"
                                  stroke-width="1.7"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>

                        </svg>

                    </div>


                    <div class="doctor-forgot-form-header">

                        <h1>
                            نسيت كلمة المرور؟
                        </h1>


                        <p>

                            لا مشكلة. أدخل البريد الإلكتروني
                            الذي سجلت به حسابك، وسنرسل لك
                            رابطًا لإعادة تعيين كلمة المرور.

                        </p>

                    </div>


                    {{-- رسالة Laravel --}}
                    @if (session('status'))

                        <div class="doctor-forgot-auth-status">

                            {{ session('status') }}

                        </div>

                    @endif



                    <form
                        method="POST"
                        action="{{ route('password.email') }}"
                        id="doctorForgotForm">

                        @csrf


                        <div class="doctor-forgot-email-group">


                            <label for="doctorForgotEmail">

                                البريد الإلكتروني

                            </label>


                            <div class="doctor-forgot-input-wrapper">


                                <span class="doctor-forgot-email-icon">

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
                                    id="doctorForgotEmail"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="example@email.com"
                                    autocomplete="email"
                                    required
                                    autofocus>

                            </div>


                            @error('email')

                                <div class="doctor-register-auth-error">

                                    {{ $message }}

                                </div>

                            @enderror


                        </div>



                        <button
                            type="submit"
                            class="doctor-forgot-send-button">

                            إرسال رابط إعادة التعيين


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



                    <div class="doctor-forgot-back-link">

                        <span>
                            تذكرت كلمة المرور؟
                        </span>


                        <a href="{{ route('login') }}">

                            العودة لتسجيل الدخول

                        </a>

                    </div>



                    <div class="doctor-forgot-security-note">

                        <div class="doctor-forgot-security-icon">

                            <svg viewBox="0 0 24 24" fill="none">

                                <path d="M12 21C12 21 19 17.5 19 11V5.5L12 3L5 5.5V11C5 17.5 12 21 12 21Z"
                                      stroke="currentColor"
                                      stroke-width="1.7"
                                      stroke-linejoin="round"/>

                                <path d="M8.5 12L10.7 14.2L15.5 9.5"
                                      stroke="currentColor"
                                      stroke-width="1.7"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"/>

                            </svg>

                        </div>


                        <p>

                            <strong>
                                رابط آمن لإعادة التعيين
                            </strong>

                            لأمان حسابك، سيكون رابط إعادة تعيين
                            كلمة المرور صالحًا لفترة محدودة فقط.

                        </p>

                    </div>


                </div>

            </section>

        </div>

    </main>

</div>

@endsection
