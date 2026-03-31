<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $paket->nama }} - Paket Wisata</title>
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
            <div style="margin-bottom: 2rem;">
                <a href="{{ route('paket.public.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #14b8a6; text-decoration: none; font-weight: 600; margin-bottom: 1rem; transition: color 0.3s;" onmouseover="this.style.color='#0d9488'" onmouseout="this.style.color='#14b8a6'">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Paket
                </a>
                <h1 style="font-size: 2.5rem; font-weight: 700; color: #2d3748; margin: 0;">
                    <i class="fas fa-box"></i> {{ $paket->nama }}
                </h1>
            </div>

            <div style="background: #fff; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <!-- Paket Header -->
                <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 2rem; margin-bottom: 3rem; padding-bottom: 2rem; border-bottom: 2px solid #e2e8f0;" class="paket-header-responsive">
                    <div style="width: 100%;">
                        @if($paket->image)
                            <img src="{{ asset('storage/' . $paket->image) }}" alt="{{ $paket->nama }}" style="width: 100%; height: 400px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        @else
                            <div style="width: 100%; height: 400px; background: #f7fafc; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #a0aec0; gap: 1rem; font-size: 1.5rem;">
                                <i class="fas fa-image"></i>
                                <span>No Image</span>
                            </div>
                        @endif
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <span style="padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); color: #fff; box-shadow: 0 2px 8px rgba(20, 184, 166, 0.3);">
                                <i class="fas fa-calendar-day"></i> {{ $paket->durasi }} Hari
                            </span>
                            <span style="padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; background: #48bb78; color: #fff;">
                                <i class="fas fa-map-marked-alt"></i> {{ $paket->destinasi->count() }} Destinasi
                            </span>
                        </div>
                        <h2 style="font-size: 2rem; font-weight: 700; color: #2d3748; margin: 0;">{{ $paket->nama }}</h2>
                        @if($paket->deskripsi)
                            <div style="color: #4a5568; line-height: 1.8; font-size: 1rem;">
                                <p style="margin: 0;">{{ $paket->deskripsi }}</p>
                            </div>
                        @endif
                        <div style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%); padding: 1.5rem; border-radius: 12px; color: #fff; box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);">
                            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem;">Harga Paket</div>
                            <div style="font-size: 2rem; font-weight: 700;">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
                        </div>
                        <div style="margin-top: 1.5rem;">
                            @php
                                $whatsappNumber = env('WHATSAPP_NUMBER', '6281392189055');
                                $whatsappMessage = "Halo, saya tertarik dengan paket wisata:\n\n";
                                $whatsappMessage .= "*{$paket->nama}*\n";
                                $whatsappMessage .= "Durasi: {$paket->durasi} Hari\n";
                                $whatsappMessage .= "Harga: Rp " . number_format($paket->harga, 0, ',', '.') . "\n\n";
                                $whatsappMessage .= "Saya ingin mendapatkan informasi lebih lanjut tentang paket ini.";
                                $encodedMessage = urlencode($whatsappMessage);
                                $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";
                            @endphp
                            <a href="{{ $whatsappUrl }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.75rem; width: 100%; padding: 1rem 1.5rem; background: #25D366; color: #fff; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 1rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);">
                                <i class="fab fa-whatsapp" style="font-size: 1.5rem;"></i>
                                <span>Hubungi via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Destinasi per Hari -->
                @if($destinasiPerHari->count() > 0)
                    <div style="margin-top: 2rem;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #2d3748; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-route"></i> Rute Perjalanan
                        </h3>
                        @foreach($destinasiPerHari as $hari => $destinasiList)
                            <div style="margin-bottom: 2.5rem; padding: 1.5rem; background: #f7fafc; border-radius: 12px; border-left: 4px solid #14b8a6;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e2e8f0;">
                                    <div style="font-size: 1.25rem; font-weight: 700; color: #14b8a6;">Hari {{ $hari }}</div>
                                    <div style="color: #718096; font-size: 0.875rem; font-weight: 600;">{{ $destinasiList->count() }} Destinasi</div>
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 1rem;">
                                    @foreach($destinasiList as $index => $destinasi)
                                        <div style="display: flex; gap: 1rem; background: #fff; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; box-shadow: 0 2px 8px rgba(20, 184, 166, 0.3);">{{ $index + 1 }}</div>
                                            <div style="flex: 1;">
                                                <h4 style="font-size: 1.125rem; font-weight: 700; color: #2d3748; margin: 0 0 0.75rem 0;">{{ $destinasi->nama }}</h4>
                                                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 0.75rem;">
                                                    <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #4a5568;">
                                                        <i class="fas fa-tag" style="color: #14b8a6;"></i> {{ $destinasi->kategori }}
                                                    </span>
                                                    @if($destinasi->rating)
                                                        <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #f6ad55;">
                                                            <i class="fas fa-star" style="color: #f6ad55;"></i> {{ number_format($destinasi->rating, 1) }}
                                                        </span>
                                                    @endif
                                                    @if($destinasi->biaya)
                                                        <span style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #48bb78;">
                                                            <i class="fas fa-money-bill-wave" style="color: #48bb78;"></i> Rp {{ number_format($destinasi->biaya, 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($destinasi->alamat)
                                                    <div style="color: #718096; font-size: 0.875rem; display: flex; align-items: flex-start; gap: 0.5rem;">
                                                        <i class="fas fa-map-marker-alt" style="color: #cbd5e0; margin-top: 0.25rem;"></i> {{ $destinasi->alamat }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @if(!$loop->last)
                                            <div style="display: flex; justify-content: center; color: #cbd5e0; padding: 0.5rem 0;">
                                                <i class="fas fa-arrow-down"></i>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 4rem 2rem;">
                        <i class="fas fa-map-marked-alt" style="font-size: 4rem; color: #cbd5e0; margin-bottom: 1rem;"></i>
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #2d3748; margin-bottom: 0.5rem;">Belum Ada Destinasi</h3>
                        <p style="color: #718096;">Paket ini belum memiliki destinasi yang ditambahkan.</p>
                    </div>
                @endif
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
        @media (max-width: 768px) {
            .paket-header-responsive {
                grid-template-columns: 1fr !important;
            }
            
            .paket-header-responsive > div:first-child img,
            .paket-header-responsive > div:first-child > div {
                height: 250px !important;
            }
        }
    </style>
</body>
</html>

