<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Wisata - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('landing') }}" class="logo">
                <img src="{{ asset('/storage/logo.ico') }}" alt="Logo" class="logo-image">
                <span>Itinerary Wisata</span>
            </a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('landing') }}">Beranda</a></li>
                <li><a href="{{ route('paket.public.index') }}" class="active">Paket Wisata</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        Informasi
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('tentang-kami') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('form-permohonan') }}">Form Permohonan</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('login.wisatawan') }}">Masuk</a></li>
            </ul>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <section class="main-section" style="padding-top: 120px;">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">PAKET WISATA</span>
                <h2>
                    Pilih Paket Wisata<br>
                    <span class="highlight">Siap Pakai</span>
                </h2>
                <p class="section-description">
                    Jelajahi berbagai paket wisata lengkap dengan destinasi terpilih untuk Solo & Yogyakarta
                </p>
            </div>

            <!-- Filter Section -->
            <div class="filter-section" style="background: #fff; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <form action="{{ route('paket.public.index') }}" method="GET" class="filter-form">
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 1rem; align-items: end;" class="filter-row-responsive">
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="font-size: 0.875rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-search" style="color: #14b8a6;"></i> Cari Paket
                            </label>
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control" 
                                placeholder="Cari nama atau deskripsi paket..."
                                value="{{ $search }}"
                                style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem;"
                            >
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="font-size: 0.875rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-calendar-day" style="color: #14b8a6;"></i> Durasi
                            </label>
                            <select name="durasi" class="form-control" style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem;">
                                <option value="">Semua Durasi</option>
                                <option value="1" {{ $durasi == '1' ? 'selected' : '' }}>1 Hari</option>
                                <option value="2" {{ $durasi == '2' ? 'selected' : '' }}>2 Hari</option>
                                <option value="3" {{ $durasi == '3' ? 'selected' : '' }}>3 Hari</option>
                                <option value="4" {{ $durasi == '4' ? 'selected' : '' }}>4 Hari</option>
                                <option value="5" {{ $durasi == '5' ? 'selected' : '' }}>5 Hari</option>
                                <option value="6" {{ $durasi == '6' ? 'selected' : '' }}>6 Hari</option>
                                <option value="7" {{ $durasi == '7' ? 'selected' : '' }}>7 Hari</option>
                            </select>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="font-size: 0.875rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-money-bill-wave" style="color: #14b8a6;"></i> Harga Min
                            </label>
                            <input 
                                type="number" 
                                name="harga_min" 
                                class="form-control" 
                                placeholder="Min"
                                value="{{ $harga_min }}"
                                style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem;"
                            >
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="font-size: 0.875rem; font-weight: 600; color: #4a5568; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-money-bill-wave" style="color: #14b8a6;"></i> Harga Max
                            </label>
                            <input 
                                type="number" 
                                name="harga_max" 
                                class="form-control" 
                                placeholder="Max"
                                value="{{ $harga_max }}"
                                style="padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem;"
                            >
                        </div>
                        <div style="display: flex; gap: 0.5rem; align-items: flex-end;">
                            <button type="submit" class="btn-hero-primary" style="padding: 0.75rem 1.5rem; font-size: 0.875rem;">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('paket.public.index') }}" class="btn-hero-secondary" style="padding: 0.75rem 1.5rem; font-size: 0.875rem;">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            @if($paket->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    @foreach($paket as $item)
                        <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column; border: 1px solid #e2e8f0;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(20, 184, 166, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'">
                            <div style="position: relative; width: 100%; height: 200px; overflow: hidden; background: #f7fafc;">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->nama }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #a0aec0; gap: 0.5rem;">
                                        <i class="fas fa-image" style="font-size: 2rem;"></i>
                                        <span>No Image</span>
                                    </div>
                                @endif
                                <div style="position: absolute; top: 1rem; right: 1rem; background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); color: #fff; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 2px 8px rgba(20, 184, 166, 0.3);">
                                    <i class="fas fa-calendar-day"></i> {{ $item->durasi }} Hari
                                </div>
                            </div>
                            <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column; gap: 1rem;">
                                <h3 style="font-size: 1.25rem; font-weight: 700; color: #2d3748; margin: 0;">{{ $item->nama }}</h3>
                                @if($item->deskripsi)
                                    <p style="color: #718096; font-size: 0.875rem; line-height: 1.6; margin: 0; flex: 1;">{{ Str::limit($item->deskripsi, 100) }}</p>
                                @endif
                                <div style="display: flex; flex-direction: column; gap: 0.75rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #4a5568; font-size: 0.875rem;">
                                        <i class="fas fa-map-marked-alt" style="color: #14b8a6; width: 20px;"></i>
                                        <span>{{ $item->destinasi->count() }} Destinasi</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.5rem; color: #4a5568; font-size: 0.875rem;">
                                        <i class="fas fa-money-bill-wave" style="color: #14b8a6; width: 20px;"></i>
                                        <span style="font-weight: 700; color: #14b8a6; font-size: 1rem;">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
                                <a href="{{ route('paket.public.show', $item->id) }}" class="btn-hero-primary" style="width: 100%; text-align: center; justify-content: center; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; font-size: 0.875rem;">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div style="display: flex; justify-content: center; margin-top: 2rem;">
                    {{ $paket->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 4rem 2rem; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <i class="fas fa-box-open" style="font-size: 4rem; color: #cbd5e0; margin-bottom: 1rem;"></i>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #2d3748; margin-bottom: 0.5rem;">Tidak Ada Paket Wisata</h3>
                    <p style="color: #718096; margin-bottom: 1.5rem;">{{ $search || $durasi || $harga_min || $harga_max ? 'Tidak ditemukan paket wisata yang sesuai dengan filter.' : 'Belum ada paket wisata yang tersedia.' }}</p>
                    @if($search || $durasi || $harga_min || $harga_max)
                        <a href="{{ route('paket.public.index') }}" class="btn-hero-primary">
                            <i class="fas fa-redo"></i> Reset Filter
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3>
                        <!-- <i class="fas fa-route"></i> -->
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
                            <p>Jl. Mayang Kembar III No.7 A, Pojok Dua, Kec. Wungu, Kab. Madiun</p>
                            <p>Jawa Timur 63138</p>
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
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.3387575796332!2d111.5446256748554!3d-7.646673675645312!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79bf8849d14c97%3A0xf27b81c071acd41e!2sAZ%20TRANS%20TOUR%20%26%20TRANSPORT%20MADIUN!5e0!3m2!1sid!2sid!4v1772287773051!5m2!1sid!2sid" 
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

            document.addEventListener('click', (e) => {
                if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                    navMenu.classList.remove('active');
                    hamburger.classList.remove('active');
                }
            });
        }

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Dropdown toggle for mobile
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const dropdown = document.querySelector('.dropdown');
        
        if (dropdownToggle && dropdown) {
            // Handle click on dropdown toggle
            dropdownToggle.addEventListener('click', function(e) {
                if (window.innerWidth <= 767) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                }
            });

            // Close dropdown when clicking outside (mobile only)
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 767) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('active');
                    }
                }
            });

            // Close dropdown and menu when clicking on dropdown menu links (mobile only)
            const dropdownLinks = dropdown.querySelectorAll('.dropdown-menu a');
            dropdownLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 767) {
                        dropdown.classList.remove('active');
                        navMenu.classList.remove('active');
                        hamburger.classList.remove('active');
                    }
                });
            });
        }
    </script>
    <style>
        @media (max-width: 1024px) {
            .filter-row-responsive {
                grid-template-columns: 1fr !important;
            }
            
            .filter-row-responsive > div:last-child {
                width: 100%;
            }
            
            .filter-row-responsive > div:last-child > * {
                flex: 1;
            }
        }
    </style>
</body>
</html>

