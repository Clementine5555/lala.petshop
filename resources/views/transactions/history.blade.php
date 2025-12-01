@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Transaction History</h1>

    @if ($transactions->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <p class="text-gray-600 text-lg mb-4">No transactions yet</p>
            <a href="{{ route('products.shop') }}" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">
                Start Shopping
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($transactions as $transaction)
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-gray-600 text-sm">Transaction ID</p>
                            <p class="font-bold">#{{ $transaction->transaction_id }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Date</p>
                            <p class="font-semibold">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Status</p>
                            <p class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                @if($transaction->status == 'completed') bg-green-100 text-green-800
                                @elseif($transaction->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($transaction->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($transaction->status) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Total</p>
                            <p class="text-lg font-bold text-orange-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Items Preview -->
                    <div class="bg-gray-50 rounded p-4 mb-4">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Items:</p>
                        <div class="space-y-2">
                            @foreach ($transaction->transactionDetails as $detail)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $detail->product->name }} x{{ $detail->quantity }}</span>
                                    <span class="font-semibold">Rp {{ number_format($detail->price_at_purchase * $detail->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('transactions.show', $transaction->transaction_id) }}" class="text-orange-600 hover:text-orange-800 font-semibold">
                        View Details →
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
