<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin Dashboard')</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">

<!-- Overlay Mobile -->
<div x-show="mobileMenuOpen"
     @click="mobileMenuOpen = false"
     class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden transition-opacity"
     x-transition.opacity></div>

<!-- Sidebar -->
<aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
       class="fixed top-0 left-0 h-full w-72 bg-gradient-to-b from-gray-800 to-gray-900 z-30 transition-transform duration-300 shadow-2xl">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between px-6 py-6 border-b border-gray-700/50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-cogs text-white text-lg"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Admin Panel</h2>
        </div>

        <!-- Close Mobile -->
        <button @click="mobileMenuOpen = false"
                class="text-gray-300 hover:text-white lg:hidden text-2xl transition-colors">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="px-4 py-6 flex-1 overflow-y-auto">
        <div class="space-y-2">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group
               @if(request()->routeIs('admin.dashboard')) bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg @endif">
                <div class="w-8 h-8 flex items-center justify-center mr-3 rounded-lg bg-gray-700 group-hover:bg-gray-600 transition-colors">
                    <i class="fas fa-home text-sm"></i>
                </div>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Users -->
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group
               @if(request()->routeIs('admin.users.*')) bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg @endif">
                <div class="w-8 h-8 flex items-center justify-center mr-3 rounded-lg bg-gray-700 group-hover:bg-gray-600 transition-colors">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <span class="font-medium">Users</span>
            </a>

            <!-- Products -->
            <a href="{{ route('admin.products.index') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group
               @if(request()->routeIs('admin.products.*')) bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg @endif">
                <div class="w-8 h-8 flex items-center justify-center mr-3 rounded-lg bg-gray-700 group-hover:bg-gray-600 transition-colors">
                    <i class="fas fa-box-open text-sm"></i>
                </div>
                <span class="font-medium">Products</span>
            </a>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group
               @if(request()->routeIs('admin.categories.*')) bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg @endif">
                <div class="w-8 h-8 flex items-center justify-center mr-3 rounded-lg bg-gray-700 group-hover:bg-gray-600 transition-colors">
                    <i class="fas fa-tags text-sm"></i>
                </div>
                <span class="font-medium">Categories</span>
            </a>

            <!-- Transactions -->
            <a href="{{ route('admin.transactions.index') }}"
               class="flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-gray-700/50 hover:text-white transition-all duration-200 group
               @if(request()->routeIs('admin.transactions.*')) bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg @endif">
                <div class="w-8 h-8 flex items-center justify-center mr-3 rounded-lg bg-gray-700 group-hover:bg-gray-600 transition-colors">
                    <i class="fas fa-credit-card text-sm"></i>
                </div>
                <span class="font-medium">Transactions</span>
            </a>

        </div>
    </nav>

    <!-- Logout -->
    <div class="border-t border-gray-700/50 p-4 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex items-center w-full px-4 py-3 text-gray-300 rounded-xl hover:bg-red-600/20 hover:text-red-400 transition-all duration-200 group">
                <div class="w-8 h-8 flex items-center justify-center mr-3 rounded-lg bg-gray-700 group-hover:bg-red-600/30 transition-colors">
                    <i class="fas fa-sign-out-alt text-sm"></i>
                </div>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>

</aside>

<!-- Main Content -->
<div :class="{'lg:ml-72': sidebarOpen, 'lg:ml-0': !sidebarOpen}" class="transition-all duration-300">

    <!-- Top Bar -->
    <header class="bg-gradient-to-r from-green-500 to-blue-700 shadow-lg sticky top-0 z-10">
        <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">

            <!-- Left -->
            <div class="flex items-center space-x-4">
                <button @click="sidebarOpen = !sidebarOpen; mobileMenuOpen = !mobileMenuOpen"
                        class="text-white hover:text-blue-200 text-2xl transition-colors">
                    <i class="fas fa-bars"></i>
                </button>

                <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-wide">@yield('page-title', 'Dashboard')</h1>
            </div>

            <!-- Right: Admin Info -->
            <div class="flex items-center space-x-3">
                <div class="hidden sm:flex items-center space-x-3 bg-white bg-opacity-20 rounded-full px-4 py-2 backdrop-blur-sm">
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-600 font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="text-white font-medium">{{ Auth::user()->name }}</span>
                </div>

                <div class="sm:hidden w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-600 font-semibold shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>

        </div>
    </header>

    <!-- Content Area -->
    <main class="p-4 sm:p-6 lg:p-8">
        @yield('content')
    </main>

</div>
</body>
</html>
