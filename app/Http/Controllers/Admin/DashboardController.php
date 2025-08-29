<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $allUsers   = User::count();
        $allJobs    = JobPost::count();
        $activeJobs = JobPost::where('job_status', 'active')->count();
        $companies  = User::where('type', 'company')->count();

        return view('admin.dashboard', compact('allUsers', 'allJobs', 'activeJobs', 'companies'));
    }
}
