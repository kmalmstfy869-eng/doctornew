@extends('home.layout.app')

@section('title', 'تأكيد البريد الإلكتروني | دليل الأطباء')

@section('content')

<div class="doctor-verify-page">

    <div class="doctor-verify-bg-circle doctor-verify-circle-one"></div>
    <div class="doctor-verify-bg-circle doctor-verify-circle-two"></div>

    <main class="doctor-verify-main">

        <div class="doctor-verify-card">

            {{-- Icon --}}
            <div class="doctor-verify-icon">

                <svg viewBox="0 0 24 24" fill="none">

                    <rect
                        x="3"
                        y="5"
                        width="18"
                        height="14"
                        rx="2"
                        stroke="currentColor"
                        stroke-width="1.7"
                    />

                    <path
                        d="M3 7L10.2 12.2C11.27 12.97 12.73 12.97 13.8 12.2L21 7"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                    />

                    <path
                        d="M16 16L18 18L21 14.5"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                </svg>

            </div>


            {{-- Heading --}}
            <h1>
                تأكيد البريد الإلكتروني
            </h1>


            <p class="doctor-verify-description">

                شكرًا لتسجيلك في دليل الأطباء.
                أرسلنا لك رابط تأكيد إلى بريدك الإلكتروني.
                اضغط على الرابط الموجود في الرسالة لتفعيل حسابك.

            </p>


            {{-- Success Message --}}
            @if (session('status') == 'verification-link-sent')

                <div class="doctor-verify-success">

                    <i class="fa-solid fa-circle-check"></i>

                    تم إرسال رابط تأكيد جديد إلى بريدك الإلكتروني.

                </div>

            @endif


            {{-- Resend --}}
            <form method="POST"
                  action="{{ route('verification.send') }}"
                  class="doctor-verify-form">

                @csrf

                <button
                    type="submit"
                    class="doctor-verify-button">

                    إعادة إرسال رابط التأكيد

                    <i class="fa-solid fa-paper-plane"></i>

                </button>

            </form>


            {{-- Email Hint --}}
            <div class="doctor-verify-note">

                <div class="doctor-verify-note-icon">

                    <i class="fa-solid fa-shield-halved"></i>

                </div>

                <p>

                    تأكد من فحص مجلد الرسائل غير المرغوب فيها
                    إذا لم تجد رسالة التأكيد.

                </p>

            </div>


            {{-- Logout --}}
            <form method="POST"
                  action="{{ route('logout') }}"
                  class="doctor-verify-logout-form">

                @csrf

                <button
                    type="submit"
                    class="doctor-verify-logout">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    تسجيل الخروج

                </button>

            </form>

        </div>

    </main>

</div>

@endsection
