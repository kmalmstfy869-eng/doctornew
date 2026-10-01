{{--
    محتوى الزيارة للطباعة فقط (مخفي في الشاشة بكلاس bq-print-only).
    print.js بيسحب الجزء ده ويضيف عليه الترويسة والتذييل وقت الطباعة.
--}}
@props(['visit'])

@php
    $rows = [
        ['الشكوى الرئيسية', $visit->complaint, false, true],
        ['الأعراض', $visit->symptoms, false, true],
        ['التشخيص', $visit->diagnosis, true, true],
        ['التحاليل المطلوبة', $visit->required_tests, false, false],
        ['الأشعة', $visit->required_radiology, false, false],
        ['ملاحظات الزيارة', $visit->notes, true, false],
        ['موعد المتابعة', $visit->next_visit_date_label, false, false],
    ];
@endphp

<div class="bq-print-only">

    <h2 class="bq-sheet-title"><span>تقرير زيارة طبية</span></h2>

    <div class="bq-sheet-meta">

        <span class="bq-sheet-meta-wide"><b>المريض:</b> {{ $visit->display_name ?: '..............................' }}</span>

        @if ($visit->display_phone)
            <span><b>الهاتف:</b> {{ $visit->display_phone }}</span>
        @endif

        <span><b>تاريخ الزيارة:</b> {{ $visit->visit_date_label }}</span>

    </div>

    <div class="bq-sheet-fields">

        @foreach ($rows as [$label, $value, $full, $always])
            @if (filled($value) || $always)
                <div class="bq-sheet-field {{ $full ? 'bq-sheet-field-full' : '' }}">
                    <p class="bq-sheet-field-label">{{ $label }}</p>
                    <p class="bq-sheet-field-text">{{ filled($value) ? $value : '—' }}</p>
                </div>
            @endif
        @endforeach

    </div>

</div>
