@extends('layouts.app')

@section('content')
<style>
    /* CSS ADMIN (SAMA DENGAN PAGE LAIN) */
    @keyframes fadeInSlide { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    nav, header { display: none !important; } .py-12, .max-w-7xl { padding: 0 !important; max-width: 100% !important; } .bg-white { background: none !important; box-shadow: none !important; }
    .admin-layout { display: flex; min-height: 100vh; width: 100%; background-color: #E0E0E0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; position: absolute; top: 0; left: 0; z-index: 50; }
    .sidebar { width: 260px; background-color: #E08E21; color: white; display: flex; flex-direction: column; padding: 30px 20px; flex-shrink: 0; }
    .sidebar-logo { display: flex; align-items: center; gap: 15px; margin-bottom: 50px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2); }
    .sidebar-logo img { width: 50px; height: 50px; object-fit: contain; background: white; border-radius: 50%; padding: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .nav-item { display: flex; align-items: center; gap: 15px; padding: 14px 20px; color: white; text-decoration: none; font-weight: 600; margin-bottom: 8px; transition: all 0.3s; border-radius: 12px; font-size: 15px; }
    .nav-item:hover, .nav-item.active { background-color: white; color: #E08E21; transform: translateX(5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .nav-icon { width: 24px; text-align: center; font-size: 18px; }
    .main-content { flex-grow: 1; padding: 40px 50px; overflow-y: auto; animation: fadeInSlide 0.5s ease-out forwards; opacity: 0; }
    .header-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
    .header-title h1 { font-size: 32px; font-weight: 800; color: #333; margin: 0 0 5px 0; }
    .header-title p { color: #666; margin: 0; font-size: 16px; }
    .btn-logout { background-color: #D93F0B; color: white; padding: 10px 30px; border-radius: 50px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; transition: background 0.3s; }
    .btn-logout:hover { background-color: #b93308; }

    /* STYLE KHUSUS REPORT */
    .table-container { background-color: #C0C0C0; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); min-height: 500px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 3px solid #E08E21; display: inline-block; width: 100%; }

    .filter-card { background: white; padding: 25px; border-radius: 12px; display: flex; gap: 20px; align-items: flex-end; margin-bottom: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);flex-wrap: wrap; }
    .filter-group { display: flex; flex-direction: column; gap: 5px; flex: 1; }
    .filter-group label { font-weight: bold; color: #555; font-size: 14px; }
    .filter-input { padding: 10px; border: 1px solid #ccc; border-radius: 8px; width: 100%; }
    .btn-filter { background: #E08E21; color: white; border: none; padding: 10px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; height: 42px; }
    .btn-pdf { background: #dc3545; color: white; text-decoration: none; padding: 10px 25px; border-radius: 8px; font-weight: bold; display: inline-flex; align-items: center; gap: 8px; height: 42px; }
    .btn-pdf:hover { background: #c82333; }

    .custom-table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; margin-top: 20px; }
    .custom-table thead { background-color: #E08E21; color: white; }
    .custom-table th, .custom-table td { padding: 15px 20px; text-align: left; border-bottom: 1px solid #eee; }
    .custom-table th { font-weight: 800; }
    .total-row { background: #ffeeba; font-weight: bold; font-size: 1.1em; color: #856404; }
</style>

<div class="admin-layout">
    <aside class="sidebar">
        <div class="sidebar-logo">@include('filament.admin.logo')</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><span class="nav-icon">🏠</span> Home</a>
        <a href="{{ route('admin.staff.index') }}" class="nav-item"><span class="nav-icon">👥</span> Kelola Staff</a>
        <a href="{{ route('admin.orders.index') }}" class="nav-item"><span class="nav-icon">📦</span> Approve Pesanan</a>
        <a href="{{ route('admin.products.index') }}" class="nav-item"><span class="nav-icon">🛒</span> Kelola Produk</a>
        <a href="{{ route('admin.appointments.index') }}" class="nav-item"><span class="nav-icon">📅</span> Appointment</a>
        <a href="{{ route('admin.messages.index') }}" class="nav-item"><span class="nav-icon">📞</span> Contact Us</a>
        <a href="{{ route('admin.reports.index') }}" class="nav-item active"><span class="nav-icon">📊</span> Laporan</a>
    </aside>

    <main class="main-content">
        <div class="header-section">
            <div class="header-title">
                <h1>Laporan Pendapatan</h1>
                <p>Rekapitulasi penjualan bulanan Petshop Lala</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <div class="table-container">
            <h2 class="page-title">Filter Laporan</h2>

            <div class="filter-card">
                <form action="{{ route('admin.reports.index') }}" method="GET" style="display:flex; gap:15px; flex:1;">
                    <div class="filter-group">
                        <label>Bulan</label>
                        <select name="month" class="filter-input">
                            @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Tahun</label>
                        <select name="year" class="filter-input">
                            @for ($y = date('Y'); $y >= 2023; $y--)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn-filter">Tampilkan</button>
                </form>

                <a href="{{ route('admin.reports.export', ['month' => $month, 'year' => $year]) }}" class="btn-pdf">
                    📥 Download PDF
                </a>
            </div>

            <table class="custom-table">
                <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>No. Order</th>
                    <th>Pelanggan</th>
                    <th>Detail Barang</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                    <td style="font-weight:bold;">#TRX-{{ $trx->transaction_id }}</td>
                    <td>{{ $trx->receiver_name ?? $trx->user->name }}</td>
                    <td>
                        <ul style="padding-left:15px; margin:0; font-size:13px; color:#555;">
                            @foreach($trx->transactionDetails as $item)
                            <li>{{ $item->product->name ?? 'Item' }} (x{{ $item->quantity }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="font-weight:bold;">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:30px;">Tidak ada transaksi di periode ini.</td>
                </tr>
                @endforelse

                @if($transactions->count() > 0)
                <tr class="total-row">
                    <td colspan="4" style="text-align:right;">TOTAL PENDAPATAN:</td>
                    <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </main>
</div>
@include('layouts.footer')
@endsection
