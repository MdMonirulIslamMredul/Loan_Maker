@extends('layouts.admin')

@section('title', 'Edit Branch')
@section('dashboard-title', 'Bank Admin - Edit Branch')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-6">Edit Branch</h2>

    <form method="POST" action="{{ route('bank-admin.branches.update', $branch) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Branch Name</label>
            <input type="text"
                   name="name"
                   id="name"
                   value="{{ old('name', $branch->name) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   required>
            @error('name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Branch Code</label>
            <input type="text"
                   name="code"
                   id="code"
                   value="{{ old('code', $branch->code) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   required>
            @error('code')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
            <textarea name="address"
                      id="address"
                      rows="3"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('address', $branch->address) }}</textarea>
            @error('address')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="city" class="block text-gray-700 text-sm font-bold mb-2">City</label>
                <input type="text"
                       name="city"
                       id="city"
                       value="{{ old('city', $branch->city) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('city')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="state" class="block text-gray-700 text-sm font-bold mb-2">State</label>
                <input type="text"
                       name="state"
                       id="state"
                       value="{{ old('state', $branch->state) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('state')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                <input type="text"
                       name="phone"
                       id="phone"
                       value="{{ old('phone', $branch->phone) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('phone')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email', $branch->email) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active', $branch->is_active) ? 'checked' : '' }}
                       class="mr-2">
                <span class="text-gray-700 text-sm font-bold">Active</span>
            </label>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('bank-admin.branches.index') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancel
            </a>
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Branch
            </button>
        </div>
    </form>
</div>
@endsection
