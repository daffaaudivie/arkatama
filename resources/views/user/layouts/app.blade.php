<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Dashboard')</title>

    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">

    <!-- Overlay (Mobile) -->
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden">
    </div>

    <!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 h-full w-64 bg-gray-800 z-30 transition-transform duration-300 lg:translate-x-0">

        <!-- Sidebar Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-700">
            <h2 class="text-xl font-bold text-white">User Panel</h2>

            <!-- Close Button (mobile) -->
            <button @click="sidebarOpen = false"
                    class="text-gray-300 hover:text-white lg:hidden text-2xl">
                ×
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="px-4 py-6">
            <div class="space-y-2">

                <!-- Dashboard -->
                <a href="{{ route('user.dashboard') }}"
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white 
                   @if(request()->routeIs('user.dashboard')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">🏠</span>
                    <span>Dashboard</span>
                </a>

                <!-- Products -->
                <a href="{{ route('user.products.index') }}"
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white
                   @if(request()->routeIs('user.products.*')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">🛒</span>
                    <span>Products</span>
                </a>

                <!-- Cart -->
                <a href=""
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white
                   @if(request()->routeIs('user.cart.*')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">🛍️</span>
                    <span>Cart</span>
                </a>

                <!-- Transactions -->
                <a href=""
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white
                   @if(request()->routeIs('user.transactions.*')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">💳</span>
                    <span>Transactions</span>
                </a>

                <!-- Profile -->
                <a href=""
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white
                   @if(request()->routeIs('user.profile')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">🙍</span>
                    <span>Profile</span>
                </a>

            </div>
        </nav>

        <!-- Logout Button -->
        <div class="absolute bottom-0 left-0 right-0 border-t border-gray-700 p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-3 text-gray-300 rounded-lg hover:bg-red-600 hover:text-white transition-colors">
                    <span class="text-xl mr-3">🚪</span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-64">

        <!-- Top Bar -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="flex items-center justify-between px-4 py-3">

                <!-- Hamburger (mobile) -->
                <button @click="sidebarOpen = true"
                        class="text-gray-600 hover:text-gray-900 lg:hidden text-3xl">
                    ☰
                </button>

                <!-- Page Title -->
                <h1 class="text-lg sm:text-xl font-semibold text-gray-800">
                    @yield('page-title', 'Dashboard')
                </h1>

                <!-- User Info -->
                <div class="text-sm text-gray-700 hidden sm:block">
                    {{ Auth::user()->name }}
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>

    </div>

</body>
</html>
