<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Show login form for members
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    /**
     * Show login form for admins
     */
    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Log input credentials untuk debug (tanpa password asli)
        $email = $credentials['email'];
        
        // Cek apakah user dengan email tersebut ada
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            // User tidak ditemukan
            return back()->withErrors([
                'email' => 'Akun dengan email ini tidak ditemukan.',
            ])->withInput($request->except('password'));
        }
        
        // Coba login menggunakan Auth facade
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Arahkan ke dashboard berdasarkan peran
            if ($user->isAdmin()) {
                return redirect()->intended('admin/dashboard');
            } elseif ($user->isDistrictAdmin()) {
                return redirect()->intended('district-admin/dashboard');
            } else {
                return redirect()->intended('member/dashboard');
            }
        }
        
        // Cek apakah anggota punya data member
        if (!$user->isAdmin() && !$user->member_id) {
            return back()->withErrors([
                'email' => 'Akun Anda belum terhubung dengan data anggota. Silakan hubungi admin.',
            ])->withInput($request->except('password'));
        }
        
        // Verifikasi password secara manual untuk debug
        if (Hash::check($credentials['password'], $user->password)) {
            // Password seharusnya cocok, tapi Auth::attempt gagal
            return back()->withErrors([
                'email' => 'Terjadi kesalahan sistem saat login. Silakan hubungi admin.',
            ])->withInput($request->except('password'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak valid.',
        ])->withInput($request->except('password'));
    }

    // Registration methods removed as we are using member registration

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
