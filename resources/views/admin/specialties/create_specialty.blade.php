@extends('admin.layout.app')

@section('title', 'لوحة التحكم | إضافة تخصص')

@section('content')

    <div class="doctor-edit-page">

        {{-- =========================================================
        HEADER
        ========================================================== --}}

        <div class="doctor-edit-header">

            <div class="doctor-edit-title">

                <div class="title-icon">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>

                <div class="title-content">

                    <span class="title-small">
                        إدارة التخصصات
                    </span>

                    <h1>
                        إضافة تخصص جديد
                    </h1>

                    <p>
                        إضافة تخصص طبي جديد إلى دليل الأطباء
                    </p>

                </div>

            </div>


            <a href="{{ route('admin.specialties.index') }}" class="back-btn">

                <i class="fa-solid fa-arrow-right"></i>

                <span>
                    رجوع
                </span>

            </a>

        </div>


        {{-- =========================================================
        LAYOUT
        ========================================================== --}}

        <div class="doctor-edit-layout">


            {{-- =====================================================
            SIDEBAR
            ====================================================== --}}

            <aside class="doctor-profile-card">

                <div class="profile-card-title">

                    <div class="profile-title-icon">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>

                    <div>

                        <h2>
                            التخصص الطبي
                        </h2>

                        <p>
                            البيانات التي ستظهر في دليل الأطباء
                        </p>

                    </div>

                </div>


                {{-- SPECIALTY PREVIEW --}}

                <div class="profile-image-area">

                    <div class="profile-image-wrapper">

                        <div class="doctor-default-image">

                            <i
                                id="specialtyLogoPreview"
                                class="fa-solid fa-stethoscope">
                            </i>

                        </div>

                    </div>

                </div>


                <div class="upload-note">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>
                        اكتب كلاس الأيقونة من Font Awesome في خانة الشعار
                    </span>

                </div>


                {{-- INFO --}}

                <div class="profile-doctor-info">

                    <span class="doctor-profile-label">
                        مثال
                    </span>

                    <h3>
                        طب القلب
                    </h3>

                    <p>

                        <i class="fa-solid fa-heart-pulse"></i>

                        تخصص طبي

                    </p>

                </div>


                {{-- STATUS --}}

                <div class="subscription-status subscribed">

                    <span class="status-icon">

                        <i class="fa-solid fa-check"></i>

                    </span>

                    <span>
                        سيظهر التخصص في الموقع
                    </span>

                </div>

            </aside>


            {{-- =====================================================
            MAIN CONTENT
            ====================================================== --}}

            <main class="doctor-form-content">

                <form
                    action="{{ route('admin.specialties.store') }}"
                    method="POST"
                >

                    @csrf


                    {{-- =================================================
                    SPECIALTY DATA
                    ================================================== --}}

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">

                                <i class="fa-solid fa-stethoscope"></i>

                            </div>

                            <div>

                                <h2>
                                    بيانات التخصص
                                </h2>

                                <p>
                                    البيانات الأساسية للتخصص الطبي
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            {{-- NAME --}}

                            <div class="form-group">

                                <label for="name">
                                    اسم التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-stethoscope"></i>

                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="مثال: طب القلب"
                                        required
                                    >

                                </div>

                                @error('name')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- SORT ORDER --}}

                            <div class="form-group">

                                <label for="sort_order">
                                    ترتيب الظهور
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-arrow-down-1-9"></i>

                                    <input
                                        id="sort_order"
                                        type="number"
                                        name="sort_order"
                                        value="{{ old('sort_order', 0) }}"
                                        placeholder="مثال: 1"
                                        min="0"
                                        required
                                    >

                                </div>

                                @error('sort_order')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- TITLE --}}

                            <div class="form-group full">

                                <label for="title">
                                    عنوان التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-heading"></i>

                                    <input
                                        id="title"
                                        type="text"
                                        name="title"
                                        value="{{ old('title') }}"
                                        placeholder="مثال: أفضل أطباء القلب في مصر"
                                        required
                                    >

                                </div>

                                @error('title')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- SLUG --}}

                            <div class="form-group">

                                <label for="slug">
                                    الرابط المختصر
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-link"></i>

                                    <input
                                        id="slug"
                                        type="text"
                                        name="slug"
                                        value="{{ old('slug') }}"
                                        placeholder="مثال: cardiology"
                                        required
                                    >

                                </div>

                                @error('slug')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- LOGO --}}

                            <div class="form-group">

                                <label for="logo">
                                    شعار التخصص
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-icons"></i>

                                    <input
                                        id="logo"
                                        type="text"
                                        name="logo"
                                        value="{{ old('logo', 'fa-solid fa-stethoscope') }}"
                                        placeholder="مثال: fa-solid fa-heart-pulse"
                                        required
                                    >

                                </div>

                                @error('logo')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                        </div>

                    </div>


                    {{-- =================================================
                    SAVE
                    ================================================== --}}

                    <div class="save-section">

                        <button
                            type="submit"
                            class="save-btn"
                        >

                            <i class="fa-solid fa-plus"></i>

                            <span>
                                إضافة التخصص
                            </span>

                        </button>

                    </div>

                </form>

            </main>

        </div>

    </div>

@endsection
