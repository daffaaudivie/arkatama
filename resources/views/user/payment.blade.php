@extends('user.layouts.app')

@section('title', 'Checkout')
@section('page-title', 'Checkout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-4 sm:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 shadow-sm animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 sm:p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-1">Order Summary</h2>
                        <p class="text-green-100 text-sm">Checkout Product</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <!-- Checkout Form -->
                <form action="{{ route('user.checkout.confirm') }}" method="POST">
                    @csrf

                    <!-- Products List -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Items Ordered
                        </h3>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Quantity: {{ $quantity }}</p>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="font-semibold text-gray-800">Rp {{ number_format($product->price * $quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t-2 border-gray-200 pt-6 mb-8">
                        <div class="flex justify-between items-center bg-green-50 p-5 rounded-xl">
                            <span class="text-lg font-bold text-gray-800">Total Payment</span>
                            <span class="text-2xl font-bold text-green-600">Rp {{ number_format($product->price * $quantity, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Hidden fields untuk product & quantity -->
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="{{ $quantity }}">

                    <!-- Checkout Button -->
                    <button type="submit" class="w-full bg-green-600 text-white py-4 px-6 rounded-xl hover:bg-green-700 font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fade-in 0.3s ease-out; }
</style>
@endsection
