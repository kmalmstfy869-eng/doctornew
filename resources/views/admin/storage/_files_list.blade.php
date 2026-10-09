@use('App\Services\PatientFileService')

@if ($rows->isEmpty())
    <div class="ap-empty">
        <i class="fa-regular fa-folder-open"></i>
        <h4>{{ request()->hasAny(['search', 'doctor_id', 'status', 'type', 'from', 'to']) ? 'لا توجد نتائج مطابقة' : 'لا توجد بيانات' }}</h4>
        <p>جرّب تغيّر البحث أو الفلاتر.</p>
    </div>
@elseif ($view === 'deleted')

    {{-- نسخ الأصل بتاعها اتحذف: بتفضل فترة الاحتفاظ وبعدها بتتمسح تلقائيًا --}}
    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th>الملف</th>
                    <th>الدكتور / المريض</th>
                    <th>حجم النسخة</th>
                    <th>اتحذف من الـ Primary</th>
                    <th>تتمسح بعد</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $b)
                    @php
                        $expires = $b->source_deleted_at->copy()->addDays($retention);
                        $left = max(0, (int) ceil(now()->diffInDays($expires, false)));
                    @endphp
                    <tr>
                        <td data-label="الملف">
                            <div>
                                <div class="ap-title">{{ $b->original_name }}</div>
                                <div class="ap-sub">{{ str_starts_with((string) $b->mime_type, 'image/') ? 'صورة' : 'PDF' }}</div>
                            </div>
                        </td>
                        <td data-label="الدكتور / المريض">
                            <div>
                                <div class="ap-title">د. {{ $b->doctor_name ?? '—' }}</div>
                                <div class="ap-sub">{{ $b->patient_name ?? 'مريض محذوف' }}</div>
                            </div>
                        </td>
                        <td data-label="حجم النسخة"><span class="ap-num" dir="ltr">{{ PatientFileService::formatBytes((int) $b->size) }}</span></td>
                        <td data-label="اتحذف">{{ $b->source_deleted_at->copy()->timezone('Africa/Cairo')->translatedFormat('d M Y') }}</td>
                        <td data-label="تتمسح بعد"><span class="ap-badge {{ $left <= 5 ? 'ap-badge--bad' : 'ap-badge--warn' }}">{{ $left }} يوم</span></td>
                        <td data-label="">@include('admin.storage._restore_btn', ['id' => $b->id, 'deleted' => true])</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@else

    {{-- الملفات الحالية. مفيش معاينة للملف الطبي هنا (خصوصية)، بيانات بس. --}}
    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th>الملف</th>
                    <th>الدكتور / المريض</th>
                    <th>الحجم</th>
                    <th>تاريخ الرفع</th>
                    <th>الـ Primary</th>
                    <th>النسخة الاحتياطية</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $f)
                    <tr>
                        <td data-label="الملف">
                            <div>
                                <div class="ap-title">{{ $f->original_name }}</div>
                                <div class="ap-sub">#{{ $f->id }} • {{ str_starts_with((string) $f->mime_type, 'image/') ? 'صورة' : 'PDF' }}</div>
                            </div>
                        </td>
                        <td data-label="الدكتور / المريض">
                            <div>
                                <div class="ap-title">د. {{ $f->doctor_name ?? '—' }}</div>
                                <div class="ap-sub">{{ $f->patient_name ?? 'مريض محذوف' }}</div>
                            </div>
                        </td>
                        <td data-label="الحجم"><span class="ap-num" dir="ltr">{{ PatientFileService::formatBytes((int) $f->size) }}</span></td>
                        <td data-label="تاريخ الرفع">{{ $f->created_at?->copy()->timezone('Africa/Cairo')->translatedFormat('d M Y') }}</td>
                        <td data-label="الـ Primary">
                            <span class="ap-badge {{ $f->primary_ok ? 'ap-badge--ok' : 'ap-badge--bad' }}">{{ $f->primary_ok ? 'موجود' : 'مفقود' }}</span>
                        </td>
                        <td data-label="النسخة الاحتياطية">
                            <div>
                                @if ($f->backed_up_at)
                                    <span class="ap-badge ap-badge--ok"><i class="fa-solid fa-check"></i> اتنسخ</span>
                                    <div class="ap-sub">{{ \Carbon\Carbon::parse($f->backed_up_at)->timezone('Africa/Cairo')->translatedFormat('d M Y - h:i A') }}</div>
                                @elseif ($f->backup_last_error)
                                    <span class="ap-badge ap-badge--bad"><i class="fa-solid fa-xmark"></i> فشل النسخ</span>
                                    <div class="ap-err">{{ $f->backup_last_error }}</div>
                                @else
                                    <span class="ap-badge ap-badge--warn"><i class="fa-solid fa-hourglass-half"></i> لسه ما اتنسخش</span>
                                @endif
                            </div>
                        </td>
                        <td data-label="إجراء">
                            {{-- الاسترجاع بيظهر بس لو الملف مفقود من الـ Primary وليه نسخة --}}
                            @if (! $f->primary_ok && $f->backup_id)
                                @include('admin.storage._restore_btn', ['id' => $f->backup_id, 'deleted' => false])
                            @else
                                <span class="ap-sub">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endif
