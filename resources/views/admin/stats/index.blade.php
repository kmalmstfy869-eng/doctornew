@extends('admin.layout.app')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/admin/site-stats.css') }}?v={{ @filemtime(public_path('css/admin/site-stats.css')) ?: time() }}">
@endpush

@section('title', 'إحصائيات الزيارات | لوحة الإدارة')
@section('page-title', 'إحصائيات الزيارات')
@section('page-description', 'مشاهدات الموقع وزواره')

@section('content')
    @php
        $chip = function ($v) {
            if ($v === null) return null;
            return ['cls' => $v >= 0 ? 'up' : 'down', 'icon' => $v >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down', 'txt' => abs($v) . '%'];
        };
        $vc = $chip($viewsChange);
        $uc = $chip($uniqueChange);
    @endphp

    <div class="as-page" dir="rtl">

        {{-- HEAD --}}
        <div class="as-head">
            <div>
                <h2>إحصائيات الموقع</h2>
                <p>إجمالي المشاهدات والزوار على المنصة</p>
            </div>
            <div class="as-tabs">
                @foreach ($ranges as $key => $label)
                    <a href="{{ route('admin.stats', ['range' => $key]) }}" class="{{ $range === $key ? 'active' : '' }}">{{ $label }}</a>
                @endforeach
            </div>
        </div>

        {{-- CARDS --}}
        <div class="as-grid">
            <div class="as-card c-indigo">
                <div class="as-card-top">
                    <span class="as-icon"><i class="fa-solid fa-eye"></i></span>
                    @if ($vc)
                        <span class="as-chip {{ $vc['cls'] }}"><i class="fa-solid {{ $vc['icon'] }}"></i> {{ $vc['txt'] }}</span>
                    @else
                        <span class="as-chip"><i class="fa-regular fa-clock"></i> {{ $ranges[$range] }}</span>
                    @endif
                </div>
                <div class="as-value">{{ number_format($current['views']) }}</div>
                <div class="as-label">إجمالي الزيارات</div>
            </div>

            <div class="as-card c-sky">
                <div class="as-card-top">
                    <span class="as-icon"><i class="fa-solid fa-user-group"></i></span>
                    @if ($uc)
                        <span class="as-chip {{ $uc['cls'] }}"><i class="fa-solid {{ $uc['icon'] }}"></i> {{ $uc['txt'] }}</span>
                    @else
                        <span class="as-chip">{{ number_format($returning) }} متكررة</span>
                    @endif
                </div>
                <div class="as-value">{{ number_format($current['unique']) }}</div>
                <div class="as-label">الزوار الفريدون</div>
            </div>

            <div class="as-card c-green">
                <div class="as-card-top">
                    <span class="as-icon"><i class="fa-solid fa-chart-simple"></i></span>
                    <span class="as-chip">اليوم: {{ number_format($today['views']) }}</span>
                </div>
                <div class="as-value">{{ $average }}</div>
                <div class="as-label">متوسط الزيارات يوميًا</div>
            </div>

            <div class="as-card c-amber">
                <div class="as-card-top">
                    <span class="as-icon"><i class="fa-solid fa-infinity"></i></span>
                    <span class="as-chip">منذ البداية</span>
                </div>
                <div class="as-value">{{ number_format($allTime['views']) }}</div>
                <div class="as-label">إجمالي كل الأوقات</div>
            </div>
        </div>
        <p class="as-note">النسبة على الكروت مقارنة بالفترة السابقة بنفس الطول.</p>

        {{-- CHART + WEEKDAYS --}}
        <div class="as-row">
            <div class="dashboard-card as-panel">
                <h3>أداء الموقع</h3>
                <p class="sub">الزيارات والزوار خلال {{ $ranges[$range] }}</p>
                <div class="as-legend">
                    <span><i style="background:#4f46e5"></i>الزيارات</span>
                    <span><i style="background:#0ea5e9"></i>الزوار الفريدون</span>
                </div>
                <div class="as-chart"><canvas id="asChart"></canvas></div>
                <script type="application/json" id="asChartData">@json($chart)</script>
            </div>

            <div class="dashboard-card as-panel">
                <h3>أنشط أيام الأسبوع</h3>
                <p class="sub">توزيع الزيارات على أيام الأسبوع</p>
                <div class="as-wd">
                    @foreach ($weekdays as $w)
                        <div class="as-wd-row {{ $w['top'] ? 'top' : '' }}">
                            <span>{{ $w['name'] }}</span>
                            <div class="as-bar"><span style="width:{{ $w['percent'] }}%"></span></div>
                            <b>{{ number_format($w['views']) }}</b>
                        </div>
                    @endforeach
                </div>

                @if ($bestDay)
                    <div class="as-best">
                        <i class="fa-solid fa-trophy"></i>
                        <span>أفضل يوم: {{ $bestDay['label'] }} ({{ number_format($bestDay['views']) }} زيارة)</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- SPLIT --}}
        <div class="dashboard-card as-panel">
            <h3>مصدر الزيارات</h3>
            <p class="sub">الصفحة الرئيسية مقابل صفحات الأطباء خلال {{ $ranges[$range] }}</p>

            <div class="as-split">
                @foreach ([
                    ['key' => 'home', 'name' => 'الصفحة الرئيسية', 'icon' => 'fa-house', 'color' => '#4f46e5'],
                    ['key' => 'profiles', 'name' => 'صفحات الأطباء (إجمالي)', 'icon' => 'fa-user-doctor', 'color' => '#0ea5e9'],
                ] as $s)
                    @php
                        $v = $split[$s['key']]['views'];
                        $pct = round($v / $splitMax * 100);
                    @endphp
                    <div class="as-split-row">
                        <div class="as-split-top">
                            <span><i class="fa-solid {{ $s['icon'] }}" style="color:{{ $s['color'] }}"></i> {{ $s['name'] }}</span>
                            <b>{{ number_format($v) }} <small>/ {{ number_format($split[$s['key']]['unique']) }} زائر</small></b>
                        </div>
                        <div class="as-bar"><span style="width:{{ $v > 0 ? max($pct, 2) : 0 }}%;background:{{ $s['color'] }}"></span></div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection

@push('extra_java')
    <script src="{{ asset('js/admin/site-stats.js') }}?v={{ @filemtime(public_path('js/admin/site-stats.js')) ?: time() }}"></script>
@endpush
