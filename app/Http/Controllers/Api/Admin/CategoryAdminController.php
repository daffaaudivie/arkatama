<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryAdminController extends Controller
{
    // List semua kategori
    public function index()
    {
        return response()->json(Category::all());
    }

    // Tambah kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description']);

        $category = Category::create($data);

        return response()->json([
            'message' => 'Kategori berhasil dibuat',
            'category' => $category
        ]);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        return response()->json($category);
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description']);

        $category->update($data);

        return response()->json([
            'message' => 'Kategori berhasil diperbarui',
            'category' => $category
        ]);
    }

    // Hapus kategori
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }
}