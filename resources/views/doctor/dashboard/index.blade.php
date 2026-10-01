@extends('doctor.layouts.app')
@section('title', ' الصفحة الرئيسية|لوحة تحكم الطبيب')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/topbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/account&notification.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/subscription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/no_results.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/readability/topbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/readability/account-notification.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/readability/subscription.css') }}">
@endpush

@section('content')
    <x-doctor.dashboard.topbar :doctor="$doctor" :doctorname="$doctor_name" />


    <section class="account-grid">

        <x-doctor.dashboard.acount :doctor="$doctor" :doctorname="$doctor_name" />

        <x-doctor.dashboard.norification  :notifications="$notifications" />

    </section>

    <x-doctor.dashboard.subscription :doctor="$doctor" />


@endsection
