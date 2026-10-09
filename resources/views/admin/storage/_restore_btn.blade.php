{{-- زر استرجاع ملف واحد. لو الملف اتحذف عمدًا بنطلب تأكيد صريح (يتراجع في السيرفر كمان). --}}
<form method="POST" action="{{ route('admin.storage.restore.one', $id) }}" class="ap-inline-form" x-data="{ busy: false }"
    @submit="if (confirm('{{ $deleted ? 'الملف ده اتحذف عمدًا. متأكد إنك عايز ترجّعه؟' : 'استرجاع الملف للتخزين الأساسي؟' }}')) { busy = true } else { $event.preventDefault() }">
    @csrf
    @if ($deleted)
        <label class="ap-check"><input type="checkbox" name="confirm_deleted" value="1" required> أؤكد إعادة ملف اتحذف عمدًا</label>
    @endif
    <button type="submit" class="ap-btn ap-btn--ghost ap-btn--sm" :disabled="busy">
        <i class="fa-solid fa-rotate-left"></i> استرجاع
    </button>
</form>
