<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Doctor;
use Illuminate\Http\Request;



class AreaController extends Controller
{
    public function index(){
            $areas = Area::withCount('doctors')->latest()
            ->paginate(10);

        $totalDoctors = Doctor::count();

        $emptyArea = Area::doesntHave('doctors')->count();

        return view(
            'admin.areas.index',
            compact(
                'areas',
                'totalDoctors',
                'emptyArea'
            )
        );
    }

    public function create()
    {
        return view('admin.areas.create_area');
    }

 public function store(Request $request)
{
    $validated = $request->validate(
        [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:areas,slug',
            ],
        ],
        [
            'name.required' => 'من فضلك أدخل اسم المنطقة.',
            'name.string' => 'اسم المنطقة يجب أن يكون نصًا صحيحًا.',
            'name.max' => 'اسم المنطقة يجب ألا يتجاوز 255 حرفًا.',

            'slug.required' => 'من فضلك أدخل الرابط المختصر للمنطقة.',
            'slug.string' => 'الرابط المختصر يجب أن يكون نصًا صحيحًا.',
            'slug.max' => 'الرابط المختصر يجب ألا يتجاوز 255 حرفًا.',
            'slug.unique' => 'الرابط المختصر مستخدم بالفعل.',
        ]
    );

    Area::create($validated);

    return redirect()
        ->route('admin.areas.index')
        ->with('success', 'تمت إضافة المنطقة بنجاح.');
}


    public function edit(Area $area)
    {
        return view(
            'admin.areas.edit_area',
            compact('area')
        );
    }

    public function update(Request $request, Area $area)
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:areas,name,' . $area->id,
                ],

                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:areas,slug,' . $area->id,
                ],
            ],
            [
                'name.required' => 'اسم المنطقة مطلوب.',
                'name.string'   => 'اسم المنطقة يجب أن يكون نصًا.',
                'name.max'      => 'اسم المنطقة لا يجب أن يتجاوز 255 حرفًا.',
                'name.unique'   => 'اسم المنطقة موجود بالفعل.',

                'slug.required' => '  الرابط المختصر مطلوب',
                'slug.string'   => ' الرابط المختصر يجب أن يكون نصًا.',
                'slug.max'      => ' الرابط المختصر لا يجب أن يتجاوز 255 حرفًا.',
                'slug.unique'   => 'الرابط المختصر موجود بالفعل.',
            ]
        );

        $area->update($validated);

        return redirect()
            ->route('admin.areas.index')
            ->with('success', 'تم تعديل المنطقة بنجاح.');
    }

    public function destroy(Area $area)
    {
        try {

            $area->delete();

            return redirect()
                ->back()
                ->with(
                    'success',
                    'تم حذف المنطقة بنجاح.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                   'حدثت مشكلة أثناء حذف المنطقة لا يمكن حذف منطقة بها اطباء '
                );
        }
    }
}
