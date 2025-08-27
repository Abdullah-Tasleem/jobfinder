<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    public function showForm($job)
    {
        // Load the job based on $jobId if needed
        $job = JobPost::findOrFail($job);

        // Pass $job or $jobId to the view
        return view('user.jobs.job_apply', compact('job'));
    }


    public function uploadResume(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $path = $request->file('file')->store('resumes', 'public');

        return response()->json(['path' => $path]);
    }

    public function submitApplication(Request $request, JobPost $job)
    {
        $request->validate([
            'resume_path' => 'required|string'
        ], [
            'resume_path.required' => 'Please upload your resume before submitting.'
        ]);

        JobApplication::create([
            'user_id' => Auth::id(),
            'job_id'  => $job->id,
            'resume' => $request->resume_path,
        ]);

        if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Application submitted successfully.']);
    }

        return redirect()->route('home')->with('success', 'Application submitted successfully.');
    }


    public function showAjax($id)
    {
        $job = JobPost::with('company')->findOrFail($id);
        $user = auth()->user();

        $alreadyApplied = false;
        $isSaved = false;

        if ($user && $user->type === 'user') {
            $alreadyApplied = JobApplication::where('user_id', $user->id)
                ->where('job_id', $job->id)
                ->exists();

            $isSaved = $user->savedJobs->contains($job->id);
        }

        return response()->json([
            'id' => $job->id,
            'title' => $job->job_title,
            'job_type' => $job->job_type,
            'job_location' => $job->job_location,
            'job_description' => $job->job_description,
            'salary_start' => $job->salary_start,
            'salary_end' => $job->salary_end,
            'country' => $job->company->country ?? '',
            'company_name' => $job->company->company_name ?? '',
            'company_website' => $job->company->company_website ?? '',
            'apply_url' => route('user.jobs.apply', ['job' => $job->id]),
            'is_authenticated' => auth()->check(),
            'already_applied' => $alreadyApplied,
            'is_saved' => $isSaved,
        ]);
    }

    public function toggleSave(JobPost $job)
    {
        $user = auth()->user();

        if ($user->savedJobs()->where('job_post_id', $job->id)->exists()) {
            $user->savedJobs()->detach($job->id);
            return response()->json(['status' => 'unsaved']);
        } else {
            $user->savedJobs()->attach($job->id);
            return response()->json(['status' => 'saved']);
        }
    }
    public function savedJobs()
    {
        $savedJobs = auth()->user()->savedJobs()->get();
        return view('user.jobs.saved', compact('savedJobs'));
    }
    public function appliedJobs()
    {
        $appliedJobs = JobApplication::with('jobPost.company')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('user.jobs.applied', compact('appliedJobs'));
    }
}
