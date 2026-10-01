<?php

namespace App\Http\Controllers\Admin;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Subscription;
use App\Models\Plan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Http\Requests\UpdateDoctor;
use App\Http\Requests\SubscribeDoctor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function edit(
        Request $request,
        Doctor $doctor
    ) {

        $doctor->load([
            'user',
            'specialty',
            'area',
            'subscription.plan',
        ]);

        $specialties = DB::table('specialties')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $areas = DB::table('areas')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $plans = Plan::where('slug', '!=', 'free')
            ->orderBy('sort_order')
            ->get();

        $showSubscriptionForm = $request->boolean('subscribe');

        $subscription = $doctor->subscription;

        /*
        |--------------------------------------------------------------------------
        | هل الاشتراك Free؟
        |--------------------------------------------------------------------------
        */

        $isFreeSubscription =
            $subscription
            && $subscription->plan
            && $subscription->plan->slug === 'free';

        /*
        |--------------------------------------------------------------------------
        | هل الطبيب مشترك حاليًا والاشتراك ساري؟
        |--------------------------------------------------------------------------
        */

        $isCurrentlySubscribed = Doctor::subscribed()
            ->whereKey($doctor->id)
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | هل لديه اشتراك سابق أو حالي غير Free؟
        |--------------------------------------------------------------------------
        */

        $hasPreviousSubscription =
            $subscription
            && !$isFreeSubscription;

        return view(
            'admin.doctors.edit_doctor',
            compact(
                'doctor',
                'plans',
                'specialties',
                'areas',
                'subscription',
                'showSubscriptionForm',
                'isFreeSubscription',
                'isCurrentlySubscribed',
                'hasPreviousSubscription'
            )
        );
    }


    public function update(
        UpdateDoctor $request,
        Doctor $doctor
    ) {
        $validated = $request->validated();

        DB::transaction(function () use (
            $request,
            $doctor,
            $validated
        ) {

            $doctor->user->update([
                'name' => $validated['name'],
            ]);

            $doctor->update([

                'specialty_id' =>
                    $validated['specialty_id'],

                'area_id' =>
                    $validated['area_id'],

                'phone' =>
                    $validated['phone'] ?? null,

                'whatsapp' =>
                    $validated['whatsapp'] ?? null,

                'experience' =>
                    $validated['experience'] ?? null,

                'consultation_price' =>
                    $validated['consultation_price'] ?? null,

                'clinic_name' =>
                    $validated['clinic_name'] ?? null,

                'address' =>
                    $validated['address'] ?? null,

                'working_hours' =>
                    $validated['working_hours'] ?? null,

                'bio' =>
                    $validated['bio'] ?? null,

                'services' =>
                    $validated['services'] ?? null,

                'google_maps_url' =>
                    $validated['google_maps_url'] ?? null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | صورة الطبيب
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('doctor_image')) {

                // حفظ مسار الصورة القديمة قبل استبدالها
                $oldDoctorImage = $doctor->doctor_image;

                /*
                |--------------------------------------------------------------------------
                | التأكد أن فولدر الصور موجود
                |--------------------------------------------------------------------------
                */

                Storage::disk('public')
                    ->makeDirectory('image_doctors');

                $manager = new ImageManager(
                    new Driver()
                );

                $image = $manager->decode(
                    $request
                        ->file('doctor_image')
                        ->getPathname()
                );

                // تصغير الصورة لو أبعادها أكبر من 2000px
                $image->scaleDown(
                    width: 2000
                );

                // اسم ومسار الصورة الجديدة
                $path =
                    'image_doctors/'
                    . uniqid()
                    . '.webp';

                // حفظها WebP بجودة 80
                $image->save(
                    storage_path(
                        'app/public/' . $path
                    ),
                    quality: 80
                );

                /*
                |--------------------------------------------------------------------------
                | تحديث قاعدة البيانات بالصورة الجديدة
                |--------------------------------------------------------------------------
                */

                $doctor->update([
                    'doctor_image' => $path,
                ]);

                /*
                |--------------------------------------------------------------------------
                | حذف الصورة القديمة بعد نجاح حفظ الجديدة
                |--------------------------------------------------------------------------
                */

                if (
                    !empty($oldDoctorImage)
                    && $oldDoctorImage !== $path
                ) {
                    Storage::disk('public')->delete(
                        $oldDoctorImage
                    );
                }
            }
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'تم تعديل بيانات الدكتور في الموقع.'
            );
    }


    public function subscribe(
        SubscribeDoctor $request,
        Doctor $doctor
    ) {

        $validated = $request->validated();


        /*
        |--------------------------------------------------------------------------
        | الباقة
        |--------------------------------------------------------------------------
        */

        $plan = Plan::findOrFail(
            $validated['plan_id']
        );


        /*
        |--------------------------------------------------------------------------
        | التأكد أن الباقة ليست مجانية
        |--------------------------------------------------------------------------
        */

        if ($plan->slug === 'free') {

            return back()
                ->withErrors([
                    'plan_id' =>
                        'لا يمكن إضافة الباقة المجانية من هنا.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | تنفيذ العملية داخل Transaction
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $validated,
            $plan,
            $doctor,
        ) {


            /*
            |--------------------------------------------------------------------------
            | تاريخ البداية
            |--------------------------------------------------------------------------
            */

            $startDate = Carbon::parse(
                $validated['start_date']
            );


            /*
            |--------------------------------------------------------------------------
            | تاريخ النهاية
            |--------------------------------------------------------------------------
            */

            $endDate = (clone $startDate)
                ->addDays($plan->duration);


            /*
            |--------------------------------------------------------------------------
            | الخدمات
            |--------------------------------------------------------------------------
            */

            $services = null;

            if (!empty($validated['services'])) {

                $services = collect(
                    preg_split(
                        '/\r\n|\r|\n/',
                        $validated['services']
                    )
                )
                    ->map(
                        fn ($service) =>
                            trim($service)
                    )
                    ->filter()
                    ->values()
                    ->toArray();
            }


            /*
            |--------------------------------------------------------------------------
            | صورة الطبيب
            |--------------------------------------------------------------------------
            */

            $doctorImage = $doctor->doctor_image;

            // الاحتفاظ بمسار الصورة القديمة
            $oldDoctorImage = $doctor->doctor_image;

            $newDoctorImageUploaded = false;

            if ($request->hasFile('doctor_image')) {

                /*
                |--------------------------------------------------------------------------
                | التأكد أن فولدر صور الأطباء موجود
                |--------------------------------------------------------------------------
                */

                Storage::disk('public')
                    ->makeDirectory('image_doctors');

                $manager = new ImageManager(
                    new Driver()
                );

                $image = $manager->decode(
                    $request
                        ->file('doctor_image')
                        ->getPathname()
                );

                // تصغير الصورة لو أبعادها أكبر من 2000px
                $image->scaleDown(
                    width: 2000
                );

                // اسم ومسار الصورة الجديدة
                $doctorImage =
                    'image_doctors/'
                    . uniqid()
                    . '.webp';

                // حفظها WebP بجودة 80
                $image->save(
                    storage_path(
                        'app/public/' . $doctorImage
                    ),
                    quality: 80
                );

                $newDoctorImageUploaded = true;
            }


            /*
            |--------------------------------------------------------------------------
            | صور العيادة
            |--------------------------------------------------------------------------
            */

            $clinicImages = $doctor->clinic_images ?? [];

            if ($request->hasFile('clinic_images')) {

                /*
                |--------------------------------------------------------------------------
                | التأكد أن فولدر صور العيادة موجود
                |--------------------------------------------------------------------------
                */

                Storage::disk('public')
                    ->makeDirectory('clinic_images');

                foreach (
                    $request->file('clinic_images') as $image
                ) {

                    $manager = new ImageManager(
                        new Driver()
                    );

                    $clinicImage = $manager->decode(
                        $image->getPathname()
                    );

                    // تصغير الصورة لو أبعادها أكبر من 2000px
                    $clinicImage->scaleDown(
                        width: 2000
                    );

                    // اسم ومسار الصورة الجديدة
                    $path =
                        'clinic_images/'
                        . uniqid()
                        . '.webp';

                    // حفظها WebP بجودة 80
                    $clinicImage->save(
                        storage_path(
                            'app/public/' . $path
                        ),
                        quality: 80
                    );

                    $clinicImages[] = $path;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | حذف صور العيادة المحددة
            |--------------------------------------------------------------------------
            */

            if ($request->filled('delete_clinic_images')) {

                foreach (
                    $request->delete_clinic_images
                    as $clinic_image
                ) {

                    Storage::disk('public')->delete(
                        $clinic_image
                    );

                    $key = array_search(
                        $clinic_image,
                        $clinicImages
                    );

                    if ($key !== false) {
                        unset($clinicImages[$key]);
                    }
                }

                $clinicImages =
                    array_values($clinicImages);
            }


            /*
            |--------------------------------------------------------------------------
            | تحديث بيانات الطبيب الخاصة بالاشتراك
            |--------------------------------------------------------------------------
            */

            $doctor->update([

                'doctor_image' =>
                    $doctorImage,

                'google_maps_url' =>
                    $validated['google_maps_url']
                    ?? null,

                'services' =>
                    $services,

                'clinic_images' =>
                    $clinicImages,
            ]);


            /*
            |--------------------------------------------------------------------------
            | حذف صورة الطبيب القديمة بعد نجاح تحديث قاعدة البيانات
            |--------------------------------------------------------------------------
            */

            if (
                $newDoctorImageUploaded
                && !empty($oldDoctorImage)
                && $oldDoctorImage !== $doctorImage
            ) {
                Storage::disk('public')->delete(
                    $oldDoctorImage
                );
            }


            /*
            |--------------------------------------------------------------------------
            | إنشاء / تحديث الاشتراك
            |--------------------------------------------------------------------------
            */

            Subscription::updateOrCreate(

                [
                    'doctor_id' =>
                        $doctor->id,
                ],

                [
                    'plan_id' =>
                        $plan->id,

                    'start_date' =>
                        $startDate,

                    'end_date' =>
                        $endDate,

                    'price' =>
                        $validated['price'],

                    'status' =>
                        'active',
                ]
            );
        });


        /*
        |--------------------------------------------------------------------------
        | العودة لصفحة الطبيب
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->back()
            ->with(
                'success',
                'تم حفظ بيانات الاشتراك بنجاح.'
            );
    }


    public function cancelSubscription(
        Doctor $doctor
    ) {

        $subscription =
            $doctor->subscription;

        if (!$subscription) {

            return back()
                ->withErrors([
                    'subscription' =>
                        'الطبيب لا يملك اشتراكًا.',
                ]);
        }


        $subscription->status = "expired";

        $subscription->save();

        return redirect()
            ->route('admin.doctor.edit', [
                'doctor' => $doctor->id,
            ])
            ->with(
                'success',
                'تم حذف اشتراك الدكتور في الموقع.'
            );
    }


    public function deleteImage(
        Doctor $doctor
    ) {

        if ($doctor->doctor_image) {

            Storage::disk('public')->delete(
                $doctor->doctor_image
            );

            $doctor->update([
                'doctor_image' => null,
            ]);
        }

        return back()->with(
            'success',
            'تم حذف صورة الطبيب بنجاح.'
        );
    }


    public function destroy(
        Doctor $doctor
    ) {

        $doctor->status = 'rejected';

        $doctor->subscription->status = "expired";

        $doctor->save();

        return redirect()
            ->back()
            ->with(
                'success',
                'تم حذف ظهور الدكتور في الموقع.'
            );
    }
}

