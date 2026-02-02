<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Display the super admin dashboard.
     */
    public function dashboard()
    {
        $banks = Bank::withCount('branches', 'users')->get();
        return view('super-admin.dashboard', compact('banks'));
    }

    /**
     * Show the form for creating a new bank.
     */
    public function createBank()
    {
        return view('super-admin.banks.create');
    }

    /**
     * Store a newly created bank in storage.
     */
    public function storeBank(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:banks',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logoName = time() . '_logo_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('uploads/bank-logos'), $logoName);
            $validated['logo'] = 'uploads/bank-logos/' . $logoName;
        }

        if ($request->hasFile('banner')) {
            $bannerName = time() . '_banner_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/bank-banners'), $bannerName);
            $validated['banner'] = 'uploads/bank-banners/' . $bannerName;
        }

        Bank::create($validated);

        return redirect()->route('super-admin.dashboard')->with('success', 'Bank created successfully.');
    }

    /**
     * Show the form for creating a new bank admin.
     */
    public function createBankAdmin()
    {
        $banks = Bank::where('is_active', true)->get();
        return view('super-admin.bank-admins.create', compact('banks'));
    }

    /**
     * Store a newly created bank admin in storage.
     */
    public function storeBankAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'bank_id' => 'required|exists:banks,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'bank_admin',
            'bank_id' => $validated['bank_id'],
        ]);

        return redirect()->route('super-admin.dashboard')->with('success', 'Bank Admin created successfully.');
    }

    /**
     * Display a listing of all bank admins.
     */
    public function listBankAdmins()
    {
        $bankAdmins = User::with('bank')->where('role', 'bank_admin')->paginate(15);
        return view('super-admin.bank-admins.index', compact('bankAdmins'));
    }

    /**
     * Show the form for editing a bank admin.
     */
    public function editBankAdmin(User $user)
    {
        $banks = Bank::where('is_active', true)->get();
        return view('super-admin.bank-admins.edit', compact('user', 'banks'));
    }

    /**
     * Update the specified bank admin in storage.
     */
    public function updateBankAdmin(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'bank_id' => 'required|exists:banks,id',
            'is_active' => 'boolean',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->bank_id = $validated['bank_id'];
        $user->is_active = $request->has('is_active');

        // Only update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('super-admin.bank-admins.index')->with('success', 'Bank Admin updated successfully.');
    }

    /**
     * Display a listing of all banks.
     */
    public function listBanks()
    {
        $banks = Bank::withCount('branches', 'users')->get();
        return view('super-admin.banks.index', compact('banks'));
    }

    /**
     * Show the form for editing a bank.
     */
    public function editBank(Bank $bank)
    {
        return view('super-admin.banks.edit', compact('bank'));
    }

    /**
     * Update the specified bank in storage.
     */
    public function updateBank(Request $request, Bank $bank)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:banks,code,' . $bank->id,
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $logoName = time() . '_logo_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('uploads/bank-logos'), $logoName);
            $validated['logo'] = 'uploads/bank-logos/' . $logoName;
        }

        if ($request->hasFile('banner')) {
            $bannerName = time() . '_banner_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/bank-banners'), $bannerName);
            $validated['banner'] = 'uploads/bank-banners/' . $bannerName;
        }

        $bank->update($validated);

        return redirect()->route('super-admin.banks.index')->with('success', 'Bank updated successfully.');
    }

    /**
     * Remove the specified bank from storage.
     */
    public function destroyBank(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('super-admin.banks.index')->with('success', 'Bank deleted successfully.');
    }

    /**
     * Show the form for creating a new branch.
     */
    public function createBranch()
    {
        $banks = Bank::where('is_active', true)->get();
        return view('super-admin.branches.create', compact('banks'));
    }

    /**
     * Store a newly created branch in storage.
     */
    public function storeBranch(Request $request)
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        Branch::create($validated);

        return redirect()->route('super-admin.dashboard')->with('success', 'Branch created successfully.');
    }

    /**
     * Display a listing of all branches.
     */
    public function listBranches()
    {
        $branches = Branch::with('bank')->withCount('users')->get();
        return view('super-admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for editing a branch.
     */
    public function editBranch(Branch $branch)
    {
        $banks = Bank::where('is_active', true)->get();
        return view('super-admin.branches.edit', compact('branch', 'banks'));
    }

    /**
     * Update the specified branch in storage.
     */
    public function updateBranch(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
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

        return redirect()->route('super-admin.branches.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroyBranch(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('super-admin.branches.index')->with('success', 'Branch deleted successfully.');
    }

    /**
     * Show the form for creating a new branch admin.
     */
    public function createBranchAdmin()
    {
        $banks = Bank::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        return view('super-admin.branch-admins.create', compact('banks', 'branches'));
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

        // Get the bank_id from the selected branch
        $branch = Branch::findOrFail($validated['branch_id']);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'branch_admin',
            'bank_id' => $branch->bank_id,
            'branch_id' => $validated['branch_id'],
        ]);

        return redirect()->route('super-admin.dashboard')->with('success', 'Branch Admin created successfully.');
    }

    /**
     * Display a listing of all branch admins.
     */
    public function listBranchAdmins()
    {
        $branchAdmins = User::with('branch', 'bank')->where('role', 'branch_admin')->paginate(15);
        return view('super-admin.branch-admins.index', compact('branchAdmins'));
    }

    /**
     * Show the form for editing a branch admin.
     */
    public function editBranchAdmin(User $user)
    {
        $banks = Bank::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        return view('super-admin.branch-admins.edit', compact('user', 'banks', 'branches'));
    }

    /**
     * Update the specified branch admin in storage.
     */
    public function updateBranchAdmin(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'branch_id' => 'required|exists:branches,id',
            'is_active' => 'boolean',
        ]);

        // Get the bank_id from the selected branch
        $branch = Branch::findOrFail($validated['branch_id']);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->branch_id = $validated['branch_id'];
        $user->bank_id = $branch->bank_id;
        $user->is_active = $request->has('is_active');

        // Only update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('super-admin.branch-admins.index')->with('success', 'Branch Admin updated successfully.');
    }

    /**
     * Display a listing of all loans.
     */
    public function listLoans()
    {
        $loans = Loan::with('branch.bank')->orderBy('created_at', 'desc')->get();
        return view('super-admin.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function createLoan()
    {
        $branches = Branch::with('bank')->get();
        return view('super-admin.loans.create', compact('branches'));
    }

    /**
     * Store a newly created loan in storage.
     */
    public function storeLoan(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
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

        $validated['is_active'] = $request->has('is_active');

        Loan::create($validated);

        return redirect()->route('super-admin.loans.index')
                         ->with('success', 'Loan created successfully.');
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function editLoan(Loan $loan)
    {
        $branches = Branch::with('bank')->get();
        return view('super-admin.loans.edit', compact('loan', 'branches'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function updateLoan(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
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

        return redirect()->route('super-admin.loans.index')
                         ->with('success', 'Loan updated successfully.');
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroyLoan(Loan $loan)
    {
        // Delete banner if exists
        if ($loan->banner && file_exists(public_path($loan->banner))) {
            unlink(public_path($loan->banner));
        }

        $loan->delete();

        return redirect()->route('super-admin.loans.index')
                         ->with('success', 'Loan deleted successfully.');
    }
}
