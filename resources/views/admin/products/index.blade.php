@extends('layouts.app')

@section('content')
<style>
    /* ================================================================= */
    /* 1. ANIMASI & RESET                                                */
    /* ================================================================= */
    @keyframes fadeInSlide {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    nav { display: none !important; }
    header { display: none !important; }
    .py-12 { padding: 0 !important; }
    .max-w-7xl { max-width: 100% !important; padding: 0 !important; }
    .bg-white { background: none !important; box-shadow: none !important; }

    /* ================================================================= */
    /* 2. LAYOUT UTAMA                                                   */
    /* ================================================================= */
    .admin-layout {
        display: flex;
        min-height: 100vh;
        width: 100%;
        background-color: #E0E0E0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        position: absolute; top: 0; left: 0; z-index: 50;
    }

    /* SIDEBAR */
    .sidebar {
        width: 260px;
        background-color: #E08E21;
        color: white;
        display: flex; flex-direction: column; padding: 30px 20px; flex-shrink: 0;
    }
    .sidebar-logo {
        display: flex; align-items: center; gap: 15px; margin-bottom: 50px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .sidebar-logo img {
        width: 50px; height: 50px; object-fit: contain; background: white; border-radius: 50%; padding: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .nav-item {
        display: flex; align-items: center; gap: 15px; padding: 14px 20px; color: white; text-decoration: none; font-weight: 600; margin-bottom: 8px; transition: all 0.3s; border-radius: 12px; font-size: 15px;
    }
    .nav-item:hover, .nav-item.active {
        background-color: white; color: #E08E21; transform: translateX(5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .nav-icon { width: 24px; text-align: center; font-size: 18px; }

    /* CONTENT */
    .main-content {
        flex-grow: 1; padding: 40px 50px; overflow-y: auto;
        animation: fadeInSlide 0.5s ease-out forwards; opacity: 0;
    }

    /* HEADER */
    .header-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
    .header-title h1 { font-size: 32px; font-weight: 800; color: #333; margin: 0 0 5px 0; }
    .header-title p { color: #666; margin: 0; font-size: 16px; }
    .btn-logout {
        background-color: #D93F0B; color: white; padding: 10px 30px; border-radius: 50px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; transition: background 0.3s;
    }
    .btn-logout:hover { background-color: #b93308; }

    /* TABLE CONTAINER */
    .table-container {
        background-color: #C0C0C0; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); min-height: 500px;
    }
    .page-title {
        font-size: 24px; font-weight: 800; color: #222; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 3px solid #E08E21; display: inline-block; width: 100%;
    }

    /* ACTIONS (ADD & SEARCH) */
    .actions-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }

    .btn-add {
        background-color: #28a745; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: 0.3s;
    }
    .btn-add:hover { background-color: #218838; transform: translateY(-2px); }

    .search-form { display: flex; gap: 10px; }
    .search-input {
        padding: 10px 15px; border: 1px solid #ddd; border-radius: 8px; width: 250px; font-size: 14px; outline: none; transition: 0.3s;
    }
    .search-input:focus { border-color: #E08E21; box-shadow: 0 0 5px rgba(224, 142, 33, 0.3); }
    .btn-search {
        background-color: #666; color: white; padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: bold; transition: 0.3s;
    }
    .btn-search:hover { background-color: #444; }

    /* TABLE STYLE */
    .custom-table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
    .custom-table thead { background-color: #E08E21; color: white; }
    .custom-table th, .custom-table td { padding: 18px 20px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
    .custom-table th { font-weight: 800; font-size: 15px; text-transform: uppercase; letter-spacing: 0.5px; }
    .custom-table tbody tr:hover { background-color: #f9f9f9; }

    /* BADGES & TEXT */
    .price-tag { font-weight: 800; color: #E08E21; font-size: 15px; }
    .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block; }
    .badge-stock-ok { background: #d4edda; color: #155724; }
    .badge-stock-low { background: #f8d7da; color: #721c24; }

    /* ACTION BUTTONS */
    .action-group { display: flex; gap: 8px; }
    .btn-action { padding: 6px 12px; border-radius: 6px; color: white; font-size: 12px; font-weight: bold; border: none; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; transition: 0.2s; }
    .btn-view { background-color: #17a2b8; } .btn-view:hover { background-color: #138496; }
    .btn-edit { background-color: #ffc107; color: #333; } .btn-edit:hover { background-color: #e0a800; }
    .btn-delete { background-color: #dc3545; } .btn-delete:hover { background-color: #c82333; }

    /* ALERT */
    .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; }
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
        <a href="{{ route('admin.orders.index') }}" class="nav-item">
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
                <h1>Kelola Produk</h1>
                <p>Manajemen barang dan stok toko</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <div class="table-container">
            <h2 class="page-title">Daftar Produk</h2>

            @if (session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
            @endif

            <div class="actions-bar">
                <a href="{{ route('admin.products.create') }}" class="btn-add">
                    + Tambah Produk
                </a>

                <form method="GET" action="{{ route('admin.products.index') }}" class="search-form">
                    <input type="text" name="search" class="search-input" placeholder="Cari nama / kategori..." value="{{ request('search') }}">
                    <button type="submit" class="btn-search">Cari</button>
                </form>
            </div>

            <table class="custom-table">
                <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="25%">Nama Produk</th>
                    <th width="20%">Kategori</th>
                    <th width="20%">Harga</th>
                    <th width="10%">Stok</th>
                    <th width="20%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($products as $product)
                <tr>
                    <td>#{{ $product->product_id }}</td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td><span style="background:#eee; padding:4px 8px; border-radius:4px; font-size:12px; color:#555;">{{ $product->category ?? 'Umum' }}</span></td>
                    <td><span class="price-tag">Rp {{ number_format($product->price, 0, ',', '.') }}</span></td>
                    <td>
                        @if($product->stock > 5)
                        <span class="badge badge-stock-ok">{{ $product->stock }} Unit</span>
                        @else
                        <span class="badge badge-stock-low">{{ $product->stock }} (Low)</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.products.show', $product) }}" class="btn-action btn-view">Lihat</a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn-action btn-edit">Edit</a>

                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding: 40px; color:#666;">
                        <div style="font-size: 40px; margin-bottom: 10px;">📦</div>
                        Belum ada produk. Silakan tambah produk baru.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>

            <div style="margin-top: 20px;">
                {{ $products->links() }}
            </div>
        </div>
        @include('layouts.footer')
    </main>
</div>
@endsection
