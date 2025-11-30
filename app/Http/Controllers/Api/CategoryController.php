<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    // GET /categories  → tampilkan semua categories
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'message' => 'List all categories',
            'data' => $categories
        ], 200);
    }

    // GET /category/{id} → tampilkan 1 category berdasarkan ID
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Category',
            'data' => $category
        ], 200);
    }
}