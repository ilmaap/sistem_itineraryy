<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .dashboard-header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-left h1 {
            font-size: 1.75rem;
            color: #1a202c;
            margin-bottom: 0.25rem;
        }
        
        .header-left p {
            color: #718096;
            font-size: 0.9rem;
        }
        
        .header-right {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f7fafc;
            border-radius: 8px;
        }
        
        .user-info i {
            color: #4299e1;
            font-size: 1.25rem;
        }
        
        .user-details {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: #718096;
            text-transform: capitalize;
        }
        
        .btn-logout {
            padding: 0.625rem 1.25rem;
            background: #e53e3e;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        
        .btn-logout:hover {
            background: #c53030;
        }
        
        .dashboard-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .welcome-card {
            text-align: center;
            padding: 3rem 2rem;
        }
        
        .welcome-icon {
            font-size: 4rem;
            color: #4299e1;
            margin-bottom: 1rem;
        }
        
        .welcome-title {
            font-size: 2rem;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }
        
        .welcome-subtitle {
            color: #718096;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .action-card {
            padding: 1.5rem;
            background: #f7fafc;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .action-icon {
            font-size: 2rem;
            color: #4299e1;
            margin-bottom: 0.5rem;
        }
        
        .action-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        
        .action-desc {
            font-size: 0.85rem;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="header-left">
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h1>
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
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Keluar
                    </button>
                </form>
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

