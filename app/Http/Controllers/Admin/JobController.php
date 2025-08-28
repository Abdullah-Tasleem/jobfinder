<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobPost;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobPost::latest()->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function toggleStatus(JobPost $job)
    {
        $job->job_status = $job->job_status == 'active' ? 'inactive' : 'active';
        $job->save();

        return back()->with('success', 'Job status updated');
    }

    public function destroy(JobPost $job)
    {
        $job->delete();
        return back()->with('success', 'Job deleted');
    }
}
