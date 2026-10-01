<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\UpdateProfileRequest;
use App\Models\Doctor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Illuminate\Support\Facades\View;

class DoctorProfileController extends Controller
{
  use AuthorizesRequests;

    public function edit(
        Request $request,
    ) {
        /** @var \App\Models\Doctor $doctor */
        $doctor = View::shared('doctor');

        if ($doctor) {
            $doctor->loadMissing([
                'area',
                'rating',
            ]);
        }

        $specialties = DB::table('specialties')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $areas = DB::table('areas')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view(
            'doctor.dashboard.doctor_profile.edit',
            compact(
                'specialties',
                'areas'
            )
        );
    }

    public function update(UpdateProfileRequest $request)
    {

        $validated = $request->validated();
        $doctor = Auth::user()->doctor;
        $this->authorize('access', $doctor);


        $newFiles = [];

        $deletedFiles = [];

        try {

            DB::transaction(function () use (
                $request,
                $validated,
                $doctor,
                &$newFiles,
                &$deletedFiles,
            ) {

                /*
                |--------------------------------------------------------------------------
                | البيانات الأساسية
                |--------------------------------------------------------------------------
                */

                $doctor->user->update([
                    'name' => $validated['name'],
                ]);

                $doctor->specialty_id =
                    $validated['specialty_id'];

                $doctor->phone =
                    $validated['phone'];

                $doctor->whatsapp =
                    $validated['whatsapp'];

                $doctor->address =
                    $validated['address'];

                $doctor->consultation_price =
                    $validated['consultation_price'];

                $doctor->clinic_name =
                    $validated['clinic_name'];

                $doctor->working_hours =
                    $validated['working_hours'];

                $doctor->google_maps_url =
                    $validated['google_maps_url'] ?? null;

                $doctor->bio =
                    $validated['bio'];

                $doctor->services = json_decode(
                    $validated['services'],
                    true
                );

                /*
                |--------------------------------------------------------------------------
                | الصورة الشخصية
                |--------------------------------------------------------------------------
                |
                | نفس فكرة صور العيادة:
                |
                | 1. لو الصورة القديمة موجودة وتم حذفها من الواجهة
                |    يتم تسجيلها للحذف بعد نجاح الـTransaction.
                |
                | 2. لو تم اختيار صورة جديدة
                |    يتم استبدال القديمة بها.
                |
                | 3. الصورة القديمة لا يتم حذفها فعليًا
                |    إلا بعد نجاح الـTransaction.
                |
                */

                $oldDoctorImage =
                    $doctor->doctor_image;

                $deletedDoctorImage =
                    $validated['deleted_doctor_image'] ?? null;

                /*
                |--------------------------------------------------------------------------
                | الصورة القديمة تم تحديدها للحذف
                |--------------------------------------------------------------------------
                */

                if (
                    $deletedDoctorImage &&
                    $oldDoctorImage &&
                    $deletedDoctorImage === $oldDoctorImage
                ) {

                    $deletedFiles[] =
                        $oldDoctorImage;

                    $doctor->doctor_image = null;
                }

                /*
                |--------------------------------------------------------------------------
                | صورة شخصية جديدة
                |--------------------------------------------------------------------------
                */

                if ($request->hasFile('doctor_image')) {

                    $newDoctorImage = $request
                        ->file('doctor_image')
                        ->store(
                            'image_doctors',
                            'public'
                        );

                    /*
                    | تسجيل الصورة الجديدة
                    | حتى نحذفها لو حصل Exception
                    */

                    $newFiles[] =
                        $newDoctorImage;

                    /*
                    | لو فيه صورة قديمة
                    | والصورة الجديدة استبدلتها
                    | نسجل القديمة للحذف بعد نجاح الـTransaction.
                    */

                    if (
                        $oldDoctorImage &&
                        !in_array(
                            $oldDoctorImage,
                            $deletedFiles,
                            true
                        )
                    ) {

                        $deletedFiles[] =
                            $oldDoctorImage;
                    }

                    /*
                    | وضع الصورة الجديدة
                    */

                    $doctor->doctor_image =
                        $newDoctorImage;
                }

                /*
                |--------------------------------------------------------------------------
                | صور العيادة الحالية
                |--------------------------------------------------------------------------
                */

                $clinicImages =
                    $doctor->clinic_images ?? [];

                /*
                |--------------------------------------------------------------------------
                | الصور المطلوب حذفها
                |--------------------------------------------------------------------------
                */

                $deletedClinicImages =
                    json_decode(
                        $validated['deleted_clinic_images'],
                        true
                    );

                if (!is_array($deletedClinicImages)) {
                    $deletedClinicImages = [];
                }

                /*
                |--------------------------------------------------------------------------
                | حساب الصور بعد الحذف
                |--------------------------------------------------------------------------
                */

                $clinicImagesAfterDelete =
                    array_values(
                        array_diff(
                            $clinicImages,
                            $deletedClinicImages
                        )
                    );

                /*
                |--------------------------------------------------------------------------
                | الصور الجديدة
                |--------------------------------------------------------------------------
                */

                $newClinicImagesCount =
                    $request->hasFile('clinic_images')
                        ? count(
                            $request->file('clinic_images')
                        )
                        : 0;

                /*
                |--------------------------------------------------------------------------
                | التأكد أن الإجمالي لا يتجاوز 3 صور
                |--------------------------------------------------------------------------
                */

                $totalClinicImages =
                    count($clinicImagesAfterDelete)
                    + $newClinicImagesCount;

                if ($totalClinicImages > 3) {

                    throw new \RuntimeException(
                        'لا يمكن أن يتجاوز إجمالي صور العيادة 3 صور.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | حذف صور العيادة
                |--------------------------------------------------------------------------
                |
                | لا نحذف الملفات فعليًا الآن.
                | نحتفظ بها لحد ما الـTransaction تنجح.
                |
                */

                foreach ($deletedClinicImages as $clinicImage) {

                    if (
                        in_array(
                            $clinicImage,
                            $clinicImages,
                            true
                        )
                    ) {

                        $deletedFiles[] =
                            $clinicImage;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | إضافة صور العيادة الجديدة
                |--------------------------------------------------------------------------
                */

                if ($request->hasFile('clinic_images')) {

                    foreach (
                        $request->file('clinic_images')
                        as $image
                    ) {

                        $path = $image->store(
                            'clinic_images',
                            'public'
                        );

                        /*
                        | تسجيل الملف الجديد
                        */

                        $newFiles[] =
                            $path;

                        $clinicImagesAfterDelete[] =
                            $path;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | تحديث صور العيادة
                |--------------------------------------------------------------------------
                */

                $doctor->clinic_images =
                    array_values(
                        $clinicImagesAfterDelete
                    );

                /*
                |--------------------------------------------------------------------------
                | حفظ بيانات الطبيب
                |--------------------------------------------------------------------------
                */

                $doctor->save();
            });

            /*
            |--------------------------------------------------------------------------
            | الـTransaction نجحت
            |--------------------------------------------------------------------------
            |
            | دلوقتي فقط نحذف الملفات القديمة.
            |
            */

            foreach (
                array_unique($deletedFiles)
                as $file
            ) {

                Storage::disk('public')
                    ->delete($file);
            }

            /*
            |--------------------------------------------------------------------------
            | رسالة النجاح
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->back()
                ->with(
                    'success',
                    'تم تحديث بيانات الملف الطبي بنجاح.'
                );

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | تسجيل الخطأ في اللوج
            |--------------------------------------------------------------------------
            */

            report($e);

            /*
            |--------------------------------------------------------------------------
            | حصل خطأ
            |--------------------------------------------------------------------------
            |
            | نحذف أي ملفات جديدة تم تخزينها
            | أثناء العملية حتى لا تظل ملفات
            | بدون استخدام في Storage.
            |
            */

            foreach (
                array_unique($newFiles)
                as $file
            ) {

                Storage::disk('public')
                    ->delete($file);
            }

            /*
            |--------------------------------------------------------------------------
            | الرجوع للصفحة مع الخطأ
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $e instanceof \RuntimeException
                        ? $e->getMessage()
                        : 'حدث خطأ أثناء تحديث بيانات الملف الطبي. حاول مرة أخرى.'
                );
        }



}





        public function show(Request $request)
    {
        /** @var \App\Models\Doctor $doctor */
        $doctor = View::shared('doctor');

        $doctor->loadMissing(['rating','area']);

        $ratings = $doctor->rating()
            ->with('user')
            ->where('status', 'approved')
            ->latest()
            ->paginate(3);

        return view(
            'doctor.dashboard.doctor_profile.show',
            compact('ratings')
        );
    }

    }
