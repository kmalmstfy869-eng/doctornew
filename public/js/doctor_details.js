/* =========================================================
   COPY / ACTION TOAST
========================================================= */

function showCopyToast(
    title = "تم نسخ الرابط",
    message = "يمكنك مشاركته الآن",
    icon = "fa-check"
) {

    const oldToast =
        document.getElementById("copyLinkToast");

    if (oldToast) {
        oldToast.remove();
    }


    const toast =
        document.createElement("div");

    toast.id = "copyLinkToast";


    toast.innerHTML = `
        <div style="
            width:42px;
            height:42px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            background:rgba(255,255,255,.18);
            flex-shrink:0;
        ">
            <i
                class="fa-solid ${icon}"
                style="font-size:18px;"
            ></i>
        </div>

        <div style="
            display:flex;
            flex-direction:column;
            gap:3px;
        ">
            <strong style="
                font-size:14px;
                font-weight:800;
            ">
                ${title}
            </strong>

            <span style="
                font-size:11px;
                opacity:.85;
            ">
                ${message}
            </span>
        </div>
    `;


    Object.assign(toast.style, {

        position: "fixed",

        bottom: "25px",

        left: "25px",

        right: "auto",

        zIndex: "999999",

        display: "flex",

        alignItems: "center",

        gap: "12px",

        minWidth: "230px",

        padding: "13px 16px",

        borderRadius: "14px",

        background:
            "linear-gradient(135deg, #147d78, #0e625e)",

        color: "#ffffff",

        boxShadow:
            "0 12px 35px rgba(0,0,0,.20)",

        fontFamily:
            "Cairo, sans-serif",

        direction: "rtl",

        opacity: "0",

        transform:
            "translateY(20px)",

        transition:
            "all .3s ease"
    });


    document.body.appendChild(toast);


    requestAnimationFrame(function () {

        toast.style.opacity = "1";

        toast.style.transform =
            "translateY(0)";

    });


    setTimeout(function () {

        toast.style.opacity = "0";

        toast.style.transform =
            "translateY(20px)";


        setTimeout(function () {

            if (toast) {
                toast.remove();
            }

        }, 300);

    }, 2500);
}


/* =========================================================
   VIEW ONLY ACTIONS
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const viewOnlyActions =
            document.querySelectorAll(
                ".med-view-only-action"
            );


        if (!viewOnlyActions.length) {
            return;
        }


        viewOnlyActions.forEach(
            function (element) {

                element.addEventListener(
                    "click",
                    function (event) {

                        event.preventDefault();

                        event.stopPropagation();


                        showCopyToast(
                            "للعرض فقط",
                            "هذة الصفحة متاح للعرض فقط",
                            "fa-eye"
                        );

                    }
                );

            }
        );

    }
);


/* =========================================================
   SHARE PROFILE
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const shareButtons =
            document.querySelectorAll(
                "#medShareButton, #shareBtn"
            );


        if (!shareButtons.length) {
            return;
        }


        shareButtons.forEach(
            function (shareButton) {

                shareButton.addEventListener(
                    "click",
                    async function () {

                        const shareData = {

                            title:
                                document.title,

                            text:
                                "شاهد تفاصيل هذه الصفحة على دليل الأطباء",

                            url:
                                window.location.href
                        };


                        try {

                            /* =================================
                               مشاركة مباشرة
                            ================================= */

                            if (navigator.share) {

                                await navigator.share(
                                    shareData
                                );

                                return;
                            }


                            /* =================================
                               نسخ الرابط
                            ================================= */

                            if (
                                navigator.clipboard &&
                                window.isSecureContext
                            ) {

                                await navigator.clipboard.writeText(
                                    window.location.href
                                );

                            } else {

                                const input =
                                    document.createElement(
                                        "input"
                                    );


                                input.value =
                                    window.location.href;


                                input.style.position =
                                    "fixed";


                                input.style.opacity =
                                    "0";


                                document.body.appendChild(
                                    input
                                );


                                input.select();


                                document.execCommand(
                                    "copy"
                                );


                                input.remove();
                            }


                            showCopyToast(
                                "تم نسخ الرابط",
                                "يمكنك مشاركته الآن",
                                "fa-check"
                            );


                        } catch (error) {

                            console.log(
                                "Share cancelled:",
                                error
                            );

                        }

                    }
                );

            }
        );

    }
);


/* =========================================================
   GALLERY MODAL
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

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
            !imageModal ||
            !modalImage
        ) {
            return;
        }


        galleryImages.forEach(
            function (image) {

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

            }
        );


        function closeImageModal() {

            imageModal.classList.remove(
                "show"
            );


            modalImage.src = "";


            document.body.style.overflow = "";
        }


        if (closeModal) {

            closeModal.addEventListener(
                "click",
                closeImageModal
            );

        }


        imageModal.addEventListener(
            "click",
            function (event) {

                if (
                    event.target ===
                    imageModal
                ) {

                    closeImageModal();

                }

            }
        );


        document.addEventListener(
            "keydown",
            function (event) {

                if (
                    event.key === "Escape" &&
                    imageModal.classList.contains("show")
                ) {

                    closeImageModal();

                }

            }
        );

    }
);


/* =========================================================
   COPY PHONE
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const copyNumber =
            document.getElementById(
                "medCopyNumber"
            );


        if (!copyNumber) {
            return;
        }


        copyNumber.addEventListener(
            "click",
            async function () {

                const phone =
                    copyNumber.dataset.phone;


                if (!phone) {
                    return;
                }


                const oldHTML =
                    copyNumber.innerHTML;


                try {

                    if (
                        navigator.clipboard &&
                        window.isSecureContext
                    ) {

                        await navigator.clipboard.writeText(
                            phone
                        );

                    } else {

                        const input =
                            document.createElement(
                                "input"
                            );


                        input.value =
                            phone;


                        input.style.position =
                            "fixed";


                        input.style.opacity =
                            "0";


                        document.body.appendChild(
                            input
                        );


                        input.select();


                        document.execCommand(
                            "copy"
                        );


                        input.remove();
                    }


                    copyNumber.innerHTML =
                        '<i class="fa-solid fa-check"></i> تم نسخ الرقم';


                    setTimeout(
                        function () {

                            copyNumber.innerHTML =
                                oldHTML;

                        },
                        1800
                    );


                } catch (error) {

                    console.error(
                        "Copy failed:",
                        error
                    );

                }

            }
        );

    }
);
