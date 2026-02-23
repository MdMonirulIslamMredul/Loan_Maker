@extends('layouts.branch-admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="bi bi-clock-history me-2"></i>Purchase History</h2>
                <p class="text-muted">Your package purchase requests and approvals.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if ($orders->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted"></i>
                        <p class="text-muted mt-3">No purchases found.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Package</th>
                                    <th>Leads</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Requested</th>
                                    <th>Approved By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->leadPackage->name ?? '-' }}</td>
                                        <td>{{ $order->number_of_leads }}</td>
                                        <td>{{ number_format($order->price, 2) }}</td>
                                        <td>
                                            @if ($order->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($order->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                                        <td>{{ $order->approved_by ? App\Models\User::find($order->approved_by)->name : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            @if ($orders->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
