<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BankAdminController extends Controller
{
    /**
     * Display the bank admin dashboard.
     */
    public function dashboard()
    {
        $bankId = Auth::user()->bank_id;
        $branches = Branch::where('bank_id', $bankId)->withCount('users')->get();
        return view('bank-admin.dashboard', compact('branches'));
    }

    /**
     * Show the form for creating a new branch.
     */
    public function createBranch()
    {
        return view('bank-admin.branches.create');
    }

    /**
     * Store a newly created branch in storage.
     */
    public function storeBranch(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        $validated['bank_id'] = Auth::user()->bank_id;

        Branch::create($validated);

        return redirect()->route('bank-admin.dashboard')->with('success', 'Branch created successfully.');
    }

    /**
     * Show the form for creating a new branch admin.
     */
    public function createBranchAdmin()
    {
        $bankId = Auth::user()->bank_id;
        $branches = Branch::where('bank_id', $bankId)->where('is_active', true)->get();
        return view('bank-admin.branch-admins.create', compact('branches'));
    }

    /**
     * Store a newly created branch admin in storage.
     */
    public function storeBranchAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Verify the branch belongs to the bank admin's bank
        $branch = Branch::findOrFail($validated['branch_id']);
        if ($branch->bank_id !== Auth::user()->bank_id) {
            return back()->withErrors(['branch_id' => 'Invalid branch selected.']);
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'branch_admin',
            'bank_id' => Auth::user()->bank_id,
            'branch_id' => $validated['branch_id'],
        ]);

        return redirect()->route('bank-admin.dashboard')->with('success', 'Branch Admin created successfully.');
    }

    /**
     * Display a listing of all branches.
     */
    public function listBranches()
    {
        $bankId = Auth::user()->bank_id;
        $branches = Branch::where('bank_id', $bankId)->withCount('users')->get();
        return view('bank-admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for editing a branch.
     */
    public function editBranch(Branch $branch)
    {
        // Verify the branch belongs to the bank admin's bank
        if ($branch->bank_id !== Auth::user()->bank_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('bank-admin.branches.edit', compact('branch'));
    }

    /**
     * Update the specified branch in storage.
     */
    public function updateBranch(Request $request, Branch $branch)
    {
        // Verify the branch belongs to the bank admin's bank
        if ($branch->bank_id !== Auth::user()->bank_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches,code,' . $branch->id,
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'is_active' => 'boolean',
        ]);

        $branch->update($validated);

        return redirect()->route('bank-admin.branches.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroyBranch(Branch $branch)
    {
        // Verify the branch belongs to the bank admin's bank
        if ($branch->bank_id !== Auth::user()->bank_id) {
            abort(403, 'Unauthorized action.');
        }

        $branch->delete();
        return redirect()->route('bank-admin.branches.index')->with('success', 'Branch deleted successfully.');
    }

    /**
     * Display a listing of all branch admins.
     */
    public function listBranchAdmins()
    {
        $bankId = Auth::user()->bank_id;
        $branchAdmins = User::with('branch')->where('role', 'branch_admin')->where('bank_id', $bankId)->get();
        return view('bank-admin.branch-admins.index', compact('branchAdmins'));
    }
}
