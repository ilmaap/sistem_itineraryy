<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Destinasi;
use App\Models\Paket;
use App\Models\Restaurant;
use App\Models\Akomodasi;
use App\Models\LiburNasional;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Validasi role
        if (!$user || !in_array($user->role, ['admin', 'super_admin'], true)) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['error' => 'Akses tidak diizinkan.']);
        }

        // Mengambil statistik
        $stats = [
            'total_users' => User::count(),
            'total_destinasi' => Destinasi::count(),
            'total_paket' => Paket::count(),
            'total_restaurant' => Restaurant::count(),
            'total_akomodasi' => Akomodasi::count(),
            'total_libur' => LiburNasional::count(),
        ];

        return view('admin.dashboard', [
            'user' => $user,
            'stats' => $stats
        ]);
    }
}

