@use('App\Services\PatientFileService')

@if ($doctors->isEmpty())
    <div class="ap-empty">
        <i class="fa-solid fa-user-doctor"></i>
        <h4>لا يوجد أطباء</h4>
        <p>مفيش طبيب مطابق للبحث أو الفلتر.</p>
    </div>
@else
    <div class="ap-table-wrap">
        <table class="ap-table">
            <thead>
                <tr>
                    <th>الدكتور</th>
                    <th>المسموح</th>
                    <th>المستخدم</th>
                    <th>المتبقي</th>
                    <th>الاستهلاك</th>
                    <th>الملفات</th>
                    <th>الحالة</th>
                    <th>إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doctors as $d)
                    @php
                        $quotaGb = (float) $d->patient_files_quota_gb;
                        $limitBytes = $quotaGb * 1073741824;
                        $used = (int) $d->used_bytes;
                        $pct = $limitBytes > 0 ? min(100, round($used / $limitBytes * 100, 1)) : 100;
                        $full = $used >= $limitBytes;
                        $near = ! $full && $pct >= config('clinic.patient_files_near_limit_percent', 90);
                        $tone = $full ? 'bad' : ($near ? 'warn' : 'ok');
                        $quotaLabel = rtrim(rtrim(number_format($quotaGb, 3), '0'), '.');
                    @endphp
                    <tr>
                        <td data-label="الدكتور">
                            <div>
                                <div class="ap-title">د. {{ $d->doctor_name }}</div>
                                <div class="ap-sub">{{ $d->doctor_email }}</div>
                            </div>
                        </td>
                        <td data-label="المسموح"><span class="ap-num" dir="ltr">{{ $quotaLabel }} GB</span></td>
                        <td data-label="المستخدم"><span class="ap-num" dir="ltr">{{ PatientFileService::formatBytes($used) }}</span></td>
                        <td data-label="المتبقي"><span class="ap-num" dir="ltr">{{ PatientFileService::formatBytes((int) max(0, $limitBytes - $used), true) }}</span></td>
                        <td data-label="الاستهلاك">
                            <div class="ap-meter-row">
                                <div class="ap-meter ap-meter--{{ $tone }}" style="flex:1"><span style="width: {{ $used > 0 ? max($pct, 2) : 0 }}%"></span></div>
                                <small>{{ $pct }}%</small>
                            </div>
                        </td>
                        <td data-label="الملفات"><span class="ap-num">{{ number_format($d->files_count) }}</span></td>
                        <td data-label="الحالة">
                            <span class="ap-badge ap-badge--{{ $tone }}">{{ $full ? 'ممتلئ' : ($near ? 'قرب من الحد' : 'طبيعي') }}</span>
                        </td>
                        <td data-label="إجراء">
                            <a href="{{ route('admin.storage.extra.index', ['search' => $d->doctor_name]) }}"
                                class="ap-btn ap-btn--primary ap-btn--sm">
                                <i class="fa-solid fa-cubes-stacked"></i> اشتراك المساحة
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
