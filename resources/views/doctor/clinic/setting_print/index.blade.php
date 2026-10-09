@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/pagination.css') }}">
@endpush

@extends('doctor.layouts.app_clinc')

@section('title', 'إعدادات الطباعة | دليل الأطباء')

@section('content')

    <x-home.banner.no_results
        logo="fa-solid fa-file-prescription"
        title="خيارات طباعة الروشتات قريبًا"
        content="نعمل حاليًا على إضافة أكثر من تصميم احترافي لطباعة الروشتات، لتتمكن من اختيار الشكل المناسب لك."
    />

@endsection