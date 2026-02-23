<?php

namespace App\Http\Controllers;

use App\Models\PackageOrder;
use App\Models\LeadPackage;
use App\Models\User;
use Illuminate\Http\Request;

class PackageOrderController extends Controller
{
    // Super-admin: view orders
    public function index()
    {
        $orders = PackageOrder::with(['user', 'leadPackage'])->orderBy('created_at', 'desc')->paginate(20);

        return view('super-admin.package-orders.index', compact('orders'));
    }

    // Super-admin: approve order
    public function approve(PackageOrder $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('success', 'Order already processed.');
        }

        $order->status = 'approved';
        $order->approved_by = auth()->id();
        $order->approved_at = now();
        $order->save();

        // add leads to user's balance
        $user = $order->user;
        $user->lead_balance = ($user->lead_balance ?? 0) + $order->number_of_leads;
        $user->save();

        return redirect()->route('super-admin.package-orders.index')
            ->with('success', 'Order approved and leads added to officer balance.');
    }
}
