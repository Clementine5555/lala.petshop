<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #FF8C42;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Background untuk gambar custom */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/anjingg.jpg') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
            z-index: 0;
        }

        /* Animated Network Background */
        .network-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            opacity: 0.2;
            z-index: 1;
        }

        .network-line {
            position: absolute;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            height: 2px;
            animation: moveLine 10s linear infinite;
        }

        @keyframes moveLine {
            0% {
                transform: translateX(-100%) translateY(-100%);
            }
            100% {
                transform: translateX(100%) translateY(100%);
            }
        }

        .network-line:nth-child(1) { top: 20%; width: 300px; animation-delay: 0s; }
        .network-line:nth-child(2) { top: 40%; width: 400px; animation-delay: 2s; }
        .network-line:nth-child(3) { top: 60%; width: 350px; animation-delay: 4s; }
        .network-line:nth-child(4) { top: 80%; width: 450px; animation-delay: 6s; }

        .glow-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.25), transparent);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.2;
            }
            50% {
                transform: scale(1.3);
                opacity: 0.5;
            }
        }

        .glow-circle:nth-child(5) {
            width: 120px;
            height: 120px;
            top: 15%;
            right: 20%;
            animation-delay: 0s;
        }

        .glow-circle:nth-child(6) {
            width: 180px;
            height: 180px;
            bottom: 20%;
            left: 15%;
            animation-delay: 2s;
        }

        .glow-circle:nth-child(7) {
            width: 100px;
            height: 100px;
            top: 50%;
            right: 10%;
            animation-delay: 4s;
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            animation: fadeInScale 1s ease-out;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            padding: 60px 50px;
            width: 100%;
            max-width: 480px;
            box-shadow: 
                0 10px 40px rgba(0, 0, 0, 0.2),
                inset 0 0 80px rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.08), transparent);
            animation: shimmer 5s linear infinite;
        }

        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .login-title {
            font-size: 64px;
            font-weight: 800;
            color: #fff;
            text-align: center;
            margin-bottom: 50px;
            text-shadow: 
                0 3px 15px rgba(0, 0, 0, 0.4),
                0 0 40px rgba(0, 212, 255, 0.3);
            position: relative;
            z-index: 1;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 20px;
            z-index: 2;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 18px 55px 18px 22px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            font-size: 16px;
            color: white;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="text"]::placeholder,
        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.3);
        }

        .remember-group {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            cursor: pointer;
            accent-color: #fff;
        }

        .remember-group label {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.95);
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        .btn-submit {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #FF8C42, #FF6B35);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            box-shadow: 
                0 10px 35px rgba(255, 140, 66, 0.5),
                0 0 25px rgba(255, 107, 53, 0.4);
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 15px 45px rgba(255, 140, 66, 0.6),
                0 0 35px rgba(255, 107, 53, 0.5);
            background: linear-gradient(135deg, #FF9D5C, #FF7B45);
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        .form-footer {
            text-align: center;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        .form-footer a {
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .form-footer a:hover {
            text-decoration: underline;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
        }

        .error-message {
            color: #fff;
            background: rgba(231, 76, 60, 0.9);
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 14px;
            margin-top: 12px;
            border-left: 5px solid #c0392b;
            animation: shake 0.6s;
            box-shadow: 0 5px 20px rgba(231, 76, 60, 0.4);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Responsive */
        @media (max-width: 580px) {
            .login-card {
                padding: 45px 35px;
            }

            .login-title {
                font-size: 48px;
                margin-bottom: 40px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"] {
                padding: 16px 50px 16px 18px;
                font-size: 15px;
            }

            .btn-submit {
                font-size: 16px;
                padding: 16px;
            }
        }
    </style>

    <!-- Animated Network Background -->
    <div class="network-bg">
        <div class="network-line"></div>
        <div class="network-line"></div>
        <div class="network-line"></div>
        <div class="network-line"></div>
        <div class="glow-circle"></div>
        <div class="glow-circle"></div>
        <div class="glow-circle"></div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Register</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <div class="input-wrapper">
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus 
                            placeholder="Enter your name"
                        />
                        <span class="input-icon">👤</span>
                    </div>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            placeholder="Enter your email"
                        />
                        <span class="input-icon">📧</span>
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            placeholder="Enter your password"
                        />
                        <span class="input-icon">🔒</span>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-wrapper">
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            placeholder="Confirm your password"
                        />
                        <span class="input-icon">🔒</span>
                    </div>
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Register
                </button>

                <div class="form-footer">
                    Already registered? 
                    <a href="{{ route('login') }}">Sign in</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>