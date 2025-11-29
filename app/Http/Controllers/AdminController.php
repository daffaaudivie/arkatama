<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::paginate(10);
        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:admins',
            'password'=>'required|string|min:6',
        ]);

        Admin::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        return redirect()->route('admins.index')->with('success','Admin berhasil ditambahkan');
    }

    public function edit(Admin $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:admins,email,'.$admin->id,
            'password'=>'nullable|string|min:6',
        ]);

        $data = $request->only('name','email');
        if($request->filled('password')) $data['password'] = Hash::make($request->password);

        $admin->update($data);
        return redirect()->route('admins.index')->with('success','Admin berhasil diperbarui');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.index')->with('success','Admin berhasil dihapus');
    }
}
