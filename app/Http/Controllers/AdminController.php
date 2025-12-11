<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Hitung Statistik
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $totalOrders = Transaction::count();

        // Hitung Pendapatan (Hanya yang statusnya sukses/proses, abaikan pending/batal)
        $totalRevenue = Transaction::whereNotIn('status', ['pending', 'cancelled'])
            ->sum('total_price');

        // 2. Kirim data ke View
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalOrders',
            'totalRevenue'
        ));
    }
}
