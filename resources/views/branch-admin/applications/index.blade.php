@extends('layouts.branch-admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="bi bi-file-text me-2"></i>Loan Applications</h2>
            <p class="text-muted">Manage loan applications for your branch</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('branch-admin.applications.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label for="status" class="form-label">Filter by Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-filter me-2"></i>Filter
                    </button>
                    <a href="{{ route('branch-admin.applications.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($applications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Applicant Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Loan Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Applied Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $application)
                                <tr>
                                    <td><strong>#{{ $application->id }}</strong></td>
                                    <td>{{ $application->full_name }}</td>
                                    <td>{{ $application->email }}</td>
                                    <td>{{ $application->phone }}</td>
                                    <td>{{ $application->loan->name ?? 'N/A' }}</td>
                                    <td><strong>৳{{ number_format($application->loan_amount, 2) }}</strong></td>
                                    <td>
                                        @if($application->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($application->status == 'under_review')
                                            <span class="badge bg-info">Under Review</span>
                                        @elseif($application->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($application->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $application->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('branch-admin.applications.show', $application) }}"
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $applications->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3">No loan applications found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
