<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        if (request()->is('admin/*')) {
        // Admin sees all products
        $products = Product::with('category')->paginate(10);
        return view('admin.products.product_index', compact('products'));
    } else {
        // User sees product list
        $products = Product::with('category')->paginate(12);
        return view('user.products.product_index', compact('products'));
    }
    }


    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        if (request()->is('user/*')) {
            return view('user.products.product_show', compact('product'));
        }
        return view('admin.products.product_show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.product_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'category_id'=>'required|exists:categories,id',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
            'description'=>'nullable|string',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/products', $filename);
            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success','Product berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.product_edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'category_id'=>'required|exists:categories,id',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
            'description'=>'nullable|string',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if($request->hasFile('image')){
            if($product->image) Storage::delete('public/products/'.$product->image);
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/products', $filename);
            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success','Product berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        if($product->image) Storage::delete('public/products/'.$product->image);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success','Product berhasil dihapus');
    }
}
