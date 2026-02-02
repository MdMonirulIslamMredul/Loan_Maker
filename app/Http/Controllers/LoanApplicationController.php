<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanApplication;
use Illuminate\Http\Request;

class LoanApplicationController extends Controller
{
    /**
     * Show the application form for a loan.
     */
    public function create(Loan $loan)
    {
        $loan->load(['branch.bank']);
        return view('loan-application-form', compact('loan'));
    }

    /**
     * Store a new loan application.
     */
    public function store(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'nid_number' => 'required|string|max:50',
            'present_address' => 'required|string',
            'permanent_address' => 'nullable|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|string|max:255',
            'loan_amount' => 'required|numeric|min:0',
            'tenure_months' => 'required|integer|min:1',
            'employment_type' => 'required|in:employed,self-employed,business,professional,student',
            'company_name' => 'nullable|string|max:255',
            'purpose_of_loan' => 'required|string',
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        // Handle document uploads
        $documentPaths = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $document) {
                $path = $document->store('loan-applications', 'public');
                $documentPaths[] = $path;
            }
        }

        $validated['loan_id'] = $loan->id;
        $validated['documents'] = $documentPaths;
        $validated['status'] = 'pending';

        LoanApplication::create($validated);

        return redirect()->route('loans.show', $loan)->with('success', 'Your loan application has been submitted successfully! We will contact you soon.');
    }

    /**
     * Display all loan applications (for super admin).
     */
    public function index(Request $request)
    {
        $query = LoanApplication::with(['loan.branch.bank'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by loan name
        if ($request->filled('loan_name')) {
            $query->whereHas('loan', function ($q) use ($request) {
                $q->where('loan_name', 'like', '%' . $request->loan_name . '%');
            });
        }

        $applications = $query->paginate(15);

        return view('super-admin.applications.index', compact('applications'));
    }

    /**
     * Display loan applications for a specific branch (for branch admin).
     */
    public function branchApplications(Request $request)
    {
        $branchId = auth()->user()->branch_id;

        $query = LoanApplication::with(['loan.branch.bank'])
            ->whereHas('loan', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            })
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(15);

        return view('branch-admin.applications.index', compact('applications'));
    }

    public function branch_show(LoanApplication $application)
    {
        $application->load(['loan.branch.bank']);
        return view('branch-admin.applications.show', compact('application'));
    }

    /**
     * Display a single loan application.
     */
    public function show(LoanApplication $application)
    {
        $application->load(['loan.branch.bank']);
        return view('super-admin.applications.show', compact('application'));
    }

    /**
     * Update application status.
     */
    public function updateStatus(Request $request, LoanApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }
}

