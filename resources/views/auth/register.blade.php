<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    
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
            background: linear-gradient(135deg, #fbbf24 0%, #fb923c 50%, #fdba74 100%);
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
                radial-gradient(circle at 80% 20%, rgba(251, 191, 36, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(251, 146, 60, 0.3) 0%, transparent 50%);
            animation: bgMove 15s ease-in-out infinite;
        }

        @keyframes bgMove {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-20px, 20px); }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.98) 0%, rgba(251, 146, 60, 0.98) 100%);
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
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
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

        .image-card {
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            animation: fadeInRight 0.8s ease-out;
            position: relative;
        }

        .image-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 3px solid rgba(251, 146, 60, 0.5);
            border-radius: 32px;
            pointer-events: none;
            animation: borderGlow 2s ease-in-out infinite;
        }

        @keyframes borderGlow {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        input:focus {
            outline: none;
            border-color: #fb923c !important;
            box-shadow: 0 0 0 4px rgba(251, 146, 60, 0.2);
        }

        button[type="submit"] {
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(249, 115, 22, 0.3);
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(249, 115, 22, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        a {
            transition: all 0.3s ease;
        }

        a:hover {
            text-shadow: 0 0 10px rgba(154, 52, 18, 0.5);
        }

        @media (max-width: 1024px) {
            .image-container {
                display: none;
            }
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
                <div class="loading-icon">✨</div>
            </div>
            <p class="loading-text">Creating Account</p>
            <p class="loading-subtext">Please wait, setting up your account</p>
            <div class="loading-progress">
                <div class="loading-progress-bar"></div>
            </div>
        </div>
    </div>

    <div class="gradient-bg" style="display: flex; align-items: center; justify-content: center; padding: 2rem;">
        <div style="width: 100%; max-width: 72rem; display: flex; gap: 3rem; align-items: center; position: relative; z-index: 10;">
            
            <div style="flex: 1; max-width: 28rem;">
                <div class="card" style="padding: 3rem; border-radius: 32px;">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <div style="font-size: 56px; margin-bottom: 1rem;">🎉</div>
                        <h1 style="font-size: 2.5rem; font-weight: 900; color: #ea580c;">Sign Up</h1>
                        <p style="color: rgba(234, 88, 12, 0.7); font-size: 0.875rem; margin-top: 0.5rem;">Create your account to get started</p>
                    </div>
                    
                    <form method="POST" action="{{ route('register') }}" id="registerForm" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        @csrf
                        
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label for="name" style="color: #c2410c; font-weight: 600; font-size: 0.875rem; letter-spacing: 0.5px;">
                                Username
                            </label>
                            <div style="position: relative;">
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    style="width: 100%; background: rgba(255, 255, 255, 0.5); border: none; border-bottom: 2px solid #fb923c; padding: 0.75rem 3rem 0.75rem 0; color: #292524; font-size: 1rem; transition: all 0.3s ease;"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    placeholder="Your username"
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); color: #ea580c;">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </div>
                            @error('name')
                                <p style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label for="email" style="color: #c2410c; font-weight: 600; font-size: 0.875rem; letter-spacing: 0.5px;">
                                Email Address
                            </label>
                            <div style="position: relative;">
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    style="width: 100%; background: rgba(255, 255, 255, 0.5); border: none; border-bottom: 2px solid #fb923c; padding: 0.75rem 3rem 0.75rem 0; color: #292524; font-size: 1rem; transition: all 0.3s ease;"
                                    required
                                    autocomplete="username"
                                    placeholder="you@example.com"
                                />
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); color: #ea580c;">
                                    <rect width="20" height="16" x="2" y="4" rx="2" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                </svg>
                            </div>
                            @error('email')
                                <p style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label for="password" style="color: #c2410c; font-weight: 600; font-size: 0.875rem; letter-spacing: 0.5px;">
                                Password
                            </label>
                            <div style="position: relative;">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    style="width: 100%; background: rgba(255, 255, 255, 0.5); border: none; border-bottom: 2px solid #fb923c; padding: 0.75rem 3rem 0.75rem 0; color: #292524; font-size: 1rem; transition: all 0.3s ease;"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Create a password"
                                />
                                <button
                                    type="button"
                                    onclick="togglePassword('password', 'toggleIconPass')"
                                    style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 20px; padding: 0; transition: transform 0.2s ease;"
                                    onmouseover="this.style.transform='translateY(-50%) scale(1.2)'"
                                    onmouseout="this.style.transform='translateY(-50%) scale(1)'"
                                >
                                    <span id="toggleIconPass">👁️</span>
                                </button>
                            </div>
                            @error('password')
                                <p style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label for="password_confirmation" style="color: #c2410c; font-weight: 600; font-size: 0.875rem; letter-spacing: 0.5px;">
                                Confirm Password
                            </label>
                            <div style="position: relative;">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    style="width: 100%; background: rgba(255, 255, 255, 0.5); border: none; border-bottom: 2px solid #fb923c; padding: 0.75rem 3rem 0.75rem 0; color: #292524; font-size: 1rem; transition: all 0.3s ease;"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Confirm your password"
                                />
                                <button
                                    type="button"
                                    onclick="togglePassword('password_confirmation', 'toggleIconConfirm')"
                                    style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 20px; padding: 0; transition: transform 0.2s ease;"
                                    onmouseover="this.style.transform='translateY(-50%) scale(1.2)'"
                                    onmouseout="this.style.transform='translateY(-50%) scale(1)'"
                                >
                                    <span id="toggleIconConfirm">👁️</span>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="padding-top: 0.5rem;">
                            <button
                                type="submit"
                                style="width: 100%; background: linear-gradient(135deg, #f97316, #ea580c); color: white; border-radius: 16px; padding: 1rem; font-weight: 700; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: none; text-transform: uppercase; letter-spacing: 1px; font-size: 0.875rem; cursor: pointer;"
                            >
                                Sign Up
                            </button>
                        </div>

                        <div style="text-align: center; padding-top: 0.5rem; border-top: 1px solid rgba(234, 88, 12, 0.2);">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" style="color: #9a3412; font-weight: 600; text-decoration: none; font-size: 0.875rem;">
                                    Already Have an Account?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="image-container" style="flex: 1;">
                <div class="image-card">
                    <img 
                        src="images/anjkucing.jpg"
                        alt="Decorative cat image"
                        style="width: 100%; height: 600px; object-fit: cover;"
                    />
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }

        document.getElementById('registerForm').addEventListener('submit', function() {
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