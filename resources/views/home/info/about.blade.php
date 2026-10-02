@extends('home.layout.app')

@section('title', 'دليل الأطباء | ابحث عن طبيبك')


@section('content')

    <main>


        <x-home.hero.firsthero nav="من نحن" title="تسهيل عليك الوصول" title_continue="لطبيبك المفضل" note1="بحث سريع"
            anser1="حسب التخصص والمكان" note2="معلومات منظمة" anser2="تجربة أوضح للمستخدم">
            دليل الأطباء منصة رقمية تساعدك على اكتشاف الأطباء والتخصصات والخدمات الطبية بسهولة، من خلال تجربة بسيطة ومنظمة
            تساعدك توصل للمعلومة اللي محتاجها بسهولة.
        </x-home.hero.firsthero>




        <section class="section">

            <div class="container">


                <div class="section-head">

                    <span>
                        لماذا دليل الأطباء؟
                    </span>

                    <h2>
                        كل اللي تحتاجه في مكان واحد
                    </h2>

                    <p>
                        هدفنا نجعل الوصول للمعلومات الطبية أسهل وأوضح.
                    </p>

                </div>



                <div class="features-grid">


                    <article class="feature-card">

                        <div class="feature-icon">

                            <i class="fa-solid fa-magnifying-glass"></i>

                        </div>

                        <h3>
                            بحث وتنظيم
                        </h3>

                        <p>
                            ابحث عن الطبيب أو التخصص والمكان
                            بطريقة سريعة ومنظمة.
                        </p>

                    </article>



                    <article class="feature-card">

                        <div class="feature-icon">

                            <i class="fa-solid fa-user-doctor"></i>

                        </div>

                        <h3>
                            دليل طبي متنوع
                        </h3>

                        <p>
                            استعرض الأطباء والتخصصات المختلفة
                            من خلال ملفات واضحة وسهلة.
                        </p>

                    </article>



                    <article class="feature-card">

                        <div class="feature-icon">

                            <i class="fa-solid fa-mobile-screen-button"></i>

                        </div>

                        <h3>
                            تجربة بسيطة
                        </h3>

                        <p>
                            تصميم مريح يعمل بشكل جيد على
                            الكمبيوتر والموبايل.
                        </p>

                    </article>


                </div>

            </div>

        </section>





        <section class="section mission-section">

            <div class="container mission-content">


                <div class="mission-visual">

                    <div class="mission-icon-box">

                        <i class="fa-solid fa-heart-pulse"></i>

                    </div>

                </div>



                <div class="mission-text">


                    <span class="section-badge">

                        <i class="fa-solid fa-bullseye"></i>

                        رؤيتنا

                    </span>


                    <h2>

                        نجعل الوصول للرعاية الطبية

                        <span>
                            أسهل وأوضح
                        </span>

                    </h2>


                    <p>

                        بنبني المنصة على فكرة بسيطة:
                        المستخدم ما يضيعش وقت في البحث عن
                        المعلومات اللي محتاجها.

                    </p>


                    <p>

                        لذلك بنركز على تنظيم بيانات الأطباء
                        والتخصصات والمناطق والخدمات في تجربة
                        واضحة وسهلة الاستخدام.

                    </p>


                    <ul class="mission-list">

                        <li>

                            <i class="fa-solid fa-check"></i>

                            واجهة سهلة وواضحة

                        </li>


                        <li>

                            <i class="fa-solid fa-check"></i>

                            تنظيم أفضل للمعلومات

                        </li>


                        <li>

                            <i class="fa-solid fa-check"></i>

                            تجربة مناسبة للموبايل والكمبيوتر

                        </li>


                        <li>

                            <i class="fa-solid fa-check"></i>

                            تطوير مستمر للمنصة

                        </li>

                    </ul>


                </div>

            </div>

        </section>




        <section class="company-section">

            <div class="container">


                <div class="company-card">


                    <div class="company-content">


                        <span class="company-label">

                            <i class="fa-solid fa-code"></i>

                            تم تصميم وتطوير المنصة بواسطة شركه

                        </span>


                        <h2>

                            MK SOFT

                        </h2>


                        <p>

                            بنصمم ونطور مواقع وأنظمة ويب احترافية
                            تساعد الشركات والأطباء وأصحاب المشاريع
                            يحولوا أفكارهم إلى منتجات رقمية حقيقية.

                        </p>


                        <div class="company-services">

                            <span>

                                <i class="fa-solid fa-check"></i>

                                مواقع شركات

                            </span>

                            <span>

                                <i class="fa-solid fa-check"></i>

                                أنظمة إدارية

                            </span>

                            <span>

                                <i class="fa-solid fa-check"></i>

                                مواقع طبية

                            </span>

                            <span>

                                <i class="fa-solid fa-check"></i>

                                متاجر إلكترونية

                            </span>

                        </div>

                        <a href="{{ route('contact.index') }}" class="company-button">
                            عندك فكرة؟ خلينا ننفذها

                            <i class="fa-solid fa-arrow-left"></i>
                        </a>


                    </div>



                    <div class="company-visual">


                        <div class="company-circle">

                            <div class="company-logo-box">

                                &lt;/&gt;

                            </div>

                        </div>


                        <div class="company-small-card">

                            <i class="fa-solid fa-circle-check"></i>

                            <span>
                                نحول فكرتك إلى منتج
                            </span>

                        </div>


                    </div>


                </div>

            </div>

        </section>



    </main>


@endsection
