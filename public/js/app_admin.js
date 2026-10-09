document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       DARK MODE
    ========================================================= */

    const themeButton = document.getElementById('themeButton');
    const themeIcon = document.getElementById('themeIcon');

    function setThemeIcon(isDark) {
        if (!themeIcon) return;
        themeIcon.classList.toggle('fa-sun', isDark);
        themeIcon.classList.toggle('fa-moon', !isDark);
    }

    if (themeButton) {
        const isDark = localStorage.getItem('theme') === 'dark';
        document.body.classList.toggle('dark-mode', isDark);
        setThemeIcon(isDark);

        themeButton.addEventListener('click', function () {
            const dark = document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', dark ? 'dark' : 'light');
            setThemeIcon(dark);
        });
    }


    /* =========================================================
       DETAILS MODAL
       (الأزرار بتتربط بـ event delegation عشان تشتغل بعد اللايف سيرش)
    ========================================================= */

    const detailsModal = document.getElementById('detailsModal');
    const closeModal = document.getElementById('closeModal');
    const modalDoctorName = document.getElementById('modalDoctorName');
    const modalPhone = document.getElementById('modalPhone');
    const modalSpecialty = document.getElementById('modalSpecialty');
    const modalArea = document.getElementById('modalArea');
    const modalStatus = document.getElementById('modalStatus');

    function openDetailsModal(row) {
        if (!row || !detailsModal) return;

        if (modalDoctorName) modalDoctorName.textContent = 'د. ' + (row.dataset.name || '-');
        if (modalPhone) modalPhone.textContent = row.dataset.phone || '-';
        if (modalSpecialty) modalSpecialty.textContent = row.dataset.specialty || '-';
        if (modalArea) modalArea.textContent = row.dataset.area || '-';
        if (modalStatus) modalStatus.textContent = row.dataset.status || '-';

        detailsModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDetailsModal() {
        if (!detailsModal) return;
        detailsModal.classList.remove('show');
        document.body.style.overflow = '';
    }

    // زر العين
    document.addEventListener('click', function (event) {
        const button = event.target.closest('.doctor-pending-action.view');
        if (!button) return;

        event.preventDefault();
        event.stopPropagation();

        openDetailsModal(button.closest('tr[data-name]'));
    });

    if (closeModal) {
        closeModal.addEventListener('click', closeDetailsModal);
    }

    if (detailsModal) {
        detailsModal.addEventListener('click', function (event) {
            if (event.target === detailsModal) closeDetailsModal();
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && detailsModal && detailsModal.classList.contains('show')) {
            closeDetailsModal();
        }
    });


    /* =========================================================
       DOCTOR PROFILE IMAGE
    ========================================================= */

    const doctorInput = document.getElementById('doctorImageInput');
    const doctorPreview = document.getElementById('doctorImagePreview');
    const doctorDefault = document.getElementById('doctorImageDefault');

    if (doctorInput) {
        doctorInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('من فضلك اختر صورة صحيحة.');
                this.value = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('حجم صورة الطبيب يجب ألا يتجاوز 5MB.');
                this.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                if (doctorPreview) {
                    doctorPreview.src = event.target.result;
                    doctorPreview.style.display = 'block';
                }
                if (doctorDefault) {
                    doctorDefault.style.display = 'none';
                }
            };

            reader.readAsDataURL(file);
        });
    }


    /* =========================================================
       CLINIC IMAGES
    ========================================================= */

    const clinicInput = document.getElementById('clinicImagesInput');
    const clinicPreview = document.getElementById('clinicImagesPreview');
    const clinicCount = document.getElementById('clinicImagesCount');

    if (clinicInput && clinicPreview && clinicCount) {

        let selectedFiles = [];

        function renderClinicImages() {
            clinicPreview.innerHTML = '';

            if (selectedFiles.length === 0) {
                clinicCount.innerHTML = `
                    <span class="count-icon"><i class="fa-solid fa-images"></i></span>
                    <span class="count-text">لم يتم اختيار صور</span>
                `;
                return;
            }

            clinicCount.innerHTML = `
                <span class="count-icon"><i class="fa-solid fa-images"></i></span>
                <span class="count-text">تم اختيار ${selectedFiles.length} صورة</span>
            `;

            selectedFiles.forEach(function (file, index) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    const item = document.createElement('div');
                    item.className = 'clinic-image-preview-item';

                    item.innerHTML = `
                        <img src="${event.target.result}" alt="صورة العيادة ${index + 1}">
                        <div class="clinic-image-overlay">
                            <div class="clinic-image-number">${index + 1}</div>
                            <button type="button" class="remove-clinic-image"
                                data-index="${index}" title="حذف الصورة">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    `;

                    clinicPreview.appendChild(item);
                };

                reader.readAsDataURL(file);
            });
        }

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(function (file) {
                dataTransfer.items.add(file);
            });
            clinicInput.files = dataTransfer.files;
        }

        clinicInput.addEventListener('change', function () {
            const newFiles = Array.from(this.files);
            if (newFiles.length === 0) return;

            const validFiles = [];

            for (const file of newFiles) {
                if (!file.type.startsWith('image/')) {
                    alert(`الملف "${file.name}" ليس صورة صحيحة.`);
                    continue;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert(`الصورة "${file.name}" أكبر من 5MB.`);
                    continue;
                }

                validFiles.push(file);
            }

            // الحد الأقصى (max:3) بيتحقق منه Laravel
            selectedFiles = selectedFiles.concat(validFiles);

            updateFileInput();
            renderClinicImages();
        });

        clinicPreview.addEventListener('click', function (event) {
            const removeButton = event.target.closest('.remove-clinic-image');
            if (!removeButton) return;

            const index = Number(removeButton.dataset.index);

            if (Number.isNaN(index) || index < 0 || index >= selectedFiles.length) return;

            selectedFiles.splice(index, 1);

            updateFileInput();
            renderClinicImages();
        });

        renderClinicImages();
    }

});


