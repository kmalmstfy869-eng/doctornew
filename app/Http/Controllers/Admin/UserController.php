<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('jobs')
             ->where("role","user")
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->back()
            ->with('success', 'تم حذف المستخدم من الموقع.');
    }

    public function jobs(User $user)
    {
        $jobs = $user->jobs()
            ->with('user')
            ->orderByRaw("FIELD(status, 'approved', 'pending', 'rejected')")
            ->latest()
            ->paginate(10);

        return view('admin.jobs.index', compact('user', 'jobs'));
    }
}
