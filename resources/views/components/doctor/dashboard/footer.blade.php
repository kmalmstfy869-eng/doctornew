<footer class="footer">


    <div class="footer-brand">

        <strong>
            دليلك الطبي
        </strong>

        <p>
            إدارة حضورك الطبي، تطوير ملفك،
            ومتابعة أداء صفحتك من مكان واحد.
        </p>

    </div>


    <div class="footer-col">

        <strong>
            حسابي
        </strong>

        <a href="#">
            الملف الشخصي
        </a>

        <a href="#">
            الإعدادات
        </a>

        <a href="#subscription">
            الاشتراك
        </a>

    </div>


    <div class="footer-col">

        <strong>
            تواصل معنا
        </strong>


        @php

            $whatsapp = preg_replace('/\D/', '', config('services.whatsapp.support_number', ''));

        @endphp


        @if ($whatsapp)
            <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="whatsapp-box">

                <span class="whatsapp-icon">
                    ☎
                </span>

                تواصل معنا عبر واتساب

            </a>
        @else
            <span class="whatsapp-box">

                <span class="whatsapp-icon">
                    ☎
                </span>

                تواصل معنا عبر واتساب

            </span>
        @endif

    </div>


    <div class="footer-copy">

        © {{ date('Y') }}
        دليلك الطبي — جميع الحقوق محفوظة

    </div>

</footer>

<script src="{{ asset('js/app_doctor.js') }}"></script>
<script src="{{ asset('js/doctor_details.js') }}"></script>
    <script src="{{ asset('sw.js') }}"></script>
    <script src="{{ asset('js/push-notifications.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>
