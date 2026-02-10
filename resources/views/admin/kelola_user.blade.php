<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($user) ? 'Edit' : 'Tambah' }} Pengguna - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/userkelolaadmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="content-wrapper">
        <div class="user-form-container">
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-user"></i> {{ isset($user) ? 'Edit' : 'Tambah' }} Pengguna
                </h1>
                <h4 class="page-subtitle">{{ isset($user) ? 'Ubah informasi pengguna' : 'Tambahkan pengguna baru' }}</h4>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-container">
                <form action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}" method="POST">
                    @csrf
                    @if (isset($user))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="nama">
                            <i class="fas fa-user"></i> Nama Lengkap <span style="color: #e53e3e;">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            class="form-control" 
                            required 
                            value="{{ old('nama', $user->nama ?? '') }}"
                            placeholder="Masukkan nama lengkap"
                        >
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email <span style="color: #e53e3e;">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control" 
                                required 
                                value="{{ old('email', $user->email ?? '') }}"
                                placeholder="Masukkan email"
                            >
                        </div>

                        <div class="form-group">
                            <label for="no_telp">
                                <i class="fas fa-phone"></i> No. Telepon
                            </label>
                            <input 
                                type="text" 
                                id="no_telp" 
                                name="no_telp" 
                                class="form-control" 
                                value="{{ old('no_telp', $user->no_telp ?? '') }}"
                                placeholder="Masukkan nomor telepon"
                            >
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i> Password <span style="color: #e53e3e;">{{ isset($user) ? '' : '*' }}</span>
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control" 
                                {{ isset($user) ? '' : 'required' }}
                                placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password' }}"
                            >
                            @if(isset($user))
                                <small style="color: #718096; font-size: 0.875rem;">Kosongkan jika tidak ingin mengubah password</small>
                            @else
                                <small style="color: #718096; font-size: 0.875rem;">Minimal 6 karakter</small>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="role">
                                <i class="fas fa-user-tag"></i> Role <span style="color: #e53e3e;">*</span>
                            </label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="wisatawan" {{ old('role', $user->role ?? '') === 'wisatawan' ? 'selected' : '' }}>Wisatawan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ isset($user) ? 'Update Pengguna' : 'Simpan Pengguna' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

