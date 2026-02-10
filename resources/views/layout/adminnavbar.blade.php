<!-- Navigation Bar -->
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <i class="fas fa-route"></i>
            <span>Itinerary Wisata</span>
        </a>
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('admin.destinasi.index') }}" class="{{ request()->routeIs('admin.destinasi.*') ? 'active' : '' }}">Kelola Destinasi</a></li>
            <li><a href="{{ route('admin.paket.index') }}" class="{{ request()->routeIs('admin.paket.*') ? 'active' : '' }}">Kelola Paket</a></li>
            <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        Layanan Fasilitas
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Kelola Tempat Makan</a></li>
                        <li><a href="#">Kelola Akomodasi</a></li>
                    </ul>
                </li>
            <li><a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">Manajemen Pengguna</a></li>
            <li><a href="{{ route('admin.libur_nasional.index') }}" class="{{ request()->routeIs('admin.libur_nasional.*') ? 'active' : '' }}">Kelola Hari Libur</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="display: inline;">
                    @csrf
                    <a href="#" onclick="confirmLogout(event); return false;">Keluar</a>
                </form>
            </li>
        </ul>
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            if (window.innerWidth <= 767) {
                if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                    navMenu.classList.remove('active');
                    hamburger.classList.remove('active');
                }
            }
        });

        // Close menu when clicking on a link (except dropdown toggle)
        navMenu.querySelectorAll('a').forEach(link => {
            // Skip dropdown toggle and dropdown menu links
            if (!link.closest('.dropdown')) {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 767) {
                        navMenu.classList.remove('active');
                        hamburger.classList.remove('active');
                    }
                });
            }
        });
    }

    // Dropdown toggle for mobile and desktop
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
            link.addEventListener('click', () => {
                if (window.innerWidth <= 767) {
                    dropdown.classList.remove('active');
                    navMenu.classList.remove('active');
                    hamburger.classList.remove('active');
                }
            });
        });
    }

    // Logout Confirmation
    function confirmLogout(event) {
        event.preventDefault();
        const form = document.getElementById('logoutForm');
        
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Anda akan keluar dari sistem!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, keluar!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
