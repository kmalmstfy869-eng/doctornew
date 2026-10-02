<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b1020">

    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('logo/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/readability/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/readability/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/ux.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @stack('extra_style')
</head>


<body>

<x-home.info.flash-message/>

    <div class="app">

        <div class="background">
            <div class="grid-bg"></div>
            <div class="blob one"></div>
            <div class="blob two"></div>
        </div>


        <div class="overlay" id="overlay" onclick="closeSidebar()">
        </div>

        <x-doctor.dashboard.sidebar :doctor="$doctor" :doctorname="$doctor_name" />

        <main class="main">

            <x-doctor.dashboard.header :doctor="$doctor" :doctorname="$doctor_name" :notifications="$notificationsheader"/>


            @yield('content')

            <x-doctor.dashboard.footer />
