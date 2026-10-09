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

        <a href="{{ route('doctor.profile.show') }}">
            الملف الشخصي
        </a>

        <a href="{{ route('doctor.profile_doctor') }}">
            الإعدادات
        </a>

        <a href="{{ route('doctor.subscription') }}">
            الاشتراك
        </a>

    </div>


    <div class="footer-col">

        <strong>
            تواصل معنا
        </strong>




            <a href="{{App\Support\Whatsapp::link(null)}}" target="_blank" rel="noopener noreferrer" class="whatsapp-box">

                <span class="whatsapp-icon">
                    ☎
                </span>

                تواصل معنا عبر واتساب

            </a>



    </div>


    <div class="footer-copy">

        © {{ date('Y') }}
        دليل الاطباء — جميع الحقوق محفوظة

    </div>

</footer>

<script src="{{ asset('js/app_doctor.js') }}"></script>
<script src="{{ asset('js/doctor_details.js') }}"></script>
    <script src="{{ asset('sw.js') }}"></script>
    <script src="{{ asset('js/push-notifications.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
 @stack('scripts')
</body>

</html>
