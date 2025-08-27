<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;

class JobSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPost::with('company')
            ->where('job_status', 'active'); // sirf active jobs

        if ($kw = trim($request->get('keyword', ''))) {
            $query->where(function ($q) use ($kw) {
                $q->where('job_title', 'like', "%{$kw}%")
                    ->orWhere('job_description', 'like', "%{$kw}%")
                    ->orWhereHas('company', function ($qq) use ($kw) {
                        $qq->where('company_name', 'like', "%{$kw}%");
                    });
            });
        }

        if ($loc = trim($request->get('location', ''))) {
            $query->where('job_location', 'like', "%{$loc}%");
        }

        $jobs = $query->latest()->take(50)->get();

        // AJAX request: sirf list ka partial bhej do
        if ($request->ajax()) {
            return view('partials.jobs_list', compact('jobs'))->render();
        }

        return view('jobs.search', compact('jobs'));
    }
}
