
@php
    $showPatient = $showPatient ?? true;
@endphp

@if ($files->isNotEmpty())

    <div class="space-y-3">

        @foreach ($files as $file)
            @php
                $viewUrl = route('clinic.files.view', $file);
                $downloadUrl = route('clinic.files.download', $file);
            @endphp

            <article class="clinic-surface-card pf-row">

                <div class="pf-row__main">

                    <div class="pf-icon bg-primary-soft text-primary">
                        <i data-lucide="{{ $file->is_image ? 'image' : 'file-text' }}" class="size-5"></i>
                    </div>

                    <div class="pf-row__info">

                        <p class="pf-name">{{ $file->original_name }}</p>

                        @if ($showPatient && $file->patient)
                            <a href="{{ route('clinic.patients.show', $file->patient_id) }}"
                                class="pf-patient hover:underline">
                                {{ $file->patient->name }}
                                @if ($file->patient->phone)
                                    <span class="tabular-nums">• {{ $file->patient->phone }}</span>
                                @endif
                            </a>
                        @endif

                        <div class="pf-meta text-muted-foreground">
                            <span class="badge badge-info">{{ $file->kind_label }}</span>
                            <span class="tabular-nums">{{ $file->size_label }}</span>
                            <span>{{ $file->date_label }}</span>
                        </div>

                    </div>

                </div>

                <div class="pf-actions bq-no-print">

                    {{-- الصورة تتفتح في Viewer، والـ PDF في تبويب جديد (أأمن وأضمن على الموبايل) --}}
                    @if ($file->is_image)
                        <button type="button" class="btn btn-default btn-sm"
                            @click="$dispatch('pf-view', @js(['name' => $file->original_name, 'url' => $viewUrl, 'download' => $downloadUrl]))">
                            <i data-lucide="eye" class="size-4"></i>
                            عرض
                        </button>
                    @else
                        <a href="{{ $viewUrl }}" target="_blank" rel="noopener noreferrer"
                            class="btn btn-default btn-sm">
                            <i data-lucide="eye" class="size-4"></i>
                            عرض
                        </a>
                    @endif

                    <a href="{{ $downloadUrl }}" class="btn btn-outline btn-sm">
                        <i data-lucide="download" class="size-4"></i>
                        تحميل
                    </a>

                    <form method="POST" action="{{ route('clinic.files.destroy', $file) }}"
                        onsubmit="return confirm('حذف هذا الملف نهائيًا؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline btn-sm">
                            <i data-lucide="trash-2" class="size-4"></i>
                            حذف
                        </button>
                    </form>

                </div>

            </article>
        @endforeach

    </div>
@else
    <div class="clinic-surface-card p-6">
        <x-home.banner.no_results logo="fa-solid fa-folder-open" :title="request('search') ? 'لا توجد نتائج مطابقة للبحث' : 'لا توجد ملفات'"
            :content="request('search')
                ? 'جرّب اسمًا أو رقم هاتف مختلف.'
                : ($showPatient
                    ? 'لم يتم رفع أي ملفات طبية حتى الآن.'
                    : 'لم يتم رفع أي ملفات طبية لهذا المريض حتى الآن.')" />
    </div>
@endif
