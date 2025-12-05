<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - Petshop Lala</title>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f5f5f5; padding-top: 100px; }

        nav { position: fixed; top: 0; width: 100%; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000; padding: 20px 0; }
        .nav-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; padding: 0 50px; }
        .logo { display: flex; align-items: center; gap: 12px; text-decoration: none; font-weight: 700; color: #FF8C42; font-size: 1.4em; }
        .logo img { width: 45px; height: 45px; border-radius: 50%; }

        .checkout-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .checkout-header h1 { font-size: 2.5em; color: #333; margin-bottom: 10px; }
        
        .checkout-content { 
            display: grid; 
            grid-template-columns: 1.5fr 1fr; 
            gap: 30px; 
        }

        .checkout-form, .order-summary { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-control { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .order-item { display: flex; gap: 15px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .order-item img { width: 60px; height: 60px; border-radius: 8px; background: #f9f9f9; object-fit: contain; }
        
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .total { font-size: 1.3em; font-weight: 700; color: #FF8C42; border-top: 2px solid #eee; padding-top: 15px; margin-top: 15px; }

        .btn-place-order { 
            width: 100%; padding: 15px; background: #FF8C42; color: white; 
            border: none; border-radius: 30px; font-size: 1.1em; font-weight: 700; 
            cursor: pointer; margin-top: 20px; transition: 0.3s; 
        }
        .btn-place-order:hover { background: #e67e3b; }

        @media (max-width: 900px) {
            .checkout-content { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <nav>
        <div class="nav-container">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('images/logoo.png') }}" alt="Logo">
                <span>Petshop Lala</span>
            </a>
        </div>
    </nav>

    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Checkout</h1>
        </div>

        <div class="checkout-content">
            <div class="checkout-form">
                @if ($errors->any())
                    <div style="background:#fee2e2; color:#b91c1c; padding:15px; border-radius:10px; margin-bottom:20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="checkoutForm" action="{{ route('checkout.submit') }}" method="POST">
                    @csrf
                    <h3>Shipping Info</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name*</label>
                            <input type="text" name="first_name" class="form-control" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name*</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email*</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    </div>

                    <div class="form-group">
                        <label>Phone*</label>
                        <input type="tel" name="phone" class="form-control" value="{{ Auth::user()->phone }}" required>
                    </div>

                    <div class="form-group">
                        <label>Address*</label>
                        <textarea name="address" class="form-control" required></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>City*</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Postal Code*</label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>
                    </div>
                </form>
            </div>

            <div class="order-summary">
                <h2>Order Summary</h2>
                @if(isset($cartItems) && count($cartItems) > 0)
                    @foreach($cartItems as $item)
                    <div class="order-item">
                        <img src="{{ $item->product->image ? asset('images/'.$item->product->image) : asset('images/default.png') }}">
                        <div>
                            <div style="font-weight:600;">{{ $item->product->name }}</div>
                            <div style="color:#666; font-size:0.9em;">
                                {{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                    @endforeach

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
                        <span>Rp {{ number_format($total + 15000, 0, ',', '.') }}</span>
                    </div>

                    <button type="button" class="btn-place-order" onclick="document.getElementById('checkoutForm').submit()">
                        Place Order
                    </button>
                @else
                    <p>Cart is empty.</p>
                @endif
            </div>
        </div>
    </div>

</body>
</html>