@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumb -->
        <a href="{{ route('products.shop') }}" class="text-orange-600 hover:text-orange-800 mb-8 inline-flex items-center gap-2 font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Products
        </a>

        <!-- Product Details -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Image -->
                <div class="flex items-center justify-center bg-gradient-to-br from-orange-100 to-orange-50 rounded-lg h-96">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <div class="text-center">
                            <svg class="w-24 h-24 text-orange-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-orange-400 text-lg mt-4">No Image Available</p>
                        </div>
                    @endif
                </div>

                <!-- Details -->
                <div>
                    <div class="mb-4">
                        <span class="inline-block bg-orange-100 text-orange-700 text-xs font-bold px-4 py-2 rounded-full">
                            {{ $product->category ?? 'Uncategorized' }}
                        </span>
                    </div>

                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                    <div class="flex items-baseline gap-4 mb-6">
                        <span class="text-5xl font-bold text-orange-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                        <span class="text-lg text-gray-600">
                            {{ $product->stock }} available
                        </span>
                    </div>

                    <p class="text-gray-700 text-lg leading-relaxed mb-8">
                        {{ $product->description ?? 'Premium quality product designed for your beloved pets. Trusted by pet owners everywhere.' }}
                    </p>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.store') }}" method="POST" class="mb-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        
                        <div class="flex items-center gap-4 mb-6">
                            <label class="font-semibold text-gray-700">Quantity:</label>
                            <div class="flex items-center border-2 border-gray-300 rounded-lg">
                                <button type="button" class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition" onclick="decreaseQty()">−</button>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    name="quantity" 
                                    value="1" 
                                    min="1" 
                                    max="{{ $product->stock }}"
                                    class="w-16 text-center border-none focus:outline-none font-semibold"
                                >
                                <button type="button" class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition" onclick="increaseQty()">+</button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-lg transition text-lg flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>
                    </form>

                    <a href="{{ route('cart.index') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg transition">
                        View Cart
                    </a>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Review Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Leave a Review</h2>

                    @auth
                        <form action="{{ route('reviews.store', $product->product_id) }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">Rating</label>
                                <div class="flex gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button 
                                            type="button" 
                                            onclick="document.querySelector('input[name=rating]').value = {{ $i }}; updateStars({{ $i }})"
                                            class="text-3xl transition hover:scale-110">
                                            <span id="star-{{ $i }}" class="text-gray-300">★</span>
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" value="5">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold mb-2">Comment</label>
                                <textarea 
                                    name="comment" 
                                    rows="5" 
                                    placeholder="Share your experience with this product..."
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 transition resize-none">
                                </textarea>
                            </div>

                            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg transition">
                                Submit Review
                            </button>
                        </form>
                    @else
                        <p class="text-gray-600 mb-4">Please <a href="{{ route('login') }}" class="text-orange-600 font-semibold hover:underline">log in</a> to leave a review.</p>
                    @endauth
                </div>
            </div>

            <!-- Reviews List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Reviews</h2>

                    @if ($product->reviews->count())
                        <div class="space-y-6">
                            @foreach ($product->reviews as $review)
                                <div class="pb-6 border-b last:border-b-0">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $review->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $review->created_at->format('d F Y') }}</p>
                                        </div>
                                        <div class="text-yellow-400 text-sm">
                                            @for ($i = 0; $i < $review->rate; $i++)
                                                ★
                                            @endfor
                                            @for ($i = $review->rate; $i < 5; $i++)
                                                <span class="text-gray-300">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-700">{{ $review->comment ?? 'No comment provided' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No reviews yet. Be the first to review this product!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-bounce">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
function increaseQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

function decreaseQty() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function updateStars(rating) {
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById(`star-${i}`);
        if (i <= rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    }
}

// Initialize stars
updateStars(5);
</script>
@endsection
