
<div x-data="{
        open: false,
        file: null,
        show(f) { this.file = f; this.open = true; document.body.classList.add('overflow-hidden'); },
        close() { this.open = false; this.file = null; document.body.classList.remove('overflow-hidden'); },
    }"
    @pf-view.window="show($event.detail)" @keydown.escape.window="open && close()">

    <div x-cloak x-show="open" x-transition.opacity class="pf-viewer" @click.self="close()" role="dialog"
        aria-modal="true">

        <div class="clinic-surface-card pf-viewer__panel" @click.stop>

            <div class="pf-viewer__head">
                <p class="pf-viewer__name" x-text="file ? file.name : ''"></p>

                <div class="pf-viewer__tools">
                    <a class="btn btn-outline btn-sm" :href="file ? file.download : '#'">
                        <i data-lucide="download" class="size-4"></i>
                        تحميل
                    </a>
                    <button type="button" class="btn btn-icon" @click="close()" aria-label="إغلاق" title="إغلاق">
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>
            </div>

            <div class="pf-viewer__body">
                <img :src="file ? file.url : null" :alt="file ? file.name : ''">
            </div>

        </div>
    </div>
</div>
<?php /**PATH C:\Users\DELL\Desktop\doctors-ai\resources\views/components/doctor/clinic/file-viewer-modal.blade.php ENDPATH**/ ?>