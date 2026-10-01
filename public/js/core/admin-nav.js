document.addEventListener("DOMContentLoaded", function () {
    var toggle = document.getElementById("mobileMenuButton");
    var sidebar = document.querySelector("aside.sidebar");
    var overlay = document.getElementById("adminSidebarOverlay");

    if (!toggle || !sidebar) {
        return;
    }

    function setOpen(open) {
        sidebar.classList.toggle("open", open);
        toggle.setAttribute("aria-expanded", open ? "true" : "false");

        if (overlay) {
            overlay.classList.toggle("is-open", open);
            overlay.hidden = !open;
        }

        document.body.classList.toggle("admin-nav-locked", open);
    }

    function close() {
        setOpen(false);
    }

    toggle.addEventListener("click", function () {
        setOpen(!sidebar.classList.contains("open"));
    });

    if (overlay) {
        overlay.addEventListener("click", close);
    }

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            close();
        }
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 991) {
            close();
        }
    });
});
