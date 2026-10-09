<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryBookingController extends Controller
{
    private const FILTERS = ['today', 'upcoming', 'past', 'cancelled', 'all'];

    private const SOURCES = ['online', 'clinic'];

    private const HISTORY_STATUSES = ['completed', 'cancelled', 'no_show'];

    private const UPCOMING_STATUSES = ['pending', 'confirmed'];

    private const SEARCH_MAX_LENGTH = 100;

    private const TIMEZONE = 'Africa/Cairo';

    public function index(Request $request)
    {
        $today = Carbon::today(self::TIMEZONE)->toDateString();

        /*
        |--------------------------------------------------------------------------
        | المستخدم والطبيب
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        abort_unless($user, 403);

        $doctor = $user->clinicDoctor();

        abort_unless($doctor, 403);

        $isClinicSystem = (bool) $doctor->hasFeature('clinic_system');
        $isAssistant = (bool) $user->doctorAssistant;

        /*
        |--------------------------------------------------------------------------
        | تنظيف المدخلات (أي قيمة غير نصية يتم تجاهلها)
        |--------------------------------------------------------------------------
        */

        $filter = $request->input('booking_filter');

        $filter = is_string($filter) && in_array($filter, self::FILTERS, true)
            ? $filter
            : 'today';

        $search = $request->input('search');

        $search = is_string($search)
            ? trim(mb_substr($search, 0, self::SEARCH_MAX_LENGTH))
            : '';

        $sourceInput = $request->input('source');

        $sourceFilter = is_string($sourceInput) && in_array($sourceInput, self::SOURCES, true)
            ? $sourceInput
            : null;

        $source = $sourceFilter ?? 'all';

        /*
        |--------------------------------------------------------------------------
        | الاستعلام (محصور على حجوزات الطبيب فقط)
        |--------------------------------------------------------------------------
        */

        $query = $doctor->bookings();

        /*
        |--------------------------------------------------------------------------
        | البحث
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $escaped = addcslashes($search, '%_\\');

            $query->where(function ($q) use ($escaped) {
                $q->where('patient_name', 'like', "%{$escaped}%")
                    ->orWhere('patient_phone', 'like', "%{$escaped}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | المصدر
        |--------------------------------------------------------------------------
        */

        if ($sourceFilter !== null) {
            $query->where('booking_type', $sourceFilter);
        }

        /*
        |--------------------------------------------------------------------------
        | فلترة التاريخ
        |--------------------------------------------------------------------------
        */

        switch ($filter) {

            case 'cancelled':
                $query->where('status', 'cancelled');
                break;

            case 'upcoming':
                // القادمة: حجوزات أونلاين (pending) أو من العيادة (confirmed) بتاريخ مستقبلي
                $query->whereIn('status', self::UPCOMING_STATUSES)
                    ->whereDate('appointment_date', '>', $today);
                break;

            case 'past':
                $query->whereIn('status', self::HISTORY_STATUSES)
                    ->whereDate('appointment_date', '<', $today);
                break;

            case 'all':
                $query->whereIn('status', self::HISTORY_STATUSES);
                break;

            case 'today':
            default:
                $query->whereIn('status', self::HISTORY_STATUSES)
                    ->whereDate('appointment_date', $today);
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | جلب الحجوزات (ترتيب ثابت لمنع تكرار/اختفاء النتائج بين الصفحات)
        |--------------------------------------------------------------------------
        */

        $bookings = $query
            ->orderByDesc('appointment_date')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | البيانات الثابتة
        |--------------------------------------------------------------------------
        */

        $statuses = [
            'pending' => [
                'label' => 'بانتظار التأكيد',
                'class' => 'badge-warning',
            ],

            'confirmed' => [
                'label' => 'مؤكد',
                'class' => 'badge-primary',
            ],

            'completed' => [
                'label' => 'تم الكشف',
                'class' => 'badge-success',
            ],

            'cancelled' => [
                'label' => 'ملغي',
                'class' => 'badge-danger',
            ],

            'no_show' => [
                'label' => 'لم يحضر',
                'class' => 'badge-danger',
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | تجهيز نتائج الصفحة الحالية فقط
        |--------------------------------------------------------------------------
        */

        $bookings->getCollection()->transform(
            function ($booking, $index) use ($bookings, $statuses) {

                /*
                | رقم الحجز
                */

                $booking->display_number = str_pad(
                    (($bookings->currentPage() - 1) * $bookings->perPage())
                        + $index
                        + 1,
                    2,
                    '0',
                    STR_PAD_LEFT
                );

                /*
                | الحالة
                */

                $status = $statuses[$booking->status] ?? [
                    'label' => $booking->status,
                    'class' => 'badge-muted',
                ];

                $booking->status_label = $status['label'];
                $booking->status_class = $status['class'];

                /*
                | التاريخ
                */

                $booking->display_date = $this->formatDate($booking->appointment_date);

                /*
                | الوقت (الموعد، وإلا وقت الوصول)
                */

                $booking->display_time = $this->formatTime(
                    $booking->start_time ?: $booking->arrived_at
                );

                /*
                | المصدر
                */

                $isOnline = $booking->booking_type === 'online';

                $booking->source_label = $isOnline
                    ? 'أونلاين'
                    : 'من العيادة';

                $booking->source_class = $isOnline
                    ? 'badge-primary'
                    : 'badge-purple';

                /*
                | الخدمة
                */

                $booking->service_label = $booking->service ?: 'لم تحدد';

                /*
                | الدفع
                */

                $price = (float) ($booking->price ?? 0);
                $paid = (float) ($booking->paid ?? 0);

                $booking->price_value = $price;
                $booking->paid_value = $paid;

                if ($price <= 0) {

                    $booking->payment_label = 'مجاني / بدون سعر';
                    $booking->payment_class = 'text-muted-foreground';

                } elseif ($paid <= 0) {

                    $booking->payment_label = 'غير مدفوع';
                    $booking->payment_class = 'text-muted-foreground';

                } elseif ($paid < $price) {

                    $booking->payment_label = 'مدفوع جزئيًا';
                    $booking->payment_class = 'text-warning';

                } else {

                    $booking->payment_label = 'مدفوع بالكامل';
                    $booking->payment_class = 'text-success';
                }

                /*
                | المبلغ المعروض
                */

                if ($price > 0) {

                    $booking->payment_amount =
                        number_format($paid, 0)
                        . ' / '
                        . number_format($price, 0)
                        . ' ج.م';

                } elseif ($paid > 0) {

                    $booking->payment_amount =
                        number_format($paid, 0)
                        . ' ج.م';

                } else {

                    $booking->payment_amount = null;
                }

                return $booking;
            }
        );

        return view(
            'doctor.clinic.booking.history',
            compact(
                'bookings',
                'isClinicSystem',
                'filter',
                'isAssistant',
                'search',
                'source'
            )
        );
    }

    private function formatDate($value): string
    {
        if (! $value) {
            return '-';
        }

        try {
            return Carbon::parse($value)
                ->locale('ar')
                ->translatedFormat('d F Y');
        } catch (\Throwable $e) {
            return '-';
        }
    }

    private function formatTime($value): string
    {
        if (! $value) {
            return '-';
        }

        try {
            $time = Carbon::parse($value, self::TIMEZONE);

            return $time->format('h:i') . ' ' . ($time->hour < 12 ? 'ص' : 'م');
        } catch (\Throwable $e) {
            return '-';
        }
    }
}
