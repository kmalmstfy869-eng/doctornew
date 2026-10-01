<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RejectedDoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $doctors = Doctor::with([
            'user',
            'area',
            'specialty',
            'subscription',
            'subscription.plan',
        ])
            ->Rejected()
            ->doctors()
            ->paginate(10);

            $expiredDoctors = Doctor::doctors()
                ->Rejected()
                ->whereHas('subscription', function ($query) {

                    $query
                        ->whereHas('plan', function ($query) {
                            $query->where('slug', '!=', 'free');
                        })
                        ->where(function ($query) {

                            $query->where('start_date', '>', now())
                                ->orWhere('end_date', '<', now())
                                ->orWhere('status', 'expired');

                        });

                })
                ->count();

            $unsubscribedDoctors = Doctor::doctors()
                ->Rejected()
                ->whereHas('subscription', function ($query) {

                    $query->whereHas('plan', function ($planQuery) {

                        $planQuery->where('slug', 'free');

                    });

                })
                ->count();

        return view(
            'admin.doctors.rejected_doctors',
            compact(
                'doctors',
                'expiredDoctors',
                'unsubscribedDoctors'
            )
        );}




    /**
     * Update the specified resource in storage.
     */
    public function restore(Request $request, Doctor $doctor)
    {

            $doctor->status = 'approved';
            $doctor->subscription->status="active";

            $doctor->save();

            return redirect()
                ->back()
                ->with(
                    'success',
                    'تم رجوع ظهور الدكتور في الموقع.'
                );
        }

    /**
     * Remove the specified resource from storage.
     */




        public function destroy(Doctor $rejected_doctor)
        {

            try {

                DB::transaction(function () use ($rejected_doctor) {

                    $user = $rejected_doctor->user;

                    $rejected_doctor->delete();

                    $user->delete();


                });

                return redirect()
                    ->back()
                    ->with(
                        'success',
                        'تم حذف الدكتور من الموقع نهائيًا'
                    );

            } catch (\Throwable $e) {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'فشل حذف الدكتور، حدث خطأ أثناء عملية الحذف'
                    );
            }
        }

}
