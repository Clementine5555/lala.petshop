<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Appointment - Pet Care</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=1920') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            padding-top: 70px;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 245, 235, 0.85);
            z-index: -1;
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
    </style>
</head>
<body>
    <!-- Navigation - SAME AS DASHBOARD -->
    <nav>
        <div class="nav-container">
            <!-- Logo -->
            <a href="/" class="logo">
                <img src="/images/logoo.png" alt="Petshop Lala">
                <span>Petshop Lala</span>
            </a>
            
            <!-- Navigation Links -->
            <ul class="nav-links">
                <li><a href="/">Home</a></li>
                <li><a href="/appointment" class="active">Appointment</a></li>
                <li><a href="/products">Products</a></li>
                <li><a href="/contact">Contact Us</a></li>
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

                <button type="submit" class="btn-register" style="width: 100%; padding: 12px; margin-top: 20px;">Save Changes</button>
            </form>
        </div>
    </div>
    @endauth

    <div class="container">
        <form action="/appointment" method="POST" enctype="multipart/form-data" id="appointmentForm">
            @csrf
            
            <!-- Step 1: Pet Information -->
            <div class="form-step active" data-step="1">
                <div class="form-title">
                    <h2>Pet Information</h2>
                </div>

                <div class="form-group">
                    <label for="pet_name">Pet Name</label>
                    <input type="text" id="pet_name" name="pet_name" required>
                </div>

                <div class="form-group">
                    <label>Pet Type</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="dog" name="pet_type" value="dog" required>
                            <label for="dog">Dog</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="cat" name="pet_type" value="cat">
                            <label for="cat">Cat</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pet_age">Pet Age</label>
                    <div class="date-time-row">
                        <input type="number" id="pet_age_years" name="pet_age_years" placeholder="Years" min="0">
                        <input type="number" id="pet_age_months" name="pet_age_months" placeholder="Months" min="0" max="11">
                    </div>
                </div>

                <div class="form-group">
                    <label for="pet_breed">Pet Breed</label>
                    <input type="text" id="pet_breed" name="pet_breed" required>
                    <small class="link-text">mixed breed dog</small>
                </div>

                <div class="form-group">
                    <label>Pet Gender</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="female" name="pet_gender" value="female" required>
                            <label for="female">Female</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="male" name="pet_gender" value="male">
                            <label for="male">Male</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pet_weight">Weight</label>
                    <input type="number" id="pet_weight" name="pet_weight" placeholder="kg" step="0.1" required>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-cancel" onclick="window.location.href='/'">Cancel</button>
                    <button type="button" class="btn btn-next" onclick="nextStep(2)">Next</button>
                </div>
            </div>

            <!-- Step 2: Appointment Details -->
            <div class="form-step" data-step="2">
                <div class="form-title">
                    <h2>Appointment Details</h2>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Appointment Date</label>
                    <input type="date" id="appointment_date" name="appointment_date" required>
                </div>

                <div class="form-group">
                    <label for="appointment_time">Appointment Time</label>
                    <div class="date-time-row">
                        <input type="time" id="appointment_time" name="appointment_time" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Service</label>
                    
             <div class="service-checkbox">
                        <input type="checkbox" id="bath_only" name="services[]" value="bath_only" data-price="400000">
                        <div class="service-info">
                            <strong>Bath Only - Rp 50.000</strong>
                        </div>
                    </div>

                    <div class="service-checkbox">
                        <input type="checkbox" id="full_grooming" name="services[]" value="full_grooming" data-price="750000">
                        <div class="service-info">
                            <strong>Full Grooming - Rp 120.000 (bath, haircut, nail cut, ear cleaning, perfume)</strong>
                            <span>Complete grooming package</span>
                        </div>
                    </div>



                <div class="form-group">
                    <label for="notes">Additional Notes</label>
                    <textarea id="notes" name="notes" placeholder="e.g. dog doesn't like cold water, please use warm water"></textarea>
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-back" onclick="prevStep(1)">Back</button>
                    <button type="button" class="btn btn-next" onclick="nextStep(3)">Next</button>
                </div>
            </div>

            <!-- Step 3: Payment Summary -->
            <div class="form-step" data-step="3">
                <div class="form-title">
                    <h2>Payment Summary</h2>
                </div>

                <div class="form-group">
                    <div class="summary-row">
                        <label>Customer Name:</label>
                        <span id="summary_customer">{{ Auth::user()->name ?? 'Guest' }}</span>
                    </div>
                    <div class="summary-row">
                        <label>Pet Name:</label>
                        <span id="summary_pet">-</span>
                    </div>
                    <div class="summary-row">
                        <label>Appointment Date:</label>
                        <span id="summary_date">-</span>
                    </div>
                    <div class="summary-row">
                        <label>Appointment Time:</label>
                        <span id="summary_time">-</span>
                    </div>
                    <div class="summary-row">
                        <label>Selected Service:</label>
                        <span id="summary_service">-</span>
                    </div>
                    <div class="summary-row">
                        <label>Total Price:</label>
                        <span id="summary_price">Rp 0</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Payment Method</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="cash" name="payment_method" value="cash" required>
                            <label for="cash">Cash</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer">
                            <label for="bank_transfer">Bank Transfer</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="ewallet" name="payment_method" value="ewallet">
                            <label for="ewallet">E-Wallet (GoPay)</label>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="transfer-info" style="display: none; background: #FFF5EB; padding: 20px; border-radius: 10px; margin-top: 20px;">
                    <label style="font-size: 1.1em; margin-bottom: 15px;">Transfer to:</label>
                    <p id="transfer-details" style="color: #FF8C42; font-weight: 700; font-size: 1.2em; margin-top: 10px;"></p>
                </div>

                <div class="upload-section" id="upload-section" style="display: none;">
                    <label style="display: block; margin-bottom: 10px; font-weight: 600;">Upload Proof of Payment:</label>
                    <small style="color: #666; display: block; margin-bottom: 10px;">Support file types: JPG, JPEG, PNG (max. 2MB)</small>
                    <label class="upload-btn">
                        Choose File
                        <input type="file" name="payment_proof" accept="image/*" id="payment_proof" onchange="showFileName()">
                    </label>
                    <span class="file-name" id="file-name"></span>
                </div>

                <div class="alert-info" id="cash-info" style="display: none;">
                    Pembayaran cash akan dikonfirmasi saat Anda datang ke toko
                </div>

                <div class="button-group">
                    <button type="button" class="btn btn-back" onclick="prevStep(2)">Back</button>
                    <button type="button" class="btn btn-submit" onclick="submitForm()">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('active');
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
            document.getElementById('editProfileModal').classList.add('active');
            document.getElementById('profileDropdown').classList.remove('active');
        }

        function closeEditProfile() {
            document.getElementById('editProfileModal').classList.remove('active');
        }

        const modal = document.getElementById('editProfileModal');
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === this) closeEditProfile();
            });
        }

        function nextStep(step) {
            // Validasi step sebelum pindah
            const currentStep = document.querySelector('.form-step.active');
            const inputs = currentStep.querySelectorAll('input[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (input.type === 'radio') {
                    const name = input.name;
                    const checked = document.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        isValid = false;
                    }
                } else if (input.type === 'checkbox') {
                    // Skip checkbox validation for now
                } else if (!input.value) {
                    isValid = false;
                }
            });

            if (!isValid) {
                alert('Please fill all required fields');
                return;
            }

            document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
            document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
            
            if(step === 3) {
                updateSummary();
            }

            window.scrollTo(0, 0);
        }

        function prevStep(step) {
            document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
            document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
            window.scrollTo(0, 0);
        }

        function updateSummary() {
            // Update pet name
            const petName = document.getElementById('pet_name').value;
            document.getElementById('summary_pet').textContent = petName || '-';
            
            // Update date
            const date = document.getElementById('appointment_date').value;
            document.getElementById('summary_date').textContent = date || '-';
            
            // Update time
            const time = document.getElementById('appointment_time').value;
            document.getElementById('summary_time').textContent = time || '-';
            
            // Update selected services and calculate total
            const services = [];
            let totalPrice = 0;
            
            document.querySelectorAll('input[name="services[]"]:checked').forEach(checkbox => {
                const serviceText = checkbox.nextElementSibling.querySelector('strong').textContent;
                services.push(serviceText);
                totalPrice += parseInt(checkbox.dataset.price);
            });
            
            document.getElementById('summary_service').textContent = services.length > 0 ? services.join(', ') : '-';
            document.getElementById('summary_price').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
        }

        function showFileName() {
            const input = document.getElementById('payment_proof');
            const fileName = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
            }
        }

        function togglePaymentInfo() {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            const transferInfo = document.getElementById('transfer-info');
            const transferDetails = document.getElementById('transfer-details');
            const uploadSection = document.getElementById('upload-section');
            const cashInfo = document.getElementById('cash-info');
            
            console.log('Payment method changed:', paymentMethod ? paymentMethod.value : 'none');
            
            if (!paymentMethod) return;
            
            // Hide all sections first
            transferInfo.style.display = 'none';
            uploadSection.style.display = 'none';
            cashInfo.style.display = 'none';
            
            const method = paymentMethod.value;
            
            if (method === 'cash') {
                cashInfo.style.display = 'block';
                console.log('Showing cash info');
            } else if (method === 'bank_transfer') {
                transferInfo.style.display = 'block';
                transferDetails.textContent = 'SeaBank - 901683597161';
                uploadSection.style.display = 'block';
                console.log('Showing bank transfer info');
            } else if (method === 'ewallet') {
                transferInfo.style.display = 'block';
                transferDetails.textContent = 'GoPay - 081260968298';
                uploadSection.style.display = 'block';
                console.log('Showing ewallet info');
            }
        }
        
        function submitForm() {
            // Check if payment method is selected
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            
            if (!paymentMethod) {
                alert('Please select a payment method!');
                return false;
            }
            
            // Check if upload required for non-cash payments
            const method = paymentMethod.value;
            const paymentProof = document.getElementById('payment_proof');
            
            if ((method === 'bank_transfer' || method === 'ewallet') && !paymentProof.files.length) {
                alert('Please upload proof of payment!');
                return false;
            }
            
            // If all validation passed, submit the form
            console.log('Form is valid, submitting...');
            document.getElementById('appointmentForm').submit();
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('appointment_date').setAttribute('min', today);
            
            // Add event listeners to all payment method radios
            document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
                radio.addEventListener('change', togglePaymentInfo);
            });
            
            // Check if payment method already selected and show info
            togglePaymentInfo();
        });
    </script>

</body>
</html>