<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StorePatientRequest;
use App\Http\Requests\Doctor\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\PatientFileService;

class PatientsController extends Controller
{
    /**
     * عرض قائمة المرضى
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
            $user = Auth::user();
        $doctor =$user->clinicDoctor();

        $search = trim((string) $request->input('search', ''));

        $query = $doctor->patients()
            ->select([
                'id',
                'name',
                'phone',
                'birth_date',
                'gender',
                'created_at',
            ]);

        /*
        |--------------------------------------------------------------------------
        | البحث بالاسم أو الهاتف
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "{$search}%")
                    ->orWhere('phone', 'like', "{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $patients = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'doctor.clinic.patients.index',
            compact('patients')
        );
    }

    /**
     * إنشاء مريض جديد
     */
    public function store(StorePatientRequest $request)
    {
        /** @var \App\Models\User $user */
           $user = Auth::user();
        $doctor =$user->clinicDoctor();

        $doctor->patients()->create(
            $request->validated()
        );

        return redirect()
            ->route('clinic.patients')
            ->with('success', 'تم إنشاء ملف المريض بنجاح.');
    }

    /**
     * تعديل بيانات المريض
     */
    public function update(
        UpdatePatientRequest $request,
        Patient $patient
    ) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $doctor =$user->clinicDoctor();

        /*
        |--------------------------------------------------------------------------
        | التأكد أن المريض تابع للدكتور الحالي
        |--------------------------------------------------------------------------
        */

        if ((int) $patient->doctor_id !== (int) $doctor->id) {
            return redirect()
                ->route('clinic.patients')
                ->with(
                    'error',
                    'غير مصرح لك بالوصول إلى بيانات هذا المريض.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | تحديث بيانات المريض
        |--------------------------------------------------------------------------
        */

        $patient->update(
            $request->validated()
        );

        return redirect()
            ->route('clinic.patients')
            ->with(
                'success',
                'تم تحديث بيانات المريض بنجاح.'
            );
    }

    public function show(Patient $patient)
    {

 /** @var \App\Models\User $user */
        $user = Auth::user();
        $doctor =$user->clinicDoctor()->load('specialty');
        $isAssistant = (bool) $user?->doctorAssistant;

        if ((int) $patient->doctor_id !== (int) $doctor->id) {
            return redirect()
                ->route('clinic.patients')
                ->with(
                    'error',
                    'غير مصرح لك بالوصول إلى بيانات هذا المريض.'
                );
        }



        $visits = $patient->visits()
            ->where('doctor_id', $doctor->id)
            ->latest('visit_date')
            ->latest('id')
            ->paginate(
                5,
                ['*'],
                'visits_page'
            )
            ->withQueryString();



        $bookings = $patient->bookings()
            ->where('doctor_id', $doctor->id)
            ->latest('appointment_date')
            ->latest('start_time')
            ->latest('id')
            ->paginate(
                8,
                ['*'],
                'payments_page'
            )
            ->withQueryString();



        $prescriptions = Prescription::query()
            ->forDoctor($doctor->id)
            ->where('patient_id', $patient->id)
            ->latest('prescription_date')
            ->latest('id')
            ->paginate(
                5,
                ['*'],
                'prescriptions_page'
            )
            ->withQueryString();

        $notes = $patient->notes()
            ->where('doctor_id', $doctor->id)
            ->latest('created_at')
            ->latest('id')
            ->paginate(
                4,
                ['*'],
                'notes_page'
            )
            ->withQueryString();

        // ملفات المريض الطبية: بتتحمّل للطبيب بس والمساعد ممنوع منها. Pagination باسم مستقل عشان ما يتداخلش مع باقي التابات.
        $patientFiles = null;
        $fileStats = null;

        if (! $isAssistant) {
            $patientFiles = $patient->files()
                ->where('doctor_id', $doctor->id)
                ->select(['id', 'doctor_id', 'patient_id', 'original_name', 'mime_type', 'size', 'created_at'])
                ->latest()
                ->latest('id')
                ->paginate(6, ['*'], 'files_page')
                ->withQueryString();

            $fileStats = app(PatientFileService::class)->stats($doctor->id);
        }
/*
|--------------------------------------------------------------------------
| مدفوعات المريض
| الحجوزات المكتملة + الحركات اليدوية الخاصة بالمريض
|--------------------------------------------------------------------------
*/

$bookingPayments = DB::table('bookings')
    ->where('doctor_id', $doctor->id)
    ->where('patient_id', $patient->id)
    ->where('status', 'completed')
    ->selectRaw("
        'booking' as source,
        id as row_id,
        appointment_date as row_date,
        service as title,
        'income' as type,
        paid as amount,
        price as expected,
        NULL as notes
    ");


$manualPayments = DB::table('payments')
    ->where('doctor_id', $doctor->id)
    ->where('patient_id', $patient->id)
    ->selectRaw("
        'payment' as source,
        id as row_id,
        paid_at as row_date,
        title as title,
        type as type,
        amount as amount,
        NULL as expected,
        notes as notes
    ");


$payments = DB::query()
    ->fromSub(
        $bookingPayments->unionAll($manualPayments),
        'patient_payments'
    )
    ->orderByDesc('row_date')
    ->orderByDesc('row_id')
    ->paginate(
        8,
        ['*'],
        'payments_page'
    )
    ->withQueryString();


/*
|--------------------------------------------------------------------------
| إجمالي ما دفعه المريض
|--------------------------------------------------------------------------
*/

$bookingPaid = (float) DB::table('bookings')
    ->where('doctor_id', $doctor->id)
    ->where('patient_id', $patient->id)
    ->where('status', 'completed')
    ->sum('paid');


$manualPaid = (float) DB::table('payments')
    ->where('doctor_id', $doctor->id)
    ->where('patient_id', $patient->id)
    ->where('type', Payment::INCOME)
    ->sum('amount');


$totalPaid = $bookingPaid + $manualPaid;


        $patientAge = $patient->birth_date
            ? $patient->birth_date->age
            : null;

        return view(
            'doctor.clinic.patients.patient_details',
            compact(
                'doctor',
                'patient',
                'visits',
                'bookings',
                'payments',
                'prescriptions',
                'notes',
                'patientAge',
                'totalPaid',
                'isAssistant',
                'patientFiles',
                'fileStats',
            )
        );
    }

    /**
     * حذف المريض
     */
    public function destroy(Patient $patient)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $doctor = $user->doctor()->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | التأكد أن المريض تابع للدكتور الحالي
        |--------------------------------------------------------------------------
        */

        if (! $doctor->patients()->whereKey($patient->id)->exists()) {
            return back()
                ->with(
                    'error',
                    'هذا المريض لا ينتمي إلى حسابك.'
                );
        }

        try {

            DB::transaction(function () use ($patient) {


                $patient->delete();
            });

            return back()
                ->with(
                    'success',
                    'تم حذف المريض وجميع بياناته بنجاح.'
                );

        } catch (\Throwable $e) {

            return back()
                ->with(
                    'error',
                    'حدث خطأ أثناء حذف المريض.'
                );
        }
    }
}
