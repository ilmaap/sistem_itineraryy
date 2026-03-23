<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login tunggal (untuk semua role).
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        // Set cache control headers untuk mencegah browser cache halaman login
        return response()
            ->view('login')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    /**
     * Menangani proses login tunggal (email + password).
     * Role ditentukan otomatis dari kolom role di tabel user.
     */
    public function login(Request $request)
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
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])
                ->withInput($request->except('password'));
        }

        /** @var User $user */
        $user = Auth::user();

        // Tolak login jika akun dinonaktifkan oleh admin.
        // Fallback: jika kolom `is_active` belum ada (null), anggap user masih aktif
        // supaya tidak mengunci login sebelum migration dijalankan.
        if (!($user->is_active ?? true)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda dinonaktifkan oleh admin.'])
                ->withInput($request->except('password'));
        }

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    /**
     * Redirect user berdasarkan role yang tersimpan di kolom role.
     */
    protected function redirectByRole(User $user)
    {
        if ($user->role === 'admin' || $user->role === 'super_admin') {
            return redirect()->route('admin.dashboard');
        }

        // Default: wisatawan
        return redirect()->route('wisatawan.dashboard');
    }


    /**
     * Menangani proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect dengan cache control headers untuk mencegah back button
        return redirect()->route('login')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}

