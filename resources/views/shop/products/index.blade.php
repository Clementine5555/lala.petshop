@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Pet Shop Products</h1>
            <p class="text-gray-600 text-lg">Discover everything your beloved pets need</p>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('products.shop') }}" class="mb-8">
            <div class="flex gap-4">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search products by name or category..." 
                    class="flex-1 px-6 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-orange-500 transition"
                />
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold transition">
                    Search
                </button>
            </div>
        </form>

        <!-- Products Grid -->
        @if($products->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition overflow-hidden group">
                        <!-- Image Placeholder -->
                        <div class="w-full h-48 bg-gradient-to-br from-orange-200 to-orange-100 flex items-center justify-center overflow-hidden relative">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition">
                            @else
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-orange-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-orange-400 text-sm mt-2">No Image</p>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="mb-3">
                                <span class="inline-block bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full">
                                    {{ $product->category ?? 'Uncategorized' }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description ?? 'High quality product for your pets' }}</p>
                            
                            <div class="flex items-baseline justify-between mb-6">
                                <span class="text-2xl font-bold text-orange-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $product->stock }} in stock
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add to Cart
                                    </button>
                                </form>
                                <a href="{{ route('products.show', $product) }}" class="flex-1 border-2 border-orange-500 text-orange-600 hover:bg-orange-50 font-semibold py-2 rounded-lg transition text-center">
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-lg shadow">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-600 text-lg mb-4">No products found</p>
                <a href="{{ route('products.shop') }}" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 inline-block">
                    Clear Filters
                </a>
            </div>
        @endif
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-bounce">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
