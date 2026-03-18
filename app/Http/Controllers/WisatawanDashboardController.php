<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WisatawanDashboardController extends Controller
{
    /**
     * Menampilkan dashboard wisatawan
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Validasi role
        if (!$user || $user->role !== 'wisatawan') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['error' => 'Akses tidak diizinkan.']);
        }

        return view('wisatawan.dashboard', [
            'user' => $user
        ]);
    }
}

