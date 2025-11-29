@extends('admin.layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Product Details: {{ $product->name }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                @if($product->image)
                    <img src="{{ asset('storage/products/'.$product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-64 object-cover rounded-lg">
                @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg">
                        <span class="text-gray-500">No image available</span>
                    </div>
                @endif
            </div>

            <div class="space-y-3">
                <p><strong>Category:</strong> {{ $product->category->name ?? '-' }}</p>
                <p><strong>Price:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p><strong>Stock:</strong> {{ $product->stock }}</p>
                <p><strong>Description:</strong></p>
                <p class="text-gray-700">{{ $product->description ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.products.index') }}" 
               class="inline-flex font-sans items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
               Back to Product List
            </a>
        </div>
    </div>
</div>
@endsection
