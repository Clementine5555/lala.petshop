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
            0% { transform: translateX(-100%) translateY(-100%); }
            100% { transform: translateX(100%) translateY(100%); }
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
            0%, 100% { transform: scale(1); opacity: 0.2; }
            50% { transform: scale(1.3); opacity: 0.5; }
        }

        .glow-circle:nth-child(5) { width: 120px; height: 120px; top: 15%; right: 20%; animation-delay: 0s; }
        .glow-circle:nth-child(6) { width: 180px; height: 180px; bottom: 20%; left: 15%; animation-delay: 2s; }
        .glow-circle:nth-child(7) { width: 100px; height: 100px; top: 50%; right: 10%; animation-delay: 4s; }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 140, 66, 0.95);
            backdrop-filter: blur(20px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.5s ease;
        }

        .loading-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .loading-content {
            text-align: center;
        }

        .loading-spinner {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            position: relative;
        }

        .spinner-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 4px solid transparent;
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 1.5s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        }

        .spinner-ring:nth-child(1) { border-top-color: #fff; animation-delay: -0.45s; }
        .spinner-ring:nth-child(2) { border-top-color: rgba(255, 255, 255, 0.7); animation-delay: -0.3s; }
        .spinner-ring:nth-child(3) { border-top-color: rgba(255, 255, 255, 0.4); animation-delay: -0.15s; }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            color: white;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 16px;
            animation: fadeInOut 2s infinite;
            letter-spacing: 1.5px;
        }

        .loading-subtext {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 500;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        .loading-progress {
            width: 250px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            margin: 25px auto 0;
            overflow: hidden;
        }

        .loading-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #fff, rgba(255, 255, 255, 0.7));
            animation: progress 3s ease-in-out infinite;
        }

        @keyframes progress {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }

        .loading-dots {
            color: white;
            font-size: 32px;
            margin-top: 18px;
            letter-spacing: 4px;
        }

        .loading-dots span {
            animation: blink 1.4s infinite;
        }

        .loading-dots span:nth-child(2) { animation-delay: 0.2s; }
        .loading-dots span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes blink {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 1; }
        }

        .login-container {
            position: relative;
            z-index: 10;
            animation: fadeInScale 1s ease-out;
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 35px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2), inset 0 0 80px rgba(255, 255, 255, 0.1);
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
            font-size: 42px;
            font-weight: 800;
            color: #fff;
            text-align: center;
            margin-bottom: 32px;
            text-shadow: 0 3px 15px rgba(0, 0, 0, 0.4), 0 0 40px rgba(0, 212, 255, 0.3);
            position: relative;
            z-index: 1;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 22px;
            position: relative;
            z-index: 1;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 18px;
            z-index: 2;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 14px 48px 14px 18px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 14px;
            color: white;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder,
        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.3);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #FF8C42, #FF6B35);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 10px 35px rgba(255, 140, 66, 0.5), 0 0 25px rgba(255, 107, 53, 0.4);
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 45px rgba(255, 140, 66, 0.6), 0 0 35px rgba(255, 107, 53, 0.5);
            background: linear-gradient(135deg, #FF9D5C, #FF7B45);
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        .error-message {
            color: #fff;
            background: rgba(231, 76, 60, 0.9);
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-top: 10px;
            border-left: 4px solid #c0392b;
            animation: shake 0.6s;
            box-shadow: 0 5px 20px rgba(231, 76, 60, 0.4);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        @media (max-width: 580px) {
            .login-card { padding: 30px 28px; }
            .login-title { font-size: 36px; margin-bottom: 28px; }
            input[type="email"], input[type="password"], input[type="text"] { padding: 12px 44px 12px 16px; font-size: 13px; }
            .btn-submit { font-size: 14px; padding: 12px; }
        }
    </style>

    <div class="network-bg">
        <div class="network-line"></div>
        <div class="network-line"></div>
        <div class="network-line"></div>
        <div class="network-line"></div>
        <div class="glow-circle"></div>
        <div class="glow-circle"></div>
        <div class="glow-circle"></div>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
            <p class="loading-text">Processing</p>
            <p class="loading-subtext">Please wait, resetting your password</p>
            <div class="loading-progress">
                <div class="loading-progress-bar"></div>
            </div>
            <div class="loading-dots">
                <span>.</span><span>.</span><span>.</span>
            </div>
        </div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Reset Password</h1>

            <form method="POST" action="{{ route('password.store') }}" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $request->email) }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="Enter your email"
                        />
                        <span class="input-icon">📧</span>
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Enter new password"
                        />
                        <span class="input-icon">🔒</span>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-wrapper">
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Confirm new password"
                        />
                        <span class="input-icon">🔒</span>
                    </div>
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Reset Password
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('resetForm').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('loadingOverlay').classList.remove('active');
            });
        @endif
    </script>
</x-guest-layout>