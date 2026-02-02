<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Loan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        // Get active banks with their loans
        $banks = Bank::where('is_active', true)
            ->with(['branches.loans' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        // Get featured loans (latest active loans)
        $featuredLoans = Loan::where('is_active', true)
            ->with(['branch.bank'])
            ->latest()
            ->take(6)
            ->get();

        // Get all active loans for banners
        $bannerLoans = Loan::where('is_active', true)
            ->whereNotNull('banner')
            ->with(['branch.bank'])
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact('banks', 'featuredLoans', 'bannerLoans'));
    }

    /**
     * Search for loans.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        $loans = Loan::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('details1', 'like', '%' . $query . '%')
                    ->orWhereHas('branch.bank', function($subQuery) use ($query) {
                        $subQuery->where('name', 'like', '%' . $query . '%');
                    });
            })
            ->with(['branch.bank'])
            ->paginate(12);

        return view('search-results', compact('loans', 'query'));
    }

    /**
     * Display all loans with filters.
     */
    public function allLoans(Request $request)
    {
        $bankId = $request->input('bank');
        $loanName = $request->input('loan_name');

        // Get all active banks for filter dropdown
        $banks = Bank::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Build query
        $loansQuery = Loan::where('is_active', true)
            ->with(['branch.bank']);

        // Apply bank filter
        if ($bankId) {
            $loansQuery->whereHas('branch.bank', function($query) use ($bankId) {
                $query->where('id', $bankId);
            });
        }

        // Apply loan name filter
        if ($loanName) {
            $loansQuery->where('name', 'like', '%' . $loanName . '%');
        }

        $loans = $loansQuery->latest()->paginate(12);

        return view('all-loans', compact('loans', 'banks', 'bankId', 'loanName'));
    }

    /**
     * Display all banks.
     */
    public function allBanks()
    {
        $banks = Bank::where('is_active', true)
            ->withCount(['branches'])
            ->with(['branches.loans' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->paginate(12);

        return view('all-banks', compact('banks'));
    }

    /**
     * Display loan details.
     */
    public function show(Loan $loan)
    {
        // Load relationships
        $loan->load(['branch.bank']);

        return view('loan-details', compact('loan'));
    }
}
