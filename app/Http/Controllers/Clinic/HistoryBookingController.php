<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryBookingController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today('Africa/Cairo')->toDateString();

               $user = Auth::user();
        $doctor =$user->clinicDoctor();

        $isClinicSystem = $doctor->hasFeature('clinic_system');
       $isAssistant =(bool) $user?->doctorAssistant;
        $filter = $request->input('booking_filter', 'today');

        $query = $doctor->bookings()
            ->whereIn('status', [
                'completed',
                'cancelled',
                'no_show',
            ]);

        /*
        |--------------------------------------------------------------------------
        | البحث
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                    ->orWhere('patient_phone', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | المصدر
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('source') &&
            in_array($request->source, ['online', 'clinic'], true)
        ) {
            $query->where('booking_type', $request->source);
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
                $query->whereDate('appointment_date', '>', $today);
                break;

            case 'past':
                $query->whereDate('appointment_date', '<', $today);
                break;

            case 'today':
                $query->whereDate('appointment_date', $today);
                break;

            case 'all':
                break;

            default:
                $filter = 'today';

                $query->whereDate('appointment_date', $today);
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | جلب الحجوزات
        |--------------------------------------------------------------------------
        */

        $bookings = $query
            ->orderByDesc('appointment_date')
            ->paginate(20)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | البيانات الثابتة
        |--------------------------------------------------------------------------
        */

        $statuses = [
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
            function ($booking, $index) use (
                $bookings,
                $statuses,
            ) {

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

                $booking->display_date = $booking->appointment_date
                    ? $booking->appointment_date
                        ->locale('ar')
                        ->translatedFormat('d F Y')
                    : '-';

                /*
                | الوقت
                */

                $booking->display_time = $booking->start_time
                    ? Carbon::parse(
                        $booking->start_time,
                        'Africa/Cairo'
                    )->format('g:i A')
                    : '-';

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
                'isAssistant'
            )
        );
    }
}
