<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class NotificationController extends Controller
{
    /**
     * عرض الإشعارات
     */
 use AuthorizesRequests;
    public function index()
    {
        $doctor = View::shared('doctor');

        $notifications = $doctor->notifications()
            ->latest()
            ->paginate(15);

        return view('doctor.dashboard.notifications.index', compact(
            'notifications'
        ));
    }


    /**
     * قراءة الإشعار
     */
    public function markAsRead(int $notification)
    {
        $doctor = View::shared('doctor');

        $this->authorize('access', $doctor);

        $notification = $doctor->notifications()
            ->findOrFail($notification);

        $notification->update([
            'is_read' => true,
        ]);

        return redirect()->to(
            $notification->url
                ?? route('doctor.notifications.index')
        );
    }


    /**
     * حذف إشعار واحد
     */
    public function destroy( int $notification)
    {
        $doctor = View::shared('doctor');
        $this->authorize('access', $doctor);
        $notification = $doctor->notifications()
            ->findOrFail($notification);

        $notification->delete();

        return redirect()
            ->route('doctor.notifications.index')
            ->with('success', 'تم حذف الإشعار بنجاح.');
    }



    public function destroyAll()
    {
        $doctor = View::shared('doctor');
        $this->authorize('access', $doctor);
        $doctor->notifications()->delete();

        return redirect()
            ->route('doctor.notifications.index')
            ->with('success', 'تم حذف جميع الإشعارات بنجاح.');
    }
}
