<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpecialtyRequest;
use App\Http\Requests\UpdateSpecialtyRequest;
use App\Models\Doctor;
use App\Models\Specialties;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{

   public function index()
{
    $specialties = Specialties::withCount('doctors')
        ->orderBy('sort_order', 'asc')
        ->latest()
        ->paginate(10);

    $totalDoctors = Doctor::count();

    $emptySpecialties = Specialties::doesntHave('doctors')->count();

    return view(
        'admin.specialties.index',
        compact(
            'specialties',
            'totalDoctors',
            'emptySpecialties'
        )
    );
}


    public function create()
    {
        return view('admin.specialties.create_specialty');
    }



    public function store(StoreSpecialtyRequest $request)
    {
    try {


        Specialties::create(
            $request->validated()
        );

        return redirect()
            ->route('admin.specialties.index')
            ->with(
                'success',
                'تم إضافة التخصص بنجاح.'
            );

    } catch (\Throwable $e) {

        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                'حدثت مشكلة أثناء إضافة التخصص، برجاء المحاولة مرة أخرى أو إخبارنا بالمشكلة.'
            );
    }


}



    /**
     * صفحة تعديل التخصص
     */
    public function edit(Specialties $specialty)
    {
        return view(
            'admin.specialties.edit_specialty',
            compact('specialty')
        );
    }


    /**
     * تحديث التخصص
     */
    public function update(
        UpdateSpecialtyRequest $request,
        Specialties $specialty
    ) {
        try {

            $specialty->update(
                $request->validated()
            );

            return redirect()
                ->route('admin.specialties.index')
                ->with(
                    'success',
                    'تم تعديل التخصص بنجاح.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'حدثت مشكلة أثناء تعديل التخصص، برجاء المحاولة مرة أخرى أو إخبارنا بالمشكلة.'
                );
        }
    }


    public function destroy(Specialties $specialty)
    {
        try {

            $specialty->delete();

            return redirect()
                ->back()
                ->with(
                    'success',
                    'تم حذف التخصص بنجاح.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                   'حدثت مشكلة أثناء حذف التخصص، لا يمكن حذف تخصص به اطباء '
                );
        }
    }
}
