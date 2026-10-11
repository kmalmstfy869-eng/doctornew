{{-- تنقل سريع بين صفحات التخزين --}}
@php
    $items = [
        ['admin.storage.overview', 'fa-gauge-high', 'نظرة عامة'],
        ['admin.storage.files', 'fa-folder-open', 'الملفات والنسخ'],
        ['admin.storage.runs', 'fa-clock-rotate-left', 'سجل التشغيل'],
        ['admin.storage.restore', 'fa-rotate-left', 'الاسترجاع'],
        ['admin.storage.quotas', 'fa-sliders', 'مساحات الأطباء'],
    ];
@endphp

<nav class="ap-tabs">
    @foreach ($items as [$r, $icon, $label])
        <a href="{{ route($r) }}" class="ap-tab {{ request()->routeIs($r) ? 'is-active' : '' }}">
            <i class="fa-solid {{ $icon }}"></i><span>{{ $label }}</span>
        </a>
    @endforeach
</nav>
