<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $user = Auth::user();
        
        // Pastikan user ini bukan admin
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard')->with('error', 'Akun admin tidak dapat mengakses halaman anggota.');
        }
        
        // Cari data member yang terkait
        $member = $user->member;
        
        // Jika tidak memiliki data member, beri pesan khusus
        if (!$member) {
            // Tetap izinkan akses ke dashboard, tapi dengan pesan peringatan
            // Ini akan membuat pesan error khusus ditampilkan di dashboard
            session()->flash('warning', 'Akun Anda belum terhubung dengan data keanggotaan. Silakan hubungi administrator.');
            return $next($request);
        }
        
        // Verifikasi approval_status untuk member
        if ($member->approval_status !== 'approved') {
            return redirect('/login')->with('error', 'Pendaftaran Anda sedang diproses atau ditolak. Silakan hubungi administrator.');
        }
        
        return $next($request);
    }
}
