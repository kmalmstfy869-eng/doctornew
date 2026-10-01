document.addEventListener('DOMContentLoaded', function () {

    document
        .querySelectorAll('[data-live-search]')
        .forEach(function (searchInput) {

            const searchUrl =
                searchInput.dataset.liveSearchUrl;

            const targetSelector =
                searchInput.dataset.liveSearchTarget;

            const paginationSelector =
                searchInput.dataset.liveSearchPagination;

            const countSelector =
                searchInput.dataset.liveSearchCount;

            const preserveSelectors =
                searchInput.dataset.liveSearchPreserve
                    ? searchInput.dataset.liveSearchPreserve
                        .split(',')
                        .map(function (selector) {
                            return selector.trim();
                        })
                        .filter(Boolean)
                    : [];

            const resultsContainer =
                document.querySelector(targetSelector);

            const paginationContainer =
                paginationSelector
                    ? document.querySelector(paginationSelector)
                    : null;

            const countElement =
                countSelector
                    ? document.querySelector(countSelector)
                    : null;

            if (
                !searchUrl ||
                !targetSelector ||
                !resultsContainer
            ) {
                return;
            }

            let searchTimer = null;
            let controller = null;

            function renderLucide() {

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

            }

            function performSearch() {

                const search =
                    searchInput.value.trim();

                if (controller) {
                    controller.abort();
                }

                controller =
                    new AbortController();

                const url =
                    new URL(
                        searchUrl,
                        window.location.origin
                    );

                /*
                 * البحث الحالي
                 */
                if (search !== '') {

                    url.searchParams.set(
                        searchInput.name || 'search',
                        search
                    );

                } else {

                    url.searchParams.delete(
                        searchInput.name || 'search'
                    );

                }

                /*
                 * الحفاظ على أي فلاتر موجودة في الصفحة
                 * مثل:
                 * booking_filter
                 * source
                 * وغيرها
                 */
                preserveSelectors.forEach(function (selector) {

                    const element =
                        document.querySelector(selector);

                    if (!element) {
                        return;
                    }

                    const name =
                        element.name;

                    if (!name) {
                        return;
                    }

                    if (
                        element.type === 'checkbox' ||
                        element.type === 'radio'
                    ) {

                        if (!element.checked) {
                            return;
                        }

                    }

                    const value =
                        element.value;

                    if (
                        value !== null &&
                        value !== ''
                    ) {

                        url.searchParams.set(
                            name,
                            value
                        );

                    }

                });

                /*
                 * البحث يبدأ دائمًا من الصفحة الأولى
                 */
                url.searchParams.set(
                    'page',
                    '1'
                );

                fetch(
                    url.toString(),
                    {
                        method: 'GET',

                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        },

                        signal: controller.signal
                    }
                )
                    .then(function (response) {

                        if (!response.ok) {
                            throw new Error(
                                'Search request failed'
                            );
                        }

                        return response.text();

                    })
                    .then(function (html) {

                        const parser =
                            new DOMParser();

                        const doc =
                            parser.parseFromString(
                                html,
                                'text/html'
                            );

                        /*
                         * النتائج
                         */
                        const newResults =
                            doc.querySelector(
                                targetSelector
                            );

                        if (newResults) {

                            resultsContainer.innerHTML =
                                newResults.innerHTML;

                        }

                        /*
                         * Pagination
                         */
                        if (
                            paginationContainer &&
                            paginationSelector
                        ) {

                            const newPagination =
                                doc.querySelector(
                                    paginationSelector
                                );

                            if (newPagination) {

                                paginationContainer.innerHTML =
                                    newPagination.innerHTML;

                            } else {

                                paginationContainer.innerHTML =
                                    '';

                            }

                        }

                        /*
                         * العدد لو الصفحة تستخدمه
                         */
                        if (
                            countElement &&
                            countSelector
                        ) {

                            const newCount =
                                doc.querySelector(
                                    countSelector
                                );

                            if (newCount) {

                                countElement.textContent =
                                    newCount.textContent;

                            }

                        }

                        /*
                         * تحديث الرابط بدون Reload
                         */
                        history.replaceState(
                            null,
                            '',
                            url.toString()
                        );

                        renderLucide();

                    })
                    .catch(function (error) {

                        if (
                            error.name === 'AbortError'
                        ) {
                            return;
                        }

                    });

            }

            /*
             * Live Search
             */
            searchInput.addEventListener(
                'input',
                function () {

                    clearTimeout(
                        searchTimer
                    );

                    searchTimer =
                        setTimeout(
                            performSearch,
                            300
                        );

                }
            );

            /*
             * زر مسح البحث العام
             */
            document.addEventListener(
                'click',
                function (event) {

                    const clearButton =
                        event.target.closest(
                            '[data-live-search-clear]'
                        );

                    if (!clearButton) {
                        return;
                    }

                    searchInput.value = '';

                    performSearch();

                }
            );

        });

});
