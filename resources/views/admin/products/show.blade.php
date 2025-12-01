@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $product->name }}
                </h1>
                <div class="space-x-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Edit
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                        Back
                    </a>
                </div>
            </div>

            <div class="p-6 grid grid-cols-2 gap-4">
                <!-- Product ID -->
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Product ID</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $product->product_id }}</p>
                </div>

                <!-- Category -->
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Category</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $product->category ?? 'N/A' }}</p>
                </div>

                <!-- Price -->
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Price</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($product->price, 2) }}</p>
                </div>

                <!-- Stock -->
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Stock</p>
                    <p class="text-lg font-bold">
                        <span class="px-3 py-1 rounded {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stock }} units
                        </span>
                    </p>
                </div>

                <!-- Supplier -->
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Supplier</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        @if ($product->supplier)
                            {{ $product->supplier->name }}
                        @else
                            No supplier assigned
                        @endif
                    </p>
                </div>

                <!-- Created At -->
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Created At</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $product->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>

            <!-- Description -->
            @if ($product->description)
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Description</p>
                    <p class="text-gray-900 dark:text-gray-100">{{ $product->description }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
