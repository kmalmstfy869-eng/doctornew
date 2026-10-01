/* =========================================================
   APP.JS
   دليل الأطباء
========================================================= */


/* =========================================================
   DARK MODE
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const themeButton =
        document.getElementById("themeButton");

    const themeIcon =
        document.getElementById("themeIcon");

    const savedTheme =
        localStorage.getItem("doctorDirectoryTheme");


    if (savedTheme === "dark") {

        document.body.classList.add("dark");

        if (themeIcon) {

            themeIcon.className =
                "fa-solid fa-sun";

        }

    } else {

        document.body.classList.remove("dark");

        if (themeIcon) {

            themeIcon.className =
                "fa-solid fa-moon";

        }

    }


    if (themeButton) {

        themeButton.addEventListener(
            "click",
            function () {

                document.body.classList.toggle("dark");


                const isDark =
                    document.body.classList.contains("dark");


                localStorage.setItem(
                    "doctorDirectoryTheme",
                    isDark ? "dark" : "light"
                );


                if (themeIcon) {

                    themeIcon.className =
                        isDark
                            ? "fa-solid fa-sun"
                            : "fa-solid fa-moon";

                }

            }
        );

    }

});


/* =========================================================
   HOME SEARCH
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const homeSearchForm =
        document.getElementById("homeSearchForm");


    if (!homeSearchForm) {
        return;
    }


    homeSearchForm.addEventListener(
        "submit",
        function () {

            /*
             * Laravel يستقبل البحث.
             * لا نمنع الإرسال.
             */

        }
    );

});


/* =========================================================
   FAQ
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const faqItems =
        document.querySelectorAll(".faq-item");


    if (!faqItems.length) {
        return;
    }


    faqItems.forEach(function (item) {

        const question =
            item.querySelector(".faq-question");


        if (!question) {
            return;
        }


        question.addEventListener(
            "click",
            function () {

                faqItems.forEach(function (otherItem) {

                    if (otherItem !== item) {

                        otherItem.classList.remove(
                            "active"
                        );

                    }

                });


                item.classList.toggle("active");

            }
        );

    });

});


/* =========================================================
   DOCTOR PROFILE
========================================================= */

