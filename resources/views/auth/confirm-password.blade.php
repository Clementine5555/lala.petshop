<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fbbf24 0%, #fb923c 50%, #f97316 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(251, 191, 36, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(249, 115, 22, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(251, 146, 60, 0.2) 0%, transparent 50%);
            animation: bgMove 15s ease-in-out infinite;
        }

        @keyframes bgMove {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 30px) scale(0.9); }
        }

        /* Floating Particles */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            animation: float 20s infinite;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 60px; height: 60px; left: 80%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 100px; height: 100px; left: 50%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 50px; height: 50px; left: 30%; animation-delay: 6s; }
        .particle:nth-child(5) { width: 70px; height: 70px; left: 70%; animation-delay: 8s; }

        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.3; }
            90% { opacity: 0.3; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.98) 0%, rgba(249, 115, 22, 0.98) 100%);
            backdrop-filter: blur(20px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.4s ease;
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
            position: relative;
        }

        .loading-spinner {
            width: 140px;
            height: 140px;
            margin: 0 auto 50px;
            position: relative;
        }

        .spinner-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 4px solid transparent;
            border-radius: 50%;
            animation: spin 2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        }

        .spinner-ring:nth-child(1) {
            border-top-color: #fff;
            animation-delay: -0.45s;
        }

        .spinner-ring:nth-child(2) {
            border-right-color: rgba(255, 255, 255, 0.7);
            animation-delay: -0.3s;
        }

        .spinner-ring:nth-child(3) {
            border-bottom-color: rgba(255, 255, 255, 0.5);
            animation-delay: -0.15s;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 50px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(0.9); opacity: 0.7; }
            50% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
        }

        .loading-text {
            color: white;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .loading-subtext {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 40px;
        }

        .loading-progress {
            width: 320px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            margin: 0 auto;
            overflow: hidden;
            position: relative;
        }

        .loading-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #fff, rgba(255, 255, 255, 0.8));
            animation: progress 2.5s ease-in-out infinite;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        @keyframes progress {
            0% { width: 0%; transform: translateX(0); }
            50% { width: 80%; }
            100% { width: 100%; transform: translateX(0); }
        }

        /* Main Container */
        .container {
            position: relative;
            z-index: 10;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 32px;
            padding: 60px 50px;
            width: 100%;
            max-width: 500px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, 
                rgba(255, 255, 255, 0.1), 
                transparent, 
                rgba(255, 255, 255, 0.1));
            border-radius: 32px;
            z-index: -1;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .card-title {
            font-size: 48px;
            font-weight: 900;
            color: #fff;
            text-align: center;
            margin-bottom: 16px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            letter-spacing: -1px;
        }

        .card-subtitle {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .info-banner {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-left: 4px solid #fff;
            padding: 18px 20px;
            margin-bottom: 32px;
            border-radius: 16px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.7;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 32px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 22px;
            opacity: 0.7;
            pointer-events: none;
        }

        input[type="password"] {
            width: 100%;
            padding: 18px 60px 18px 22px;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            border-bottom: 2px solid #fb923c;
            border-radius: 16px;
            font-size: 16px;
            color: #1f2937;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="password"]::placeholder {
            color: rgba(0, 0, 0, 0.4);
        }

        input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.6);
            border-color: #fb923c;
            box-shadow: 
                0 0 0 4px rgba(251, 146, 60, 0.2),
                0 8px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .btn-submit {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            box-shadow: 
                0 10px 30px rgba(249, 115, 22, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 15px 40px rgba(249, 115, 22, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            background: linear-gradient(135deg, #fb923c, #f97316);
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        .error-message {
            color: #fff;
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-left: 4px solid #ef4444;
            padding: 16px 18px;
            border-radius: 12px;
            font-size: 14px;
            margin-top: 12px;
            animation: shake 0.5s;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }

        @media (max-width: 580px) {
            .card {
                padding: 45px 30px;
            }

            .card-title {
                font-size: 36px;
            }

            input[type="password"] {
                padding: 16px 55px 16px 18px;
                font-size: 15px;
            }

            .btn-submit {
                font-size: 15px;
                padding: 16px;
            }
        }
    </style>

    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="loading-icon">🔒</div>
            </div>
            <p class="loading-text">Confirming</p>
            <p class="loading-subtext">Verifying your password securely</p>
            <div class="loading-progress">
                <div class="loading-progress-bar"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h1 class="card-title">🔐 Confirm</h1>
            <p class="card-subtitle">Please verify your identity to continue</p>

            <div class="info-banner">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" id="confirmForm">
                @csrf

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        />
                        <span class="input-icon">🔑</span>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    {{ __('Confirm') }}
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('confirmForm').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('loadingOverlay').classList.remove('active');
            });
        @endif
    </script>
</x-guest-layout>