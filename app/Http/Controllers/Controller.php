<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Hanya check jika user sudah login
            if (!Auth::check()) {
                return $next($request);
            }
            
            $path = $request->path();
            $user = Auth::user();
            
            // Check role untuk admin routes
            if (str_starts_with($path, 'admin')) {
                if (!in_array($user->role, ['admin', 'super_admin'], true)) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->route('login')->withErrors(['error' => 'Akses tidak diizinkan.']);
                }
            }
            
            // Check role untuk wisatawan routes
            if (str_starts_with($path, 'wisatawan')) {
                if ($user->role !== 'wisatawan') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->route('login')->withErrors(['error' => 'Akses tidak diizinkan.']);
                }
            }
            
            return $next($request);
        });
    }
}
