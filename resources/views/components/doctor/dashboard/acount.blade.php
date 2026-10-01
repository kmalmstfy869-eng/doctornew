@props(['doctor', 'doctorname'])
@php
    $planSlug = strtolower($doctor->subscription?->plan?->slug ?? 'مجاني');
    $doctorImage = $doctor->doctor_image;
@endphp

<div class="panel" id="account-summary">


    <div class="panel-head">

        <div class="panel-title">

            <strong>
                ملخص حسابك
            </strong>

            <span>
                نظرة سريعة على بياناتك وحالة ملفك الطبي
            </span>

        </div>

    </div>


    <div class="account-summary">


        <div class="account-intro">

            <div class="account-avatar">

                @if ($doctorImage)
                    <img src="{{ asset('storage/' . $doctorImage) }}" alt="د. {{ $doctorname }}"
                        class="account-doctor-image">
                @else
                    <div class="med-doctor-image-placeholder">

                        <div class="med-placeholder-icon">
                            <span>♙</span>
                        </div>

                    </div>
                @endif

            </div>

            <div class="account-intro-info">

                <strong>
                    د. {{ $doctorname }}
                </strong>

                <span>
                    {{ $doctor->specialty?->name ?? 'التخصص غير محدد' }}
                </span>


                <div class="account-status">

                    <i></i>

                    الحساب نشط

                </div>

            </div>

        </div>


        <div class="account-info-grid">


            <div class="account-row">

                <div class="account-row-icon">
                    ★
                </div>

                <div class="account-row-content">

                    <span>
                        التخصص
                    </span>

                    <strong>
                        {{ $doctor->specialty?->name ?? 'غير محدد' }}
                    </strong>

                </div>

            </div>


            <div class="account-row">

                <div class="account-row-icon">
                    ◉
                </div>

                <div class="account-row-content">

                    <span>
                        المنطقة
                    </span>

                    <strong>
                        {{ $doctor->area?->name ?? 'غير محددة' }}
                    </strong>

                </div>

            </div>


            <div class="account-row">

                <div class="account-row-icon">
                    ☆
                </div>

                <div class="account-row-content">

                    <span>
                        التقييم
                    </span>

                    <strong>
                        @php
                            $averageRating = $doctor->rating()->avg('rating');
                        @endphp

                        {{ $averageRating ? number_format($averageRating, 1) . ' / 5' : 'لا توجد تقييمات' }}
                    </strong>

                </div>

            </div>


            <div class="account-row">

                <div class="account-row-icon">
                    ♛
                </div>

                <div class="account-row-content">

                    <span>
                        الاشتراك
                    </span>
                    @if ($doctor->hasFeature('subscription'))
                        <strong>
                            {{ $planSlug }}
                        </strong>
                    @else
                        <strong>
                            {{ 'مجاني' }}
                        </strong>
                    @endif
                </div>

            </div>

        </div>


        <div class="account-actions">

            <a href="{{ route('doctor.profile.show') }}" class="account-action primary">

                مشاهدة الملف الطبي

            </a>


            <a href="{{ route('doctor.profile.edit') }}" class="account-action secondary">

                تعديل الملف

            </a>

        </div>

    </div>

</div>
