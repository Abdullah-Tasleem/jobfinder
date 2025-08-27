<?php

use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\CompanyAuthController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Contracts\Provider;

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search-jobs', [JobSearchController::class, 'index'])->name('jobs.search');

Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect']);

Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback']);

// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// User Dashboard
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth', 'user'])->name('user.dashboard');

// Company Dashboard
Route::get('/company/dashboard', [CompanyDashboardController::class, 'index'])->middleware(['auth', 'company'])->name('company.dashboard');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/register/company', [CompanyAuthController::class, 'showRegisterForm'])->name('company.registerform');
Route::post('/register/company', [CompanyAuthController::class, 'register'])->name('company.register');

// ---Company Routes---
Route::get('company/jobs', [JobPostController::class, 'index'])->name('company.jobs.index')->middleware(['auth', 'company']);
Route::get('company/jobs/create', [JobPostController::class, 'create'])->name('company.jobs.create')->middleware(['auth', 'company']);
Route::post('company/jobs', [JobPostController::class, 'store'])->name('company.jobs.store')->middleware(['auth', 'company']);
Route::get('company/jobs/{job}/edit', [JobPostController::class, 'edit'])->name('company.jobs.edit')->middleware(['auth', 'company']);
Route::put('company/jobs/{job}', [JobPostController::class, 'update'])->name('company.jobs.update')->middleware(['auth', 'company']);
Route::patch('company/jobs/{job}/status', [JobPostController::class, 'updateStatus'])->name('company.jobs.updateStatus')->middleware(['auth', 'company']);
Route::delete('company/jobs/{job}', [JobPostController::class, 'destroy'])->name('company.jobs.destroy')->middleware(['auth', 'company']);
Route::get('company/jobs/{id}/ajax', [JobPostController::class, 'showAjax'])->name('company.jobs.showAjax')->middleware(['auth', 'company']);

//  ---User Routes--
Route::get('/company/jobs/{id}/ajax', [JobApplicationController::class, 'showAjax']);
Route::post('/jobs/{job}/save', [JobApplicationController::class, 'toggleSave'])->name('jobs.save')->middleware(['auth', 'user']);
Route::get('user/saved-jobs', [JobApplicationController::class, 'savedJobs'])->name('saved.jobs')->middleware(['auth', 'user']);
Route::get('user/applied-jobs', [JobApplicationController::class, 'appliedJobs'])->name('applied.jobs')->middleware(['auth', 'user']);
Route::get('user/jobs/{job}/apply', [JobApplicationController::class, 'showForm'])->name('user.jobs.apply')->middleware(['auth', 'user']);
Route::post('user/jobs/upload-resume', [JobApplicationController::class, 'uploadResume'])->name('user.jobs.upload.resume')->middleware(['auth', 'user']);
Route::post('user/jobs/apply/{job}', [JobApplicationController::class, 'submitApplication'])->name('user.jobs.submit.application')->middleware(['auth', 'user']);


//  ---Admin Routes--
// Industries Routes
Route::get('admin/industries', [IndustryController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.industries.index');
Route::get('admin/industries/create', [IndustryController::class, 'create'])->middleware(['auth', 'admin'])->name('admin.industries.create');
Route::post('admin/industries', [IndustryController::class, 'store'])->middleware(['auth', 'admin'])->name('admin.industries.store');
Route::get('admin/industries/{industry}/edit', [IndustryController::class, 'edit'])->middleware(['auth', 'admin'])->name('admin.industries.edit');
Route::put('admin/industries/{industry}', [IndustryController::class, 'update'])->middleware(['auth', 'admin'])->name('admin.industries.update');
Route::delete('admin/industries/{industry}', [IndustryController::class, 'destroy'])->middleware(['auth', 'admin'])->name('admin.industries.destroy');

// Users
Route::get('admin/users', [UserController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.users.index');
Route::patch('admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->middleware(['auth', 'admin'])->name('admin.users.toggleStatus');

// Jobs
Route::get('admin/jobs', [JobController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.jobs.index');
Route::patch('admin/jobs/{job}/toggle-status', [JobController::class, 'toggleStatus'])->middleware(['auth', 'admin'])->name('admin.jobs.toggleStatus');
Route::delete('admin/jobs/{job}', [JobController::class, 'destroy'])->middleware(['auth', 'admin'])->name('admin.jobs.destroy');

require __DIR__ . '/auth.php';
