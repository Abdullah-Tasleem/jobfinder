<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    // public function __construct()
    // {
    //     // ensure you have 'company' middleware defined
    //     $this->middleware(['auth', 'company']);
    // }

    public function index(Request $request)
    {
        $query = JobApplication::with(['user', 'jobPost'])
            ->whereHas('jobPost', function ($q) {
                $q->where('company_id', Auth::id());
            });

        // Optional filters: status and search
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('jobPost', function ($q3) use ($search) {
                    $q3->where('job_title', 'like', "%{$search}%");
                });
            });
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('company.job_applications.index', compact('applications'));
    }

    /**
     * Show single application (mark as seen).
     */
    public function show($id)
    {
        $application = JobApplication::with(['user', 'jobPost'])
            ->where('id', $id)
            ->whereHas('jobPost', function ($q) {
                $q->where('company_id', Auth::id());
            })->firstOrFail();

        // mark as seen
        if (!$application->is_seen) {
            $application->is_seen = true;
            $application->save();
        }

        return view('company.job_applications.show', compact('application'));
    }

    /**
     * Update application status (accept / reject / pending / seen).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,seen,accepted,rejected',
        ]);

        $application = JobApplication::where('id', $id)
            ->whereHas('jobPost', function ($q) {
                $q->where('company_id', Auth::id());
            })->firstOrFail();

        $application->status = $request->status;
        if ($request->status !== 'pending') {
            $application->is_seen = true;
        }
        $application->save();

        return redirect()->route('company.applications.show', $application->id)
            ->with('success', 'Application status updated successfully.');
    }

    /**
     * Delete an application (optional).
     */
    public function destroy($id)
    {
        $application = JobApplication::where('id', $id)
            ->whereHas('jobPost', function ($q) {
                $q->where('company_id', Auth::id());
            })->firstOrFail();

        $application->delete();

        return redirect()->route('company.applications.index')
            ->with('success', 'Application deleted.');
    }

    /**
     * Optional: download resume
     */
   public function downloadResume($id)
{
    $application = JobApplication::where('id', $id) 
        ->whereHas('jobPost', function ($q) {
            $q->where('company_id', Auth::id());
        })->firstOrFail();

    if (!$application->resume || !Storage::disk('public')->exists($application->resume)) {
        abort(404);
    }

    return Storage::disk('public')->download($application->resume);
}

}
