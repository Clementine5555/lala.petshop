<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} - Pet Shop</title>
    <style>
        /* CSS SAMA SEPERTI SEBELUMNYA */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; color: #333; }
        .top-nav { background: white; padding: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 100; }
        .nav-container { max-width: 1400px; margin: 0 auto; padding: 0 50px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.8em; font-weight: 800; color: #FF8C42; text-decoration: none; }
        .nav-links { display: flex; gap: 30px; align-items: center; }
        .nav-links a { text-decoration: none; color: #333; font-weight: 600; transition: color 0.3s; }
        .nav-links a:hover { color: #FF8C42; }
        .back-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #f0f0f0; border-radius: 25px; text-decoration: none; color: #666; font-weight: 600; transition: all 0.3s; }
        .back-btn:hover { background: #e0e0e0; color: #333; }
        .product-detail-container { max-width: 1400px; margin: 50px auto; padding: 0 50px; }
        .breadcrumb { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; color: #999; font-size: 0.95em; }
        .breadcrumb a { color: #FF8C42; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .product-main { background: white; border-radius: 30px; padding: 50px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); display: grid; grid-template-columns: 1fr 1fr; gap: 60px; margin-bottom: 40px; }
        .product-image-section { display: flex; flex-direction: column; gap: 20px; }
        .main-image { width: 100%; height: 500px; background: #f9f9f9; border-radius: 20px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .main-image img { max-width: 90%; max-height: 90%; object-fit: contain; }
        .thumbnail-images { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; }
        .thumbnail { height: 100px; background: #f9f9f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid transparent; transition: all 0.3s; }
        .thumbnail:hover, .thumbnail.active { border-color: #FF8C42; }
        .thumbnail img { max-width: 80%; max-height: 80%; object-fit: contain; }
        .product-info-section h1 { font-size: 2.5em; color: #333; margin-bottom: 15px; font-weight: 800; }
        .product-meta { display: flex; align-items: center; gap: 20px; margin-bottom: 25px; padding-bottom: 25px; border-bottom: 2px solid #f0f0f0; }
        .rating-display { display: flex; align-items: center; gap: 8px; }
        .stars { display: flex; gap: 3px; }
        .star { color: #FFD700; font-size: 1.3em; }
        .star.empty { color: #ddd; }
        .rating-text { color: #666; font-weight: 600; }
        .review-count { color: #999; }
        .product-price { font-size: 3em; color: #FF8C42; font-weight: 800; margin-bottom: 20px; }
        .stock-info { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #e8f5e9; color: #2e7d32; border-radius: 25px; font-weight: 600; margin-bottom: 25px; }
        .stock-info.out-of-stock { background: #ffebee; color: #c62828; }
        .product-description { color: #666; line-height: 1.8; font-size: 1.1em; margin-bottom: 30px; }
        .product-description h3 { color: #333; margin-bottom: 15px; font-size: 1.4em; }
        .quantity-selector { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .quantity-selector label { font-weight: 600; color: #333; }
        .quantity-controls { display: flex; align-items: center; background: #f0f0f0; border-radius: 30px; overflow: hidden; }
        .quantity-btn { width: 45px; height: 45px; border: none; background: transparent; font-size: 1.5em; cursor: pointer; transition: all 0.3s; color: #666; }
        .quantity-btn:hover { background: #e0e0e0; color: #333; }
        .quantity-input { width: 60px; text-align: center; border: none; background: transparent; font-size: 1.2em; font-weight: 600; color: #333; }
        .action-buttons { display: flex; gap: 15px; }
        .btn { flex: 1; padding: 18px 35px; border: none; border-radius: 30px; font-size: 1.2em; font-weight: 700; cursor: pointer; transition: all 0.3s; text-align: center; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-primary { background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%); color: white; box-shadow: 0 5px 20px rgba(255, 140, 66, 0.4); }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255, 140, 66, 0.6); }
        .btn-secondary { background: white; color: #FF8C42; border: 2px solid #FF8C42; }
        .btn-secondary:hover { background: #FF8C42; color: white; }
        .reviews-container { background: white; border-radius: 30px; padding: 50px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .reviews-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; padding-bottom: 25px; border-bottom: 2px solid #f0f0f0; }
        .reviews-header h2 { font-size: 2em; color: #333; }
        .btn-add-review { padding: 12px 30px; background: #FF8C42; color: white; border: none; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-add-review:hover { background: #FF6B35; transform: translateY(-2px); }
        .review-form { display: none; background: #f9f9f9; padding: 30px; border-radius: 20px; margin-bottom: 35px; }
        .review-form.active { display: block; }
        .review-form h3 { color: #333; margin-bottom: 25px; font-size: 1.5em; }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; color: #333; font-weight: 600; margin-bottom: 10px; font-size: 1.05em; }
        .rating-input { display: flex; gap: 10px; font-size: 2.5em; }
        .rating-input span { cursor: pointer; color: #ddd; transition: all 0.2s; }
        .rating-input span:hover, .rating-input span.active { color: #FFD700; transform: scale(1.1); }
        .form-control { width: 100%; padding: 15px 20px; border: 2px solid #e0e0e0; border-radius: 15px; font-size: 1.05em; font-family: inherit; transition: all 0.3s; }
        .form-control:focus { outline: none; border-color: #FF8C42; box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1); }
        textarea.form-control { resize: vertical; min-height: 150px; }
        .form-actions { display: flex; gap: 15px; }
        .reviews-list { display: flex; flex-direction: column; gap: 20px; }
        .review-item { padding: 25px; background: #f9f9f9; border-radius: 20px; transition: all 0.3s; }
        .review-item:hover { background: #f0f0f0; }
        .review-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
        .reviewer-info { display: flex; align-items: center; gap: 15px; }
        .reviewer-avatar { width: 55px; height: 55px; border-radius: 50%; background: linear-gradient(135deg, #FF8C42, #FF6B35); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.4em; }
        .reviewer-details h4 { font-size: 1.15em; color: #333; margin-bottom: 5px; }
        .review-date { color: #999; font-size: 0.9em; }
        .review-content { color: #666; line-height: 1.7; font-size: 1.05em; margin-top: 15px; }
        .no-reviews { text-align: center; padding: 60px 20px; color: #999; }
        .no-reviews h3 { font-size: 1.5em; margin-bottom: 10px; }
        @media (max-width: 992px) { .product-main { grid-template-columns: 1fr; } .nav-container { padding: 0 20px; } .product-detail-container { padding: 0 20px; } .product-main, .reviews-container { padding: 30px 20px; } .action-buttons { flex-direction: column; } }
        @media (max-width: 768px) { .product-info-section h1 { font-size: 2em; } .product-price { font-size: 2.2em; } .main-image { height: 350px; } }
    </style>
</head>
<body>
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
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>/</span>
        <a href="{{ route('products.index') }}">Products</a>
        <span>/</span>
        <span>{{ $product->name }}</span>
    </div>

    <a href="{{ route('products.index') }}" class="back-btn">← Back to Products</a>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="product-main">
            <div class="product-image-section">
                <div class="main-image" id="mainImage">
                    @if ($product->image)
                    <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" id="mainImageTag">
                    @else
                    <img src="https://via.placeholder.com/500x500?text={{ urlencode($product->name) }}" alt="{{ $product->name }}" id="mainImageTag">
                    @endif
                </div>

                <div class="thumbnail-images">
                    @for($i = 1; $i <= 4; $i++)
                    <div class="thumbnail {{ $i == 1 ? 'active' : '' }}" onclick="changeImage(this, '{{ $product->image ? asset('img/' . $product->image) : 'https://via.placeholder.com/500x500?text=' . urlencode($product->name) }}')">
                        <img src="{{ $product->image ? asset('img/' . $product->image) : 'https://via.placeholder.com/100x100?text=View' . $i }}" alt="View {{ $i }}">
                    </div>
                    @endfor
                </div>
            </div>

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
                    <p>{{ $product->description ?? 'Deskripsi produk belum tersedia.' }}</p>
                </div>

                <div id="cartActionArea">
                    <input type="hidden" id="prodId" value="{{ $product->product_id ?? $product->getKey() }}">

                    <div class="quantity-selector">
                        <label>Quantity:</label>
                        <div class="quantity-controls">
                            <button type="button" class="quantity-btn" onclick="decreaseQuantity()">−</button>
                            <input type="number" id="quantityInput" class="quantity-input" value="1" min="1" max="{{ $product->stock ?? 15 }}" readonly>
                            <button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="button" id="btnFinalAdd" class="btn btn-primary"
                                {{ ($product->stock ?? 15) <= 0 ? 'disabled' : '' }}
                            onclick="finalAddToCart(this)">
                            🛒 Add to Cart
                        </button>

                        <button type="button" class="btn btn-secondary" onclick="buyNow()">
                            ⚡ Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="reviews-container">
        <div class="reviews-header">
            <h2>Customer Reviews ({{ $reviews->count() }})</h2>
            <button class="btn-add-review" onclick="toggleReviewForm()">✍️ Write a Review</button>
        </div>
        <div class="lg:col-span-1">
            @auth
            <div class="review-form" id="reviewForm">
                <h3>Share Your Experience</h3>
                <form action="{{ route('reviews.store', $product->product_id) }}" method="POST" onsubmit="submitReview(event)">
                    @csrf
                    <div class="form-group">
                        <label>Your Rating</label>
                        <div class="rating-input" id="ratingInput">
                            <span id="star-1" onclick="setRating(1)">★</span>
                            <span id="star-2" onclick="setRating(2)">★</span>
                            <span id="star-3" onclick="setRating(3)">★</span>
                            <span id="star-4" onclick="setRating(4)">★</span>
                            <span id="star-5" onclick="setRating(5)">★</span>
                        </div>
                        <input type="hidden" id="ratingValue" name="rating" value="5">
                    </div>
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Your Review</label>
                        <textarea name="comment" class="form-control" placeholder="Tell us about your experience..." required></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleReviewForm()">Cancel</button>
                    </div>
                </form>
            </div>
            @endauth
        </div>
        <div class="reviews-list">
            @forelse($reviews as $review)
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">{{ strtoupper(substr($review->user_name ?? 'U', 0, 1)) }}</div>
                        <div class="reviewer-details">
                            <h4>{{ $review->user_name ?? 'User' }}</h4>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">★</span>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <span class="review-date">{{ $review->created_at->format('d M Y') }}</span>
                </div>
                <div class="review-content">{{ $review->comment }}</div>
            </div>
            @empty
            <div class="no-reviews"><h3>No reviews yet</h3></div>
            @endforelse
        </div>
    </div>
</div>

<div id="toast" class="toast-container" style="position: fixed; bottom: 20px; right: 20px; background: #333; color: white; padding: 15px 25px; border-radius: 10px; opacity: 0; transition: opacity 0.5s; z-index: 9999; pointer-events: none;">
    <span id="toastMessage"></span>
</div>
<style> .toast.show { opacity: 1; } .toast.success { background: #4CAF50; } .toast.error { background: #F44336; } </style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inisialisasi Toast & Gambar
        initHelpers();

        // 2. BERSIHKAN TOMBOL DARI GANGGUAN (Jurus Utama)
        cleanAndAttachListener();
    });

    const productId = '{{ $product->product_id ?? $product->getKey() }}';
    const maxStock = {{ (int)($product->stock ?? 15) }}

    function cleanAndAttachListener() {
        const oldBtn = document.getElementById('btnFinalAdd');

        if (oldBtn) {
            // Trik Clone: Membuat duplikat tombol untuk membuang semua event listener
            // dari jQuery atau file JS lain yang mengganggu.
            const newBtn = oldBtn.cloneNode(true);
            oldBtn.parentNode.replaceChild(newBtn, oldBtn);

            console.log('✨ Tombol berhasil dibersihkan dari script lain.');

            // Pasang Listener Tunggal di tombol baru
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation(); // Matikan event lain jika masi ada
                handleAddToCart(this);
            });
        }
    }

    let isProcessing = false;

    function handleAddToCart(btn) {
        // 1. Cek Kunci
        if (isProcessing) {
            console.warn('⛔ Klik ditahan: Proses sedang berjalan.');
            return;
        }

        console.log('🚀 Mulai proses Add to Cart...');
        isProcessing = true; // Kunci

        // 2. UI Loading
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.style.opacity = '0.7';
        btn.innerHTML = '⏳ Saving...';

        // 3. Ambil Data
        const qtyInput = document.getElementById('quantityInput');
        // Pastikan quantity minimal 1, cegah angka aneh
        let quantity = parseInt(qtyInput.value);
        if (isNaN(quantity) || quantity < 1) quantity = 1;

        console.log(`📦 Data dikirim: ID=${productId}, Qty=${quantity}`);

        // 4. Ambil CSRF
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrf) {
            showToast('CSRF Token Error', 'error');
            resetBtn(btn, originalText);
            return;
        }

        // 5. Kirim Request
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ product_id: productId, quantity: quantity })
        })
            .then(async res => {
                let data;
                try {
                    const text = await res.text();
                    // Cek jika server melempar halaman login HTML
                    if (text.includes('<html') || text.includes('login')) {
                        if(confirm('Sesi habis. Login sekarang?')) window.location.href = '/login';
                        throw new Error('Need Login');
                    }
                    data = JSON.parse(text);
                } catch (e) {
                    if(e.message !== 'Need Login') {
                        console.error('JSON Parse Error:', e);
                        showToast('Server Error (Cek Console)', 'error');
                    }
                    return;
                }

                if (res.ok && data.success) {
                    showToast(data.message, 'success');
                    // Update badge
                    const badge = document.querySelector('.cart-badge');
                    if (badge && data.cart_count) badge.textContent = data.cart_count;
                } else {
                    showToast(data.message || 'Gagal menambahkan', 'error');
                }
            })
            .catch(err => {
                console.error('Fetch Error:', err);
                showToast('Gagal menghubungi server', 'error');
            })
            .finally(() => {
                // 6. Buka Kunci (Wajib)
                console.log('🔓 Proses selesai. Kunci dibuka.');
                resetBtn(btn, originalText);
            });
    }

    function resetBtn(btn, text) {
        isProcessing = false;
        if(btn) {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.innerHTML = text;
        }
    }

    // --- Helper Functions (Gambar, Review, Qty) ---

    function increaseQuantity() {
        const el = document.getElementById('quantityInput');
        let v = parseInt(el.value) || 0;
        if (v < maxStock) el.value = v + 1;
    }

    function decreaseQuantity() {
        const el = document.getElementById('quantityInput');
        let v = parseInt(el.value) || 2;
        if (v > 1) el.value = v - 1;
    }

    function changeImage(thumb, url) {
        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
        const img = document.getElementById('mainImageTag');
        if(img) img.src = url;
    }

    function initHelpers() {
        // Init Toast UI kalau belum ada
        if(!document.getElementById('toast')) {
            const t = document.createElement('div');
            t.id = 'toast';
            t.style.cssText = "position: fixed; bottom: 20px; right: 20px; background: #333; color: white; padding: 15px 25px; border-radius: 10px; opacity: 0; transition: opacity 0.5s; z-index: 9999; pointer-events: none;";
            t.innerHTML = '<span id="toastMessage"></span>';
            document.body.appendChild(t);
        }
    }

    function showToast(msg, type) {
        const t = document.getElementById('toast');
        const m = document.getElementById('toastMessage');
        if(t && m) {
            t.style.background = type === 'error' ? '#F44336' : '#4CAF50';
            m.textContent = msg;
            t.style.opacity = '1';
            setTimeout(() => t.style.opacity = '0', 4000);
        } else {
            alert(msg);
        }
    }

    // Buy Now / Reviews functions (bisa dicopy dari sebelumnya jika butuh)
    function buyNow() {
        const q = document.getElementById('quantityInput').value;
        // ... Logika buy now ...
        window.location.href = '/checkout'; // Simplifikasi sementara
    }
</script>
</body>
</html>