/* =========================================================
   FLASH MESSAGE
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const flashMessages = document.querySelectorAll('.flash-message');
    if (!flashMessages.length) return;

    flashMessages.forEach(function (message) {

        const closeButton = message.querySelector('.flash-close');

        function closeMessage() {
            message.style.opacity = '0';
            message.style.transform = 'translateX(-50%) translateY(-15px) scale(.96)';

            setTimeout(function () {
                message.remove();
            }, 300);
        }

        if (closeButton) {
            closeButton.addEventListener('click', closeMessage);
        }

        setTimeout(function () {
            if (document.body.contains(message)) closeMessage();
        }, 4000);
    });
});


/* =========================================================
   إرفاق صورة الطبيب مع فورم التعديل / الاشتراك
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const doctorImageInput = document.getElementById('doctorImageInput');

    const forms = [
        document.getElementById('editDoctorForm'),
        document.getElementById('subscribeDoctorForm'),
    ];

    if (!doctorImageInput) return;

    forms.forEach(function (form) {
        if (!form) return;

        form.addEventListener('submit', function () {
            if (!doctorImageInput.files.length) return;

            const imageInput = document.createElement('input');
            imageInput.type = 'file';
            imageInput.name = 'doctor_image';

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(doctorImageInput.files[0]);

            imageInput.files = dataTransfer.files;
            imageInput.style.display = 'none';

            form.appendChild(imageInput);
        });
    });
});


/* =========================================================
   RATING STARS (تعديل التقييم)
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const ratingButtons = document.querySelectorAll('.edit-star-button');
    const ratingInput = document.getElementById('editRatingInput');
    const ratingValue = document.getElementById('editRatingValue');
    const ratingText = document.getElementById('editRatingText');

    if (!ratingButtons.length || !ratingInput) return;

    const ratingTexts = {
        1: 'سيئ',
        2: 'مقبول',
        3: 'جيد',
        4: 'ممتاز',
        5: 'ممتاز جدًا',
    };

    ratingButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const selectedRating = Number(button.dataset.rating);

            ratingInput.value = selectedRating;

            if (ratingValue) ratingValue.textContent = selectedRating + '/5';
            if (ratingText) ratingText.textContent = ratingTexts[selectedRating];

            ratingButtons.forEach(function (item) {
                item.classList.toggle('active', Number(item.dataset.rating) <= selectedRating);
            });
        });
    });
});


/* =========================================================
   SPECIALTIES CHART (الداشبورد)
========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('specialtiesChart');
    if (!canvas || typeof Chart === 'undefined') return;

    const specialties = window.specialtiesData || [];

    const labels = specialties.map(function (item) {
        return item.specialty?.name ?? 'تخصص غير محدد';
    });

    const data = specialties.map(function (item) {
        return Number(item.total);
    });

    const otherDoctors = Number(window.otherDoctors || 0);

    if (otherDoctors > 0) {
        labels.push('تخصصات أخرى');
        data.push(otherDoctors);
    }

    const colors = [
        '#3b82f6', // أزرق
        '#22c55e', // أخضر
        '#f97316', // برتقالي
        '#a855f7', // بنفسجي
        '#94a3b8', // فضي
    ];

    new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors.slice(0, data.length),
                borderWidth: 0,
                hoverOffset: 5,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function (context) {
                            return `${context.label}: ${context.raw} طبيب`;
                        },
                    },
                },
            },
        },
    });
});
