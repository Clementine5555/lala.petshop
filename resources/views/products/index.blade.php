<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>All Products - Petshop Lala</title>
    
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
            background: #f5f5f5;
        }

        /* Navigation - SAME AS DASHBOARD */
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
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            gap: 30px;
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
        }

        .profile-dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
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

        /* Products Page dengan Sidebar */
        .products-page {
            padding: 40px 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-header h1 {
            font-size: 2.8em;
            color: #333;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .page-header p {
            font-size: 1.2em;
            color: #666;
        }

        .search-section {
            max-width: 600px;
            margin: 0 auto 50px;
            position: relative;
        }

        .search-box {
            width: 100%;
            padding: 18px 25px 18px 55px;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 1.1em;
            transition: all 0.3s;
            background: white;
        }

        .search-box:focus {
            outline: none;
            border-color: #FF8C42;
            box-shadow: 0 5px 20px rgba(255, 140, 66, 0.2);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3em;
        }

        /* LAYOUT DENGAN SIDEBAR */
        .products-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
            margin-bottom: 50px;
        }

        /* SIDEBAR KATEGORI */
        .category-sidebar {
            background: white;
            border-radius: 25px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            height: fit-content;
            sticky: top;
            position: sticky;
            top: 70px;
        }

        .category-sidebar h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-list {
            list-style: none;
        }

        .category-item {
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.05em;
            color: #666;
            font-weight: 500;
        }

        .category-item:hover {
            background: rgba(255, 140, 66, 0.1);
            color: #FF8C42;
            transform: translateX(5px);
        }

        .category-item.active {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
        }

        .category-item.active:hover {
            transform: translateX(0);
        }

        .category-icon {
            font-size: 1.3em;
        }

        .category-count {
            margin-left: auto;
            background: rgba(255, 140, 66, 0.2);
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.85em;
            font-weight: 600;
            color: #FF8C42;
        }

        .category-item.active .category-count {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: white;
            border-radius: 25px;
            padding: 25px;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .product-image-wrapper {
            width: 100%;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9f9;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .product-image-wrapper img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .product-info h3 {
            font-size: 1.4em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
            min-height: 60px;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .stars {
            display: flex;
            gap: 3px;
        }

        .star {
            color: #FFD700;
            font-size: 1.1em;
        }

        .star.empty {
            color: #ddd;
        }

        .review-count {
            color: #666;
            font-size: 0.95em;
        }

        .product-price {
            font-size: 1.8em;
            color: #FF8C42;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .stock-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 15px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .stock-status.out-of-stock {
            background: #ffebee;
            color: #c62828;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 66, 0.5);
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-secondary {
            background: white;
            color: #FF8C42;
            border: 2px solid #FF8C42;
        }

        .btn-secondary:hover {
            background: #FF8C42;
            color: white;
        }

        /* Product Detail Modal */
        .product-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .product-modal.active {
            display: flex;
        }

        .product-modal-content {
            background: white;
            border-radius: 30px;
            width: 100%;
            max-width: 1000px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .product-modal-header {
            padding: 30px 40px 20px;
            border-bottom: 2px solid #f0f0f0;
            position: relative;
        }

        .product-modal-close {
            position: absolute;
            right: 25px;
            top: 25px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            color: #999;
            transition: all 0.3s;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
        }

        .product-modal-close:hover {
            background: #f5f5f5;
            color: #333;
        }

        .product-modal-body {
            padding: 30px 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .product-modal-image {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9f9;
            border-radius: 20px;
            padding: 30px;
            min-height: 400px;
        }

        .product-modal-image img {
            max-width: 100%;
            max-height: 400px;
        }

        .product-modal-details h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 15px;
        }

        .product-modal-description {
            color: #666;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 20px 0;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            background: #f0f0f0;
            border-radius: 30px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            font-size: 1.3em;
            cursor: pointer;
            transition: all 0.3s;
        }

        .quantity-btn:hover {
            background: #e0e0e0;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            background: transparent;
            font-size: 1.1em;
            font-weight: 600;
        }

        /* Reviews Section */
        .reviews-section {
            padding: 30px 40px;
            background: #f9f9f9;
            border-top: 2px solid #e0e0e0;
        }

        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .reviews-header h3 {
            font-size: 1.6em;
            color: #333;
        }

        .btn-add-review {
            padding: 10px 25px;
            background: #FF8C42;
            color: white;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-add-review:hover {
            background: #FF6B35;
            transform: translateY(-2px);
        }

        .review-form {
            display: none;
            background: white;
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 25px;
        }

        .review-form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .rating-input {
            display: flex;
            gap: 8px;
            font-size: 2em;
        }

        .rating-input span {
            cursor: pointer;
            color: #ddd;
            transition: all 0.2s;
        }

        .rating-input span:hover,
        .rating-input span.active {
            color: #FFD700;
        }

        .form-control {
            width: 100%;
            padding: 12px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1em;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #FF8C42;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
        }

        .review-item {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 15px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .review-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF8C42, #FF6B35);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2em;
        }

        .author-info h4 {
            font-size: 1.1em;
            color: #333;
        }

        .review-date {
            color: #999;
            font-size: 0.9em;
        }

        .review-text {
            color: #666;
            line-height: 1.6;
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

            .products-layout {
                grid-template-columns: 250px 1fr;
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

            .product-modal-body {
                grid-template-columns: 1fr;
            }

            .products-layout {
                grid-template-columns: 1fr;
            }

            .category-sidebar {
                position: static;
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

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }
        }
    </style>
</head>
<body>

    <!-- Navigation - SAMA PERSIS DENGAN DASHBOARD -->
    <nav>
        <div class="nav-container">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="/images/logoo.png" alt="Petshop Lala">
                <span>Petshop Lala</span>
            </a>
            
            <!-- Navigation Links -->
            <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}#home">Home</a></li>
                <li><a href="{{ route('dashboard') }}#appointment">Appointment</a></li>
                <li><a href="{{ route('products.index') }}" class="active">Products</a></li>
                <li><a href="{{ route('dashboard') }}#contact">Contact Us</a></li>
            </ul>

            <!-- Right Section -->
            <div class="nav-right">
                <!-- Cart Icon -->
                <div class="cart-icon" onclick="window.location.href='{{ route('cart.index') }}'">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                    <span class="cart-badge" id="cartBadge">{{ count(session('cart')) }}</span>
                    @endif
                </div>

                @auth
                <!-- Profile Dropdown (Logged In) -->
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="profile-trigger" onclick="toggleDropdown()">
                        <img src="{{ Auth::user()->profile_photo_url ?? 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'%3E%3Ccircle cx=\'50\' cy=\'50\' r=\'50\' fill=\'%23FF8C42\'/%3E%3Cpath d=\'M50 45c8 0 15-7 15-15s-7-15-15-15-15 7-15 15 7 15 15 15zm0 5c-13 0-25 6-25 15v10h50V65c0-9-12-15-25-15z\' fill=\'white\'/%3E%3C/svg%3E' }}" 
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

            <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" id="userName" value="{{ Auth::user()->name }}" placeholder="Enter your name" class="form-control">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="userEmail" value="{{ Auth::user()->email }}" placeholder="Enter your email" class="form-control">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" id="userPhone" value="{{ Auth::user()->phone ?? '' }}" placeholder="Enter your phone" class="form-control">
                </div>

                <button type="submit" class="btn-register" style="width: 100%; padding: 12px; margin-top: 20px;">Save Changes</button>
            </form>
        </div>
    </div>
    @endauth

    <!-- Products Page Content -->
    <div class="products-page">
        <div class="page-header">
            <h1>Yummy Bites for Happy Pets</h1>
            <p>Biar waktu makan jadi momen paling ditunggu si meong dan si guguk!</p>
        </div>

        <div class="search-section">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-box" id="searchInput" placeholder="Search products...">
        </div>

        <!-- LAYOUT DENGAN SIDEBAR -->
        <div class="products-layout">
            <!-- SIDEBAR KATEGORI -->
            <div class="category-sidebar">
                <h3>
                    <span>📂</span>
                    Kategori
                </h3>
                <ul class="category-list">
                    <li class="category-item active" onclick="filterCategory('all')" data-category="all">
                        <span class="category-icon">🏠</span>
                        <span>Semua Produk</span>
                        <span class="category-count" id="count-all">8</span>
                    </li>
                    <li class="category-item" onclick="filterCategory('cat-food')" data-category="cat-food">
                        <span class="category-icon">🐱</span>
                        <span>Makanan Kucing</span>
                        <span class="category-count" id="count-cat-food">4</span>
                    </li>
                    <li class="category-item" onclick="filterCategory('dog-food')" data-category="dog-food">
                        <span class="category-icon">🐶</span>
                        <span>Makanan Anjing</span>
                        <span class="category-count" id="count-dog-food">2</span>
                    </li>
                    <li class="category-item" onclick="filterCategory('vitamin')" data-category="vitamin">
                        <span class="category-icon">💊</span>
                        <span>Vitamin & Suplemen</span>
                        <span class="category-count" id="count-vitamin">0</span>
                    </li>
                    <li class="category-item" onclick="filterCategory('grooming')" data-category="grooming">
                        <span class="category-icon">🧴</span>
                        <span>Perawatan & Grooming</span>
                        <span class="category-count" id="count-grooming">0</span>
                    </li>
                    <li class="category-item" onclick="filterCategory('toys')" data-category="toys">
                        <span class="category-icon">🎾</span>
                        <span>Mainan & Aksesoris</span>
                        <span class="category-count" id="count-toys">0</span>
                    </li>
                </ul>
            </div>

            <!-- PRODUCTS GRID -->
            <div class="products-grid" id="productsGrid">
                <?php
                $products = [
                    ['product_id' => 1, 'name' => 'Whiskas', 'description' => 'Makanan lezat dan bergizi untuk kucing kesayangan Anda', 'price' => 130000, 'stock' => 15, 'average_rating' => 5, 'reviews_count' => 28, 'image_url' => asset('images/whiskas.avif'), 'category' => 'cat-food'],
                    ['product_id' => 2, 'name' => 'Me-O', 'description' => 'Premium cat food with salmon', 'price' => 99000, 'stock' => 30, 'average_rating' => 4.5, 'reviews_count' => 15, 'image_url' => asset('images/me-o.jpg'), 'category' => 'cat-food'],
                    ['product_id' => 3, 'name' => 'Royal Canin', 'description' => 'High quality pet nutrition', 'price' => 99000, 'stock' => 20, 'average_rating' => 5, 'reviews_count' => 42, 'image_url' => asset('images/caninneanj.jpeg'), 'category' => 'cat-food'],
                    ['product_id' => 4, 'name' => 'Cat Choize', 'description' => 'Makanan kucing berkualitas tinggi', 'price' => 210000, 'stock' => 18, 'average_rating' => 4, 'reviews_count' => 22, 'image_url' => asset('images/me-o.jpg'), 'category' => 'cat-food'],
                    ['product_id' => 5, 'name' => 'Premium Dry Dog Food', 'description' => 'Nutrisi lengkap untuk anjing dewasa, 5kg', 'price' => 350000, 'stock' => 12, 'average_rating' => 5, 'reviews_count' => 35, 'image_url' => asset('images/premiumdry.webp'), 'category' => 'dog-food'],
                    ['product_id' => 6, 'name' => 'Pedigree Adult', 'description' => 'Complete nutrition for adult dogs', 'price' => 285000, 'stock' => 25, 'average_rating' => 4.5, 'reviews_count' => 18, 'image_url' => asset('images/pedigree.jpg'), 'category' => 'dog-food'],
                    ['product_id' => 7, 'name' => 'Purina Pro Plan', 'description' => 'Advanced nutrition for cats', 'price' => 425000, 'stock' => 8, 'average_rating' => 5, 'reviews_count' => 31, 'image_url' => asset('images/purina.jpeg'), 'category' => 'cat-food'],
                    ['product_id' => 8, 'name' => 'Friskies', 'description' => 'Delicious meals for playful cats', 'price' => 75000, 'stock' => 40, 'average_rating' => 4, 'reviews_count' => 12, 'image_url' => asset('images/friskies.avif'), 'category' => 'cat-food']
                ];

                $reviews = [
                    1 => [
                        ['user_name' => 'Tachyang Cutesy', 'rating' => 5, 'comment' => 'Eeck - eek aa. Kucing saya sangat suka!', 'date' => '20 Jan 2026'],
                        ['user_name' => 'Budi Santoso', 'rating' => 5, 'comment' => 'Kualitas bagus, kucing jadi lebih sehat', 'date' => '18 Jan 2026']
                    ],
                    2 => [
                        ['user_name' => 'Siti Aminah', 'rating' => 4, 'comment' => 'Bagus tapi agak mahal', 'date' => '15 Jan 2026']
                    ],
                    3 => [
                        ['user_name' => 'John Doe', 'rating' => 5, 'comment' => 'Best quality pet food!', 'date' => '10 Jan 2026']
                    ],
                    4 => [
                        ['user_name' => 'Maria Clara', 'rating' => 4, 'comment' => 'Kucing saya doyan banget', 'date' => '12 Jan 2026']
                    ],
                    5 => [
                        ['user_name' => 'Ahmad Yani', 'rating' => 5, 'comment' => 'Anjing saya jadi lebih energik', 'date' => '8 Jan 2026']
                    ],
                    6 => [
                        ['user_name' => 'Linda Wijaya', 'rating' => 4, 'comment' => 'Good product for my dog', 'date' => '5 Jan 2026']
                    ],
                    7 => [
                        ['user_name' => 'Rina Susanti', 'rating' => 5, 'comment' => 'Premium quality, worth the price', 'date' => '3 Jan 2026']
                    ],
                    8 => [
                        ['user_name' => 'Tommy Lee', 'rating' => 4, 'comment' => 'Affordable and good', 'date' => '1 Jan 2026']
                    ]
                ];
                ?>
                    <?php foreach($products as $product): ?>
                    <div class="product-card" data-id="<?php echo $product['product_id']; ?>" data-category="<?php echo $product['category']; ?>">
                    <div class="product-image-wrapper">
                        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="product-info">
                        <h3><?php echo $product['name']; ?></h3>
                        
                        <div class="product-rating">
                            <div class="stars">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?php echo $i <= round($product['average_rating']) ? '' : 'empty'; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                            <span class="review-count">(<?php echo $product['reviews_count']; ?> reviews)</span>
                        </div>

                        <div class="product-price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></div>

                        <div class="stock-status <?php echo $product['stock'] > 0 ? '' : 'out-of-stock'; ?>">
                            <?php echo $product['stock'] > 0 ? '✓ Stock (' . $product['stock'] . ' tersedia)' : '✗ Out of Stock'; ?>
                        </div>

                        <div class="product-actions">
                            <button class="btn btn-secondary" onclick="event.stopPropagation(); openProductDetail(<?php echo $product['product_id']; ?>)">
                                Detail
                            </button>
                            <button class="btn btn-primary" onclick="event.stopPropagation(); addToCart(<?php echo $product['product_id']; ?>, '<?php echo addslashes($product['name']); ?>')" <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div class="product-modal" id="productModal">
        <div class="product-modal-content">
            <div class="product-modal-header">
                <span class="product-modal-close" onclick="closeModal()">✕</span>
            </div>
            <div class="product-modal-body" id="modalBody">
                <!-- Content loaded dynamically -->
            </div>
            <div class="reviews-section" id="reviewsSection">
                <!-- Reviews loaded dynamically -->
            </div>
        </div>
    </div>

    <script>
        // Sample product data for JavaScript
        const productsData = <?php echo json_encode($products); ?>;
        const allReviews = <?php echo json_encode($reviews); ?>;

        // ============================================
        // FILTER KATEGORI - FITUR BARU
        // ============================================
        function filterCategory(category) {
            // Update active state
            document.querySelectorAll('.category-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`[data-category="${category}"]`).classList.add('active');

            // Filter products
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // ============================================
        // CART MANAGEMENT - TETAP FUNGSIONAL
        // ============================================
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('cartBadge');
                    if (data.count > 0) {
                        if (badge) {
                            badge.textContent = data.count;
                            badge.style.display = 'flex';
                        } else {
                            const newBadge = document.createElement('span');
                            newBadge.id = 'cartBadge';
                            newBadge.className = 'cart-badge';
                            newBadge.textContent = data.count;
                            document.querySelector('.cart-icon').appendChild(newBadge);
                        }
                    } else if (badge) {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error updating cart count:', error));
        }

        // Call on page load
        updateCartCount();

        function addToCart(productId, productName) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + productName + ' berhasil ditambahkan ke keranjang!');
                    updateCartCount();
                } else {
                    alert('❌ ' + (data.message || 'Gagal menambahkan ke keranjang'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan saat menambahkan ke keranjang');
            });
        }

        // ============================================
        // SEARCH FUNCTIONALITY - TETAP FUNGSIONAL
        // ============================================
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const productCards = document.querySelectorAll('.product-card');
            
            productCards.forEach(card => {
                const productName = card.querySelector('h3').textContent.toLowerCase();
                if (productName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // ============================================
        // PRODUCT DETAIL MODAL - TETAP FUNGSIONAL
        // ============================================
        function openProductDetail(productId) {
            const product = productsData.find(p => p.product_id === productId);
            if (!product) return;

            const modal = document.getElementById('productModal');
            const modalBody = document.getElementById('modalBody');
            const reviewsSection = document.getElementById('reviewsSection');

            // Render product details
            const stars = Array.from({length: 5}, (_, i) => 
                `<span class="star ${i < Math.round(product.average_rating) ? '' : 'empty'}">★</span>`
            ).join('');

            modalBody.innerHTML = `
                <div class="product-modal-image">
                    <img src="${product.image_url}" alt="${product.name}">
                </div>
                <div class="product-modal-details">
                    <h2>${product.name}</h2>
                    <div class="product-rating">
                        <div class="stars">${stars}</div>
                        <span class="review-count">(${product.reviews_count} reviews)</span>
                    </div>
                    <div class="product-price">Rp ${product.price.toLocaleString('id-ID')}</div>
                    <div class="stock-status ${product.stock > 0 ? '' : 'out-of-stock'}">
                        ${product.stock > 0 ? '✓ Stock (' + product.stock + ' tersedia)' : '✗ Out of Stock'}
                    </div>
                    <div class="product-modal-description">
                        <p>${product.description}</p>
                    </div>
                    <div class="quantity-selector">
                        <label>Quantity:</label>
                        <div class="quantity-controls">
                            <button class="quantity-btn" onclick="changeQuantity(-1)">−</button>
                            <input type="number" class="quantity-input" id="quantityInput" value="1" min="1" max="${product.stock}" readonly>
                            <button class="quantity-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                    </div>
                    <button class="btn btn-primary" style="width: 100%; padding: 15px;" onclick="addToCartFromModal(${product.product_id}, '${product.name}')" ${product.stock <= 0 ? 'disabled' : ''}>
                        🛒 Add to Cart
                    </button>
                </div>
            `;

            // Render reviews
            renderReviews(productId);

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function renderReviews(productId) {
            const reviewsSection = document.getElementById('reviewsSection');
            const productReviews = allReviews[productId] || [];

            let reviewsHTML = `
                <div class="reviews-header">
                    <h3>Customer Reviews (${productReviews.length})</h3>
                    <button class="btn-add-review" onclick="toggleReviewForm()">
                        ✏️ Tulis Review
                    </button>
                </div>
                
                <div class="review-form" id="reviewForm">
                    <h4 style="margin-bottom: 20px; color: #333;">Tulis Review Anda</h4>
                    <form onsubmit="submitReview(event, ${productId})">
                        <div class="form-group">
                            <label>Rating Anda</label>
                            <div class="rating-input" id="ratingInput">
                                ${Array.from({length: 5}, (_, i) => `<span onclick="setRating(${i + 1})">★</span>`).join('')}
                            </div>
                            <input type="hidden" id="ratingValue" name="rating" value="5">
                        </div>
                        <div class="form-group">
                            <label>Nama Anda</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="form-group">
                            <label>Komentar Anda</label>
                            <textarea class="form-control" name="comment" placeholder="Berikan review terbaik Anda..." required></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Kirim Review</button>
                            <button type="button" class="btn btn-secondary" onclick="toggleReviewForm()">Batal</button>
                        </div>
                    </form>
                </div>
            `;

            if (productReviews.length > 0) {
                productReviews.forEach(review => {
                    const stars = Array.from({length: 5}, (_, i) => 
                        `<span class="star ${i < review.rating ? '' : 'empty'}">★</span>`
                    ).join('');

                    reviewsHTML += `
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-author">
                                    <div class="author-avatar">${review.user_name.charAt(0).toUpperCase()}</div>
                                    <div class="author-info">
                                        <h4>${review.user_name}</h4>
                                        <div class="stars">${stars}</div>
                                    </div>
                                </div>
                                <span class="review-date">${review.date}</span>
                            </div>
                            <div class="review-text">${review.comment}</div>
                        </div>
                    `;
                });
            } else {
                reviewsHTML += `
                    <div style="text-align: center; padding: 40px; color: #999;">
                        <p>Belum ada review. Jadilah yang pertama!</p>
                    </div>
                `;
            }

            reviewsSection.innerHTML = reviewsHTML;
            setRating(5); // Default rating
        }

        function closeModal() {
            document.getElementById('productModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function changeQuantity(delta) {
            const input = document.getElementById('quantityInput');
            const newValue = parseInt(input.value) + delta;
            const max = parseInt(input.max);
            const min = parseInt(input.min);
            
            if (newValue >= min && newValue <= max) {
                input.value = newValue;
            }
        }

        function addToCartFromModal(productId, productName) {
            const quantity = parseInt(document.getElementById('quantityInput').value);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`✅ ${quantity}x ${productName} berhasil ditambahkan ke keranjang!`);
                    updateCartCount();
                    closeModal();
                } else {
                    alert('❌ ' + (data.message || 'Gagal menambahkan ke keranjang'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan saat menambahkan ke keranjang');
            });
        }

        function toggleReviewForm() {
            const form = document.getElementById('reviewForm');
            form.classList.toggle('active');
        }

        function setRating(rating) {
            document.getElementById('ratingValue').value = rating;
            const stars = document.querySelectorAll('#ratingInput span');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        function submitReview(event, productId) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const newReview = {
                user_name: formData.get('name'),
                rating: parseInt(formData.get('rating')),
                comment: formData.get('comment'),
                date: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })
            };
            
            // Add to reviews array
            if (!allReviews[productId]) {
                allReviews[productId] = [];
            }
            allReviews[productId].unshift(newReview);
            
            // Update product review count
            const product = productsData.find(p => p.product_id === productId);
            if (product) {
                product.reviews_count++;
                const totalRating = allReviews[productId].reduce((sum, r) => sum + r.rating, 0);
                product.average_rating = totalRating / allReviews[productId].length;
            }
            
            alert('✅ Review berhasil ditambahkan!');
            renderReviews(productId);
            toggleReviewForm();
            event.target.reset();
        }

        // Profile dropdown
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

        // Close modal when clicking outside
        document.getElementById('productModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });

        // Edit Profile Modal Functions
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

        const editModal = document.getElementById('editProfileModal');
        if (editModal) {
            editModal.addEventListener('click', function(event) {
                if (event.target === this) closeEditProfile();
            });
        }
    </script>

</body>
</html>