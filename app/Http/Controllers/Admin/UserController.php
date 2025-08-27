<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->is_blocked = $user->is_blocked == 0 ? 1 : 0;
        $user->save();

        return back()->with('success', 'User status updated');
    }
}

