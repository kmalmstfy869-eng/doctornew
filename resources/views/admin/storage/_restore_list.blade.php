@use('App\Services\PatientFileService')

@if ($rows->isEmpty())
    <div class="ap-empty">
        <i class="fa-solid fa-box-archive"></i>
        <h4>لا توجد نسخ</h4>
        <p>مفيش نسخ احتياطية مطابقة للبحث.</p>
    </div>
@else
    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th>الملف</th>
                    <th>الدكتور / المريض</th>
                    <th>تاريخ النسخة</th>
                    <th>الأصل في الـ Primary</th>
                    <th>سجل الداتابيز</th>
                    <th>الحالة</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $b)
                    @php
                        $deleted = (bool) $b->source_deleted_at;
                        $needs = ! $b->primary_ok || ! $b->row_ok;
                    @endphp
                    <tr>
                        <td data-label="الملف">
                            <div>
                                <div class="ap-title">{{ $b->original_name }}</div>
                                <div class="ap-sub" dir="ltr" style="text-align:start">{{ PatientFileService::formatBytes((int) $b->size) }}</div>
                            </div>
                        </td>
                        <td data-label="الدكتور / المريض">
                            <div>
                                <div class="ap-title">د. {{ $b->doctor_name ?? '—' }}</div>
                                <div class="ap-sub">{{ $b->patient_name ?? 'مريض محذوف' }}</div>
                            </div>
                        </td>
                        <td data-label="تاريخ النسخة">{{ $b->backed_up_at?->copy()->timezone('Africa/Cairo')->translatedFormat('d M Y') }}</td>
                        <td data-label="الأصل"><span class="ap-badge {{ $b->primary_ok ? 'ap-badge--ok' : 'ap-badge--bad' }}">{{ $b->primary_ok ? 'موجود' : 'مفقود' }}</span></td>
                        <td data-label="السجل"><span class="ap-badge {{ $b->row_ok ? 'ap-badge--ok' : 'ap-badge--bad' }}">{{ $b->row_ok ? 'موجود' : 'ناقص' }}</span></td>
                        <td data-label="الحالة">
                            @if ($deleted)
                                <span class="ap-badge ap-badge--warn">اتحذف عمدًا</span>
                                <div class="ap-sub">يتمسح بعد {{ max(0, (int) ceil(now()->diffInDays($b->source_deleted_at->copy()->addDays($retention), false))) }} يوم</div>
                            @elseif ($needs)
                                <span class="ap-badge ap-badge--bad">ضايع (محتاج استرجاع)</span>
                            @else
                                <span class="ap-badge ap-badge--ok">سليم</span>
                            @endif
                        </td>
                        <td data-label="إجراء">
                            @if ($deleted || $needs)
                                @include('admin.storage._restore_btn', ['id' => $b->id, 'deleted' => $deleted])
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
