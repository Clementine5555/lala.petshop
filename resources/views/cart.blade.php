<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keranjang Belanja - Petshop Lala</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('/images/anjingkucing.jpeg') center/cover no-repeat fixed;
        min-height: 100vh;
        padding: 40px 20px;
        position: relative;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.85);
        z-index: -1;
    }

        /* Back Button */
        .back-button {
            position: fixed;
            top: 30px;
            left: 30px;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: white;
            border: 2px solid #FF8C42;
            border-radius: 50px;
            color: #FF8C42;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .back-button:hover {
            background: #FF8C42;
            color: white;
            transform: translateX(-5px);
            box-shadow: 0 6px 20px rgba(255,140,66,0.3);
        }

        .back-button svg {
            width: 20px;
            height: 20px;
        }

        /* Main Container */
          .container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: calc(100vh - 80px);
        }

        /* Header */
        .page-header {
            text-align: center;
            margin-bottom: 50px;
            animation: slideDown 0.6s ease;
        }

        .page-header h1 {
            font-size: 3em;
            color: #FF8C42;
            text-shadow: 2px 2px 15px rgba(255,140,66,0.5);
            margin-bottom: 10px;
            font-weight: 800;
        }

        .page-header p {
            font-size: 1.1em;
            color: #FF6B35;
            font-weight: 600;
            text-shadow: 1px 1px 5px rgba(255,140,66,0.3);
        }

        /* Tabs */
        .tabs-container {
            display: flex;
            gap: 15px;
            margin-bottom: 40px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 14px 32px;
            border: 2px solid white;
            background: rgba(255,255,255,0.2);
            border-radius: 50px;
            font-size: 1em;
            font-weight: 700;
            cursor: pointer;
            color: white;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }

        .tab-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            border-color: #FF8C42;
            box-shadow: 0 8px 25px rgba(255,140,66,0.4);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        /* Cart Section */
        .cart-wrapper {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 30px;
        }

        .cart-items {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .cart-header {
            font-size: 1.8em;
            color: #FF8C42;
            margin-bottom: 25px;
            font-weight: 700;
            border-bottom: 3px solid #fff5f0;
            padding-bottom: 15px;
        }

        .cart-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 15px;
            margin-bottom: 15px;
            align-items: center;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .cart-item:hover {
            border-color: #FF8C42;
            box-shadow: 0 5px 15px rgba(255,140,66,0.2);
            transform: translateX(5px);
        }

        .item-img {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-size: 1.1em;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .item-meta {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            border-radius: 8px;
            width: fit-content;
            padding: 4px;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border: none;
            background: #f0f0f0;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s;
        }

        .qty-btn:hover {
            background: #FF8C42;
            color: white;
        }

        .qty-input {
            width: 40px;
            text-align: center;
            border: none;
            font-weight: 700;
            background: white;
        }

        .item-price {
            text-align: right;
        }

        .price-amount {
            font-size: 1.3em;
            font-weight: 800;
            color: #FF8C42;
        }

        .remove-btn {
            background: none;
            border: none;
            color: #dc2626;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9em;
            transition: color 0.3s;
            margin-top: 8px;
        }

        .remove-btn:hover {
            color: #991b1b;
        }

        /* Cart Summary */
        .cart-summary {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .summary-title {
            font-size: 1.4em;
            color: #FF8C42;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #666;
            padding: 10px 0;
        }

        .summary-row.total {
            font-size: 1.4em;
            font-weight: 800;
            color: #FF8C42;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .btn-checkout {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.1em;
            font-weight: 700;
            cursor: pointer;
            margin-top: 25px;
            transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(255,140,66,0.4);
        }

        .btn-checkout:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(255,140,66,0.5);
        }

        .btn-checkout:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Orders Section */
        .orders-grid {
            display: grid;
            gap: 25px;
        }

        .order-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s;
            border-left: 5px solid #FF8C42;
        }

        .order-card:hover {
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
            transform: translateY(-5px);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .order-info h3 {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 5px;
        }

        .order-info p {
            color: #999;
            font-size: 0.9em;
        }

        .order-status {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85em;
        }

        .status-pending {
            background: #fff3e0;
            color: #f57c00;
        }

        .status-processing {
            background: #e3f2fd;
            color: #1976d2;
        }

        .status-approved {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-rejected {
            background: #ffebee;
            color: #c62828;
        }

        .order-items-list {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 12px;
        }

        .order-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .order-item-row:last-child {
            border-bottom: none;
        }

        .order-item-name {
            font-weight: 600;
            color: #333;
        }

        .order-item-qty {
            color: #666;
            font-size: 0.9em;
        }

        .order-item-total {
            font-weight: 700;
            color: #FF8C42;
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 2px solid #f0f0f0;
        }

        .order-total {
            font-size: 1.3em;
            font-weight: 800;
            color: #333;
        }

        .btn-refund, .btn-return {
            padding: 10px 24px;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9em;
            margin-left: 10px;
        }

        .btn-refund:hover, .btn-return:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,140,66,0.4);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 20px;
        }

        .empty-state-icon {
            font-size: 5em;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 30px;
        }

        .btn-shop {
            display: inline-block;
            padding: 12px 32px;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            text-decoration: none;
            border-radius: 15px;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-shop:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255,140,66,0.4);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .modal-header h2 {
            color: #FF8C42;
            font-size: 1.5em;
        }

        .close-modal {
            width: 30px;
            height: 30px;
            cursor: pointer;
            color: #999;
            font-size: 1.5em;
            transition: color 0.3s;
        }

        .close-modal:hover {
            color: #FF8C42;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1em;
            font-family: inherit;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #FF8C42;
            box-shadow: 0 0 0 3px rgba(255,140,66,0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 15px;
            background: #f9f9f9;
            border: 2px dashed #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            color: #666;
            font-weight: 600;
        }

        .file-upload-label:hover {
            border-color: #FF8C42;
            background: #fff5f0;
            color: #FF8C42;
        }

        .file-preview {
            margin-top: 15px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 8px;
            display: none;
        }

        .file-preview.active {
            display: block;
        }

        .file-preview img {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 10px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }

        .radio-option:hover {
            border-color: #FF8C42;
            background: #fff5f0;
        }

        .radio-option input[type="radio"] {
            margin-right: 12px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .radio-option input[type="radio"]:checked + label {
            color: #FF8C42;
            font-weight: 700;
        }

        .radio-option label {
            cursor: pointer;
            font-weight: 600;
            color: #333;
            flex: 1;
        }

        .payment-info {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background: #fff5f0;
            border: 2px solid #FF8C42;
            border-radius: 12px;
        }

        .payment-info.active {
            display: block;
        }

        .payment-info h4 {
            color: #FF8C42;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .payment-info p {
            color: #666;
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .payment-info strong {
            color: #333;
        }

        .checkout-summary {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .checkout-summary h3 {
            color: #FF8C42;
            margin-bottom: 15px;
            font-size: 1.2em;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #666;
        }

        .summary-item.total {
            font-size: 1.3em;
            font-weight: 800;
            color: #FF8C42;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #e0e0e0;
        }

        .success-message {
            text-align: center;
            padding: 40px 20px;
        }

        .success-icon {
            font-size: 5em;
            color: #2e7d32;
            margin-bottom: 20px;
        }

        .success-message h2 {
            color: #2e7d32;
            margin-bottom: 15px;
        }

        .success-message p {
            color: #666;
            margin-bottom: 10px;
        }

        .order-id {
            font-size: 1.3em;
            font-weight: 700;
            color: #FF8C42;
            margin: 20px 0;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @media (max-width: 1024px) {
            .cart-wrapper {
                grid-template-columns: 1fr;
            }

            .cart-summary {
                position: static;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2em;
            }

            .back-button {
                top: 15px;
                left: 15px;
                padding: 10px 20px;
                font-size: 0.9em;
            }

            .cart-item {
                flex-direction: column;
                text-align: center;
            }

            .item-price {
                text-align: center;
                margin-top: 10px;
            }

            .order-footer {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .tabs-container {
                gap: 10px;
            }

            .tab-btn {
                padding: 12px 20px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>

    <!-- Back Button -->
    <a href="{{ route('products.index') }}" class="back-button">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Products
    </a>

    <!-- Main Container -->
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1>🛒 Kelola Pesanan Anda</h1>
            <p>Lihat keranjang, pesanan, return, dan ajukan refund dengan mudah</p>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('cart')">🛍️ Keranjang Belanja</button>
            <button class="tab-btn" onclick="switchTab('orders')">📦 Daftar Pesanan</button>
            <button class="tab-btn" onclick="switchTab('return')">🔄 Return</button>
            <button class="tab-btn" onclick="switchTab('refund')">💰 Refund</button>
        </div>

        <!-- CART TAB -->
        <div id="cart-tab" class="tab-content active">
            <div class="cart-wrapper">
                <div class="cart-items">
                    <h2 class="cart-header">Produk Anda</h2>
                    
                    @if(session('cart') && count(session('cart')) > 0)
                        @foreach(session('cart') as $id => $item)
                        <div class="cart-item">
                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/100' }}" alt="{{ $item['name'] }}" class="item-img">
                            <div class="item-info">
                                <div class="item-name">{{ $item['name'] }}</div>
                                <div class="item-meta">Stok: Tersedia | SKU: {{ $id }}</div>
                                <div class="qty-control">
                                    <button class="qty-btn" onclick="updateQuantity({{ $id }}, -1)">−</button>
                                    <input type="text" class="qty-input" value="{{ $item['quantity'] }}" readonly>
                                    <button class="qty-btn" onclick="updateQuantity({{ $id }}, 1)">+</button>
                                </div>
                            </div>
                            <div class="item-price">
                                <div class="price-amount">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                                <button class="remove-btn" onclick="removeFromCart({{ $id }})">Hapus</button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">🛒</div>
                            <h3>Keranjang Kosong</h3>
                            <p>Belum ada produk di keranjang Anda</p>
                            <a href="{{ route('products.index') }}" class="btn-shop">Mulai Belanja</a>
                        </div>
                    @endif
                </div>

                @if(session('cart') && count(session('cart')) > 0)
                <div class="cart-summary">
                    <h3 class="summary-title">Ringkasan</h3>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format(collect(session('cart'))->sum(function($item) { return $item['price'] * $item['quantity']; }), 0, ',', '.') }}</span>
                    </div>
                    <button class="btn-checkout" onclick="openCheckoutModal()">Lanjut ke Checkout</button>
                </div>
                @endif
            </div>
        </div>

        <!-- ORDERS TAB -->
        <div id="orders-tab" class="tab-content">
            <div class="orders-grid">
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Order #12347</h3>
                            <p>Dibeli: 20 November 2025</p>
                        </div>
                        <span class="order-status status-processing">⏳ Sedang Diproses</span>
                    </div>
                    <div class="order-items-list">
                        <div class="order-item-row">
                            <div>
                                <div class="order-item-name">Royal Canin Kitten Food</div>
                                <div class="order-item-qty">Qty: 1</div>
                            </div>
                            <div class="order-item-total">Rp 350.000</div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">Total: Rp 350.000</div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Order #12345</h3>
                            <p>Dibeli: 15 November 2025</p>
                        </div>
                        <span class="order-status status-approved">✓ Delivered</span>
                    </div>
                    <div class="order-items-list">
                        <div class="order-item-row">
                            <div>
                                <div class="order-item-name">Whiskas Adult Cat Food</div>
                                <div class="order-item-qty">Qty: 2</div>
                            </div>
                            <div class="order-item-total">Rp 260.000</div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">Total: Rp 260.000</div>
                        <div>
                            <button class="btn-return" onclick="openReturnModal()">Return</button>
                            <button class="btn-refund" onclick="openRefundModal()">Refund</button>
                        </div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Order #12346</h3>
                            <p>Dibeli: 18 November 2025</p>
                        </div>
                        <span class="order-status status-approved">✓ Delivered</span>
                    </div>
                    <div class="order-items-list">
                        <div class="order-item-row">
                            <div>
                                <div class="order-item-name">Pedigree Premium Dog Food</div>
                                <div class="order-item-qty">Qty: 1</div>
                            </div>
                            <div class="order-item-total">Rp 285.000</div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">Total: Rp 285.000</div>
                        <div>
                            <button class="btn-return" onclick="openReturnModal()">Return</button>
                            <button class="btn-refund" onclick="openRefundModal()">Refund</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RETURN TAB -->
        <div id="return-tab" class="tab-content">
            <div class="orders-grid">
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Return #RT12340</h3>
                            <p>Diajukan: 12 November 2025</p>
                        </div>
                        <span class="order-status status-pending">⏳ Menunggu Review</span>
                    </div>
                    <div class="order-items-list">
                        <div class="order-item-row">
                            <div>
                                <div class="order-item-name">Me-O Persian Cat Food</div>
                                <div class="order-item-qty">Qty: 2 | Alasan: Produk tidak sesuai</div>
                            </div>
                            <div class="order-item-total">Rp 198.000</div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">Total Return: Rp 198.000</div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Return #RT12338</h3>
                            <p>Selesai: 8 November 2025</p>
                        </div>
                        <span class="order-status status-approved">✓ Disetujui</span>
                    </div>
                    <div class="order-items-list">
                        <div class="order-item-row">
                            <div>
                                <div class="order-item-name">Friskies Cat Food</div>
                                <div class="order-item-qty">Qty: 1 | Alasan: Ukuran salah</div>
                            </div>
                            <div class="order-item-total">Rp 75.000</div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">Total Return: Rp 75.000</div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Return #RT12335</h3>
                            <p>Ditolak: 3 November 2025</p>
                        </div>
                        <span class="order-status status-rejected">✗ Ditolak</span>
                    </div>
                    <div class="order-items-list">
                        <div class="order-item-row">
                            <div>
                                <div class="order-item-name">Royal Canin Adult Dog Food</div>
                                <div class="order-item-qty">Qty: 1 | Alasan: Produk sudah dibuka</div>
                            </div>
                            <div class="order-item-total">Rp 420.000</div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">Total: Rp 420.000</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- REFUND TAB -->
        <div id="refund-tab" class="tab-content">
            <div class="orders-grid">
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Refund #RF12340</h3>
                            <p>Diajukan: 10 November 2025</p>
                        </div>
                        <span class="order-status status-pending">⏳ Menunggu Review</span>
                    </div>
                    <div class="order-items-list">
                        <div class="order-item-row">
                            <div>
                                <div class="order-item-name">Me-O Persian Cat Food</div>
                                <div class="order-item-qty">Qty: 3 | Alasan: Produk rusak</div>
                            </div>
                            <div class="order-item-total">Rp 297.000</div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">Refund: Rp 297.000</div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Refund #RF12338</h3>
                            <p>Selesai: 5 November 2025</p>
                        </div>
                        <span class="order-status status-approved">✓ Disetujui</span>
                    </div>
                    <div class="order-items-list">
                        <div class="order-item-row">
                            <div>
                                <div class="order-item-name">Pedigree Adult Dog Food</div>
                                <div class="order-item-qty">Qty: 1</div>
                            </div>
                            <div class="order-item-total">Rp 285.000</div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">Refund: Rp 285.000</div>
                    </div>
                </div>

                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>Refund #RF12335</h3>
                            <p>Ditolak: 1 November 2025</p>
                        </div>
                        <span class="order-status status-rejected">✗ Ditolak</span>
                    </div>
                    <div class="order-items-list">
                        <div class="order-item-row">
                            <div>
                                <div class="order-item-name">Friskies Cat Food</div>
                                <div class="order-item-qty">Qty: 2 | Alasan: Melebihi batas waktu</div>
                            </div>
                            <div class="order-item-total">Rp 150.000</div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">Total: Rp 150.000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div class="modal" id="checkoutModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📋 Checkout & Pembayaran</h2>
                <span class="close-modal" onclick="closeCheckoutModal()">✕</span>
            </div>

            <form id="checkoutForm" onsubmit="submitCheckout(event)">
                <!-- Order Summary -->
                <div class="checkout-summary">
                    <h3>Ringkasan Pesanan</h3>
                    <div id="checkoutItems"></div>
                    <div class="summary-item total">
                        <span>Total Pembayaran</span>
                        <span id="checkoutTotal">Rp 0</span>
                    </div>
                </div>

                <h3 style="color: #FF8C42; margin-bottom: 15px; font-size: 1.1em;">📍 Data Pengiriman</h3>

                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" class="form-control" name="full_name" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                    <label>No. Telepon / WhatsApp *</label>
                    <input type="tel" class="form-control" name="phone" placeholder="08xxxxxxxxxx" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="email@example.com">
                </div>

                <div class="form-group">
                    <label>Alamat Lengkap *</label>
                    <textarea class="form-control" name="address" placeholder="Jalan, nomor rumah, RT/RW, Kelurahan, Kecamatan" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kota *</label>
                        <input type="text" class="form-control" name="city" placeholder="Kota" required>
                    </div>

                    <div class="form-group">
                        <label>Kode Pos *</label>
                        <input type="text" class="form-control" name="postal_code" placeholder="12345" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Catatan Pesanan (Opsional)</label>
                    <textarea class="form-control" name="notes" placeholder="Catatan khusus untuk pesanan Anda"></textarea>
                </div>

                <h3 style="color: #FF8C42; margin: 25px 0 15px; font-size: 1.1em;">💳 Metode Pembayaran</h3>

                <div class="form-group">
                    <label>Payment Method *</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="cash" name="payment_method" value="cash" required onchange="togglePaymentInfo()">
                            <label for="cash">💵 Cash (Bayar di Tempat)</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" onchange="togglePaymentInfo()">
                            <label for="bank_transfer">🏦 Bank Transfer</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="ewallet" name="payment_method" value="ewallet" onchange="togglePaymentInfo()">
                            <label for="ewallet">📱 E-Wallet (GoPay)</label>
                        </div>
                    </div>

                    <!-- Payment Info Sections -->
                    <div id="cashInfo" class="payment-info">
                        <h4>💵 Pembayaran Cash</h4>
                        <p>Pembayaran dilakukan saat barang diterima (COD - Cash on Delivery)</p>
                        <p>📌 Pastikan Anda menyiapkan uang pas atau kurir akan memberikan kembalian</p>
                    </div>

                    <div id="bankInfo" class="payment-info">
                        <h4>🏦 Informasi Bank Transfer</h4>
                        <p><strong>Bank BCA</strong><br>
                        No. Rekening: 1234567890<br>
                        A/N: Petshop Lala</p>
                        <p><strong>Bank Mandiri</strong><br>
                        No. Rekening: 0987654321<br>
                        A/N: Petshop Lala</p>
                        <p><strong>Bank BRI</strong><br>
                        No. Rekening: 5555666677778888<br>
                        A/N: Petshop Lala</p>
                        <p><strong>Bank BNI</strong><br>
                        No. Rekening: 9999888877776666<br>
                        A/N: Petshop Lala</p>
                        <p style="color: #FF8C42; font-weight: 600; margin-top: 10px;">⚠️ Upload bukti transfer di bawah ini</p>
                    </div>

                    <div id="ewalletInfo" class="payment-info">
                        <h4>📱 Pembayaran GoPay</h4>
                        <p><strong>Nomor GoPay:</strong> 0812-3456-7890<br>
                        <strong>A/N:</strong> Petshop Lala</p>
                        <p>💡 Scan QR Code atau transfer langsung ke nomor di atas</p>
                        <p style="color: #FF8C42; font-weight: 600; margin-top: 10px;">⚠️ Upload bukti pembayaran di bawah ini</p>
                    </div>
                </div>

                <div id="uploadSection" style="display: none;">
                    <h3 style="color: #FF8C42; margin: 25px 0 15px; font-size: 1.1em;">📤 Upload Bukti Pembayaran</h3>

                    <div class="form-group">
                        <div class="file-upload-wrapper">
                            <input type="file" id="payment_proof" name="payment_proof" accept="image/*" onchange="previewPaymentProof(event)">
                            <label for="payment_proof" class="file-upload-label">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <span id="file-label">Pilih file bukti pembayaran</span>
                            </label>
                        </div>
                        <div class="file-preview" id="filePreview">
                            <p style="color: #666; font-size: 0.9em; margin-bottom: 5px;">Preview:</p>
                            <img id="previewImage" src="" alt="Preview">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-checkout" id="submitCheckoutBtn">
                    ✅ Konfirmasi & Submit Pesanan
                </button>
            </form>
        </div>
    </div>

    <!-- Return Modal -->
    <div class="modal" id="returnModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>🔄 Ajukan Return Produk</h2>
                <span class="close-modal" onclick="closeReturnModal()">✕</span>
            </div>

            <form id="returnForm" onsubmit="submitReturn(event)">
                <div class="form-group">
                    <label>Alasan Return *</label>
                    <select class="form-control" required>
                        <option value="">Pilih alasan...</option>
                        <option value="wrong_item">Produk salah/tidak sesuai pesanan</option>
                        <option value="wrong_size">Ukuran/varian salah</option>
                        <option value="defect">Produk cacat</option>
                        <option value="not_as_described">Tidak sesuai deskripsi</option>
                        <option value="change_mind">Berubah pikiran</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi Detail *</label>
                    <textarea class="form-control" placeholder="Jelaskan alasan return Anda secara detail..." required></textarea>
                </div>

                <div class="form-group">
                    <label>Kondisi Produk *</label>
                    <select class="form-control" required>
                        <option value="">Pilih kondisi...</option>
                        <option value="unopened">Belum dibuka (segel masih utuh)</option>
                        <option value="opened_unused">Sudah dibuka tapi belum dipakai</option>
                        <option value="used">Sudah dipakai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Upload Foto Produk (Opsional)</label>
                    <div class="file-upload-wrapper">
                        <input type="file" id="return_photo" accept="image/*" onchange="previewReturnPhoto(event)">
                        <label for="return_photo" class="file-upload-label">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span id="return-file-label">Pilih foto produk</span>
                        </label>
                    </div>
                    <div class="file-preview" id="returnFilePreview">
                        <p style="color: #666; font-size: 0.9em; margin-bottom: 5px;">Preview:</p>
                        <img id="returnPreviewImage" src="" alt="Preview">
                    </div>
                </div>

                <button type="submit" class="btn-checkout" style="margin-top: 10px;">🔄 Kirim Permintaan Return</button>
            </form>
        </div>
    </div>

    <!-- Refund Modal -->
    <div class="modal" id="refundModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>💰 Ajukan Refund</h2>
                <span class="close-modal" onclick="closeRefundModal()">✕</span>
            </div>

            <form id="refundForm" onsubmit="submitRefund(event)">
                <div class="form-group">
                    <label>Alasan Refund *</label>
                    <select class="form-control" required>
                        <option value="">Pilih alasan...</option>
                        <option value="damaged">Produk rusak/cacat</option>
                        <option value="wrong">Produk salah/tidak sesuai</option>
                        <option value="expired">Produk kadaluarsa</option>
                        <option value="quality">Kualitas tidak sesuai</option>
                        <option value="incomplete">Barang tidak lengkap</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi Detail *</label>
                    <textarea class="form-control" placeholder="Jelaskan masalah Anda secara detail..." required></textarea>
                </div>

                <div class="form-group">
                    <label>Bank untuk Refund *</label>
                    <select class="form-control" required>
                        <option value="">Pilih bank...</option>
                        <option value="bca">BCA</option>
                        <option value="mandiri">Mandiri</option>
                        <option value="bri">BRI</option>
                        <option value="bni">BNI</option>
                        <option value="other">Bank Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Nomor Rekening *</label>
                    <input type="text" class="form-control" placeholder="Masukkan nomor rekening" required>
                </div>

                <div class="form-group">
                    <label>Nama Pemilik Rekening *</label>
                    <input type="text" class="form-control" placeholder="Masukkan nama pemilik rekening" required>
                </div>

                <div class="form-group">
                    <label>Upload Bukti (Foto produk rusak, dll)</label>
                    <div class="file-upload-wrapper">
                        <input type="file" id="refund_photo" accept="image/*" onchange="previewRefundPhoto(event)">
                        <label for="refund_photo" class="file-upload-label">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span id="refund-file-label">Pilih foto bukti</span>
                        </label>
                    </div>
                    <div class="file-preview" id="refundFilePreview">
                        <p style="color: #666; font-size: 0.9em; margin-bottom: 5px;">Preview:</p>
                        <img id="refundPreviewImage" src="" alt="Preview">
                    </div>
                </div>

                <button type="submit" class="btn-checkout" style="margin-top: 10px;">💰 Kirim Permintaan Refund</button>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal" id="successModal">
        <div class="modal-content">
            <div class="success-message">
                <div class="success-icon">✅</div>
                <h2>Pesanan Berhasil Dibuat!</h2>
                <p>Terima kasih telah berbelanja di Petshop Lala</p>
                <div class="order-id">Order ID: #<span id="newOrderId"></span></div>
                <p style="margin-top: 20px;">Pesanan Anda sedang diproses dan akan segera dikirim</p>
                <button class="btn-checkout" onclick="closeSuccessModal()" style="margin-top: 30px; max-width: 300px;">
                    Lihat Daftar Pesanan
                </button>
            </div>
        </div>
    </div>

    <script>
        // Payment method toggle
        function togglePaymentInfo() {
            const cashInfo = document.getElementById('cashInfo');
            const bankInfo = document.getElementById('bankInfo');
            const ewalletInfo = document.getElementById('ewalletInfo');
            const uploadSection = document.getElementById('uploadSection');
            const paymentProof = document.getElementById('payment_proof');
            
            // Hide all
            cashInfo.classList.remove('active');
            bankInfo.classList.remove('active');
            ewalletInfo.classList.remove('active');
            uploadSection.style.display = 'none';
            
            // Reset required attribute
            if (paymentProof) {
                paymentProof.removeAttribute('required');
            }
            
            // Show based on selection
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (selectedMethod) {
                if (selectedMethod.value === 'cash') {
                    cashInfo.classList.add('active');
                } else if (selectedMethod.value === 'bank_transfer') {
                    bankInfo.classList.add('active');
                    uploadSection.style.display = 'block';
                    if (paymentProof) {
                        paymentProof.setAttribute('required', 'required');
                    }
                } else if (selectedMethod.value === 'ewallet') {
                    ewalletInfo.classList.add('active');
                    uploadSection.style.display = 'block';
                    if (paymentProof) {
                        paymentProof.setAttribute('required', 'required');
                    }
                }
            }
        }

        // Tab switching
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            document.getElementById(tabName + '-tab').classList.add('active');
            event.target.classList.add('active');
        }

        // Checkout Modal
        function openCheckoutModal() {
            const modal = document.getElementById('checkoutModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            loadCheckoutSummary();
        }

        function closeCheckoutModal() {
            document.getElementById('checkoutModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function loadCheckoutSummary() {
            const itemsContainer = document.getElementById('checkoutItems');
            const totalContainer = document.getElementById('checkoutTotal');
            
            itemsContainer.innerHTML = `
                <div class="summary-item">
                    <span>Subtotal Produk</span>
                    <span>Rp {{ number_format(collect(session('cart'))->sum(function($item) { return $item['price'] * $item['quantity']; }), 0, ',', '.') }}</span>
                </div>
            `;
            
            totalContainer.textContent = 'Rp {{ number_format(collect(session('cart'))->sum(function($item) { return $item['price'] * $item['quantity']; }), 0, ',', '.') }}';
        }

        // Preview payment proof
        function previewPaymentProof(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('filePreview').classList.add('active');
                    document.getElementById('file-label').textContent = file.name;
                };
                reader.readAsDataURL(file);
            }
        }

        // Preview return photo
        function previewReturnPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('returnPreviewImage').src = e.target.result;
                    document.getElementById('returnFilePreview').classList.add('active');
                    document.getElementById('return-file-label').textContent = file.name;
                };
                reader.readAsDataURL(file);
            }
        }

        // Preview refund photo
        function previewRefundPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('refundPreviewImage').src = e.target.result;
                    document.getElementById('refundFilePreview').classList.add('active');
                    document.getElementById('refund-file-label').textContent = file.name;
                };
                reader.readAsDataURL(file);
            }
        }

        // Submit checkout
        function submitCheckout(event) {
            event.preventDefault();
            
            const form = event.target;
            const submitBtn = document.getElementById('submitCheckoutBtn');
            const formData = new FormData(form);
            
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            const paymentProof = document.getElementById('payment_proof').files[0];
            
            // Validate payment proof for non-cash methods
            if ((paymentMethod === 'bank_transfer' || paymentMethod === 'ewallet') && !paymentProof) {
                alert('❌ Harap upload bukti pembayaran');
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.textContent = '⏳ Memproses...';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            // Simulate success and CLEAR CART
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = '✅ Konfirmasi & Submit Pesanan';
                
                const orderId = 12348 + Math.floor(Math.random() * 100);
                
                // Clear cart via AJAX
                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Cart cleared:', data);
                })
                .catch(error => {
                    console.error('Error clearing cart:', error);
                });
                
                closeCheckoutModal();
                showSuccessModal(orderId);
                
                form.reset();
                document.getElementById('filePreview').classList.remove('active');
                document.getElementById('file-label').textContent = 'Pilih file bukti pembayaran';
                togglePaymentInfo();
            }, 1500);
        }

        // Success modal
        function showSuccessModal(orderId) {
            document.getElementById('newOrderId').textContent = orderId;
            document.getElementById('successModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.remove('active');
            document.body.style.overflow = 'auto';
            location.reload(); // Reload to show empty cart
        }

        // Return Modal
        function openReturnModal() {
            document.getElementById('returnModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeReturnModal() {
            document.getElementById('returnModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function submitReturn(event) {
            event.preventDefault();
            alert('✅ Permintaan return berhasil dikirim! Tim kami akan segera meninjau permintaan Anda.');
            closeReturnModal();
            event.target.reset();
            document.getElementById('returnFilePreview').classList.remove('active');
            document.getElementById('return-file-label').textContent = 'Pilih foto produk';
        }

        // Refund Modal
        function openRefundModal() {
            document.getElementById('refundModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeRefundModal() {
            document.getElementById('refundModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function submitRefund(event) {
            event.preventDefault();
            alert('✅ Permintaan refund berhasil dikirim! Tim kami akan segera meninjau permintaan Anda.');
            closeRefundModal();
            event.target.reset();
            document.getElementById('refundFilePreview').classList.remove('active');
            document.getElementById('refund-file-label').textContent = 'Pilih foto bukti';
        }

        // Cart functions
        function updateQuantity(productId, delta) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    delta: delta
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('❌ ' + (data.message || 'Gagal mengupdate quantity'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan');
            });
        }

        function removeFromCart(productId) {
            if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) return;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('❌ ' + (data.message || 'Gagal menghapus produk'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan');
            });
        }

        // Close modals when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(event) {
                if (event.target === this) {
                    this.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    </script>

</body>
</html>