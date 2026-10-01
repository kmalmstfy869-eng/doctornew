document.addEventListener('DOMContentLoaded', function () {


    /* =========================================================
       DARK MODE
    ========================================================= */

    const themeButton =
        document.getElementById('themeButton');

    const themeIcon =
        document.getElementById('themeIcon');


    if (themeButton) {

        if (localStorage.getItem('theme') === 'dark') {

            document.body.classList.add('dark-mode');

            if (themeIcon) {

                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');

            }

        } else {

            document.body.classList.remove('dark-mode');

            if (themeIcon) {

                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');

            }

        }


        themeButton.addEventListener('click', function () {

            document.body.classList.toggle('dark-mode');


            if (document.body.classList.contains('dark-mode')) {

                localStorage.setItem('theme', 'dark');


                if (themeIcon) {

                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');

                }

            } else {

                localStorage.setItem('theme', 'light');


                if (themeIcon) {

                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');

                }

            }

        });

    }



    /* =========================================================
       عناصر صفحة الأطباء
    ========================================================= */

    const searchInput =
        document.getElementById('searchInput');

    const specialtyFilter =
        document.getElementById('specialtyFilter');

    const resetBtn =
        document.getElementById('resetBtn');

    const requestsBody =
        document.getElementById('requestsBody');



    /* =========================================================
       الحصول على صفوف الأطباء
    ========================================================= */

    function getDoctorRows() {

        if (!requestsBody) {

            return [];

        }

        return requestsBody.querySelectorAll(
            'tr[data-name]'
        );

    }



    /* =========================================================
       البحث والفلترة
    ========================================================= */

    function filterDoctors() {

        const searchValue =
            searchInput?.value
                .trim()
                .toLowerCase() || '';


        const specialtyValue =
            specialtyFilter?.value || '';


        getDoctorRows().forEach(function (row) {

            const doctorName =
                (row.dataset.name || '')
                    .toLowerCase();


            const doctorPhone =
                (row.dataset.phone || '')
                    .toLowerCase();


            const doctorSpecialty =
                row.dataset.specialty || '';


            const searchMatch =
                doctorName.includes(searchValue) ||
                doctorPhone.includes(searchValue);


            const specialtyMatch =
                specialtyValue === '' ||
                doctorSpecialty === specialtyValue;


            row.style.display =
                searchMatch && specialtyMatch
                    ? 'table-row'
                    : 'none';

        });

    }



    /* =========================================================
       أحداث البحث
    ========================================================= */

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterDoctors
        );

    }



    /* =========================================================
       فلترة التخصص
    ========================================================= */

    if (specialtyFilter) {

        specialtyFilter.addEventListener(
            'change',
            filterDoctors
        );

    }



    /* =========================================================
       إعادة تعيين الفلاتر
    ========================================================= */

    if (resetBtn) {

        resetBtn.addEventListener(
            'click',
            function () {

                if (searchInput) {

                    searchInput.value = '';

                }


                if (specialtyFilter) {

                    specialtyFilter.value = '';

                }


                filterDoctors();

            }
        );

    }



    /* =========================================================
       MODAL
    ========================================================= */

    const detailsModal =
        document.getElementById('detailsModal');


    const closeModal =
        document.getElementById('closeModal');


    const modalDoctorName =
        document.getElementById('modalDoctorName');


    const modalPhone =
        document.getElementById('modalPhone');


    const modalSpecialty =
        document.getElementById('modalSpecialty');


    const modalArea =
        document.getElementById('modalArea');


    const modalStatus =
        document.getElementById('modalStatus');



    /* =========================================================
       فتح التفاصيل
    ========================================================= */

    function openDetailsModal(row) {

        if (!row || !detailsModal) {

            return;

        }


        const doctorName =
            row.dataset.name || '-';


        const doctorPhone =
            row.dataset.phone || '-';


        const doctorSpecialty =
            row.dataset.specialty || '-';


        const doctorArea =
            row.dataset.area || '-';


        const doctorStatus =
            row.dataset.status || '-';



        /* اسم الطبيب */

        if (modalDoctorName) {

            modalDoctorName.textContent =
                'د. ' + doctorName;

        }



        /* الهاتف */

        if (modalPhone) {

            modalPhone.textContent =
                doctorPhone;

        }



        /* التخصص */

        if (modalSpecialty) {

            modalSpecialty.textContent =
                doctorSpecialty;

        }



        /* المنطقة */

        if (modalArea) {

            modalArea.textContent =
                doctorArea;

        }



        /* الحالة */

        if (modalStatus) {

            modalStatus.textContent =
                doctorStatus;

        }



        /* فتح Modal */

        detailsModal.classList.add('show');

        document.body.style.overflow = 'hidden';

    }



    /* =========================================================
       زر العين
    ========================================================= */

    document.querySelectorAll('.view')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();

                    event.stopPropagation();


                    const row =
                        button.closest('tr[data-name]');


                    openDetailsModal(row);

                }
            );

        });



    /* =========================================================
       إغلاق Modal
    ========================================================= */

    function closeDetailsModal() {

        if (!detailsModal) {

            return;

        }


        detailsModal.classList.remove('show');

        document.body.style.overflow = '';

    }



    /* =========================================================
       زر X
    ========================================================= */

    if (closeModal) {

        closeModal.addEventListener(
            'click',
            closeDetailsModal
        );

    }



    /* =========================================================
       الضغط خارج Modal
    ========================================================= */

    if (detailsModal) {

        detailsModal.addEventListener(
            'click',
            function (event) {

                if (event.target === detailsModal) {

                    closeDetailsModal();

                }

            }
        );

    }



    /* =========================================================
       إغلاق بالـ ESC
    ========================================================= */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                detailsModal &&
                detailsModal.classList.contains('show')
            ) {

                closeDetailsModal();

            }

        }
    );



    /* =========================================================
       DOCTOR PROFILE IMAGE
    ========================================================= */

    const doctorInput =
        document.getElementById('doctorImageInput');


    const doctorPreview =
        document.getElementById('doctorImagePreview');


    const doctorDefault =
        document.getElementById('doctorImageDefault');


    if (doctorInput) {

        doctorInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files[0];


                if (!file) {

                    return;

                }



                /* التحقق من نوع الصورة */

                if (!file.type.startsWith('image/')) {

                    alert(
                        'من فضلك اختر صورة صحيحة.'
                    );

                    this.value = '';

                    return;

                }



                /* التحقق من الحجم */

                if (file.size > 5 * 1024 * 1024) {

                    alert(
                        'حجم صورة الطبيب يجب ألا يتجاوز 5MB.'
                    );

                    this.value = '';

                    return;

                }



                /* عرض الصورة */

                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        if (doctorPreview) {

                            doctorPreview.src =
                                event.target.result;

                            doctorPreview.style.display =
                                'block';

                        }


                        if (doctorDefault) {

                            doctorDefault.style.display =
                                'none';

                        }

                    };


                reader.readAsDataURL(file);

            }
        );

    }



    /* =========================================================
       CLINIC IMAGES
    ========================================================= */

    const clinicInput =
        document.getElementById('clinicImagesInput');


    const clinicPreview =
        document.getElementById('clinicImagesPreview');


    const clinicCount =
        document.getElementById('clinicImagesCount');


    if (clinicInput && clinicPreview && clinicCount) {


        let selectedFiles = [];



        /* =====================================================
           RENDER CLINIC IMAGES
        ====================================================== */

        function renderClinicImages() {

            clinicPreview.innerHTML = '';


            if (selectedFiles.length === 0) {

                clinicCount.innerHTML = `

                    <span class="count-icon">

                        <i class="fa-solid fa-images"></i>

                    </span>

                    <span class="count-text">

                        لم يتم اختيار صور

                    </span>

                `;

                return;

            }



            clinicCount.innerHTML = `

                <span class="count-icon">

                    <i class="fa-solid fa-images"></i>

                </span>

                <span class="count-text">

                    تم اختيار
                    ${selectedFiles.length}
                    صورة

                </span>

            `;



            selectedFiles.forEach(
                function (file, index) {

                    const reader =
                        new FileReader();


                    reader.onload =
                        function (event) {

                            const item =
                                document.createElement('div');


                            item.className =
                                'clinic-image-preview-item';


                            item.innerHTML = `

                                <img
                                    src="${event.target.result}"
                                    alt="صورة العيادة ${index + 1}">




                                <div class="clinic-image-overlay">


                                    <div class="clinic-image-number">

                                        ${index + 1}

                                    </div>


                                    <button
                                        type="button"
                                        class="remove-clinic-image"
                                        data-index="${index}"
                                        title="حذف الصورة">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>


                                </div>

                            `;


                            clinicPreview.appendChild(item);

                        };


                    reader.readAsDataURL(file);

                }
            );

        }



        /* =====================================================
           ESCAPE FILE NAME
        ====================================================== */

        function escapeHtml(value) {

            const div =
                document.createElement('div');


            div.textContent =
                value;


            return div.innerHTML;

        }



        /* =====================================================
           UPDATE REAL FILE INPUT
        ====================================================== */

        function updateFileInput() {

            const dataTransfer =
                new DataTransfer();


            selectedFiles.forEach(
                function (file) {

                    dataTransfer.items.add(file);

                }
            );


            clinicInput.files =
                dataTransfer.files;

        }



        /* =====================================================
           ADD NEW FILES
        ====================================================== */

        clinicInput.addEventListener(
            'change',
            function () {

                const newFiles =
                    Array.from(this.files);


                if (newFiles.length === 0) {

                    return;

                }



                /* ---------------------------------------------
                   Validate images
                --------------------------------------------- */

                const validFiles = [];


                for (const file of newFiles) {


                    if (!file.type.startsWith('image/')) {

                        alert(
                            `الملف "${file.name}" ليس صورة صحيحة.`
                        );

                        continue;

                    }


                    if (file.size > 5 * 1024 * 1024) {

                        alert(
                            `الصورة "${file.name}" أكبر من 5MB.`
                        );

                        continue;

                    }


                    validFiles.push(file);

                }



                /* ---------------------------------------------
                   إضافة الصور

                   لا يوجد هنا حد 3.
                   Laravel Validation هو المسؤول عن max:3.
                --------------------------------------------- */

                selectedFiles =
                    selectedFiles.concat(validFiles);



                /* ---------------------------------------------
                   تحديث input
                --------------------------------------------- */

                updateFileInput();



                /* ---------------------------------------------
                   عرض الصور
                --------------------------------------------- */

                renderClinicImages();

            }
        );



        /* =====================================================
           REMOVE SELECTED CLINIC IMAGE
        ====================================================== */

        clinicPreview.addEventListener(
            'click',
            function (event) {


                const removeButton =
                    event.target.closest(
                        '.remove-clinic-image'
                    );


                if (!removeButton) {

                    return;

                }


                const index =
                    Number(
                        removeButton.dataset.index
                    );


                if (
                    Number.isNaN(index) ||
                    index < 0 ||
                    index >= selectedFiles.length
                ) {

                    return;

                }


                selectedFiles.splice(index, 1);


                updateFileInput();


                renderClinicImages();

            }
        );



        /* =====================================================
           INITIAL RENDER
        ====================================================== */

        renderClinicImages();

    }

});



