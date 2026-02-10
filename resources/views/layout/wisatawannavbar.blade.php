<!-- Navigation Bar -->
<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('wisatawan.dashboard') }}" class="logo">
            <i class="fas fa-route"></i>
            <span>Itinerary Wisata</span>
        </a>
        <ul class="nav-menu" id="navMenu">
            <li><a href="{{ route('wisatawan.dashboard') }}">Beranda</a></li>
            <li><a href="#">Buat Itinerary</a></li>
            <li><a href="#">Paket Wisata</a></li>
            <li><a href="#">Riwayat</a></li>
            <!-- <li><a href="#">Kelola Hari Libur</a></li> -->
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
