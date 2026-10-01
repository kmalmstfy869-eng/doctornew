
@props([
    'rx',
    'name' => null,
    'phone' => null,
    'age' => null,
])

@php
    $meds = collect($rx->medications ?? []);
    $date = $rx->prescription_date?->format('Y/m/d');
    $next = $rx->next_visit_date?->format('Y/m/d');
@endphp

<div class="bq-print-only">

    <h2 class="bq-sheet-title"><span>روشتة طبية</span></h2>

    <div class="bq-sheet-meta">

        <span class="bq-sheet-meta-wide"><b>الاسم:</b> {{ $name ?: '..............................' }}</span>

        @if ($age)
            <span><b>السن:</b> {{ $age }} سنة</span>
        @endif

        <span><b>التاريخ:</b> {{ $date }}</span>

        @if ($next)
            <span><b>موعد الإعادة:</b> {{ $next }}</span>
        @endif

    </div>

    @if ($meds->isNotEmpty())
        <table class="bq-sheet-table">
            <thead>
                <tr>
                    <th class="bq-col-num">#</th>
                    <th>العلاج</th>
                    <th>الجرعة</th>
                    <th>عدد المرات</th>
                    <th>المدة</th>
                    <th>التوقيت</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($meds as $i => $med)
                    <tr>
                        <td class="bq-col-num">{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $med['name'] ?? '' }}</strong>
                            @if (! empty($med['notes']))
                                <small>{{ $med['notes'] }}</small>
                            @endif
                        </td>
                        <td>{{ $med['dose'] ?? '—' }}</td>
                        <td>{{ $med['frequency'] ?? '—' }}</td>
                        <td>{{ $med['duration'] ?? '—' }}</td>
                        <td>{{ $med['timing'] ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($rx->notes)
        <div class="bq-sheet-note">
            <b>ملاحظات الطبيب:</b>
            <span>{{ $rx->notes }}</span>
        </div>
    @endif

</div>
