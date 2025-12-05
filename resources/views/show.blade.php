<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - Petshop Lala</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        /* Header Navigation */
        .top-nav {
            background: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }

        .logo span {
            font-weight: 700;
            color: #FF8C42;
            font-size: 1.4em;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #FF8C42;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
        }

        .cart-icon svg {
            width: 28px;
            height: 28px;
            color: #333;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #FF8C42;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7em;
            font-weight: 700;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #f0f0f0;
            border-radius: 25px;
            text-decoration: none;
            color: #666;
            font-weight: 600;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #e0e0e0;
            color: #333;
        }

        /* Product Detail Section */
        .product-detail-container {
            max-width: 1400px;
            margin: 50px auto;
            padding: 0 50px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            color: #999;
            font-size: 0.95em;
        }

        .breadcrumb a {
            color: #FF8C42;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .product-main {
            background: white;
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 40px;
        }

        .product-image-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .main-image {
            width: 100%;
            height: 500px;
            background: #f9f9f9;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .main-image img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .thumbnail-images {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .thumbnail {
            height: 100px;
            background: #f9f9f9;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: #FF8C42;
        }

        .thumbnail img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }

        .product-info-section h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 15px;
            font-weight: 800;
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }

        .rating-display {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stars {
            display: flex;
            gap: 3px;
        }

        .star {
            color: #FFD700;
            font-size: 1.3em;
        }

        .star.empty {
            color: #ddd;
        }

        .rating-text {
            color: #666;
            font-weight: 600;
        }

        .review-count {
            color: #999;
        }

        .product-price {
            font-size: 3em;
            color: #FF8C42;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .stock-info {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 25px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .stock-info.out-of-stock {
            background: #ffebee;
            color: #c62828;
        }

        .product-description {
            color: #666;
            line-height: 1.8;
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        .product-description h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.4em;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .quantity-selector label {
            font-weight: 600;
            color: #333;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            background: #f0f0f0;
            border-radius: 30px;
            overflow: hidden;
        }

        .quantity-btn {
            width: 45px;
            height: 45px;
            border: none;
            background: transparent;
            font-size: 1.5em;
            cursor: pointer;
            transition: all 0.3s;
            color: #666;
        }

        .quantity-btn:hover {
            background: #e0e0e0;
            color: #333;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            border: none;
            background: transparent;
            font-size: 1.2em;
            font-weight: 600;
            color: #333;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            flex: 1;
            padding: 18px 35px;
            border: none;
            border-radius: 30px;
            font-size: 1.2em;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            box-shadow: 0 5px 20px rgba(255, 140, 66, 0.4);
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255, 140, 66, 0.6);
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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

        /* Toast */
        .toast {
            position: fixed;
            top: 100px;
            right: 30px;
            background: white;
            padding: 20px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            display: none;
            align-items: center;
            gap: 15px;
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
        }

        .toast.show {
            display: flex;
        }

        .toast.success {
            border-left: 5px solid #4caf50;
        }

        .toast.error {
            border-left: 5px solid #f44336;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 992px) {
            .product-main {
                grid-template-columns: 1fr;
            }

            .nav-container {
                padding: 0 20px;
            }

            .product-detail-container {
                padding: 0 20px;
            }

            .product-main {
                padding: 30px 20px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .product-info-section h1 {
                font-size: 2em;
            }

            .product-price {
                font-size: 2.2em;
            }

            .main-image {
                height: 350px;
            }

            .toast {
                right: 15px;
                left: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <svg class="toast-icon" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span class="toast-message" id="toastMessage"></span>
        <svg class="toast-close" width="20" height="20" onclick="hideToast()" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </div>

    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-container">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23FF8C42'/%3E%3Cpath d='M50 30c-8 0-15 5-15 12 0 4 2 7 5 9-2 1-3 3-3 5 0 3 3 6 8 6h10c5 0 8-3 8-6 0-2-1-4-3-5 3-2 5-5 5-9 0-7-7-12-15-12z' fill='white'/%3E%3C/svg%3E" alt="Petshop Lala">
                <span>Petshop Lala</span>
            </a>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}">Home</a>
                <a href="{{ route('dashboard') }}#products">Products</a>
                <a href="{{ route('dashboard') }}#appointment">Appointment</a>
                <a href="{{ route('dashboard') }}#contact">Contact</a>
                <div class="cart-icon" onclick="window.location.href='{{ route('cart.index') }}'">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    @if(session('cart') && count(session('cart')) > 0)
                    <span class="cart-badge">{{ count(session('cart')) }}</span>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="product-detail-container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Home</a>
            <span>/</span>
            <a href="{{ route('dashboard') }}#products">Products</a>
            <span>/</span>
            <span>{{ $product->name }}</span>
        </div>

        <a href="{{ route('dashboard') }}#products" class="back-btn">
            ← Back to Products
        </a>

        <!-- Product Main Info -->
        <div class="product-main">
            <!-- Product Images -->
            <div class="product-image-section">
                <div class="main-image" id="mainImage">
                    <img src="{{ $product->image_url ?? 'https://via.placeholder.com/500x500?text=' . urlencode($product->name) }}" 
                         alt="{{ $product->name }}"
                         id="mainImageTag">
                </div>
                
                <div class="thumbnail-images">
                    @for($i = 1; $i <= 4; $i++)
                    <div class="thumbnail {{ $i == 1 ? 'active' : '' }}" onclick="changeImage(this, '{{ $product->image_url ?? 'https://via.placeholder.com/500x500?text=' . urlencode($product->name) }}')">
                        <img src="{{ $product->image_url ?? 'https://via.placeholder.com/100x100?text=View' . $i }}" alt="View {{ $i }}">
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info-section">
                <h1>{{ $product->name }}</h1>

                <div class="product-meta">
                    <div class="rating-display">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= round($product->average_rating ?? 5) ? '' : 'empty' }}">★</span>
                            @endfor
                        </div>
                        <span class="rating-text">{{ number_format($product->average_rating ?? 5, 1) }}</span>
                        <span class="review-count">({{ $product->reviews_count ?? 0 }} reviews)</span>
                    </div>
                </div>

                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                <div class="stock-info {{ ($product->stock ?? 15) > 0 ? '' : 'out-of-stock' }}">
                    @if(($product->stock ?? 15) > 0)
                        ✓ In Stock ({{ $product->stock ?? 15 }} tersedia)
                    @else
                        ✗ Out of Stock
                    @endif
                </div>

                <div class="product-description">
                    <h3>Description</h3>
                    <p>{{ $product->description ?? 'Makanan premium berkualitas tinggi untuk hewan kesayangan Anda. Dibuat dari bahan-bahan pilihan dengan nutrisi lengkap dan seimbang untuk mendukung kesehatan dan pertumbuhan optimal. Cocok untuk konsumsi harian dengan rasa yang disukai hewan peliharaan.' }}</p>
                </div>

                <div class="quantity-selector">
                    <label>Quantity:</label>
                    <div class="quantity-controls">
                        <button type="button" class="quantity-btn" onclick="decreaseQuantity()">−</button>
                        <input type="number" id="quantityInput" class="quantity-input" value="1" min="1" max="{{ $product->stock ?? 15 }}" readonly>
                        <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="button" class="btn btn-primary" onclick="addToCart()" {{ ($product->stock ?? 15) <= 0 ? 'disabled' : '' }}>
                        🛒 Add to Cart
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="buyNow()" {{ ($product->stock ?? 15) <= 0 ? 'disabled' : '' }}>
                        ⚡ Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const productId = {{ $product->product_id ?? $product->getKey() }};
        const maxStock = {{ $product->stock ?? 15 }};

        // Toast functions
        function showToast(message, type = 'success') {
            if (!message) return; // don't show empty toasts
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            
            toast.className = `toast ${type}`;
            toastMessage.textContent = message;
            toast.classList.add('show');
            
            setTimeout(() => hideToast(), 4000);
        }

        function hideToast() {
            document.getElementById('toast').classList.remove('show');
        }

        // Image gallery
        function changeImage(thumbnail, imageUrl) {
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            thumbnail.classList.add('active');
            document.getElementById('mainImageTag').src = imageUrl;
        }

        // Quantity controls
        function increaseQuantity() {
            const input = document.getElementById('quantityInput');
            const current = parseInt(input.value);
            if (current < maxStock) {
                input.value = current + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantityInput');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }

        // Add to cart
        function addToCart() {
            const quantity = parseInt(document.getElementById('quantityInput').value);
            
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Product added to cart successfully!', 'success');
                    // Update cart badge
                    updateCartBadge(data.cart_count);
                } else {
                    showToast(data.message || 'Failed to add to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to add to cart. Please try again.', 'error');
            });
        }

        // Buy now
        function buyNow() {
            const quantity = parseInt(document.getElementById('quantityInput').value);
            
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("checkout.index") }}';
                } else {
                    showToast(data.message || 'Failed to process', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to process. Please try again.', 'error');
            });
        }

        // Update cart badge
        function updateCartBadge(count) {
            const badge = document.querySelector('.cart-badge');
            if (count > 0) {
                if (badge) {
                    badge.textContent = count;
                } else {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'cart-badge';
                    newBadge.textContent = count;
                    document.querySelector('.cart-icon').appendChild(newBadge);
                }
            }
        }
    </script>
</body>
</html>