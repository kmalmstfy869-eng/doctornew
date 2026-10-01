{{--
    Partial: كارت لكل زيارة + رسالة "لا توجد زيارات".
    نفس الـ partial بيتحمّل أول مرة وبيترجع تاني عن طريق live_search.js
    (بيجيب نفس صفحة index كاملة ويسحب منها #visits-list بس).
--}}
@if ($visits->isNotEmpty())

    <div class="space-y-3">

        @foreach ($visits as $visit)
            <article class="clinic-surface-card bq-visit-card" data-print-target="visit-{{ $visit->id }}">

                {{-- ========== عرض الشاشة ========== --}}
                <div class="bq-screen-only">

                    {{-- Header: المريض + التشخيص + التاريخ + الأزرار --}}
                    <div
                        class="flex flex-col gap-4 border-b border-border/60 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">

                        <div class="flex min-w-0 items-center gap-3">

                            <div
                                class="bq-visit-icon grid size-11 shrink-0 place-items-center rounded-xl bg-primary-soft text-primary">
                                <i data-lucide="stethoscope" class="size-5"></i>
                            </div>

                            <div class="min-w-0">

                                <div class="flex flex-wrap items-center gap-2">

                                    @if ($visit->patient_id)
                                        <a href="{{ route('clinic.patients.show', $visit->patient_id) }}"
                                            class="font-bold hover:underline">
                                            {{ $visit->display_name }}
                                        </a>
                                    @else
                                        <span class="font-bold">{{ $visit->display_name }}</span>
                                        <span class="badge" style="background: #e8f1ff; color: #2563eb;">
                                            غير مسجل
                                        </span>
                                    @endif

                                </div>

                                <h3 class="bq-visit-title mt-0.5 text-sm text-muted-foreground">
                                    {{ $visit->diagnosis ?: 'بدون تشخيص' }}
                                </h3>

                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                    <span class="badge badge-muted">{{ $visit->visit_date_label }}</span>

                                    @if ($visit->display_phone)
                                        <span
                                            class="text-xs text-muted-foreground tabular-nums">{{ $visit->display_phone }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>


                        <div class="bq-no-print flex shrink-0 flex-wrap items-center gap-2">

                            <button type="button" class="btn btn-default btn-sm"
                                @click="openEdit(@js($visit->editPayload()))">
                                <i data-lucide="pencil" class="size-4"></i>
                                تعديل الزيارة
                            </button>

                            <button type="button" class="btn btn-outline btn-sm"
                                data-print-trigger="visit-{{ $visit->id }}" data-print-mode="visit">
                                <i data-lucide="printer" class="size-4"></i>
                                طباعة الزيارة
                            </button>

                            <form method="POST" action="{{ route('clinic.visit.destroy', $visit) }}"
                                onsubmit="return confirm('حذف هذه الزيارة نهائيًا؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm">
                                    <i data-lucide="trash-2" class="size-4"></i>
                                    حذف
                                </button>
                            </form>

                        </div>

                    </div>


                    {{-- Body --}}
                    <div class="grid gap-3 p-4 sm:grid-cols-2 sm:p-5">

                        <div class="bq-visit-field rounded-xl bg-muted/40 p-3">
                            <p class="text-xs text-muted-foreground">الشكوى</p>
                            <p class="bq-visit-text mt-1 text-sm font-medium">{{ $visit->complaint ?: '—' }}</p>
                        </div>

                        <div class="bq-visit-field rounded-xl bg-muted/40 p-3">
                            <p class="text-xs text-muted-foreground">الأعراض</p>
                            <p class="bq-visit-text mt-1 text-sm font-medium">{{ $visit->symptoms ?: '—' }}</p>
                        </div>

                        @if ($visit->required_tests)
                            <div class="bq-visit-field rounded-xl bg-muted/40 p-3">
                                <p class="text-xs text-muted-foreground">التحاليل المطلوبة</p>
                                <p class="bq-visit-text mt-1 text-sm font-medium">{{ $visit->required_tests }}</p>
                            </div>
                        @endif

                        @if ($visit->required_radiology)
                            <div class="bq-visit-field rounded-xl bg-muted/40 p-3">
                                <p class="text-xs text-muted-foreground">الأشعة</p>
                                <p class="bq-visit-text mt-1 text-sm font-medium">{{ $visit->required_radiology }}</p>
                            </div>
                        @endif

                        @if ($visit->notes)
                            <div class="bq-visit-field rounded-xl bg-muted/40 p-3 sm:col-span-2">
                                <p class="text-xs text-muted-foreground">ملاحظات الزيارة</p>
                                <p class="bq-visit-text mt-1 text-sm font-medium">{{ $visit->notes }}</p>
                            </div>
                        @endif

                        @if ($visit->next_visit_date_label)
                            <div class="bq-visit-field rounded-xl bg-muted/40 p-3">
                                <p class="text-xs text-muted-foreground">موعد المتابعة</p>
                                <p class="mt-1 text-sm font-medium">{{ $visit->next_visit_date_label }}</p>
                            </div>
                        @endif

                    </div>

                </div>

                {{-- ========== محتوى الطباعة (مخفي في الشاشة) ========== --}}
                <x-doctor.clinic.visit-print :visit="$visit" />

            </article>
        @endforeach

    </div>
@else
    <div class="clinic-surface-card p-6">
        @if (request('search'))
            <x-home.banner.no_results logo="fa-solid fa-stethoscope" title="لا توجد نتائج مطابقة للبحث"
                content="جرّب اسمًا أو رقم هاتف مختلف." />
        @else
            <x-home.banner.no_results logo="fa-solid fa-stethoscope" title="لا توجد زيارات بعد"
                content="لم يتم تسجيل أي زيارات حتى الآن." />
        @endif
    </div>
@endif
