<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - Pet Shop</title>
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
            font-size: 1.8em;
            font-weight: 800;
            color: #FF8C42;
            text-decoration: none;
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

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255, 140, 66, 0.6);
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

        /* Reviews Section */
        .reviews-container {
            background: white;
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        }

        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }

        .reviews-header h2 {
            font-size: 2em;
            color: #333;
        }

        .btn-add-review {
            padding: 12px 30px;
            background: #FF8C42;
            color: white;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add-review:hover {
            background: #FF6B35;
            transform: translateY(-2px);
        }

        .review-form {
            display: none;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 35px;
        }

        .review-form.active {
            display: block;
        }

        .review-form h3 {
            color: #333;
            margin-bottom: 25px;
            font-size: 1.5em;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.05em;
        }

        .rating-input {
            display: flex;
            gap: 10px;
            font-size: 2.5em;
        }

        .rating-input span {
            cursor: pointer;
            color: #ddd;
            transition: all 0.2s;
        }

        .rating-input span:hover,
        .rating-input span.active {
            color: #FFD700;
            transform: scale(1.1);
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 1.05em;
            font-family: inherit;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #FF8C42;
            box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 150px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
        }

        .reviews-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .review-item {
            padding: 25px;
            background: #f9f9f9;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .review-item:hover {
            background: #f0f0f0;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .reviewer-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF8C42, #FF6B35);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.4em;
        }

        .reviewer-details h4 {
            font-size: 1.15em;
            color: #333;
            margin-bottom: 5px;
        }

        .review-date {
            color: #999;
            font-size: 0.9em;
        }

        .review-content {
            color: #666;
            line-height: 1.7;
            font-size: 1.05em;
            margin-top: 15px;
        }

        .no-reviews {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .no-reviews h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
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

            .product-main,
            .reviews-container {
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
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">🐾 PetShop</a>
            <div class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('products.index') }}">Products</a>
                <a href="#appointment">Appointment</a>
                <a href="#contact">Contact</a>
                <a href="#cart">🛒 Cart</a>
            </div>
        </div>
    </nav>

    <div class="product-detail-container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('products.index') }}">Products</a>
            <span>/</span>
            <span>{{ $product->name }}</span>
        </div>

        <a href="{{ route('products.index') }}" class="back-btn">
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

                <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id ?? $product->getKey() }}">
                    
                    <div class="quantity-selector">
                        <label>Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn" onclick="decreaseQuantity()">−</button>
                            <input type="number" name="quantity" id="quantityInput" class="quantity-input" value="1" min="1" max="{{ $product->stock ?? 15 }}" readonly>
                            <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary" {{ ($product->stock ?? 15) <= 0 ? 'disabled' : '' }}>
                            🛒 Add to Cart
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="buyNow()">
                            ⚡ Buy Now
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-container">
            <div class="reviews-header">
                <h2>Customer Reviews ({{ $reviews->count() }})</h2>
                <button class="btn-add-review" onclick="toggleReviewForm()">
                    ✍️ Write a Review
                </button>
            </div>

            <!-- Review Form -->
            <div class="review-form" id="reviewForm">
                <h3>Share Your Experience</h3>
                <form onsubmit="submitReview(event)">
                    <div class="form-group">
                        <label>Your Rating</label>
                        <div class="rating-input" id="ratingInput">
                            <span onclick="setRating(1)">★</span>
                            <span onclick="setRating(2)">★</span>
                            <span onclick="setRating(3)">★</span>
                            <span onclick="setRating(4)">★</span>
                            <span onclick="setRating(5)">★</span>
                        </div>
                        <input type="hidden" id="ratingValue" name="rating" value="5">
                    </div>

                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>

                    <div class="form-group">
                        <label>Your Review</label>
                        <textarea name="comment" class="form-control" placeholder="Tell us about your experience with this product..." required></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleReviewForm()">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Reviews List -->
            <div class="reviews-list">
                @forelse($reviews as $review)
                <div class="review-item">
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="reviewer-avatar">{{ strtoupper(substr($review->user_name, 0, 1)) }}</div>
                            <div class="reviewer-details">
                                <h4>{{ $review->user_name }}</h4>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <span class="review-date">{{ $review->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="review-content">
                        {{ $review->comment }}
                    </div>
                </div>
                @empty
                <div class="no-reviews">
                    <h3>No reviews yet</h3>
                    <p>Be the first to review this product!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

  <script>
    // Variables
    const productId = {{ $product->product_id ?? $product->getKey() }};
    const maxStock = {{ $product->stock ?? 15 }};

    console.log('Product ID:', productId);
    console.log('Max Stock:', maxStock);

    // Toast functions
    function showToast(message, type) {
        type = type || 'success';
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');
        
        if (!toast || !toastMessage) {
            console.error('Toast elements not found');
            alert(message);
            return;
        }
        
        toast.className = 'toast ' + type + ' show';
        toastMessage.textContent = message;
        
        setTimeout(function() {
            hideToast();
        }, 4000);
    }

    function hideToast() {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.classList.remove('show');
        }
    }

    // Image gallery
    function changeImage(thumbnail, imageUrl) {
        document.querySelectorAll('.thumbnail').forEach(function(t) {
            t.classList.remove('active');
        });
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
        console.log('Add to cart clicked!');
        
        const quantity = parseInt(document.getElementById('quantityInput').value);
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        
        console.log('Quantity:', quantity);
        console.log('CSRF Token:', csrfToken ? csrfToken.content : 'NOT FOUND');
        
        if (!csrfToken) {
            alert('CSRF token not found!');
            return;
        }
        
        const url = '/cart/add';
        const data = {
            product_id: productId,
            quantity: quantity
        };
        
        console.log('Sending request to:', url);
        console.log('Data:', data);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(function(response) {
            console.log('Response status:', response.status);
            console.log('Response OK:', response.ok);
            return response.json();
        })
        .then(function(data) {
            console.log('Response data:', data);
            
            if (data.success) {
                showToast('Product added to cart successfully!', 'success');
                updateCartBadge(data.cart_count);
            } else {
                showToast(data.message || 'Failed to add to cart', 'error');
            }
        })
        .catch(function(error) {
            console.error('Fetch error:', error);
            showToast('Failed to add to cart. Error: ' + error.message, 'error');
        });
    }

    // Buy now
    function buyNow() {
        console.log('Buy now clicked!');
        
        const quantity = parseInt(document.getElementById('quantityInput').value);
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        
        if (!csrfToken) {
            alert('CSRF token not found!');
            return;
        }
        
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                window.location.href = '/checkout';
            } else {
                showToast(data.message || 'Failed to process', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            showToast('Failed to process. Error: ' + error.message, 'error');
        });
    }

    // Update cart badge
    function updateCartBadge(count) {
        console.log('Updating cart badge to:', count);
        
        const cartIcon = document.querySelector('.cart-icon');
        if (!cartIcon) {
            console.error('Cart icon not found');
            return;
        }
        
        let badge = cartIcon.querySelector('.cart-badge');
        
        if (count > 0) {
            if (badge) {
                badge.textContent = count;
            } else {
                badge = document.createElement('span');
                badge.className = 'cart-badge';
                badge.textContent = count;
                cartIcon.appendChild(badge);
            }
        } else {
            if (badge) {
                badge.remove();
            }
        }
    }

    // Test pada load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded!');
        console.log('Product ID:', productId);
        console.log('Add to Cart button:', document.querySelector('.btn-primary'));
        console.log('Buy Now button:', document.querySelector('.btn-secondary'));
    });
</script>
</body>
</html>