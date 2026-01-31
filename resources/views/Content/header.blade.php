<header class="header-area">
    <div class="container-full">
        <div class="nav-wrapper">
            <!-- Logo -->
            <a href="#" class="logo-header">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo TalentGroup" />
            </a>

            <!-- Desktop Navigation -->
            <nav class="main-nav">
                <ul class="nav">
                    <li><a href="{{ route('home') }}" class="active">Home</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="#">Community</a></li>
                    <li><a href="{{ route('partnerkolaborasi') }}">Partner Kolaborasi</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><a href="#">Message Us</a></li>
                    <li><a href="{{ route('login.user') }}" class="contact-button">Login</a></li>
                </ul>
            </nav>

            <!-- Mobile Menu Toggle -->
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Sidebar -->
<div class="mobile-sidebar" id="mobileSidebar">
    <ul class="mobile-nav">
        <li><a href="{{ route('home') }}" class="active">Home</a></li>
        <li><a href="{{ route('about') }}">About Us</a></li>
        <li><a href="#">Community</a></li>
        <li><a href="{{ route('partnerkolaborasi') }}">Partner Kolaborasi</a></li>
        <li><a href="{{ route('blog') }}">Blog</a></li>
        <li><a href="#">Message Us</a></li>
    </ul>
    <div class="mobile-actions">
        <a href="{{ route('login-dashboard') }}" class="btn btn-primary">Login</a>
    </div>
</div>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<!-- Demo Content -->

<script>
    const menuToggle = document.getElementById('menuToggle');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('overlay');
    const closeSidebar = document.getElementById('closeSidebar');

    function toggleMobileMenu() {
        menuToggle.classList.toggle('active');
        mobileSidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.style.overflow = mobileSidebar.classList.contains('active') ? 'hidden' : '';
    }

    function closeMobileMenu() {
        menuToggle.classList.remove('active');
        mobileSidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    menuToggle.addEventListener('click', toggleMobileMenu);
    overlay.addEventListener('click', closeMobileMenu);
    closeSidebar.addEventListener('click', closeMobileMenu);
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeMobileMenu();
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) closeMobileMenu();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav a, .mobile-nav a');

        navLinks.forEach(link => {
            const linkPath = link.getAttribute('href');
            if (currentPath === linkPath || currentPath.startsWith(linkPath)) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    });
</script>