document.addEventListener("DOMContentLoaded", function () {


    /* =========================================
       Scroll To Booking
    ========================================= */

    document
        .querySelectorAll('a[href="#med-booking"]')
        .forEach(function (link) {

            link.addEventListener(
                "click",
                function (event) {

                    event.preventDefault();


                    const booking =
                        document.getElementById(
                            "med-booking"
                        );


                    if (!booking) {
                        return;
                    }


                    booking.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });

                }
            );

        });


    /* =========================================
       Booking
    ========================================= */

    const bookingSection =
        document.getElementById("med-booking");


    /*
     * الصفحة الحالية ليست صفحة حجز
     */

    if (!bookingSection) {
        return;
    }


    /* =========================================
       Booking Accordion
    ========================================= */

    const dayAccordions =
        document.querySelectorAll(
            ".med-day-accordion"
        );


    dayAccordions.forEach(function (day) {

        const header =
            day.querySelector(
                ".med-day-header"
            );


        if (!header) {
            return;
        }


        header.addEventListener(
            "click",
            function () {

                const wasActive =
                    day.classList.contains("active");


                dayAccordions.forEach(function (item) {

                    item.classList.remove("active");

                });


                if (!wasActive) {

                    day.classList.add("active");

                }

            }
        );

    });


    /* =========================================
       Appointment Selection
    ========================================= */

    const timeButtons =
        document.querySelectorAll(
            ".med-day-times button:not(.unavailable)"
        );


    const selectedText =
        document.getElementById(
            "medSelectedText"
        );


    const confirmBooking =
        document.getElementById(
            "medConfirmBooking"
        );


    let selectedAppointment = null;


    /* =========================================
       Format Arabic Time
    ========================================= */

    function formatArabicTime(time) {

        if (!time) {
            return "";
        }


        const parts =
            time.split(":");


        let hour =
            Number(parts[0]);


        const minute =
            parts[1] || "00";


        const period =
            hour >= 12
                ? "م"
                : "ص";


        hour =
            hour % 12 || 12;


        return (
            String(hour).padStart(2, "0") +
            ":" +
            minute +
            " " +
            period
        );

    }


    /* =========================================
       Appointment Selection
    ========================================= */

    timeButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                /*
                 * إزالة الموعد المختار سابقًا
                 */

                document
                    .querySelectorAll(
                        ".med-day-times button"
                    )
                    .forEach(function (item) {

                        item.classList.remove(
                            "selected"
                        );

                    });


                /*
                 * تحديد الموعد الحالي
                 */

                button.classList.add(
                    "selected"
                );


                const day =
                    button.closest(
                        ".med-day-accordion"
                    );


                if (!day) {
                    return;
                }


                const dayNameElement =
                    day.querySelector(
                        ".med-day-name"
                    );


                const dayDateElement =
                    day.querySelector(
                        ".med-day-info strong"
                    );


                const dayName =
                    dayNameElement
                        ? dayNameElement.textContent.trim()
                        : "";


                const dayDate =
                    dayDateElement
                        ? dayDateElement.textContent.trim()
                        : "";


                /*
                 * التاريخ الحقيقي
                 * مثال:
                 * 2026-09-10
                 */

                const date =
                    day.dataset.date || "";


                /*
                 * وقت البداية والنهاية
                 * القادمين من Laravel
                 */

                const startTime =
                    button.dataset.start || "";


                const endTime =
                    button.dataset.end || "";


                /*
                 * الوقت الذي سيظهر للمستخدم
                 */

                const displayTime =
                    formatArabicTime(startTime);


                /*
                 * حفظ الموعد
                 */

                selectedAppointment = {

                    day:
                        dayName,

                    date:
                        date,

                    displayDate:
                        dayDate,

                    startTime:
                        startTime,

                    endTime:
                        endTime,

                    displayTime:
                        displayTime

                };


                /*
                 * عرض الموعد المختار
                 */

                if (selectedText) {

                    selectedText.textContent =
                        dayName +
                        " - " +
                        dayDate +
                        " | " +
                        displayTime;

                }


                /*
                 * تفعيل زر تأكيد الحجز
                 */

                if (confirmBooking) {

                    confirmBooking.disabled =
                        false;

                }


                /*
                 * Scroll للموبايل
                 */

                if (window.innerWidth <= 700) {

                    const selectedArea =
                        document.querySelector(
                            ".med-selected-appointment"
                        );


                    if (selectedArea) {

                        setTimeout(function () {

                            selectedArea.scrollIntoView({
                                behavior: "smooth",
                                block: "center"
                            });

                        }, 100);

                    }

                }

            }
        );

    });


    /* =========================================
       Confirm Booking
    ========================================= */

    if (confirmBooking) {

        confirmBooking.addEventListener(
            "click",
            function () {

                if (!selectedAppointment) {
                    return;
                }


                /*
                 * حاليًا نتأكد أن الموعد
                 * تم اختياره بشكل صحيح.
                 *
                 * الخطوة التالية:
                 * فتح فورم بيانات المريض
                 * ثم إرسال الحجز إلى Laravel.
                 */

                console.log(
                    "Selected Appointment:",
                    selectedAppointment
                );

            }
        );

    }


    /* =========================================
       Reviews
    ========================================= */

    const ratingButtons =
        document.querySelectorAll(
            ".med-star-rating button"
        );


    const ratingLabel =
        document.getElementById(
            "medRatingLabel"
        );


    const ratingInput =
        document.getElementById(
            "medRatingValue"
        );


    const ratingTexts = {

        1: "سيئ",
        2: "مقبول",
        3: "جيد",
        4: "ممتاز",
        5: "ممتاز جدًا"

    };


    let selectedRating = 0;


    ratingButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                selectedRating =
                    Number(
                        button.dataset.rating
                    );


                /* ================================
                   تخزين قيمة التقييم في الـ Form
                ================================= */

                if (ratingInput) {

                    ratingInput.value =
                        selectedRating;

                }


                /* ================================
                   تفعيل النجوم
                ================================= */

                ratingButtons.forEach(function (item) {

                    const itemRating =
                        Number(
                            item.dataset.rating
                        );


                    item.classList.toggle(
                        "active",
                        itemRating <= selectedRating
                    );

                });


                /* ================================
                   نص التقييم
                ================================= */

                if (ratingLabel) {

                    ratingLabel.textContent =
                        ratingTexts[selectedRating];

                }

            }
        );

    });


    /* =========================================
       Gallery Modal
    ========================================= */

    const galleryImages =
        document.querySelectorAll(
            ".med-gallery-image"
        );


    const imageModal =
        document.getElementById(
            "medImageModal"
        );


    const modalImage =
        document.getElementById(
            "medModalImage"
        );


    const closeModal =
        document.getElementById(
            "medCloseModal"
        );


    if (
        imageModal &&
        modalImage
    ) {

        galleryImages.forEach(function (image) {

            image.addEventListener(
                "click",
                function () {

                    const imageURL =
                        image.dataset.image;


                    if (!imageURL) {
                        return;
                    }


                    modalImage.src =
                        imageURL;


                    imageModal.classList.add(
                        "show"
                    );


                    document.body.style.overflow =
                        "hidden";

                }
            );

        });


        function closeImageModal() {

            imageModal.classList.remove(
                "show"
            );


            modalImage.src =
                "";


            document.body.style.overflow =
                "";

        }


        if (closeModal) {

            closeModal.addEventListener(
                "click",
                closeImageModal
            );

        }

    }

});


