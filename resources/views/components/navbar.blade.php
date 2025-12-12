<nav id="mainNav">
    <div class="nav-container">
        <a href="{{ route('welcome') }}" class="logo">
            <img src="{{ asset('images/logoo.png') }}" alt="Petshop Lala">
            <span>Petshop Lala</span>
        </a>

        <ul class="nav-links">
            <li>
                <a href="{{ request()->routeIs('welcome') || request()->routeIs('dashboard') ? '#home' : route('welcome') }}"
                   class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}"
                   data-section="home">Home</a>
            </li>

            <li>
                <a href="{{ request()->routeIs('welcome') || request()->routeIs('dashboard') ? '#appointment' : route('appointment.create') }}"
                   class="nav-link {{ request()->routeIs('appointment.create') ? 'active' : '' }}"
                   data-section="appointment">Appointment</a>
            </li>

            <li>
                <a href="{{ request()->routeIs('welcome') || request()->routeIs('dashboard') ? '#products' : route('products.shop') }}"
                   class="nav-link {{ request()->routeIs('products.shop') ? 'active' : '' }}"
                   data-section="products">Products</a>
            </li>

            <li>
                <a href="{{ request()->routeIs('welcome') || request()->routeIs('dashboard') ? '#contact' : url('/#contact') }}"
                   class="nav-link"
                   data-section="contact">Contact Us</a>
            </li>
        </ul>

        <div class="nav-right">
            <div class="cart-icon" onclick="window.location.href='{{ route('cart.index') }}'">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                @if(session('cart') && count(session('cart')) > 0)
                <span class="cart-badge" id="cartBadge">{{ count(session('cart')) }}</span>
                @endif
            </div>

            @auth
            <div class="profile-dropdown" id="profileDropdown">
                <div class="profile-trigger" onclick="toggleDropdown(event)">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="profile-name">{{ Auth::user()->name }}</span>
                    <svg class="dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="{{ route('user.orders') }}" class="dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Pesanan Saya
                    </a>

                    <a href="{{ route('user.appointments') }}" class="dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Appointment Saya
                    </a>

                    <a href="#" class="dropdown-item" onclick="openEditProfile(event)">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <a href="#" class="dropdown-item logout" onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </a>
                    </form>
                </div>
            </div>
            @else
            <div class="auth-buttons">
                <a href="{{ route('login') }}" class="btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn-register">Register</a>
            </div>
            @endauth
        </div>
    </div>
</nav>

