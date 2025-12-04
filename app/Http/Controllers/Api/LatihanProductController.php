<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Facades\Storage;

class LatihanProductController extends Controller
{

    public function index()
    {
        $products = Product::with('category')->get();
        return new ProductCollection($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $imageName = time().'_'.$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/products', $imageName);

        $product = Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'image' => $imageName,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
        ]);

        return new ProductResource($product);
    }

    // Update product (admin)
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image' => 'sometimes|image|max:2048',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            // Hapus image lama
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }

            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/products', $imageName);
            $product->image = $imageName;
        }

        $product->update($validated);

        return new ProductResource($product);
    }

 
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product berhasil dihapus',
        ]);
    }
}