/* =========================================================
   DOCTOR REGISTRATION PAGE
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const doctorRegisterForm =
        document.getElementById(
            "doctorRegistrationForm"
        );


    if (!doctorRegisterForm) {
        return;
    }


    const doctorName =
        document.getElementById("doctor_name");

    const clinicName =
        document.getElementById("clinic_name");

    const specialty =
        document.getElementById("specialty");

    const area =
        document.getElementById("area");

    const price =
        document.getElementById("price");

    const bio =
        document.getElementById("bio");

    const password =
        document.getElementById("password");

    const passwordConfirmation =
        document.getElementById(
            "password_confirmation"
        );


    const previewName =
        document.getElementById("previewName");

    const previewClinic =
        document.getElementById("previewClinic");

    const previewSpecialty =
        document.getElementById("previewSpecialty");

    const previewArea =
        document.getElementById("previewArea");

    const previewPrice =
        document.getElementById("previewPrice");


    function updateDoctorPreview() {

        if (doctorName && previewName) {

            previewName.textContent =
                doctorName.value.trim() ||
                "اسم الدكتور";

        }


        if (clinicName && previewClinic) {

            previewClinic.textContent =
                clinicName.value.trim() ||
                "اسم العيادة";

        }


        if (specialty && previewSpecialty) {

            previewSpecialty.textContent =
                specialty.options[specialty.selectedIndex].text ||
                "التخصص الطبي";

        }


        if (area && previewArea) {

            previewArea.textContent =
                area.options[area.selectedIndex].text ||
                "لم يتم اختيارها";

        }


        if (price && previewPrice) {

            previewPrice.textContent =
                price.value
                    ? price.value + " جنيه"
                    : "لم يحدد بعد";

        }

    }


    if (doctorName) {

        doctorName.addEventListener(
            "input",
            updateDoctorPreview
        );

    }


    if (clinicName) {

        clinicName.addEventListener(
            "input",
            updateDoctorPreview
        );

    }


    if (specialty) {

        specialty.addEventListener(
            "change",
            updateDoctorPreview
        );

    }


    if (area) {

        area.addEventListener(
            "change",
            updateDoctorPreview
        );

    }


    if (price) {

        price.addEventListener(
            "input",
            updateDoctorPreview
        );

    }


    const charCount =
        document.getElementById(
            "doctorRegisterCharCount"
        );


    function updateBioCounter() {

        if (!bio || !charCount) {
            return;
        }


        charCount.textContent =
            bio.value.length + " / 500";

    }


    if (bio) {

        bio.addEventListener(
            "input",
            updateBioCounter
        );

    }


    window.doctorRegisterTogglePassword =
        function (inputId, button) {

            const input =
                document.getElementById(
                    inputId
                );


            if (!input || !button) {
                return;
            }


            const hidden =
                input.type === "password";


            input.type =
                hidden
                    ? "text"
                    : "password";


            button.style.color =
                hidden
                    ? "#147d78"
                    : "#91a1a1";


            button.setAttribute(
                "aria-label",
                hidden
                    ? "إخفاء كلمة المرور"
                    : "إظهار كلمة المرور"
            );

        };


    const strengthBars = [

        document.getElementById(
            "doctorRegisterBar1"
        ),

        document.getElementById(
            "doctorRegisterBar2"
        ),

        document.getElementById(
            "doctorRegisterBar3"
        ),

        document.getElementById(
            "doctorRegisterBar4"
        )

    ];


    const strengthText =
        document.getElementById(
            "doctorRegisterStrengthText"
        );


    function resetPasswordStrength() {

        strengthBars.forEach(function (bar) {

            if (bar) {

                bar.style.background =
                    "#e7eeee";

            }

        });


        if (strengthText) {

            strengthText.textContent =
                "قوة كلمة المرور";

        }

    }


    function updatePasswordStrength() {

        if (!password) {
            return;
        }


        const value =
            password.value;


        resetPasswordStrength();


        if (!value) {
            return;
        }


        let strength = 0;


        if (value.length >= 6) {
            strength++;
        }


        if (/[A-Z]/.test(value)) {
            strength++;
        }


        if (/[0-9]/.test(value)) {
            strength++;
        }


        if (/[^A-Za-z0-9]/.test(value)) {
            strength++;
        }


        const colors = {

            1: "#e58c8c",
            2: "#e4b36e",
            3: "#9dc87b",
            4: "#62b9a4"

        };


        const labels = {

            1: "ضعيفة",
            2: "متوسطة",
            3: "جيدة",
            4: "قوية جدًا"

        };


        for (
            let i = 0;
            i < strength;
            i++
        ) {

            if (strengthBars[i]) {

                strengthBars[i].style.background =
                    colors[strength];

            }

        }


        if (strengthText) {

            strengthText.textContent =
                labels[strength] ||
                "قوة كلمة المرور";

        }

    }


    if (password) {

        password.addEventListener(
            "input",
            updatePasswordStrength
        );

    }


    function checkPasswordMatch() {

        if (!passwordConfirmation) {
            return true;
        }


        if (!passwordConfirmation.value) {

            passwordConfirmation.style.borderColor =
                "";

            return true;

        }


        const matched =
            passwordConfirmation.value ===
            password.value;


        passwordConfirmation.style.borderColor =
            matched
                ? "#9dc8b8"
                : "#dc8a8a";


        return matched;

    }


    if (passwordConfirmation) {

        passwordConfirmation.addEventListener(
            "input",
            checkPasswordMatch
        );

    }


    if (password) {

        password.addEventListener(
            "input",
            function () {

                if (
                    passwordConfirmation &&
                    passwordConfirmation.value
                ) {

                    checkPasswordMatch();

                }

            }
        );

    }


    updateDoctorPreview();

    updateBioCounter();

    updatePasswordStrength();

});


/* =========================================================
   PASSWORD TOGGLE
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    function setupPasswordToggle(inputId, buttonId) {

        const input =
            document.getElementById(inputId);

        const button =
            document.getElementById(buttonId);


        if (!input || !button) {
            return;
        }


        button.addEventListener(
            "click",
            function () {

                if (input.type === "password") {

                    input.type = "text";

                    button.setAttribute(
                        "aria-label",
                        "إخفاء كلمة المرور"
                    );

                } else {

                    input.type = "password";

                    button.setAttribute(
                        "aria-label",
                        "إظهار كلمة المرور"
                    );

                }

            }
        );

    }


    /* تسجيل الحساب العادي */

    setupPasswordToggle(
        "registerPassword",
        "doctorRegisterTogglePassword"
    );


    setupPasswordToggle(
        "registerPasswordConfirmation",
        "doctorRegisterTogglePasswordConfirmation"
    );


    /* تسجيل الطبيب */

    setupPasswordToggle(
        "password",
        "doctorRegisterTogglePassword"
    );


    setupPasswordToggle(
        "password_confirmation",
        "doctorRegisterTogglePasswordConfirmation"
    );

});


