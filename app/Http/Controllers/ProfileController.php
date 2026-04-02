<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini tidak sesuai.');
        }

        // Memberitahu intelephense/editor bahwa Auth::user() adalah turunan Model Eloquent
        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return back()->with('success', 'Password berhasil diubah.');
    }
}
