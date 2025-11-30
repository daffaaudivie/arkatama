@extends('user.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Find Your Products</h2>
    <p class="text-gray-600 mt-1">Discover amazing deals on quality products</p>
    
    <!-- Search & Filter Form -->
    <form method="GET" action="{{ route('user.products.index') }}" class="mt-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <!-- Search Input -->
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search products by name..." 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            
            <!-- Category Filter -->
            <div class="sm:w-48">
                <select name="category" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Search Button -->
            <button type="submit" 
                    class="px-6 py-2.5 bg-white text-black border-2 border-gray-300 rounded-lg hover:border-green-500 border-gray-300 transition-colors font-medium flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Search
            </button>
            
            <!-- Reset Button -->
            @if(request('search') || request('category'))
                <a href="{{ route('user.products.index') }}" 
                   class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Reset
                </a>
            @endif
        </div>
        
        <!-- Active Filters Info -->
        @if(request('search') || request('category'))
            <div class="mt-3 flex items-center gap-2 text-sm text-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>
                    Showing results 
                    @if(request('search'))
                        for "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if(request('category'))
                        in category "<strong>{{ $categories->find(request('category'))->name ?? '' }}</strong>"
                    @endif
                    ({{ $products->total() }} products found)
                </span>
            </div>
        @endif
    </form>
</div>

<!-- Grid Produk -->
@if($products->count() > 0)
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
@else
    <!-- No Products Found -->
    <div class="text-center py-12">
        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-1">No products found</h3>
        <p class="text-gray-500 mb-4">Try adjusting your search or filter to find what you're looking for.</p>
        <a href="{{ route('user.products.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Clear all filters
        </a>
    </div>
@endif

<!-- Pagination -->
@if($products->count() > 0)
<div class="mt-8">
    {{ $products->appends(request()->query())->links() }}
</div>
@endif

@endsection