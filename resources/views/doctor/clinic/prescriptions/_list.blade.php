{{--
    Partial: كارت لكل روشتة + رسالة "لا توجد روشتات".
    نفس الـ partial بيتحمّل أول مرة وبيترجع تاني عن طريق live_search.js
    (بيجيب نفس صفحة index كاملة ويسحب منها #rx-list بس).
--}}
@if ($prescriptions->isNotEmpty())

    <div class="space-y-3">

        @foreach ($prescriptions as $rx)
            @php $meds = collect($rx->medications ?? []); @endphp

            <article class="clinic-surface-card p-4 sm:p-5" data-print-target="rx-{{ $rx->id }}">

                {{-- ========== عرض الشاشة ========== --}}
                <div class="bq-screen-only">

                    <div class="flex flex-wrap items-center justify-between gap-3">

                        <div class="min-w-0">

                            <div class="flex flex-wrap items-center gap-2">

                                @if ($rx->patient_id)
                                    <a href="{{ route('clinic.patients.show', $rx->patient_id) }}"
                                        class="font-bold hover:underline">
                                        {{ $rx->display_name }}
                                    </a>
                                @else
                                    <span class="font-bold">{{ $rx->display_name }}</span>
                                    <span class="badge" style="background: #e8f1ff; color: #2563eb;">
                                        غير مسجل
                                    </span>
                                @endif



                            </div>

                            <p class="mt-1 text-xs text-muted-foreground">
                                {{ $rx->prescription_date_label }}
                                @if ($rx->display_phone)
                                    • <span class="tabular-nums">{{ $rx->display_phone }}</span>
                                @endif
                            </p>

                        </div>


                        <div class="bq-no-print flex flex-wrap items-center gap-2">

                            <button type="button" class="btn btn-default btn-sm"
                                @click="$dispatch('bq-rx-edit', @js($rx->editPayload()))">
                                <i data-lucide="pencil" class="size-4"></i>
                                تعديل الروشتة
                            </button>

                            <button type="button" class="btn btn-outline btn-sm"
                                data-print-trigger="rx-{{ $rx->id }}" data-print-mode="rx">
                                <i data-lucide="printer" class="size-4"></i>
                                طباعة الروشتة
                            </button>

                            <form method="POST" action="{{ route('clinic.prescriptions.destroy', $rx) }}"
                                onsubmit="return confirm('حذف هذه الروشتة نهائيًا؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-sm">
                                    <i data-lucide="trash-2" class="size-4"></i>
                                    حذف
                                </button>
                            </form>

                        </div>

                    </div>


                    @if ($meds->isNotEmpty())
                        <div class="mt-4 overflow-hidden rounded-xl border border-border/60">

                            <div
                                class="hidden grid-cols-[1.5fr_1fr_1fr_1fr_1fr] gap-3 bg-muted/40 px-4 py-3 text-xs font-semibold text-muted-foreground sm:grid">
                                <div>الدواء</div>
                                <div>الجرعة</div>
                                <div>التكرار</div>
                                <div>المدة</div>
                                <div>التوقيت</div>
                            </div>

                            @foreach ($meds as $med)
                                <div
                                    class="grid gap-2 border-b border-border/60 p-4 last:border-b-0 sm:grid-cols-[1.5fr_1fr_1fr_1fr_1fr] sm:items-center sm:gap-3 sm:px-4">

                                    <div>
                                        <p class="text-xs text-muted-foreground sm:hidden">الدواء</p>
                                        <p class="font-semibold">{{ $med['name'] ?? '' }}</p>
                                        @if (!empty($med['notes']))
                                            <p class="mt-0.5 text-xs text-muted-foreground">{{ $med['notes'] }}</p>
                                        @endif
                                    </div>

                                    <div>
                                        <p class="text-xs text-muted-foreground sm:hidden">الجرعة</p>
                                        <p class="text-sm">{{ $med['dose'] ?? '—' }}</p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-muted-foreground sm:hidden">التكرار</p>
                                        <p class="text-sm">{{ $med['frequency'] ?? '—' }}</p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-muted-foreground sm:hidden">المدة</p>
                                        <p class="text-sm">{{ $med['duration'] ?? '—' }}</p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-muted-foreground sm:hidden">التوقيت</p>
                                        <p class="text-sm text-muted-foreground">{{ $med['timing'] ?? '—' }}</p>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @endif


                    @if ($rx->notes || $rx->next_visit_date)
                        <div class="mt-4 grid gap-3 sm:grid-cols-2">

                            @if ($rx->notes)
                                <div
                                    class="rounded-xl bg-muted/40 p-3 {{ $rx->next_visit_date ? '' : 'sm:col-span-2' }}">
                                    <p class="text-xs font-semibold text-muted-foreground">ملاحظات الطبيب</p>
                                    <p class="mt-1 text-sm" style="white-space:pre-line">{{ $rx->notes }}</p>
                                </div>
                            @endif

                            @if ($rx->next_visit_date)
                                <div class="rounded-xl bg-muted/40 p-3">
                                    <p class="text-xs font-semibold text-muted-foreground">موعد المتابعة</p>
                                    <p class="mt-1 text-sm">{{ $rx->next_visit_date_label }}</p>
                                </div>
                            @endif

                        </div>
                    @endif

                </div>

                {{-- ========== محتوى الطباعة (مخفي في الشاشة) ========== --}}
                <x-doctor.clinic.prescription-print :rx="$rx" :name="$rx->display_name" :phone="$rx->display_phone"
                    :age="$rx->patient?->birth_date?->age" />

            </article>
        @endforeach

    </div>
@else
    <div class="clinic-surface-card p-6">
        <x-home.banner.no_results logo="fa-solid fa-file-medical" :title="request('search') ? 'لا توجد نتائج مطابقة للبحث' : 'لا توجد روشتات بعد'" :content="request('search') ? 'جرّب اسمًا أو رقم هاتف مختلف.' : 'لم يتم تسجيل أي روشتات حتى الآن.'" />
    </div>

@endif
