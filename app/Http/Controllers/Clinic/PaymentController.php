<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\PaymentRequest;
use App\Models\Payment;
use App\Services\Clinic\ClinicFinanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    private const BOOKING_DONE = ClinicFinanceService::BOOKING_DONE;

    public function __construct(protected ClinicFinanceService $finance) {}

    public function index(Request $request)
    {
        $doctor = Auth::user()->clinicDoctor();

        // ---------- الفلاتر ----------
        $from = $this->safeDate($request->query('from'), Carbon::create(2025, 1, 1));
        $to = $this->safeDate($request->query('to'), now('Africa/Cairo')->addWeek());

        if ($from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        $fromStr = $from->toDateString();
        $toStr = $to->toDateString();

        $q = trim((string) $request->query('q', ''));

        $type = $request->query('type');
        $type = in_array($type, ['income', 'expense', 'due'], true) ? $type : null;

        // ---------- الجدول (حجوزات + مدفوعات) ----------
        $rows = DB::query()
            ->fromSub($this->ledger($doctor->id, $fromStr, $toStr), 'ledger')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('patient_name', 'like', "%{$q}%")
                        ->orWhere('title', 'like', "%{$q}%");
                });
            })
            ->when(
                in_array($type, ['income', 'expense'], true),
                fn ($query) => $query->where('type', $type)
            )
            ->when(
                $type === 'due',
                fn ($query) => $query
                    ->where('source', 'booking')
                    ->whereColumn('expected', '>', 'amount')
            )
            ->orderByDesc('row_date')
            ->orderByDesc('row_id')
            ->paginate(15)
            ->withQueryString();

        // ---------- الكروت والرسم (من السيرفس) ----------
        $today = $this->finance->today($doctor->id);
        $period = $this->finance->totals($doctor->id, $fromStr, $toStr);
        $dues = $this->finance->dues($doctor->id);
        $chart = $this->finance->revenueLastSevenDays($doctor->id);

        $serviceNames = ['كشف', 'استشارة', 'متابعة', 'إعادة كشف', 'إجراء آخر'];

        return view('doctor.clinic.finances.index', [
            'rows' => $rows,
            'today' => $today,
            'period' => $period,
            'dues' => $dues,
            'chart' => $chart,
            'serviceNames' => $serviceNames,
            'from' => $fromStr,
            'to' => $toStr,
            'q' => $q,
            'type' => $type,
        ]);
    }

    public function store(PaymentRequest $request)
    {
        $doctor = Auth::user()->clinicDoctor();

        $data = $request->validated();

        $isPatient = $data['party'] === 'patient';

        if (
            $isPatient &&
            ! $doctor->patients()->whereKey($data['patient_id'])->exists()
        ) {
            throw ValidationException::withMessages([
                'patient_id' => 'المريض غير موجود أو لا يتبع هذا الطبيب.',
            ])->errorBag('payment');
        }

        Payment::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $isPatient ? $data['patient_id'] : null,
            'type' => $isPatient ? Payment::INCOME : $data['type'],
            'title' => $data['title'],
            'amount' => $data['amount'],
            'paid_at' => now(),
            'notes' => $data['notes'] ?? null,
        ]);

        return back()->with('success', 'تم تسجيل الحركة بنجاح.');
    }

    public function destroy(Request $request, Payment $payment)
    {
        abort_unless(
            $payment->doctor_id === $request->user()->clinicDoctor()->id,
            403
        );

        $payment->delete();

        return back()->with('success', 'تم حذف السجل.');
    }

    /* ===================================================================== */

    /**
     * كشف موحد: الحجوزات المكتملة + جدول المدفوعات.
     */
    private function ledger(int $doctorId, string $from, string $to)
    {
        $bookings = DB::table('bookings as b')
            ->leftJoin('patients as p', 'p.id', '=', 'b.patient_id')
            ->where('b.doctor_id', $doctorId)
            ->where('b.status', self::BOOKING_DONE)
            ->whereDate('b.appointment_date', '>=', $from)
            ->whereDate('b.appointment_date', '<=', $to)
            ->selectRaw("
                'booking' as source,
                b.id as row_id,
                b.appointment_date as row_date,
                b.patient_id as patient_id,
                COALESCE(p.name, b.patient_name) as patient_name,
                b.service as title,
                'income' as type,
                b.paid as amount,
                b.price as expected,
                NULL as notes
            ");

        $payments = DB::table('payments as py')
            ->leftJoin('patients as p', 'p.id', '=', 'py.patient_id')
            ->where('py.doctor_id', $doctorId)
            ->whereDate('py.paid_at', '>=', $from)
            ->whereDate('py.paid_at', '<=', $to)
            ->selectRaw("
                'payment' as source,
                py.id as row_id,
                py.paid_at as row_date,
                py.patient_id as patient_id,
                p.name as patient_name,
                py.title as title,
                py.type as type,
                py.amount as amount,
                NULL as expected,
                py.notes as notes
            ");

        return $bookings->unionAll($payments);
    }

    private function safeDate(?string $value, Carbon $fallback): Carbon
    {
        try {
            return $value
                ? Carbon::parse($value)->startOfDay()
                : $fallback->copy()->startOfDay();
        } catch (\Throwable) {
            return $fallback->copy()->startOfDay();
        }
    }
}
