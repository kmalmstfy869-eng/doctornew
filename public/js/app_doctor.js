        /* =========================
           DARK MODE
        ========================== */

        function toggleDark() {

            document.body.classList.toggle("dark");

            const dark =
                document.body.classList.contains("dark");


            localStorage.setItem(
                "doctor-dashboard-theme",
                dark ? "dark" : "light"
            );


            const themeButton =
                document.getElementById("themeButton");


            if (themeButton) {

                themeButton.innerText =
                    dark ? "☀" : "☾";

            }

        }


        const savedTheme =
            localStorage.getItem(
                "doctor-dashboard-theme"
            );


        if (savedTheme === "dark") {

            document.body.classList.add("dark");


            const themeButton =
                document.getElementById("themeButton");


            if (themeButton) {

                themeButton.innerText = "☀";

            }

        }
   /* =========================
       SIDEBAR
    ========================== */

    function openSidebar() {
        document
            .getElementById("sidebar")
            ?.classList.add("open");

        document
            .getElementById("overlay")
            ?.classList.add("show");
    }

    function closeSidebar() {
        document
            .getElementById("sidebar")
            ?.classList.remove("open");

        document
            .getElementById("overlay")
            ?.classList.remove("show");
    }


    /* =========================
       TOAST
    ========================== */

    let toastTimer;

    function showToast(message) {
        const toast = document.getElementById("toast");

        if (!toast) {
            return;
        }

        toast.innerText = message;

        toast.classList.add("show");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(() => {
            toast.classList.remove("show");
        }, 2200);
    }


    /* =========================
       ESC CLOSE
    ========================== */

    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") {
            closeSidebar();
        }
    });


