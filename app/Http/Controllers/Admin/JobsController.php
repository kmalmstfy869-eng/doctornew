<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $jobs = Job::with('user')
    ->orderByRaw("FIELD(status, 'approved', 'pending', 'rejected')")
    ->latest()
    ->paginate(10);

        return view('admin.jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function approve(Job $job)
    {
        $job->status = "approved";
        $job->save();

        return redirect()
            ->back()
            ->with('success', 'تم إضافة الوظيفة بنجاح.');
    }
    public function reject(Job $job)
    {
            $job->status = 'rejected';
        $job->save();

        return redirect()
            ->back()
            ->with('success', 'تم رفض طلب ظهور الوظيفة في الموقع.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        $job->load('user');

        return view('admin.jobs.job_show', compact('job'));
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return back()->with('success', 'تم حذف الوظيفة بنجاح.');
    }
}
