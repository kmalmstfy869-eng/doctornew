{{-- زر تشغيل Backup يدوي: تأكيد + منع الضغط المتكرر. القفل الحقيقي في السيرفر. --}}
<form method="POST" action="{{ route('admin.storage.runs.run') }}" x-data="{ busy: false }"
    @submit="if (confirm('تشغيل Backup دلوقتي؟ ممكن ياخد وقت لو فيه ملفات كتير.')) { busy = true } else { $event.preventDefault() }">
    @csrf
    <button type="submit" class="ap-btn ap-btn--primary" :disabled="busy">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <span x-text="busy ? 'جاري النسخ... متقفلش الصفحة' : 'شغّل Backup الآن'">شغّل Backup الآن</span>
    </button>
</form>
