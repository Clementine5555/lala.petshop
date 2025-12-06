<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #fbbf24 0%, #fb923c 50%, #f97316 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(251, 191, 36, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(249, 115, 22, 0.3) 0%, transparent 50%);
            animation: bgPulse 10s ease-in-out infinite;
        }

        @keyframes bgPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

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
        }

        .loading-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #fff, rgba(255, 255, 255, 0.8));
            animation: progress 2.5s ease-in-out infinite;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        @keyframes progress {
            0% { width: 0%; }
            50% { width: 80%; }
            100% { width: 100%; }
        }

        .card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 32px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
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

        input:focus {
            outline: none;
            border-color: rgba(251, 146, 60, 0.8) !important;
            box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.2);
        }

        button[type="submit"] {
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(249, 115, 22, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        a {
            transition: all 0.3s ease;
        }

        a:hover {
            text-shadow: 0 0 10px rgba(194, 65, 12, 0.5);
        }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="loading-icon">📧</div>
            </div>
            <p class="loading-text">Sending Reset Link</p>
            <p class="loading-subtext">Please wait while we send the email</p>
            <div class="loading-progress">
                <div class="loading-progress-bar"></div>
            </div>
        </div>
    </div>

    <div class="gradient-bg" style="display: flex; align-items: center; justify-content: center; padding: 2rem;">
        <div style="width: 100%; max-width: 28rem; position: relative; z-index: 10;">
            
            <div class="card" style="padding: 2.5rem;">
                
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div style="font-size: 56px; margin-bottom: 1rem;">🔐</div>
                    <h1 style="font-size: 2rem; font-weight: 800; color: white; margin-bottom: 0.5rem;">Forgot Password?</h1>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem;">No worries, we'll send you reset instructions</p>
                </div>

                <div style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); border-left: 4px solid #fff; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; color: rgba(255, 255, 255, 0.95); font-size: 0.875rem; line-height: 1.6;">
                    Lupa kata sandi Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi melalui email Anda.
                </div>

                @if (session('status'))
                    <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.3); border-left: 4px solid #10b981; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; color: white; font-size: 0.875rem;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                    @csrf
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label for="email" style="display: block; color: rgba(255, 255, 255, 0.95); margin-bottom: 0.75rem; font-weight: 600; font-size: 0.875rem; letter-spacing: 0.5px;">
                            Email Address
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            style="width: 100%; background: rgba(255, 255, 255, 0.5); border: none; border-bottom: 2px solid #fb923c; padding: 0.875rem; color: #1f2937; transition: all 0.3s ease;"
                            required
                            autofocus
                            placeholder="Enter your email"
                        />
                        @error('email')
                            <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <button
                            type="submit"
                            style="width: 100%; background: linear-gradient(135deg, #f97316, #ea580c); color: white; border-radius: 12px; padding: 1rem; font-weight: 700; border: none; text-transform: uppercase; letter-spacing: 1px; font-size: 0.875rem; box-shadow: 0 10px 30px rgba(249, 115, 22, 0.3); cursor: pointer;"
                        >
                            Send Reset Link
                        </button>
                    </div>
                </form>

                <div style="text-align: center; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.3);">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" style="color: rgba(255, 255, 255, 0.9); font-size: 0.875rem; text-decoration: none; font-weight: 500;">
                            ← Back to Login
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('forgotForm').addEventListener('submit', function() {
            document.getElementById('loadingOverlay').classList.add('active');
        });

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('loadingOverlay').classList.remove('active');
            });
        @endif
    </script>
</body>
</html>