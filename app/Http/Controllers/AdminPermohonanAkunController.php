<?php

namespace App\Http\Controllers;

use App\Models\PermohonanAkun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Mail\SetPasswordMail;

class AdminPermohonanAkunController extends Controller
{
    /**
     * Menampilkan daftar permohonan akun (opsional filter status).
     */
    public function index(Request $request)
    {
        $currentUser = auth()->user();

        // Guard role (admin & super_admin).
        if (!$currentUser || !in_array($currentUser->role, ['admin', 'super_admin'], true)) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['error' => 'Akses tidak diizinkan.']);
        }

        $allowedStatuses = [
            PermohonanAkun::STATUS_MENUNGGU,
            PermohonanAkun::STATUS_DISETUJUI,
            PermohonanAkun::STATUS_DITOLAK,
        ];

        // Default: tampilkan semua status supaya admin bisa melihat riwayat.
        $status = $request->get('status', 'all');

        $query = PermohonanAkun::query();
        if (is_string($status) && $status !== 'all' && in_array($status, $allowedStatuses, true)) {
            $query->where('status', $status);
        }

        // Search by nama/email/no_telp.
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_telp', 'like', '%' . $search . '%');
            });
        }

        $permohonan = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.index_permohonan_akun', [
            'permohonan' => $permohonan,
            'search' => $request->search ?? '',
            'status' => $status,
        ]);
    }

    /**
     * Approve permohonan:
     * - Copy data permohonan ke tabel `user` (role wisatawan)
     * - Set status permohonan menjadi disetujui
     */
    public function approve(Request $request, int $id)
    {
        $currentUser = auth()->user();
        if (!$currentUser || !in_array($currentUser->role, ['admin', 'super_admin'], true)) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['error' => 'Akses tidak diizinkan.']);
        }

        $permohonan = PermohonanAkun::findOrFail($id);

        if ($permohonan->status !== PermohonanAkun::STATUS_MENUNGGU) {
            return redirect()
                ->route('admin.permohonan.index')
                ->with('error', 'Permohonan ini tidak dapat disetujui karena statusnya sudah diproses.');
        }

        $autoGenerate = env('AUTO_GENERATE_PASSWORD', false);

        if (!$autoGenerate) {
            $validated = $request->validate([
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|string|min:6',
            ], [
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            ]);
        }

        // Email harus unik karena kolom email di tabel `user` unique.
        if (User::where('email', $permohonan->email)->exists()) {
            return redirect()
                ->route('admin.permohonan.index')
                ->with('error', 'Email permohonan sudah terdaftar, tidak bisa membuat akun duplikat.');
        }

        $user = User::create([
            'nama' => $permohonan->nama,
            'email' => $permohonan->email,
            'no_telp' => $permohonan->no_telp,
            'password' => $autoGenerate ? Hash::make(Str::random(40)) : Hash::make($validated['password']),
            'role' => 'wisatawan',
        ]);

        if ($autoGenerate) {
            /** @var \Illuminate\Auth\Passwords\PasswordBroker $passwordBroker */
            $passwordBroker = Password::broker();
            $token = $passwordBroker->createToken($user);
            $url = route('password.reset', ['token' => $token, 'email' => $user->email]);
            Mail::to($user->email)->send(new SetPasswordMail($user->nama, $url));
        }

        $permohonan->update([
            'status' => PermohonanAkun::STATUS_DISETUJUI,
        ]);

        return redirect()
            ->route('admin.permohonan.index')
            ->with('success', 'Permohonan berhasil disetujui' . ($autoGenerate ? ' dan link pengaturan password telah dikirim ke email wisatawan.' : ' dan akun wisatawan telah dibuat.'));
    }

    /**
     * Reject permohonan:
     * - Set status permohonan menjadi ditolak
     * - Tidak membuat user baru
     */
    public function reject(Request $request, int $id)
    {
        $currentUser = auth()->user();
        if (!$currentUser || !in_array($currentUser->role, ['admin', 'super_admin'], true)) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['error' => 'Akses tidak diizinkan.']);
        }

        $permohonan = PermohonanAkun::findOrFail($id);

        if ($permohonan->status !== PermohonanAkun::STATUS_MENUNGGU) {
            return redirect()
                ->route('admin.permohonan.index')
                ->with('error', 'Permohonan ini tidak dapat ditolak karena statusnya sudah diproses.');
        }

        $permohonan->update([
            'status' => PermohonanAkun::STATUS_DITOLAK,
        ]);

        return redirect()
            ->route('admin.permohonan.index')
            ->with('success', 'Permohonan ditolak.');
    }
}


