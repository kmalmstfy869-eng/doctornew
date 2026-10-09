@extends('doctor.layouts.app')

@section('title', 'تعديل الملف الطبي | لوحة تحكم الطبيب')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/doctor/dashboard/subscription.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/edit.css') }}">
@endpush

@section('content')

    <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data" id="doctorProfileForm">
        @method('PUT')
        @csrf

        <input type="hidden" id="deletedDoctorImage" name="deleted_doctor_image"
            value="{{ old('deleted_doctor_image', '') }}">

        <input type="hidden" id="deletedClinicImages" name="deleted_clinic_images"
            value="{{ old('deleted_clinic_images', '[]') }}">

        <section class="subscription" id="subscription">

            <div class="subscription-main">

                <span class="sub-label">
                    الملف الطبي
                </span>

                <div class="sub-heading">
                    <h2>
                        تعديل ملفي الطبي
                    </h2>
                </div>

                <span class="sub-status free-status">
                    حدّث معلوماتك الطبية ومعلومات عيادتك التي تظهر للمرضى.
                </span>

                <div class="sub-features">

                    <span class="sub-feature">
                        ✓ اجعل مرضى أكثر يجدونك بسهولة
                    </span>

                    <span class="sub-feature">
                        ✓ زوّد فرص ظهورك وحجز المرضى
                    </span>

                    <span class="sub-feature">
                        ✓ اجعل ملفك الطبي أكثر احترافية
                    </span>

                    <span class="sub-feature">
                        ✓ استفيد من مميزات حصرية للأطباء المشتركين
                    </span>

                </div>

                @if ($doctor->hasFeature('booking'))
                    <div class="booking-notice">

                        <div class="booking-notice-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>

                        <div class="booking-notice-content">

                            <span class="booking-notice-title">
                                تنبيه بخصوص الحجوزات
                            </span>

                            <p>
                                هذه الصفحة مخصصة لتعديل بيانات ملفك الطبي
                                وبيانات العيادة التي تظهر للمرضى.

                                <strong>
                                    إدارة الحجوزات ومواعيد الحجز القادمة من الموقع
                                </strong>

                                تتم من خلال صفحة إدارة العيادة أو الحجوزات.
                            </p>

                        </div>

                    </div>
                @endif

            </div>

            <div class="subscription-side">

                <span class="expire-label">
                    طوّر حسابك
                </span>

                <div class="expire-date">
                    شاهد ملفك كما يظهر للآخرين
                </div>

                <a href="{{ route('doctor.profile.show') }}" class="upgrade-btn">
                    ملفي الطبي
                </a>

            </div>

        </section>

        <section class="doctor-edit-page" dir="rtl">

            <div class="doctor-edit-layout">

                <aside class="doctor-profile-card">

                    @if ($doctor->hasFeature('subscription'))

                        <div class="profile-card-title">

                            <div class="profile-title-icon">
                                <i class="fa-solid fa-image"></i>
                            </div>

                            <div>

                                <h2>
                                    الصورة الشخصية
                                </h2>

                                <p>
                                    الصورة التي ستظهر بجانب اسمك في الملف الطبي
                                </p>

                            </div>

                        </div>

                        <div class="profile-image-area">

                            <div class="profile-image-wrapper" id="doctorProfileImageWrapper"
                                data-original-image="{{ $doctor->doctor_image ?? '' }}">

                                @if ($doctor->doctor_image)
                                    <img src="{{ asset('storage/' . ltrim($doctor->doctor_image, '/')) }}"
                                        alt="{{ $doctor_name }}" class="doctor-profile-image" id="doctorProfileImage">
                                @else
                                    <div class="doctor-default-image" id="doctorDefaultImage">
                                        <i class="fa-solid fa-user-doctor"></i>
                                    </div>
                                @endif

                                <button type="button" id="removeDoctorImageBtn" class="profile-image-remove"
                                    aria-label="حذف الصورة" title="حذف الصورة"
                                    style="{{ $doctor->doctor_image ? 'display: flex;' : 'display: none;' }}">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>

                                <div class="profile-image-actions">

                                    <label for="doctorImageInput" class="change-profile-btn" title="اختيار صورة جديدة">
                                        <i class="fa-solid fa-camera"></i>
                                    </label>

                                </div>

                            </div>

                        </div>

                        <label for="doctorImageInput" class="upload-profile">

                            <span class="upload-profile-icon">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </span>

                            <span class="upload-profile-text">

                                <strong>
                                    رفع صورة جديدة
                                </strong>

                                <small>
                                    اضغط هنا لاختيار صورة الطبيب
                                </small>

                            </span>

                            <input type="file" id="doctorImageInput" name="doctor_image"
                                accept="image/jpeg,image/png,image/jpg">

                        </label>

                        @error('doctor_image')
                            <div class="field-error">

                                <i class="fa-solid fa-circle-exclamation"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </div>
                        @enderror

                        @error('deleted_doctor_image')
                            <div class="field-error">

                                <i class="fa-solid fa-circle-exclamation"></i>

                                <span>
                                    {{ $message }}
                                </span>

                            </div>
                        @enderror

                        <div class="upload-note">

                            <i class="fa-solid fa-circle-info"></i>

                            <span>
                                JPG أو PNG — الحد الأقصى 2MB
                            </span>

                        </div>
                    @else
                        <section class="upg-card">
                            <div class="upg-top">
                                <span class="upg-crown"><i class="fa-solid fa-crown"></i></span>
                                <span class="upg-plan-badge">
                                    <i class="fa-solid fa-circle"></i>
                                    اشتراكك الحالي: مجاني
                                </span>
                            </div>

                            <span class="upg-kicker">✦ طوّر ظهورك</span>
                            <h3 class="upg-title">لسه مش مشترك؟ <br> فايتك كتير!</h3>
                            <p class="upg-desc">
                                اشترك الآن وخلي ملفك الطبي يظهر بشكل أفضل، واستفيد من المميزات الإضافية اللي تساعدك توصل
                                لعدد أكبر من المرضى.
                            </p>

                            <ul class="upg-list">
                                <li><i class="fa-solid fa-check"></i> خلّي مرضى أكتر يلاقوك بسهولة</li>
                                <li><i class="fa-solid fa-check"></i> زوّد فرص ظهورك وحجز المرضى</li>
                                <li><i class="fa-solid fa-check"></i> استفيد من مميزات حصرية للأطباء</li>
                            </ul>

                            <a href="{{ route('doctor.subscription') }}" class="upg-btn">
                                <span>شوف الباقات</span>
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </section>

                    @endif

                    <div class="profile-doctor-info">

                        <span class="doctor-profile-label">
                            الملف الطبي
                        </span>

                        <h3>
                            بيانات الطبيب
                        </h3>

                        <p>
                            <i class="fa-solid fa-stethoscope"></i>
                            يمكنك تعديل بياناتك من النموذج
                        </p>

                    </div>

                    <div class="subscription-status subscribed">

                        <span class="status-icon">
                            <i class="fa-solid fa-check"></i>
                        </span>

                        <span>
                            الملف الطبي معتمد
                        </span>

                    </div>

                </aside>

                <main class="doctor-form-content">

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
                                    بيانات التعريف بك كطبيب داخل المنصة
                                </p>

                            </div>

                        </div>

                        <div class="form-grid">

                            <div class="form-group">

                                <label for="doctorName">
                                    اسم الطبيب
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-user"></i>

                                    <input id="doctorName" type="text" name="name"
                                        value="{{ old('name', $doctor_name ?? $doctor->user->name) }}"
                                        placeholder="مثال: د. أحمد محمود">

                                </div>

                                @error('name')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">

                                <label for="specialty">
                                    التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-stethoscope"></i>

                                    <select id="specialty" name="specialty_id">

                                        <option value="">
                                            اختر التخصص
                                        </option>

                                        @foreach ($specialties as $specialty)
                                            <option value="{{ $specialty->id }}" @selected(old('specialty_id', $doctor->specialty_id) == $specialty->id)>
                                                {{ $specialty->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                @error('specialty_id')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">

                                <label for="area">
                                    المنطقة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <select id="area" name="area_id">

                                        <option value="">
                                            اختر المنطقة
                                        </option>

                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}" @selected(old('area_id', $doctor->area_id) == $area->id)>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                @error('area_id')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

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
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

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
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">

                                <label for="experience">
                                    سنوات الخبرة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-user-clock"></i>

                                    <input id="experience" type="number" name="experience" min="0"
                                        value="{{ old('experience', $doctor->experience) }}"
                                        placeholder="عدد سنوات الخبرة">

                                    <span class="input-unit">
                                        سنة
                                    </span>

                                </div>

                                @error('experience')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

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
                                    تفاصيل العيادة التي تظهر للمرضى عند الحجز
                                </p>

                            </div>

                        </div>

                        <div class="form-grid">

                            <div class="form-group">

                                <label for="clinicName">
                                    اسم العيادة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-house-medical"></i>

                                    <input id="clinicName" type="text" name="clinic_name"
                                        value="{{ old('clinic_name', $doctor->clinic_name) }}"
                                        placeholder="مثال: عيادة النور التخصصية">

                                </div>

                                @error('clinic_name')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group">

                                <label for="consultationPrice">
                                    سعر الكشف
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-money-bill-wave"></i>

                                    <input id="consultationPrice" type="number" name="consultation_price"
                                        min="0" step="0.01"
                                        value="{{ old('consultation_price', $doctor->consultation_price) }}"
                                        placeholder="مثال: 300">

                                    <span class="input-unit">
                                        جنيه
                                    </span>

                                </div>

                                @error('consultation_price')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                            <div class="form-group full">

                                <label for="address">
                                    عنوان العيادة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <input id="address" type="text" name="address"
                                        value="{{ old('address', $doctor->address) }}"
                                        placeholder="مثال: 12 شارع التحرير، الدور الثالث">

                                </div>

                                @error('address')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                            @if ($doctor->hasFeature('subscription'))
                                <div class="form-group full">

                                    <label for="googleMap">
                                        موقع العيادة على Google Maps
                                    </label>

                                    <div class="input-wrapper">

                                        <i class="fa-solid fa-map-location-dot"></i>

                                        <input id="googleMap" type="url" name="google_maps_url"
                                            value="{{ old('google_maps_url', $doctor->google_maps_url) }}"
                                            placeholder="https://maps.google.com/...">

                                    </div>

                                    @error('google_maps_url')
                                        <div class="field-error">
                                            <i class="fa-solid fa-circle-exclamation"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror

                                </div>
                            @endif

                            <div class="form-group full">

                                <label for="workingHours">
                                    مواعيد العمل
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-regular fa-clock"></i>

                                    <input id="workingHours" type="text" name="working_hours"
                                        value="{{ old('working_hours', $doctor->working_hours) }}"
                                        placeholder="مثال: السبت - الخميس من 5 م إلى 10 م">

                                </div>

                                @error('working_hours')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">
                                <i class="fa-solid fa-book-medical"></i>
                            </div>

                            <div>

                                <h2>
                                    نبذة عن الطبيب
                                </h2>

                                <p>
                                    نبذة مختصرة تساعد المرضى على التعرف عليك
                                </p>

                            </div>

                        </div>

                        <div class="form-grid">

                            <div class="form-group full">

                                <label for="bio">
                                    نبذة مختصرة
                                </label>

                                <div class="textarea-box">

                                    <textarea id="bio" name="bio" rows="5" placeholder="اكتب نبذة مختصرة عن الطبيب وخبرته وتخصصه...">{{ old('bio', $doctor->bio) }}</textarea>

                                </div>

                                @error('bio')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                    @if ($doctor->hasFeature('subscription'))
                        <div class="edit-card">

                            <div class="card-title">

                                <div class="card-title-icon">
                                    <i class="fa-solid fa-list-check"></i>
                                </div>

                                <div>

                                    <h2>
                                        الخدمات الطبية
                                    </h2>

                                    <p>
                                        أضف الخدمات التي تقدمها داخل العيادة
                                    </p>

                                </div>

                            </div>
                            <div class="form-group full">

                                <label for="serviceInput">
                                    إضافة خدمة جديدة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-plus"></i>

                                    <input type="text" id="serviceInput" placeholder="مثال: الكشف الطبي">

                                    <button type="button" id="addServiceBtn" class="service-add-btn">

                                        <i class="fa-solid fa-plus"></i>

                                        <span>
                                            إضافة
                                        </span>

                                    </button>

                                </div>

                            </div>

                            <div id="servicesList" class="doctor-services-list"></div>

                            <input type="hidden" id="services" name="services"
                                value="{{ old('services', json_encode($doctor->services ?? [], JSON_UNESCAPED_UNICODE)) }}">

                            <div class="input-hint">

                                <i class="fa-solid fa-circle-info"></i>

                                <span>
                                    يمكنك إضافة أكثر من خدمة، واضغط على × لحذف أي خدمة.
                                </span>

                            </div>

                            @error('services')
                                <div class="field-error">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror

                        </div>

                        <div class="edit-card">

                            <div class="card-title">

                                <div class="card-title-icon">
                                    <i class="fa-solid fa-images"></i>
                                </div>

                                <div>

                                    <h2>
                                        صور العيادة
                                    </h2>

                                    <p>
                                        أضف حتى 3 صور توضح شكل العيادة للمرضى
                                    </p>

                                </div>

                            </div>

                            <div class="form-group full">

                                <label class="field-label">
                                    صور العيادة
                                </label>

                                <div id="clinicImagesPreview" class="clinic-images-preview">

                                    @if (!empty($doctor->clinic_images))

                                        @foreach ($doctor->clinic_images as $index => $image)
                                            <div class="clinic-image-preview-item existing-clinic-image"
                                                data-existing-image="{{ $image }}">

                                                <img src="{{ asset('storage/' . ltrim($image, '/')) }}"
                                                    alt="صورة العيادة" loading="lazy">

                                                <button type="button"
                                                    class="clinic-image-remove existing-clinic-image-remove"
                                                    data-image="{{ $image }}" aria-label="حذف الصورة">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>

                                            </div>
                                        @endforeach

                                    @endif

                                    <label for="clinicImagesInput" class="clinic-images-dropzone">

                                        <i class="fa-solid fa-cloud-arrow-up"></i>

                                        <strong>
                                            إضافة صورة
                                        </strong>

                                        <span>
                                            حتى 3 صور
                                        </span>

                                        <input type="file" id="clinicImagesInput" name="clinic_images[]"
                                            accept="image/jpeg,image/png,image/jpg" multiple>

                                    </label>

                                </div>

                                <div id="clinicImagesCount" class="clinic-images-count">

                                    <span class="count-icon">
                                        <i class="fa-solid fa-images"></i>
                                    </span>

                                    <span class="count-text">
                                        يمكنك إضافة صور للعيادة
                                    </span>

                                </div>

                                @error('clinic_images')
                                    <div class="field-error">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror

                            </div>

                        </div>

                    @endif

                    @error('deleted_clinic_images')
                        <div class="field-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="save-section">

                        <button type="submit" class="save-btn" id="saveDoctorProfileBtn">

                            <i class="fa-solid fa-floppy-disk"></i>

                            <span>
                                حفظ التغييرات
                            </span>

                        </button>

                    </div>

                </main>

            </div>

        </section>

    </form>

@endsection
