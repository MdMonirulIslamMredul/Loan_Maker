<?php

namespace App\Http\Controllers;

use App\Models\PackageOrder;
use App\Models\LeadPackage;
use App\Models\User;
use App\Models\Bank;
use App\Models\Branch;
use Illuminate\Http\Request;

class PackageOrderController extends Controller
{
    // Super-admin: view orders
    public function index(Request $request)
    {
        $query = PackageOrder::with(['user', 'leadPackage']);

        // Filter by package
        if ($request->filled('package_id')) {
            $query->where('lead_package_id', $request->package_id);
        }

        // Filter by bank (via user)
        if ($request->filled('bank_id')) {
            $bankId = $request->bank_id;
            $query->whereHas('user', function ($q) use ($bankId) {
                $q->where('bank_id', $bankId);
            });
        }

        // Filter by branch (via user)
        if ($request->filled('branch_id')) {
            $branchId = $request->branch_id;
            $query->whereHas('user', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        // Filter by officer
        if ($request->filled('officer_id')) {
            $query->where('user_id', $request->officer_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter (order date)
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        $packages = LeadPackage::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $banks = Bank::with('branches')->orderBy('name')->get();

        return view('super-admin.package-orders.index', compact('orders', 'packages', 'users', 'banks'));
    }

    // Super-admin: approve order
    public function approve(PackageOrder $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('success', 'Order already processed.');
        }

        $order->status = 'approved';
        $order->updated_by = auth()->id();
        $order->approved_at = now();
        // clear any previous rejection timestamp
        if (property_exists($order, 'rejected_at') || array_key_exists('rejected_at', $order->getAttributes())) {
            $order->rejected_at = null;
        }
        $order->save();

        // add leads to user's balance
        $user = $order->user;
        $user->lead_balance = ($user->lead_balance ?? 0) + $order->number_of_leads;
        $user->save();

        return redirect()->route('super-admin.package-orders.index')
            ->with('success', 'Order approved and leads added to officer balance.');
    }

    // Super-admin: reject order
    public function reject(PackageOrder $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('success', 'Order already processed.');
        }

        $order->status = 'rejected';
        // record which admin rejected the order
        $order->updated_by = auth()->id();
        $order->approved_at = null;
        // record rejection time if column exists
        if (property_exists($order, 'rejected_at') || array_key_exists('rejected_at', $order->getAttributes())) {
            $order->rejected_at = now();
        }
        $order->save();

        return redirect()->route('super-admin.package-orders.index')
            ->with('success', 'Order rejected.');
    }
}
