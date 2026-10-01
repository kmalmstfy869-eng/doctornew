<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="bq-no-print"> @yield('title') </title>
    <meta name="description" content="ملخص يومي لحالة العيادة: الحجوزات، الطابور، المواعيد والإيرادات.">
    <meta property="og:title" content="لوحة التحكم">
    <meta property="og:description" content="ملخص يومي لحالة العيادة: الحجوزات، الطابور، المواعيد والإيرادات.">
    <link rel="icon" href="assets/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/doctor/clinic/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clinic/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clinic/responsive.css') }}">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    @stack('extra_style')
</head>

<body class="min-h-screen w-full overflow-x-hidden bg-background text-foreground">
<x-home.info.flash-message/>
    <x-doctor.clinic.sidebar />
    <div id="drawer-overlay" class="clinic-no-print fixed inset-0 z-40 hidden bg-foreground/45 lg:hidden"
        style="backdrop-filter:blur(2px)">
    </div>

    <div class="clinic-content-area">

        <x-doctor.clinic.header />

        @yield('content')

    </div>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/clinic/app.js') }}"></script>
    @stack('extra_java')
</body>

</html>
