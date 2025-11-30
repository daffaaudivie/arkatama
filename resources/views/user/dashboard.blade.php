@extends('user.layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="container mx-auto">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-green-500 to-blue-600 rounded-2xl shadow-xl p-6 sm:p-8 mb-8 text-white">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold mb-2">Welcome Back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-green-50 text-lg">Ready to shop for something amazing today?</p>
            </div>
            <div class="hidden sm:block">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-shopping-cart text-4xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Orders -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Orders</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalOrders ?? 0 }}</h3>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Pending Orders</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $pendingOrders ?? 0 }}</h3>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Completed</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $completedOrders ?? 0 }}</h3>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Spent -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Spent</p>
                    <h3 class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</h3>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-wallet text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Recent Orders</h2>
                <a href="{{ route('user.transactions.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                    View All <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            @if(isset($recentOrders) && $recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg flex items-center justify-center text-white font-bold">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                @if($order->status == 'completed') bg-green-100 text-green-700
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status == 'processing') bg-blue-100 text-blue-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-bag text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">No orders yet</p>
                    <a href="{{ route('user.products.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-green-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Actions & Profile -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('user.products.index') }}" class="flex items-center p-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:shadow-lg transition-all">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <span class="font-medium">Browse Products</span>
                    </a>
                    <a href="{{ route('user.transactions.index') }}" class="flex items-center p-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <span class="font-medium">View Transactions</span>
                    </a>
                    <a href="" class="flex items-center p-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg hover:shadow-lg transition-all">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <span class="font-medium">Edit Profile</span>
                    </a>
                </div>
            </div>

            <!-- Account Info -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl shadow-md p-6 text-white">
                <h2 class="text-xl font-bold mb-4">Account Info</h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-user w-8 text-green-400"></i>
                        <div>
                            <p class="text-xs text-gray-400">Name</p>
                            <p class="font-medium">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope w-8 text-blue-400"></i>
                        <div>
                            <p class="text-xs text-gray-400">Email</p>
                            <p class="font-medium">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar w-8 text-purple-400"></i>
                        <div>
                            <p class="text-xs text-gray-400">Member Since</p>
                            <p class="font-medium">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection