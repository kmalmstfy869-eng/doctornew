@extends('doctor.layouts.app')
@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/home/settings.css') }}">
@endpush
@section('title', 'دليل الأطباء | ملفك الشخصي')

@section('content')

    @include('settings.index')

@endsection
