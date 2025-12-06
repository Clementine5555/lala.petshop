<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Grooming Services - Petshop Lala</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            padding-top: 50px;
            background: #f5f5f5;
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
            font-size: 1em;
            transition: color 0.3s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #FF8C42;
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
            color: #333;
        }

        .cart-icon:hover svg {
            color: #FF8C42;
        }

        /* Services Page */
        .services-page {
            padding: 40px 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-header h1 {
            font-size: 2.8em;
            color: #333;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .page-header p {
            font-size: 1.2em;
            color: #666;
        }

        .search-section {
            max-width: 600px;
            margin: 0 auto 50px;
            position: relative;
        }

        .search-box {
            width: 100%;
            padding: 18px 25px 18px 55px;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 1.1em;
            transition: all 0.3s;
            background: white;
        }

        .search-box:focus {
            outline: none;
            border-color: #FF8C42;
            box-shadow: 0 5px 20px rgba(255, 140, 66, 0.2);
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3em;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .service-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            cursor: pointer;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .service-info h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .service-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
            font-size: 0.95em;
        }

        .service-duration {
            color: #999;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .service-price {
            font-size: 1.8em;
            color: #FF8C42;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .service-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 66, 0.5);
        }

        .btn-secondary {
            background: white;
            color: #FF8C42;
            border: 2px solid #FF8C42;
        }

        .btn-secondary:hover {
            background: #FF8C42;
            color: white;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 50px;
        }

        .pagination a, .pagination span {
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .pagination a:hover {
            background: #FF8C42;
            color: white;
            border-color: #FF8C42;
        }

        .pagination .active span {
            background: #FF8C42;
            color: white;
            border-color: #FF8C42;
        }

        @media (max-width: 768px) {
            .services-grid {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="/images/logoo.png" alt="Petshop Lala">
                <span>Petshop Lala</span>
            </a>
            
            <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}">Home</a></li>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li><a href="{{ route('products.shop') }}" class="active">Services</a></li>
            </ul>

            <div class="nav-right">
                <div class="cart-icon" onclick="window.location.href='{{ route('cart.index') }}'">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>

                @auth
                <div style="color: #333; font-weight: 600;">
                    {{ Auth::user()->name }}
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #FF8C42; cursor: pointer; font-weight: 600;">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" style="text-decoration: none; color: #FF8C42; font-weight: 600;">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Services Page Content -->
    <div class="services-page">
        <div class="page-header">
            <h1>🛁 Grooming Services</h1>
            <p>Manjakan hewan peliharaan Anda dengan layanan grooming premium kami!</p>
        </div>

        <div class="search-section">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-box" id="searchInput" placeholder="Search services...">
        </div>

        <div class="services-grid" id="servicesGrid">
            @forelse ($services as $service)
                <div class="service-card" onclick="window.location.href='{{ route('appointment.create') }}'">
                    <div class="service-icon">🛁</div>
                    <div class="service-info">
                        <h3>{{ $service->service_name }}</h3>
                        <p class="service-description">{{ $service->description }}</p>
                        <p class="service-duration">⏱️ {{ $service->duration_minutes }} minutes</p>
                        <div class="service-price">Rp {{ number_format($service->price, 0, ',', '.') }}</div>

                        <div class="service-actions">
                            <button class="btn btn-secondary" onclick="event.stopPropagation(); window.location.href='{{ route('services.show', $service->service_id) }}'">
                                Details
                            </button>

                            <button class="btn btn-primary" onclick="event.stopPropagation(); bookService({{ $service->service_id }}, '{{ $service->service_name }}')">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <p style="font-size: 1.2em; color: #999;">No services available</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($services->hasPages())
            <div class="pagination">
                {{ $services->links() }}
            </div>
        @endif
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.service-card');
            
            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('.service-description').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        function bookService(serviceId, serviceName) {
            // Redirect to appointment creation with service pre-selected
            window.location.href = '{{ route('appointment.create') }}?service_id=' + serviceId;
        }
    </script>

</body>
</html>
