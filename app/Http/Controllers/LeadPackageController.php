<?php

namespace App\Http\Controllers;

use App\Models\LeadPackage;
use Illuminate\Http\Request;

class LeadPackageController extends Controller
{
    public function index()
    {
        $packages = LeadPackage::orderBy('created_at', 'desc')->paginate(10);

        return view('super-admin.lead-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('super-admin.lead-packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'number_of_leads' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        LeadPackage::create($validated);

        return redirect()->route('super-admin.lead-packages.index')
            ->with('success', 'Lead package created successfully.');
    }

    public function edit(LeadPackage $leadPackage)
    {
        return view('super-admin.lead-packages.edit', compact('leadPackage'));
    }

    public function update(Request $request, LeadPackage $leadPackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'number_of_leads' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $leadPackage->update($validated);

        return redirect()->route('super-admin.lead-packages.index')
            ->with('success', 'Lead package updated successfully.');
    }

    public function destroy(LeadPackage $leadPackage)
    {
        $leadPackage->delete();

        return redirect()->route('super-admin.lead-packages.index')
            ->with('success', 'Lead package deleted successfully.');
    }
}
