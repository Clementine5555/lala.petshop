@extends('layouts.app')

@section('content')
<style>
    /* ================================================================= */
    /* 1. ANIMASI TRANSISI SMOOTH                                        */
    /* ================================================================= */
    @keyframes fadeInSlide {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ================================================================= */
    /* 2. RESET BAWAAN                                                   */
    /* ================================================================= */
    nav { display: none !important; }
    header { display: none !important; }
    .py-12 { padding: 0 !important; }
    .max-w-7xl { max-width: 100% !important; padding: 0 !important; }
    .bg-white { background: none !important; box-shadow: none !important; }

    /* ================================================================= */
    /* 3. STYLE LAYOUT ADMIN                                             */
    /* ================================================================= */

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
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 50px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .sidebar-logo svg,
    .sidebar-logo img {
        width: 50px;
        height: 50px;
        object-fit: contain;
        background: white;
        border-radius: 50%;
        padding: 5px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .logo-text h2 { font-weight: 800; font-size: 20px; line-height: 1.2; margin: 0; }
    .logo-text span { font-size: 13px; font-weight: 400; opacity: 0.9; }

    /* Menu Sidebar */
    .nav-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 14px 20px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 8px;
        transition: all 0.3s;
        border-radius: 12px;
        font-size: 15px;
    }

    .nav-item:hover, .nav-item.active {
        background-color: white;
        color: #E08E21;
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .nav-icon { width: 24px; text-align: center; font-size: 18px; }

    /* KONTEN KANAN (DENGAN ANIMASI) */
    .main-content {
        flex-grow: 1;
        padding: 40px 50px;
        overflow-y: auto;

        /* Terapkan Animasi disini */
        animation: fadeInSlide 0.6s ease-out forwards;
        opacity: 0; /* Mulai invisible */

        display: flex;
        flex-direction: column;
    }

    /* Header */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 40px;
    }

    .header-title h1 { font-size: 32px; font-weight: 800; color: #333; margin: 0 0 5px 0; }
    .header-title p { color: #666; margin: 0; font-size: 16px; }

    .btn-logout {
        background-color: #D93F0B;
        color: white;
        padding: 10px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
        box-shadow: 0 4px 10px rgba(217, 63, 11, 0.3);
    }
    .btn-logout:hover { background-color: #b93308; }

    /* Dashboard Container */
    .dashboard-overview {
        background-color: #C0C0C0;
        border-radius: 25px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 40px; /* Jarak ke footer */
    }

    .overview-title {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 30px;
        color: #222;
        border-bottom: 3px solid #E08E21;
        display: inline-block;
        padding-bottom: 5px;
        width: 100%;
    }

    /* Grid Statistik */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-bottom: 50px;
    }

    .stat-card {
        background-color: #6D5B4B;
        color: white;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 8px 20px rgba(109, 91, 75, 0.3);
        height: 180px;
        transition: transform 0.3s;
    }
    .stat-card:hover { transform: translateY(-5px); }

    .stat-number { font-size: 56px; font-weight: 800; line-height: 1; margin-bottom: 10px; }
    .stat-label { font-size: 18px; font-weight: 500; opacity: 0.9; }

    /* Recent Activities */
    .recent-section h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #333;
    }

    .activity-item {
        background-color: #E8E8E8;
        padding: 15px 25px;
        border-radius: 12px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 20px;
        border-left: 5px solid #E08E21;
    }

    .activity-icon { font-size: 24px; background: white; width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; border-radius: 50%; }
    .activity-text h4 { margin: 0; font-weight: 700; font-size: 16px; color: #222; }
    .activity-text p { margin: 3px 0 0; font-size: 14px; color: #555; }

</style>

<div class="admin-layout">

    <aside class="sidebar">
        <div class="sidebar-logo">
            @include('filament.admin.logo')
        </div>

        <a href="#" class="nav-item active">
            <span class="nav-icon">🏠</span> Home
        </a>

        <a href="{{ route('admin.staff.index') }}" class="nav-item">
            <span class="nav-icon">👥</span> Kelola Staff
        </a>

        <a href="{{ route('admin.products.index') }}" class="nav-item">
            <span class="nav-icon">🛒</span> Products
        </a>

        <a href="#" class="nav-item"><span class="nav-icon">📅</span> Appointment</a>
        <a href="#" class="nav-item"><span class="nav-icon">📞</span> Contact Us</a>
    </aside>

    <main class="main-content">

        <div class="header-section">
            <div class="header-title">
                <h1>Dashboard Admin</h1>
                <p>Kelola website pet care Anda, Halo <strong>{{ Auth::user()->name }}</strong>!</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <div class="dashboard-overview">
            <h2 class="overview-title">Dashboard Overview</h2>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
                    <div class="stat-label">Total Appointments</div>
                </div>

                <div class="stat-card">
                    <div class="stat-number">{{ $totalProducts ?? 0 }}</div>
                    <div class="stat-label">Products Sold</div>
                </div>

                <div class="stat-card">
                    <div class="stat-number">{{ $totalUsers ?? 0 }}</div>
                    <div class="stat-label">Happy Customers</div>
                </div>

                <div class="stat-card">
                    <div class="stat-number">
                        {{ $totalRevenue > 1000000 ? round($totalRevenue/1000000, 1) . 'M' : number_format($totalRevenue, 0, ',', '.') }}
                    </div>
                    <div class="stat-label">Total Revenue (Rp)</div>
                </div>
            </div>

            <div class="recent-section">
                <h3>Recent Activities</h3>

                <div class="activity-item">
                    <span class="activity-icon">🎉</span>
                    <div class="activity-text">
                        <h4>Appointment baru dari Customer</h4>
                        <p>Pet Grooming - Menunggu konfirmasi.</p>
                    </div>
                </div>

                <div class="activity-item">
                    <span class="activity-icon">🛒</span>
                    <div class="activity-text">
                        <h4>Produk terjual</h4>
                        <p>Transaksi berhasil diproses.</p>
                    </div>
                </div>

                <div class="activity-item">
                    <span class="activity-icon">📧</span>
                    <div class="activity-text">
                        <h4>Pesan baru dari customer</h4>
                        <p>Pertanyaan tentang layanan Pet Hotel.</p>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')

    </main>
</div>
@endsection
