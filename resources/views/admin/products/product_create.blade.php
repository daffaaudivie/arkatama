@extends('admin.layouts.app')

@section('title', 'Add New Product')
@section('page-title', 'Add New Product')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Card Form -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <span class="text-3xl mr-3">📦</span>
                Add Product
            </h2>
        </div>

        <!-- Form Content -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <!-- Error Alert -->
            @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex items-center mb-2">
                    <span class="text-2xl mr-2">⚠️</span>
                    <h3 class="font-bold text-red-800">Error!</h3>
                </div>
                <ul class="list-disc list-inside text-red-700 text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Product Name -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <span class="text-lg mr-1">📝</span>Product Name
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                       placeholder="Enter product name"
                       required>
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <span class="text-lg mr-1">🏷️</span> Category
                    <span class="text-red-500">*</span>
                </label>
                <select name="category_id" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                        required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Price & Stock in one row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Price -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <span class="text-lg mr-1">💰</span> Price (IDR)
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="price" 
                           value="{{ old('price') }}"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                           placeholder="0"
                           min="0"
                           step="0.01"
                           required>
                </div>

                <!-- Stock -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        <span class="text-lg mr-1">📊</span> Stock
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           value="{{ old('stock') }}"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                           placeholder="0"
                           min="0"
                           required>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <span class="text-lg mr-1">📄</span> Product Description
                </label>
                <textarea name="description" 
                          rows="5"
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors resize-none"
                          placeholder="Enter product description">{{ old('description') }}</textarea>
            </div>

            <!-- Image Upload -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <span class="text-lg mr-1">🖼️</span> Product Image
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                    <input type="file" 
                           name="image" 
                           id="imageInput"
                           class="hidden"
                           accept="image/jpeg,image/png,image/jpg,image/gif"
                           onchange="previewImage(event)">
                    
                    <label for="imageInput" class="cursor-pointer">
                        <div id="imagePreview" class="mb-4">
                            <span class="text-6xl">📷</span>
                            <p class="text-gray-600 mt-2">Click to upload</p>
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.products.index') }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                    <span class="mr-1">←</span> Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-lg">
                    <span class="mr-1">✓</span> Save Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Image Preview -->
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="max-w-full h-48 mx-auto rounded-lg shadow-md mb-2">
                <p class="text-sm text-gray-600">Click to change image</p>
            `;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
