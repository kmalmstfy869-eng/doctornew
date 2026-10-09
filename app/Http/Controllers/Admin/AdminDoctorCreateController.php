<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Plan;
use App\Models\Specialties;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctor;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\FinanceEntry;
class AdminDoctorCreateController extends Controller
{
    public function index(Request $request)
    {
        $specialties = Specialties::orderBy('sort_order')->get();

        $areas = Area::orderBy('name')->get();

        $plans = Plan::where('slug', '!=', 'free')
            ->orderBy('sort_order')
            ->get();

        $showSubscriptionForm = $request->boolean('subscribe');

        return view(
            'admin.doctors.add_doctor',
            compact(
                'specialties',
                'areas',
                'plans',
                'showSubscriptionForm'
            )
        );
    }


    public function store(StoreDoctorRequest $request)
    {
        try {

            $validated = $request->validated();


            $user = DB::transaction(function () use ($request, $validated) {

                /*
                |--------------------------------------------------------------------------
                | إنشاء المستخدم
                |--------------------------------------------------------------------------
                */

                $user = User::create([

                    'name' =>
                        $validated['name'],

                    'email' =>
                        $validated['email'],

                    'password' =>
                        Hash::make($validated['password']),

                    'role' =>
                        'doctor',
                ]);


                /*
                |--------------------------------------------------------------------------
                | إنشاء Image Manager
                |--------------------------------------------------------------------------
                */

                $manager = new ImageManager(
                    new Driver()
                );


                /*
                |--------------------------------------------------------------------------
                | صورة الطبيب
                |--------------------------------------------------------------------------
                */

                $doctorImage = null;

                if ($request->hasFile('doctor_image')) {

                    /*
                    |--------------------------------------------------------------------------
                    | إنشاء فولدر صور الأطباء لو مش موجود
                    |--------------------------------------------------------------------------
                    */

                    Storage::disk('public')
                        ->makeDirectory('image_doctors');

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

                    // حفظ الصورة WebP بجودة 80
                    $image->save(
                        storage_path(
                            'app/public/' . $doctorImage
                        ),
                        quality: 80
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | صور العيادة
                |--------------------------------------------------------------------------
                */

                $clinicImages = [];

                if ($request->hasFile('clinic_images')) {

                    /*
                    |--------------------------------------------------------------------------
                    | إنشاء فولدر صور العيادة لو مش موجود
                    |--------------------------------------------------------------------------
                    */

                    Storage::disk('public')
                        ->makeDirectory('clinic_images');

                    foreach (
                        $request->file('clinic_images') as $image
                    ) {

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

                        // حفظ الصورة WebP بجودة 80
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
                | إنشاء الطبيب
                |--------------------------------------------------------------------------
                */

                $doctor = Doctor::create([

                    'user_id' =>
                        $user->id,

                    'specialty_id' =>
                        $validated['specialty_id'],

                    'area_id' =>
                        $validated['area_id'],

                    'phone' =>
                        $validated['phone'],

                    'whatsapp' =>
                        $validated['whatsapp'],

                    'experience' =>
                        $validated['experience'],

                    'consultation_price' =>
                        $validated['consultation_price'],

                    'clinic_name' =>
                        $validated['clinic_name'],

                    'address' =>
                        $validated['address'],

                    'working_hours' =>
                        $validated['working_hours'],

                    'bio' =>
                        $validated['bio'],

                    'services' =>
                        $services,

                    'google_maps_url' =>
                        $validated['google_maps_url']
                        ?? null,

                    'doctor_image' =>
                        $doctorImage,

                    'clinic_images' =>
                        $clinicImages,

                    'status' =>
                        'approved',
                ]);


                /*
                |--------------------------------------------------------------------------
                | إنشاء الاشتراك لو تم اختياره
                |--------------------------------------------------------------------------
                */

                if (!empty($validated['plan_id'])) {

                    $plan = Plan::findOrFail(
                        $validated['plan_id']
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | منع الباقة المجانية
                    |--------------------------------------------------------------------------
                    */

                    if ($plan->slug === 'free') {

                        throw new \Exception(
                            'لا يمكن إضافة الباقة المجانية من هنا.'
                        );
                    }


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
                    | إنشاء الاشتراك
                    |--------------------------------------------------------------------------
                    */

                    Subscription::create([

                        'doctor_id' =>
                            $doctor->id,

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

                    ]);
                        FinanceEntry::create([
                            'type'       => 'income',
                            'category'   => 'subscription',
                            'title'      => 'اشتراك ' . $plan->name . ' - د. ' . $user->name,
                            'amount'     => $validated['price'],
                            'entry_date' => $startDate->toDateString(),
                            'note'       => 'من ' . $startDate->toDateString() . ' إلى ' . $endDate->toDateString(),
                            'created_by' => auth()->id(),
                        ]);
                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | الاشتراك المجاني الافتراضي
                    |--------------------------------------------------------------------------
                    */

                    $startDate = now();

                    Subscription::create([

                        'doctor_id' =>
                            $doctor->id,

                        'plan_id' =>
                            "1",

                        'start_date' =>
                            $startDate,

                        'end_date' =>
                            $startDate
                                ->copy()
                                ->addYears(10),

                        'price' =>
                            0,

                    ]);

                }

                return $user;
            });


            /*
            |--------------------------------------------------------------------------
            | إرسال رابط تأكيد البريد للدكتور
            |--------------------------------------------------------------------------
            */

            rescue(fn () => $user->sendEmailVerificationNotification());


            return redirect()
                ->route('admin.dashboard')
                ->with(
                    'success',
                    'تم إضافة الطبيب بنجاح، وتم إرسال رابط تأكيد البريد إليه.'
                );


        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                    ?: 'حدث خطأ أثناء إضافة الطبيب، حاول مرة أخرى.'
                );
        }
    }
}
