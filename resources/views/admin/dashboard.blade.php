<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminnavbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardadmin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

        <!-- Charts Section -->
        @php
            $chartStats = [
                'total_users' => intval($stats['total_users'] ?? 0),
                'total_destinasi' => intval($stats['total_destinasi'] ?? 0),
                'total_paket' => intval($stats['total_paket'] ?? 0),
                'total_restaurant' => intval($stats['total_restaurant'] ?? 0),
                'total_akomodasi' => intval($stats['total_akomodasi'] ?? 0),
                'total_libur' => intval($stats['total_libur'] ?? 0)
            ];
        @endphp
        <div class="charts-section" data-stats='{!! json_encode($chartStats) !!}'>
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-bar"></i>
                        Distribusi Data
                    </h3>
                    <p class="chart-subtitle">Grafik perbandingan jumlah data</p>
                </div>
                <div class="chart-wrapper">
                    <canvas id="dataChart"></canvas>
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-pie"></i>
                        Persentase Data
                    </h3>
                    <p class="chart-subtitle">Distribusi persentase data sistem</p>
                </div>
                <div class="chart-wrapper">
                    <canvas id="pieChart"></canvas>
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

    <script>
        // Ambil data dari data attribute
        var chartsSection = document.querySelector('.charts-section');
        var statsObject = chartsSection ? JSON.parse(chartsSection.getAttribute('data-stats') || '{}') : {};
        
        // Data untuk chart
        var statsValues = [
            statsObject.total_users || 0,
            statsObject.total_destinasi || 0,
            statsObject.total_paket || 0,
            statsObject.total_restaurant || 0,
            statsObject.total_akomodasi || 0,
            statsObject.total_libur || 0
        ];
        
        var statsData = {
            labels: ['Pengguna', 'Destinasi', 'Paket', 'Restaurant', 'Akomodasi', 'Hari Libur'],
            values: statsValues,
            colors: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(240, 147, 251, 0.8)',
                'rgba(79, 172, 254, 0.8)',
                'rgba(67, 233, 123, 0.8)',
                'rgba(250, 112, 154, 0.8)',
                'rgba(48, 207, 208, 0.8)'
            ],
            borderColors: [
                'rgba(102, 126, 234, 1)',
                'rgba(240, 147, 251, 1)',
                'rgba(79, 172, 254, 1)',
                'rgba(67, 233, 123, 1)',
                'rgba(250, 112, 154, 1)',
                'rgba(48, 207, 208, 1)'
            ]
        };

        // Bar Chart
        var ctxBar = document.getElementById('dataChart');
        if (ctxBar) {
            new Chart(ctxBar.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: statsData.labels,
                    datasets: [{
                        label: 'Jumlah Data',
                        data: statsData.values,
                        backgroundColor: statsData.colors,
                        borderColor: statsData.borderColors,
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 14,
                            titleFont: {
                                size: 14,
                                weight: 'bold',
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
                            },
                            bodyFont: {
                                size: 13,
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
                            },
                            cornerRadius: 10,
                            displayColors: true,
                            borderColor: 'rgba(20, 184, 166, 0.3)',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return 'Jumlah: ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(20, 184, 166, 0.08)',
                                drawBorder: false,
                                lineWidth: 1
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                stepSize: 1,
                                padding: 8
                            },
                            border: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#334155',
                                font: {
                                    size: 11,
                                    weight: '600'
                                },
                                padding: 10
                            },
                            border: {
                                display: false
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart',
                        delay: function(context) {
                            return context.dataIndex * 100;
                        }
                    }
                }
            });
        }

        // Pie Chart
        var ctxPie = document.getElementById('pieChart');
        if (ctxPie) {
            var total = statsData.values.reduce(function(a, b) { return a + b; }, 0);
            
            new Chart(ctxPie.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: statsData.labels,
                    datasets: [{
                        data: statsData.values,
                        backgroundColor: statsData.colors,
                        borderColor: '#ffffff',
                        borderWidth: 3,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 18,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                pointStyleWidth: 8,
                                font: {
                                    size: 12,
                                    weight: '600',
                                    family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
                                },
                                color: '#334155',
                                generateLabels: function(chart) {
                                    var data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map(function(label, i) {
                                            var value = data.datasets[0].data[i];
                                            var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                            return {
                                                text: label + ' (' + percentage + '%)',
                                                fillStyle: data.datasets[0].backgroundColor[i],
                                                strokeStyle: data.datasets[0].borderColor,
                                                lineWidth: data.datasets[0].borderWidth,
                                                hidden: false,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 14,
                            titleFont: {
                                size: 14,
                                weight: 'bold',
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
                            },
                            bodyFont: {
                                size: 13,
                                family: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
                            },
                            cornerRadius: 10,
                            borderColor: 'rgba(20, 184, 166, 0.3)',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    var value = context.parsed || 0;
                                    var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return label + ': ' + value + ' (' + percentage + '%)';
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    },
                    cutout: '65%'
                }
            });
        }

    </script>
</body>
</html>

