@extends('user.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Find Your Products</h2>
    <p class="text-gray-600 mt-1">Discover amazing deals on quality products</p>
</div>

<!-- Grid Produk -->
<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">

    @foreach($products as $product)
        <a href="{{ route('user.products.show', $product->id) }}"
           class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group overflow-hidden flex flex-col">

            <!-- Image Container -->
            <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/products/'.$product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                
                <!-- Hover Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
            </div>

            <!-- Info Produk -->
<div class="p-2 sm:p-4 flex flex-col flex-grow">
    <!-- Nama Produk -->
    <h3 class="text-sm sm:text-base text-gray-800 font-medium line-clamp-2 mb-2">
        {{ $product->name }}
    </h3>

    <!-- Harga Langsung di Bawah Nama -->
    <span class="text-sm sm:text-base font-bold text-gray-900">
        Rp {{ number_format($product->price, 0, ',', '.') }}
    </span>

    <!-- Optional: Hover View Details -->
    <div class="mt-1 pt-2 border-t border-gray-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <span class="text-xs text-green-600 font-medium flex items-center gap-1">
            View Details
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </span>
    </div>
</div>


        </a>
    @endforeach

</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $products->links() }}
</div>

@endsection