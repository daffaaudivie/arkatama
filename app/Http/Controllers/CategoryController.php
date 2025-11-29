<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.category_index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.category_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success','Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.category_edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success','Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success','Kategori berhasil dihapus');
    }
}
