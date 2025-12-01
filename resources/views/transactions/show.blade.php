@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <a href="{{ route('transactions.history') }}" class="text-orange-600 hover:text-orange-800 mb-6 inline-flex items-center">
        ← Back to Transactions
    </a>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Transaction Header -->
        <div class="border-b pb-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-gray-600 text-sm uppercase tracking-wide">Transaction ID</p>
                    <p class="text-2xl font-bold">#{{ $transaction->transaction_id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm uppercase tracking-wide">Order Date</p>
                    <p class="text-lg font-semibold">{{ $transaction->created_at->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm uppercase tracking-wide">Status</p>
                    <p class="inline-block px-4 py-2 rounded-full font-semibold text-sm
                        @if($transaction->status == 'completed') bg-green-100 text-green-800
                        @elseif($transaction->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($transaction->status == 'cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($transaction->status) }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm uppercase tracking-wide">Total Amount</p>
                    <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4">Order Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Product</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Price</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Quantity</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->transactionDetails as $detail)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-4 text-sm">
                                    <a href="{{ route('products.show', $detail->product) }}" class="text-orange-600 hover:text-orange-800 font-semibold">
                                        {{ $detail->product->name }}
                                    </a>
                                    <p class="text-gray-600 text-xs">{{ $detail->product->category }}</p>
                                </td>
                                <td class="px-4 py-4 text-sm text-center">
                                    Rp {{ number_format($detail->price_at_purchase, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-sm text-center">
                                    {{ $detail->quantity }}
                                </td>
                                <td class="px-4 py-4 text-sm text-right font-semibold">
                                    Rp {{ number_format($detail->price_at_purchase * $detail->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
            <h2 class="text-lg font-bold mb-4">Order Summary</h2>
            <div class="space-y-3">
                <div class="flex justify-between text-gray-700">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="flex justify-between text-gray-700">
                    <span>Tax</span>
                    <span>Rp 0</span>
                </div>
                <div class="border-t-2 border-orange-200 pt-3 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span class="text-orange-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex gap-4">
            <a href="{{ route('products.shop') }}" class="flex-1 bg-orange-500 text-white py-3 rounded-lg font-semibold text-center hover:bg-orange-600 transition">
                Continue Shopping
            </a>
            <a href="{{ route('transactions.history') }}" class="flex-1 border border-orange-500 text-orange-600 py-3 rounded-lg font-semibold text-center hover:bg-orange-50 transition">
                Back to History
            </a>
        </div>
    </div>
</div>
@endsection
