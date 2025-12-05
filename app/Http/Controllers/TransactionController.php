<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('transactionDetails.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.history', compact('transactions'));
    }

    public function show($id)
    {
        // Use 'id' unless you are 100% sure your DB uses 'transaction_id'
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('id', $id) 
            ->with('transactionDetails.product')
            ->firstOrFail();
            
        return view('transactions.show', compact('transaction'));
    }

    public function showCheckoutPage()
    {       
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('products.shop')
                ->with('error', 'Keranjang belanja kosong, silakan belanja dulu.');
        }

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('transactions.checkout', compact('cartItems', 'total')); 
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'address'    => 'required|string',
            'phone'      => 'required|numeric',
            'city'       => 'required|string',
            'postal_code'=> 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang kosong.');
            }

            // Construct full address
            $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->postal_code;

            // Create Transaction
            // FIX: Removed 'transaction_date' (uses created_at)
            // FIX: Changed 'total_amount' to 'total_price' (standard convention)
            $transaction = Transaction::create([
                'user_id'          => Auth::id(),
                'status'           => 'pending',
                'total_price'      => 0, 
                'receiver_name'    => $request->first_name . ' ' . $request->last_name,
                'receiver_address' => $fullAddress,
                'receiver_phone'   => $request->phone,
            ]);

            $totalAmount = 0;

            foreach ($cartItems as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok produk {$item->product->name} tidak mencukupi.");
                }

                $subtotal = $item->product->price * $item->quantity;
                $totalAmount += $subtotal;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id, // FIX: Use ->id
                    'product_id'     => $item->product_id,
                    'quantity'       => $item->quantity,
                    'price'          => $item->product->price,
                ]);
                
                $item->product->decrement('stock', $item->quantity);
            }

            // FIX: Update 'total_price'
            $grandTotal = $totalAmount + 15000; // Add shipping
            $transaction->update(['total_price' => $grandTotal]);

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // Redirect to success page
            return redirect()->route('checkout.success', ['id' => $transaction->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }
    
    // Add the success method
    public function success($id)
    {
        return view('transactions.success');
    }
}