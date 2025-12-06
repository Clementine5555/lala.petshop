<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Petshop Lala - Your Trusted Pet Care Partner</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            padding-top: 50px;
            background: #f9f9f9;
            min-width: 320px;
        }
        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            padding: 5px 0;
        }

        .nav-container {
            max-width: 1200px;  /* ← LEBIH KECIL */
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;  /* ← PADDING LEBIH KECIL */
            gap: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            text-decoration: none;
        }

         .logo img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .logo span {
            font-weight: 900;
            color: #FF8C42;
            font-size: 1.2em;
            white-space: nowrap;
        }

        .nav-links {
            display: flex;
            gap: 35px;
            list-style: none;
            align-items: center;
            flex-grow: 1;
            justify-content: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-size: 1.15em;
            letter-spacing: 0.3px;
            transition: color 0.3s, transform 0.3s;
            cursor: pointer;
            white-space: nowrap;
            padding: 6px 10px;
            border-radius: 8px;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #FF8C42;
            background: rgba(255, 140, 66, 0.1);
            transform: translateY(-2px);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-shrink: 0;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
        }

        .cart-icon svg {
            width: 26px;
            height: 26px;
            transition: transform 0.3s;
            color: #333;
        }

        .cart-icon:hover svg {
            transform: scale(1.1);
            color: #FF8C42;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #FF8C42;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65em;
            font-weight: 700;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 50px;
            transition: background 0.3s;
            border: 2px solid transparent;
        }

        .profile-trigger:hover {
            background: rgba(255, 140, 66, 0.1);
            border-color: rgba(255, 140, 66, 0.3);
        }

        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #FF8C42;
            flex-shrink: 0;
        }

        .profile-name {
            font-weight: 600;
            color: #333;
            font-size: 0.9em;
            max-width: 110px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .dropdown-arrow {
            width: 16px;
            height: 16px;
            transition: transform 0.3s;
            flex-shrink: 0;
            color: #666;
        }

        .profile-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
            color: #FF8C42;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 15px);
            right: 0;
            background: white;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            min-width: 240px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s;
            display: none !important;
        }

        .profile-dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            display: block !important;
        }

        .dropdown-item {
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #333;
            transition: background 0.3s;
            border-bottom: 1px solid #f5f5f5;
            font-size: 0.9em;
        }

        .dropdown-item:last-child {
            border-bottom: none;
            border-radius: 0 0 14px 14px;
        }

        .dropdown-item:first-child {
            border-radius: 14px 14px 0 0;
        }

        .dropdown-item:hover {
            background: rgba(255, 140, 66, 0.1);
        }

        .dropdown-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .dropdown-item.logout {
            color: #dc2626;
        }

        .dropdown-item.logout:hover {
            background: rgba(220, 38, 38, 0.1);
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-login,
        .btn-register {
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9em;
            text-decoration: none;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .btn-login {
            color: #FF8C42;
            background: white;
            border: 2px solid #FF8C42;
        }

        .btn-login:hover {
            background: rgba(255, 140, 66, 0.1);
            transform: translateY(-2px);
        }

        .btn-register {
            color: white;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            border: none;
            box-shadow: 0 2px 8px rgba(255, 140, 66, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(255, 140, 66, 0.4);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            padding: 30px;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .modal-header h2 {
            color: #FF8C42;
            font-size: 1.5em;
        }

        .close-modal {
            width: 30px;
            height: 30px;
            cursor: pointer;
            color: #666;
            transition: color 0.3s;
        }

        .close-modal:hover {
            color: #FF8C42;
        }

        /* Form Container */
        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 30px;
            padding: 50px;
            max-width: 600px;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .form-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title h2 {
            font-size: 2em;
            color: #FF8C42;
            margin-bottom: 10px;
        }

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group input[type="number"],
        .form-group input[type="date"],
        .form-group input[type="time"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #FF8C42;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-option input[type="radio"] {
            width: 20px;
            height: 20px;
            accent-color: #FF8C42;
            cursor: pointer;
        }

        .radio-option label {
            cursor: pointer;
            margin-bottom: 0 !important;
        }

        .date-time-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .service-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .service-checkbox:hover {
            border-color: #FF8C42;
            background: #FFF5EB;
        }

        .service-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #FF8C42;
            margin-top: 2px;
            cursor: pointer;
        }

        .service-info {
            flex: 1;
        }

        .service-info strong {
            display: block;
            color: #333;
            margin-bottom: 5px;
        }

        .service-info span {
            color: #666;
            font-size: 0.9em;
        }

        .link-text {
            color: #FF8C42;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9em;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.1em;
            color: #FF8C42;
        }

        .summary-row label {
            color: #666;
        }

        .summary-row span {
            color: #333;
            font-weight: 600;
        }

        .upload-section {
            margin-top: 20px;
        }

        .upload-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #FF8C42;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-btn:hover {
            background: #FF6B35;
        }

        .upload-btn input[type="file"] {
            display: none;
        }

        .file-name {
            display: inline-block;
            margin-left: 10px;
            color: #666;
            font-size: 0.9em;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel {
            background: #e0e0e0;
            color: #666;
        }

        .btn-cancel:hover {
            background: #d0d0d0;
        }

        .btn-next,
        .btn-submit {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-next:hover,
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 140, 66, 0.4);
        }

        .btn-back {
            background: white;
            color: #FF8C42;
            border: 2px solid #FF8C42;
        }

        .btn-back:hover {
            background: #FFF5EB;
        }

        .alert-info {
            background: #FFF5EB;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            color: #FF8C42;
            font-weight: 600;
            text-align: center;
        }

        @media (max-width: 1200px) {
            .nav-container {
                padding: 0 30px;
                gap: 25px;
            }

            .nav-links {
                gap: 25px;
            }

            .nav-links a {
                font-size: 1.15em;
            }
        }

        @media (max-width: 992px) {
            .nav-links {
                gap: 20px;
            }

            .nav-links a {
                font-size: 1.1em;
            }

            .profile-name {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                padding: 0 20px;
            }

            .logo span {
                font-size: 1.2em;
            }

            .nav-links {
                display: none;
            }

            .container {
                padding: 30px 20px;
            }

            .date-time-row {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }
        }

            /* --- CSS FOOTER (WARNA COKLAT EMAS) --- */
        footer {
            background-color: #bf8c3c; /* Warna sesuai gambar */
            color: white;
            padding: 60px 0 20px;
            margin-top: 50px;
            font-family: 'Segoe UI', sans-serif;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 40;
        }

        /* Bagian Kiri */
        .footer-logo-area { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .footer-logo-circle { width: 50px; height: 50px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .footer-logo-circle img { width: 35px; height: 35px; object-fit: contain; }
        .footer-brand-name { font-size: 1.5em; font-weight: 800; letter-spacing: 0.5px; }
        
        .footer-desc { 
            line-height: 1.6; margin-bottom: 40px; font-size: 1em; font-weight: 500;
            max-width: 90%;
        }

        .footer-heading { 
            font-weight: 800; font-size: 1.1em; margin-bottom: 15px; display: block; 
            letter-spacing: 0.5px;
        }

        .footer-list { list-style: none; padding: 0; margin: 0; }
        .footer-list li { margin-bottom: 10px; font-size: 0.95em; font-weight: 600; }
        .footer-list.contact li { display: flex; align-items: flex-start; gap: 12px; font-weight: 600; }

        /* Bagian Kanan */
        .footer-right-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        /* Bagian Tengah (Follow Us) */
        .footer-center {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 30px;
        }
        
        /* Garis & Copyright */
        .footer-line {
            border: 0;
            border-top: 3px solid white;
            margin: 0 40px 25px 40px;
            opacity: 1;
        }

        .copyright {
            text-align: center;
            font-size: 0.95em;
            font-weight: 700;
        }

        @media (max-width: 992px) { 
            .footer-container { grid-template-columns: 1fr; gap: 40px; } 
        }

    </style>
</head>
<body>
    <!-- Navigation - SAME AS DASHBOARD -->
    <nav>
        <div class="nav-container">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('images/logoo.png') }}" alt="Petshop Lala">
                <span>Petshop Lala</span>
            </a>

            <!-- Navigation Links -->
            <ul class="nav-links">
                <li><a href="#home" data-section="home">Home</a></li>
                <li><a href="#appointment" data-section="appointment">Appointment</a></li>
                <li><a href="#products" data-section="products">Products</a></li>
                <li><a href="#contact" data-section="contact">Contact Us</a></li>
            </ul>

            <!-- Right Section -->
            <div class="nav-right">
                <div class="cart-icon" onclick="window.location.href='{{ route('cart.index') }}'">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                @auth
                    @php
                        $cartCount = \App\Models\Cart::where('user_id', auth()->id())
                                                    ->where('status', 'active')
                                                    ->sum('quantity');
                    @endphp
                    @if($cartCount > 0)
                    <span class="cart-badge" id="cartBadge">{{ $cartCount }}</span>
                    @endif
                @endauth
            </div>

                @auth
                <!-- Profile Dropdown (Logged In) -->
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="profile-trigger" onclick="toggleDropdown()">
                        <img src="{{ Auth::user()->profile_photo_url ?? 'data:img/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'%3E%3Ccircle cx=\'50\' cy=\'50\' r=\'50\' fill=\'%23FF8C42\'/%3E%3Cpath d=\'M50 45c8 0 15-7 15-15s-7-15-15-15-15 7-15 15 7 15 15 15zm0 5c-13 0-25 6-25 15v10h50V65c0-9-12-15-25-15z\' fill=\'white\'/%3E%3C/svg%3E' }}"
                             alt="User"
                             class="profile-avatar">
                        <span class="profile-name">{{ Auth::user()->name }}</span>
                        <svg class="dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>

                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item" onclick="openEditProfile(event)">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <a href="#" class="dropdown-item logout" onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </a>
                        </form>
                    </div>
                </div>
                @else
                <!-- Auth Buttons (Not Logged In) -->
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-register">Register</a>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Edit Profile Modal -->
    @auth
    <div class="modal" id="editProfileModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Profile</h2>
                <svg class="close-modal" onclick="closeEditProfile()" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Profile Photo Upload -->
                <div class="form-group">
                    <label>Profile Photo</label>
                    <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px;">
                        <img id="previewPhoto" src="{{ Auth::user()->profile_photo_url ?? 'data:img/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 100%27%3E%3Ccircle cx=%2750%27 cy=%2750%27 r=%2750%27 fill=%27%23FF8C42%27/%3E%3Cpath d=%27M50 45c8 0 15-7 15-15s-7-15-15-15-15 7-15 15 7 15 15 15zm0 5c-13 0-25 6-25 15v10h50V65c0-9-12-15-25-15z%27 fill=%27white%27/%3E%3C/svg%3E' }}" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 3px solid #FF8C42;">
                        <div style="display: flex; gap: 8px; flex-direction: column;">
                            <button type="button" onclick="document.getElementById('photoUpload').click()" style="background: #FF8C42; color: white; border: none; padding: 8px 14px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.9em;">Upload Photo</button>
                            <button type="button" onclick="deletePhoto()" style="background: #dc2626; color: white; border: none; padding: 8px 14px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.9em;">Delete Photo</button>
                        </div>
                    </div>
                    <input type="file" id="photoUpload" name="profile_photo" accept="image/*" style="display: none;" onchange="previewProfilePhoto(event)">
                </div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" id="userName" value="{{ Auth::user()->name }}" placeholder="Enter your name">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="userEmail" value="{{ Auth::user()->email }}" placeholder="Enter your email">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" id="userPhone" value="{{ Auth::user()->phone ?? '' }}" placeholder="Enter your phone">
                </div>

                <button type="submit" class="btn-register" style="width: 100%; padding: 12px; margin-top: 20px;">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
    @endauth

    <!-- Main Content -->
    <main>
        @include('sections.home')
        @include('sections.appointment')
        @include('sections.products')
        @include('sections.contact')
    </main>

    <script>
        // Toast notification
        function showToast(message, type = 'success') {
            if (!message) return; // avoid showing empty toast
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');

            if (toast && toastMessage) {
                toast.className = `toast ${type}`;
                toastMessage.textContent = message;
                toast.classList.add('show');

                setTimeout(() => {
                    hideToast();
                }, 4000);
            }
        }

        function hideToast() {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.remove('show');
            }
        }

        function updateCartBadge() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('cartBadge');
                    if (data.count > 0) {
                        if (badge) {
                            badge.textContent = data.count;
                        } else {
                            const newBadge = document.createElement('span');
                            newBadge.id = 'cartBadge';
                            newBadge.className = 'cart-badge';
                            newBadge.textContent = data.count;
                            document.querySelector('.cart-icon').appendChild(newBadge);
                        }
                    } else if (badge) {
                        badge.remove();
                    }
                });
        }

        // Dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) {
                dropdown.classList.toggle('active');
            }
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Modal
        function openEditProfile(event) {
            event.preventDefault();
            const modal = document.getElementById('editProfileModal');
            const dropdown = document.getElementById('profileDropdown');

            if (modal) modal.classList.add('active');
            if (dropdown) dropdown.classList.remove('active');
        }

        function closeEditProfile() {
            const modal = document.getElementById('editProfileModal');
            if (modal) {
                modal.classList.remove('active');
            }
        }

        // Close dropdowns/modals on page load
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('profileDropdown');
            const modal = document.getElementById('editProfileModal');
            
            if (dropdown) {
                dropdown.classList.remove('active');
                const menu = dropdown.querySelector('.dropdown-menu');
                if (menu) menu.style.display = 'none !important';
            }
            if (modal) {
                modal.classList.remove('active');
                modal.style.display = 'none !important';
            }
            
            // Populate cart badge on load
            try { updateCartBadge(); } catch (e) { console.warn('updateCartBadge not found', e); }

            // Hide all modals and toasts with inline styles
            try {
                document.querySelectorAll('.modal').forEach(m => {
                    m.classList.remove('active');
                    m.style.display = 'none !important';
                });
            } catch (e) { /* ignore */ }

            try {
                const toast = document.getElementById('toast');
                if (toast) {
                    toast.classList.remove('show');
                    toast.style.display = 'none !important';
                }
            } catch (e) { /* ignore */ }
        });

        function previewProfilePhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewPhoto').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function deletePhoto() {
            if (confirm('Are you sure you want to delete your profile photo?')) {
                // Create a hidden input to indicate deletion
                const form = document.getElementById('editProfileForm');
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_profile_photo';
                deleteInput.value = '1';
                form.appendChild(deleteInput);
                
                // Reset file input and preview
                document.getElementById('photoUpload').value = '';
                document.getElementById('previewPhoto').src = 'data:img/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 100%27%3E%3Ccircle cx=%2750%27 cy=%2750%27 r=%2750%27 fill=%27%23FF8C42%27/%3E%3Cpath d=%27M50 45c8 0 15-7 15-15s-7-15-15-15-15 7-15 15 7 15 15 15zm0 5c-13 0-25 6-25 15v10h50V65c0-9-12-15-25-15z%27 fill=%27white%27/%3E%3C/svg%3E';
            }
        }

        const modal = document.getElementById('editProfileModal');
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === this) closeEditProfile();
            });
        }

        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href && href.startsWith('#')) {
                    e.preventDefault();
                    
                    const targetId = href.substring(1); 
                    const target = document.getElementById(targetId);

                    if (target) {
                        document.querySelectorAll('.nav-links a').forEach(l => l.classList.remove('active'));

                        this.classList.add('active');

                        target.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    }
                }
            });
        });

        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('main > section');
            const navLinks = document.querySelectorAll('.nav-links a');

            let current = '';

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                
                if (pageYOffset >= (sectionTop - 100)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                const href = link.getAttribute('href');

                if (href === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        window.addEventListener('load', function() {
            const hash = window.location.hash;

            if (hash) {
                const targetLink = document.querySelector(`.nav-links a[href="${hash}"]`);
                if (targetLink) {
                    document.querySelectorAll('.nav-links a').forEach(l => l.classList.remove('active'));
                    targetLink.classList.add('active');
                }
            } else {
                const homeLink = document.querySelector('.nav-links a[href="#home"]');
                if (homeLink) {
                    homeLink.classList.add('active');
                }
            }
        });

        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    function saveProfile() {
        let name = document.getElementById('userName').value;
        let email = document.getElementById('userEmail').value;
        let phone = document.getElementById('userPhone').value;

        fetch("{{ route('profile.update') }}", {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                name: name,
                email: email,
                phone: phone
            })
        })
        .then(res => res.json())
        .then(data => {
            // 🚀 NOTIF SUKSES
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated!',
                text: data.message,
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 2500
            });

            // 🚀 TUTUP MODAL
            closeEditProfile();
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong!',
            });
        });
    }
    </script>

    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <div class="footer-logo-area">
                    <div class="footer-logo-circle">
                        <img src="/images/logoo.png" alt="Petshop Lala">
                    </div>
                    <span class="footer-brand-name">Petshop Lala</span>
                </div>
                
                <p class="footer-desc">
                    Your trusted partner in pet care.<br>
                    Menyediakan layanan grooming profesional<br>
                    dan produk pet berkualitas sejak 2020.
                </p>

                <div class="footer-contact-area">
                    <span class="footer-heading">Contact</span>
                    <ul class="footer-list contact">
                        <li><span>📍</span> Jl. Pet Lover No. 123, Medan</li>
                        <li><span>📞</span> +62 812-3456-7890</li>
                        <li><span>📧</span> info@petshoplala.com</li>
                        <li><span>⏰</span> Mon-Sun: 08:00 - 20:00</li>
                    </ul>
                </div>
            </div>

            <div class="footer-right-grid">
                <div>
                    <span class="footer-heading">Services</span>
                    <ul class="footer-list">
                        <li>Pet Grooming</li>
                        <li>Pet Hotel</li>
                        <li>Health Check</li>
                        <li>Appointment</li>
                        <li>Booking</li>
                    </ul>
                </div>

                <div>
                    <span class="footer-heading">Customer Service</span>
                    <ul class="footer-list">
                        <li>FAQs</li>
                        <li>Refund Policy</li>
                        <li>Payment Methods</li>
                        <li>Terms & Conditions</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-center">
            <span class="footer-heading">Follow Us</span>
            <div class="footer-list" style="font-weight: 600;">
                Instagram @petshoplala<br>
                Facebook<br>
                TikTok<br>
                WhatsApp Business
            </div>
        </div>

        <hr class="footer-line">

        <div class="copyright">
            © 2025 Petshop Lala. All rights reserved. | Trusted by 10,000+ happy pet owners
        </div>
    </footer>
    ```
</body>
</html>
