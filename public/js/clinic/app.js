/* ===================================================================
   Clinic Harmony — shared vanilla JS
   Handles ONLY interactive micro-components: theme toggle, mobile
   drawer, dropdown menus, modals/dialogs, tabs, switches, simple
   client-side search/filter on already-rendered rows.
   No routing. No data fetching. Every page is a plain .html file.
   =================================================================== */

(function () {
  "use strict";

  /* ---------------- Theme (dark mode) ---------------- */
  function initTheme() {
    var stored = localStorage.getItem("clinic-theme");

    var isDark = stored
      ? stored === "dark"
      : window.matchMedia("(prefers-color-scheme: dark)").matches;

    document.documentElement.classList.toggle("dark", isDark);

    updateThemeIcon(isDark);

    var btn = document.getElementById("theme-toggle");

    if (btn) {
      btn.addEventListener("click", function () {
        var next =
          !document.documentElement.classList.contains("dark");

        document.documentElement.classList.toggle("dark", next);

        localStorage.setItem(
          "clinic-theme",
          next ? "dark" : "light"
        );

        updateThemeIcon(next);
      });
    }
  }

  function updateThemeIcon(isDark) {
    var sun = document.getElementById("theme-icon-sun");
    var moon = document.getElementById("theme-icon-moon");

    if (sun && moon) {
      sun.style.display = isDark ? "block" : "none";
      moon.style.display = isDark ? "none" : "block";
    }
  }


  /* ---------------- Mobile drawer ---------------- */
  function initDrawer() {
    var openBtn = document.getElementById("drawer-open");
    var closeBtn = document.getElementById("drawer-close");
    var overlay = document.getElementById("drawer-overlay");
    var drawer = document.getElementById("clinic-sidebar");

    if (!drawer) return;

    function open() {
      drawer.classList.remove("translate-x-full");

      if (overlay) {
        overlay.classList.remove("hidden");
      }

      document.body.style.overflow = "hidden";
    }

    function close() {
      drawer.classList.add("translate-x-full");

      if (overlay) {
        overlay.classList.add("hidden");
      }

      document.body.style.overflow = "";
    }

    if (openBtn) {
      openBtn.addEventListener("click", open);
    }

    if (closeBtn) {
      closeBtn.addEventListener("click", close);
    }

    if (overlay) {
      overlay.addEventListener("click", close);
    }

    /*
     * لو الشاشة كبرت من Mobile إلى Desktop
     * نقفل الـ Drawer ونرجع الـ body للوضع الطبيعي.
     */
    window.addEventListener("resize", function () {
      if (window.innerWidth >= 1024) {
        close();
      }
    });
  }


  /* ---------------- Dropdown menus ---------------- */
  function initDropdowns() {
    document
      .querySelectorAll("[data-dropdown-trigger]")
      .forEach(function (trigger) {
        trigger.addEventListener("click", function (e) {
          e.stopPropagation();

          var dropdown = trigger.closest(".dropdown");

          if (!dropdown) return;

          var wasOpen = dropdown.classList.contains("open");

          closeAllDropdowns();

          if (!wasOpen) {
            dropdown.classList.add("open");
          }
        });
      });

    document.addEventListener("click", closeAllDropdowns);
  }

  function closeAllDropdowns() {
    document
      .querySelectorAll(".dropdown.open")
      .forEach(function (dropdown) {
        dropdown.classList.remove("open");
      });
  }


  /* ---------------- Modals / dialogs ---------------- */
  function initModals() {
    document
      .querySelectorAll("[data-modal-open]")
      .forEach(function (btn) {
        btn.addEventListener("click", function () {
          var id = btn.getAttribute("data-modal-open");
          var modal = document.getElementById(id);

          if (modal) {
            modal.classList.add("open");
          }
        });
      });

    document
      .querySelectorAll("[data-modal-close]")
      .forEach(function (btn) {
        btn.addEventListener("click", function () {
          var overlay = btn.closest(".modal-overlay");

          if (overlay) {
            overlay.classList.remove("open");
          }
        });
      });

    document
      .querySelectorAll(".modal-overlay")
      .forEach(function (overlay) {
        overlay.addEventListener("click", function (e) {
          if (e.target === overlay) {
            overlay.classList.remove("open");
          }
        });
      });
  }


  /* ---------------- Tabs ---------------- */
  function initTabs() {
    document
      .querySelectorAll("[data-tabs]")
      .forEach(function (group) {
        var name = group.getAttribute("data-tabs");

        var triggers =
          group.querySelectorAll("[data-tab-trigger]");

        triggers.forEach(function (trigger) {
          trigger.addEventListener("click", function () {
            var value =
              trigger.getAttribute("data-tab-trigger");

            triggers.forEach(function (item) {
              item.classList.remove("active");
            });

            trigger.classList.add("active");

            document
              .querySelectorAll(
                '[data-tab-panel][data-tabs-owner="' +
                  name +
                  '"]'
              )
              .forEach(function (panel) {
                panel.classList.toggle(
                  "active",
                  panel.getAttribute("data-tab-panel") === value
                );
              });

            if (typeof window.onTabChange === "function") {
              window.onTabChange(name, value);
            }
          });
        });
      });
  }


  /* ---------------- Switches ---------------- */
  function initSwitches() {
    document
      .querySelectorAll(".switch")
      .forEach(function (sw) {
        sw.addEventListener("click", function () {
          var checked =
            sw.getAttribute("aria-checked") === "true";

          sw.setAttribute(
            "aria-checked",
            String(!checked)
          );
        });
      });
  }


  /* ---------------- Generic live search/filter ----------------
     Usage: input[data-search-target="#list-id"] filters children
     of the target that have [data-search-text] using textContent.
  ------------------------------------------------------------- */
  function initSearch() {
    document
      .querySelectorAll("[data-search-target]")
      .forEach(function (input) {
        var target = document.querySelector(
          input.getAttribute("data-search-target")
        );

        if (!target) return;

        input.addEventListener("input", function () {
          var q = input.value.trim().toLowerCase();

          target
            .querySelectorAll("[data-search-text]")
            .forEach(function (row) {
              var text =
                row
                  .getAttribute("data-search-text")
                  .toLowerCase();

              row.style.display =
                !q || text.indexOf(q) !== -1
                  ? ""
                  : "none";
            });
        });
      });
  }


  /* ---------------- Simple tab-style filter buttons/select ----------------
     [data-filter-target] filters rows in target via [data-filter-value]
  ------------------------------------------------------------------- */
  function initFilterSelects() {
    document
      .querySelectorAll("[data-filter-target]")
      .forEach(function (select) {
        var target = document.querySelector(
          select.getAttribute("data-filter-target")
        );

        if (!target) return;

        select.addEventListener("change", function () {
          var value = select.value;

          target
            .querySelectorAll("[data-filter-value]")
            .forEach(function (row) {
              row.style.display =
                value === "all" ||
                row.getAttribute("data-filter-value") === value
                  ? ""
                  : "none";
            });
        });
      });
  }


  /* ---------------- Init ---------------- */
  document.addEventListener("DOMContentLoaded", function () {
    initTheme();
    initDrawer();
    initDropdowns();
    initModals();
    initTabs();
    initSwitches();
    initSearch();
    initFilterSelects();

    if (window.lucide) {
      window.lucide.createIcons();
    }
  });
})();


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
