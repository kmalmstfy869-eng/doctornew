@extends('admin.layout.app')

@section('title', 'لوحة التحكم | إضافة طبيب جديد')

@section('content')

    <div class="doctor-edit-page">

        {{-- =========================================================
        HEADER
        ========================================================== --}}

        <div class="doctor-edit-header">

            <div class="doctor-edit-title">

                <div class="title-icon">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>

                <div class="title-content">

                    <span class="title-small">
                        إدارة الأطباء
                    </span>

                    <h1>
                        إضافة طبيب جديد
                    </h1>

                    <p>
                        إضافة بيانات الطبيب والعيادة والاشتراك
                    </p>

                </div>

            </div>

            <a href="{{ route('admin.dashboard') }}" class="back-btn">

                <i class="fa-solid fa-arrow-right"></i>

                <span>
                    خروج
                </span>

            </a>

        </div>


        {{-- =========================================================
        LAYOUT
        ========================================================== --}}

        <div class="doctor-edit-layout">


            {{-- =====================================================
            PROFILE SIDEBAR
            ====================================================== --}}

            <aside class="doctor-profile-card">


                {{-- PROFILE TITLE --}}

                <div class="profile-card-title">

                    <div class="profile-title-icon">
                        <i class="fa-solid fa-image"></i>
                    </div>

                    <div>

                        <h2>
                            صورة الطبيب
                        </h2>

                        <p>
                            الصورة التي ستظهر في دليل الأطباء
                        </p>

                    </div>

                </div>


                {{-- =================================================
                PROFILE IMAGE
                ================================================== --}}

                <div class="profile-image-area">

                    <div class="profile-image-wrapper">

                        <div id="doctorImageDefault" class="doctor-default-image">

                            <i class="fa-solid fa-user-doctor"></i>

                        </div>

                        <img id="doctorImagePreview" src="" alt="صورة الطبيب" class="profile-image"
                            style="display:none;">

                        <div class="profile-image-actions">

                            <label for="doctorImageInput" class="change-profile-btn" title="اختيار صورة جديدة">

                                <i class="fa-solid fa-camera"></i>

                            </label>

                        </div>

                    </div>

                </div>


                {{-- IMAGE ERROR --}}

                @error('doctor_image')
                    <div class="profile-image-error">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <span>
                            {{ $message }}
                        </span>

                    </div>
                @enderror


                {{-- UPLOAD PROFILE IMAGE --}}

                <label for="doctorImageInput" class="upload-profile">

                    <span class="upload-profile-icon">

                        <i class="fa-solid fa-cloud-arrow-up"></i>

                    </span>

                    <span class="upload-profile-text">

                        <strong>
                            اختيار صورة الطبيب
                        </strong>

                        <small>
                            اضغط هنا لاختيار صورة جديدة
                        </small>

                    </span>

                    <input type="file" id="doctorImageInput" name="doctor_image" form="createDoctorForm"
                        accept="image/jpeg,image/png,image/jpg">

                </label>


                <div class="upload-note">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>
                        JPG أو PNG — الحد الأقصى 5MB
                    </span>

                </div>


                {{-- DOCTOR INFO --}}

                <div class="profile-doctor-info">

                    <span class="doctor-profile-label">
                        الطبيب
                    </span>

                    <h3>
                        طبيب جديد
                    </h3>

                    <p>

                        <i class="fa-solid fa-stethoscope"></i>

                        سيتم تحديد التخصص من النموذج

                    </p>

                </div>


                {{-- SUBSCRIPTION STATUS --}}

                @if ($showSubscriptionForm)
                    <div class="subscription-status subscribed">

                        <span class="status-icon">

                            <i class="fa-solid fa-check"></i>

                        </span>

                        <span>
                            سيتم إضافة اشتراك للطبيب
                        </span>

                    </div>
                @else
                    <div class="subscription-status unsubscribed">

                        <span class="status-icon">

                            <i class="fa-solid fa-user-slash"></i>

                        </span>

                        <span>
                            بدون اشتراك
                        </span>

                    </div>
                @endif

            </aside>


            {{-- =========================================================
            MAIN CONTENT
            ========================================================== --}}

            <main class="doctor-form-content">


                {{-- =====================================================
                CREATE DOCTOR FORM
                ====================================================== --}}

                <form id="createDoctorForm" action="{{ route('admin.doctor.store') }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf


                    {{-- =================================================
                    BASIC INFORMATION
                    ================================================== --}}

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">

                                <i class="fa-solid fa-user-doctor"></i>

                            </div>

                            <div>

                                <h2>
                                    المعلومات الأساسية
                                </h2>

                                <p>
                                    البيانات الأساسية للطبيب التي تظهر في الدليل
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            {{-- NAME --}}

                            <div class="form-group">

                                <label for="doctorName">
                                    اسم الطبيب
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-user"></i>

                                    <input id="doctorName" type="text" name="name" value="{{ old('name') }}"
                                        placeholder="اكتب اسم الطبيب" required>

                                </div>

                                @error('name')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- EMAIL --}}

                            <div class="form-group">

                                <label for="email">
                                    البريد الإلكتروني
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-envelope"></i>

                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        placeholder="example@email.com" required>

                                </div>

                                @error('email')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- PASSWORD --}}

                            <div class="form-group">

                                <label for="password">
                                    كلمة المرور
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-lock"></i>

                                    <input id="password" type="password" name="password" placeholder="اكتب كلمة المرور"
                                        required>

                                </div>

                                @error('password')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <div class="form-group">

                                <label for="password">
                                    تاكيد كلمه المرور
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-lock"></i>

                                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder=" اكتب كلمه المرور مره اخرى  "
                                        required>

                                </div>

                                @error('password_confirmation')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- SPECIALTY --}}

                            <div class="form-group">

                                <label for="specialty">
                                    التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-stethoscope"></i>

                                    <select id="specialty" name="specialty_id" required>

                                        <option value="">
                                            اختر التخصص
                                        </option>

                                        @foreach ($specialties as $specialty)
                                            <option value="{{ $specialty->id }}" @selected(old('specialty_id') == $specialty->id)>

                                                {{ $specialty->name }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                @error('specialty_id')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- AREA --}}

                            <div class="form-group">

                                <label for="area">
                                    المنطقة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <select id="area" name="area_id" required>

                                        <option value="">
                                            اختر المنطقة
                                        </option>

                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}" @selected(old('area_id') == $area->id)>

                                                {{ $area->name }}

                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                @error('area_id')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- PHONE --}}

                            <div class="form-group">

                                <label for="phone">
                                    رقم الهاتف
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-phone"></i>

                                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                        placeholder="مثال: 01012345678">

                                </div>

                                @error('phone')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- EXPERIENCE --}}

                            <div class="form-group">

                                <label for="experience">
                                    سنوات الخبرة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-user-clock"></i>

                                    <input id="experience" type="number" name="experience"
                                        value="{{ old('experience') }}" placeholder="عدد سنوات الخبرة" min="0">

                                    <span class="input-unit">
                                        سنة
                                    </span>

                                </div>

                                @error('experience')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- WHATSAPP --}}

                            <div class="form-group">

                                <label for="whatsapp">
                                    رقم واتساب
                                </label>

                                <div class="input-wrapper whatsapp-input">

                                    <i class="fa-brands fa-whatsapp"></i>

                                    <input id="whatsapp" type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                                        placeholder="مثال: 01012345678">

                                </div>

                                @error('whatsapp')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- CONSULTATION PRICE --}}

                            <div class="form-group">

                                <label for="consultationPrice">
                                    سعر الكشف
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-money-bill-wave"></i>

                                    <input id="consultationPrice" type="number" name="consultation_price"
                                        value="{{ old('consultation_price') }}" placeholder="مثال: 300" min="0">

                                    <span class="input-unit">
                                        جنيه
                                    </span>

                                </div>

                                @error('consultation_price')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- BIO --}}

                            <div class="form-group full">

                                <label for="bio">
                                    نبذة عن الطبيب
                                </label>

                                <div class="textarea-box">

                                    <textarea id="bio" name="bio" rows="5" placeholder="اكتب نبذة مختصرة عن الطبيب وخبرته وتخصصه...">{{ old('bio') }}</textarea>

                                </div>

                                @error('bio')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    CLINIC INFORMATION
                    ================================================== --}}

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">

                                <i class="fa-solid fa-hospital"></i>

                            </div>

                            <div>

                                <h2>
                                    معلومات العيادة
                                </h2>

                                <p>
                                    بيانات ومعلومات العيادة الأساسية
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            {{-- CLINIC NAME --}}

                            <div class="form-group">

                                <label for="clinicName">
                                    اسم العيادة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-house-medical"></i>

                                    <input id="clinicName" type="text" name="clinic_name"
                                        value="{{ old('clinic_name') }}" placeholder="اكتب اسم العيادة">

                                </div>

                                @error('clinic_name')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- ADDRESS --}}

                            <div class="form-group">

                                <label for="address">
                                    عنوان العيادة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <input id="address" type="text" name="address" value="{{ old('address') }}"
                                        placeholder="اكتب عنوان العيادة">

                                </div>

                                @error('address')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- WORKING HOURS --}}

                            <div class="form-group full">

                                <label for="workingHours">
                                    مواعيد العمل
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-regular fa-clock"></i>

                                    <input id="workingHours" type="text" name="working_hours"
                                        value="{{ old('working_hours') }}" placeholder="مثال: من 4 مساءً إلى 10 مساءً">

                                </div>

                                @error('working_hours')
                                    <small class="field-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    SUBSCRIPTION
                    ================================================== --}}

                    @if ($showSubscriptionForm)

                        <div class="edit-card subscription-card">


                            {{-- SUBSCRIPTION HEADER --}}

                            <div class="subscription-header">

                                <div class="card-title subscription-title">

                                    <div class="card-title-icon crown">

                                        <i class="fa-solid fa-crown"></i>

                                    </div>

                                    <div>

                                        <h2>
                                            اشتراك الطبيب
                                        </h2>

                                        <p>
                                            إضافة الاشتراك مع إنشاء الطبيب
                                        </p>

                                    </div>

                                </div>


                                <span class="subscription-badge active">

                                    <i class="fa-solid fa-circle-check"></i>

                                    سيتم تفعيل الاشتراك

                                </span>

                            </div>


                            {{-- SUBSCRIPTION DATA --}}

                            <div class="subscription-section">

                                <div class="section-heading">

                                    <div class="section-heading-icon">

                                        <i class="fa-solid fa-box-open"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            بيانات الاشتراك
                                        </strong>

                                        <span>
                                            الباقة والتاريخ والسعر
                                        </span>

                                    </div>

                                </div>


                                <div class="subscription-form-grid">


                                    {{-- PLAN --}}

                                    <div class="form-group">

                                        <label for="subscriptionPlan">
                                            الباقة
                                        </label>

                                        <div class="input-wrapper">

                                            <i class="fa-solid fa-box"></i>

                                            <select id="subscriptionPlan" name="plan_id" required>

                                                <option value="">
                                                    اختر الباقة
                                                </option>

                                                @foreach ($plans as $plan)
                                                    <option value="{{ $plan->id }}" @selected(old('plan_id') == $plan->id)>

                                                        {{ $plan->name }} -
                                                        {{ $plan->price }} جنيه -
                                                        {{ round($plan->duration / 30) }} شهر

                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>

                                        @error('plan_id')
                                            <small class="field-error">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- START DATE --}}

                                    <div class="form-group">

                                        <label for="subscriptionStartDate">
                                            تاريخ البداية
                                        </label>

                                        <div class="input-wrapper">

                                            <input id="subscriptionStartDate" type="date" name="start_date"
                                                value="{{ old('start_date', now()->format('Y-m-d')) }}"
                                                min="{{ now()->format('Y-m-d') }}" required>

                                        </div>

                                        @error('start_date')
                                            <small class="field-error">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- PRICE --}}

                                    <div class="form-group">

                                        <label for="subscriptionPrice">
                                            سعر الاشتراك
                                        </label>

                                        <div class="input-wrapper">

                                            <input id="subscriptionPrice" type="number" name="price" min="0"
                                                value="{{ old('price') }}" placeholder="مثال: 300" required>

                                            <span class="input-unit">
                                                جنيه
                                            </span>

                                        </div>

                                        @error('price')
                                            <small class="field-error">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- =================================================
                            EXTRA DATA
                            ================================================== --}}

                            <div class="subscription-section">

                                <div class="section-heading">

                                    <div class="section-heading-icon star">

                                        <i class="fa-solid fa-star"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            البيانات الإضافية
                                        </strong>

                                        <span>
                                            الخدمات والموقع وصور العيادة
                                        </span>

                                    </div>

                                </div>


                                <div class="subscription-extra-grid">


                                    {{-- SERVICES --}}

                                    <div class="form-group full">

                                        <label for="services">
                                            خدمات الطبيب
                                        </label>

                                        <div class="textarea-box">

                                            <textarea id="services" name="services" rows="4" placeholder="اكتب كل خدمة في سطر منفصل">{{ old('services') }}</textarea>

                                        </div>

                                        @error('services')
                                            <small class="field-error">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                        @error('services.*')
                                            <small class="field-error">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- GOOGLE MAPS --}}

                                    <div class="form-group full">

                                        <label for="googleMapsUrl">
                                            موقع العيادة على Google Maps
                                        </label>

                                        <div class="input-wrapper">

                                            <i class="fa-solid fa-map-location-dot"></i>

                                            <input id="googleMapsUrl" type="url" name="google_maps_url"
                                                value="{{ old('google_maps_url') }}"
                                                placeholder="https://maps.google.com/...">

                                        </div>

                                        @error('google_maps_url')
                                            <small class="field-error">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>


                                    {{-- CLINIC IMAGES --}}

                                    <div class="form-group full">

                                        <label class="field-label">
                                            صور العيادة
                                        </label>


                                        {{-- NEW IMAGES PREVIEW --}}

                                        <div id="clinicImagesPreview" class="clinic-images-preview">
                                        </div>


                                        {{-- NEW IMAGES UPLOAD --}}

                                        <div class="clinic-images-upload">

                                            <label for="clinicImagesInput" class="clinic-images-dropzone">

                                                <i class="fa-solid fa-images"></i>

                                                <strong>
                                                    أضف صور للعيادة
                                                </strong>

                                                <input type="file" id="clinicImagesInput" name="clinic_images[]"
                                                    accept="image/jpeg,image/png,image/jpg" multiple>

                                            </label>

                                        </div>


                                        {{-- IMAGE COUNT --}}

                                        <div id="clinicImagesCount" class="clinic-images-count">

                                            <span class="count-icon">

                                                <i class="fa-solid fa-images"></i>

                                            </span>

                                            <span class="count-text">
                                                لم يتم اختيار صور جديدة
                                            </span>

                                        </div>


                                        <div class="input-hint">

                                            <i class="fa-solid fa-circle-info"></i>

                                            يمكنك إضافة حتى 3 صور للعيادة.

                                        </div>


                                        @error('clinic_images')
                                            <small class="field-error">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                        @error('clinic_images.*')
                                            <small class="field-error">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                    ACTIONS
                    ================================================== --}}

                    <div class="save-section">

                        <button type="submit" class="save-btn" data-submit-form="createDoctorForm">

                            <i class="fa-solid fa-floppy-disk"></i>

                            <span>
                                حفظ الطبيب
                            </span>

                        </button>

                    </div>

                </form>


                {{-- =====================================================
                SUBSCRIPTION TOGGLE
                ====================================================== --}}

                @if (!$showSubscriptionForm)
                    <div class="edit-card no-subscription-card">

                        <div class="empty-subscription">

                            <div class="empty-icon">

                                <i class="fa-solid fa-user-slash"></i>

                            </div>

                            <div class="empty-content">

                                <span class="empty-label">
                                    الاشتراك
                                </span>

                                <h2>
                                    إنشاء الطبيب بدون اشتراك
                                </h2>

                                <p>
                                    يمكنك إنشاء الطبيب أولًا بدون اشتراك،
                                    أو فتح نموذج الاشتراك لإرسال بيانات الطبيب والاشتراك معًا.
                                </p>

                            </div>

                        </div>


                        <a href="{{ route('admin.doctor.create', ['subscribe' => 1]) }}" class="activate-btn">

                            <i class="fa-solid fa-plus"></i>

                            <span>
                                إضافة اشتراك مع الطبيب
                            </span>

                        </a>

                    </div>
                @else
                    <div class="edit-card no-subscription-card">

                        <div class="empty-subscription">

                            <div class="empty-icon">

                                <i class="fa-solid fa-crown"></i>

                            </div>

                            <div class="empty-content">

                                <span class="empty-label">
                                    الاشتراك
                                </span>

                                <h2>
                                    الاشتراك مفتوح
                                </h2>

                                <p>
                                    سيتم إرسال بيانات الطبيب والاشتراك في نفس العملية.
                                </p>

                            </div>

                        </div>


                        <a href="{{ route('admin.doctor.create') }}" class="subscription-btn cancel-btn">

                            <i class="fa-solid fa-xmark"></i>

                            <span>
                                إنشاء الطبيب بدون اشتراك
                            </span>

                        </a>

                    </div>
                @endif

            </main>

        </div>

    </div>


@endsection
