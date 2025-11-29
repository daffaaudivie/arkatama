<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string',
        ]);

        // Cek admin
        $admin = Admin::where('email', $request->email)->first();
        if($admin && Hash::check($request->password, $admin->password)){
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard');
        }

        // Cek user biasa
        $user = User::where('email', $request->email)->first();
        if($user && Hash::check($request->password, $user->password)){
            Auth::login($user);
            return redirect()->route('user.dashboard'); // user dashboard
        }

        throw ValidationException::withMessages([
            'email'=>['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        } else {
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
