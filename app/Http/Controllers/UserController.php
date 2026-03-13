<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index(Request $request)
    {
        $currentUser = auth()->user();
        $query = User::query();

        // Filter berdasarkan role user yang login
        // Admin hanya bisa melihat wisatawan
        // Super Admin bisa melihat semua
        if ($currentUser->role === 'admin') {
            $query->where('role', 'wisatawan');
        }
        // Super admin bisa melihat semua, tidak perlu filter

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('no_telp', 'like', '%' . $search . '%')
                  ->orWhere('role', 'like', '%' . $search . '%');
            });
        }

        // Pagination
        $user = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.index_user', [
            'user' => $user,
            'search' => $request->search ?? ''
        ]);
    }

    /**
     * Menampilkan form untuk membuat user baru
     */
    public function create()
    {
        return view('admin.kelola_user');
    }
    
    /**
     * Cek apakah user bisa mengelola user tertentu berdasarkan role
     */
    private function canManageUser($targetUser)
    {
        $currentUser = auth()->user();
        
        // Super admin bisa mengelola semua
        if ($currentUser->role === 'super_admin') {
            return true;
        }
        
        // Admin hanya bisa mengelola wisatawan
        if ($currentUser->role === 'admin') {
            return $targetUser->role === 'wisatawan';
        }
        
        return false;
    }
    
    /**
     * Validasi role yang bisa dibuat/diupdate berdasarkan user yang login
     */
    private function getAllowedRoles()
    {
        $currentUser = auth()->user();
        
        // Super admin bisa membuat semua role
        if ($currentUser->role === 'super_admin') {
            return ['wisatawan', 'admin', 'super_admin'];
        }
        
        // Admin hanya bisa membuat wisatawan
        if ($currentUser->role === 'admin') {
            return ['wisatawan'];
        }
        
        return [];
    }

    /**
     * Menyimpan user baru
     */
    public function store(Request $request)
    {
        $allowedRoles = $this->getAllowedRoles();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email|max:255',
            'no_telp' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'role' => 'required|in:' . implode(',', $allowedRoles),
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak diizinkan untuk akun Anda.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.user.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Cek apakah user yang login bisa mengelola user ini
        if (!$this->canManageUser($user)) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengelola pengguna ini.');
        }
        
        return view('admin.kelola_user', ['user' => $user]);
    }

    /**
     * Mengupdate user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Cek apakah user yang login bisa mengelola user ini
        if (!$this->canManageUser($user)) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengelola pengguna ini.');
        }
        
        $allowedRoles = $this->getAllowedRoles();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $id . '|max:255',
            'no_telp' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:' . implode(',', $allowedRoles),
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak diizinkan untuk akun Anda.',
        ]);

        // Jika password diisi, hash password baru
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.user.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Jangan izinkan menghapus user yang sedang login
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Tidak dapat menghapus akun yang sedang digunakan.');
        }
        
        // Cek apakah user yang login bisa mengelola user ini
        if (!$this->canManageUser($user)) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus pengguna ini.');
        }

        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}

