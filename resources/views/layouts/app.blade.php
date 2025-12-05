<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer style="background-color: #bf8c3c; color: white; padding: 60px 0 20px; margin-top: 50px; font-family: 'Segoe UI', sans-serif;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: 1.2fr 1fr; gap: 40px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                        <div style="width: 50px; height: 50px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('images/logoo.png') }}" alt="Petshop Lala" style="width: 35px; height: 35px; object-fit: contain;">
                        </div>
                        <span style="font-size: 1.5em; font-weight: 800; letter-spacing: 0.5px;">Petshop Lala</span>
                    </div>

                    <p style="line-height: 1.6; margin-bottom: 40px; font-size: 1em; font-weight: 500; max-width: 90%;">
                        Your trusted partner in pet care.<br>
                        Menyediakan layanan grooming profesional<br>
                        dan produk pet berkualitas sejak 2020.
                    </p>

                    <div>
                        <span style="font-weight: 800; font-size: 1.1em; margin-bottom: 15px; display: block; letter-spacing: 0.5px;">Contact</span>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600; display: flex; align-items: flex-start; gap: 12px;">
                                <span>📍</span> Jl. Pet Lover No. 123, Medan
                            </li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600; display: flex; align-items: flex-start; gap: 12px;">
                                <span>📞</span> +62 812-3456-7890
                            </li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600; display: flex; align-items: flex-start; gap: 12px;">
                                <span>📧</span> info@petshoplala.com
                            </li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600; display: flex; align-items: flex-start; gap: 12px;">
                                <span>⏰</span> Mon-Sun: 08:00 - 20:00
                            </li>
                        </ul>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <div>
                        <span style="font-weight: 800; font-size: 1.1em; margin-bottom: 15px; display: block; letter-spacing: 0.5px;">Services</span>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600;">Pet Grooming</li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600;">Pet Hotel</li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600;">Health Check</li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600;">Appointment</li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600;">Booking</li>
                        </ul>
                    </div>

                    <div>
                        <span style="font-weight: 800; font-size: 1.1em; margin-bottom: 15px; display: block; letter-spacing: 0.5px;">Customer Service</span>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600;">FAQs</li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600;">Refund Policy</li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600;">Payment Methods</li>
                            <li style="margin-bottom: 10px; font-size: 0.95em; font-weight: 600;">Terms & Conditions</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 50px; margin-bottom: 30px;">
                <span style="font-weight: 800; font-size: 1.1em; margin-bottom: 15px; display: block; letter-spacing: 0.5px;">Follow Us</span>
                <div style="font-weight: 600;">
                    Instagram @petshoplala<br>
                    Facebook<br>
                    TikTok<br>
                    WhatsApp Business
                </div>
            </div>

            <hr style="border: 0; border-top: 3px solid white; margin: 0 40px 25px 40px; opacity: 1;">

            <div style="text-align: center; font-size: 0.95em; font-weight: 700;">
                © 2025 Petshop Lala. All rights reserved. | Trusted by 10,000+ happy pet owners
            </div>
        </footer>
    </body>
</html>
