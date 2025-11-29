<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    // GET /product  → tampilkan semua product
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'message' => 'List all product',
            'data' => $products
        ], 200);
    }

    // GET /product/{id} → tampilkan 1 product berdasarkan ID
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail produk',
            'data' => $product
        ], 200);
    }
}
