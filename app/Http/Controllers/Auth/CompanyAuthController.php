<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.company-register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'city'         => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'regex:/^[0-9]{11}$/'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'company_name'     => $request->company_name,
            'email'    => $request->email,
            'city'     => $request->city,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'type'     => 'company',
        ]);

        // Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }
}
