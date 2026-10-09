<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request, int $doctor): RedirectResponse
    {
        if (! Auth::check()) {

            return back()->with(
                'error',
                'سجّل دخولك أولًا لتتمكن من الرجوع إلى هذا الطبيب في أي وقت 🤍'
            );
            }

        $doctor = Doctor::active()->doctors()->find($doctor);

        if (! $doctor) {
            return back()->with(
                'error',
                'هذا الدكتور غير متاح حاليًا'
            );
        }

        $result = $request->user()->favoriteDoctors()->toggle($doctor->id);

        return back()->with(
            'success',
            count($result['attached']) > 0
                ? 'تمت إضافة الطبيب إلى المفضلة'
                : 'تمت إزالة الطبيب من المفضلة'
        );
    }
}
