@extends('admin.layouts.app')

@section('title', 'Users List')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Users</h1>
                <p class="mt-2 text-sm text-gray-600">Manage all registered users</p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Name</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Email</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Total Transactions</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Total Spent</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->total_transactions }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($user->total_spent, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                No users found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
