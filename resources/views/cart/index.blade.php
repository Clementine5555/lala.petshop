@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if ($cartItems->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-600 text-lg mb-4">Your cart is empty</p>
            <a href="{{ route('products.shop') }}" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @foreach ($cartItems as $item)
                        <div class="p-6 border-b flex gap-6 items-start">
                            <!-- Product Image Placeholder -->
                            <div class="w-24 h-24 bg-gray-200 rounded-lg flex-shrink-0">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold">{{ $item->product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $item->product->category }}</p>
                                <p class="text-orange-600 font-bold">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>

                                <!-- Quantity & Actions -->
                                <div class="flex items-center gap-4 mt-4">
                                    <form action="{{ route('cart.update', $item->cart_id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 border rounded px-2 py-1 text-center">
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Update</button>
                                    </form>

                                    <form action="{{ route('cart.destroy', $item->cart_id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Remove from cart?')">Remove</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-right">
                                <p class="text-lg font-bold">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-orange-50 rounded-lg p-6 border border-orange-200 sticky top-4">
                    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('checkout') }}" method="POST" class="mb-4">
                        @csrf
                        <!-- Pass cart items to checkout -->
                        <input type="hidden" name="products" value="{{ json_encode($cartItems->map(fn($item) => ['id' => $item->product_id, 'quantity' => $item->quantity])->toArray()) }}">
                        <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-lg font-semibold hover:bg-orange-600 transition">
                            Proceed to Checkout
                        </button>
                    </form>

                    <a href="{{ route('products.shop') }}" class="block w-full text-center text-orange-600 hover:text-orange-800 font-medium">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@if (session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
@endif
@endsection
