<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itinerary Wisata - Solo & Yogyakarta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">
                <i class="fas fa-route"></i>
                <span>Itinerary Wisata</span>
            </a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="#" class="active">Beranda</a></li>
                <li><a href="#">Paket Wisata</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        Informasi
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Form Permohonan</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('login') }}">Masuk</a></li>
            </ul>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    @if (session('login_success'))
        <div style="max-width: 1200px; margin: 90px auto -70px; padding: 0 2rem;">
            <div style="background: #ecfeff; border: 1px solid #a5f3fc; color: #0e7490; padding: 0.9rem 1rem; border-radius: 12px;">
                {{ session('login_success') }}
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="hero" style="--bg-image: url('{{ asset('storage/gambarbackground.jpg') }}');">
        <div class="hero-container">
            <div class="badge">
                <i class="fas fa-map-marked-alt"></i>
                <span>Solo & Yogyakarta</span>
            </div>
            <h1>
                Rencanakan Perjalanan Wisata<br>
                <span class="highlight">Lebih Mudah & Efisien</span>
            </h1>
            <p class="hero-subtitle">
                Sistem itinerary wisata berbasis website dengan penyusunan destinasi menggunakan algoritma cerdas. Dapatkan rencana perjalanan terstruktur dalam hitungan detik.
            </p>
            <div class="hero-cta">
                <a href="#" class="btn-white">
                    <i class="fas fa-rocket"></i>
                    Mulai Sekarang
                </a>
                <a href="#" class="btn-outline">
                    <i class="fas fa-suitcase"></i>
                    Lihat Paket Wisata
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Itinerary Dibuat</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">150+</span>
                    <span class="stat-label">Destinasi Wisata</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">4.8</span>
                    <span class="stat-label">Rating Pengguna</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">FITUR UNGGULAN</span>
                <h2>
                    Semua yang Anda Butuhkan<br>
                    <span class="highlight">dalam Satu Platform</span>
                </h2>
                <p class="section-description">
                    Nikmati berbagai fitur canggih yang dirancang untuk memudahkan perencanaan perjalanan wisata Anda dengan hasil yang optimal dan efisien.
                </p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon gradient-1">
                        <i class="fas fa-route"></i>
                    </div>
                    <h3>Optimasi Rute Otomatis</h3>
                    <p>Sistem secara otomatis menyusun rute terpendek menggunakan algoritma Nearest Neighbor untuk meminimalkan jarak tempuh</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon gradient-2">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3>Perhitungan Jarak Akurat</h3>
                    <p>Menghitung jarak antar destinasi menggunakan algoritma Haversine berbasis koordinat geografis dengan akurasi tinggi</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon gradient-3">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Jadwal Terstruktur</h3>
                    <p>Mendapatkan jadwal perjalanan lengkap dengan estimasi waktu tiba, durasi kunjungan, dan waktu selesai di setiap destinasi</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon gradient-4">
                        <i class="fas fa-suitcase"></i>
                    </div>
                    <h3>Paket Wisata Siap Pakai</h3>
                    <p>Pilih paket wisata lengkap dengan driver, kendaraan, konsumsi, dan tiket masuk dari travel agent terpercaya</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon gradient-5">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <h3>Estimasi Biaya</h3>
                    <p>Perkiraan biaya perjalanan lengkap untuk membantu perencanaan anggaran dengan breakdown yang detail</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon gradient-6">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Rating Destinasi</h3>
                    <p>Lihat rating dan informasi lengkap destinasi wisata untuk membantu pemilihan destinasi terbaik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">CARA KERJA</span>
                <h2>
                    Mulai dalam <span class="highlight">5 Langkah Mudah</span>
                </h2>
                <p class="section-description">
                    Proses yang sederhana dan intuitif untuk mendapatkan itinerary perjalanan wisata yang optimal dalam waktu singkat.
                </p>
            </div>
            <div class="steps-container">
                <!-- <div class="steps-line"></div> -->
                <div class="steps">
                    <div class="step">
                        <div class="step-number gradient-1">1</div>
                        <h3>Daftar & Login</h3>
                        <p>Buat akun atau login ke sistem dengan mudah</p>
                    </div>
                    <div class="step">
                        <div class="step-number gradient-2">2</div>
                        <h3>Pilih Mode</h3>
                        <p>Buat itinerary mandiri atau pilih paket wisata siap pakai</p>
                    </div>
                    <div class="step">
                        <div class="step-number gradient-3">3</div>
                        <h3>Konfigurasi</h3>
                        <p>Input lokasi awal, jumlah hari, waktu mulai, dan kategori wisata</p>
                    </div>
                    <div class="step">
                        <div class="step-number gradient-4">4</div>
                        <h3>Pilih Destinasi</h3>
                        <p>Pilih destinasi wisata yang ingin dikunjungi sesuai preferensi</p>
                    </div>
                    <div class="step">
                        <div class="step-number gradient-5">5</div>
                        <h3>Dapatkan Itinerary</h3>
                        <p>Sistem otomatis menyusun rute optimal dan jadwal lengkap</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Siap Memulai Perjalanan Wisata Anda?</h2>
                <p>
                    Dapatkan itinerary perjalanan terstruktur dan optimal dalam hitungan detik. Mulai rencanakan perjalanan impian Anda sekarang!
                </p>
                <div class="cta-buttons">
                    <a href="#" class="btn-white">
                        <i class="fas fa-rocket"></i>
                        Daftar Sekarang
                    </a>
                    <a href="#" class="btn-outline">
                        <i class="fas fa-suitcase"></i>
                        Lihat Paket
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3>
                        <i class="fas fa-route"></i>
                        Itinerary Wisata
                    </h3>
                    <p>
                        Sistem perencanaan perjalanan wisata untuk Solo & Yogyakarta dengan optimasi rute otomatis menggunakan algoritma cerdas.
                    </p>
                    <div class="social-icons">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Paket Wisata</a></li>
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Kontak</h4>
                    <div class="footer-contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>info@itinerarywisata.com</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+62 812-3456-7890</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Solo & Yogyakarta, Indonesia</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Sistem Itinerary Wisata. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Hamburger Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('navMenu');

        if (hamburger && navMenu) {
            hamburger.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                    navMenu.classList.remove('active');
                }
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Dropdown toggle for mobile
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const dropdown = document.querySelector('.dropdown');
        
        if (dropdownToggle && dropdown) {
            dropdownToggle.addEventListener('click', function(e) {
                if (window.innerWidth <= 767) {
                    e.preventDefault();
                    dropdown.classList.toggle('active');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        }
    </script>
</body>
</html>

