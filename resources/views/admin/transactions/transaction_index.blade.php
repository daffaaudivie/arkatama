@extends('admin.layouts.app')

@section('title', 'Transactions List')
@section('page-title', 'Transactions')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header Section -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Transactions List</h1>
                <p class="mt-2 text-sm text-gray-600">Manage all transaction records</p>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" 
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" 
                              clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">User</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Total Price</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Payment Proof</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <!-- User -->
                            <td class="px-6 py-4 text-center">
                                {{ $transaction->user->name }}
                            </td>

                            <!-- Total Price -->
                            <td class="px-6 py-4 text-center">
                                Rp {{ number_format($transaction->total_price,0,',','.') }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 text-center">
                                @php
                                    $colors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'waiting_verification' => 'bg-blue-100 text-blue-700',
                                        'paid' => 'bg-green-100 text-green-700',
                                        'failed' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$transaction->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst(str_replace('_',' ', $transaction->status)) }}
                                </span>
                            </td>

                            <!-- Payment Proof -->
                            <td class="px-6 py-4 text-center">
                                @if($transaction->payment_proof)
                                    <a href="{{ asset('storage/' . $transaction->payment_proof) }}" 
                                       target="_blank"
                                       class="text-blue-600 underline">
                                       View
                                    </a>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">

                                    <!-- View Details -->
                                    <a href="{{ route('admin.transactions.show', $transaction->id) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors text-sm font-medium">
                                        Details
                                    </a>

                                    <!-- Change Status -->
                                    <form action="{{ route('admin.transactions.update_status', $transaction->id) }}" method="POST">
                                        @csrf
                                        <select name="status" class="px-2 py-2 border rounded-lg text-sm">
                                            <option value="pending" {{ $transaction->status=='pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $transaction->status=='paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="cancelled" {{ $transaction->status=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>

                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 text-sm font-medium">
                                            Update
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                No transactions available
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                {{ $transactions->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
