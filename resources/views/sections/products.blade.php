<section id="products" style="min-height: 100vh; padding: 100px 0; background: #f9f9f9;">
    <style>
        .products-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 50px;
        }

        .products-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .products-header h2 {
            font-size: 3em;
            color: #333;
            margin-bottom: 15px;
            font-weight: 800;
        }

        .products-header p {
            font-size: 1.2em;
            color: #666;
        }

        .product-showcase {
            background: white;
            border-radius: 30px;
            padding: 60px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            margin-bottom: 50px;
        }

        .product-img img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .product-details h3 {
            font-size: 2.2em;
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .product-description {
            font-size: 1.1em;
            color: #666;
            margin-bottom: 25px;
            line-height: 1.8;
        }

        .rating {
            display: flex;
            gap: 5px;
            margin-bottom: 25px;
        }

        .rating svg {
            width: 28px;
            height: 28px;
            fill: #FFD700;
        }

        .product-price {
            font-size: 2.5em;
            color: #FF8C42;
            font-weight: 800;
            margin-bottom: 30px;
        }

        .btn-add-cart {
            display: inline-block;
            padding: 16px 45px;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2em;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(255, 140, 66, 0.4);
            border: none;
            cursor: pointer;
        }

        .btn-add-cart:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255, 140, 66, 0.6);
        }

        .view-all-section {
            text-align: center;
        }

        .btn-view-all {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 18px 50px;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.3em;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(255, 140, 66, 0.4);
        }

        .btn-view-all:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255, 140, 66, 0.6);
        }

        .btn-view-all svg {
            width: 24px;
            height: 24px;
        }

        @media (max-width: 992px) {
            .product-showcase {
                grid-template-columns: 1fr;
                padding: 40px;
                text-align: center;
            }
            .product-img img { margin: 0 auto; }
            .rating { justify-content: center; }
        }

        @media (max-width: 768px) {
            .products-container { padding: 0 20px; }
            .products-header h2 { font-size: 2.2em; }
            .product-showcase { padding: 30px 20px; }
            .product-details h3 { font-size: 1.8em; }
            .product-price { font-size: 2em; }
            .btn-add-cart, .btn-view-all { padding: 14px 35px; font-size: 1em; }
        }
    </style>

    <div class="products-container">
        <div class="products-header">
            <h2>Pet Products Shop</h2>
            <p>Premium quality products for your beloved pets</p>
        </div>

        @php
            // pick a featured product: try to find Pedigree, otherwise first dog-food, otherwise first product
            $featured = null;
            if (isset($products) && $products->count() > 0) {
                $featured = $products->firstWhere('name', 'like', '%Pedigree%')
                            ?? $products->firstWhere('category', 'dog-food')
                            ?? $products->first();
            }
        @endphp

        <div class="product-showcase">
            <div class="product-img">
                @if($featured && ($featured->image ?? false))
                    <img src="{{ asset('images/' . ($featured->image ?? 'makanan.jpeg')) }}" alt="{{ $featured->name }}">
                @else
                    <img src="{{ asset('images/makanan.jpeg') }}" alt="Product">
                @endif
            </div>

            <div class="product-details">
                <h3>{{ $featured->name ?? 'Pedigree' }}</h3>
                <p class="product-description">{{ $featured->description ?? 'Nutrisi lengkap untuk anjing dewasa, 3kg' }}</p>

                <div class="rating">
                    @php
                        $avg = $featured->average_rating ?? 0;
                        $full = (int) floor($avg);
                        $hasHalf = ($avg - $full) >= 0.5;
                    @endphp

                    @for ($i = 0; $i < $full; $i++)
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endfor

                    @if($hasHalf)
                        <!-- half star: left half filled -->
                        <svg viewBox="0 0 24 24" style="width:28px;height:28px;">
                            <defs>
                                <clipPath id="halfClip">
                                    <rect x="0" y="0" width="12" height="24" />
                                </clipPath>
                            </defs>
                            <g clip-path="url(#halfClip)">
                                <path fill="#FFD700" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </g>
                            <path fill="none" stroke="#FFD700" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    @endif

                    @php $rendered = $full + ($hasHalf ? 1 : 0); @endphp
                    @for ($i = $rendered; $i < 5; $i++)
                        <svg viewBox="0 0 24 24" style="opacity:0.25;"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endfor

                    <span style="margin-left:8px;color:#666;font-weight:700;">{{ number_format($avg, 1) }} ({{ $featured->reviews_count ?? 0 }})</span>
                </div>

                <div class="product-price">Rp {{ number_format($featured->price ?? 140000, 0, ',', '.') }}</div>

                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $featured->product_id ?? 1 }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-add-cart">Add to Cart</button>
                </form>
            </div>
        </div>

        <div class="view-all-section">
            <a href="{{ route('products.shop') }}" class="btn-view-all">
                See all Products
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
