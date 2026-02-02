<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchAdminController extends Controller
{
    /**
     * Display the branch admin dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $branch = $user->branch;
        $bank = $user->bank;

        return view('branch-admin.dashboard', compact('branch', 'bank'));
    }

    /**
     * Display a listing of the loans.
     */
    public function indexLoans()
    {
        $branchId = Auth::user()->branch_id;
        $loans = Loan::where('branch_id', $branchId)
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('branch-admin.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function createLoan()
    {
        return view('branch-admin.loans.create');
    }

    /**
     * Store a newly created loan in storage.
     */
    public function storeLoan(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'details1' => 'nullable|string',
            'details2' => 'nullable|string',
            'details3' => 'nullable|string',
            'details4' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'min_tenure_months' => 'nullable|integer|min:1',
            'max_tenure_months' => 'nullable|integer|min:1',
            'eligibility' => 'nullable|string',
            'documents_required' => 'nullable|string',
        ]);

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $bannerName = time() . '_loan_banner_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/loan-banners'), $bannerName);
            $validated['banner'] = 'uploads/loan-banners/' . $bannerName;
        }

        $validated['branch_id'] = Auth::user()->branch_id;
        $validated['is_active'] = $request->has('is_active');

        Loan::create($validated);

        return redirect()->route('branch-admin.loans.index')
                         ->with('success', 'Loan created successfully.');
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function editLoan(Loan $loan)
    {
        // Check if loan belongs to branch admin's branch
        if ($loan->branch_id !== Auth::user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('branch-admin.loans.edit', compact('loan'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function updateLoan(Request $request, Loan $loan)
    {
        // Check if loan belongs to branch admin's branch
        if ($loan->branch_id !== Auth::user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'details1' => 'nullable|string',
            'details2' => 'nullable|string',
            'details3' => 'nullable|string',
            'details4' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'min_tenure_months' => 'nullable|integer|min:1',
            'max_tenure_months' => 'nullable|integer|min:1',
            'eligibility' => 'nullable|string',
            'documents_required' => 'nullable|string',
        ]);

        // Handle banner upload
        if ($request->hasFile('banner')) {
            // Delete old banner if exists
            if ($loan->banner && file_exists(public_path($loan->banner))) {
                unlink(public_path($loan->banner));
            }

            $bannerName = time() . '_loan_banner_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/loan-banners'), $bannerName);
            $validated['banner'] = 'uploads/loan-banners/' . $bannerName;
        }

        $validated['is_active'] = $request->has('is_active');

        $loan->update($validated);

        return redirect()->route('branch-admin.loans.index')
                         ->with('success', 'Loan updated successfully.');
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroyLoan(Loan $loan)
    {
        // Check if loan belongs to branch admin's branch
        if ($loan->branch_id !== Auth::user()->branch_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete banner if exists
        if ($loan->banner && file_exists(public_path($loan->banner))) {
            unlink(public_path($loan->banner));
        }

        $loan->delete();

        return redirect()->route('branch-admin.loans.index')
                         ->with('success', 'Loan deleted successfully.');
    }
}
