<?php

namespace App\Http\Controllers;

use App\Models\LeadPackage;
use App\Models\PackageOrder;
use Illuminate\Http\Request;

class OfficerPurchaseController extends Controller
{
    public function gallery()
    {
        $packages = LeadPackage::orderBy('price')->get();

        return view('branch-admin.packages.gallery', compact('packages'));
    }

    public function purchase(Request $request, LeadPackage $leadPackage)
    {
        $user = auth()->user();

        $order = PackageOrder::create([
            'user_id' => $user->id,
            'lead_package_id' => $leadPackage->id,
            'price' => $leadPackage->price,
            'number_of_leads' => $leadPackage->number_of_leads,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Package purchase requested. Awaiting admin approval.');
    }

    public function history()
    {
        $user = auth()->user();
        $orders = PackageOrder::with('leadPackage')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('branch-admin.packages.history', compact('orders'));
    }
}
