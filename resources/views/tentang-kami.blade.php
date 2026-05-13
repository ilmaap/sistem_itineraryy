<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Itinerary Wisata</title>
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
                <li><a href="{{ route('paket.public.index') }}">Paket Wisata</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        Informasi
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('tentang-kami') }}" class="active">Tentang Kami</a></li>
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
    <section class="main-section" style="padding-top: 120px; padding-bottom: 4rem;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            <!-- Page Header -->
            <div class="text-center" style="margin-bottom: 3rem;">
                <span class="section-badge">TENTANG KAMI</span>
                <h1 style="font-size: 2.5rem; font-weight: 700; color: #1a202c; margin: 1.5rem 0 1rem;">
                    Portal Pariwisata<br>
                    <span class="highlight">Solo & Yogyakarta</span>
                </h1>
                <!-- <p style="font-size: 1.125rem; color: #718096; max-width: 700px; margin: 0 auto; line-height: 1.7;">
                    Menyediakan layanan terbaik untuk merencanakan perjalanan wisata Anda
                </p> -->
            </div>

            <!-- About Content -->
            <div class="main-content-grid" style="margin-bottom: 5rem; gap: 3rem; align-items: center;">
                <div class="main-content-left">
                    <h2 style="font-size: 2rem; font-weight: 700; color: #1a202c; margin-bottom: 1.5rem;">
                        Siapa Kami?
                    </h2>
                    <p class="main-description" style="margin-bottom: 1.25rem;">
                        Kami adalah travel agent dan biro tour yang melayani perjalanan wisata di wilayah Solo dan Yogyakarta dengan pilihan paket wisata serta layanan custom wisata sesuai kebutuhan pelanggan.
                    </p>
                    <p class="main-description">
                        Beragam destinasi tersedia dalam kategori wisata alam, budaya, buatan, dan minat khusus, yang dirancang dengan perencanaan perjalanan yang nyaman. Melalui layanan yang terorganisir, kami membantu wisatawan menikmati keindahan dan kekayaan budaya Solo dan Yogyakarta dengan lebih mudah dan berkesan.
                    </p>
                </div>
                <div class="main-content-right" style="display: flex; align-items: center; justify-content: center;">
                    <div style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%); border-radius: 20px; padding: 3rem; color: white; text-align: center; box-shadow: 0 20px 60px rgba(20, 184, 166, 0.3); width: 100%; max-width: 400px;">
                        <i class="fas fa-route" style="font-size: 4rem; margin-bottom: 1.5rem; display: block;"></i>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem; font-weight: 600;">Visi Kami</h3>
                        <p style="font-size: 1rem; line-height: 1.7; opacity: 0.95;">
                            Menjadi travel agent dan biro tour terpercaya dalam penyediaan layanan perjalanan wisata di wilayah Solo dan Yogyakarta yang mengutamakan kualitas pelayanan, kenyamanan, dan kepuasan pelanggan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mission Section -->
            <div style="background: #f7fafc; border-radius: 20px; padding: 4rem 3rem; margin-bottom: 5rem;">
                <h2 style="font-size: 2rem; font-weight: 700; color: #1a202c; margin-bottom: 3rem; text-align: center;">
                    Misi Kami
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem;">
                    <div style="text-align: center; padding: 0;">
                        <div style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 10px 30px rgba(20, 184, 166, 0.3);">
                            <i class="fas fa-map-marked-alt" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1a202c; margin-bottom: 0.75rem;">
                            Pelayanan Profesional
                        </h3>
                        <p style="color: #718096; line-height: 1.7; font-size: 0.95rem;">
                            Memberikan pelayanan profesional melalui perencanaan perjalanan yang terorganisir dan transportasi yang nyaman.
                        </p>
                    </div>
                    <div style="text-align: center; padding: 0;">
                        <div style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 10px 30px rgba(20, 184, 166, 0.3);">
                            <i class="fas fa-route" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1a202c; margin-bottom: 0.75rem;">
                            Produk Beragam
                        </h3>
                        <p style="color: #718096; line-height: 1.7; font-size: 0.95rem;">
                            Menyediakan paket wisata dan layanan custom wisata dengan berbagai pilihan destinasi wisata yang dapat disesuaikan.
                        </p>
                    </div>
                    <div style="text-align: center; padding: 0;">
                        <div style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 10px 30px rgba(20, 184, 166, 0.3);">
                            <i class="fas fa-info-circle" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1a202c; margin-bottom: 0.75rem;">
                            Pengalaman Berkesan
                        </h3>
                        <p style="color: #718096; line-height: 1.7; font-size: 0.95rem;">
                            Menciptakan pengalaman wisata yang berkesan melalui layanan yang ramah, informatif, dan responsif.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us Section -->
            <div style="margin-bottom: 5rem;">
                <h2 style="font-size: 2rem; font-weight: 700; color: #1a202c; margin-bottom: 3rem; text-align: center;">
                    Mengapa Memilih Kami?
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
                    <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 30px rgba(20, 184, 166, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                        <div style="display: flex; align-items: start; gap: 1.5rem;">
                            <div style="background: #ecfeff; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-clock" style="font-size: 1.5rem; color: #14b8a6;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: #1a202c; margin-bottom: 0.75rem;">
                                    Hemat Waktu
                                </h3>
                                <p style="color: #718096; line-height: 1.7; font-size: 0.95rem;">
                                    Sistem kami membantu Anda merencanakan perjalanan dengan cepat tanpa perlu riset manual yang memakan waktu.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 30px rgba(20, 184, 166, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                        <div style="display: flex; align-items: start; gap: 1.5rem;">
                            <div style="background: #ecfeff; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-dollar-sign" style="font-size: 1.5rem; color: #14b8a6;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: #1a202c; margin-bottom: 0.75rem;">
                                    Hemat Biaya
                                </h3>
                                <p style="color: #718096; line-height: 1.7; font-size: 0.95rem;">
                                    Rute yang dioptimalkan membantu mengurangi biaya transportasi dan memaksimalkan efisiensi perjalanan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 30px rgba(20, 184, 166, 0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                        <div style="display: flex; align-items: start; gap: 1.5rem;">
                            <div style="background: #ecfeff; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-user-friends" style="font-size: 1.5rem; color: #14b8a6;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: #1a202c; margin-bottom: 0.75rem;">
                                    Mudah Digunakan
                                </h3>
                                <p style="color: #718096; line-height: 1.7; font-size: 0.95rem;">
                                    Interface yang user-friendly membuat siapa saja dapat menggunakan platform kami dengan mudah.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%); border-radius: 20px; padding: 4rem 3rem; color: white; text-align: center; box-shadow: 0 20px 60px rgba(20, 184, 166, 0.3);">
                <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">
                    Hubungi Kami
                </h2>
                <p style="font-size: 1.125rem; margin-bottom: 2.5rem; opacity: 0.95; line-height: 1.7;">
                    Ada pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi kami.
                </p>
                <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/Mjaw59e9Ln6Grit59" target="_blank" style="display: inline-flex; align-items: center; gap: 0.75rem; background: white; color: #14b8a6; padding: 1rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 600; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(20, 184, 166, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Lokasi Kami</span>
                    </a>
                    <a href="https://wa.me/6281392189055" target="_blank" style="display: inline-flex; align-items: center; gap: 0.75rem; background: white; color: #14b8a6; padding: 1rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 600; transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(20, 184, 166, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
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
                        <a href="https://maps.app.goo.gl/Mjaw59e9Ln6Grit59" target="_blank" style="display: block; position: relative;">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.3387575796332!2d111.5446256748554!3d-7.646673675645312!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79bf8849d14c97%3A0xf27b81c071acd41e!2sAZ%20TRANS%20TOUR%20%26%20TRANSPORT%20MADIUN!5e0!3m2!1sid!2sid!4v1772287773051!5m2!1sid!2sid" 
                                width="100%" 
                                height="150" 
                                style="border:0; border-radius: 8px;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </a>
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
        /* Responsive adjustments for About Page */
        @media (max-width: 1024px) {
            .main-content-grid {
                grid-template-columns: 1fr !important;
            }
            
            .main-content-right {
                margin-top: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            section.main-section {
                padding-top: 100px !important;
                padding-bottom: 3rem !important;
            }
            
            .text-center h1 {
                font-size: 2rem !important;
            }
            
            .text-center p {
                font-size: 1rem !important;
            }
            
            .main-content-left h2 {
                font-size: 1.75rem !important;
            }
            
            div[style*="background: #f7fafc"] {
                padding: 2.5rem 1.5rem !important;
            }
            
            div[style*="background: #f7fafc"] h2 {
                font-size: 1.75rem !important;
                margin-bottom: 2rem !important;
            }
            
            div[style*="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))"] {
                grid-template-columns: 1fr !important;
                gap: 2rem !important;
            }
            
            div[style*="grid-template-columns: repeat(auto-fit, minmax(320px, 1fr))"] {
                grid-template-columns: 1fr !important;
            }
            
            div[style*="background: linear-gradient(135deg, #14b8a6"] {
                padding: 3rem 2rem !important;
            }
            
            div[style*="background: linear-gradient(135deg, #14b8a6"] h2 {
                font-size: 1.75rem !important;
            }
            
            div[style*="background: linear-gradient(135deg, #14b8a6"] p {
                font-size: 1rem !important;
                margin-bottom: 2rem !important;
            }
            
            div[style*="display: flex; gap: 1.5rem"] {
                flex-direction: column !important;
                gap: 1rem !important;
            }
            
            div[style*="display: flex; gap: 1.5rem"] a {
                width: 100% !important;
                justify-content: center !important;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 0 1rem !important;
            }
            
            .text-center {
                margin-bottom: 3rem !important;
            }
            
            .main-content-grid {
                margin-bottom: 3rem !important;
            }
            
            div[style*="background: #f7fafc"] {
                padding: 2rem 1rem !important;
            }
            
            div[style*="background: linear-gradient(135deg, #14b8a6"] {
                padding: 2.5rem 1.5rem !important;
            }
        }
    </style>
</body>
</html>

