@extends('admin.layouts.app')

@section('title', 'Products List')
@section('page-title', 'Product')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header Section -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Products List</h1>
                <p class="mt-2 text-sm text-gray-600">Manage your product data</p>
            </div>
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 shadow-md">
                Add Product
            </a>
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

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Name</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Category</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Price</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Stock</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Image</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-center">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">Rp {{ number_format($product->price,0,',','.') }}</td>
                            <td class="px-6 py-4 text-center">{{ $product->stock }}</td>
                            <td class="px-6 py-4 image-center">
                                <div class="flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/products/'.$product->image) }}" class="h-40 w-40 object-cover rounded">
                                @else
                                    -
                                @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Detail Button -->
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-150 text-sm font-medium">
                                        Details
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors duration-150 text-sm font-medium">
                                        Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this product?')"
                                                class="inline-flex items-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors duration-150 text-sm font-medium">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                No products available
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $products->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
