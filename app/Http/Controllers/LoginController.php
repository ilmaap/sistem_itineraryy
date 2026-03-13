<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login wisatawan
     */
    public function showWisatawanLoginForm()
    {
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin' || $user->role === 'super_admin') {
                Auth::logout();
            } else {
                return redirect()->route('wisatawan.dashboard');
            }
        }
        
        return view('login-wisatawan');
    }

    /**
     * Menangani proses login wisatawan
     */
    public function wisatawanLogin(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login.wisatawan')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');

        // Coba melakukan autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Verifikasi role user harus wisatawan
            if ($user->role !== 'wisatawan') {
                Auth::logout();
                return redirect()->route('login.wisatawan')
                    ->withErrors(['email' => 'Akun ini bukan akun wisatawan. Silakan gunakan halaman login yang sesuai.'])
                    ->withInput($request->except('password'));
            }

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            return redirect()->intended('/wisatawan/dashboard');
        }

        // Jika autentikasi gagal
        return redirect()->route('login.wisatawan')
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])
            ->withInput($request->except('password'));
    }

    /**
     * Menampilkan halaman login admin (untuk admin dan super admin)
     */
    public function showAdminLoginForm()
    {
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin' || $user->role === 'super_admin') {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
            }
        }
        
        return view('login-admin');
    }

    /**
     * Menangani proses login admin (untuk admin dan super admin)
     */
    public function adminLogin(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,super_admin',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Pilih peran untuk masuk.',
            'role.in' => 'Peran yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login.admin')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $selectedRole = $request->input('role');

        // Coba melakukan autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Verifikasi role user harus sesuai dengan yang dipilih
            if ($user->role !== $selectedRole) {
                Auth::logout();
                return redirect()->route('login.admin')
                    ->withErrors(['role' => 'Peran yang dipilih tidak sesuai dengan akun Anda. Akun ini adalah ' . ($user->role === 'admin' ? 'Admin' : ($user->role === 'super_admin' ? 'Super Admin' : 'Wisatawan')) . '.'])
                    ->withInput($request->except('password'));
            }

            // Verifikasi role user harus admin atau super_admin
            if ($user->role !== 'admin' && $user->role !== 'super_admin') {
                Auth::logout();
                return redirect()->route('login.admin')
                    ->withErrors(['email' => 'Akun ini bukan akun admin. Silakan gunakan halaman login yang sesuai.'])
                    ->withInput($request->except('password'));
            }

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }

        // Jika autentikasi gagal
        return redirect()->route('login.admin')
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])
            ->withInput($request->except('password'));
    }

    /**
     * Menangani proses logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect berdasarkan role sebelumnya
        if ($role === 'admin' || $role === 'super_admin') {
            return redirect()->route('login.admin');
        } else {
            return redirect()->route('login.wisatawan');
        }
    }
}

