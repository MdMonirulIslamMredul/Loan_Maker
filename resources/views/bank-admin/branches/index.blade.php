@extends('layouts.admin')

@section('title', 'All Branches')
@section('dashboard-title', 'Bank Admin - All Branches')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">All Branches</h2>
        <a href="{{ route('bank-admin.branches.create') }}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create New Branch
        </a>
    </div>

    @if($branches->isEmpty())
        <p class="text-gray-600">No branches available.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Branch Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($branches as $branch)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $branch->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $branch->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $branch->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $branch->city ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $branch->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $branch->users_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $branch->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('bank-admin.branches.edit', $branch) }}"
                                   class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </a>
                                <form action="{{ route('bank-admin.branches.destroy', $branch) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
