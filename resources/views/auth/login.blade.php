<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Custom Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1.2;
        }

        label {
            font-size: 0.875rem;
            font-weight: 500;
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
            padding: 0.5rem 0;
            font-size: 1rem;
        }

        input:focus {
            outline: none;
        }

        .rounded-60px {
            border-radius: 60px;
        }

        .rounded-40px {
            border-radius: 40px;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        button[type="submit"] {
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

        button[type="submit"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        a {
            text-decoration: none;
            transition: color 0.15s ease;
        }

        /* Custom backdrop blur for older browsers */
        .backdrop-blur-sm {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .image-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(to bottom right, #fdba74, #fed7aa, #fef3c7); padding: 2rem;">
        <div style="width: 100%; max-width: 72rem; display: flex; gap: 3rem; align-items: center;">
            
            <!-- Left side - Image -->
            <div class="image-container" style="flex: 1;">
                <div style="position: relative;">
                    <div class="rounded-60px" style="overflow: hidden; border: 4px solid #06b6d4; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                        <img 
                            src="images/pet.jpg"
                            alt="Decorative cat image"
                            style="width: 100%; height: 600px; object-fit: cover;"
                        />
                    </div>
                </div>
            </div>

            <!-- Right side - Login Form -->
            <div style="flex: 1; max-width: 28rem;">
                <div class="backdrop-blur-sm rounded-40px" style="background-color: rgba(255, 255, 255, 0.4); padding: 3rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                    <h1 style="text-align: center; color: #f97316; margin-bottom: 3rem;">Log In</h1>
                    
                    <!-- Form Laravel dengan @csrf dan action -->
                    <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 2rem;">
                        @csrf
                        
                        <!-- Email Field -->
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label for="email" style="color: #f97316;">
                                Email
                            </label>
                            <div style="position: relative;">
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    style="width: 100%; background: transparent; border: none; border-bottom: 2px solid #fb923c; padding-right: 2.5rem; color: #1f2937;"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />
                                <!-- Mail Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); color: #374151;">
                                    <rect width="20" height="16" x="2" y="4" rx="2" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                </svg>
                            </div>
                            @error('email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label for="password" style="color: #f97316;">
                                Password
                            </label>
                            <div style="position: relative;">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    style="width: 100%; background: transparent; border: none; border-bottom: 2px solid #fb923c; padding-right: 2.5rem; color: #1f2937;"
                                    required
                                    autocomplete="current-password"
                                />
                                <!-- Lock Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); color: #374151;">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>
                            @error('password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Login Button -->
                        <div style="padding-top: 1rem;">
                            <button
                                type="submit"
                                style="width: 100%; background-color: #f97316; color: white; border-radius: 9999px; padding: 0.75rem; font-weight: 600; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: none;"
                            >
                                Log in
                            </button>
                        </div>

                        <!-- Links -->
                        <div style="display: flex; justify-content: center; gap: 2rem; padding-top: 1rem;">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" style="color: #c2410c; font-weight: 500;">
                                    Create Account?
                                </a>
                            @endif

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" style="color: #c2410c; font-weight: 500;">
                                    Forget Password?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