/* =========================================================
   FLASH MESSAGE
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const flashMessages =
            document.querySelectorAll(
                '.flash-message'
            );


        if (!flashMessages.length) {

            return;

        }


        flashMessages.forEach(
            function (message) {

                const closeButton =
                    message.querySelector(
                        '.flash-close'
                    );


                function closeMessage() {

                    message.style.opacity =
                        '0';


                    message.style.transform =
                        'translateX(-50%) translateY(-15px) scale(.96)';


                    setTimeout(
                        function () {

                            message.remove();

                        },
                        300
                    );

                }



                /* إغلاق X */

                if (closeButton) {

                    closeButton.addEventListener(
                        'click',
                        closeMessage
                    );

                }



                /* إغلاق تلقائي */

                setTimeout(
                    function () {

                        if (
                            document.body.contains(
                                message
                            )
                        ) {

                            closeMessage();

                        }

                    },
                    4000
                );

            }
        );

    }
);
document.addEventListener('DOMContentLoaded', function () {

    const doctorImageInput = document.getElementById('doctorImageInput');

    const forms = [
        document.getElementById('editDoctorForm'),
        document.getElementById('subscribeDoctorForm')
    ];

    if (!doctorImageInput) {
        return;
    }

    forms.forEach(function (form) {

        if (!form) {
            return;
        }

        form.addEventListener('submit', function () {

            if (!doctorImageInput.files.length) {
                return;
            }

            const imageInput = document.createElement('input');

            imageInput.type = 'file';
            imageInput.name = 'doctor_image';

            const dataTransfer = new DataTransfer();

            dataTransfer.items.add(
                doctorImageInput.files[0]
            );

            imageInput.files = dataTransfer.files;

            imageInput.style.display = 'none';

            form.appendChild(imageInput);

        });

    });

});
     document.addEventListener('DOMContentLoaded', function () {

            const ratingButtons =
                document.querySelectorAll('.edit-star-button');

            const ratingInput =
                document.getElementById('editRatingInput');

            const ratingValue =
                document.getElementById('editRatingValue');

            const ratingText =
                document.getElementById('editRatingText');


            const ratingTexts = {

                1: 'سيئ',
                2: 'مقبول',
                3: 'جيد',
                4: 'ممتاز',
                5: 'ممتاز جدًا'

            };


            ratingButtons.forEach(function (button) {

                button.addEventListener('click', function () {

                    const selectedRating =
                        Number(button.dataset.rating);


                    ratingInput.value =
                        selectedRating;


                    ratingValue.textContent =
                        selectedRating + '/5';


                    ratingText.textContent =
                        ratingTexts[selectedRating];


                    ratingButtons.forEach(function (item) {

                        const itemRating =
                            Number(item.dataset.rating);


                        item.classList.toggle(
                            'active',
                            itemRating <= selectedRating
                        );

                    });

                });

            });

        });













