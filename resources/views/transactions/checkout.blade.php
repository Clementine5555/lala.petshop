<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - Petshop Lala</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding-top: 100px;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            padding: 20px 0;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 50px;
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

        /* Checkout Container */
        .checkout-container {
            max-width: 1400px;
            margin: 50px auto;
            padding: 0 50px;
        }

        .checkout-header {
            margin-bottom: 40px;
        }

        .checkout-header h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 10px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #999;
            font-size: 0.95em;
        }

        .breadcrumb a {
            color: #FF8C42;
            text-decoration: none;
        }

        .checkout-content {
            display: grid;
            grid-template-columns: 1fr 450px;
            gap: 30px;
        }

        /* Checkout Form */
        .checkout-form {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .form-section {
            margin-bottom: 35px;
        }

        .form-section h2 {
            font-size: 1.6em;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1em;
        }

        .form-group label .required {
            color: #dc2626;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1em;
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
            min-height: 100px;
        }

        /* Payment Methods */
        .payment-methods {
            display: grid;
            gap: 15px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-option:hover {
            border-color: #FF8C42;
            background: rgba(255, 140, 66, 0.05);
        }

        .payment-option input[type="radio"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .payment-option.selected {
            border-color: #FF8C42;
            background: rgba(255, 140, 66, 0.1);
        }

        .payment-info {
            flex: 1;
        }

        .payment-info h4 {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 5px;
        }

        .payment-info p {
            color: #999;
            font-size: 0.9em;
        }

        /* Order Summary */
        .order-summary {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            height: fit-content;
            position: sticky;
            top: 120px;
        }

        .order-summary h2 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .order-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item-image {
            width: 70px;
            height: 70px;
            background: #f9f9f9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .order-item-image img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .order-item-info {
            flex: 1;
        }

        .order-item-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .order-item-details {
            display: flex;
            justify-content: space-between;
            color: #666;
            font-size: 0.95em;
        }

        .order-item-price {
            font-weight: 700;
            color: #FF8C42;
        }

        .summary-divider {
            height: 2px;
            background: #f0f0f0;
            margin: 25px 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 1.05em;
        }

        .summary-row.total {
            font-size: 1.5em;
            font-weight: 700;
            color: #FF8C42;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .btn-place-order {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 1.2em;
            font-weight: 700;
            cursor: pointer;
            margin-top: 25px;
            transition: all 0.3s;
        }

        .btn-place-order:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 140, 66, 0.4);
        }

        .security-note {
            text-align: center;
            margin-top: 20px;
            color: #999;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        @media (max-width: 992px) {
            .checkout-content {
                grid-template-columns: 1fr;
            }

            .order-summary {
                position: static;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-container,
            .checkout-container {
                padding: 0 20px;
            }

            .checkout-form,
            .order-summary {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ccircle cx='50' cy='50' r='45' fill='%23FF8C42'/%3E%3Cpath d='M50 30c-8 0-15 5-15 12 0 4 2 7 5 9-2 1-3 3-3 5 0 3 3 6 8 6h10c5 0 8-3 8-6 0-2-1-4-3-5 3-2 5-5 5-9 0-7-7-12-15-12z' fill='white'/%3E%3C/svg%3E" alt="Petshop Lala">
                <span>Petshop Lala</span>
            </a>
        </div>
    </nav>

    <!-- Checkout Container -->
    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Checkout</h1>
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Home</a>
                <span>/</span>
                <a href="{{ route('cart.index') }}">Cart</a>
                <span>/</span>
                <span>Checkout</span>
            </div>
        </div>

        <div class="checkout-content">
            <!-- Checkout Form -->
            <div class="checkout-form">
                <form id="checkoutForm" action="{{ route('checkout.submit') }}" method="POST">
                    @csrf
                    
                    <!-- Shipping Information -->
                    <div class="form-section">
                        <h2>Shipping Information</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>First Name <span class="required">*</span></label>
                                <input type="text" name="first_name" class="form-control" value="{{ Auth::user()->name ?? '' }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Last Name <span class="required">*</span></label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Email Address <span class="required">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email ?? '' }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Phone Number <span class="required">*</span></label>
                            <input type="tel" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Complete Address <span class="required">*</span></label>
                            <textarea name="address" class="form-control" placeholder="Street address, city, postal code" required></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>City <span class="required">*</span></label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Postal Code <span class="required">*</span></label>
                                <input type="text" name="postal_code" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="form-section">
                        <h2>Payment Method</h2>
                        
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <div class="payment-info">
                                    <h4>💵 Cash on Delivery</h4>
                                    <p>Bayar ketika sudah diterima kepada Kurir</p>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="bank">
                                <div class="payment-info">
                                    <h4>🏦 Bank Transfer</h4>
                                    <p>Transfer ke rekening bank kami</p>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="ewallet">
                                <div class="payment-info">
                                    <h4>📱 E-Wallet</h4>
                                    <p>Bayar menggunakan GoPay, OVO, Dana, dll.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="form-section">
                        <h2>Order Notes (Optional)</h2>
                        
                        <div class="form-group">
                            <label>Additional Notes</label>
                            <textarea name="notes" class="form-control" placeholder="Any special instructions for your order?"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h2>Order Summary</h2>
                
                {{-- LOGIC BARU: Cek variabel $cartItems (dari Database), BUKAN session --}}
                @if(isset($cartItems) && count($cartItems) > 0)
                    
                    @foreach($cartItems as $item)
                    <div class="order-item">
                        <div class="order-item-image">
                            {{-- Pastikan folder gambar sesuai, pakai placeholder kalau null --}}
                            <img src="{{ $item->product->image ? asset('images/' . $item->product->image) : 'https://via.placeholder.com/70' }}" 
                                alt="{{ $item->product->name }}">
                        </div>
                        <div class="order-item-info">
                            {{-- Akses data sebagai OBJECT (pakai tanda panah ->) --}}
                            <div class="order-item-name">{{ $item->product->name }}</div>
                            <div class="order-item-details">
                                <span>Qty: {{ $item->quantity }}</span>
                                <span class="order-item-price">
                                    Rp {{ number_format(($item->product->price * $item->quantity), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Rp 15.000</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        {{-- Total + Ongkir --}}
                        <span>Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                    </div>           
                    
                    {{-- Tombol Submit Order --}}
                    <button type="button" class="btn-place-order" onclick="submitCheckout()">
                        Place Order
                    </button>

                @else
                    {{-- Pesan kalau keranjang benar-benar kosong --}}
                    <p>Keranjang belanja kosong.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Payment method selection
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Submit checkout
        function submitCheckout() {
            const form = document.getElementById('checkoutForm');
            if (form.checkValidity()) {
                form.submit();
            } else {
                form.reportValidity();
            }
        }
    </script>

</body>
</html>