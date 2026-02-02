@extends('layouts.admin')

@section('title', 'Super Admin Dashboard')
@section('dashboard-title', 'Super Admin Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('super-admin.banks.create') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-building text-primary fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-primary mb-2">Create Bank</h5>
                    <p class="text-muted mb-0 small">Add a new bank to the system</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <a href="{{ route('super-admin.bank-admins.create') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-badge text-success fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-success mb-2">Create Bank Admin</h5>
                    <p class="text-muted mb-0 small">Add a new bank administrator</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <a href="{{ route('super-admin.branches.create') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-shop text-warning fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-warning mb-2">Create Branch</h5>
                    <p class="text-muted mb-0 small">Add a new branch</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <a href="{{ route('super-admin.branch-admins.create') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-person-plus text-info fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-info mb-2">Create Branch Admin</h5>
                    <p class="text-muted mb-0 small">Add a new branch administrator</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <a href="{{ route('super-admin.banks.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-purple bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-bank text-purple fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-purple mb-2">View All Banks</h5>
                    <p class="text-muted mb-0 small">Manage all banks in the system</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <a href="{{ route('super-admin.branches.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-indigo bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-diagram-3 text-indigo fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-indigo mb-2">View All Branches</h5>
                    <p class="text-muted mb-0 small">Manage all branches in the system</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <a href="{{ route('super-admin.loans.create') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-cash-coin text-danger fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-danger mb-2">Create Loan</h5>
                    <p class="text-muted mb-0 small">Add a new loan product</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <a href="{{ route('super-admin.loans.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-pink bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-list-ul text-pink fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-pink mb-2">View All Loans</h5>
                    <p class="text-muted mb-0 small">Manage all loans in the system</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-4">
        <a href="{{ route('super-admin.applications.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 hover-lift">
                <div class="card-body text-center p-4">
                    <div class="bg-cyan bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-file-text text-cyan fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-cyan mb-2">View Loan Applications</h5>
                    <p class="text-muted mb-0 small">Manage customer loan applications</p>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
        <h4 class="mb-0"><i class="bi bi-bank me-2"></i>Banks Overview</h4>
    </div>
    <div class="card-body">
        @if($banks->isEmpty())
            <div class="text-center py-4">
                <i class="bi bi-inbox display-4 text-muted opacity-50"></i>
                <p class="text-muted mt-3 mb-0">No banks created yet.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Bank Name</th>
                            <th class="py-3">Code</th>
                            <th class="py-3">Branches</th>
                            <th class="py-3">Users</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banks as $bank)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="bi bi-building text-primary"></i>
                                        </div>
                                        <strong>{{ $bank->name }}</strong>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary">{{ $bank->code }}</span></td>
                                <td><span class="text-muted">{{ $bank->branches_count }}</span></td>
                                <td><span class="text-muted">{{ $bank->users_count }}</span></td>
                                <td>
                                    @if($bank->is_active)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>Inactive
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.hover-lift {
    transition: transform 0.2s, box-shadow 0.2s;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.text-purple { color: #6f42c1; }
.bg-purple { background-color: #6f42c1; }
.text-indigo { color: #6610f2; }
.bg-indigo { background-color: #6610f2; }
.text-pink { color: #d63384; }
.bg-pink { background-color: #d63384; }
.text-cyan { color: #0dcaf0; }
.bg-cyan { background-color: #0dcaf0; }
</style>
@endpush
@endsection
