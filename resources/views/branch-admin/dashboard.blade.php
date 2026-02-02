@extends('layouts.branch-admin')

@section('title', 'Branch Admin Dashboard')
@section('dashboard-title', 'Branch Admin Dashboard')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="d-flex align-items-center">
            <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3">
                <i class="bi bi-shop fs-4"></i>
            </div>
            <h4 class="mb-0 fw-bold">Branch Information</h4>
        </div>
    </div>
    <div class="card-body p-4">
        @if($branch)
            <div class="row g-4">
                <div class="col-md-6">
                    <p class="text-muted mb-1 small fw-semibold">Branch Name:</p>
                    <h6 class="mb-0">{{ $branch->name }}</h6>
                </div>
                <div class="col-md-6">
                    <p class="text-muted mb-1 small fw-semibold">Branch Code:</p>
                    <h6 class="mb-0"><span class="badge bg-secondary">{{ $branch->code }}</span></h6>
                </div>
                <div class="col-md-6">
                    <p class="text-muted mb-1 small fw-semibold">Bank:</p>
                    <h6 class="mb-0">{{ $bank->name }}</h6>
                </div>
                <div class="col-md-6">
                    <p class="text-muted mb-1 small fw-semibold">Location:</p>
                    <h6 class="mb-0"><i class="bi bi-geo-alt me-1 text-primary"></i>{{ $branch->city ?? 'N/A' }}, {{ $branch->state ?? 'N/A' }}</h6>
                </div>
                @if($branch->phone)
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small fw-semibold">Phone:</p>
                        <h6 class="mb-0"><i class="bi bi-telephone me-1 text-success"></i>{{ $branch->phone }}</h6>
                    </div>
                @endif
                @if($branch->email)
                    <div class="col-md-6">
                        <p class="text-muted mb-1 small fw-semibold">Email:</p>
                        <h6 class="mb-0"><i class="bi bi-envelope me-1 text-info"></i>{{ $branch->email }}</h6>
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                <p class="text-muted mt-3 mb-0">No branch information available.</p>
            </div>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h4 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h4>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('branch-admin.loans.index') }}" class="text-decoration-none d-block">
                    <div class="card bg-primary text-white h-100 hover-lift">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-list-ul fs-1 mb-2"></i>
                            <h5 class="fw-bold mb-0">Manage Loans</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('branch-admin.loans.create') }}" class="text-decoration-none d-block">
                    <div class="card bg-success text-white h-100 hover-lift">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-plus-circle fs-1 mb-2"></i>
                            <h5 class="fw-bold mb-0">Add New Loan</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('branch-admin.applications.index') }}" class="text-decoration-none d-block">
                    <div class="card bg-info text-white h-100 hover-lift">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-file-text fs-1 mb-2"></i>
                            <h5 class="fw-bold mb-0">Loan Applications</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.hover-lift {
    transition: transform 0.2s, box-shadow 0.2s;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
}
</style>
@endpush
@endsection
