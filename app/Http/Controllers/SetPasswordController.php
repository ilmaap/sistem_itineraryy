<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class SetPasswordController extends Controller
{
    /**
     * Menampilkan form untuk membuat password baru.
     */
    public function showResetForm(Request $request, $token = null)
    {
        $user = User::where('email', $request->email)->first();
        
        /** @var \Illuminate\Auth\Passwords\PasswordBroker $passwordBroker */
        $passwordBroker = Password::broker();

        // Cek apakah token masih ada/asli, jika hilang maka keluarkan dari halaman
        if (!$user || !$passwordBroker->tokenExists($user, $token)) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Peringatan: Link keamanan untuk mengatur password Anda sudah tidak berlaku / telah kedaluwarsa. Silakan hubungi Admin.']);
        }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Memproses penyimpanan password baru.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        // Menggunakan Laravel Password Broker untuk validasi token dan mengupdate password
        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Berhasil! Password Anda telah dibuat. Silakan login.');
        }

        return back()->withInput($request->only('email'))
                     ->withErrors(['email' => __($status)]);
    }
}
