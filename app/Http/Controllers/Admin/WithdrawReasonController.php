<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawReason;
use Illuminate\Http\Request;

class WithdrawReasonController extends Controller
{
    public function index()
    {
        $reasons = WithdrawReason::latest()->paginate(10);
        return view('admin.withdraw_reasons.index', compact('reasons'));
    }

    public function create()
    {
        return view('admin.withdraw_reasons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        WithdrawReason::create($request->all());

        return redirect()->route('admin.withdraw-reasons.index')->with('success', 'Reason created successfully.');
    }

    public function edit(WithdrawReason $withdrawReason)
    {
        return view('admin.withdraw_reasons.edit', compact('withdrawReason'));
    }

    public function update(Request $request, WithdrawReason $withdrawReason)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $withdrawReason->update($request->all());

        return redirect()->route('admin.withdraw-reasons.index')->with('success', 'Reason updated successfully.');
    }

    public function destroy(WithdrawReason $withdrawReason)
    {
        $withdrawReason->delete();
        return redirect()->route('admin.withdraw-reasons.index')->with('success', 'Reason deleted successfully.');
    }
}
