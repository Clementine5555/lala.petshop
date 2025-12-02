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

        input {
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
            transition: all 0.15s ease;
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
