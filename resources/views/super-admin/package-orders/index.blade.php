@extends('layouts.admin')

@section('title', 'Package Orders')
@section('dashboard-title', 'Package Orders')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Package Orders</h4>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Officer</th>
                            <th>Package</th>
                            <th>Leads</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->leadPackage->name }}</td>
                                <td>{{ $order->number_of_leads }}</td>
                                <td>{{ number_format($order->price, 2) }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td class="text-end">
                                    @if ($order->status === 'pending')
                                        <form action="{{ route('super-admin.package-orders.approve', $order) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
