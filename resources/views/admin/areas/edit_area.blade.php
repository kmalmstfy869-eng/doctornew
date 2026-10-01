@extends('admin.layout.app')

@section('title', 'لوحة التحكم | تعديل المنطقة')

@section('content')

    <div class="doctor-edit-page">

        {{-- =========================================================
        HEADER
        ========================================================== --}}

        <div class="doctor-edit-header">

            <div class="doctor-edit-title">

                <div class="title-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>

                <div class="title-content">

                    <span class="title-small">
                        إدارة المناطق
                    </span>

                    <h1>
                        تعديل المنطقة
                    </h1>

                    <p>
                        تعديل بيانات المنطقة في دليل الأطباء
                    </p>

                </div>

            </div>


            <a href="{{ route('admin.areas.index') }}" class="back-btn">

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

                        <i class="fa-solid fa-location-dot"></i>

                    </div>

                    <div>

                        <h2>
                            المنطقة
                        </h2>

                        <p>
                            البيانات التي تظهر في دليل الأطباء
                        </p>

                    </div>

                </div>


                {{-- AREA PREVIEW --}}

                <div class="profile-image-area">

                    <div class="profile-image-wrapper">

                        <div class="doctor-default-image">

                            <i class="fa-solid fa-location-dot"></i>

                        </div>

                    </div>

                </div>


                {{-- INFO --}}

                <div class="profile-doctor-info">

                    <span class="doctor-profile-label">
                        المنطقة الحالية
                    </span>

                    <h3>
                        {{ $area->name }}
                    </h3>

                    <p>

                        <i class="fa-solid fa-link"></i>

                        {{ $area->slug }}

                    </p>

                </div>


                {{-- STATUS --}}

                <div class="subscription-status subscribed">

                    <span class="status-icon">

                        <i class="fa-solid fa-check"></i>

                    </span>

                    <span>
                        المنطقة موجودة في الموقع
                    </span>

                </div>

            </aside>


            {{-- =====================================================
            MAIN CONTENT
            ====================================================== --}}

            <main class="doctor-form-content">

                <form action="{{ route('admin.areas.update', $area) }}" method="POST">

                    @csrf

                    @method('PUT')


                    {{-- =================================================
                    AREA DATA
                    ================================================== --}}

                    <div class="edit-card">

                        <div class="card-title">

                            <div class="card-title-icon">

                                <i class="fa-solid fa-location-dot"></i>

                            </div>

                            <div>

                                <h2>
                                    بيانات المنطقة
                                </h2>

                                <p>
                                    تعديل البيانات الأساسية للمنطقة
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            {{-- NAME --}}

                            <div class="form-group">

                                <label for="name">
                                    اسم المنطقة
                                </label>

                                <div class="input-wrapper">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name', $area->name) }}"
                                        placeholder="مثال: الرحمانية"
                                        required
                                    >

                                </div>

                                @error('name')

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
                                        value="{{ old('slug', $area->slug) }}"
                                        placeholder="مثال: sidi-bishr"
                                        required
                                    >

                                </div>

                                @error('slug')

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

                            <i class="fa-solid fa-floppy-disk"></i>

                            <span>
                                حفظ التعديلات
                            </span>

                        </button>

                    </div>

                </form>

            </main>

        </div>

    </div>

@endsection
