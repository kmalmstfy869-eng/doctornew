@props(['doctorname'])

<section class="pr-hero" role="status">
    <div class="pr-glow pr-glow-a"></div>
    <div class="pr-glow pr-glow-b"></div>
    <div class="pr-grid"></div>

    <div class="pr-top">
        <span class="pr-badge">
            <i></i>
            قيد المراجعة
        </span>
        <span class="pr-eta">
            <i class="fa-regular fa-clock"></i>
            أقل من 8 ساعات
        </span>
    </div>

    <div class="pr-main">
        <div class="pr-icon">
            <i class="fa-solid fa-hourglass-half"></i>
            <span class="pr-ring"></span>
            <span class="pr-ring pr-ring-2"></span>
        </div>

        <div class="pr-text">
            <h1>أهلاً بك، د. {{ $doctorname }} 👋</h1>
            <h2>حسابك قيد المراجعة حالياً</h2>
            <p>
                استلمنا طلب انضمامك وفريقنا بيراجعه الآن. ملفك
                <strong>لسه مش ظاهر للمرضى</strong>
                وهيظهر فور الموافقة، وهنبلغك بإشعار  في نفس اللحظة.
            </p>
        </div>
    </div>

    <ol class="pr-steps">
        <li class="done">
            <span><i class="fa-solid fa-check"></i></span>
            <b>تم التسجيل</b>
            <small>استلمنا طلبك</small>
        </li>
        <li class="active">
            <span><i class="fa-solid fa-shield-halved"></i></span>
            <b>المراجعة</b>
            <small>جارية الآن</small>
        </li>
        <li>
            <span><i class="fa-solid fa-user-doctor"></i></span>
            <b>الظهور للمرضى</b>
            <small>بعد الموافقة</small>
        </li>
    </ol>

    <div class="pr-foot">
        <i class="fa-solid fa-bell"></i>
        <span>هتوصلك إشعار هنا أول ما يتم قبول حسابك.</span>
    </div>
</section>
