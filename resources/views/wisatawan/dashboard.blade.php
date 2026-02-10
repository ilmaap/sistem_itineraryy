<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wisatawan - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboardwisatawan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
</head>
<body>
     @include('layout.wisatawannavbar')
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="header-left">
                <h1><i class="fas fa-home"></i> Dashboard Wisatawan</h1>
                <p>Selamat datang, {{ $user->nama ?? 'Wisatawan' }}</p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <i class="fas fa-user"></i>
                    <div class="user-details">
                        <span class="user-name">{{ $user->nama ?? 'Wisatawan' }}</span>
                        <span class="user-role">{{ $user->role ?? 'wisatawan' }}</span>
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
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h2 class="welcome-title">Selamat Datang, {{ $user->nama ?? 'Wisatawan' }}!</h2>
                <p class="welcome-subtitle">Rencanakan perjalanan wisata Anda dengan mudah</p>
                
                <div class="quick-actions">
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="action-title">Buat Itinerary Baru</div>
                        <div class="action-desc">Buat rencana perjalanan baru</div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="action-title">Itinerary Saya</div>
                        <div class="action-desc">Lihat itinerary yang sudah dibuat</div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-map"></i>
                        </div>
                        <div class="action-title">Destinasi Wisata</div>
                        <div class="action-desc">Jelajahi destinasi menarik</div>
                    </div>
                    <div class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="action-title">Favorit</div>
                        <div class="action-desc">Destinasi favorit Anda</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

