@extends('admin.layout.app')
@use('App\Services\PatientFileService')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush

@section('title', 'سجل النسخ الاحتياطي | لوحة الإدارة')
@section('page-title', 'سجل تشغيل النسخ الاحتياطي')
@section('page-description', 'كل تشغيل للـ Backup ونتيجته')

@section('content')

    @include('admin.storage._nav')

    <div class="dashboard-card ap-card">

        <div class="ap-card__head">
            <div>
                <h3>التشغيلات</h3>
                <p>{{ $runs->total() }} تشغيل • "جزئي" مش بيتحسب نجاح كامل</p>
            </div>
            @include('admin.storage._run_button')
        </div>

        <form method="GET" class="ap-filters">
            <div class="ap-field">
                <label>الحالة</label>
                <select name="status" class="ap-input" onchange="this.form.submit()">
                    <option value="">الكل</option>
                    <option value="success" @selected($status === 'success')>ناجح</option>
                    <option value="partial" @selected($status === 'partial')>جزئي</option>
                    <option value="failed" @selected($status === 'failed')>فشل</option>
                    <option value="running" @selected($status === 'running')>شغال / معلّق</option>
                </select>
            </div>
            <div class="ap-field">
                <label>من</label>
                <input type="date" name="from" value="{{ $from }}" class="ap-input" onchange="this.form.submit()">
            </div>
            <div class="ap-field">
                <label>إلى</label>
                <input type="date" name="to" value="{{ $to }}" class="ap-input" onchange="this.form.submit()">
            </div>
            <a href="{{ route('admin.storage.runs') }}" class="ap-btn ap-btn--ghost">مسح الفلاتر</a>
        </form>

        @if ($runs->isEmpty())
            <div class="ap-empty">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <h4>لا توجد تشغيلات</h4>
                <p>مفيش تشغيل مطابق للفلاتر.</p>
            </div>
        @else
            <div class="ap-table-wrap">
                <table class="ap-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>البداية</th>
                            <th>النهاية</th>
                            <th>المدة</th>
                            <th>الحالة</th>
                            <th>اتنسخ</th>
                            <th>فشل</th>
                            <th>اتمسح</th>
                            <th>الحجم</th>
                            <th>الخطأ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($runs as $run)
                            <tr>
                                <td data-label="#"><span class="ap-num">{{ $run->id }}</span></td>
                                <td data-label="البداية">{{ $run->started_label }}</td>
                                <td data-label="النهاية">{{ $run->finished_label }}</td>
                                <td data-label="المدة">{{ $run->duration_label }}</td>
                                <td data-label="الحالة"><span class="ap-badge ap-badge--{{ $run->status_tone }}">{{ $run->status_label }}</span></td>
                                <td data-label="اتنسخ"><span class="ap-num">{{ $run->copied_count }}</span></td>
                                <td data-label="فشل"><span class="ap-num {{ $run->failed_count ? 'ap-minus' : '' }}">{{ $run->failed_count }}</span></td>
                                <td data-label="اتمسح"><span class="ap-num">{{ $run->purged_count }}</span></td>
                                <td data-label="الحجم"><span class="ap-num" dir="ltr">{{ PatientFileService::formatBytes((int) $run->copied_bytes) }}</span></td>
                                <td data-label="الخطأ">
                                    @if ($run->error)
                                        <details><summary class="ap-minus" style="cursor:pointer">عرض</summary><div class="ap-err">{{ $run->error }}</div></details>
                                    @else
                                        <span class="ap-sub">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="ap-card__foot">{{ $runs->links('vendor.pagination.custom') }}</div>
        @endif

    </div>

@endsection
