@extends('admin.layout.app')

@section('title', 'لوحة التحكم | تعديل بيانات الطبيب')

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
                        تعديل بيانات الطبيب
                    </h1>

                    <p>
                        إدارة البيانات الشخصية والعيادة والاشتراك
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

                        @if ($doctor->doctor_image)
                            <img id="doctorImagePreview" src="{{ asset('storage/' . $doctor->doctor_image) }}"
                                alt="{{ $doctor->user->name }}" class="profile-image">

                            <div id="doctorImageDefault" class="doctor-default-image" style="display:none;">

                                <i class="fa-solid fa-user-doctor"></i>

                            </div>
                        @else
                            <div id="doctorImageDefault" class="doctor-default-image">

                                <i class="fa-solid fa-user-doctor"></i>

                            </div>

                            <img id="doctorImagePreview" src="" alt="صورة الطبيب" class="profile-image"
                                style="display:none;">
                        @endif


                        {{-- =================================================
                        IMAGE ACTIONS
                        ================================================== --}}

                        <div class="profile-image-actions">

                            {{-- تغيير الصورة --}}

                            <label for="doctorImageInput" class="change-profile-btn" title="اختيار صورة جديدة">

                                <i class="fa-solid fa-camera"></i>

                            </label>


                            {{-- حذف الصورة --}}

                            @if ($doctor->doctor_image)
                                <form method="POST" action="{{ route('admin.doctor.deleteImage', $doctor) }}"
                                    class="delete-profile-image-form"
                                    onsubmit="return confirm('هل أنت متأكد من حذف صورة الطبيب؟')">

                                    @csrf

                                    <button type="submit" class="delete-profile-btn" title="حذف صورة الطبيب">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>
                            @endif

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

                    <input type="file" id="doctorImageInput" name="doctor_image" form="editDoctorForm"
                        accept="image/jpeg,image/png,image/jpg">

                </label>


                <div class="upload-note">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>
                        JPG أو PNG — الحد الأقصى 5MB
                    </span>

                </div>


                {{-- =================================================
                DOCTOR INFO
                ================================================== --}}

                <div class="profile-doctor-info">

                    <span class="doctor-profile-label">
                        الطبيب
                    </span>

                    <h3>
                        د. {{ $doctor->user->name }}
                    </h3>

                    <p>

                        <i class="fa-solid fa-stethoscope"></i>

                        {{ $doctor->specialty->name ?? 'بدون تخصص' }}

                    </p>

                </div>


                {{-- =================================================
                SUBSCRIPTION STATUS
                ================================================== --}}

                @if ($isCurrentlySubscribed)
                    {{-- اشتراك حالي --}}

                    <div class="subscription-status subscribed">

                        <span class="status-icon">
                            <i class="fa-solid fa-check"></i>
                        </span>

                        <span>
                            الطبيب مشترك حاليًا
                        </span>

                    </div>
                @elseif ($hasPreviousSubscription)
                    {{-- اشتراك سابق منتهي --}}

                    <div class="subscription-status expired">

                        <span class="status-icon">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </span>

                        <span>
                            الاشتراك منتهي
                        </span>

                    </div>
                @else
                    {{-- لم يشترك من قبل --}}

                    <div class="subscription-status unsubscribed">

                        <span class="status-icon">
                            <i class="fa-solid fa-user-slash"></i>
                        </span>

                        <span>
                            لم يشترك من قبل
                        </span>

                    </div>
                @endif


                {{-- WHATSAPP --}}

                @if ($doctor->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $doctor->whatsapp) }}" target="_blank"
                        rel="noopener" class="whatsapp-btn">

                        <span class="whatsapp-icon">
                            <i class="fa-brands fa-whatsapp"></i>
                        </span>

                        <span>
                            التواصل عبر واتساب
                        </span>

                        <i class="fa-solid fa-arrow-up-left-from-circle"></i>

                    </a>
                @endif

            </aside>


            {{-- =========================================================
            MAIN CONTENT
            ========================================================== --}}

            <main class="doctor-form-content">


                {{-- =====================================================
                EDIT DOCTOR FORM
                ====================================================== --}}

                <form id="editDoctorForm" action="{{ route('admin.doctor.update', $doctor) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')


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

                                    <input id="doctorName" type="text" name="name"
                                        value="{{ old('name', $doctor->user->name) }}" placeholder="اكتب اسم الطبيب"
                                        required>

                                </div>

                                @error('name')
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

                                        @foreach ($specialties as $specialty)
                                            <option value="{{ $specialty->id }}" @selected(old('specialty_id', $doctor->specialty_id) == $specialty->id)>
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
                                    اختر المنطقة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <select id="area" name="area_id" required>

                                        @foreach (\App\Models\Area::all() as $area)
                                            <option value="{{ $area->id }}" @selected(old('area_id', $doctor->area_id) == $area->id)>

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

                                    <input id="phone" type="text" name="phone"
                                        value="{{ old('phone', $doctor->phone) }}" placeholder="مثال: 01012345678">

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
                                        value="{{ old('experience', $doctor->experience) }}"
                                        placeholder="عدد سنوات الخبرة" min="0">

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

                                    <input id="whatsapp" type="text" name="whatsapp"
                                        value="{{ old('whatsapp', $doctor->whatsapp) }}" placeholder="مثال: 01012345678">

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
                                        value="{{ old('consultation_price', $doctor->consultation_price) }}"
                                        placeholder="مثال: 300" min="0">

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

                                    <textarea id="bio" name="bio" rows="5" placeholder="اكتب نبذة مختصرة عن الطبيب وخبرته وتخصصه...">{{ old('bio', $doctor->bio) }}</textarea>

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
                                        value="{{ old('clinic_name', $doctor->clinic_name) }}"
                                        placeholder="اكتب اسم العيادة">

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

                                    <input id="address" type="text" name="address"
                                        value="{{ old('address', $doctor->address) }}" placeholder="اكتب عنوان العيادة">

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
                                        value="{{ old('working_hours', $doctor->working_hours) }}"
                                        placeholder="مثال: من 4 مساءً إلى 10 مساءً">

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
                    SAVE DOCTOR DATA
                    ================================================== --}}

                    <div class="save-section">

                        <button type="submit" class="save-btn" data-submit-form="editDoctorForm">

                            <i class="fa-solid fa-floppy-disk"></i>

                            <span>
                                حفظ التغييرات
                            </span>

                        </button>

                    </div>

                </form>


                {{-- =====================================================
                SUBSCRIPTION
                ====================================================== --}}

                @if ($showSubscriptionForm || $hasPreviousSubscription)

                    <div class="edit-card subscription-card">


                        {{-- =================================================
                        SUBSCRIPTION HEADER
                        ================================================== --}}

                        <div class="subscription-header">

                            <div class="card-title subscription-title">

                                <div class="card-title-icon {{ $isCurrentlySubscribed ? 'crown' : '' }}">

                                    <i class="fa-solid {{ $isCurrentlySubscribed ? 'fa-crown' : 'fa-credit-card' }}"></i>

                                </div>

                                <div>

                                    <h2>

                                        @if ($isCurrentlySubscribed)
                                            الاشتراك الحالي
                                        @else
                                            الاشتراك السابق - يمكن تفعيله من جديد
                                        @endif

                                    </h2>

                                    <p>

                                        @if ($isCurrentlySubscribed)
                                            يمكنك تعديل بيانات الاشتراك الحالية
                                        @else
                                            الاشتراك السابق انتهى ويمكنك تفعيله من جديد باستخدام البيانات الحالية
                                        @endif

                                    </p>

                                </div>

                            </div>


                            {{-- BADGE --}}

                            @if ($isCurrentlySubscribed)
                                <span class="subscription-badge active">

                                    <i class="fa-solid fa-circle-check"></i>

                                    مشترك حاليًا

                                </span>
                            @elseif ($hasPreviousSubscription)
                                <span class="subscription-badge expired">

                                    <i class="fa-solid fa-clock-rotate-left"></i>

                                    منتهي

                                </span>
                            @endif

                        </div>


                        {{-- =================================================
                        CURRENT PLAN
                        ================================================== --}}

                        <div class="current-plan">

                            <div class="plan-icon">

                                <i class="fa-solid fa-crown"></i>

                            </div>

                            <div class="plan-details">

                                <strong>
                                    {{ $subscription->plan->name }}
                                </strong>

                                <span>
                                    الباقة الحالية -
                                    {{ round($subscription->plan->duration / 30) }} شهر
                                </span>

                                @if ($isCurrentlySubscribed)
                                    <span class="subscription-state-text">
                                        الاشتراك ساري حاليًا
                                    </span>
                                @else
                                    <span class="subscription-state-text">
                                        الاشتراك منتهي ويمكن تفعيله مرة أخرى
                                    </span>
                                @endif

                            </div>

                        </div>


                        {{-- =================================================
                        SUBSCRIPTION FORM
                        ================================================== --}}

                        <form id="subscribeDoctorForm" method="POST"
                            action="{{ route('admin.doctor.subscribe', $doctor) }}" enctype="multipart/form-data">

                            @csrf


                            {{-- SUBSCRIPTION DATA --}}

                            <div class="subscription-section">

                                <div class="section-heading">

                                    <div class="section-heading-icon">

                                        <i class="fa-solid fa-box-open"></i>

                                    </div>

                                    <div>

                                        <strong>

                                            @if ($isCurrentlySubscribed)
                                                تعديل بيانات الاشتراك
                                            @else
                                                إعادة تفعيل الاشتراك
                                            @endif

                                        </strong>

                                        <span>

                                            @if ($isCurrentlySubscribed)
                                                يمكنك تعديل الباقة والتاريخ والسعر
                                            @else
                                                راجع البيانات القديمة ثم قم بتفعيل الاشتراك من جديد
                                            @endif

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
                                                    <option value="{{ $plan->id }}" @selected(old('plan_id', $subscription?->plan_id) == $plan->id)>

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
                                                value="{{ old('start_date', $subscription ? $subscription->start_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                                                required>

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
                                                value="{{ old('price', $subscription ? $subscription->price : null) }}"
                                                placeholder="مثال: 300" required>

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

                                            <textarea id="services" name="services" rows="4" placeholder="اكتب كل خدمة في سطر منفصل">{{ old('services', is_array($doctor->services) ? implode("\n", $doctor->services) : '') }}</textarea>

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
                                                value="{{ old('google_maps_url', $doctor->google_maps_url ?? '') }}"
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


                                        {{-- OLD IMAGES --}}

                                        @if (!empty($doctor->clinic_images))

                                            <div class="clinic-images-preview">

                                                @foreach ($doctor->clinic_images as $image)
                                                    <div class="clinic-image-preview-item old-clinic-image"
                                                        data-image="{{ $image }}">

                                                        <img src="{{ asset('storage/' . $image) }}" alt="صورة العيادة">

                                                        <label class="clinic-image-delete">

                                                            <input type="checkbox" name="delete_clinic_images[]"
                                                                value="{{ $image }}">

                                                            <span>
                                                                ×
                                                            </span>

                                                        </label>

                                                    </div>
                                                @endforeach

                                            </div>

                                        @endif


                                        {{-- NEW IMAGES PREVIEW --}}

                                        <div id="clinicImagesPreview" class="clinic-images-preview">
                                        </div>


                                        {{-- NEW IMAGES UPLOAD --}}

                                        <div class="clinic-images-upload">

                                            <label for="clinicImagesInput" class="clinic-images-dropzone">

                                                <i class="fa-solid fa-images"></i>

                                                <strong>
                                                    أضف صور جديدة للعيادة
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

                                            لو عايز تحذف صورة قديمة، علم على علامة × الموجودة عليها، وعند تحديدها هتتحول
                                            علامة × للون الأخضر.
                                            ولو عايز تضيف صور جديدة، اختارها من المربع بالأعلى.

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

                                        @error('delete_clinic_images')
                                            <small class="field-error">
                                                {{ $message }}
                                            </small>
                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- =================================================
                            ACTIONS
                            ================================================== --}}

                            <div class="subscription-actions">


                                {{-- CANCEL FORM VIEW --}}

                                @if ($showSubscriptionForm)
                                    <a href="{{ route('admin.doctor.edit', $doctor) }}"
                                        class="subscription-btn cancel-btn">

                                        <i class="fa-solid fa-xmark"></i>

                                        <span>
                                            إلغاء
                                        </span>

                                    </a>
                                @endif


                                {{-- SUBMIT --}}

                                <button type="submit" class="subscription-btn activate-btn"
                                    data-submit-form="subscribeDoctorForm">

                                    <i class="fa-solid fa-check"></i>

                                    <span>

                                        @if ($isCurrentlySubscribed)
                                            حفظ بيانات الاشتراك
                                        @else
                                            إعادة تفعيل الاشتراك
                                        @endif

                                    </span>

                                </button>

                            </div>

                        </form>


                        {{-- =====================================================
                        CANCEL CURRENT SUBSCRIPTION
                        ====================================================== --}}

                        @if ($isCurrentlySubscribed)
                            <form method="POST" action="{{ route('admin.doctor.cancelSubscription', $doctor) }}"
                                class="cancel-subscription-form"
                                onsubmit="return confirm('هل أنت متأكد من إلغاء اشتراك الطبيب؟')">

                                @csrf

                                <button type="submit" class="cancel-subscription-btn">

                                    <i class="fa-regular fa-circle-xmark"></i>

                                    <span>
                                        إلغاء اشتراك الطبيب
                                    </span>

                                </button>

                            </form>
                        @elseif ($hasPreviousSubscription)
                            {{-- EXPIRED --}}

                            <div class="expired-subscription-notice">



                                <div>

                                    <strong>
                                        الاشتراك السابق منتهي
                                    </strong>

                                    <span>
                                        يمكنك إعادة تفعيله من خلال النموذج أعلاه.
                                    </span>

                                </div>

                            </div>
                        @endif


                    </div>
                @else
                    {{-- =====================================================
                    NO SUBSCRIPTION EVER
                    ====================================================== --}}

                    <div class="edit-card no-subscription-card">

                        <div class="empty-subscription">

                            <div class="empty-icon">

                                <i class="fa-solid fa-user-slash"></i>

                            </div>

                            <div class="empty-content">

                                <span class="empty-label">
                                    حالة الاشتراك
                                </span>

                                <h2>
                                    لم يشترك من قبل
                                </h2>

                                <p>
                                    هذا الطبيب لا يوجد له أي اشتراك سابق.
                                    يمكنك إضافة اشتراك جديد لإتاحة المميزات الإضافية للطبيب.
                                </p>

                            </div>

                        </div>


                        <a href="{{ route('admin.doctor.edit', [
                            'doctor' => $doctor,
                            'subscribe' => 1,
                        ]) }}"
                            class="activate-btn">

                            <i class="fa-solid fa-plus"></i>

                            <span>
                                إضافة اشتراك
                            </span>

                        </a>

                    </div>

                @endif

            </main>

        </div>

    </div>




@endsection
@push('extra_java')
    <script src="{{ asset('js/admin/image-lightbox.js') }}?v={{ @filemtime(public_path('js/admin/image-lightbox.js')) ?: time() }}"></script>
@endpush
