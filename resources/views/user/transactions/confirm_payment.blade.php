@extends('user.layouts.app')

@section('title', 'Confirm Payment')
@section('page-title', 'Upload Payment Proof')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-8 sm:py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Card Container --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            
            {{-- Header Section --}}
            <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 sm:p-8">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-white">
                            Payment Confirmation
                        </h2>
                        <p class="text-green-100 text-sm mt-1">Upload your payment proof to complete the order</p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8">

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="ml-3 text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                
                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3">
                                <ul class="text-sm text-red-800 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Transaction Info --}}
                <div class="mb-8">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Transaction Details
                    </h3>

                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 sm:p-5 rounded-xl border border-gray-200 space-y-3">
                        <div class="flex justify-between items-start sm:items-center flex-col sm:flex-row gap-1 sm:gap-0">
                            <span class="text-sm text-gray-600 font-medium">Transaction ID</span>
                            <span class="text-sm font-mono bg-white px-3 py-1 rounded-lg border border-gray-200">
                                #{{ $transaction->id }}
                            </span>
                        </div>
                        
                        <div class="border-t border-gray-200"></div>
                        
                        <div class="flex justify-between items-start sm:items-center flex-col sm:flex-row gap-1 sm:gap-0 pt-2">
                            <span class="text-sm text-gray-600 font-medium">Total Amount</span>
                            <span class="text-xl sm:text-2xl font-bold text-green-600">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Upload Form --}}
                <form action="{{ route('user.checkout.upload_payment', $transaction->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="space-y-6">
                    @csrf

                    {{-- Upload Section --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            Upload Payment Proof
                        </label>

                        <div class="relative">
                            <input type="file" 
                                   name="payment_proof" 
                                   accept="image/*"
                                   id="file-input"
                                   class="hidden"
                                   onchange="previewImage(this)">
                            
                            <label for="file-input" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-200 overflow-hidden">
                                <div class="flex flex-col items-center justify-center py-6 px-4 text-center h-40 sm:h-48" id="upload-placeholder">
                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="mb-2 text-sm sm:text-base font-semibold text-gray-700">
                                        Click to upload payment proof
                                    </p>
                                    <p class="text-xs text-gray-500">JPG, JPEG or PNG (Max 2MB)</p>
                                </div>
                                
                                {{-- Preview Container --}}
                                <div id="preview-container" class="hidden w-full relative">
                                    <img id="preview-image" src="" alt="Payment Proof Preview" class="w-full h-auto max-h-96 object-contain">
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                        <p class="text-white text-sm font-medium" id="file-name"></p>
                                        <p class="text-white/80 text-xs" id="file-size"></p>
                                        <p class="text-green-400 text-xs mt-1">Click to change image</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <p class="mt-2 text-xs text-gray-500 flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <span>Make sure your payment proof is clear and includes the transaction details</span>
                        </p>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 sm:py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Submit Payment Proof</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        {{-- Help Text --}}
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Need help? 
                <a href="#" class="text-green-600 hover:text-green-700 font-semibold hover:underline">
                    Contact Support
                </a>
            </p>
        </div>

    </div>
</div>

<script>
function previewImage(input) {
    const placeholder = document.getElementById('upload-placeholder');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Hide placeholder and show preview
            placeholder.classList.add('hidden');
            previewContainer.classList.remove('hidden');
            
            // Set image source
            previewImage.src = e.target.result;
            
            // Set file info
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
        }
        
        reader.readAsDataURL(file);
    }
}
</script>

@endsection