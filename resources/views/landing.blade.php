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
    <section class="hero" style="--bg-image: url('{{ asset('storage/gambar_background.jpg') }}');">
        <div class="hero-overlay"></div>
        <div class="hero-container">
            <h1 class="hero-title">
                Jelajahi Keindahan<br>
                <span class="highlight">Solo & Yogyakarta</span>
            </h1>
            <p class="hero-subtitle">
                Temukan destinasi wisata terbaik dan rencanakan perjalanan Anda dengan mudah
            </p>
            
            <!-- Hero CTA Buttons -->
            <div class="hero-cta-buttons">
                <a href="#" class="btn-hero-primary">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                </a>
                <a href="#" class="btn-hero-secondary">
                    <i class="fas fa-suitcase"></i>
                    Lihat Paket
                </a>
            </div>
        </div>
        
        <!-- Wave SVG -->
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z" fill="#ffffff"/>
            </svg>
        </div>
    </section>

    <!-- Main Section - Two Columns -->
    <section class="main-section">
        <div class="container">
            <div class="main-content-grid">
                <div class="main-content-left">
                    <span class="section-badge">TENTANG WILAYAH</span>
                    <h2>
                        Portal Pariwisata<br>
                        <span class="highlight">Solo & Yogyakarta</span>
                    </h2>
                    <p class="main-description">
                        Solo dan Yogyakarta merupakan dua kota budaya yang kaya akan warisan sejarah, seni, dan tradisi Jawa. Kedua kota ini menawarkan pengalaman wisata yang unik dengan berbagai destinasi menarik mulai dari keraton, candi, museum, hingga kuliner khas yang menggugah selera.
                    </p>
                    <p class="main-description">
                        Dengan sistem itinerary wisata berbasis website ini, Anda dapat merencanakan perjalanan dengan mudah. Sistem akan membantu menyusun rute optimal menggunakan algoritma cerdas untuk memaksimalkan pengalaman wisata Anda.
                    </p>
                    <div class="main-features">
                        <div class="main-feature-item">
                            <div class="main-feature-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div>
                                <h4>150+ Destinasi</h4>
                                <p>Destinasi wisata terpilih</p>
                            </div>
                        </div>
                        <div class="main-feature-item">
                            <div class="main-feature-icon">
                                <i class="fas fa-route"></i>
                            </div>
                            <div>
                                <h4>Rute Optimal</h4>
                                <p>Algoritma cerdas untuk rute terbaik</p>
                            </div>
                        </div>
                        <div class="main-feature-item">
                            <div class="main-feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4>Jadwal Lengkap</h4>
                                <p>Perencanaan waktu yang efisien</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-content-right">
                    <div class="map-illustration">
                        <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                            <!-- Background -->
                            <rect width="400" height="400" fill="#f0fdfa"/>
                            
                            <!-- Border -->
                            <rect x="20" y="20" width="360" height="360" fill="none" stroke="#14b8a6" stroke-width="3" stroke-dasharray="5,5"/>
                            
                            <!-- Administrative boundaries -->
                            <path d="M50 100 L150 80 L200 120 L250 100 L350 130 L350 300 L250 320 L200 280 L150 300 L50 280 Z" 
                                  fill="#5eead4" fill-opacity="0.3" stroke="#0d9488" stroke-width="2"/>
                            
                            <!-- Solo area -->
                            <circle cx="150" cy="200" r="40" fill="#14b8a6" fill-opacity="0.4" stroke="#0d9488" stroke-width="2"/>
                            <text x="150" y="205" text-anchor="middle" fill="#0f766e" font-size="14" font-weight="bold">Solo</text>
                            
                            <!-- Yogyakarta area -->
                            <circle cx="250" cy="180" r="40" fill="#14b8a6" fill-opacity="0.4" stroke="#0d9488" stroke-width="2"/>
                            <text x="250" y="185" text-anchor="middle" fill="#0f766e" font-size="12" font-weight="bold">Yogyakarta</text>
                            
                            <!-- Connection line -->
                            <line x1="190" y1="200" x2="210" y2="180" stroke="#0d9488" stroke-width="2" stroke-dasharray="3,3"/>
                            
                            <!-- Landmarks -->
                            <circle cx="120" cy="180" r="5" fill="#f59e0b"/>
                            <circle cx="280" cy="160" r="5" fill="#f59e0b"/>
                            <circle cx="180" cy="240" r="5" fill="#f59e0b"/>
                            
                            <!-- Title -->
                            <text x="200" y="30" text-anchor="middle" fill="#0f766e" font-size="18" font-weight="bold">Peta Wilayah</text>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">KEUNGGULAN</span>
                <h2>
                    Semua yang Anda Butuhkan<br>
                    <span class="highlight">dalam Satu Platform</span>
                </h2>
                <p class="section-description">
                    Nikmati berbagai fitur canggih yang dirancang untuk memudahkan perencanaan perjalanan wisata Anda dengan hasil yang optimal dan efisien.
                </p>
            </div>
            <div class="features-carousel">
                <div class="features-track" id="featuresTrack">
                    <!-- Clone cards untuk infinite scroll (2-3 card terakhir di awal) -->
                    <div class="feature-card-carousel" data-clone="last-2">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-5">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Estimasi Biaya</h3>
                            <p>Perkiraan biaya perjalanan lengkap untuk membantu perencanaan anggaran dengan breakdown yang detail</p>
                        </div>
                    </div>
                    <div class="feature-card-carousel" data-clone="last-1">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-6">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Rating Destinasi</h3>
                            <p>Lihat rating dan informasi lengkap destinasi wisata untuk membantu pemilihan destinasi terbaik</p>
                        </div>
                    </div>
                    <!-- Original cards -->
                    <div class="feature-card-carousel" data-original="1">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-1">
                                <i class="fas fa-route"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Optimasi Rute Otomatis</h3>
                            <p>Sistem secara otomatis menyusun rute terpendek menggunakan algoritma Nearest Neighbor untuk meminimalkan jarak tempuh</p>
                        </div>
                    </div>
                    <div class="feature-card-carousel" data-original="2">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-2">
                                <i class="fas fa-calculator"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Perhitungan Jarak Akurat</h3>
                            <p>Menghitung jarak antar destinasi menggunakan algoritma Haversine berbasis koordinat geografis dengan akurasi tinggi</p>
                        </div>
                    </div>
                    <div class="feature-card-carousel" data-original="3">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Jadwal Terstruktur</h3>
                            <p>Mendapatkan jadwal perjalanan lengkap dengan estimasi waktu tiba, durasi kunjungan, dan waktu selesai di setiap destinasi</p>
                        </div>
                    </div>
                    <div class="feature-card-carousel" data-original="4">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-4">
                                <i class="fas fa-suitcase"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Paket Wisata Siap Pakai</h3>
                            <p>Pilih paket wisata lengkap dengan driver, kendaraan, konsumsi, dan tiket masuk dari travel agent terpercaya</p>
                        </div>
                    </div>
                    <div class="feature-card-carousel" data-original="5">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-5">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Estimasi Biaya</h3>
                            <p>Perkiraan biaya perjalanan lengkap untuk membantu perencanaan anggaran dengan breakdown yang detail</p>
                        </div>
                    </div>
                    <div class="feature-card-carousel" data-original="6">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-6">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Rating Destinasi</h3>
                            <p>Lihat rating dan informasi lengkap destinasi wisata untuk membantu pemilihan destinasi terbaik</p>
                        </div>
                    </div>
                    <!-- Clone cards untuk infinite scroll (3 card pertama di akhir) -->
                    <div class="feature-card-carousel" data-clone="first-1">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-1">
                                <i class="fas fa-route"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Optimasi Rute Otomatis</h3>
                            <p>Sistem secara otomatis menyusun rute terpendek menggunakan algoritma Nearest Neighbor untuk meminimalkan jarak tempuh</p>
                        </div>
                    </div>
                    <div class="feature-card-carousel" data-clone="first-2">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-2">
                                <i class="fas fa-calculator"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Perhitungan Jarak Akurat</h3>
                            <p>Menghitung jarak antar destinasi menggunakan algoritma Haversine berbasis koordinat geografis dengan akurasi tinggi</p>
                        </div>
                    </div>
                    <div class="feature-card-carousel" data-clone="first-3">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon gradient-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="feature-content">
                            <h3>Jadwal Terstruktur</h3>
                            <p>Mendapatkan jadwal perjalanan lengkap dengan estimasi waktu tiba, durasi kunjungan, dan waktu selesai di setiap destinasi</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-btn carousel-prev" id="featuresPrevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-btn carousel-next" id="featuresNextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
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
                    <div class="step scroll-reveal">
                        <div class="step-number gradient-1">1</div>
                        <h3>Daftar & Login</h3>
                        <p>Buat akun atau login ke sistem dengan mudah</p>
                    </div>
                    <div class="step scroll-reveal">
                        <div class="step-number gradient-2">2</div>
                        <h3>Pilih Mode</h3>
                        <p>Buat itinerary mandiri atau pilih paket wisata siap pakai</p>
                    </div>
                    <div class="step scroll-reveal">
                        <div class="step-number gradient-3">3</div>
                        <h3>Konfigurasi</h3>
                        <p>Input lokasi awal, jumlah hari, waktu mulai, dan kategori wisata</p>
                    </div>
                    <div class="step scroll-reveal">
                        <div class="step-number gradient-4">4</div>
                        <h3>Pilih Destinasi</h3>
                        <p>Pilih destinasi wisata yang ingin dikunjungi sesuai preferensi</p>
                    </div>
                    <div class="step scroll-reveal">
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
                        Portal Pariwisata
                    </h3>
                    <p>
                        Sistem perencanaan perjalanan wisata untuk Solo & Yogyakarta dengan optimasi rute otomatis menggunakan algoritma cerdas.
                    </p>
                </div>
                <div class="footer-info">
                    <h4>Alamat</h4>
                    <div class="footer-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <p>Jl. Raya Solo - Yogyakarta No. 123</p>
                            <p>Solo, Jawa Tengah 57100</p>
                        </div>
                    </div>
                </div>
                <div class="footer-info">
                    <h4>Jam Operasional</h4>
                    <div class="footer-info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <p>Senin - Jumat: 08:00 - 17:00 WIB</p>
                            <p>Sabtu - Minggu: 09:00 - 15:00 WIB</p>
                        </div>
                    </div>
                </div>
                <div class="footer-map">
                    <h4>Lokasi</h4>
                    <div class="mini-map">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.1234567890!2d110.3695!3d-7.7956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwNDcnNDQuMiJTIDExMMKwMjInMTAuMiJF!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid" 
                            width="100%" 
                            height="150" 
                            style="border:0; border-radius: 8px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Portal Pariwisata Solo & Yogyakarta. All rights reserved.</p>
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
                hamburger.classList.toggle('active');
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                    navMenu.classList.remove('active');
                    hamburger.classList.remove('active');
                }
            });
        }

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        let lastScroll = 0;

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            lastScroll = currentScroll;
        });

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

        // Scroll reveal animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                }
            });
        }, observerOptions);

        // Observe all scroll-reveal elements
        document.querySelectorAll('.scroll-reveal').forEach(el => {
            observer.observe(el);
        });

        // Add scroll-reveal class to feature cards and steps
        document.querySelectorAll('.feature-card, .step').forEach((el, index) => {
            el.classList.add('scroll-reveal');
            el.style.transitionDelay = `${index * 0.1}s`;
        });

        // Animate statistics on scroll
        const animateCounter = (element, target, duration = 2000) => {
            let start = 0;
            const increment = target / (duration / 16);
            const timer = setInterval(() => {
                start += increment;
                if (start >= target) {
                    element.textContent = target + (element.textContent.includes('+') ? '+' : '');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(start) + (element.textContent.includes('+') ? '+' : '');
                }
            }, 16);
        };

        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumber = entry.target.querySelector('.stat-number');
                    if (statNumber && !statNumber.dataset.animated) {
                        const text = statNumber.textContent;
                        const number = parseFloat(text.replace(/[^0-9.]/g, ''));
                        statNumber.dataset.animated = 'true';
                        statNumber.textContent = '0' + (text.includes('+') ? '+' : '');
                        animateCounter(statNumber, number, 2000);
                    }
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat-item').forEach(stat => {
            statsObserver.observe(stat);
        });

        // Features Carousel with Infinite Auto-scroll (Smooth)
        const featuresTrack = document.getElementById('featuresTrack');
        const featuresPrevBtn = document.getElementById('featuresPrevBtn');
        const featuresNextBtn = document.getElementById('featuresNextBtn');
        let featuresCurrentIndex = 2; // Start dari card pertama original (setelah 2 clone di awal)
        let autoScrollInterval = null;
        let isPaused = false;
        let isTransitioning = false;
        const featureCardWidth = 350;
        const featureGap = 32;
        const featureCardWidthWithGap = featureCardWidth + featureGap;
        const autoScrollDelay = 4000; // 4 detik
        const transitionDuration = 600; // Durasi transisi

        if (featuresTrack && featuresPrevBtn && featuresNextBtn) {
            const originalCards = featuresTrack.querySelectorAll('[data-original]');
            const totalOriginalCards = originalCards.length;
            const cloneCardsAtStart = 2; // Jumlah clone cards di awal
            const firstOriginalIndex = cloneCardsAtStart; // Index card pertama original
            const lastOriginalIndex = cloneCardsAtStart + totalOriginalCards - 1; // Index card terakhir original

            // Set initial position ke card pertama original
            function initializeCarousel() {
                featuresTrack.style.transition = 'none';
                featuresCurrentIndex = firstOriginalIndex;
                updateFeaturesCarousel();
                // Force reflow
                void featuresTrack.offsetHeight;
                featuresTrack.style.transition = `transform ${transitionDuration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
            }

            function updateFeaturesCarousel(withoutTransition = false) {
                if (withoutTransition) {
                    featuresTrack.style.transition = 'none';
                } else {
                    featuresTrack.style.transition = `transform ${transitionDuration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
                }
                
                const translateX = -featuresCurrentIndex * featureCardWidthWithGap;
                featuresTrack.style.transform = `translateX(${translateX}px)`;
                
                // Update button states (selalu enabled karena infinite)
                featuresPrevBtn.style.opacity = '1';
                featuresPrevBtn.style.pointerEvents = 'auto';
                featuresNextBtn.style.opacity = '1';
                featuresNextBtn.style.pointerEvents = 'auto';
            }

            function nextSlide() {
                if (isTransitioning) return;
                isTransitioning = true;
                
                featuresCurrentIndex++;
                updateFeaturesCarousel();

                // Jika sudah melewati card original terakhir dan masuk ke clone, reset ke card pertama original tanpa transisi
                if (featuresCurrentIndex > lastOriginalIndex) {
                    // Tunggu sampai transisi selesai dan clone card terlihat
                    setTimeout(() => {
                        // Reset tanpa transisi saat di clone card (setelah clone card pertama terlihat)
                        featuresCurrentIndex = firstOriginalIndex;
                        updateFeaturesCarousel(true);
                        // Tunggu sedikit untuk memastikan reset selesai
                        setTimeout(() => {
                            // Restore transition untuk slide berikutnya
                            featuresTrack.style.transition = `transform ${transitionDuration}ms cubic-bezier(0.4, 0, 0.2, 1)`;
                            isTransitioning = false;
                        }, 50);
                    }, transitionDuration + 100); // Tambah sedikit delay untuk memastikan clone terlihat
                } else {
                    setTimeout(() => {
                        isTransitioning = false;
                    }, transitionDuration);
                }
            }

            function prevSlide() {
                if (isTransitioning) return;
                isTransitioning = true;
                
                featuresCurrentIndex--;
                updateFeaturesCarousel();

                // Jika sudah melewati card original pertama dan masuk ke clone, reset ke card terakhir original tanpa transisi
                if (featuresCurrentIndex < firstOriginalIndex) {
                    setTimeout(() => {
                        // Reset tanpa transisi saat di clone card
                        featuresCurrentIndex = lastOriginalIndex;
                        updateFeaturesCarousel(true);
                        // Setelah reset, lanjutkan transisi normal
                        setTimeout(() => {
                            isTransitioning = false;
                        }, 100);
                    }, transitionDuration);
                } else {
                    setTimeout(() => {
                        isTransitioning = false;
                    }, transitionDuration);
                }
            }

            function startAutoScroll() {
                if (autoScrollInterval) {
                    clearInterval(autoScrollInterval);
                }
                autoScrollInterval = setInterval(() => {
                    if (!isPaused && !isTransitioning) {
                        nextSlide();
                    }
                }, autoScrollDelay);
            }

            function pauseAutoScroll() {
                isPaused = true;
            }

            function resumeAutoScroll() {
                isPaused = false;
            }

            // Event listeners untuk tombol
            featuresNextBtn.addEventListener('click', () => {
                if (!isTransitioning) {
                    nextSlide();
                    pauseAutoScroll();
                    setTimeout(() => {
                        resumeAutoScroll();
                        startAutoScroll();
                    }, 2000);
                }
            });

            featuresPrevBtn.addEventListener('click', () => {
                if (!isTransitioning) {
                    prevSlide();
                    pauseAutoScroll();
                    setTimeout(() => {
                        resumeAutoScroll();
                        startAutoScroll();
                    }, 2000);
                }
            });

            // Pause saat hover
            const featuresCarousel = document.querySelector('.features-carousel');
            if (featuresCarousel) {
                featuresCarousel.addEventListener('mouseenter', pauseAutoScroll);
                featuresCarousel.addEventListener('mouseleave', () => {
                    resumeAutoScroll();
                    startAutoScroll();
                });
            }

            // Pause saat window tidak aktif
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    pauseAutoScroll();
                } else {
                    resumeAutoScroll();
                    startAutoScroll();
                }
            });

            // Initialize
            initializeCarousel();
            startAutoScroll();
        }

    </script>
</body>
</html>

