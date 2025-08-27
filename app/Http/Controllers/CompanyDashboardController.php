<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $myJobs = JobPost::with('company')
            ->where('company_id', auth()->id())
            ->latest()
            ->get();

        $latestJob = JobPost::with('company')
            ->where('company_id', auth()->id())
            ->where('job_status', 'active')
            ->latest()
            ->first();

        return view('company.dashboard', compact('myJobs', 'latestJob'));
    }
}
