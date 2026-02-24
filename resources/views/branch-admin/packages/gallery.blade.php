@extends('layouts.branch-admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Lead Packages</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-3">
            @foreach ($packages as $package)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5>{{ $package->name }}</h5>
                            <p class="mb-1">Leads: <strong>{{ $package->number_of_leads }}</strong></p>
                            <p class="mb-1">Price: <strong>৳{{ number_format($package->price, 2) }}</strong></p>
                            <p class="text-muted small">{{ Str::limit($package->description, 80) }}</p>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('branch-admin.packages.purchase.form', $package) }}"
                                class="btn btn-primary w-100">Buy Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
