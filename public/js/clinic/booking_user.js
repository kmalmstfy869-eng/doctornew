document.addEventListener('DOMContentLoaded', function () {


/*
|--------------------------------------------------------------------------
| Booking Elements
|--------------------------------------------------------------------------
*/

const bookingModal =
    document.getElementById('medPatientBookingModal');

const bookingOverlay =
    document.getElementById('medPatientBookingOverlay');

const bookingClose =
    document.getElementById('medPatientBookingClose');

const bookingCancel =
    document.getElementById('medPatientBookingCancel');

const confirmBookingButton =
    document.getElementById('medConfirmBooking');

const selectedText =
    document.getElementById('medSelectedText');

const modalSelectedAppointment =
    document.getElementById('medModalSelectedAppointment');

const appointmentDateInput =
    document.getElementById('medAppointmentDate');

const startTimeInput =
    document.getElementById('medStartTime');


/*
|--------------------------------------------------------------------------
| Selected Appointment
|--------------------------------------------------------------------------
*/

let selectedAppointment = {
    date: '',
    start: ''
};


/*
|--------------------------------------------------------------------------
| Format Time
|--------------------------------------------------------------------------
*/

function formatArabicTime(time) {

    if (!time) {
        return '';
    }

    const parts = time.split(':');

    let hour =
        parseInt(parts[0], 10);

    const minute =
        parts[1] ?? '00';

    const period =
        hour >= 12 ? 'م' : 'ص';

    hour =
        hour % 12;

    if (hour === 0) {
        hour = 12;
    }

    return `${String(hour).padStart(2, '0')}:${minute} ${period}`;
}


/*
|--------------------------------------------------------------------------
| Format Selected Appointment
|--------------------------------------------------------------------------
*/

function updateSelectedAppointmentText() {

    if (
        !selectedAppointment.date ||
        !selectedAppointment.start
    ) {

        if (selectedText) {

            selectedText.textContent =
                'لم يتم اختيار موعد بعد';

        }

        if (modalSelectedAppointment) {

            modalSelectedAppointment.textContent =
                'لم يتم اختيار موعد';

        }

        return;
    }


    const dateElement =
        document.querySelector(
            `.med-day-accordion[data-date="${selectedAppointment.date}"]`
        );


    let dateText =
        selectedAppointment.date;


    if (dateElement) {

        const dateStrong =
            dateElement.querySelector(
                '.med-day-info strong'
            );

        const dayName =
            dateElement.querySelector(
                '.med-day-name'
            );


        if (dateStrong) {

            dateText =
                dayName
                    ? `${dayName.textContent.trim()} - ${dateStrong.textContent.trim()}`
                    : dateStrong.textContent.trim();

        }

    }


    const timeText =
        formatArabicTime(
            selectedAppointment.start
        );


    const finalText =
        `${dateText} - الساعة ${timeText}`;


    if (selectedText) {

        selectedText.textContent =
            finalText;

    }


    if (modalSelectedAppointment) {

        modalSelectedAppointment.textContent =
            finalText;

    }

}


/*
|--------------------------------------------------------------------------
| Select Slot
|--------------------------------------------------------------------------
*/

const slotButtons =
    document.querySelectorAll(
        '.med-slot-button'
    );


slotButtons.forEach(function (button) {

    button.addEventListener(
        'click',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Prevent Booked / Expired Slots
            |--------------------------------------------------------------------------
            */

            if (
                this.disabled ||
                this.classList.contains('booked') ||
                this.classList.contains('expired')
            ) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Remove Previous Selected Slot
            |--------------------------------------------------------------------------
            */

            slotButtons.forEach(function (slotButton) {

                slotButton.classList.remove(
                    'selected'
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Add Selected Class
            |--------------------------------------------------------------------------
            */

            this.classList.add(
                'selected'
            );


            /*
            |--------------------------------------------------------------------------
            | Read Appointment Data
            |--------------------------------------------------------------------------
            */

            selectedAppointment.date =
                this.dataset.date || '';

            selectedAppointment.start =
                this.dataset.start || '';


            /*
            |--------------------------------------------------------------------------
            | Update Hidden Inputs
            |--------------------------------------------------------------------------
            */

            if (appointmentDateInput) {

                appointmentDateInput.value =
                    selectedAppointment.date;

            }

            if (startTimeInput) {

                startTimeInput.value =
                    selectedAppointment.start;

            }


            /*
            |--------------------------------------------------------------------------
            | Update UI
            |--------------------------------------------------------------------------
            */

            updateSelectedAppointmentText();


            /*
            |--------------------------------------------------------------------------
            | Enable Confirm Button
            |--------------------------------------------------------------------------
            */

            if (confirmBookingButton) {

                confirmBookingButton.disabled =
                    false;

            }

        }
    );

});


/*
|--------------------------------------------------------------------------
| Open Booking Modal
|--------------------------------------------------------------------------
*/

function openBookingModal() {

    if (!bookingModal) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Make Sure Appointment Exists
    |--------------------------------------------------------------------------
    */

    if (
        !selectedAppointment.date ||
        !selectedAppointment.start
    ) {
        return;
    }


    updateSelectedAppointmentText();


    bookingModal.classList.add(
        'active'
    );

    bookingModal.setAttribute(
        'aria-hidden',
        'false'
    );


    document.body.classList.add(
        'med-booking-modal-open'
    );


    /*
    |--------------------------------------------------------------------------
    | Focus Patient Name
    |--------------------------------------------------------------------------
    */

    const patientName =
        document.getElementById(
            'patient_name'
        );


    if (patientName) {

        setTimeout(function () {

            patientName.focus();

        }, 150);

    }

}


/*
|--------------------------------------------------------------------------
| Close Booking Modal
|--------------------------------------------------------------------------
*/

function closeBookingModal() {

    if (!bookingModal) {
        return;
    }


    bookingModal.classList.remove(
        'active'
    );

    bookingModal.setAttribute(
        'aria-hidden',
        'true'
    );


    document.body.classList.remove(
        'med-booking-modal-open'
    );

}


/*
|--------------------------------------------------------------------------
| Confirm Booking Button
|--------------------------------------------------------------------------
*/

if (confirmBookingButton) {

    confirmBookingButton.addEventListener(
        'click',
        function () {

            openBookingModal();

        }
    );

}


/*
|--------------------------------------------------------------------------
| Close Buttons
|--------------------------------------------------------------------------
*/

if (bookingClose) {

    bookingClose.addEventListener(
        'click',
        closeBookingModal
    );

}


if (bookingCancel) {

    bookingCancel.addEventListener(
        'click',
        closeBookingModal
    );

}


if (bookingOverlay) {

    bookingOverlay.addEventListener(
        'click',
        closeBookingModal
    );

}


/*
|--------------------------------------------------------------------------
| Escape Key
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'keydown',
    function (event) {

        if (
            event.key === 'Escape' &&
            bookingModal &&
            bookingModal.classList.contains('active')
        ) {

            closeBookingModal();

        }

    }
);


/*
|--------------------------------------------------------------------------
| Restore Old Booking Data
|--------------------------------------------------------------------------
|
| البيانات يتم وضعها من Blade داخل window.medBookingData
|
*/

const bookingData =
    window.medBookingData || {};


const hasOldBookingData =
    bookingData.hasOldBookingData === true;


const hasBookingValidationErrors =
    bookingData.hasBookingValidationErrors === true;


if (
    hasOldBookingData ||
    hasBookingValidationErrors
) {

    selectedAppointment.date =
        bookingData.appointmentDate || '';

    selectedAppointment.start =
        bookingData.startTime || '';


    /*
    |--------------------------------------------------------------------------
    | Restore Hidden Inputs
    |--------------------------------------------------------------------------
    */

    if (appointmentDateInput) {

        appointmentDateInput.value =
            selectedAppointment.date;

    }


    if (startTimeInput) {

        startTimeInput.value =
            selectedAppointment.start;

    }


    /*
    |--------------------------------------------------------------------------
    | Restore Selected Slot
    |--------------------------------------------------------------------------
    */

    slotButtons.forEach(function (button) {

        const sameSlot =
            button.dataset.date ===
                selectedAppointment.date &&
            button.dataset.start ===
                selectedAppointment.start;


        if (
            sameSlot &&
            !button.disabled &&
            !button.classList.contains('booked') &&
            !button.classList.contains('expired')
        ) {

            button.classList.add(
                'selected'
            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Update Appointment Text
    |--------------------------------------------------------------------------
    */

    updateSelectedAppointmentText();


    /*
    |--------------------------------------------------------------------------
    | Enable Confirm Button
    |--------------------------------------------------------------------------
    */

    if (
        selectedAppointment.date &&
        selectedAppointment.start &&
        confirmBookingButton
    ) {

        const selectedSlot =
            document.querySelector(
                `.med-slot-button[data-date="${selectedAppointment.date}"][data-start="${selectedAppointment.start}"]`
            );


        if (
            selectedSlot &&
            !selectedSlot.disabled &&
            !selectedSlot.classList.contains('booked') &&
            !selectedSlot.classList.contains('expired')
        ) {

            confirmBookingButton.disabled =
                false;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Reopen Modal After Validation Error
    |--------------------------------------------------------------------------
    */

    if (
        bookingModal &&
        selectedAppointment.date &&
        selectedAppointment.start
    ) {

        const selectedSlot =
            document.querySelector(
                `.med-slot-button[data-date="${selectedAppointment.date}"][data-start="${selectedAppointment.start}"]`
            );


        if (
            selectedSlot &&
            !selectedSlot.disabled &&
            !selectedSlot.classList.contains('booked') &&
            !selectedSlot.classList.contains('expired')
        ) {

            bookingModal.classList.add(
                'active'
            );

            bookingModal.setAttribute(
                'aria-hidden',
                'false'
            );

            document.body.classList.add(
                'med-booking-modal-open'
            );


            const patientName =
                document.getElementById(
                    'patient_name'
                );


            if (patientName) {

                setTimeout(function () {

                    patientName.focus();

                }, 150);

            }

        }

    }

}


});
