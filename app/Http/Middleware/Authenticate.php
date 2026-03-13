<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * 
     * PENJELASAN:
     * - Middleware ini OTOMATIS digunakan oleh Laravel ketika route menggunakan middleware('auth')
     * - Jika TIDAK menggunakan custom redirect ini, bisa:
     *   1. Return null -> Laravel akan redirect ke route('login') (default)
     *   2. Atau hapus method ini -> akan menggunakan default Laravel
     * 
     * - Kita menggunakan custom redirect untuk mengarahkan user ke halaman login yang sesuai
     *   berdasarkan path yang mereka akses (admin -> login.admin, wisatawan -> login.wisatawan)
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Redirect ke login sesuai dengan path yang diakses
        $path = $request->path();
        if (str_starts_with($path, 'admin')) {
            return route('login.admin');
        } elseif (str_starts_with($path, 'wisatawan')) {
            return route('login.wisatawan');
        }

        // Default redirect ke login wisatawan
        return route('login.wisatawan');
    }
}
