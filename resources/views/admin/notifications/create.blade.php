@extends('admin.layout.app')

@section('title', 'إرسال إشعار | لوحة تحكم الإدارة')

@push('extra_style')
    <link rel="stylesheet" href="{{ asset('css/admin/notifications.css') }}">
@endpush

@section('content')

    <main class="admin-notification-page">

        <div class="admin-notification-container">

            {{-- =========================================
                 PAGE HEADER
            ========================================== --}}
            <div class="notification-page-header">

                <div class="notification-page-title">

                    <div class="notification-page-icon">
                        <i class="fa-solid fa-bell"></i>
                    </div>

                    <div>

                        <h1>
                            إرسال إشعار
                        </h1>

                        <p>
                            إرسال إشعار مباشر إلى أحد الأطباء
                        </p>

                    </div>

                </div>

            </div>


            {{-- =========================================
                 FORM CARD
            ========================================== --}}
            <section class="notification-form-card">


                {{-- FORM HEADER --}}
                <div class="notification-form-header">

                    <div class="notification-form-header-icon">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>

                    <div>

                        <h2>
                            بيانات الإشعار
                        </h2>

                        <p>
                            اكتب بيانات الإشعار واختر الصفحة التي سيفتحها الطبيب
                        </p>

                    </div>

                </div>


                {{-- FORM --}}
                <form
                    action="{{ route('admin.notifications.store') }}"
                    method="POST"
                    class="notification-form"
                >

                    @csrf


                    {{-- =================================
                         DOCTOR ID
                    ================================== --}}
                    <div class="notification-form-group">

                        <label
                            for="doctor_id"
                            class="notification-form-label"
                        >
                            رقم الطبيب

                            <span class="required">
                                *
                            </span>
                        </label>

                        <div class="notification-input-wrapper">

                            <span class="notification-input-icon">
                                <i class="fa-solid fa-user-doctor"></i>
                            </span>

                            <input
                                type="number"
                                id="doctor_id"
                                name="doctor_id"
                                value="{{ old('doctor_id') }}"
                                class="notification-form-input @error('doctor_id') is-invalid @enderror"
                                placeholder="مثال: 15"
                                min="1"
                                required
                            >

                        </div>

                        @error('doctor_id')

                            <div class="notification-field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>

                        @enderror

                        <small class="notification-field-hint">
                            أدخل رقم الطبيب الموجود في جدول الأطباء.
                        </small>

                    </div>


                    {{-- =================================
                         TITLE
                    ================================== --}}
                    <div class="notification-form-group">

                        <label
                            for="title"
                            class="notification-form-label"
                        >
                            عنوان الإشعار

                            <span class="required">
                                *
                            </span>
                        </label>

                        <div class="notification-input-wrapper">

                            <span class="notification-input-icon">
                                <i class="fa-solid fa-heading"></i>
                            </span>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                class="notification-form-input @error('title') is-invalid @enderror"
                                placeholder="مثال: تم قبول حسابك"
                                maxlength="255"
                                required
                            >

                        </div>

                        @error('title')

                            <div class="notification-field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================
                         MESSAGE
                    ================================== --}}
                    <div class="notification-form-group">

                        <label
                            for="message"
                            class="notification-form-label"
                        >
                            نص الإشعار

                            <span class="required">
                                *
                            </span>
                        </label>

                        <div class="notification-textarea-wrapper">

                            <span class="notification-textarea-icon">
                                <i class="fa-solid fa-message"></i>
                            </span>

                            <textarea
                                id="message"
                                name="message"
                                class="notification-form-textarea @error('message') is-invalid @enderror"
                                placeholder="اكتب هنا تفاصيل الإشعار الذي سيصل إلى الطبيب..."
                                rows="6"
                                required
                            >{{ old('message') }}</textarea>

                        </div>

                        @error('message')

                            <div class="notification-field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================
                         PAGE SELECT
                    ================================== --}}
                    <div class="notification-form-group">

                        <label
                            for="page"
                            class="notification-form-label"
                        >
                            الصفحة التي سيفتحها الإشعار

                            <span class="required">
                                *
                            </span>
                        </label>

                        <div class="notification-input-wrapper">

                            <span class="notification-input-icon">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </span>

                            <select
                                id="page"
                                name="page"
                                class="notification-form-input notification-form-select @error('page') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    اختر الصفحة
                                </option>

                                <option
                                    value="notifications"
                                    {{ old('page') === 'notifications' ? 'selected' : '' }}
                                >
                                    الإشعارات
                                </option>

                                <option
                                    value="reviews"
                                    {{ old('page') === 'reviews' ? 'selected' : '' }}
                                >
                                    التقييمات
                                </option>

                                <option
                                    value="subscription"
                                    {{ old('page') === 'subscription' ? 'selected' : '' }}
                                >
                                    الاشتراك
                                </option>

                                <option
                                    value="profile"
                                    {{ old('page') === 'profile' ? 'selected' : '' }}
                                >
                                    الملف الطبي
                                </option>

                                <option
                                    value="dashboard"
                                    {{ old('page') === 'dashboard' ? 'selected' : '' }}
                                >
                                    الصفحة الرئيسية
                                </option>

                            </select>

                        </div>

                        @error('page')

                            <div class="notification-field-error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>

                        @enderror

                        <small class="notification-field-hint">
                            اختر الصفحة التي سيتم فتحها عند ضغط الطبيب على الإشعار.
                        </small>

                    </div>


                    {{-- =================================
                         INFO BOX
                    ================================== --}}
                    <div class="notification-info-box">

                        <div class="notification-info-icon">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>

                        <div class="notification-info-content">

                            <strong>
                                ملاحظة
                            </strong>

                            <p>
                                سيتم حفظ الإشعار في قاعدة البيانات،
                                وإرساله للطبيب عبر إشعار المتصفح إذا كان قد فعّل
                                إشعارات المتصفح.
                            </p>

                        </div>

                    </div>


                    {{-- =================================
                         FORM ACTIONS
                    ================================== --}}
                    <div class="notification-form-actions">

                        <a
                            href="{{ route('admin.notifications') }}"
                            class="notification-cancel-btn"
                        >
                            <i class="fa-solid fa-arrow-right"></i>

                            <span>
                                إلغاء
                            </span>
                        </a>


                        <button
                            type="submit"
                            class="notification-submit-btn"
                        >

                            <i class="fa-solid fa-paper-plane"></i>

                            <span>
                                إرسال الإشعار
                            </span>

                        </button>

                    </div>

                </form>

            </section>

        </div>

    </main>

@endsection
