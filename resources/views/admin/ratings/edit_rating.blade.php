
@extends('admin.layout.app')

@section('title', 'لوحة التحكم | تعديل التقييم')

@section('content')

    <div class="doctor-review-edit-page">

        {{-- =========================================================
           HEADER
        ========================================================== --}}

        <div class="doctor-review-edit-header">

            <div class="doctor-review-edit-title">

                <div class="edit-title-icon">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>

                <div class="edit-title-content">

                    <span>
                        إدارة التقييمات
                    </span>

                    <h1>
                        تعديل التقييم
                    </h1>

                    <p>
                        تعديل بيانات وتقييم المستخدم للطبيب
                    </p>

                </div>

            </div>

            <a href="{{ route('admin.ratings.index') }}" class="edit-back-button">

                <i class="fa-solid fa-arrow-right"></i>

                العودة للتقييمات

            </a>

        </div>


        {{-- =========================================================
           FORM CARD
        ========================================================== --}}

        <div class="doctor-review-edit-card">

            <form
                action="{{ route('admin.ratings.update', $review->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                {{-- =================================================
                   USERS INFO
                ================================================== --}}

                <div class="edit-info-grid">

                    {{-- USER --}}

                    <div class="edit-info-box">

                        <div class="edit-info-icon user">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <div class="edit-info-content">

                            <span>
                                صاحب التقييم
                            </span>

                            <strong>
                                {{ $review->user?->name ?? 'مستخدم غير معروف' }}
                            </strong>

                            @if($review->user?->email)

                                <small>
                                    {{ $review->user->email }}
                                </small>

                            @endif

                        </div>

                    </div>


                    {{-- DOCTOR --}}

                    <div class="edit-info-box">

                        <div class="edit-info-icon doctor">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>

                        <div class="edit-info-content">

                            <span>
                                الطبيب
                            </span>

                            <strong>
                                {{ $review->doctor?->user?->name ?? 'طبيب غير معروف' }}
                            </strong>

                            @if($review->doctor?->specialty)

                                <small>
                                    {{ $review->doctor->specialty->name }}
                                </small>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- =================================================
                   RATING
                ================================================== --}}

                <div class="edit-form-section">

                    <div class="edit-section-title">

                        <div class="edit-section-icon rating">
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <div>

                            <h2>
                                التقييم
                            </h2>

                            <p>
                                اختر عدد النجوم المناسب للتقييم
                            </p>

                        </div>

                    </div>


                    <div class="edit-rating-wrapper">

                        <div class="edit-stars">

                            @for($i = 1; $i <= 5; $i++)

                                <button
                                    type="button"
                                    class="edit-star-button {{ $i <= $review->rating ? 'active' : '' }}"
                                    data-rating="{{ $i }}"
                                    aria-label="{{ $i }} نجوم"
                                >

                                    <i class="fa-solid fa-star"></i>

                                </button>

                            @endfor

                        </div>


                        <div class="edit-rating-value">

                            <strong id="editRatingValue">
                                {{ $review->rating }}/5
                            </strong>

                            <span id="editRatingText">

                                @switch($review->rating)

                                    @case(1)
                                        سيئ
                                        @break

                                    @case(2)
                                        مقبول
                                        @break

                                    @case(3)
                                        جيد
                                        @break

                                    @case(4)
                                        ممتاز
                                        @break

                                    @case(5)
                                        ممتاز جدًا
                                        @break

                                @endswitch

                            </span>

                        </div>

                    </div>


                    <input
                        type="hidden"
                        name="rating"
                        id="editRatingInput"
                        value="{{ old('rating', $review->rating) }}"
                    >


                    @error('rating')

                        <span class="edit-field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- =================================================
                   COMMENT
                ================================================== --}}

                <div class="edit-form-section">

                    <div class="edit-section-title">

                        <div class="edit-section-icon comment">
                            <i class="fa-solid fa-comment"></i>
                        </div>

                        <div>

                            <h2>
                                التعليق
                            </h2>

                            <p>
                                تعديل نص تجربة المستخدم
                            </p>

                        </div>

                    </div>


                    <div class="edit-textarea-wrapper">

                        <textarea
                            name="comment"
                            class="edit-review-textarea"
                            placeholder="اكتب تعليق التقييم..."
                            required
                        >{{ old('comment', $review->comment) }}</textarea>

                    </div>


                    @error('comment')

                        <span class="edit-field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- =================================================
                   STATUS
                ================================================== --}}

                <div class="edit-form-section">

                    <div class="edit-section-title">

                        <div class="edit-section-icon status">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>

                        <div>

                            <h2>
                                حالة التقييم
                            </h2>

                            <p>
                                تحديد حالة التقييم داخل النظام
                            </p>

                        </div>

                    </div>


                    <div class="edit-status-options">


                        {{-- APPROVED --}}

                        <label class="edit-status-option approved">

                            <input
                                type="radio"
                                name="status"
                                value="approved"
                                {{ old('status', $review->status) === 'approved' ? 'checked' : '' }}
                            >

                            <div class="edit-status-content">

                                <div class="edit-status-option-icon">

                                    <i class="fa-solid fa-circle-check"></i>

                                </div>

                                <div>

                                    <strong>
                                        مقبول
                                    </strong>

                                    <span>
                                        التقييم ظاهر ومقبول
                                    </span>

                                </div>

                            </div>

                        </label>





                        {{-- REJECTED --}}

                        <label class="edit-status-option rejected">

                            <input
                                type="radio"
                                name="status"
                                value="rejected"
                                {{ old('status', $review->status) === 'rejected' ? 'checked' : '' }}
                            >

                            <div class="edit-status-content">

                                <div class="edit-status-option-icon">

                                    <i class="fa-solid fa-circle-xmark"></i>

                                </div>

                                <div>

                                    <strong>
                                        مرفوض
                                    </strong>

                                    <span>
                                        التقييم غير مقبول
                                    </span>

                                </div>

                            </div>

                        </label>

                    </div>


                    @error('status')

                        <span class="edit-field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- =================================================
                   ACTIONS
                ================================================== --}}

                <div class="edit-form-actions">

                    <a
                        href="{{ route('admin.ratings.index') }}"
                        class="edit-cancel-button"
                    >

                        <i class="fa-solid fa-xmark"></i>

                        إلغاء

                    </a>


                    <button
                        type="submit"
                        class="edit-save-button"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        حفظ التعديلات

                    </button>

                </div>

            </form>

        </div>

    </div>




@endsection
