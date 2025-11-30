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

    // ← TAMBAH DEBUG INI!
    \Log::info('=== DEBUG UPDATE PRODUCT ===');
    \Log::info('Product ID:', [$id]);
    \Log::info('Request Input:', $request->all());
    \Log::info('Product Before:', $product->toArray());

    $request->validate([
        'name'        => 'sometimes|required|string|max:255',
        'price'       => 'sometimes|required|numeric|min:0',
        'stock'       => 'sometimes|required|integer|min:0',
        'category_id' => 'sometimes|required|exists:categories,id',
        'description' => 'nullable|string',
        'image'       => 'nullable|image|max:4096',
    ]);

    $data = $request->only(['name','price','stock','category_id','description']);
    
    // ← FILTER NULL/EMPTY
    $data = array_filter($data, function($value) {
        return $value !== null && $value !== '';
    });

    \Log::info('Filtered Data:', $data);

    // ← CEK APAKAH ADA PERUBAHAN
    $hasChanges = false;
    foreach ($data as $key => $value) {
        if ($product->{$key} != $value) {
            $hasChanges = true;
            \Log::info("Change detected: {$key} from '{$product->{$key}}' to '{$value}'");
        }
    }

    if (!$hasChanges && !$request->hasFile('image')) {
        \Log::info('No changes detected!');
        return response()->json([
            'message' => 'Tidak ada perubahan data',
            'product' => $product
        ]);
    }

    // Handle image upload
    if ($request->hasFile('image')) {
        if ($product->image && Storage::disk('public')->exists("products/{$product->image}")) {
            Storage::disk('public')->delete("products/{$product->image}");
        }

        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('products', $filename, 'public');
        $data['image'] = $filename;
        $hasChanges = true;
    }

    // ← FORCE UPDATE TIMESTAMP
    $data['updated_at'] = now();

    $updateResult = $product->update($data);
    
    \Log::info('Update Result:', [$updateResult]);
    \Log::info('Product After:', $product->fresh()->toArray());
    \Log::info('=== END DEBUG ===');

    return response()->json([
        'message' => 'Produk berhasil diperbarui',
        'product' => $product->fresh()
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
