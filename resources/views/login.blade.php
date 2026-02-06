<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <main class="auth-wrapper">
        <section class="auth-card" aria-label="Form login">
            <div class="brand">
                <i class="fas fa-route" aria-hidden="true"></i>
                <strong>Itinerary Wisata</strong>
            </div>

            <h1 class="auth-title">Masuk ke Sistem</h1>
            <p class="auth-subtitle">
                Silakan masukkan akun Anda untuk melanjutkan. Pilih peran masuk sebagai <strong>Wisatawan</strong> atau <strong>Admin</strong>.
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

            <form method="POST" action="{{ route('login.submit') }}" autocomplete="on" novalidate>
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
                            <option value="wisatawan" {{ old('role') === 'wisatawan' ? 'selected' : '' }}>Wisatawan</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i>
                    Masuk
                </button>
            </form>

            <div class="auth-footer">
                <a href="{{ url('/') }}">Kembali ke Beranda</a>
            </div>
        </section>
    </main>
</body>
</html>


