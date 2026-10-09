@extends('doctor.layouts.app_clinc')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/clinic/patient-files.css') }}">
@endpush

@section('title', 'ملفات المرضى | دليل الأطباء')

@section('content')

    {{-- المودالات: رفع (مع بحث عن مريض مسجل) + عارض الصور --}}
    <x-doctor.clinic.file-upload-modal />
    <x-doctor.clinic.file-viewer-modal />

    {{-- x-data فاضي: لازم عشان $dispatch يشتغل من أزرار القائمة (حتى بعد إعادة رسمها من live_search.js) --}}
    <main x-data class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        {{-- إعلان زيادة المساحة: بيظهر لما يتبقى جيجا واحدة أو أقل --}}
        <x-doctor.clinic.storage-upsell :stats="$stats" />

        <div class="clinic-surface-card mb-4 p-4 sm:p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-3">
                    <div class="grid size-12 shrink-0 place-items-center rounded-2xl bg-primary-soft text-primary">
                        <i data-lucide="folder-open" class="size-6"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-foreground sm:text-2xl">ملفات المرضى</h1>
                        <p class="mt-1 text-sm text-muted-foreground" id="pf-count">{{ $files->total() }} ملف</p>
                    </div>
                </div>
                <div class="flex w-full flex-col gap-2 sm:flex-row sm:items-center lg:w-auto">
                    <div class="relative w-full sm:w-80 lg:w-[26rem]">
                        <i data-lucide="search"
                            class="pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground"></i>
                        <input type="text" name="search" value="{{ $search }}" class="field-input w-full ps-9"
                            placeholder="ابحث باسم المريض أو رقم الهاتف" autocomplete="off" data-live-search
                            data-live-search-url="{{ route('clinic.files.index') }}"
                            data-live-search-target="#pf-list" data-live-search-pagination="#pf-pagination"
                            data-live-search-count="#pf-count">
                    </div>

                    <button type="button" class="btn btn-default" @click="$dispatch('pf-upload-open')">
                        <i data-lucide="upload" class="size-4"></i>
                        رفع ملف جديد
                    </button>
                </div>

            </div>
        </div>

        <div class="mb-4">
            <x-doctor.clinic.storage-card :stats="$stats" />
        </div>

        <div id="pf-list">
            @include('doctor.clinic.files._list', ['files' => $files, 'showPatient' => true])
        </div>

        <div id="pf-pagination" class="bq-no-print mt-4">
            {{ $files->links('vendor.pagination.custom') }}
        </div>

    </main>

    @push('extra_java')
        <script src="{{ asset('js/clinic/live_search.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });
        </script>
    @endpush

@endsection
