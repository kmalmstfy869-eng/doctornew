document.addEventListener("DOMContentLoaded", function () {
    var toggle = document.getElementById("publicNavToggle");
    var nav = document.getElementById("publicMobileNav");
    var overlay = document.getElementById("publicNavOverlay");
    var closeBtn = document.getElementById("publicNavClose");

    if (!toggle || !nav) {
        return;
    }

    function setOpen(open) {
        nav.classList.toggle("is-open", open);
        toggle.setAttribute("aria-expanded", open ? "true" : "false");

        if (overlay) {
            overlay.classList.toggle("is-open", open);
            overlay.hidden = !open;
        }

        nav.hidden = false;
        document.body.classList.toggle("public-nav-locked", open);

        var icon = toggle.querySelector("i");

        if (icon) {
            icon.className = open ? "fa-solid fa-xmark" : "fa-solid fa-bars";
        }
    }

    function close() {
        setOpen(false);
    }

    toggle.addEventListener("click", function () {
        setOpen(!nav.classList.contains("is-open"));
    });

    if (closeBtn) {
        closeBtn.addEventListener("click", close);
    }

    if (overlay) {
        overlay.addEventListener("click", close);
    }

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            close();
        }
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 800) {
            close();
        }
    });
});
