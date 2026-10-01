@extends('home.layout.app')

@section('title', 'تواصل معنا | دليل الأطباء')

@section('content')
    <x-home.hero.secondhero title="تواصل معنا" address="فريق دليل طبيب" contet1=" فريق دليل طبيب" content_continuation="فريقنا"
        note="عندك استفسار، اقتراح، أو فكرة مشروع تحتاج تنفيذها؟ ابعت لنا رسالتك، وفريقنا هيتواصل معاك." />

    <!-- =================================================
        Contact
        ================================================= -->

    <section class="contact-section">

        <div class="container">

            <div class="contact-wrapper">

                <!-- معلومات التواصل -->

                <aside class="contact-information">

                    <h2>بيانات التواصل</h2>

                    <p>
                        تقدر تتواصل معانا
                        من خلال بيانات التواصل،
                        أو تبعت رسالتك من النموذج.
                    </p>

                    <div class="contact-info-list">

                        <div class="contact-info">
                            <div class="contact-info-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h4>رقم الهاتف</h4>
                                <p>0100 000 0000</p>
                            </div>
                        </div>

                        <div class="contact-info">
                            <div class="contact-info-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h4>عنوان الإدارة</h4>
                                <p>البحيره - مصر</p>
                            </div>
                        </div>

                        <div class="contact-info">
                            <div class="contact-info-icon">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <h4>مواعيد الدعم</h4>
                                <p>
                                    يوميًا من 10 صباحًا
                                    حتى 8 مساءً
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="social-links">

                        <a href="#">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a href="#">
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <a href="https://wa.me/201093796014" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>

                    </div>

                </aside>

                <!-- الفورم -->

                <div class="contact-form-card">

                    <div class="form-heading">

                        <h2>أرسل رسالة</h2>

                        <p>
                            اكتب بياناتك ورسالتك،
                            وهنراجع طلبك في أقرب وقت.
                        </p>

                    </div>

                    {{-- novalidate: عشان رسائل الخطأ من السيرفر هي اللي تظهر تحت كل حقل --}}
                    <form class="contact-form" id="contactForm" method="POST" action="{{ route('contact.store') }}"
                        novalidate>

                        @csrf

                        <div class="form-grid">

                            <!-- الاسم -->

                            <div class="form-group">

                                <label for="contact-name">الاسم بالكامل</label>

                                <input id="contact-name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" type="text"
                                    placeholder="اكتب اسمك" value="{{ old('name') }}" required
                                    @error('name') aria-invalid="true" aria-describedby="contact-name-error" @enderror>

                                @error('name')
                                    <small class="field-error" id="contact-name-error" role="alert">{{ $message }}</small>
                                @enderror


                            </div>

                            <!-- الهاتف -->

                            <div class="form-group">

                                <label for="contact-phone">رقم الهاتف</label>

                                <input id="contact-phone" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" type="tel"
                                    inputmode="tel" placeholder="01xxxxxxxxx" value="{{ old('phone') }}" required
                                    @error('phone') aria-invalid="true" aria-describedby="contact-phone-error" @enderror>

                                @error('phone')
                                    <small class="field-error" id="contact-phone-error" role="alert">{{ $message }}</small>
                                @enderror

                            </div>


                            <!-- الرسالة -->

                            <div class="form-group full">

                                <label for="contact-message">الرسالة</label>

                                <textarea id="contact-message" name="message"
                                    class="form-control @error('message') is-invalid @enderror"
                                    placeholder="اكتب رسالتك بالتفصيل..." required
                                    @error('message') aria-invalid="true" aria-describedby="contact-message-error" @enderror>{{ old('message') }}</textarea>

                                @error('message')
                                    <small class="field-error" id="contact-message-error" role="alert">{{ $message }}</small>
                                @enderror

                            </div>

                        </div>

                        <button class="submit-button" type="submit">

                            <i class="fa-solid fa-paper-plane"></i>

                            إرسال الرسالة

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </section>

    <!-- =================================================
        الأسئلة الشائعة
        ================================================= -->

    <section class="faq-section">

        <div class="faq-heading ">

            <div class="section-q-heading">

                <span>اعرف أكثر</span>

                <h2>الأسئلة الشائعة</h2>

                <p>
                    إجابات سريعة على أكثر الأسئلة التي تصل إلى فريق دليل طبيب.
                </p>

            </div>

            <div class="faq-list">

                <!-- السؤال 1 -->
                <article class="faq-item ">

                    <button class="faq-question" type="button">

                        إزاي أبحث عن طبيب مناسب؟

                        <i class="fa-solid fa-chevron-down"></i>

                    </button>

                    <div class="faq-answer">
                        تقدر تبحث باسم الطبيب
                        أو التخصص، وتستخدم الفلاتر
                        لتحديد المنطقة والسعر
                        المناسب ليك.
                    </div>

                </article>

                <!-- السؤال 2 -->

                <article class="faq-item">

                    <button class="faq-question" type="button">

                        هل استخدام الموقع مجاني؟

                        <i class="fa-solid fa-chevron-down"></i>

                    </button>

                    <div class="faq-answer">
                        أيوه، البحث عن الأطباء
                        وتصفح بياناتهم متاح
                        للمستخدمين بدون رسوم.
                    </div>

                </article>

                <!-- السؤال 3 -->

                <article class="faq-item">

                    <button class="faq-question" type="button">

                        إزاي أضيف طبيب إلى المفضلة؟

                        <i class="fa-solid fa-chevron-down"></i>

                    </button>

                    <div class="faq-answer">
                        اضغط على أيقونة القلب
                        الموجودة في كارت الطبيب
                        أو داخل صفحة تفاصيل الطبيب،
                        وهيتضاف إلى المفضلة.
                    </div>

                </article>

            </div>

            <!-- زر عرض الكل -->

            <a class="show-faq-button" id="showFaqButton" href="{{ route('faq') }}">

                <i class="fa-solid fa-circle-question"></i>

                عرض جميع الأسئلة الشائعة

                <i class="fa-solid fa-chevron-left"></i>

            </a>

        </div>

    </section>
@endsection
