<?php
use App\Http\Controllers\Clinic\BookingController;
use App\Http\Controllers\Clinic\ClinicDashboardController;
use App\Http\Controllers\Clinic\ClinicScheduleController;
use App\Http\Controllers\Clinic\ClinicSlotsController;
use App\Http\Controllers\Clinic\DoctorAssistantController;
use App\Http\Controllers\Clinic\HistoryBookingController;
use App\Http\Controllers\Clinic\PatientNoteController;
use App\Http\Controllers\Clinic\PatientsController;
use App\Http\Controllers\Clinic\PaymentController;
use App\Http\Controllers\Clinic\PrescriptionController;
use App\Http\Controllers\Clinic\ReportController;
use App\Http\Controllers\Clinic\VisitController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth', 'verified', 'doctorbookingorassistant','redirect_admin','assistant_isactive'])
    ->prefix('clinic')
    ->name('clinic.')
    ->group(function () {

        Route::get('/dashboard', [ClinicDashboardController::class, 'index'])
            ->name('dashboard');


        Route::get('/dashboard/queue-data', [ClinicDashboardController::class, 'queueData'])
            ->name('dashboard.queue-data');
        /*
        |--------------------------------------------------------------------------
        | CLINIC SCHEDULES
        |--------------------------------------------------------------------------
        */

        Route::get('/schedules', [ClinicScheduleController::class, 'index'])
            ->name('schedules.index');

        Route::post('/schedules', [ClinicScheduleController::class, 'store'])
            ->name('schedules.store');

        Route::put('/schedules/{schedule}', [ClinicScheduleController::class, 'update'])
            ->name('schedules.update');

        Route::delete('/schedules/{schedule}', [ClinicScheduleController::class, 'destroy'])
            ->name('schedules.destroy');
        /*
        |--------------------------------------------------------------------------
        | CLINIC Slots
        |--------------------------------------------------------------------------
        */

        Route::get('/slots', [ClinicSlotsController::class, 'index'])
            ->name('slots.index');

        Route::post('/slots/close', [ClinicSlotsController::class, 'close'])
            ->name('slots.close');

        Route::delete('/slots/{blockedSlot}', [ClinicSlotsController::class, 'open'])
            ->name('slots.open');



        /*
        |--------------------------------------------------------------------------
        | BOOKINGS
        |--------------------------------------------------------------------------
        */
        Route::get('/bookings/queue-data', [BookingController::class, 'queueData'])
        ->name('queue.data');

        Route::get('/bookings', [BookingController::class, 'index'])
        ->name('bookings.index');



        Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

        Route::patch('/bookings/{booking}/arrive', [BookingController::class, 'arrive'])
        ->name('bookings.arrive');

        Route::post('/bookings/{booking}/call', [BookingController::class, 'call'])
            ->name('bookings.call');

        Route::patch('/bookings/{booking}/start', [BookingController::class, 'start'])
            ->name('bookings.start');

        Route::patch('/bookings/{booking}/finish', [BookingController::class, 'finish'])
            ->name('bookings.finish');


        Route::patch('/bookings/{booking}/no-show', [BookingController::class, 'noShow'])
            ->name('bookings.no-show');

        Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
            ->name('bookings.cancel');

        Route::patch('/bookings/{booking}/payment', [BookingController::class, 'payment'])
            ->name('bookings.payment');

        Route::patch(
            '/bookings/{booking}/service',
            [BookingController::class, 'updateService']
        )->name('bookings.update-service');

        Route::get('/booking_history', [HistoryBookingController::class, 'index'])
            ->name('history');

        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])
            ->name('bookings.destroy')->middleware(['subscription:booking','doctor']);

        Route::middleware(["doctorclinicsystemorassistant"])
            ->group(function (){


            // doctor.print-settings

                    // Route::get('/bookings/patients/search', [BookingController::class, 'searchPatients'])
                    // ->name('bookings.patients.search');

                    Route::get('/bookings/patients/search', [BookingController::class, 'searchPatients'])
                    ->name('bookings.patients.search');

                    Route::get('patient/{patient}/show', [PatientsController::class, 'show'])
                        ->name('patients.show');

                    Route::get('/patients', [PatientsController::class, 'index'])
                        ->name('patients');

                    Route::post('/create_patient', [PatientsController::class, 'store'])
                        ->name('patients.store');

                    Route::put('/patient/{patient}/update', [PatientsController::class, 'update'])
                        ->name('patients.update');

                    Route::middleware(["subscription:clinic_system","redirect_assistant"])
                            ->group(function (){

                            Route::delete('/patient/{patient}/destroy', [PatientsController::class, 'destroy'])
                                ->name('patient.destroy');

                            Route::resource('prescriptions', PrescriptionController::class)
                                ->only(['index', 'store', 'update', 'destroy']);



                    /*
                    |--------------------------------------------------------------------------
                    | VISITS
                    |--------------------------------------------------------------------------
                    | الأسماء الناتجة: clinic.visits.index | clinic.visits.store | clinic.visits.update | clinic.visit.destroy
                    */
                    Route::get('/visits', [VisitController::class, 'index'])
                        ->name('visits.index');

                    Route::post('/visits', [VisitController::class, 'store'])
                        ->name('visits.store');

                    Route::put('/visits/{visit}', [VisitController::class, 'update'])
                        ->name('visits.update');

                    Route::delete('/visit/{visit}', [VisitController::class, 'destroy'])
                        ->name('visit.destroy');

                    Route::post('/patients/{patient}/notes',
                    [PatientNoteController::class, 'store']
                    )->name('patient.notes.store');

                    Route::delete(
                        '/patient-notes/{patientNote}',
                        [PatientNoteController::class, 'destroy']
                    )->name('patient.notes.destroy');


                    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
                    Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
                    Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');


                    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

                    Route::resource("assistants",DoctorAssistantController::class)
                       ->except(['show','create','edit']);;
                    Route::patch('assistants/{assistant}/toggle-status', [DoctorAssistantController::class, 'toggleStatus'])
                        ->name('assistants.toggle-status');

    });
    });
      });
