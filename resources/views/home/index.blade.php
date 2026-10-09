@extends('home.layout.app')
@section('title', 'دليل الأطباء | ابحث عن طبيبك')



@section('content')

    <main>
        <x-home.hero.firsthero nav=" دليل طبي موثوق ومراجع" title="اعثر على طبيبك" title_continue=" بسهولة وثقة"
            note1=" ملفات طبية موثوقة" anser1="بيانات يراجعها الموقع" note2=" تقييمات المستخدمين"
            anser2="تجارب تساعدك على الاختيار" :home="true" :areas="$areas">

            ابحث باسم الطبيب أو التخصص أو المحافظة،
            واطّلع على بيانات العيادة والخدمات المتاحة
            قبل التواصل.
        </x-home.hero.firsthero>

        <section class="home-section">

            <div class="site-container">

                <div class="home-section-head">

                    <div>

                        <span class="home-section-label">

                            <i class="fa-solid fa-stethoscope"></i>

                            التخصصات الطبية

                        </span>

                        <h2>

                            اختر التخصص المناسب

                        </h2>

                        <p>

                            تصفح التخصصات وابحث عن الطبيب المناسب لك.

                        </p>

                    </div>

                    <a href="{{ route('specialties.index') }}" class="home-all-link">

                        عرض جميع التخصصات

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                </div>

                <div class="specialties-grid">






                    @if ($specialties->isNotEmpty())

                        @foreach ($specialties as $specialty)
                            <x-home.specialties.card_specialties :link="route('specialties.show', $specialty->slug)" :number="str_pad($loop->iteration, 2, '0', STR_PAD_LEFT)" :name="$specialty->name"
                                :title="$specialty->title" :logo="$specialty->logo" />
                        @endforeach
                    @else
                        <x-home.banner.no_results logo="fa-solid fa-stethoscope" title="لا توجد تخصصات الان"
                            content="لم يتم اضافه تخصصات او يوجد مشكله بالموقع  " />

                    @endif
                </div>

            </div>
        </section>

        <section class="home-doctors-section">

            <div class="site-container">

                <div class="home-section-head">

                    <div>

                        <span class="home-section-label">

                            <i class="fa-solid fa-star"></i>

                            أطباء مميزون

                        </span>

                        <h2>

                            أطباء موثوقون

                        </h2>

                        <p>

                            اطّلع على الملفات الطبية وبيانات العيادات.

                        </p>

                    </div>

                    <a href="{{ route('doctors.index') }}" class="home-all-link">

                        عرض جميع الأطباء

                        <i class="fa-solid fa-arrow-left"></i>

                    </a>

                </div>

                @if ($doctors->isNotEmpty())
                    <x-home.doctors.doctors_grid :doctors="$doctors"  :favorite-ids="$favoriteIds" />
                @else
                    <x-home.banner.no_results logo="fa-solid fa-user-doctor" title="لا يوجد أطباء حاليًا"
                        content="لم يتم إضافة أطباء حتى الآن." />
                @endif

            </div>

        </section>







        <x-home.banner.firstbanner nav=" فرص عمل جديدة" title="ابحث عن فرصتك القادمة" link="عرض الوظائف " :route="route('jobs.index')">

            تصفح الوظائف المتاحة في المجالات الطبية.

        </x-home.banner.firstbanner>


        <section class="home-join-section">

            <div class="site-container">

                <div class="home-join-card">

                    <div>

                        <span class="home-section-label">

                            <i class="fa-solid fa-user-doctor"></i>

                            هل أنت طبيب؟

                        </span>

                        <h2>

                            اجعل الوصول إليك أسهل

                        </h2>

                        <p>

                            أنشئ حسابك، واختر الباقة المناسبة،
                            وأضف بيانات ملفك الطبي.
                            بعد مراجعة البيانات يظهر ملفك للزوار.

                        </p>

                        <div class="home-join-features">

                            <span>

                                <i class="fa-solid fa-check"></i>

                                ملف طبي احترافي

                            </span>

                            <span>

                                <i class="fa-solid fa-check"></i>

                                إحصائيات المشاهدات

                            </span>

                            <span>

                                <i class="fa-solid fa-check"></i>

                                إدارة سهلة للبيانات

                            </span>

                        </div>

                        <a href="{{ route('doctor_join') }}" class="home-join-button">

                            أنشئ حساب طبيب

                            <i class="fa-solid fa-arrow-left"></i>

                        </a>

                    </div>

                    <div class="home-join-visual">

                        <i class="fa-solid fa-user-doctor"></i>

                    </div>

                </div>

            </div>

        </section>
    </main>
@endsection
