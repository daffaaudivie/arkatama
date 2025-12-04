@extends('user.layouts.app')

@section('title', 'My Transactions')
@section('page-title', 'My Transactions')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Transactions</h1>
                <p class="mt-2 text-sm text-gray-600">View all your transaction records</p>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @php
        $colors = [
            'pending' => 'bg-yellow-100 text-yellow-700',
            'waiting_verification' => 'bg-blue-100 text-blue-700',
            'paid' => 'bg-green-100 text-green-700',
            'cancelled' => 'bg-red-100 text-red-700',
        ];
        @endphp

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Total Price</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Payment Proof</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                        @php
                            $statusValue = $transaction->status->value;
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center">
                                <span class="font-semibold text-gray-900">Rp {{ number_format($transaction->total_price,0,',','.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$statusValue] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $transaction->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($transaction->payment_proof)
                                    <button onclick="showImageModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-700 text-white rounded-xl hover:bg-blue-800 transition-all duration-200 shadow-lg font-medium text-sm">
                                        View
                                    </button>
                                @else
                                    <a href="{{ route('user.transactions.confirm_payment', $transaction->id) }}"
                                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-600 transition-all duration-200 shadow font-medium text-sm">
                                        Upload Now
                                    </a>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('user.transactions.product_detail', $transaction->id) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-sm hover:shadow-md font-medium text-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                No transactions available
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
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600 font-medium">Total Price</span>
                        <span class="text-lg font-bold text-gray-900">Rp {{ number_format($transaction->total_price,0,',','.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 font-medium">Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$statusValue] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $transaction->status->label() }}
                        </span>
                    </div>
                    <div class="pt-2">
                        @if($transaction->payment_proof)
                            <button onclick="showImageModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-sm font-medium">
                                View Payment Proof
                            </button>
                        @else
                            <a href="{{ route('user.transactions.confirm_payment', $transaction->id) }}"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 shadow-sm font-medium">
                                Upload Payment Proof
                            </a>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('user.transactions.product_detail', $transaction->id) }}"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-sm font-medium">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                No transactions available
            </div>
            @endforelse

            <div class="pt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full" onclick="event.stopPropagation()">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 transition-colors">&times;</button>
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

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
