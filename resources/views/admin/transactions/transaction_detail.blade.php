@extends('admin.layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Transaction Details</h1>
        <a href="{{ route('admin.transactions.index') }}"
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        
        {{-- General Info Section --}}
        <div class="p-6 border-b bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800 mb-4">General Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Transaction ID</p>
                    <p class="font-semibold text-gray-800">#{{ $transaction->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Customer Name</p>
                    <p class="font-semibold text-gray-800">{{ $transaction->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Email</p>
                    <p class="font-semibold text-gray-800">{{ $transaction->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Status</p>
                    <div class="flex items-center justify-between">
                        @php
                            $colors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'waiting_verification' => 'bg-blue-100 text-blue-700',
                                'paid' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];

                            // ambil nilai string dari enum untuk key warna
                            $statusValue = $transaction->status->value;
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$statusValue] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $transaction->status->label() }}
                        </span>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Price</p>
                    <p class="font-bold text-lg text-gray-800">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Transaction Date</p>
                    <p class="font-semibold text-gray-800">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Payment Proof Section --}}
        <div class="p-6 border-b">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Payment Proof</h2>
            @if ($transaction->payment_proof)
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $transaction->payment_proof) }}" 
                         alt="Payment Proof" 
                         class="max-w-md rounded-lg shadow-lg border-2 border-gray-200 hover:shadow-xl transition">
                </div>
            @else
                <div class="bg-gray-100 rounded-lg p-8 text-center">
                    <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-500 italic">No payment proof uploaded yet</p>
                </div>
            @endif
        </div>

        {{-- Products Section --}}
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Purchased Products</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Product Name</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">Price</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700">Qty</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaction->details as $detail)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $detail->product->name }}</p>
                                </td>
                                <td class="px-6 py-4 text-right text-gray-700">
                                    Rp {{ number_format($detail->price_per_item, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $detail->quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-gray-800">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-box-open text-3xl mb-2"></i>
                                    <p>No products found in this transaction</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                    {{-- Total Footer --}}
                    @if ($transaction->details->count() > 0)
                        <tfoot>
                            <tr class="bg-gray-50 border-t-2 border-gray-300">
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-800">
                                    TOTAL:
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-xl text-gray-900">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
