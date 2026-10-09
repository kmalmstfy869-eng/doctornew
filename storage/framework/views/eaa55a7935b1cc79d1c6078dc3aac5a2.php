
<form method="POST" action="<?php echo e(route('admin.storage.runs.run')); ?>" x-data="{ busy: false }"
    @submit="if (confirm('تشغيل Backup دلوقتي؟ ممكن ياخد وقت لو فيه ملفات كتير.')) { busy = true } else { $event.preventDefault() }">
    <?php echo csrf_field(); ?>
    <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <span x-text="busy ? 'جاري النسخ... متقفلش الصفحة' : 'شغّل Backup الآن'">شغّل Backup الآن</span>
    </button>
</form>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/admin/storage/_run_button.blade.php ENDPATH**/ ?>