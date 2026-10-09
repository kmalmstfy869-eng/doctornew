@extends('admin.layout.app')
@use('App\Services\PatientFileService')

@section('title', 'ملفات المرضى والتخزين | لوحة الإدارة')
@section('page-title', 'ملفات المرضى والتخزين')
@section('page-description', 'نظرة عامة على الملفات والنسخ الاحتياطية ومساحات الأطباء')

@section('content')

    @include('admin.storage._nav')

    {{-- كل الأرقام محسوبة من الداتابيز. حجم النسخ = مجموع أحجام سجلات النسخ (مش فحص فعلي للتخزين). --}}
    <div class="stats-grid">

        <a href="{{ route('admin.storage.files') }}" class="stat-card ap-link-card">
            <div class="stat-icon blue-icon"><i class="fa-solid fa-folder-open"></i></div>
            <div class="stat-info">
                <p>ملفات المرضى</p>
                <h3>{{ number_format($totalFiles) }}</h3>
            </div>
        </a>

        <a href="{{ route('admin.storage.quotas') }}" class="stat-card ap-link-card">
            <div class="stat-icon purple-icon"><i class="fa-solid fa-hard-drive"></i></div>
            <div class="stat-info">
                <p>المساحة المستخدمة (Primary)</p>
                <h3 dir="ltr">{{ PatientFileService::formatBytes($usedBytes) }}</h3>
            </div>
        </a>

        <a href="{{ route('admin.storage.files') }}" class="stat-card ap-link-card">
            <div class="stat-icon ap-icon-teal"><i class="fa-solid fa-cloud"></i></div>
            <div class="stat-info">
                <p>حجم النسخ الاحتياطية</p>
                <h3 dir="ltr">{{ PatientFileService::formatBytes($backupBytes) }}</h3>
                <span class="ap-hint">من سجلات النسخ</span>
            </div>
        </a>

        <a href="{{ route('admin.storage.files', ['status' => 'done']) }}" class="stat-card ap-link-card">
            <div class="stat-icon green-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-info">
                <p>اتنسخ</p>
                <h3>{{ number_format($backedUp) }}</h3>
            </div>
        </a>

        <a href="{{ route('admin.storage.files', ['status' => 'pending']) }}" class="stat-card ap-link-card">
            <div class="stat-icon orange-icon"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-info">
                <p>لسه ما اتنسخش</p>
                <h3>{{ number_format($pending) }}</h3>
                <span class="ap-hint">مستني دوره في الـ Backup الجاي</span>
            </div>
        </a>

        <a href="{{ route('admin.storage.files', ['status' => 'failed']) }}" class="stat-card ap-link-card">
            <div class="stat-icon ap-icon-red"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="stat-info">
                <p>فشل نسخها</p>
                <h3>{{ number_format($failed) }}</h3>
            </div>
        </a>

        <a href="{{ route('admin.storage.restore') }}" class="stat-card ap-link-card">
            <div class="stat-icon blue-icon"><i class="fa-solid fa-rotate-left"></i></div>
            <div class="stat-info">
                <p>ملفات قابلة للاسترجاع</p>
                <h3>{{ number_format($restorable) }}</h3>
                <span class="ap-hint">منهم {{ number_format($deletedKept) }} الأصل اتحذف</span>
            </div>
        </a>

        <a href="{{ route('admin.storage.quotas', ['limit' => 'attention']) }}" class="stat-card ap-link-card">
            <div class="stat-icon ap-icon-red"><i class="fa-solid fa-gauge-high"></i></div>
            <div class="stat-info">
                <p>أطباء قربوا من الحد</p>
                <h3>{{ number_format($attention->count()) }}</h3>
                <span class="ap-hint">{{ config('clinic.patient_files_near_limit_percent', 90) }}% أو أكتر</span>
            </div>
        </a>

    </div>

    <div class="ap-grid-2" style="margin-top:1rem">

        {{-- آخر تشغيل --}}
        <div class="dashboard-card ap-card">
            <div class="ap-card__head">
                <div>
                    <h3>آخر تشغيل للنسخ الاحتياطي</h3>
                    <p>الجدولة اليومية الساعة 4 الفجر بتوقيت القاهرة</p>
                </div>
                @include('admin.storage._run_button')
            </div>

            <div class="ap-card__body">
                @if ($lastRun)
                    <div class="ap-kv">
                        <div><span>الحالة</span><b><span class="ap-badge ap-badge--{{ $lastRun->status_tone }}">{{ $lastRun->status_label }}</span></b></div>
                        <div><span>بدأ</span><b>{{ $lastRun->started_label }}</b></div>
                        <div><span>المدة</span><b>{{ $lastRun->duration_label }}</b></div>
                        <div><span>اتنسخ</span><b>{{ $lastRun->copied_count }} ({{ PatientFileService::formatBytes((int) $lastRun->copied_bytes) }})</b></div>
                        <div><span>فشل</span><b>{{ $lastRun->failed_count }}</b></div>
                        <div><span>اتمسح بعد الاحتفاظ</span><b>{{ $lastRun->purged_count }}</b></div>
                        <div style="grid-column:1/-1"><span>آخر تشغيل ناجح</span><b>{{ $lastSuccess ? $lastSuccess->finished_label : 'لسه مفيش تشغيل ناجح' }}</b></div>
                    </div>

                    @if ($lastRun->error)
                        <div class="ap-alert ap-alert--bad" style="margin-top:1rem">{{ $lastRun->error }}</div>
                    @endif

                    <a href="{{ route('admin.storage.runs') }}" class="ap-btn ap-btn--ghost ap-btn--sm" style="margin-top:1rem">كل التشغيلات</a>
                @else
                    <div class="ap-empty">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <h4>مفيش تشغيل لسه</h4>
                        <p>دوس "شغّل Backup الآن" أو استنى الجدولة اليومية.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- أطباء قربوا من الحد --}}
        <div class="dashboard-card ap-card">
            <div class="ap-card__head">
                <div>
                    <h3>أطباء قربوا من الحد</h3>
                    <p>الأعلى استهلاكًا</p>
                </div>
                <a href="{{ route('admin.storage.quotas') }}" class="ap-btn ap-btn--ghost ap-btn--sm">إدارة المساحات</a>
            </div>

            <div class="ap-card__body">
                @forelse ($attention->take(5) as $d)
                    @php
                        $limit = (float) $d->patient_files_quota_gb * 1073741824;
                        $used = (int) $d->used_bytes;
                        $pct = $limit > 0 ? min(100, round($used / $limit * 100, 1)) : 100;
                        $tone = $used >= $limit ? 'bad' : 'warn';
                    @endphp
                    <div style="margin-bottom:1rem">
                        <div style="display:flex;justify-content:space-between;gap:.5rem;font-size:.85rem;font-weight:800">
                            <span>د. {{ $d->doctor_name }}</span>
                            <span dir="ltr">{{ PatientFileService::formatBytes($used) }} / {{ rtrim(rtrim(number_format((float) $d->patient_files_quota_gb, 2), '0'), '.') }} GB</span>
                        </div>
                        <div class="ap-meter-row" style="margin-top:.4rem">
                            <div class="ap-meter ap-meter--{{ $tone }}" style="flex:1"><span style="width: {{ max($pct, 2) }}%"></span></div>
                            <small>{{ $pct }}%</small>
                        </div>
                    </div>
                @empty
                    <div class="ap-empty">
                        <i class="fa-solid fa-circle-check"></i>
                        <h4>كله تمام</h4>
                        <p>مفيش طبيب قرب من حد المساحة.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

@endsection
