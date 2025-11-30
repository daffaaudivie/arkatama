<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    // ===== Dashboard User =====
    public function Index()
    {
        $userId = Auth::id();

        $totalOrders = Transaction::where('user_id', $userId)->count();
        $pendingOrders = Transaction::where('user_id', $userId)->where('status', 'pending')->count();
        $completedOrders = Transaction::where('user_id', $userId)->where('status', 'paid')->count();
        $totalSpent = Transaction::where('user_id', $userId)->where('status', 'paid')->sum('total_price');
        $recentOrders = Transaction::where('user_id', $userId)->latest()->take(5)->get();

        return view('user.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalSpent',
            'recentOrders'
        ));
    }

    // ===== Dashboard Admin =====
    public function adminIndex()
    {
        $totalRevenue = Transaction::where('status', 'paid')->sum('total_price');

        $lastMonthRevenue = Transaction::where('status', 'paid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_price');

        $revenueGrowth = $lastMonthRevenue > 0
            ? round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2)
            : 0;

        $totalOrders = Transaction::count();
        $pendingOrders = Transaction::where('status', 'pending')->count();
        $processingOrders = Transaction::where('status', 'processing')->count();
        $completedOrders = Transaction::where('status', 'paid')->count();
        $cancelledOrders = Transaction::where('status', 'cancelled')->count();

        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 5)->count();
        $lowStockItems = Product::where('stock', '<=', 5)->get();

        $totalCustomers = User::count();
        $newCustomers = User::whereMonth('created_at', now()->month)->count();

        $recentOrders = Transaction::latest()->take(10)->get();
        $topProducts = Product::select('products.*', DB::raw('SUM(transaction_details.quantity) as sold_count'))
        ->leftJoin('transaction_details', 'products.id', '=', 'transaction_details.product_id')
        ->groupBy('products.id')
        ->orderByDesc('sold_count')
        ->take(5)
        ->get();
        $categories = Category::withCount('products')->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'revenueGrowth',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'totalProducts',
            'lowStockProducts',
            'lowStockItems',
            'totalCustomers',
            'newCustomers',
            'recentOrders',
            'topProducts',
            'categories'
        ));
    }
}
