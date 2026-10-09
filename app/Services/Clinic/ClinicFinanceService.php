<?php

namespace App\Services\Clinic;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClinicFinanceService
{
    public const BOOKING_DONE = 'completed';
    public const NOT_ACTUAL = ['pending', 'confirmed'];

    public function totals(int $doctorId, string $from, string $to): array
    {
        $bookingIncome = (float) DB::table('bookings')
            ->where('doctor_id', $doctorId)
            ->where('status', self::BOOKING_DONE)
            ->whereDate('appointment_date', '>=', $from)
            ->whereDate('appointment_date', '<=', $to)
            ->sum('paid');

        $pay = DB::table('payments')
            ->where('doctor_id', $doctorId)
            ->whereDate('paid_at', '>=', $from)
            ->whereDate('paid_at', '<=', $to)
            ->selectRaw("
                COALESCE(SUM(CASE WHEN type = 'income'  THEN amount END), 0) as income,
                COALESCE(SUM(CASE WHEN type = 'expense' THEN amount END), 0) as expense
            ")
            ->first();

        $income = $bookingIncome + (float) $pay->income;
        $expense = (float) $pay->expense;

        return ['income' => $income, 'expense' => $expense, 'net' => $income - $expense];
    }

    public function today(int $doctorId): array
    {
        $d = Carbon::today()->toDateString();

        return $this->totals($doctorId, $d, $d);
    }

    public function month(int $doctorId): array
    {
        return $this->totals(
            $doctorId,
            Carbon::today()->startOfMonth()->toDateString(),
            Carbon::today()->endOfMonth()->toDateString()
        );
    }

    public function dues(int $doctorId): object
    {
        return DB::table('bookings')
            ->where('doctor_id', $doctorId)
            ->where('status', self::BOOKING_DONE)
            ->whereColumn('price', '>', 'paid')
            ->selectRaw('COUNT(*) as c, COALESCE(SUM(price - paid), 0) as total')
            ->first();
    }

    public function revenueLastSevenDays(int $doctorId): array
    {
        $start = Carbon::today()->subDays(6);
        $end = Carbon::today();

        $fromBookings = DB::table('bookings')
            ->where('doctor_id', $doctorId)
            ->where('status', self::BOOKING_DONE)
            ->whereDate('appointment_date', '>=', $start->toDateString())
            ->whereDate('appointment_date', '<=', $end->toDateString())
            ->groupByRaw('DATE(appointment_date)')
            ->selectRaw('DATE(appointment_date) as d, SUM(paid) as s')
            ->pluck('s', 'd');

        $fromPayments = DB::table('payments')
            ->where('doctor_id', $doctorId)
            ->where('type', Payment::INCOME)
            ->whereDate('paid_at', '>=', $start->toDateString())
            ->whereDate('paid_at', '<=', $end->toDateString())
            ->groupByRaw('DATE(paid_at)')
            ->selectRaw('DATE(paid_at) as d, SUM(amount) as s')
            ->pluck('s', 'd');

        $days = collect(range(0, 6))->map(function ($i) use ($start, $fromBookings, $fromPayments) {
            $day = $start->copy()->addDays($i);
            $key = $day->toDateString();

            return [
                'label' => $day->translatedFormat('D'),
                'total' => (float) ($fromBookings[$key] ?? 0) + (float) ($fromPayments[$key] ?? 0),
            ];
        });

        $max = max(1, (float) $days->max('total'));

        return $days->map(fn ($d) => $d + ['height' => (int) round($d['total'] / $max * 100)])->all();
    }

    public function bookingsSplitLastSevenDays(int $doctorId): array
    {
        $start = Carbon::today()->subDays(6);

        $rows = DB::table('bookings')
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', '>=', $start->toDateString())
            ->whereDate('appointment_date', '<=', Carbon::today()->toDateString())
            ->whereNotIn('status', self::NOT_ACTUAL)
            ->groupByRaw('DATE(appointment_date)')
            ->selectRaw("
                DATE(appointment_date) as d,
                SUM(CASE WHEN booking_type = 'online' THEN 1 ELSE 0 END) as online,
                SUM(CASE WHEN booking_type != 'online' OR booking_type IS NULL THEN 1 ELSE 0 END) as clinic
            ")
            ->get()
            ->keyBy('d');

        $days = collect(range(0, 6))->map(function ($i) use ($start, $rows) {
            $day = $start->copy()->addDays($i);
            $r = $rows->get($day->toDateString());

            return [
                'label' => $day->translatedFormat('D'),
                'online' => (int) ($r->online ?? 0),
                'clinic' => (int) ($r->clinic ?? 0),
            ];
        });

        $max = max(1, $days->flatMap(fn ($d) => [$d['online'], $d['clinic']])->max());

        return $days->map(fn ($d) => $d + [
            'onlineHeight' => (int) round($d['online'] / $max * 100),
            'clinicHeight' => (int) round($d['clinic'] / $max * 100),
        ])->all();
    }
}
