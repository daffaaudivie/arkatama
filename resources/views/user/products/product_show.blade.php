@extends('user.layouts.app')

@section('title', $product->name)
@section('page-title', 'Product Detail')

@section('content')
<div class="bg-gray-50 min-h-screen py-4 md:py-8">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Breadcrumb --}}
        <nav class="flex mb-4 text-sm text-gray-600">
            <a href="{{ route('user.dashboard') }}" class="hover:text-green-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('user.products.index') }}" class="hover:text-green-600">Products</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ Str::limit($product->name, 30) }}</span>
        </nav>

        {{-- Main Container --}}
        <div class="bg-white rounded-lg shadow-sm">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 p-4 md:p-8">

                {{-- Column 1: Product Image --}}
                <div class="lg:col-span-4">
                    <div class="relative border-2 rounded-lg border-gray-100">
                        <img src="{{ asset('storage/products/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-64 md:h-96 object-contain rounded-lg bg-gray-50">

                        {{-- Category Badge --}}
                        @if($product->category)
                            <span class="absolute top-4 left-4 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $product->category->name }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Column 2: Product Info --}}
                <div class="lg:col-span-5 p-2 border-r-2 border-gray-100">

                    {{-- Product Name --}}
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                        {{ $product->name }}
                    </h1>

                    {{-- Price --}}
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="text-gray-600 text-sm mb-1">Price</p>
                        <p class="text-3xl md:text-4xl font-bold text-gray-900">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Description --}}
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Product Description</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $product->description ?? 'This product offers great quality at an affordable price. Suitable for daily needs.' }}
                        </p>
                    </div>
                </div>

                {{-- Column 3: Stock & Buttons --}}
                <div class="lg:col-span-3">
                    <div class="lg:sticky lg:top-4">

                        {{-- Stock --}}
                        <div class="mb-6">
                            <p class="text-gray-600 text-sm mb-1">Stock Available</p>
                            <p class="text-2xl font-bold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stock > 0 ? $product->stock : 'Out of Stock' }}
                            </p>
                        </div>

                        {{-- Quantity Selector --}}
                        @if($product->stock > 0)
                        <div class="mb-6">
                            <h3 class="text-sm font-bold text-gray-900 mb-3">Quantity</h3>
                            <div class="flex items-center gap-2">
                                <button type="button"
                                        onclick="decreaseQty()"
                                        class="w-10 h-10 border border-gray-300 rounded-lg hover:border-green-600 hover:text-green-600 flex items-center justify-center font-semibold text-lg">
                                    −
                                </button>

                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                                       class="w-10 h-10  text-right border border-gray-300 rounded-lg font-semibold focus:ring-2 focus:ring-green-500">

                                <button type="button"
                                        onclick="increaseQty()"
                                        class="w-10 h-10 border border-gray-300 rounded-lg hover:border-green-600 hover:text-green-600 flex items-center justify-center font-semibold text-lg">
                                    +
                                </button>
                            </div>
                        </div>

                        {{-- Subtotal --}}
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Subtotal</span>
                                <span class="text-xl font-bold text-gray-900" id="subtotal">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="space-y-3">
                            {{-- Buy Now --}}
                            <form action="{{ route('user.payment.page') }}" method="GET">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" id="qty_checkout" value="1">

                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold shadow-sm hover:shadow-md transition">
                                    Buy Now
                                </button>
                            </form>
         

                            {{-- Add to Cart --}}
                            <form action="" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" id="qty_cart" value="1">

                                <button type="submit"
                                        class="w-full bg-white border-2 border-green-600 text-green-600 hover:bg-green-50 py-3 rounded-lg font-semibold transition">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                        @endif

                        {{-- Additional Info --}}
                        <div class="mt-6 pt-6 border-t space-y-3 text-xs text-gray-600">
                            <div class="flex items-start gap-2">
                                <span class="text-lg">✓</span>
                                <div>
                                    <p class="font-semibold text-gray-900">100% Original</p>
                                    <p>All items are guaranteed authentic.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-2">
                                <span class="text-lg">💰</span>
                                <div>
                                    <p class="font-semibold text-gray-900">Easy Returns</p>
                                    <p>Money-back guarantee available.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-2">
                                <span class="text-lg">⚡</span>
                                <div>
                                    <p class="font-semibold text-gray-900">Fast Delivery</p>
                                    <p>Estimated 1–3 days arrival.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Quantity & Subtotal Script --}}
<script>
    const price = {{ $product->price }};
    const maxStock = {{ $product->stock }};

    function increaseQty() {
        const qtyInput = document.getElementById('quantity');
        if (parseInt(qtyInput.value) < maxStock) {
            qtyInput.value++;
            updateSubtotal();
        }
    }

    function decreaseQty() {
        const qtyInput = document.getElementById('quantity');
        if (qtyInput.value > 1) {
            qtyInput.value--;
            updateSubtotal();
        }
    }

    function updateSubtotal() {
        const qty = parseInt(document.getElementById('quantity').value);
        const subtotal = price * qty;

        document.getElementById('subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('qty_checkout').value = qty;
        document.getElementById('qty_cart').value = qty;
    }
</script>
@endsection
