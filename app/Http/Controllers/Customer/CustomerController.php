<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanApplication;

class CustomerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        // Application stats for dashboard
        $totalApplications = LoanApplication::where('customer_id', $user->id)->count();
        $approvedApplications = LoanApplication::where('customer_id', $user->id)->where('status', 'approved')->count();
        $rejectedApplications = LoanApplication::where('customer_id', $user->id)->where('status', 'rejected')->count();
        $pendingApplications = LoanApplication::where('customer_id', $user->id)->whereIn('status', ['pending', 'under_review'])->count();

        $recentApplications = LoanApplication::with(['loan.branch.bank'])
            ->where('customer_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact(
            'user',
            'totalApplications',
            'approvedApplications',
            'rejectedApplications',
            'pendingApplications',
            'recentApplications'
        ));
    }

    /**
     * Show customer profile.
     */
    public function profile()
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        return view('customer.profile', compact('user'));
    }

    /**
     * List customer's loan applications.
     */
    public function applications(Request $request)
    {
        $user = auth()->user();

        if (!$user || ($user->role ?? '') !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        $applications = LoanApplication::with(['loan.branch.bank'])
            ->where('customer_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('customer.applications', compact('applications'));
    }
}
