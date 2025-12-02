<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart - Petshop Lala</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding-top: 80px;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 9999;
            padding: 10px 0;
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
            text-decoration: none;
        }

        .logo img {
            width: 32px;
            height: 32px;
        }

        .logo span {
            font-weight: 900;
            color: #FF8C42;
            font-size: 1.2em;
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

        .nav-links a:hover {
            color: #FF8C42;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Cart Page */
        .cart-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .cart-header {
            margin-bottom: 40px;
        }

        .cart-header h1 {
            font-size: 2.5em;
            color: #333;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .cart-empty {
            text-align: center;
            padding: 80px 20px;
        }

        .cart-empty p {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 20px;
        }

        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
        }

        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .cart-items {
            background: white;
            border-radius: 20px;
            padding: 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .cart-item {
            padding: 25px;
            border-bottom: 1px solid #f0f0f0;
            display: grid;
            grid-template-columns: 120px 1fr auto;
            gap: 20px;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 120px;
            height: 120px;
            background: #f9f9f9;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 0.9em;
            text-align: center;
        }

        .item-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .item-details h3 {
            font-size: 1.2em;
            color: #333;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .item-category {
            color: #999;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .item-price {
            color: #FF8C42;
            font-weight: 700;
            font-size: 1.1em;
            margin-bottom: 15px;
        }

        .item-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .quantity-input {
            width: 70px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
        }

        .btn-update, .btn-remove {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9em;
        }

        .btn-update {
            background: #007bff;
            color: white;
        }

        .btn-update:hover {
            background: #0056b3;
        }

        .btn-remove {
            background: #dc3545;
            color: white;
        }

        .btn-remove:hover {
            background: #c82333;
        }

        .item-total {
            text-align: right;
            font-weight: 700;
            font-size: 1.2em;
            color: #333;
            min-width: 150px;
        }

        /* Order Summary */
        .order-summary {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .summary-title {
            font-size: 1.4em;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            color: #666;
        }

        .summary-row.total {
            border-bottom: none;
            border-top: 2px solid #FF8C42;
            padding-top: 15px;
            font-weight: 700;
            font-size: 1.1em;
            color: #333;
        }

        .checkout-btn {
            width: 100%;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-size: 1em;
            font-weight: 700;
            cursor: pointer;
            margin-top: 25px;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
        }

        .continue-shopping {
            width: 100%;
            text-align: center;
            margin-top: 15px;
            color: #FF8C42;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .continue-shopping:hover {
            color: #FF6B35;
        }

        @media (max-width: 768px) {
            .cart-container {
                grid-template-columns: 1fr;
            }

            .order-summary {
                position: static;
            }

            .cart-item {
                grid-template-columns: 100px 1fr;
            }

            .item-total {
                grid-column: 2;
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
                <li><a href="{{ route('products.shop') }}">Shop</a></li>
            </ul>

            <div class="nav-right">
                @auth
                    <span>{{ Auth::user()->name }}</span>
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

    <!-- Cart Page -->
    <div class="cart-page">
        <div class="cart-header">
            <h1>🛒 Shopping Cart</h1>
        </div>

        @if ($cartItems->isEmpty())
            <div class="cart-empty">
                <p>Your cart is empty</p>
                <a href="{{ route('products.shop') }}" class="btn-primary">Continue Shopping</a>
            </div>
        @else
            <div class="cart-container">
                <!-- Cart Items -->
                <div class="cart-items">
                    @foreach ($cartItems as $item)
                        <div class="cart-item">
                            <div class="item-image">
                                @if ($item->product->image)
                                    <img src="{{ asset('images/' . ($item->product->image ?? 'default.png')) }}" alt="{{ $item->product->name }}">
                                @else
                                    No Image
                                @endif
                            </div>

                            <div class="item-details">
                                <h3>{{ $item->product->name }}</h3>
                                <p class="item-category">{{ $item->product->category }}</p>
                                <p class="item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                
                                <div class="item-actions">
                                    <form action="{{ route('cart.update', $item->cart_id) }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="quantity-input">
                                        <button type="submit" class="btn-update">Update</button>
                                    </form>

                                    <form action="{{ route('cart.destroy', $item->cart_id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove" onclick="return confirm('Remove from cart?')">Remove</button>
                                    </form>
                                </div>
                            </div>

                            <div class="item-total">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <h2 class="summary-title">Order Summary</h2>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.process') }}" class="checkout-btn" style="text-align: center; display: block;">
                        Proceed to Checkout
                    </a>
                    <a href="{{ route('products.shop') }}" class="continue-shopping">← Continue Shopping</a>
                </div>
            </div>
        @endif
    </div>

</body>
</html>
