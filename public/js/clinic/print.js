
/*
|--------------------------------------------------------------------------
| Clinic Print Engine  —  public/js/clinic/print.js
|--------------------------------------------------------------------------
| نفس نظام الـ clone الموجود: بنعمل clone للمحتوى المطلوب فقط ونحطه في body،
| والـ CSS (print.css) بيخفي باقي الصفحة وقت الطباعة.
|
| modes:
|   file  → [data-print-file]                        : ملف المريض كامل (كل التابات)
|   visit → [data-print-trigger][data-print-mode=visit]
|   rx    → [data-print-trigger][data-print-mode=rx]
|
| للـ visit / rx: بنسحب أول .bq-print-only داخل العنصر [data-print-target]
| ونحط حواليه الترويسة والتذييل من <template> (print-letterhead).
|--------------------------------------------------------------------------
*/

(function () {
    'use strict';

    var ROOT_ID = 'bq-print-root';

    function cleanupPrint() {
        var root = document.getElementById(ROOT_ID);

        if (root) {
            root.remove();
        }

        document.body.classList.remove('bq-printing');
    }

    function removeAll(node, selector) {
        node.querySelectorAll(selector).forEach(function (el) {
            el.remove();
        });
    }

    function templateFragment(id) {
        var tpl = document.getElementById(id);

        return tpl && tpl.content
            ? tpl.content.cloneNode(true)
            : document.createDocumentFragment();
    }

    /* طباعة الملف: كل التابات تظهر، وأي UI أو عنصر طباعة فردي يتشال */
    function buildFile(source) {
        var clone = source.cloneNode(true);

        clone.removeAttribute('id');

        removeAll(clone, '.bq-no-print');
        removeAll(clone, '.bq-print-only');

        clone.querySelectorAll('.patient-tab-panel').forEach(function (panel) {
            panel.classList.remove('hidden');
            panel.classList.add('active');
        });

        return clone;
    }

    /* طباعة زيارة / روشتة: ترويسة + المحتوى + تذييل */
    function buildSheet(source) {
        var body = source.querySelector('.bq-print-only');

        if (!body) {
            return null;
        }

        var content = body.cloneNode(true);

        /*
         * مهم:
         * bq-print-only متخفي في CSS بشكل افتراضي.
         * بعد عمل clone، لازم نشيله من النسخة الجديدة
         * حتى يظهر محتوى الزيارة / الروشتة داخل ورقة الطباعة.
         */
        content.classList.remove('bq-print-only');

        content.querySelectorAll('.bq-print-only').forEach(function (el) {
            el.classList.remove('bq-print-only');
        });

        /* أي عنصر عليه bq-no-print يختفي من نسخة الطباعة */
        removeAll(content, '.bq-no-print');

        var sheet = document.createElement('div');
        sheet.className = 'bq-sheet';

        sheet.appendChild(templateFragment('bq-print-header-tpl'));

        var main = document.createElement('div');
        main.className = 'bq-sheet-main';
        main.appendChild(content);
        sheet.appendChild(main);

        sheet.appendChild(templateFragment('bq-print-footer-tpl'));

        return sheet;
    }

    function printSource(source, mode) {
        if (!source) {
            return;
        }

        var content = mode === 'file'
            ? buildFile(source)
            : buildSheet(source);

        if (!content) {
            return;
        }

        cleanupPrint();

        var root = document.createElement('div');

        root.id = ROOT_ID;
        root.setAttribute('data-mode', mode);
        root.setAttribute(
            'dir',
            document.documentElement.getAttribute('dir') || 'rtl'
        );

        root.appendChild(content);

        document.body.appendChild(root);
        document.body.classList.add('bq-printing');

        window.addEventListener('afterprint', cleanupPrint, {
            once: true
        });

        window.print();
    }

    // Event delegation: listener واحد لكل أزرار الطباعة
    document.addEventListener('click', function (event) {

        if (event.target.closest('[data-print-file]')) {
            printSource(
                document.getElementById('patient-print-area'),
                'file'
            );

            return;
        }

        var trigger = event.target.closest('[data-print-trigger]');

        if (trigger) {
            var targetName = trigger.getAttribute('data-print-trigger');
            var mode = trigger.getAttribute('data-print-mode') || 'rx';

            printSource(
                document.querySelector(
                    '[data-print-target="' + targetName + '"]'
                ),
                mode
            );
        }

    });
})();
