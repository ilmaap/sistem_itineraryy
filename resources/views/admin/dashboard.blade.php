<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
</head>
<body>
    @include('layout.adminnavbar')

    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="header-left">
                <h1> Dashboard Admin</h1>
                <p>Selamat datang, {{ $user->nama ?? 'Admin' }}</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <i class="fas fa-user-shield"></i>
                    <div class="user-details">
                        <span class="user-name">{{ $user->nama ?? 'Admin' }}</span>
                        <span class="user-role">{{ $user->role ?? 'admin' }}</span>
                    </div>
                </div>
                <!-- <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Keluar
                    </button>
                </form> -->
            </div>
        </div>
        
        <div class="dashboard-content">
            <div class="welcome-card">
                <div class="welcome-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2 class="welcome-title">Panel Administrasi</h2>
                <p class="welcome-subtitle">Kelola sistem itinerary wisata dari sini</p>
                
                <div class="quick-actions">
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="action-title">Kelola Pengguna</div>
                        <div class="action-desc">Manajemen data pengguna</div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div class="action-title">Kelola Destinasi</div>
                        <div class="action-desc">Tambah/edit destinasi wisata</div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-route"></i>
                        </div>
                        <div class="action-title">Kelola Itinerary</div>
                        <div class="action-desc">Lihat dan kelola itinerary</div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="action-title">Laporan</div>
                        <div class="action-desc">Statistik dan laporan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

