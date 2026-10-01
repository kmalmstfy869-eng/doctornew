document.addEventListener('DOMContentLoaded', function () {

    const config =
        window.PatientsPageConfig;

    if (!config) {
        return;
    }

    if (
        config.hasValidationErrors &&
        !config.isUpdateRequest
    ) {

        const newPatientModal =
            document.getElementById(
                'modal-new-patient'
            );

        if (newPatientModal) {

            newPatientModal.classList.add(
                'open'
            );

        }

    }

});
