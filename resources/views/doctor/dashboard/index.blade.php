@extends('doctor.layouts.app')
@section('title', ' الصفحة الرئيسية|لوحة تحكم الطبيب')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/topbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/account&notification.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/subscription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/no_results.css') }}">
  <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/readability/account-notification.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/readability/subscription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/pending-review.css') }}">
@endpush

@section('content')

    @php
        $isPending = $doctor->status === 'pending';
    @endphp

    <div class="doctor-dash-wrap">

        @if ($isPending)
            <x-doctor.dashboard.pending-review :doctorname="$doctor_name" />
        @else
            <x-doctor.dashboard.topbar :doctor="$doctor" :doctorname="$doctor_name" />
        @endif

        <section class="account-grid">
            <x-doctor.dashboard.acount :doctor="$doctor" :doctorname="$doctor_name" />
            <x-doctor.dashboard.norification :notifications="$notifications" />
        </section>

        @unless ($isPending)
            <x-doctor.dashboard.subscription :doctor="$doctor" />
        @endunless

    </div>

@endsection