/* =========================================================
   LOGIN PAGE
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const loginForm =
        document.getElementById(
            "doctorLoginForm"
        );


    if (!loginForm) {
        return;
    }


    const passwordInput =
        document.getElementById(
            "doctorLoginPassword"
        );


    const passwordToggle =
        document.getElementById(
            "doctorLoginTogglePassword"
        );


    if (
        passwordInput &&
        passwordToggle
    ) {

        passwordToggle.addEventListener(
            "click",
            function () {

                const hidden =
                    passwordInput.type === "password";


                passwordInput.type =
                    hidden
                        ? "text"
                        : "password";


                passwordToggle.setAttribute(
                    "aria-label",
                    hidden
                        ? "إخفاء كلمة المرور"
                        : "إظهار كلمة المرور"
                );

            }
        );

    }

});


/* =========================================================
   FORGOT PASSWORD
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const forgotForm =
        document.getElementById(
            "doctorForgotForm"
        );


    if (!forgotForm) {
        return;
    }

});


/* =========================================================
   CONFIRM PASSWORD
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const input =
        document.getElementById(
            "doctorConfirmPassword"
        );


    const button =
        document.getElementById(
            "doctorConfirmTogglePassword"
        );


    if (!input || !button) {
        return;
    }


    button.addEventListener(
        "click",
        function () {

            const hidden =
                input.type === "password";


            input.type =
                hidden
                    ? "text"
                    : "password";


            button.setAttribute(
                "aria-label",
                hidden
                    ? "إخفاء كلمة المرور"
                    : "إظهار كلمة المرور"
            );

        }
    );

});


/* =========================================================
   END APP.JS
========================================================= */


/* =========================================================
   FLASH MESSAGE
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const flashMessages =
        document.querySelectorAll(
            ".flash-message"
        );


    if (!flashMessages.length) {
        return;
    }


    flashMessages.forEach(function (message) {

        const closeButton =
            message.querySelector(
                ".flash-close"
            );


        function closeMessage() {

            message.style.opacity =
                "0";


            message.style.transform =
                "translateX(-50%) translateY(-15px) scale(.96)";


            setTimeout(function () {

                message.remove();

            }, 300);

        }


        /* إغلاق عند الضغط على X */

        if (closeButton) {

            closeButton.addEventListener(
                "click",
                closeMessage
            );

        }


        /* إغلاق تلقائي بعد 4 ثواني */

        setTimeout(function () {

            if (document.body.contains(message)) {

                closeMessage();

            }

        }, 4000);

    });

});
