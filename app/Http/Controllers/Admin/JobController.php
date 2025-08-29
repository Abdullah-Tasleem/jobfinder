<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobPost::latest()->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function destroy(JobPost $job)
    {
        $job->delete();
        return back()->with('success', 'Job deleted');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'job_status' => 'required|in:draft,inactive,active,filled,expired',
        ]);

        $job = JobPost::findOrFail($id);
        $job->job_status = $request->job_status;
        $job->save();

        return redirect()->back()->with('success', 'Job status updated successfully.');
    }
}
