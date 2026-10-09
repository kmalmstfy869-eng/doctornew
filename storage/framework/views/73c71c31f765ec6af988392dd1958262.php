<?php if($bookings->hasPages()): ?>
    <div class="border-t border-border px-4 py-4 sm:px-5">

        <?php echo e($bookings->withQueryString()->links('vendor.pagination.custom')); ?>


    </div>
<?php endif; ?>

<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/doctor/clinic/booking/partials/pagination.blade.php ENDPATH**/ ?>