@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Card Form -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <span class="text-3xl mr-3">📦</span>
                Edit Category
            </h2>
        </div>

        <!-- Form Content -->
        <form action="{{ route('categories.update', $category) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

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

            <!-- Category Name -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <span class="text-lg mr-1">📝</span>Category Name
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $category->name) }}"
                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                       placeholder="Enter category name"
                       required>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    <span class="text-lg mr-1">📄</span> Description
                </label>
                <textarea name="description" 
                          rows="5"
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors resize-none"
                          placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('categories.index') }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-lg">
                    <span class="mr-1">✓</span> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
