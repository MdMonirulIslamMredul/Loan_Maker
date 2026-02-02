@extends('layouts.branch-admin')

@section('title', 'Create Loan')
@section('dashboard-title', 'Branch Admin - Create New Loan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="mb-4">
            <h2 class="mb-2 fw-bold">Create New Loan</h2>
            <p class="text-muted">Add a new loan product for {{ Auth::user()->branch->name }}</p>
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

        <form action="{{ route('branch-admin.loans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
            <!-- Loan Name (Required) -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Loan Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description"
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
            </div>

            <!-- Interest Rate -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Interest Rate (%)</label>
                <input type="number"
                       name="interest_rate"
                       value="{{ old('interest_rate') }}"
                       step="0.01"
                       min="0"
                       max="100"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Processing Fee -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Processing Fee (%)</label>
                <input type="number"
                       name="processing_fee"
                       value="{{ old('processing_fee') }}"
                       step="0.01"
                       min="0"
                       max="100"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status -->
            <div class="flex items-center pt-8">
                <input type="checkbox"
                       name="is_active"
                       id="is_active"
                       {{ old('is_active', true) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                    Active
                </label>
            </div>

            <!-- Min Amount -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Amount</label>
                <input type="number"
                       name="min_amount"
                       value="{{ old('min_amount') }}"
                       step="0.01"
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Max Amount -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Amount</label>
                <input type="number"
                       name="max_amount"
                       value="{{ old('max_amount') }}"
                       step="0.01"
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Min Tenure -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Tenure (Months)</label>
                <input type="number"
                       name="min_tenure_months"
                       value="{{ old('min_tenure_months') }}"
                       min="1"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Max Tenure -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Maximum Tenure (Months)</label>
                <input type="number"
                       name="max_tenure_months"
                       value="{{ old('max_tenure_months') }}"
                       min="1"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Details Field 1 -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Details 1</label>
                <textarea name="details1"
                          rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('details1') }}</textarea>
            </div>

            <!-- Details Field 2 -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Details 2</label>
                <textarea name="details2"
                          rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('details2') }}</textarea>
            </div>

            <!-- Details Field 3 -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Details 3</label>
                <textarea name="details3"
                          rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('details3') }}</textarea>
            </div>

            <!-- Details Field 4 -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Details 4</label>
                <textarea name="details4"
                          rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('details4') }}</textarea>
            </div>

            <!-- Eligibility -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Eligibility Criteria</label>
                <textarea name="eligibility"
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('eligibility') }}</textarea>
            </div>

            <!-- Features -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Features</label>
                <textarea name="features"
                          rows="3"
                          placeholder="List key features of this loan (e.g., No hidden charges, Quick approval, Flexible repayment)"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('features') }}</textarea>
            </div>

            <!-- Documents Required -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Documents Required</label>
                <textarea name="documents_required"
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('documents_required') }}</textarea>
            </div>

            <!-- Banner Image -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>
                <input type="file"
                       name="banner"
                       accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="text-xs text-gray-500 mt-1">Supported formats: JPEG, PNG, JPG, GIF (max 2MB)</p>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-6">
            <a href="{{ route('branch-admin.loans.index') }}"
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Cancel
            </a>
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Loan
            </button>
        </div>
    </form>
</div>
@endsection
