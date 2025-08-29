<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $myJobs = JobPost::with('company')
            ->where('company_id', auth()->id())
            ->latest()
            ->get();

        $latestJob = JobPost::with('company')
            ->where('company_id', auth()->id())
            ->latest()
            ->first();

        return view('company.dashboard', compact('myJobs', 'latestJob'));
    }
}
