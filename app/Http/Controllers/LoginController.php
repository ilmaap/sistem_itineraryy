<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLoginForm()
    {
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('wisatawan.dashboard');
            }
        }
        
        return view('login');
    }

    /**
     * Menangani proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:wisatawan,admin',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Pilih peran untuk masuk.',
            'role.in' => 'Peran yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');
        $role = $request->input('role');

        // Coba melakukan autentikasi
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Verifikasi role user
            if ($user->role !== $role) {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['role' => 'Peran yang dipilih tidak sesuai dengan akun Anda.'])
                    ->withInput($request->except('password'));
            }

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/wisatawan/dashboard');
            }
        }

        // Jika autentikasi gagal
        return redirect()->route('login')
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])
            ->withInput($request->except('password'));
    }

    /**
     * Menangani proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

