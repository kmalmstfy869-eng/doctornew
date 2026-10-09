<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StorePatientFileRequest;
use App\Models\Patient;
use App\Models\PatientFile;
use App\Services\PatientFileService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class PatientFileController extends Controller
{
    // صفحة كل الملفات + Live Search بالاسم أو الهاتف. الـ pagination بيمنع تحميل كل الملفات مرة واحدة.
    public function index(Request $request, PatientFileService $service)
    {
        Gate::authorize('viewAny', PatientFile::class);

        $doctor = $request->user()->clinicDoctor();
        $search = trim((string) $request->input('search', ''));

        $files = PatientFile::query()
            ->select(['id', 'doctor_id', 'patient_id', 'original_name', 'mime_type', 'size', 'created_at'])
            ->forDoctor($doctor->id)
            ->with('patient:id,name,phone')
            ->when($search !== '', function ($q) use ($search, $doctor) {
                $like = '%' . addcslashes($search, '%_\\') . '%';

                $q->whereIn(
                    'patient_id',
                    Patient::query()
                        ->where('doctor_id', $doctor->id)
                        ->where(fn ($p) => $p->where('name', 'like', $like)->orWhere('phone', 'like', $like))
                        ->select('id')
                );
            })
            ->latest()
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $stats = $service->stats($doctor->id);

        return view('doctor.clinic.files.index', compact('files', 'search', 'stats'));
    }


    public function store(StorePatientFileRequest $request, PatientFileService $service): RedirectResponse
    {
        try {
            $doctor = $request->user()->clinicDoctor();

            // الراوت بيرجّع ID أو Model حسب الإعداد، فبنتعامل مع الحالتين.
            $routePatient = $request->route('patient');

            $patientId = $routePatient
                ? (int) ($routePatient->id ?? $routePatient)
                : $request->integer('patient_id');

            // حماية server-side: المريض لازم يكون تابع للدكتور الحالي حتى لو غيّر الـ ID في الـ URL.
            $patient = Patient::query()
                ->where('doctor_id', $doctor->id)
                ->findOrFail($patientId);

            $service->store($doctor->id, $patient->id, $request->file('file'));

            $target = $routePatient
                ? redirect()->route('clinic.patients.show', ['patient' => $patient->id, 'tab' => 'documents'])
                : redirect()->route('clinic.files.index');

            return $target->with('success', 'تم رفع الملف بنجاح.');
        } catch (ValidationException|ModelNotFoundException $e) {
            // أخطاء التحقق (المساحة/النوع) والمريض غير الموجود بتتعامل معاها لارافيل بالرسالة العربي.
            throw $e;
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'يوجد مشكلة أثناء رفع الملف ولم يتم حفظ أي شيء. حاول مرة أخرى، وإذا استمرت المشكلة تواصل معنا.');
        }
    }

    public function show(PatientFile $patientFile, PatientFileService $service): StreamedResponse
    {
        Gate::authorize('view', $patientFile);

        return $service->response($patientFile, false);
    }

    public function download(PatientFile $patientFile, PatientFileService $service): StreamedResponse
    {
        Gate::authorize('view', $patientFile);

        return $service->response($patientFile, true);
    }

    public function destroy(PatientFile $patientFile, PatientFileService $service): RedirectResponse
    {
        Gate::authorize('delete', $patientFile);

        try {
            $service->delete($patientFile);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'تعذر حذف الملف من التخزين، لم يتم حذف أي شيء. حاول مرة أخرى.');
        }

        return back()->with('success', 'تم حذف الملف.');
    }
}
