@extends('layouts.app')

@section('content')
<style>
    /* COPY STYLE DARI ADMIN STAFF AGAR TEMA KONSISTEN */
    @keyframes fadeInSlide { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    nav { display: none !important; } header { display: none !important; } .py-12 { padding: 0 !important; } .max-w-7xl { max-width: 100% !important; padding: 0 !important; } .bg-white { background: none !important; box-shadow: none !important; }

    .admin-layout { display: flex; min-height: 100vh; width: 100%; background-color: #E0E0E0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; position: absolute; top: 0; left: 0; z-index: 50; }

    /* SIDEBAR */
    .sidebar { width: 260px; background-color: #E08E21; color: white; display: flex; flex-direction: column; padding: 30px 20px; flex-shrink: 0; }
    .sidebar-logo { display: flex; align-items: center; gap: 15px; margin-bottom: 50px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2); }
    .sidebar-logo svg, .sidebar-logo img { width: 50px; height: 50px; object-fit: contain; background: white; border-radius: 50%; padding: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .logo-text h2 { font-weight: 800; font-size: 20px; line-height: 1.2; margin: 0; }
    .logo-text span { font-size: 13px; font-weight: 400; opacity: 0.9; }
    .nav-item { display: flex; align-items: center; gap: 15px; padding: 14px 20px; color: white; text-decoration: none; font-weight: 600; margin-bottom: 8px; transition: all 0.3s; border-radius: 12px; font-size: 15px; }
    .nav-item:hover, .nav-item.active { background-color: white; color: #E08E21; transform: translateX(5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .nav-icon { width: 24px; text-align: center; font-size: 18px; }

    /* CONTENT */
    .main-content { flex-grow: 1; padding: 40px 50px; overflow-y: auto; animation: fadeInSlide 0.5s ease-out forwards; opacity: 0; }
    .header-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
    .header-title h1 { font-size: 32px; font-weight: 800; color: #333; margin: 0 0 5px 0; }
    .header-title p { color: #666; margin: 0; font-size: 16px; }
    .btn-logout { background-color: #D93F0B; color: white; padding: 10px 30px; border-radius: 50px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; transition: background 0.3s; }
    .btn-logout:hover { background-color: #b93308; }

    /* TABLE */
    .table-container { background-color: #C0C0C0; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); min-height: 500px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 3px solid #E08E21; display: inline-block; width: 100%; }

    .staff-table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
    .staff-table thead { background-color: #E08E21; color: white; }
    .staff-table th, .staff-table td { padding: 18px 20px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
    .staff-table th { font-weight: 800; font-size: 15px; }
    .staff-table tbody tr:hover { background-color: #f9f9f9; }

    .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
    .badge-payment { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }

    .btn-approve { background-color: #28a745; color: white; padding: 8px 16px; border-radius: 6px; font-weight: bold; border: none; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: 0.3s; font-size: 13px; }
    .btn-approve:hover { background-color: #218838; transform: translateY(-2px); }

    .item-list { font-size: 13px; color: #555; }
    .price-text { font-weight: 800; color: #E08E21; font-size: 15px; }
</style>

<div class="admin-layout">

    <aside class="sidebar">
        <div class="sidebar-logo">
            @include('filament.admin.logo')
        </div>

        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <span class="nav-icon">🏠</span> Home
        </a>
        <a href="{{ route('admin.staff.index') }}" class="nav-item">
            <span class="nav-icon">👥</span> Kelola Staff
        </a>

        <a href="{{ route('admin.orders.index') }}" class="nav-item active">
            <span class="nav-icon">📦</span> Approve Pesanan
        </a>

        <a href="{{ route('admin.products.index') }}" class="nav-item">
            <span class="nav-icon">🛒</span> Products
        </a>
        <a href="{{ route('admin.appointments.index') }}" class="nav-item {{ request()->routeIs('admin.appointments.index') ? 'active' : '' }}">
            <span class="nav-icon">📅</span> Appointment
        </a>
        <a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages.index') ? 'active' : '' }}">
            <span class="nav-icon">📞</span> Contact Us
        </a>
        <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Laporan
        </a>
    </aside>

    <main class="main-content">

        <div class="header-section">
            <div class="header-title">
                <h1>Approve Pesanan</h1>
                <p>Verifikasi pesanan masuk sebelum diteruskan ke Kurir</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <div class="table-container">
            <h2 class="page-title">Pesanan Menunggu Konfirmasi</h2>

            @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ✅ {{ session('success') }}
            </div>
            @endif

            <table class="staff-table">
                <thead>
                <tr>
                    <th width="15%">Order ID</th>
                    <th width="20%">Customer</th>
                    <th width="25%">Detail Barang</th>
                    <th width="15%">Total & Bayar</th>
                    <th width="15%">Alamat</th>
                    <th width="10%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <strong>#TRX-{{ $order->transaction_id }}</strong><br>
                        <span style="font-size:12px; color:#888">{{ $order->created_at->format('d M Y H:i') }}</span>
                    </td>
                    <td>
                        <strong>{{ $order->receiver_name }}</strong><br>
                        <span style="font-size:13px; color:#666">{{ $order->receiver_phone }}</span>
                    </td>
                    <td>
                        <div class="item-list">
                            @foreach($order->transactionDetails as $item)
                            <div>• {{ $item->product->name ?? 'Produk' }} (x{{ $item->quantity }})</div>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="price-text">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        <span class="badge badge-payment">{{ $order->payment->payment_method ?? 'Transfer' }}</span>
                    </td>
                    <td>
                        <div style="font-size: 13px; line-height: 1.4;">
                            {{ Str::limit($order->receiver_address, 50) }}
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('admin.orders.approve', $order->transaction_id) }}" method="POST" onsubmit="return confirm('Setujui pesanan ini dan teruskan ke Kurir?');">
                            @csrf
                            <button type="submit" class="btn-approve">
                                ✅ Approve
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center; padding: 40px; color:#666;">
                        <div style="font-size: 40px; margin-bottom: 10px;">📭</div>
                        Tidak ada pesanan baru yang menunggu konfirmasi.
                    </td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @include('layouts.footer')
    </main>
</div>
@endsection
