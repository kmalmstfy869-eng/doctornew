@extends('doctor.layouts.app_clinc')
@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/clinic/print.css') }}">
@endpush
@section('title', 'الروشتات | دليل الأطباء')

@section('content')

    {{-- ترويسة/تذييل الطباعة (مرة واحدة في الصفحة) --}}
    <x-doctor.clinic.print-letterhead :doctor="$doctor" />

    {{-- modal الروشتة (واحد للصفحة) — بدون مريض مقفول: Live Search + شخص غير مسجل --}}
    <x-doctor.clinic.prescription-form />

    {{-- x-data فاضي: لازم عشان $dispatch('bq-rx-create' / 'bq-rx-edit') يشتغل من هنا --}}
    <main id="prescriptions-print-area" x-data class="mx-auto w-full max-w-[1400px] px-3 py-5 sm:px-5 sm:py-6">

        {{-- Header --}}
        <div class="clinic-surface-card mb-4 p-4 sm:p-6">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-3">

                    <div class="grid size-12 shrink-0 place-items-center rounded-2xl bg-primary-soft text-primary">
                        <i data-lucide="file-text" class="size-6"></i>
                    </div>

                    <div>
                        <h1 class="text-xl font-bold text-foreground sm:text-2xl">الروشتات</h1>
                        <p class="mt-1 text-sm text-muted-foreground" id="rx-count">
                            {{ $prescriptions->total() }} روشتة
                        </p>
                    </div>

                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">

                    <div class="relative">

                        <i data-lucide="search"
                            class="pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            class="field-input ps-9"
                            placeholder="ابحث باسم المريض أو رقم الهاتف"
                            autocomplete="off"
                            data-live-search
                            data-live-search-url="{{ route('clinic.prescriptions.index') }}"
                            data-live-search-target="#rx-list"
                            data-live-search-pagination="#rx-pagination"
                            data-live-search-count="#rx-count"
                        >

                    </div>

                    <button type="button" class="btn btn-default" @click="$dispatch('bq-rx-create')">
                        <i data-lucide="file-plus" class="size-4"></i>
                        روشتة جديدة
                    </button>

                </div>

            </div>

        </div>

        {{-- List (partial قابل لإعادة الرسم من live_search.js) --}}
        <div id="rx-list">
            @include('doctor.clinic.prescriptions._list', ['prescriptions' => $prescriptions])
        </div>

        <div id="rx-pagination" class="bq-no-print">
            {{ $prescriptions->links('vendor.pagination.custom') }}
        </div>

    </main>

    @push('extra_java')
        <script src="{{ asset('js/clinic/live_search.js') }}"></script>
        <script src="{{ asset('js/clinic/print.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });
        </script>
    @endpush

@endsection