// Art





document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('specialtiesChart');

    if (!canvas) {
        return;
    }


    // التخصصات الأربعة القادمة من Controller
    const specialties = window.specialtiesData || [];


    // أسماء التخصصات
    const labels = specialties.map(item => {
        return item.specialty?.name ?? 'تخصص غير محدد';
    });


    // عدد الأطباء في كل تخصص
    const data = specialties.map(item => {
        return Number(item.total);
    });


    // باقي الأطباء
    const otherDoctors = Number(window.otherDoctors || 0);


    // إضافة "تخصصات أخرى"
    if (otherDoctors > 0) {

        labels.push('تخصصات أخرى');

        data.push(otherDoctors);

    }


    // ألوان التخصصات
    const colors = [
        '#3b82f6', // أزرق
        '#22c55e', // أخضر
        '#f97316', // برتقالي
        '#a855f7', // بنفسجي
        '#94a3b8'  // فضي
    ];


    new Chart(canvas, {

        type: 'doughnut',

        data: {

            labels: labels,

            datasets: [{
                data: data,

                backgroundColor: colors.slice(0, data.length),

                borderWidth: 0,

                hoverOffset: 5
            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '72%',

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {
                    enabled: true,

                    callbacks: {

                        label: function (context) {

                            return `${context.label}: ${context.raw} طبيب`;

                        }

                    }

                }

            }

        }

    });

});





