@extends('layouts.app')

@section('content')
<style>
    /* CSS WARISAN DARI DASHBOARD ADMIN */
    @keyframes fadeInSlide { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    nav, header { display: none !important; } .py-12, .max-w-7xl { padding: 0 !important; max-width: 100% !important; } .bg-white { background: none !important; box-shadow: none !important; }

    .admin-layout { display: flex; min-height: 100vh; width: 100%; background-color: #E0E0E0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; position: absolute; top: 0; left: 0; z-index: 50; }
    .sidebar { width: 260px; background-color: #E08E21; color: white; display: flex; flex-direction: column; padding: 30px 20px; flex-shrink: 0; }
    .sidebar-logo { display: flex; align-items: center; gap: 15px; margin-bottom: 50px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2); }
    .sidebar-logo img { width: 50px; height: 50px; object-fit: contain; background: white; border-radius: 50%; padding: 5px; }
    .nav-item { display: flex; align-items: center; gap: 15px; padding: 14px 20px; color: white; text-decoration: none; font-weight: 600; margin-bottom: 8px; transition: all 0.3s; border-radius: 12px; font-size: 15px; }
    .nav-item:hover, .nav-item.active { background-color: white; color: #E08E21; transform: translateX(5px); }
    .nav-icon { width: 24px; text-align: center; }

    .main-content { flex-grow: 1; padding: 40px 50px; overflow-y: auto; animation: fadeInSlide 0.5s ease-out forwards; }

    /* FORM STYLE */
    .form-container { background-color: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 3px solid #E08E21; }

    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
    .form-control { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: 0.3s; }
    .form-control:focus { outline: none; border-color: #E08E21; }

    .btn-submit { background-color: #E08E21; color: white; padding: 12px 30px; border: none; border-radius: 10px; font-weight: bold; cursor: pointer; transition: 0.3s; }
    .btn-submit:hover { background-color: #c57a1a; transform: translateY(-2px); }
    .btn-cancel { background-color: #ccc; color: #333; padding: 12px 30px; border-radius: 10px; text-decoration: none; font-weight: bold; margin-right: 10px; }
</style>

<div class="admin-layout">
    <aside class="sidebar">
        <div class="sidebar-logo">@include('filament.admin.logo')</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><span class="nav-icon">🏠</span> Home</a>
        <a href="{{ route('admin.staff.index') }}" class="nav-item"><span class="nav-icon">👥</span> Kelola Staff</a>
        <a href="{{ route('admin.orders.index') }}" class="nav-item"><span class="nav-icon">📦</span> Approve Pesanan</a>
        <a href="{{ route('admin.products.index') }}" class="nav-item"><span class="nav-icon">🛒</span> Products</a>
        <a href="{{ route('admin.appointments.index') }}" class="nav-item {{ request()->routeIs('admin.appointments.index') ? 'active' : '' }}"><span class="nav-icon">📅</span> Appointment</a>
        <a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages.index') ? 'active' : '' }}"><span class="nav-icon">📞</span> Contact Us</a>
        <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Laporan
        </a>
    </aside>

    <main class="main-content">
        <div class="form-container">
            <h2 class="page-title">Edit Produk: {{ $product->name }}</h2>

            <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>

                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label class="form-label">Kategori</label>
                        <select name="category" class="form-control">
                            <option value="Makanan" {{ $product->category == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Aksesoris" {{ $product->category == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                            <option value="Mainan" {{ $product->category == 'Mainan' ? 'selected' : '' }}>Mainan</option>
                            <option value="Obat" {{ $product->category == 'Obat' ? 'selected' : '' }}>Obat & Vitamin</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Gambar Produk (Opsional)</label>
                    @if($product->image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Preview" style="width: 100px; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <a href="{{ route('admin.products.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
        @include('layouts.footer')
    </main>
</div>
@endsection
