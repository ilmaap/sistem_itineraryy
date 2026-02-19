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
                <h1>Dashboard Admin</h1>
                <p>
                    <i class="fas fa-hand-sparkles"></i>
                    Selamat datang, <strong>{{ $user->nama ?? 'Admin' }}</strong>
                </p>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <i class="fas fa-user-shield"></i>
                    <div class="user-details">
                        <span class="user-name">{{ $user->nama ?? 'Admin' }}</span>
                        <span class="user-role">{{ $user->role ?? 'admin' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-1">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['total_users'] ?? 0 }}</div>
                    <div class="stat-label">Total Pengguna</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-2">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['total_destinasi'] ?? 0 }}</div>
                    <div class="stat-label">Total Destinasi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-3">
                    <i class="fas fa-suitcase"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['total_paket'] ?? 0 }}</div>
                    <div class="stat-label">Total Paket</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-4">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['total_restaurant'] ?? 0 }}</div>
                    <div class="stat-label">Total Restaurant</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-5">
                    <i class="fas fa-bed"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['total_akomodasi'] ?? 0 }}</div>
                    <div class="stat-label">Total Akomodasi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-wrapper stat-icon-6">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $stats['total_libur'] ?? 0 }}</div>
                    <div class="stat-label">Hari Libur</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="dashboard-content">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h2>
                <p class="section-subtitle">Akses cepat ke menu manajemen</p>
            </div>
            
            <div class="quick-actions">
                <a href="{{ route('admin.user.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="action-title">Kelola Pengguna</div>
                    <div class="action-desc">Manajemen data pengguna sistem</div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.destinasi.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="action-title">Kelola Destinasi</div>
                    <div class="action-desc">Tambah/edit destinasi wisata</div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.paket.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-suitcase"></i>
                    </div>
                    <div class="action-title">Kelola Paket</div>
                    <div class="action-desc">Kelola paket wisata</div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.restaurant.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="action-title">Kelola Restaurant</div>
                    <div class="action-desc">Manajemen data restaurant</div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.akomodasi.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-bed"></i>
                    </div>
                    <div class="action-title">Kelola Akomodasi</div>
                    <div class="action-desc">Manajemen data akomodasi</div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.libur_nasional.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="action-title">Kelola Hari Libur</div>
                    <div class="action-desc">Manajemen hari libur nasional</div>
                    <div class="action-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>

