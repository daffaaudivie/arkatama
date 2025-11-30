@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-6 sm:p-8 mb-8 text-white">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold mb-2">Admin Dashboard 🚀</h1>
                <p class="text-indigo-50 text-lg">Monitor and manage your e-commerce platform</p>
            </div>
            <div class="hidden sm:block">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-chart-line text-4xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-green-600 text-xs mt-1 font-semibold">
                    </p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Orders</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalOrders ?? 0 }}</h3>
                    <p class="text-blue-600 text-xs mt-1 font-semibold">
                    </p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Products</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalProducts ?? 0 }}</h3>
                    <p class="text-purple-600 text-xs mt-1 font-semibold">
                    </p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-boxes text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Customers</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalCustomers ?? 0 }}</h3>
                    <p class="text-orange-600 text-xs mt-1 font-semibold">
                    </p>
                </div>
                <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pending Orders -->
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl shadow-md p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-50 text-sm mb-1">Pending Orders</p>
                    <h4 class="text-3xl font-bold">{{ $pendingOrders ?? 0 }}</h4>
                </div>
                <i class="fas fa-clock text-3xl opacity-80"></i>
            </div>
        </div>

        <!-- Processing Orders -->
        <div class="bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl shadow-md p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-50 text-sm mb-1">Processing</p>
                    <h4 class="text-3xl font-bold">{{ $processingOrders ?? 0 }}</h4>
                </div>
                <i class="fas fa-spinner text-3xl opacity-80"></i>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl shadow-md p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-50 text-sm mb-1">Completed</p>
                    <h4 class="text-3xl font-bold">{{ $completedOrders ?? 0 }}</h4>
                </div>
                <i class="fas fa-check-circle text-3xl opacity-80"></i>
            </div>
        </div>

        <!-- Cancelled Orders -->
        <div class="bg-gradient-to-br from-red-400 to-red-500 rounded-xl shadow-md p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-50 text-sm mb-1">Cancelled</p>
                    <h4 class="text-3xl font-bold">{{ $cancelledOrders ?? 0 }}</h4>
                </div>
                <i class="fas fa-times-circle text-3xl opacity-80"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Recent Orders</h2>
                <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-1">
                    View All <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            @if(isset($recentOrders) && $recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Order ID</th>
                                <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Customer</th>
                                <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Amount</th>
                                <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Status</th>
                                <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-2 font-semibold text-gray-800">#{{ $order->id }}</td>
                                <td class="py-3 px-2 text-gray-600">{{ $order->user->name ?? 'N/A' }}</td>
                                <td class="py-3 px-2 font-semibold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="py-3 px-2">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                        @if($order->status == 'completed') bg-green-100 text-green-700
                                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-700
                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500">No orders yet</p>
                </div>
            @endif
        </div>

        <!-- Top Products & Quick Actions -->
        <div class="space-y-6">
            <!-- Top Products -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Top Products</h2>
                @if(isset($topProducts) && $topProducts->count() > 0)
                    <div class="space-y-3">
                        @foreach($topProducts->take(5) as $product)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ Str::limit($product->name, 20) }}</p>
                                    <p class="text-xs text-gray-500">{{ $product->sold_count ?? 0 }} sold</p>
                                </div>
                            </div>
                            <p class="font-bold text-gray-700 text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 text-sm py-4">No products data</p>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl shadow-md p-6 text-white">
                <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.products.create') }}" class="flex items-center p-3 bg-white bg-opacity-10 rounded-lg hover:bg-opacity-20 transition-all backdrop-blur-sm">
                        <div class="w-10 h-10 bg-green-500 bg-opacity-80 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span class="font-medium">Add New Product</span>
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center p-3 bg-white bg-opacity-10 rounded-lg hover:bg-opacity-20 transition-all backdrop-blur-sm">
                        <div class="w-10 h-10 bg-blue-500 bg-opacity-80 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <span class="font-medium">Manage Orders</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center p-3 bg-white bg-opacity-10 rounded-lg hover:bg-opacity-20 transition-all backdrop-blur-sm">
                        <div class="w-10 h-10 bg-purple-500 bg-opacity-80 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-tags"></i>
                        </div>
                        <span class="font-medium">Manage Categories</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 bg-white bg-opacity-10 rounded-lg hover:bg-opacity-20 transition-all backdrop-blur-sm">
                        <div class="w-10 h-10 bg-orange-500 bg-opacity-80 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <span class="font-medium">Manage Users</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    @if(isset($lowStockItems) && $lowStockItems->count() > 0)
    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl shadow-md p-6 mb-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-bold text-red-800 mb-2">Low Stock Alert!</h3>
                <p class="text-red-700 mb-3">The following products are running low on stock:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($lowStockItems as $item)
                    <div class="bg-white rounded-lg p-3 border border-red-200">
                        <p class="font-semibold text-gray-800 text-sm">{{ $item->name }}</p>
                        <p class="text-xs text-red-600 font-medium">Only {{ $item->stock }} left</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Categories Overview -->
    <!-- <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Categories Overview</h2>
        @if(isset($categories) && $categories->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-4 text-center hover:shadow-lg transition-all cursor-pointer border border-indigo-100">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-tag text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-800 text-sm mb-1">{{ $category->name }}</h4>
                    <p class="text-xs text-gray-600">{{ $category->products_count ?? 0 }} products</p>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 py-8">No categories yet</p>
        @endif
    </div> -->
</div>
@endsection