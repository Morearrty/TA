<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DistrictAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in and is a district admin
        if (!auth()->check() || !auth()->user()->isDistrictAdmin()) {
            // Redirect to appropriate page based on user role
            if (auth()->check() && auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Akses ditolak. Anda tidak memiliki izin sebagai admin distrik.');
            } else if (auth()->check()) {
                return redirect()->route('member.dashboard')
                    ->with('error', 'Akses ditolak. Anda tidak memiliki izin sebagai admin distrik.');
            } else {
                return redirect()->route('login');
            }
        }
        
        return $next($request);
    }
}
