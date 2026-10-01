<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'is_admin'], only: ['index','destroy','update','edit']),
        ];
    }



    public function index(Request $request)
    {

        // البحث باسم المستخدم أو الطبيب
        $search = $request->input('search');


        /*
        |--------------------------------------------------------------------------
        | التقييمات
        |--------------------------------------------------------------------------
        */

        $reviews = Rating::with([
            'user',
            'doctor.user',
            'doctor.specialty',
        ])
            ->when($search, function ($query) use ($search) {

                $query->where(function ($query) use ($search) {


                    $query->whereHas('user', function ($query) use ($search) {

                        $query->where('name', 'like', "%{$search}%");

                    })


                    ->orWhereHas('doctor.user', function ($query) use ($search) {

                        $query->where('name', 'like', "%{$search}%");

                    })


                    ->orWhere('comment', 'like', "%{$search}%");
                });

            })
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view('admin.ratings.index', compact(
            'reviews',
            'search'
        ));
    }


    public function store(Request $request)
    {
        if (!Auth::check()) {
            return back()->with(
                'error',
                'يجب عليك تسجيل الدخول أولًا'
            );
        }



            $validated = $request->validate(
                [
                    'doctor_id' => ['required', 'exists:doctors,id'],
                    'rating'    => ['required', 'integer', 'between:1,5'],
                    'comment'   => ['required', 'string','max:300'],
                ],
                [
                    'doctor_id.required' => 'الطبيب مطلوب',
                    'doctor_id.exists'   => 'الطبيب غير موجود',

                    'rating.required' => 'من فضلك اختر تقييمًا للطبيب',
                    'rating.integer'  => 'التقييم يجب أن يكون رقمًا',
                    'rating.between'  => 'التقييم يجب أن يكون من 1 إلى 5 نجوم',

                    'comment.required' => 'من فضلك اكتب تجربتك مع الطبيب',
                    'comment.string'   => 'التعليق يجب أن يكون نصًا',
                    'comment.max'   => 'التعليق يجب أن يكون اقل من 300 حرف',
                ]
            );

            $doctor = Doctor::with('subscription')
                ->findOrFail($validated['doctor_id']);


            if (
                !$doctor->subscription) {
                    return back();
                    }


            $existingRating = Rating::where('user_id', Auth::id())
                ->where('doctor_id', $doctor->id)
                ->first();

            if ($existingRating) {
                return back()->with(
                    'error',
                    'أنت قمت بتقييم هذا الطبيب من قبل'
                );
            }

            Rating::create([
                'doctor_id' => $doctor->id,
                'user_id'   => Auth::id(),
                'rating'    => $validated['rating'],
                'comment'   => $validated['comment'],
                'status'    => 'approved',
            ]);

            return back()->with(
                'success',
                'تم إرسال تقييمك بنجاح ❤️'
            );

    }

    public function edit(Rating $rating){

            $review = $rating->load([
                'user',
                'doctor.user',
                'doctor.specialty',
            ]);

            return view("admin.ratings.edit_rating",compact("review"));
    }

    public function update(Request $request, Rating $rating)
    {


            $validated = $request->validate(
                [
                    'rating' => ['required','integer','between:1,5',],

                    'comment' => ['required','string','max:300'],

                    'status' => ['required','in:approved,rejected',],
                ],
                [
                    'rating.required' =>'من فضلك اختر تقييمًا للطبيب',

                    'rating.integer' =>'التقييم يجب أن يكون رقمًا',

                    'rating.between' =>'التقييم يجب أن يكون من 1 إلى 5 نجوم',

                    'comment.required' =>'من فضلك اكتب تعليق التقييم',

                    'comment.string' =>'التعليق يجب أن يكون نصًا',

                    'comment.max' =>'التعليق يجب أن يكون اقل من 300 حرف',

                    'status.required' =>'من فضلك اختر حالة التقييم',

                    'status.in' => 'حالة التقييم يجب أن تكون إما مقبول أو مرفوض',
                ]
            );

            $rating->update([
                'rating'  => $validated['rating'],
                'comment' => $validated['comment'],
                'status'  => $validated['status'],
            ]);

            return redirect()
                ->route('ratings.index')
                ->with('success', 'تم تعديل التقييم بنجاح ❤️');

    }
    public function destroy(Rating $rating){
        try{
            $rating->delete();
            return redirect()
                ->route('ratings.index')
                ->with('success', 'تم حذف التقييم بنجاح ❤️');

        } catch (\Exception $e) {

                    return back()
                        ->withInput()
                        ->with('error', 'حدث خطأ أثناء حذف التقييم، حاول مرة أخرى');
                }
        }
}
