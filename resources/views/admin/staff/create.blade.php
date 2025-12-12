@extends('layouts.app')

@section('content')
<style>
    /* 1. RESET & HIDE NAVBAR */
    nav { display: none !important; }
    header { display: none !important; }
    .py-12 { padding: 0 !important; }
    .max-w-7xl { max-width: 100% !important; padding: 0 !important; }
    .bg-white { background: none !important; box-shadow: none !important; }

    /* 2. LAYOUT UTAMA */
    .admin-layout {
        display: flex;
        min-height: 100vh;
        width: 100%;
        background-color: #E0E0E0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 50;
    }

    /* SIDEBAR */
    .sidebar {
        width: 260px;
        background-color: #E08E21;
        color: white;
        display: flex;
        flex-direction: column;
        padding: 30px 20px;
        flex-shrink: 0;
    }
    .sidebar-logo {
        display: flex; align-items: center; gap: 15px; margin-bottom: 50px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .sidebar-logo svg, .sidebar-logo img {
        width: 50px; height: 50px; object-fit: contain; background: white; border-radius: 50%; padding: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .logo-text h2 { font-weight: 800; font-size: 20px; line-height: 1.2; margin: 0; }
    .logo-text span { font-size: 13px; font-weight: 400; opacity: 0.9; }

    .nav-item {
        display: flex; align-items: center; gap: 15px; padding: 14px 20px; color: white; text-decoration: none; font-weight: 600; margin-bottom: 8px; transition: all 0.3s; border-radius: 12px; font-size: 15px;
    }
    .nav-item:hover, .nav-item.active {
        background-color: white; color: #E08E21; transform: translateX(5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .nav-icon { width: 24px; text-align: center; font-size: 18px; }

    /* KONTEN */
    .main-content { flex-grow: 1; padding: 40px 50px; overflow-y: auto; display: flex; flex-direction: column; }

    /* FORM CONTAINER (Mirip Gambar) */
    .form-container {
        background-color: #C0C0C0;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        max-width: 800px;
        width: 100%;
        margin: 0 auto; /* Tengah */
    }

    .form-title {
        font-size: 24px;
        font-weight: 800;
        color: #222;
        margin-bottom: 30px;
        padding-bottom: 10px;
        border-bottom: 3px solid #E08E21;
        display: inline-block;
        width: 100%;
    }

    /* Input Style */
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-weight: 700; margin-bottom: 8px; color: #333; }
    .form-input {
        width: 100%;
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #ccc; /* Border default */
        background: #f9f9f9;
        font-size: 15px;
        outline: none;
        transition: 0.3s;
    }
    .form-input:focus {
        border-color: #E08E21; /* Fokus Oranye */
        background: white;
        box-shadow: 0 0 0 3px rgba(224, 142, 33, 0.2);
    }

    /* Tombol */
    .btn-group { display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px; }
    .btn-cancel {
        padding: 12px 25px; border-radius: 8px; font-weight: bold; text-decoration: none; color: #555; background: #e0e0e0; transition: 0.3s;
    }
    .btn-cancel:hover { background: #d0d0d0; color: #333; }

    .btn-submit {
        padding: 12px 30px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer; color: white; background: #E08E21; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: 0.3s;
    }
    .btn-submit:hover { background: #c57610; transform: translateY(-2px); }

</style>

<div class="admin-layout">

    <aside class="sidebar">
        <div class="sidebar-logo">
            @include('filament.admin.logo')
            <div class="logo-text">
                <h2>PetShop Lala</h2>
                <span>Admin Dashboard</span>
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <span class="nav-icon">🏠</span> Home
        </a>
        <a href="{{ route('admin.staff.index') }}" class="nav-item active">
            <span class="nav-icon">👥</span> Kelola Staff
        </a>
        <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
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

        <div class="form-container">
            <h2 class="form-title">Tambah Staff Baru</h2>

            <form action="{{ route('admin.staff.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" placeholder="Contoh: Budi Santoso" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-input" placeholder="email@petshop.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Handphone</label>
                        <input type="text" name="phone" class="form-input" placeholder="0812..." required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Posisi (Role)</label>
                    <select name="role" class="form-input" style="cursor: pointer;">
                        <option value="courier">🚚 Kurir (Pengiriman)</option>
                        <option value="groomer">✂️ Groomer (Perawatan Hewan)</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" placeholder="********" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="********" required>
                    </div>
                </div>

                <div class="btn-group">
                    <a href="{{ route('admin.staff.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan Data Staff</button>
                </div>

            </form>
        </div>

        @include('layouts.footer')

    </main>
</div>
@endsection
