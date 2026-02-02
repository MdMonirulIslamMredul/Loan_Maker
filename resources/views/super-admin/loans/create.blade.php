@extends('layouts.admin')

@section('title', 'Create Loan')
@section('dashboard-title', 'Super Admin - Create New Loan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="mb-4">
            <h2 class="mb-2 fw-bold">Create New Loan</h2>
            <p class="text-muted">Add a new loan product</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('super-admin.loans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
            <div class="row g-3">
                <!-- Branch Selection (Required) -->
                <div class="col-12">
                    <label class="form-label">
                        Branch <span class="text-danger">*</span>
                    </label>
                    <select name="branch_id" required class="form-select">
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->bank->name }} - {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Loan Name (Required) -->
                <div class="col-12">
                    <label class="form-label">
                        Loan Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="form-control">
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                </div>

                <!-- Interest Rate -->
                <div class="col-md-6">
                    <label class="form-label">Interest Rate (%)</label>
                    <input type="number" name="interest_rate" value="{{ old('interest_rate') }}" step="0.01" min="0" max="100" class="form-control">
                </div>

                <!-- Processing Fee -->
                <div class="col-md-6">
                    <label class="form-label">Processing Fee (%)</label>
                    <input type="number" name="processing_fee" value="{{ old('processing_fee') }}" step="0.01" min="0" max="100" class="form-control">
                </div>

                <!-- Status -->
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', true) ? 'checked' : '' }} class="form-check-input">
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                </div>

                <!-- Min Amount -->
                <div class="col-md-6">
                    <label class="form-label">Minimum Amount</label>
                    <input type="number" name="min_amount" value="{{ old('min_amount') }}" step="0.01" min="0" class="form-control">
                </div>

                <!-- Max Amount -->
                <div class="col-md-6">
                    <label class="form-label">Maximum Amount</label>
                    <input type="number" name="max_amount" value="{{ old('max_amount') }}" step="0.01" min="0" class="form-control">
                </div>

                <!-- Min Tenure -->
                <div class="col-md-6">
                    <label class="form-label">Minimum Tenure (Months)</label>
                    <input type="number" name="min_tenure_months" value="{{ old('min_tenure_months') }}" min="1" class="form-control">
                </div>

                <!-- Max Tenure -->
                <div class="col-md-6">
                    <label class="form-label">Maximum Tenure (Months)</label>
                    <input type="number" name="max_tenure_months" value="{{ old('max_tenure_months') }}" min="1" class="form-control">
                </div>

                <!-- Details Field 1 -->
                <div class="col-12">
                    <label class="form-label">Details 1</label>
                    <textarea name="details1" rows="2" class="form-control">{{ old('details1') }}</textarea>
                </div>

                <!-- Details Field 2 -->
                <div class="col-12">
                    <label class="form-label">Details 2</label>
                    <textarea name="details2" rows="2" class="form-control">{{ old('details2') }}</textarea>
                </div>

                <!-- Details Field 3 -->
                <div class="col-12">
                    <label class="form-label">Details 3</label>
                    <textarea name="details3" rows="2" class="form-control">{{ old('details3') }}</textarea>
                </div>

                <!-- Details Field 4 -->
                <div class="col-12">
                    <label class="form-label">Details 4</label>
                    <textarea name="details4" rows="2" class="form-control">{{ old('details4') }}</textarea>
                </div>

                <!-- Eligibility -->
                <div class="col-12">
                    <label class="form-label">Eligibility Criteria</label>
                    <textarea name="eligibility" rows="3" class="form-control">{{ old('eligibility') }}</textarea>
                </div>

                <!-- Features -->
                <div class="col-12">
                    <label class="form-label">Features</label>
                    <textarea name="features" rows="3" placeholder="Enter loan features (e.g., Quick approval, Low interest rate, Flexible repayment options)" class="form-control">{{ old('features') }}</textarea>
                </div>

                <!-- Documents Required -->
                <div class="col-12">
                    <label class="form-label">Documents Required</label>
                    <textarea name="documents_required" rows="3" class="form-control">{{ old('documents_required') }}</textarea>
                </div>

                <!-- Banner Image -->
                <div class="col-12">
                    <label class="form-label">Banner Image</label>
                    <input type="file" name="banner" accept="image/*" class="form-control">
                    <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF (max 2MB)</div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('super-admin.loans.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Create Loan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
