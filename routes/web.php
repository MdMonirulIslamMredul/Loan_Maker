<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\BankAdminController;
use App\Http\Controllers\BranchAdminController;
use App\Http\Controllers\LoanApplicationController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/all-loans', [HomeController::class, 'allLoans'])->name('loans.all');
Route::get('/all-banks', [HomeController::class, 'allBanks'])->name('banks.all');
Route::get('/loans/{loan}', [HomeController::class, 'show'])->name('loans.show');
Route::get('/loans/{loan}/apply', [LoanApplicationController::class, 'create'])->name('loans.apply');
Route::post('/loans/{loan}/apply', [LoanApplicationController::class, 'store'])->name('loans.apply.store');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Super Admin Routes
Route::middleware(['auth', 'super.admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('super-admin.dashboard');

    // Bank Management
    Route::get('/banks', [SuperAdminController::class, 'listBanks'])->name('super-admin.banks.index');
    Route::get('/banks/create', [SuperAdminController::class, 'createBank'])->name('super-admin.banks.create');
    Route::post('/banks', [SuperAdminController::class, 'storeBank'])->name('super-admin.banks.store');
    Route::get('/banks/{bank}/edit', [SuperAdminController::class, 'editBank'])->name('super-admin.banks.edit');
    Route::put('/banks/{bank}', [SuperAdminController::class, 'updateBank'])->name('super-admin.banks.update');
    Route::delete('/banks/{bank}', [SuperAdminController::class, 'destroyBank'])->name('super-admin.banks.destroy');

    // Bank Admin Management
    Route::get('/bank-admins', [SuperAdminController::class, 'listBankAdmins'])->name('super-admin.bank-admins.index');
    Route::get('/bank-admins/create', [SuperAdminController::class, 'createBankAdmin'])->name('super-admin.bank-admins.create');
    Route::post('/bank-admins', [SuperAdminController::class, 'storeBankAdmin'])->name('super-admin.bank-admins.store');
    Route::get('/bank-admins/{user}/edit', [SuperAdminController::class, 'editBankAdmin'])->name('super-admin.bank-admins.edit');
    Route::put('/bank-admins/{user}', [SuperAdminController::class, 'updateBankAdmin'])->name('super-admin.bank-admins.update');

    // Branch Management
    Route::get('/branches', [SuperAdminController::class, 'listBranches'])->name('super-admin.branches.index');
    Route::get('/branches/create', [SuperAdminController::class, 'createBranch'])->name('super-admin.branches.create');
    Route::post('/branches', [SuperAdminController::class, 'storeBranch'])->name('super-admin.branches.store');
    Route::get('/branches/{branch}/edit', [SuperAdminController::class, 'editBranch'])->name('super-admin.branches.edit');
    Route::put('/branches/{branch}', [SuperAdminController::class, 'updateBranch'])->name('super-admin.branches.update');
    Route::delete('/branches/{branch}', [SuperAdminController::class, 'destroyBranch'])->name('super-admin.branches.destroy');

    // Branch Admin Management
    Route::get('/branch-admins', [SuperAdminController::class, 'listBranchAdmins'])->name('super-admin.branch-admins.index');
    Route::get('/branch-admins/create', [SuperAdminController::class, 'createBranchAdmin'])->name('super-admin.branch-admins.create');
    Route::post('/branch-admins', [SuperAdminController::class, 'storeBranchAdmin'])->name('super-admin.branch-admins.store');
    Route::get('/branch-admins/{user}/edit', [SuperAdminController::class, 'editBranchAdmin'])->name('super-admin.branch-admins.edit');
    Route::put('/branch-admins/{user}', [SuperAdminController::class, 'updateBranchAdmin'])->name('super-admin.branch-admins.update');

    // Loan Management
    Route::get('/loans', [SuperAdminController::class, 'listLoans'])->name('super-admin.loans.index');
    Route::get('/loans/create', [SuperAdminController::class, 'createLoan'])->name('super-admin.loans.create');
    Route::post('/loans', [SuperAdminController::class, 'storeLoan'])->name('super-admin.loans.store');
    Route::get('/loans/{loan}/edit', [SuperAdminController::class, 'editLoan'])->name('super-admin.loans.edit');
    Route::put('/loans/{loan}', [SuperAdminController::class, 'updateLoan'])->name('super-admin.loans.update');
    Route::delete('/loans/{loan}', [SuperAdminController::class, 'destroyLoan'])->name('super-admin.loans.destroy');

    // Loan Applications Management
    Route::get('/applications', [LoanApplicationController::class, 'index'])->name('super-admin.applications.index');
    Route::get('/applications/{application}', [LoanApplicationController::class, 'show'])->name('super-admin.applications.show');
    Route::post('/applications/{application}/status', [LoanApplicationController::class, 'updateStatus'])->name('super-admin.applications.updateStatus');
});

// Bank Admin Routes
Route::middleware(['auth', 'bank.admin'])->prefix('bank-admin')->group(function () {
    Route::get('/dashboard', [BankAdminController::class, 'dashboard'])->name('bank-admin.dashboard');

    // Branch Management
    Route::get('/branches', [BankAdminController::class, 'listBranches'])->name('bank-admin.branches.index');
    Route::get('/branches/create', [BankAdminController::class, 'createBranch'])->name('bank-admin.branches.create');
    Route::post('/branches', [BankAdminController::class, 'storeBranch'])->name('bank-admin.branches.store');
    Route::get('/branches/{branch}/edit', [BankAdminController::class, 'editBranch'])->name('bank-admin.branches.edit');
    Route::put('/branches/{branch}', [BankAdminController::class, 'updateBranch'])->name('bank-admin.branches.update');
    Route::delete('/branches/{branch}', [BankAdminController::class, 'destroyBranch'])->name('bank-admin.branches.destroy');

    // Branch Admin Management
    Route::get('/branch-admins', [BankAdminController::class, 'listBranchAdmins'])->name('bank-admin.branch-admins.index');
    Route::get('/branch-admins/create', [BankAdminController::class, 'createBranchAdmin'])->name('bank-admin.branch-admins.create');
    Route::post('/branch-admins', [BankAdminController::class, 'storeBranchAdmin'])->name('bank-admin.branch-admins.store');
});

// Branch Admin Routes
Route::middleware(['auth', 'branch.admin'])->prefix('branch-admin')->group(function () {
    Route::get('/dashboard', [BranchAdminController::class, 'dashboard'])->name('branch-admin.dashboard');

    // Loan Management
    Route::get('/loans', [BranchAdminController::class, 'indexLoans'])->name('branch-admin.loans.index');
    Route::get('/loans/create', [BranchAdminController::class, 'createLoan'])->name('branch-admin.loans.create');
    Route::post('/loans', [BranchAdminController::class, 'storeLoan'])->name('branch-admin.loans.store');
    Route::get('/loans/{loan}/edit', [BranchAdminController::class, 'editLoan'])->name('branch-admin.loans.edit');
    Route::put('/loans/{loan}', [BranchAdminController::class, 'updateLoan'])->name('branch-admin.loans.update');
    Route::delete('/loans/{loan}', [BranchAdminController::class, 'destroyLoan'])->name('branch-admin.loans.destroy');

    // Loan Applications Management
    Route::get('/applications', [LoanApplicationController::class, 'branchApplications'])->name('branch-admin.applications.index');
    Route::get('/applications/{application}', [LoanApplicationController::class, 'branch_show'])->name('branch-admin.applications.show');
    Route::post('/applications/{application}/status', [LoanApplicationController::class, 'updateStatus'])->name('branch-admin.applications.updateStatus');
});
