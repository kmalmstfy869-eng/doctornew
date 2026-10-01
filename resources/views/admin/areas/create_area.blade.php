@extends('admin.layout.app')

@section('title', 'لوحة التحكم | إضافة منطقه')

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
                        إدارة المناطق
                    </span>

                    <h1>
                        إضافة منطقه جديد
                    </h1>

                    <p>
                        إضافة منطقه جديدة إلى دليل الأطباء
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
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>

                    <div>

                        <h2>
                            المنطقة
                        </h2>

                        <p>
                            البيانات التي ستظهر في دليل الأطباء
                        </p>

                    </div>

                </div>




                <div class="profile-image-area">

                    <div class="profile-image-wrapper">

                        <div class="doctor-default-image">
                            <i class="fa-solid fa-location-dot"></i>
                            </i>

                        </div>

                    </div>

                </div>



                {{-- INFO --}}

                <div class="profile-doctor-info">

                    <span class="doctor-profile-label">
                        مثال
                    </span>

                    <h3>
                        الرحمانيه
                    </h3>

                    <p>

                        <i class="fa-solid fa-heart-pulse"></i>

                        منطقه

                    </p>

                </div>


                {{-- STATUS --}}

                <div class="subscription-status subscribed">

                    <span class="status-icon">

                        <i class="fa-solid fa-check"></i>

                    </span>

                    <span>
                        سيظهر المنطقه في الموقع
                    </span>

                </div>

            </aside>


            {{-- =====================================================
            MAIN CONTENT
            ====================================================== --}}

            <main class="doctor-form-content">

                <form action="{{ route('admin.areas.store') }}" method="POST">

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
                                    بيانات المنطقه
                                </h2>

                                <p>
                                    البيانات الأساسية للمنطقة
                                </p>

                            </div>

                        </div>


                        <div class="form-grid">


                            {{-- NAME --}}

                            <div class="form-group">

                                <label for="name">
                                    اسم المنطقه
                                </label>

                                <div class="input-wrapper">

                                   <i class="fa-solid fa-location-dot"></i>

                                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                                        placeholder="مثال: الرحمانية " required>

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

                                    <input id="slug" type="text" name="slug" value="{{ old('slug') }}"
                                        placeholder="مثال:sidi-bishr" required>

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

                        <button type="submit" class="save-btn">

                            <i class="fa-solid fa-plus"></i>

                            <span>
                                إضافة المنطقة
                            </span>

                        </button>

                    </div>

                </form>

            </main>

        </div>

    </div>

@endsection
