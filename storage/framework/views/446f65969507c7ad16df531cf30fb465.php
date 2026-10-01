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


        <?php

            $whatsapp = preg_replace('/\D/', '', config('services.whatsapp.support_number', ''));

        ?>


        <?php if($whatsapp): ?>
            <a href="https://wa.me/<?php echo e($whatsapp); ?>" target="_blank" rel="noopener noreferrer" class="whatsapp-box">

                <span class="whatsapp-icon">
                    ☎
                </span>

                تواصل معنا عبر واتساب

            </a>
        <?php else: ?>
            <span class="whatsapp-box">

                <span class="whatsapp-icon">
                    ☎
                </span>

                تواصل معنا عبر واتساب

            </span>
        <?php endif; ?>

    </div>


    <div class="footer-copy">

        © <?php echo e(date('Y')); ?>

        دليلك الطبي — جميع الحقوق محفوظة

    </div>

</footer>

<script src="<?php echo e(asset('js/app_doctor.js')); ?>"></script>
<script src="<?php echo e(asset('js/doctor_details.js')); ?>"></script>
    <script src="<?php echo e(asset('sw.js')); ?>"></script>
    <script src="<?php echo e(asset('js/push-notifications.js')); ?>"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/dashboard/footer.blade.php ENDPATH**/ ?>