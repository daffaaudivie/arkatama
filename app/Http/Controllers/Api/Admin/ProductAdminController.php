<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductAdminController extends Controller
{
    // List semua produk
    public function index()
    {
        return response()->json(Product::all());
    }

    // Tambah produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:4096',
        ]);

        $data = $request->only(['name','price','stock','category_id','description']);

        // Upload gambar — simpan nama file saja
        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('products', $filename, 'public');
            $data['image'] = $filename;     // hanya nama file
        }

        $product = Product::create($data);

        return response()->json([
            'message' => 'Produk berhasil dibuat',
            'product' => $product
        ]);
    }

    // Detail produk
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json($product);
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'price'       => 'sometimes|required|numeric|min:0',
            'stock'       => 'sometimes|required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:4096',
        ]);

        $data = $request->only(['name','price','stock','category_id','description']);

        // Jika update gambar baru
        if ($request->hasFile('image')) {

            // Hapus gambar lama
            if ($product->image && Storage::disk('public')->exists("products/{$product->image}")) {
                Storage::disk('public')->delete("products/{$product->image}");
            }

            // Upload gambar baru
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('products', $filename, 'public');

            $data['image'] = $filename;  // hanya nama file
        }

        $product->update($data);

        return response()->json([
            'message' => 'Produk berhasil diperbarui',
            'product' => $product
        ]);
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Hapus gambar fisik
        if ($product->image && Storage::disk('public')->exists("products/{$product->image}")) {
            Storage::disk('public')->delete("products/{$product->image}");
        }

        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
