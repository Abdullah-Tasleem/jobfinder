<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industry;

class IndustryController extends Controller
{
    // Show all industries
    public function index()
    {
        $industries = Industry::paginate(10);
        return view('admin.industries.index', compact('industries'));
    }

    // Show form to create new industry
    public function create()
    {
        return view('admin.industries.create');
    }

    // Store new industry
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Industry::create([
            'name' => $request->name,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.industries.index')->with('success', 'Industry created successfully!');
    }

    // Show form to edit industry
    public function edit(Industry $industry)
    {
        return view('admin.industries.edit', compact('industry'));
    }

    // Update industry
    public function update(Request $request, Industry $industry)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $industry->update([
            'name' => $request->name,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.industries.index')->with('success', 'Industry updated successfully!');
    }

    // Delete industry
    public function destroy(Industry $industry)
    {
        $industry->delete();

        return redirect()->route('admin.industries.index')->with('success', 'Industry deleted successfully!');
    }
}
