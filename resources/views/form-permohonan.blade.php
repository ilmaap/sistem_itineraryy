<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Permohonan - Itinerary Wisata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('landing') }}" class="logo">
                <i class="fas fa-route"></i>
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
                        <li><a href="{{ route('tentang-kami') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('form-permohonan') }}" class="active">Form Permohonan</a></li>
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

    <!-- Main Content -->
    <section class="main-section" style="padding-top: 100px; padding-bottom: 2rem;">
        <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 2rem;">
            <!-- Page Header -->
            <div class="text-center" style="margin-bottom: 1rem;">
                <span class="section-badge">FORM PERMOHONAN</span>
                <h1 style="font-size: 2rem; font-weight: 700; color: #1a202c; margin: 1rem 0 0.5rem;">
                    Form Permohonan<br>
                    <span class="highlight">Akun</span>
                </h1>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div style="background: linear-gradient(135deg, #ecfeff 0%, #f0fdfa 100%); border-left: 4px solid #14b8a6; color: #0e7490; padding: 0.875rem 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: start; gap: 0.875rem; box-shadow: 0 4px 12px rgba(20, 184, 166, 0.15);">
                    <div style="background: #14b8a6; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-check-circle" style="font-size: 1.125rem; color: #fff;"></i>
                    </div>
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 0.9375rem; margin-bottom: 0.25rem; color: #0f766e;">Permohonan Berhasil Dikirim!</strong>
                        <span style="font-size: 0.8125rem; line-height: 1.5; color: #0e7490;">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Two Column Layout -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start;" class="form-layout-responsive">
                <!-- Left Column - Main Content -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- Info Card -->
                    <div style="background: linear-gradient(135deg, #f0fdfa 0%, #ecfeff 100%); border-radius: 16px; padding: 2rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                            <div style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%); width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(20, 184, 166, 0.25);">
                                <i class="fas fa-info-circle" style="font-size: 1.5rem; color: #fff;"></i>
                            </div>
                            <div>
                                <h3 style="font-size: 1.25rem; font-weight: 700; color: #0f766e; margin: 0;">Tentang Form Permohonan</h3>
                                <p style="font-size: 0.875rem; color: #0e7490; margin: 0.25rem 0 0;">Informasi penting untuk Anda</p>
                            </div>
                        </div>
                        <p style="color: #0e7490; font-size: 0.9375rem; line-height: 1.7; margin-bottom: 1.25rem;">
                            Form permohonan akun ini memungkinkan Anda untuk mengajukan permohonan akses ke sistem itinerary wisata. Setelah mengisi form, tim kami akan melakukan verifikasi dan menghubungi Anda melalui email atau nomor telepon yang terdaftar.
                        </p>
                        <div style="background: #fff; border-radius: 12px; padding: 1.25rem; border-left: 3px solid #14b8a6;">
                            <h4 style="font-size: 0.9375rem; font-weight: 600; color: #0f766e; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-clock" style="color: #14b8a6;"></i>
                                Waktu Proses
                            </h4>
                            <p style="color: #0e7490; font-size: 0.875rem; line-height: 1.6; margin: 0;">
                                Proses verifikasi membutuhkan waktu <strong>1-3 hari kerja</strong>. Kami akan mengirimkan notifikasi melalui email setelah permohonan Anda diproses.
                            </p>
                        </div>
                    </div>

                    <!-- Benefits Card -->
                    <div style="background: #fff; border-radius: 16px; padding: 2rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
                        <h3 style="font-size: 1.125rem; font-weight: 700; color: #1a202c; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-star" style="color: #14b8a6;"></i>
                            Keuntungan Memiliki Akun
                        </h3>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.875rem;">
                            <li style="display: flex; align-items: start; gap: 0.875rem;">
                                <div style="background: #ecfeff; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 0.125rem;">
                                    <i class="fas fa-check" style="color: #14b8a6; font-size: 0.875rem;"></i>
                                </div>
                                <div>
                                    <strong style="display: block; font-size: 0.9375rem; color: #1a202c; margin-bottom: 0.25rem;">Buat Itinerary Custom</strong>
                                    <p style="font-size: 0.8125rem; color: #718096; line-height: 1.5; margin: 0;">Rencanakan perjalanan sesuai kebutuhan Anda dengan mudah</p>
                                </div>
                            </li>
                            <!-- <li style="display: flex; align-items: start; gap: 0.875rem;">
                                <div style="background: #ecfeff; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 0.125rem;">
                                    <i class="fas fa-check" style="color: #14b8a6; font-size: 0.875rem;"></i>
                                </div>
                                <div>
                                    <strong style="display: block; font-size: 0.9375rem; color: #1a202c; margin-bottom: 0.25rem;">Akses Paket Wisata</strong>
                                    <p style="font-size: 0.8125rem; color: #718096; line-height: 1.5; margin: 0;">Lihat dan pilih paket wisata yang sesuai dengan preferensi</p>
                                </div>
                            </li> -->
                            <li style="display: flex; align-items: start; gap: 0.875rem;">
                                <div style="background: #ecfeff; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 0.125rem;">
                                    <i class="fas fa-check" style="color: #14b8a6; font-size: 0.875rem;"></i>
                                </div>
                                <div>
                                    <strong style="display: block; font-size: 0.9375rem; color: #1a202c; margin-bottom: 0.25rem;">Riwayat Perjalanan</strong>
                                    <p style="font-size: 0.8125rem; color: #718096; line-height: 1.5; margin: 0;">Simpan dan kelola semua itinerary yang pernah dibuat</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right Column - Form -->
                <div>
                    <!-- Form Card -->
                    <div style="background: #fff; border-radius: 20px; padding: 2rem; box-shadow: 0 8px 32px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; position: sticky; top: 100px;">
                <form action="{{ route('form-permohonan.store') }}" method="POST" id="formPermohonan">
                    @csrf
                    
                    <!-- Nama -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="nama" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1a202c; margin-bottom: 0.625rem;">
                            <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-user" style="color: #14b8a6; font-size: 0.875rem;"></i>
                                <span>Nama Lengkap</span>
                                <span style="color: #ef4444; font-weight: 700;">*</span>
                            </span>
                        </label>
                        <div style="position: relative;">
                            <input 
                                type="text" 
                                id="nama" 
                                name="nama" 
                                value="{{ old('nama') }}"
                                required
                                class="form-input"
                                placeholder="Masukkan nama lengkap Anda"
                                style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.9375rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #fff; color: #1a202c; font-family: inherit;"
                            >
                        </div>
                        @error('nama')
                            <div style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem; padding-left: 0.25rem;">
                                <i class="fas fa-exclamation-circle" style="font-size: 0.8125rem;"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="email" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1a202c; margin-bottom: 0.625rem;">
                            <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-envelope" style="color: #14b8a6; font-size: 0.875rem;"></i>
                                <span>Email</span>
                                <span style="color: #ef4444; font-weight: 700;">*</span>
                            </span>
                        </label>
                        <div style="position: relative;">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                required
                                class="form-input"
                                placeholder="contoh@email.com"
                                style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.9375rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #fff; color: #1a202c; font-family: inherit;"
                            >
                        </div>
                        @error('email')
                            <div style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem; padding-left: 0.25rem;">
                                <i class="fas fa-exclamation-circle" style="font-size: 0.8125rem;"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- No Telp -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="no_telp" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1a202c; margin-bottom: 0.625rem;">
                            <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-phone" style="color: #14b8a6; font-size: 0.875rem;"></i>
                                <span>Nomor Telepon</span>
                                <span style="color: #ef4444; font-weight: 700;">*</span>
                            </span>
                        </label>
                        <div style="position: relative;">
                            <input 
                                type="text" 
                                id="no_telp" 
                                name="no_telp" 
                                value="{{ old('no_telp') }}"
                                required
                                maxlength="20"
                                class="form-input"
                                placeholder="081234567890"
                                style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.9375rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #fff; color: #1a202c; font-family: inherit;"
                            >
                        </div>
                        @error('no_telp')
                            <div style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem; padding-left: 0.25rem;">
                                <i class="fas fa-exclamation-circle" style="font-size: 0.8125rem;"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="deskripsi" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1a202c; margin-bottom: 0.625rem;">
                            <span style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-file-alt" style="color: #14b8a6; font-size: 0.875rem;"></i>
                                <span>Deskripsi Permohonan</span>
                                <span style="color: #ef4444; font-weight: 700;">*</span>
                            </span>
                        </label>
                        <div style="position: relative;">
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi" 
                                rows="3"
                                required
                                class="form-input"
                                placeholder="Jelaskan alasan atau tujuan permohonan akun Anda..."
                                style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 0.9375rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #fff; color: #1a202c; resize: vertical; font-family: inherit; line-height: 1.5; min-height: 80px;"
                            >{{ old('deskripsi') }}</textarea>
                        </div>
                        @error('deskripsi')
                            <div style="color: #ef4444; font-size: 0.8125rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem; padding-left: 0.25rem;">
                                <i class="fas fa-exclamation-circle" style="font-size: 0.8125rem;"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; padding-top: 2.5rem; border-top: 1px solid #e2e8f0;">
                        <button 
                            type="submit" 
                            id="submitBtn"
                            style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%); color: #fff; padding: 0.875rem 1.5rem; border-radius: 12px; font-size: 0.9375rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 16px rgba(20, 184, 166, 0.3); display: inline-flex; align-items: center; justify-content: center; gap: 0.625rem; width: 100%;"
                        >
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Permohonan</span>
                        </button>
                        <!-- <a 
                            href="{{ route('landing') }}" 
                            style="background: #fff; color: #14b8a6; padding: 0.875rem 1.5rem; border-radius: 12px; font-size: 0.9375rem; font-weight: 600; border: 2px solid #14b8a6; text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: inline-flex; align-items: center; justify-content: center; gap: 0.625rem; width: 100%; text-align: center;"
                            onmouseover="this.style.background='#f0fdfa'"
                            onmouseout="this.style.background='#fff'"
                        >
                            <i class="fas fa-times"></i>
                            <span>Batal</span>
                        </a> -->
                    </div>
                </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info - Full Width -->
            <div style="background: linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%); border-radius: 16px; padding: 2rem; color: #fff; box-shadow: 0 8px 24px rgba(20, 184, 166, 0.3); margin-top: 2rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 2rem; flex-wrap: wrap;" class="contact-info-responsive">
                    <div style="flex: 1; min-width: 250px;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-headset"></i>
                            Butuh Bantuan?
                        </h3>
                        <p style="font-size: 0.9375rem; opacity: 0.95; line-height: 1.6; margin: 0;">
                            Jika Anda memiliki pertanyaan atau butuh bantuan dalam mengisi form, jangan ragu untuk menghubungi kami.
                        </p>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <a href="https://wa.me/6281392189055" target="_blank" style="display: inline-flex; align-items: center; gap: 0.75rem; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); color: #fff; padding: 1rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 1rem; transition: all 0.3s; border: 1px solid rgba(255, 255, 255, 0.3); white-space: nowrap;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'; this.style.transform='translateY(0)'">
                            <i class="fab fa-whatsapp" style="font-size: 1.5rem;"></i>
                            <span>Hubungi via WhatsApp</span>
                        </a>
                    </div>
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
        /* Form Input Styling */
        .form-input:focus {
            outline: none;
            border-color: #14b8a6 !important;
            box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1) !important;
            background: #fff !important;
        }

        .form-input:hover {
            border-color: #cbd5e0 !important;
        }

        .form-input::placeholder {
            color: #a0aec0;
            opacity: 1;
        }

        /* Button Hover Effects */
        #submitBtn:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 8px 24px rgba(20, 184, 166, 0.4) !important;
        }

        #submitBtn:active {
            transform: translateY(-1px) !important;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .form-layout-responsive {
                grid-template-columns: 1fr !important;
                gap: 1.5rem !important;
            }

            div[style*="position: sticky"] {
                position: relative !important;
                top: 0 !important;
            }
        }

        @media (max-width: 768px) {
            section.main-section {
                padding-top: 100px !important;
                padding-bottom: 2rem !important;
            }
            
            .text-center {
                margin-bottom: 1.5rem !important;
            }
            
            .text-center h1 {
                font-size: 1.75rem !important;
            }
            
            div[style*="background: #fff; border-radius: 20px"] {
                padding: 1.5rem !important;
            }

            div[style*="background: linear-gradient(135deg, #f0fdfa"] {
                padding: 1.5rem !important;
            }

            div[style*="background: linear-gradient(135deg, #14b8a6"] {
                padding: 1.5rem !important;
            }

            .contact-info-responsive {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 1.5rem !important;
            }

            .contact-info-responsive a {
                width: 100% !important;
                justify-content: center !important;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 1rem !important;
            }
            
            div[style*="background: #fff; border-radius: 20px"] {
                padding: 1.25rem !important;
            }

            input[style*="padding: 0.875rem"],
            textarea[style*="padding: 0.875rem"] {
                padding: 0.75rem !important;
                font-size: 0.875rem !important;
            }
        }
    </style>
</body>
</html>

