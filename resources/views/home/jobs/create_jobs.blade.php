@extends('home.layout.app')

@section('title', 'إنشاء وظيفة | دليل الأطباء')

@section('content')

    {{-- =====================================================
         BANNER
    ====================================================== --}}

    <section class="home-section">

        <div class="site-container">

            <div class="home-jobs-banner">

                <div>

                    <span>
                        ساعد الآخرين
                    </span>

                    <h2>
                        أضف وظيفة جديدة
                    </h2>

                    <p>
                        أدخل بيانات الوظيفة لتظهر للباحثين عن عمل
                    </p>

                </div>

                <a href="{{ route('jobs.index') }}" class="home-jobs-button">

                    العودة للوظائف

                    <i class="fa-solid fa-arrow-left"></i>

                </a>

            </div>

        </div>

    </section>


    {{-- =====================================================
         FORM
    ====================================================== --}}

    <main>

        <div class="container">

            <form
                method="POST"
                action="{{ route('job.store') }}"
                class="form-layout"
            >

                @csrf


                <div>


                    {{-- =====================================================
                         بيانات الوظيفة
                    ====================================================== --}}

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-briefcase"></i>

                            بيانات الوظيفة

                        </h3>


                        <div class="form-grid">


                            {{-- اسم الوظيفة --}}

                            <div class="form-group">

                                <label>

                                    اسم الوظيفة

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    value="{{ old('title') }}"
                                    placeholder="مثال: طبيب أسنان"
                                >

                                @error('title')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- مجال الوظيفة --}}

                            <div class="form-group">

                                <label>

                                    مجال الوظيفة

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="category"
                                    value="{{ old('category') }}"
                                    placeholder="مثال: طب وصحة"
                                >

                                @error('category')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- اسم الشركة --}}

                            <div class="form-group">

                                <label>

                                    اسم العيادة أو الجهة أو الدكتور

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="company_name"
                                    value="{{ old('company_name') }}"
                                    placeholder="اسم المستشفى أو العيادة"
                                >

                                @error('company_name')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- نوع الدوام --}}

                            <div class="form-group">

                                <label>

                                    نوع الدوام

                                    <span class="required">*</span>

                                </label>

                                <select name="job_type">

                                    <option value="">
                                        اختر نوع الدوام
                                    </option>

                                    <option
                                        value="دوام كامل"
                                        {{ old('job_type') == 'دوام كامل' ? 'selected' : '' }}
                                    >
                                        دوام كامل
                                    </option>

                                    <option
                                        value="دوام جزئي"
                                        {{ old('job_type') == 'دوام جزئي' ? 'selected' : '' }}
                                    >
                                        دوام جزئي
                                    </option>

                                    <option
                                        value="العمل عن بعد"
                                        {{ old('job_type') == 'العمل عن بعد' ? 'selected' : '' }}
                                    >
                                        العمل عن بعد
                                    </option>

                                </select>

                                @error('job_type')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- عدد الموظفين --}}

                            <div class="form-group">

                                <label>
                                    عدد الموظفين المطلوبين
                                </label>

                                <input
                                    type="number"
                                    name="vacancies"
                                    value="{{ old('vacancies', 1) }}"
                                    min="1"
                                    placeholder="مثال: 2"
                                >

                                @error('vacancies')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- آخر موعد --}}

                            <div class="form-group">

                                <label>
                                    آخر موعد للتقديم
                                </label>

                                <input
                                    type="date"
                                    name="application_deadline"
                                    value="{{ old('application_deadline') }}"
                                >

                                @error('application_deadline')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                         مكان العمل
                    ====================================================== --}}

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-location-dot"></i>

                            مكان العمل

                        </h3>


                        <div class="form-grid">

                            <div class="form-group full">

                                <label>

                                    عنوان مكان العمل

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="text"
                                    name="location"
                                    value="{{ old('location') }}"
                                    placeholder="مثال: دمنهور، شارع الجمهورية، بجوار المستشفى العام"
                                >

                                @error('location')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                         الراتب والخبرة
                    ====================================================== --}}

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-money-bill-wave"></i>

                            الراتب والخبرة

                        </h3>


                        <div class="form-grid">


                            {{-- الراتب من --}}

                            <div class="form-group">

                                <label>
                                    الراتب من
                                </label>

                                <input
                                    type="number"
                                    name="salary_min"
                                    value="{{ old('salary_min') }}"
                                    min="0"
                                    placeholder="مثال: 3000"
                                >

                                @error('salary_min')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- الراتب إلى --}}

                            <div class="form-group">

                                <label>
                                    الراتب إلى
                                </label>

                                <input
                                    type="number"
                                    name="salary_max"
                                    value="{{ old('salary_max') }}"
                                    min="0"
                                    placeholder="مثال: 9000"
                                >

                                @error('salary_max')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- الخبرة --}}

                            <div class="form-group">

                                <label>
                                    الخبرة المطلوبة
                                </label>

                                <select name="experience">

                                    <option value="">
                                        اختر الخبرة
                                    </option>

                                    <option
                                        value="أقل من سنة"
                                        {{ old('experience') == 'أقل من سنة' ? 'selected' : '' }}
                                    >
                                        أقل من سنة
                                    </option>

                                    <option
                                        value="من سنة إلى 3 سنوات"
                                        {{ old('experience') == 'من سنة إلى 3 سنوات' ? 'selected' : '' }}
                                    >
                                        من سنة إلى 3 سنوات
                                    </option>

                                    <option
                                        value="من 3 إلى 5 سنوات"
                                        {{ old('experience') == 'من 3 إلى 5 سنوات' ? 'selected' : '' }}
                                    >
                                        من 3 إلى 5 سنوات
                                    </option>

                                    <option
                                        value="أكثر من 5 سنوات"
                                        {{ old('experience') == 'أكثر من 5 سنوات' ? 'selected' : '' }}
                                    >
                                        أكثر من 5 سنوات
                                    </option>

                                </select>

                                @error('experience')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- المؤهل --}}

                            <div class="form-group">

                                <label>
                                    المؤهل المطلوب
                                </label>

                                <input
                                    type="text"
                                    name="qualification"
                                    value="{{ old('qualification') }}"
                                    placeholder="مثال: بكالوريوس طب"
                                >

                                @error('qualification')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                         مواعيد العمل
                    ====================================================== --}}

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-clock"></i>

                            مواعيد العمل

                        </h3>


                        <div class="form-grid">


                            <div class="form-group">

                                <label>
                                    ساعات العمل
                                </label>

                                <input
                                    type="text"
                                    name="working_hours"
                                    value="{{ old('working_hours') }}"
                                    placeholder="مثال: 8 ساعات يوميًا"
                                >

                                @error('working_hours')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            <div class="form-group">

                                <label>
                                    أيام العمل
                                </label>

                                <input
                                    type="text"
                                    name="working_days"
                                    value="{{ old('working_days') }}"
                                    placeholder="مثال: من السبت إلى الخميس"
                                >

                                @error('working_days')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                         تفاصيل الوظيفة
                    ====================================================== --}}

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-file-lines"></i>

                            تفاصيل الوظيفة

                        </h3>


                        <div class="form-grid">

                            <div class="form-group full">

                                <label>

                                    وصف الوظيفة

                                    <span class="required">*</span>

                                </label>

                                <textarea
                                    name="description"
                                    placeholder="اكتب وصفًا واضحًا عن الوظيفة والمسؤوليات..."
                                >{{ old('description') }}</textarea>

                                @error('description')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                         بيانات التواصل
                    ====================================================== --}}

                    <section class="form-card">

                        <h3 class="form-section-title">

                            <i class="fa-solid fa-phone"></i>

                            بيانات التواصل

                        </h3>


                        <div class="form-grid">


                            {{-- الهاتف --}}

                            <div class="form-group">

                                <label>

                                    رقم الهاتف

                                    <span class="required">*</span>

                                </label>

                                <input
                                    type="tel"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="01XXXXXXXXX"
                                >

                                @error('phone')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>


                            {{-- واتساب --}}

                            <div class="form-group">

                                <label>
                                    رقم واتساب
                                </label>

                                <input
                                    type="tel"
                                    name="whatsapp"
                                    value="{{ old('whatsapp') }}"
                                    placeholder="01XXXXXXXXX"
                                >

                                @error('whatsapp')

                                    <small class="field-error">
                                        {{ $message }}
                                    </small>

                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- =====================================================
                         زر الإرسال
                    ====================================================== --}}

                    <div class="form-actions">

                        <button
                            type="submit"
                            class="details-btn"
                        >

                            إرسال الوظيفة للمراجعة



                        </button>

                    </div>

                </div>


                {{-- =====================================================
                     Sidebar
                ====================================================== --}}

                <aside class="sidebar">

                    <div class="info-card">

                        <h3>
                            قبل إرسال الوظيفة
                        </h3>

                        <ul class="info-list">

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                اكتب اسم وظيفة واضحًا.

                            </li>

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                أدخل مكان العمل والراتب إن أمكن.

                            </li>

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                تأكد من صحة رقم التواصل.

                            </li>

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                سيتم مراجعة الوظيفة قبل ظهورها.

                            </li>

                            <li>

                                <i class="fa-solid fa-circle-check"></i>

                                بمجرد مراجعة الوظيفة سيتم نشرها.

                            </li>

                        </ul>

                    </div>

                </aside>

            </form>

        </div>

    </main>

@endsection
