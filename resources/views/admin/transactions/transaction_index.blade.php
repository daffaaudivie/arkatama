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

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-xl shadow-lg overflow-hidden">
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
                        @php
                            $colors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'paid' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                            $statusValue = $transaction->status->value;
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">

                            <!-- User -->
                            <td class="px-6 py-4 text-center">
                                <span class="font-medium text-gray-900">{{ $transaction->user->name }}</span>
                            </td>

                            <!-- Total Price -->
                            <td class="px-6 py-4 text-center">
                                <span class="font-semibold text-gray-900">Rp {{ number_format($transaction->total_price,0,',','.') }}</span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$statusValue] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst(str_replace('_',' ', $statusValue)) }}
                                </span>
                            </td>

                            <!-- Payment Proof -->
                            <td class="px-6 py-4 text-center">
                                @if($transaction->payment_proof)
                                    <button onclick="showImageModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md font-medium text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </button>
                                @else
                                    <span class="text-gray-400 text-sm">No proof</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">

                                    <!-- View Details -->
                                    <a href="{{ route('admin.transactions.product_detail', $transaction->id) }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M3 7h18M3 12h18M3 17h18"/>
                                            </path>
                                            </svg>
                                            Details
                                        </a>

                                    <!-- Change Status -->
                                    <form action="{{ route('admin.transactions.update_status', $transaction->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                            <option value="pending" {{ $statusValue=='pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $statusValue=='paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="cancelled" {{ $statusValue=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>

                                        <button type="submit"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Update
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 font-medium">No transactions available</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            @forelse($transactions as $transaction)
            @php
                $statusValue = $transaction->status->value;
            @endphp
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="p-5 space-y-4">
                    
                    <!-- User -->
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600 font-medium">User</span>
                        <span class="font-semibold text-gray-900">{{ $transaction->user->name }}</span>
                    </div>

                    <!-- Price -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 font-medium">Total Price</span>
                        <span class="text-lg font-bold text-gray-900">Rp {{ number_format($transaction->total_price,0,',','.') }}</span>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 font-medium">Status</span>
                        @php
                            $colors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'waiting_verification' => 'bg-blue-100 text-blue-700',
                                'paid' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$statusValue] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst(str_replace('_',' ', $statusValue)) }}
                        </span>
                    </div>

                    <!-- Payment Proof Button -->
                    @if($transaction->payment_proof)
                    <div class="pt-2">
                        <button onclick="showImageModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Payment Proof
                        </button>
                    </div>
                    @else
                    <div class="pt-2 text-center">
                        <span class="text-gray-400 text-sm">No payment proof uploaded</span>
                    </div>
                    @endif

                    <!-- Details Button -->
                    <div>
                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" 
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            View Details
                        </a>
                    </div>

                    <!-- Update Status Form -->
                    <div class="pt-2 border-t border-gray-100">
                        <form action="{{ route('admin.transactions.update_status', $transaction->id) }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="pending" {{ $statusValue=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $statusValue=='paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="cancelled" {{ $statusValue=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Update Status
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 font-medium">No transactions available</p>
            </div>
            @endforelse

            <!-- Mobile Pagination -->
            <div class="pt-4">
                {{ $transactions->links() }}
            </div>
        </div>

    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full" onclick="event.stopPropagation()">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="Payment Proof" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl">
    </div>
</div>

<script>
function showImageModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});
</script>

@endsection
