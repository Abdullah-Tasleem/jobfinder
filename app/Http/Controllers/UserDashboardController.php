<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check if user is blocked
        if ($user->is_blocked) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has been blocked.');

        }
        $myJobs = JobPost::latest()->get();
        $latestJob = JobPost::where('job_status', 'active')->latest()->first();

        return view('user.dashboard', compact('myJobs', 'latestJob'));
    }
}
