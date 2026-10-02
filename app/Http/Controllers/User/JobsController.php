<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJobRequest;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $page_job = true;

        $q = trim((string) $request->query('q'));

        $jobs = Job::with('user')
            ->active()
            ->when($q !== '', function ($query) use ($q) {
                $like = '%' . addcslashes($q, '%_\\') . '%';
                $query->where(function ($w) use ($like) {
                    $w->where('title', 'like', $like)
                    ->orWhere('company_name', 'like', $like)
                    ->orWhere('category', 'like', $like)
                    ->orWhere('location', 'like', $like);
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        if ($request->ajax()) {
            return response()
                ->json([
                    'html'  => view('home.jobs._grid', compact('jobs'))->render(),
                    'count' => $jobs->total(),
                ])
                ->header('Vary', 'X-Requested-With')
                ->header('Cache-Control', 'no-store');
        }

        $totaljobs = $jobs->total();

        return view('home.jobs.jobs', compact('jobs', 'page_job', 'totaljobs'));
    }

    public function create(){

        if (!Auth::check()) {
            return redirect()
                ->back()
                ->with('error', 'يجب عليك تسجيل الدخول أولًا 🤷‍♀️');
        }

        return view("home.jobs.create_jobs");
    }


    public function store(StoreJobRequest $request)
    {
        try {

            $data = $request->validated();

            $data['user_id'] = Auth::id();


            $data['status'] = 'pending';

            Job::create($data);

            return redirect()
                ->route('jobs.index')
                ->with(
                    'success',
                    'تم إضافة الوظيفة بنجاح، وسيتم مراجعتها من الإدارة قبل نشرها.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'حدثت مشكلة أثناء إضافة الوظيفة، برجاء المحاولة مرة أخرى أو إخبارنا بالمشكلة.'
                );
        }
    }





    public function show(Job $job)
    {
        $page_job = true;

        $job->load("user");

        return view(
            "home.jobs.jobs_details",
            compact("job", "page_job")
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
/** @var \App\Models\User $user */
        $user = Auth::user();
        $job = $user->jobs()->findOrFail($id);;

        return view('home.jobs.edit_job', compact('job'));
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(StoreJobRequest $request, string $id)
    {
        try {

/** @var \App\Models\User $user */

        $user = Auth::user();
        $job = $user->jobs()->findOrFail($id);


            $data = $request->validated();

            // أي تعديل على الوظيفة يرجعها للمراجعة
            $data['status'] = 'pending';

            $job->update($data);

            return redirect()
                ->route('profile')
                ->with(
                    'success',
                    'تم تعديل الوظيفة بنجاح، وسيتم مراجعة التعديلات من الإدارة قبل نشرها مرة أخرى.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'حدثت مشكلة أثناء تعديل الوظيفة، برجاء المحاولة مرة أخرى.'
                );
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

         /** @var \App\Models\User $user */

        $user = Auth::user();
        $job = $user->jobs()->findOrFail($id);

            $job->delete();

            return redirect()
                ->route('profile')
                ->with(
                    'success',
                    'تم حذف الوظيفة بنجاح.'
                );

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'حدثت مشكلة أثناء حذف الوظيفة، برجاء المحاولة مرة أخرى.'
                );
        }
    }
}