/* =========================================================
   FLASH MESSAGE
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const flashMessages =
        document.querySelectorAll(".flash-message");


    if (!flashMessages.length) {
        return;
    }


    flashMessages.forEach(function (message) {

        const closeButton =
            message.querySelector(".flash-close");


        function closeMessage() {

            message.style.opacity = "0";

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




document.addEventListener('DOMContentLoaded', function () {


    const servicesList = document.getElementById('servicesList');
    const serviceInput = document.getElementById('serviceInput');
    const addServiceBtn = document.getElementById('addServiceBtn');
    const servicesInput = document.getElementById('services');

    let services = [];

    if (servicesInput) {
        try {
            services = JSON.parse(servicesInput.value || '[]');
            if (!Array.isArray(services)) services = [];
        } catch {
            services = [];
        }
    }

    function updateServicesInput() {
        if (servicesInput) {
            servicesInput.value = JSON.stringify(services);
        }
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value;
        return div.innerHTML;
    }

    function renderServices() {
        if (!servicesList) return;

        servicesList.innerHTML = '';

        if (!services.length) {
            servicesList.innerHTML = `
                <div class="doctor-services-empty">
                    <i class="fa-solid fa-list"></i>
                    <span>لم تتم إضافة أي خدمات حتى الآن</span>
                </div>
            `;

            updateServicesInput();
            return;
        }

        services.forEach((service, index) => {
            const item = document.createElement('div');

            item.className = 'doctor-service-item';

            item.innerHTML = `
                <span class="service-name">
                    ${escapeHtml(service)}
                </span>

                <button
                    type="button"
                    class="service-remove-btn"
                    data-index="${index}"
                    aria-label="حذف الخدمة"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            servicesList.appendChild(item);
        });

        updateServicesInput();
    }

    function addService() {
        if (!serviceInput) return;

        const service = serviceInput.value.trim();

        if (!service) {
            serviceInput.focus();
            return;
        }

        const exists = services.some(
            item => item.toLowerCase() === service.toLowerCase()
        );

        if (exists) {
            serviceInput.value = '';
            serviceInput.focus();
            return;
        }

        services.push(service);
        serviceInput.value = '';

        renderServices();
        serviceInput.focus();
    }

    servicesList?.addEventListener('click', function (event) {
        const button = event.target.closest('.service-remove-btn');

        if (!button) return;

        const index = Number(button.dataset.index);

        if (Number.isNaN(index)) return;

        services.splice(index, 1);
        renderServices();
    });

    addServiceBtn?.addEventListener('click', addService);

    serviceInput?.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            addService();
        }
    });

    renderServices();


    /* =========================================================
       DOCTOR IMAGE
    ========================================================= */

    const doctorImageInput =
        document.getElementById('doctorImageInput');

    const doctorImageWrapper =
        document.getElementById('doctorProfileImageWrapper');

    const removeDoctorImageBtn =
        document.getElementById('removeDoctorImageBtn');

    const deletedDoctorImageInput =
        document.getElementById('deletedDoctorImage');


    if (
        doctorImageInput &&
        doctorImageWrapper &&
        removeDoctorImageBtn
    ) {

        const originalDoctorImagePath =
            doctorImageWrapper.dataset.originalImage || '';

        const originalDoctorImageSrc =
            doctorImageWrapper
                .querySelector('#doctorProfileImage')
                ?.getAttribute('src') || '';

        let hasNewDoctorImage = false;
        let doctorImageDeleted = false;


        function removeDoctorImageElement() {
            doctorImageWrapper
                .querySelector('#doctorProfileImage')
                ?.remove();
        }


        function removeDoctorDefaultElement() {
            doctorImageWrapper
                .querySelector('#doctorDefaultImage')
                ?.remove();
        }


        function insertBeforeRemoveButton(element) {
            const removeButton =
                doctorImageWrapper.querySelector(
                    '#removeDoctorImageBtn'
                );

            if (removeButton) {
                doctorImageWrapper.insertBefore(
                    element,
                    removeButton
                );
            } else {
                doctorImageWrapper.appendChild(element);
            }
        }


        function showDoctorDefaultImage() {
            removeDoctorImageElement();
            removeDoctorDefaultElement();

            const defaultImage =
                document.createElement('div');

            defaultImage.id = 'doctorDefaultImage';
            defaultImage.className = 'doctor-default-image';

            defaultImage.innerHTML =
                '<i class="fa-solid fa-user-doctor"></i>';

            insertBeforeRemoveButton(defaultImage);
        }


        function showOriginalDoctorImage() {
            removeDoctorImageElement();
            removeDoctorDefaultElement();

            if (!originalDoctorImageSrc) {
                showDoctorDefaultImage();
                return;
            }

            const image =
                document.createElement('img');

            image.id = 'doctorProfileImage';
            image.className = 'doctor-profile-image';
            image.alt = 'صورة الطبيب';
            image.src = originalDoctorImageSrc;

            insertBeforeRemoveButton(image);
        }


        function showNewDoctorImage(src) {
            removeDoctorImageElement();
            removeDoctorDefaultElement();

            const image =
                document.createElement('img');

            image.id = 'doctorProfileImage';
            image.className = 'doctor-profile-image';
            image.alt = 'صورة الطبيب';
            image.src = src;

            insertBeforeRemoveButton(image);
        }


        /* =====================================================
           SELECT NEW IMAGE
        ===================================================== */

        doctorImageInput.addEventListener('change', function () {

            const file = this.files?.[0];

            if (!file) return;

            hasNewDoctorImage = true;

            if (
                originalDoctorImagePath &&
                deletedDoctorImageInput
            ) {
                deletedDoctorImageInput.value =
                    originalDoctorImagePath;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                showNewDoctorImage(event.target.result);

                removeDoctorImageBtn.style.display = 'flex';
            };

            reader.readAsDataURL(file);
        });


        /* =====================================================
           REMOVE / CANCEL DOCTOR IMAGE
        ===================================================== */

        removeDoctorImageBtn.addEventListener('click', function () {

            /* -------------------------------------------------
               NEW IMAGE EXISTS
            ------------------------------------------------- */

            if (hasNewDoctorImage) {

                doctorImageInput.value = '';
                hasNewDoctorImage = false;

                /* OLD IMAGE SHOULD RETURN */
                if (
                    originalDoctorImagePath &&
                    !doctorImageDeleted
                ) {

                    if (deletedDoctorImageInput) {
                        deletedDoctorImageInput.value = '';
                    }

                    showOriginalDoctorImage();

                    removeDoctorImageBtn.style.display = 'flex';

                    return;
                }


                /* OLD IMAGE WAS DELETED */
                if (
                    originalDoctorImagePath &&
                    doctorImageDeleted
                ) {

                    if (deletedDoctorImageInput) {
                        deletedDoctorImageInput.value =
                            originalDoctorImagePath;
                    }

                    showDoctorDefaultImage();

                    removeDoctorImageBtn.style.display = 'none';

                    return;
                }


                /* NO OLD IMAGE */
                if (deletedDoctorImageInput) {
                    deletedDoctorImageInput.value = '';
                }

                showDoctorDefaultImage();

                removeDoctorImageBtn.style.display = 'none';

                return;
            }


            /* -------------------------------------------------
               OLD IMAGE ONLY
            ------------------------------------------------- */

            if (originalDoctorImagePath) {

                if (deletedDoctorImageInput) {
                    deletedDoctorImageInput.value =
                        originalDoctorImagePath;
                }

                doctorImageDeleted = true;

                showDoctorDefaultImage();

                removeDoctorImageBtn.style.display = 'none';

                return;
            }


            /* -------------------------------------------------
               NO IMAGE
            ------------------------------------------------- */

            doctorImageInput.value = '';

            hasNewDoctorImage = false;
            doctorImageDeleted = false;

            if (deletedDoctorImageInput) {
                deletedDoctorImageInput.value = '';
            }

            showDoctorDefaultImage();

            removeDoctorImageBtn.style.display = 'none';
        });
    }


    /* =========================================================
       CLINIC IMAGES
    ========================================================= */

    const clinicImagesInput =
        document.getElementById('clinicImagesInput');

    const clinicImagesPreview =
        document.getElementById('clinicImagesPreview');

    const clinicImagesCount =
        document.getElementById('clinicImagesCount');

    const deletedClinicImagesInput =
        document.getElementById('deletedClinicImages');


    if (
        clinicImagesInput &&
        clinicImagesPreview &&
        clinicImagesCount
    ) {

        let selectedClinicImages = [];


        /* =====================================================
           EXISTING IMAGES COUNT
        ===================================================== */

        function getExistingImagesCount() {
            return Array.from(
                clinicImagesPreview.querySelectorAll(
                    '.existing-clinic-image'
                )
            ).filter(
                item => item.style.display !== 'none'
            ).length;
        }


        /* =====================================================
           UPDATE COUNT
        ===================================================== */

        function updateClinicImagesCount() {

            const existingCount =
                getExistingImagesCount();

            const total =
                existingCount +
                selectedClinicImages.length;

            const countText =
                clinicImagesCount.querySelector(
                    '.count-text'
                );

            if (!countText) return;

            countText.textContent =
                total === 0
                    ? 'يمكنك إضافة صور للعيادة'
                    : `تم اختيار ${total} من أصل 3 صور`;
        }


        /* =====================================================
           SYNC FILE INPUT
        ===================================================== */

        function syncClinicImagesInput() {

            if (!window.DataTransfer) return;

            const dataTransfer =
                new DataTransfer();

            selectedClinicImages.forEach(file => {
                dataTransfer.items.add(file);
            });

            clinicImagesInput.files =
                dataTransfer.files;
        }


        /* =====================================================
           RENDER NEW CLINIC IMAGES
        ===================================================== */

        function renderClinicImages() {

            const uploadBox =
                clinicImagesPreview.querySelector(
                    '.clinic-images-dropzone'
                );

            clinicImagesPreview
                .querySelectorAll('.new-clinic-image')
                .forEach(item => item.remove());


            selectedClinicImages.forEach(
                function (file, index) {

                    const reader =
                        new FileReader();

                    reader.onload =
                        function (event) {

                            const item =
                                document.createElement('div');

                            item.className =
                                'clinic-image-preview-item new-clinic-image';

                            item.innerHTML = `
                                <img
                                    src="${event.target.result}"
                                    alt="صورة العيادة الجديدة"
                                >

                                <button
                                    type="button"
                                    class="clinic-image-remove"
                                    data-image-index="${index}"
                                    aria-label="حذف الصورة"
                                >
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            `;

                            if (uploadBox) {
                                clinicImagesPreview.insertBefore(
                                    item,
                                    uploadBox
                                );
                            } else {
                                clinicImagesPreview.appendChild(item);
                            }
                        };

                    reader.readAsDataURL(file);
                }
            );

            syncClinicImagesInput();
            updateClinicImagesCount();
        }


        /* =====================================================
           SELECT CLINIC IMAGES
        ===================================================== */

        clinicImagesInput.addEventListener(
            'change',
            function () {

                const files =
                    Array.from(this.files);

                if (!files.length) return;

                const existingCount =
                    getExistingImagesCount();

                const availableSlots =
                    3 -
                    existingCount -
                    selectedClinicImages.length;

                if (availableSlots <= 0) {
                    this.value = '';
                    return;
                }

                selectedClinicImages =
                    selectedClinicImages.concat(
                        files.slice(0, availableSlots)
                    );

                syncClinicImagesInput();
                renderClinicImages();
            }
        );


        /* =====================================================
           REMOVE CLINIC IMAGES
        ===================================================== */

        clinicImagesPreview.addEventListener(
            'click',
            function (event) {

                /* -------------------------------------------------
                   REMOVE NEW IMAGE
                ------------------------------------------------- */

                const removeNewButton =
                    event.target.closest(
                        '.new-clinic-image .clinic-image-remove'
                    );

                if (removeNewButton) {

                    const index =
                        Number(
                            removeNewButton.dataset.imageIndex
                        );

                    if (Number.isNaN(index)) return;

                    selectedClinicImages.splice(index, 1);

                    syncClinicImagesInput();
                    renderClinicImages();

                    return;
                }


                /* -------------------------------------------------
                   REMOVE EXISTING IMAGE
                ------------------------------------------------- */

                const removeExistingButton =
                    event.target.closest(
                        '.existing-clinic-image-remove'
                    );

                if (!removeExistingButton) return;

                const image =
                    removeExistingButton.dataset.image;

                const item =
                    removeExistingButton.closest(
                        '.existing-clinic-image'
                    );

                if (!item) return;

                /* Hide from UI */
                item.style.display = 'none';


                /* Store deleted image */
                if (!deletedClinicImagesInput) return;

                let deletedImages = [];

                try {
                    deletedImages =
                        JSON.parse(
                            deletedClinicImagesInput.value || '[]'
                        );

                    if (!Array.isArray(deletedImages)) {
                        deletedImages = [];
                    }

                } catch {
                    deletedImages = [];
                }


                if (!deletedImages.includes(image)) {
                    deletedImages.push(image);
                }

                deletedClinicImagesInput.value =
                    JSON.stringify(deletedImages);

                updateClinicImagesCount();
            }
        );


        /* =====================================================
           INITIAL COUNT
        ===================================================== */

        updateClinicImagesCount();
    }

});