<style>
    /* Navbar CSS */
    nav { position: fixed; top: 0; width: 100%; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000; padding: 5px 0; }
    .nav-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; gap: 30px; }
    .logo { display: flex; align-items: center; gap: 10px; flex-shrink: 0; text-decoration: none; }
    .logo img { width: 32px; height: 32px; object-fit: contain; }
    .logo span { font-weight: 900; color: #FF8C42; font-size: 1.2em; white-space: nowrap; }

    .nav-links { display: flex; gap: 35px; list-style: none; align-items: center; flex-grow: 1; justify-content: center; }
    .nav-links a { text-decoration: none; color: #333; font-size: 1.15em; letter-spacing: 0.3px; transition: color 0.3s, transform 0.3s; cursor: pointer; white-space: nowrap; padding: 6px 10px; border-radius: 8px; }
    .nav-links a:hover, .nav-links a.active { color: #FF8C42; background: rgba(255, 140, 66, 0.1); transform: translateY(-2px); }

    .nav-right { display: flex; align-items: center; gap: 18px; flex-shrink: 0; }
    .cart-icon { position: relative; cursor: pointer; }
    .cart-icon svg { width: 26px; height: 26px; transition: transform 0.3s; color: #333; }
    .cart-icon:hover svg { transform: scale(1.1); color: #FF8C42; }
    .cart-badge { position: absolute; top: -6px; right: -6px; background: #FF8C42; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 0.65em; font-weight: 700; }

    /* Profile Dropdown Styles */
    .profile-dropdown { position: relative; }
    .profile-trigger { display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 6px 12px; border-radius: 50px; transition: background 0.3s; border: 2px solid transparent; }
    .profile-trigger:hover { background: rgba(255, 140, 66, 0.1); border-color: rgba(255, 140, 66, 0.3); }

    .profile-avatar { width: 34px; height: 34px; border-radius: 50%; background-color: #FF8C42; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2em; border: 2px solid #FF8C42; flex-shrink: 0; }
    .profile-name { font-weight: 600; color: #333; font-size: 0.9em; max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .dropdown-arrow { width: 16px; height: 16px; transition: transform 0.3s; flex-shrink: 0; color: #666; }
    .profile-dropdown.active .dropdown-arrow { transform: rotate(180deg); color: #FF8C42; }

    .dropdown-menu { position: absolute; top: calc(100% + 15px); right: 0; background: white; border-radius: 14px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); min-width: 240px; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s; z-index: 1001; }
    .profile-dropdown.active .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }

    .dropdown-item { padding: 12px 18px; display: flex; align-items: center; gap: 10px; text-decoration: none; color: #333; transition: background 0.3s; border-bottom: 1px solid #f5f5f5; font-size: 0.9em; }
    .dropdown-item:last-child { border-bottom: none; border-radius: 0 0 14px 14px; }
    .dropdown-item:first-child { border-radius: 14px 14px 0 0; }
    .dropdown-item:hover { background: rgba(255, 140, 66, 0.1); }
    .dropdown-item svg { width: 18px; height: 18px; flex-shrink: 0; }
    .dropdown-item.logout { color: #dc2626; }
    .dropdown-item.logout:hover { background: rgba(220, 38, 38, 0.1); }

    .auth-buttons { display: flex; gap: 10px; align-items: center; }
    .btn-login, .btn-register { padding: 8px 20px; border-radius: 50px; font-weight: 600; font-size: 0.9em; text-decoration: none; transition: all 0.3s; white-space: nowrap; }
    .btn-login { color: #FF8C42; background: white; border: 2px solid #FF8C42; }
    .btn-login:hover { background: rgba(255, 140, 66, 0.1); transform: translateY(-2px); }
    .btn-register { color: white; background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%); border: none; box-shadow: 0 2px 8px rgba(255, 140, 66, 0.3); }
    .btn-register:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(255, 140, 66, 0.4); }

    @media (max-width: 992px) { .nav-links { gap: 20px; } .nav-links a { font-size: 1.1em; } .profile-name { display: none; } }
    @media (max-width: 768px) { .nav-container { padding: 0 20px; } .logo span { font-size: 1.2em; } .nav-links { display: none; } }
</style>

<script>
    // 1. Logic Dropdown Profile
    function toggleDropdown(event) {
        event.stopPropagation();
        document.getElementById('profileDropdown').classList.toggle('active');
    }

    window.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown && dropdown.classList.contains('active')) {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        }
    });

    // 2. Logic Scroll Spy (Highlighter Otomatis)
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah kita di halaman Home (/) atau Dashboard (/dashboard)
        const isHomePage = window.location.pathname === '/' || window.location.pathname === '/dashboard';
        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('section');

        if (isHomePage) {
            // A. Smooth Scroll saat Klik
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    // Hanya intercept jika linknya berupa Anchor (#...)
                    if (href.startsWith('#')) {
                        e.preventDefault();
                        const targetId = href.substring(1);
                        const targetSection = document.getElementById(targetId);
                        if (targetSection) {
                            // Update Active Class Manual
                            navLinks.forEach(l => l.classList.remove('active'));
                            this.classList.add('active');
                            targetSection.scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                });
            });

            // B. Auto Update Active saat Scroll
            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    // Trigger aktif jika scroll sudah mencapai -150px dari section
                    if (pageYOffset >= (sectionTop - 150)) {
                        current = section.getAttribute('id');
                    }
                });

                if (current) {
                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        // Cek attribute data-section
                        if (link.dataset.section === current) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        }
    });
</script>
