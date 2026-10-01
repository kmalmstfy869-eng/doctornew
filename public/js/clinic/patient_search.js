document.addEventListener('DOMContentLoaded', function () {

    document
        .querySelectorAll('[data-patient-search]')
        .forEach(function (container) {

            const searchInput =
                container.querySelector(
                    '[data-patient-search-input]'
                );

            const resultsContainer =
                container.querySelector(
                    '[data-patient-search-results]'
                );

            const patientIdInput =
                container.querySelector(
                    '[data-patient-search-id]'
                );

            const selectedContainer =
                container.querySelector(
                    '[data-patient-search-selected]'
                );

            const selectedName =
                container.querySelector(
                    '[data-patient-search-selected-name]'
                );

            const selectedPhone =
                container.querySelector(
                    '[data-patient-search-selected-phone]'
                );

            const changeButton =
                container.querySelector(
                    '[data-patient-search-change]'
                );

            const picker =
                container.querySelector(
                    '[data-patient-search-picker]'
                );

            const searchUrl =
                container.dataset.patientSearchUrl;

            if (
                !searchInput ||
                !resultsContainer ||
                !patientIdInput ||
                !searchUrl
            ) {
                return;
            }

            let searchTimer = null;
            let controller = null;


            function escapeHtml(value) {

                const div =
                    document.createElement('div');

                div.textContent =
                    value ?? '';

                return div.innerHTML;
            }


            function hideResults() {

                resultsContainer.innerHTML = '';

                resultsContainer.classList.add(
                    'hidden'
                );
            }


            function showResults() {

                resultsContainer.classList.remove(
                    'hidden'
                );
            }


            function renderResults(patients) {

                if (!patients.length) {

                    resultsContainer.innerHTML = `
                        <div class="p-4 text-center text-sm text-muted-foreground">
                            لا يوجد مريض مطابق للبحث.
                        </div>
                    `;

                    showResults();

                    return;
                }


                resultsContainer.innerHTML =
                    patients.map(function (patient) {

                        const phone =
                            patient.phone ||
                            'لا يوجد رقم هاتف';

                        const initials =
                            (patient.name || '')
                                .substring(0, 2);

                        return `
                            <button
                                type="button"
                                data-patient-result
                                data-patient-id="${escapeHtml(String(patient.id))}"
                                data-patient-name="${escapeHtml(patient.name || '')}"
                                data-patient-phone="${escapeHtml(patient.phone || '')}"
                                class="flex w-full items-center gap-3 border-b border-border/60 p-3 text-start transition last:border-b-0 hover:bg-muted/60"
                            >

                                <div
                                    class="grid size-10 shrink-0 place-items-center rounded-xl bg-primary-soft font-bold text-primary"
                                >
                                    ${escapeHtml(initials)}
                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-semibold text-foreground">
                                        ${escapeHtml(patient.name || '')}
                                    </p>

                                    <p class="mt-0.5 text-xs text-muted-foreground">
                                        ${escapeHtml(phone)}
                                    </p>

                                </div>

                            </button>
                        `;

                    }).join('');


                showResults();
            }


            function selectPatient(patient) {

                patientIdInput.value =
                    patient.id;


                if (selectedName) {

                    selectedName.textContent =
                        patient.name || '';
                }


                if (selectedPhone) {

                    selectedPhone.textContent =
                        patient.phone ||
                        'لا يوجد رقم هاتف';
                }


                if (selectedContainer) {

                    selectedContainer.classList.remove(
                        'hidden'
                    );
                }


                if (picker) {

                    picker.classList.add(
                        'hidden'
                    );
                }


                searchInput.value = '';

                hideResults();


                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }


            function changePatient() {

                patientIdInput.value = '';


                if (selectedName) {
                    selectedName.textContent = '';
                }


                if (selectedPhone) {
                    selectedPhone.textContent = '';
                }


                if (selectedContainer) {

                    selectedContainer.classList.add(
                        'hidden'
                    );
                }


                if (picker) {

                    picker.classList.remove(
                        'hidden'
                    );
                }


                searchInput.value = '';

                hideResults();

                searchInput.focus();
            }


            function searchPatients() {

                const search =
                    searchInput.value.trim();


                if (controller) {
                    controller.abort();
                }


                if (search === '') {

                    hideResults();

                    return;
                }


                if (search.length < 2) {

                    resultsContainer.innerHTML = `
                        <div class="p-4 text-center text-sm text-muted-foreground">
                            اكتب حرفين على الأقل للبحث.
                        </div>
                    `;

                    showResults();

                    return;
                }


                controller =
                    new AbortController();


                resultsContainer.innerHTML = `
                    <div class="p-4 text-center text-sm text-muted-foreground">
                        جاري البحث...
                    </div>
                `;

                showResults();


                const url =
                    new URL(
                        searchUrl,
                        window.location.origin
                    );


                url.searchParams.set(
                    'search',
                    search
                );


                fetch(
                    url.toString(),
                    {
                        method: 'GET',

                        headers: {
                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'application/json'
                        },

                        signal:
                            controller.signal
                    }
                )
                    .then(function (response) {

                        if (!response.ok) {

                            throw new Error(
                                'Patient search failed'
                            );
                        }

                        return response.json();
                    })
                    .then(function (data) {

                        renderResults(
                            Array.isArray(
                                data.patients
                            )
                                ? data.patients
                                : []
                        );

                    })
                    .catch(function (error) {

                        if (
                            error.name ===
                            'AbortError'
                        ) {
                            return;
                        }


                        resultsContainer.innerHTML = `
                            <div class="p-4 text-center text-sm text-danger">
                                حدث خطأ أثناء البحث عن المريض.
                            </div>
                        `;

                        showResults();
                    });
            }


            searchInput.addEventListener(
                'input',
                function () {

                    clearTimeout(
                        searchTimer
                    );

                    searchTimer =
                        setTimeout(
                            searchPatients,
                            300
                        );
                }
            );


            resultsContainer.addEventListener(
                'click',
                function (event) {

                    const result =
                        event.target.closest(
                            '[data-patient-result]'
                        );


                    if (!result) {
                        return;
                    }


                    selectPatient({

                        id:
                            result.dataset.patientId,

                        name:
                            result.dataset.patientName,

                        phone:
                            result.dataset.patientPhone

                    });
                }
            );


            if (changeButton) {

                changeButton.addEventListener(
                    'click',
                    function () {

                        changePatient();

                    }
                );
            }


            document.addEventListener(
                'click',
                function (event) {

                    if (
                        !container.contains(
                            event.target
                        )
                    ) {

                        hideResults();
                    }
                }
            );


            if (
                patientIdInput.value !== ''
            ) {

                if (selectedContainer) {

                    selectedContainer.classList.remove(
                        'hidden'
                    );
                }

                if (picker) {

                    picker.classList.add(
                        'hidden'
                    );
                }

            } else {

                if (picker) {

                    picker.classList.remove(
                        'hidden'
                    );
                }
            }

        });

});
