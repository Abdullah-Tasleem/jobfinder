<?php
// app/Http/Controllers/CompanyJobController.php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{


    // List jobs posted by logged-in company
    public function index()
    {
        $jobs = JobPost::with('industry')->where('company_id', Auth::id())->paginate(10);
        return view('company.jobs.index', compact('jobs'));
    }

    // Show form to create new job
    public function create()
    {
        $companies = User::where('type', 'company')->get();
        $skills = Skill::where('status', true)->pluck('name', 'id');
        $industries = Industry::all();
        return view('company.jobs.create', compact('companies', 'skills', 'industries'));
    }

    // Store new job
    public function store(Request $request)
    {
        $data = $request->validate([
            'job_title' => 'required|string|max:255',
            'job_status' => 'nullable|in:draft,pending,active,inactive,filled,expired,rejected',
            'job_type' => 'required|in:hybrid,on-site,remote',
            'salary_start' => 'nullable|integer|min:0',
            'salary_end' => 'nullable|integer|min:0|gte:salary_start',
            'job_description' => 'required|string',
            'job_location' => 'nullable|string|max:255',
            'job_start_time' => 'required|date_format:H:i',
            'job_end_time' => 'required|date_format:H:i',
            'job_skills' => 'nullable|array',
            'job_skills.*' => 'integer',
            'industry_id' => 'nullable|integer|exists:industries,id',
            'expires_at' => 'nullable|date|after_or_equal:today',
        ]);

        $data['company_id'] = Auth::id();
        JobPost::create($data);

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job created successfully.');
    }
    public function edit(JobPost $job)
    {
        $this->authorizeJob($job);

        $skills = Skill::where('status', true)->pluck('name', 'id');
        $industries = Industry::all();

        return view('company.jobs.edit', compact('job', 'skills', 'industries'));
    }

    public function update(Request $request, JobPost $job)
    {
        $this->authorizeJob($job);

        $data = $request->validate([
            'job_title' => 'required|string|max:255',
            'job_status' => 'nullable|in:draft,pending,active,inactive,filled,expired,rejected',
            'job_type' => 'required|in:hybrid,on-site,remote',
            'salary_start' => 'nullable|integer|min:0',
            'salary_end' => 'nullable|integer|min:0|gte:salary_start|required_with:salary_start',
            'job_description' => 'required|string|max:4000',
            'job_location' => 'nullable|string|max:255',
            'job_start_time' => 'required|date_format:H:i',
            'job_end_time' => 'required|date_format:H:i|after:job_start_time',
            'job_skills' => 'nullable|array',
            'job_skills.*' => 'integer',
            'industry_id' => 'nullable|integer|exists:industries,id',
            'expires_at' => 'nullable|date|after_or_equal:today',
        ]);

        // Update each field individually
        $job->job_title = $data['job_title'];
        $job->job_status = $data['job_status'] ?? $job->job_status;
        $job->job_type = $data['job_type'];
        $job->salary_start = $data['salary_start'] ?? $job->salary_start;
        $job->salary_end = $data['salary_end'] ?? $job->salary_end;
        $job->job_description = $data['job_description'];
        $job->job_location = $data['job_location'] ?? $job->job_location;
        $job->job_start_time = $data['job_start_time'];
        $job->job_end_time = $data['job_end_time'];
        $job->industry_id = $data['industry_id'] ?? $job->industry_id;
        $job->expires_at = $data['expires_at'] ?? $job->expires_at;

        // Handle job_skills separately
        if (!empty($data['job_skills'])) {
            $job->job_skills = $data['job_skills'];
        } else {
            $job->job_skills = null;
        }

        $job->save();

        return redirect()->route('company.jobs.index')->with('success', 'Job updated successfully.');
    }

    public function updateStatus(Request $request, JobPost $job)
    {
        $this->authorizeJob($job);

        $request->validate([
            'job_status' => 'required|in:draft,pending,active,inactive,filled,expired,rejected',
        ]);

        $job->update(['job_status' => $request->job_status]);

        return back()->with('success', 'Job status updated successfully.');
    }

    // Delete job
    // public function destroy(JobPost $job)
    // {
    //     $this->authorizeJob($job);

    //     $job->delete();

    //     return redirect()->route('company.jobs.index')->with('success', 'Job deleted successfully.');
    // }

    // Authorize that the logged-in company owns this job
    private function authorizeJob(JobPost $job)
    {
        if ($job->company_id !== Auth::id()) {
            abort(403);
        }
    }

    public function showAjax($id)
    {
        $job = JobPost::with('company')->findOrFail($id);
        $user = auth()->user();

        return response()->json([
            'id' => $job->id,
            'title' => $job->job_title,
            'company_name' => $job->company->company_name ?? '',
            'company_website' => $job->company->company_website ?? '',
            'country' => ucfirst($job->company->country ?? ''),
            'salary_start' => $job->salary_start ? number_format($job->salary_start) : null,
            'salary_end' => $job->salary_end ? number_format($job->salary_end) : null,
            'job_type' => $job->job_type,
            'job_location' => $job->job_location,
            'job_description' => $job->job_description,

            'apply_url' => route('user.jobs.apply', $job->id),
            'is_authenticated' => (bool) $user,
            'is_saved' => $user ? $user->savedJobs->contains($job->id) : false,
            'csrf_token' => csrf_token(),
        ]);
    }
}
