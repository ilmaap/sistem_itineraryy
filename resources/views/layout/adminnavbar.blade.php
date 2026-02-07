<!-- Navigation Bar -->
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <i class="fas fa-route"></i>
            <span>Itinerary Wisata</span>
        </a>
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ route('admin.dashboard') }}" class="active">Beranda</a></li>
            <li><a href="{{ route('admin.destinasi.index') }}">Kelola Destinasi</a></li>
            <li><a href="{{ route('admin.paket.index') }}">Kelola Paket</a></li>
            <li><a href="#">Manajemen Pengguna</a></li>
            <li><a href="#">Kelola Hari Libur</a></li>
            <li><a href="{{ route('logout') }}">Keluar</a></li>
        </ul>
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

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

        // Close menu when clicking on a link
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 767) {
                    navMenu.classList.remove('active');
                    hamburger.classList.remove('active');
                }
            });
        });
    }
</script>
