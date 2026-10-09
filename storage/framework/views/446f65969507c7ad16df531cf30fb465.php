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

        <a href="<?php echo e(route('doctor.profile.show')); ?>">
            الملف الشخصي
        </a>

        <a href="<?php echo e(route('doctor.profile_doctor')); ?>">
            الإعدادات
        </a>

        <a href="<?php echo e(route('doctor.subscription')); ?>">
            الاشتراك
        </a>

    </div>


    <div class="footer-col">

        <strong>
            تواصل معنا
        </strong>




            <a href="<?php echo e(App\Support\Whatsapp::link(null)); ?>" target="_blank" rel="noopener noreferrer" class="whatsapp-box">

                <span class="whatsapp-icon">
                    ☎
                </span>

                تواصل معنا عبر واتساب

            </a>



    </div>


    <div class="footer-copy">

        © <?php echo e(date('Y')); ?>

        دليل الاطباء — جميع الحقوق محفوظة

    </div>

</footer>

<script src="<?php echo e(asset('js/app_doctor.js')); ?>"></script>
<script src="<?php echo e(asset('js/doctor_details.js')); ?>"></script>
    <script src="<?php echo e(asset('sw.js')); ?>"></script>
    <script src="<?php echo e(asset('js/push-notifications.js')); ?>"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
 <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/dashboard/footer.blade.php ENDPATH**/ ?>