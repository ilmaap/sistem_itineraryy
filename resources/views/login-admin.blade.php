<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk sebagai Admin - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <main class="auth-wrapper">
        <section class="auth-card" aria-label="Form login admin">
            <div class="brand">
                <i class="fas fa-route" aria-hidden="true"></i>
                <strong>Itinerary Wisata</strong>
            </div>

            <h1 class="auth-title">Masuk sebagai Admin</h1>
            <p class="auth-subtitle">
                Silakan masukkan akun admin atau super admin Anda untuk melanjutkan ke dashboard admin.
            </p>

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin: 0.5rem 0 0 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.admin.submit') }}" autocomplete="on" novalidate>
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-row">
                        <i class="fa-solid fa-envelope input-icon" aria-hidden="true"></i>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            class="input with-icon"
                            placeholder="contoh@email.com"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-row">
                        <i class="fa-solid fa-lock input-icon" aria-hidden="true"></i>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="input with-icon"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Masuk sebagai</label>
                    <div class="input-row">
                        <i class="fa-solid fa-user-tag input-icon" aria-hidden="true"></i>
                        <select id="role" name="role" class="input with-icon" required>
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih peran</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                    </div>
                    @error('role')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; padding-left: 0.25rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>
                    Masuk
                </button>
            </form>

            <div class="auth-footer">
                <p style="margin: 0.5rem 0;">
                    <a href="{{ route('landing') }}">Kembali ke Beranda</a>
                </p>
                <p style="margin: 0.5rem 0; font-size: 0.875rem; color: var(--text-gray);">
                    Wisatawan? <a href="{{ route('login.wisatawan') }}" style="font-weight: 700;">Masuk sebagai Wisatawan</a>
                </p>
            </div>
        </section>
    </main>
</body>
</html>

