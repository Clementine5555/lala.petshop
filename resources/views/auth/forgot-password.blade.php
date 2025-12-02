<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    
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

        label {
            font-size: 0.875rem;
            font-weight: 500;
        }

        input {
            outline: none;
            padding: 0.75rem;
            font-size: 1rem;
        }

        input:focus {
            outline: none;
        }

        .rounded-xl {
            border-radius: 0.75rem;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .success-message {
            color: #10b981;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        button[type="submit"] {
            cursor: pointer;
            transition: all 0.15s ease;
        }

        button[type="submit"]:hover {
            opacity: 0.9;
        }

        /* Custom background */
        .bg-pattern {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-pattern">
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
        <div style="width: 100%; max-width: 28rem;">
            
            <!-- Card Container -->
            <div style="background-color: #1e293b; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
                
                <!-- Info Text -->
                <div class="error-message" style="margin-bottom: 1.5rem;">
                    Lupa kata sandi Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi melalui email Anda.
                </div>

                <!-- Session Status (Laravel akan inject ini jika ada) -->
                @if (session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form Laravel dengan @csrf dan action -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <!-- Email Field -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="email" style="display: block; color: #e2e8f0; margin-bottom: 0.5rem;">
                            Email
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            style="width: 100%; background-color: #1e293b; border: 2px solid #3b82f6; border-radius: 0.375rem; color: #e2e8f0; padding: 0.75rem;"
                            required
                            autofocus
                        />
                        @error('email')
                            <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            style="width: 100%; background-color: #94a3b8; color: #1e293b; border-radius: 0.375rem; padding: 0.75rem; font-weight: 600; border: none; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.875rem;"
                        >
                            EMAIL PASSWORD RESET LINK
                        </button>
                    </div>
                </form>

                <!-- Back to Login Link -->
                <div style="margin-top: 1.5rem; text-align: center;">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" style="color: #94a3b8; font-size: 0.875rem; text-decoration: none; transition: color 0.15s ease;">
                            Back to Login
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</body>
</html>
