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
     * Support both web (session) and API (token) authentication
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Deteksi apakah request dari API atau Web
        $isApiRequest = $request->expectsJson() || $request->is('api/*');

        // Cek admin
        $admin = Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            
            if ($isApiRequest) {
                // API Response - buat token
                $admin->tokens()->delete(); // hapus token lama
                $token = $admin->createToken('admin-token', ['admin'])->plainTextToken;
                
                return response()->json([
                    'message' => 'Login successful',
                    'user_type' => 'admin',
                    'admin' => $admin,
                    'token' => $token,
                    'token_type' => 'Bearer',
                ]);
            } else {
                // Web Response - session login
                Auth::guard('admin')->login($admin);
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
        }

        // Cek user biasa
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            
            if ($isApiRequest) {
                // API Response - buat token
                $user->tokens()->delete(); // hapus token lama
                $token = $user->createToken('user-token', ['user'])->plainTextToken;
                
                return response()->json([
                    'message' => 'Login successful',
                    'user_type' => 'user',
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer',
                ]);
            } else {
                // Web Response - session login
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->route('user.dashboard');
            }
        }

        // Credentials tidak cocok
        if ($isApiRequest) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.',
                'errors' => [
                    'email' => ['The provided credentials do not match our records.']
                ]
            ], 422);
        } else {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     * Support both web and API logout
     */
    public function destroy(Request $request)
    {
        $isApiRequest = $request->expectsJson() || $request->is('api/*');

        if ($isApiRequest) {
            // API Logout - hapus current token
            if ($request->user()) {
                $request->user()->currentAccessToken()->delete();
                return response()->json(['message' => 'Logout successful']);
            }
            return response()->json(['message' => 'No active session'], 401);
        } else {
            // Web Logout - hapus session
            if (Auth::guard('admin')->check()) {
                Auth::guard('admin')->logout();
            } else {
                Auth::logout();
            }

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        }
    }
}