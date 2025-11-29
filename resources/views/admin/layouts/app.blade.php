<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">

    <!-- Overlay untuk mobile (lapisan gelap saat sidebar terbuka) -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden">
    </div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed top-0 left-0 h-full w-64 bg-gray-800 z-30 transition-transform duration-300 lg:translate-x-0">
        
        <!-- Header Sidebar -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-700">
            <h2 class="text-xl font-bold text-white">Admin Panel</h2>
            <!-- Tombol Close (X) untuk mobile -->
            <button @click="sidebarOpen = false" 
                    class="text-gray-400 hover:text-white lg:hidden text-2xl">
                ×
            </button>
        </div>

        <!-- Menu Navigasi -->
        <nav class="px-4 py-6">
            <div class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white
                          @if(request()->routeIs('admin.dashboard')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">🏠</span>
                    <span>Dashboard</span>
                </a>

                <!-- Users -->
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white
                          @if(request()->routeIs('users.*')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">🙎🏻‍♂️</span>
                    <span>Users</span>
                </a>

                <!-- Products -->
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white
                          @if(request()->routeIs('products.*')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">📦</span>
                    <span>Products</span>
                </a>

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white
                          @if(request()->routeIs('categories.*')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">🏷️</span>
                    <span>Categories</span>
                </a>

                <!-- Transactions -->
                <a href="" 
                   class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white
                          @if(request()->routeIs('transactions.*')) bg-gray-700 text-white @endif">
                    <span class="text-xl mr-3">💳</span>
                    <span>Transactions</span>
                </a>
            </div>
        </nav>

        <!-- Logout Button di bagian bawah -->
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

    <!-- Konten Utama -->
    <div class="lg:ml-64">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="flex items-center justify-between px-4 py-3">
                <!-- Tombol Hamburger untuk mobile -->
                <button @click="sidebarOpen = true" 
                        class="text-gray-600 hover:text-gray-900 lg:hidden text-3xl">
                    ☰
                </button>

                <!-- Judul Halaman -->
                <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>

                <!-- Info User -->
                <div class="text-sm text-gray-600 hidden sm:block">
                    Admin User
                </div>
            </div>
        </header>

        <!-- Area Konten -->
        <main class="p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>