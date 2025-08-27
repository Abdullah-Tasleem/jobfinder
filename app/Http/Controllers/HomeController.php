<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            // Job seeker: show all active jobs
            $jobs = JobPost::with('company')
                ->where('job_status', 'active')
                ->latest()
                ->take(10)
                ->get();

            $latestJob = JobPost::with('company')
                ->where('job_status', 'active')
                ->latest()
                ->first();
        } else {
            $jobs = collect();
            $latestJob = null;
        }

        return view('home', compact('jobs', 'latestJob'));
    }
}
