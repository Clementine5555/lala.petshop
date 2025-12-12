@extends('layouts.app')

@section('content')
<style>
    /* CONSISTENT ADMIN THEME STYLES */
    @keyframes fadeInSlide { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    nav, header { display: none !important; } .py-12, .max-w-7xl { padding: 0 !important; max-width: 100% !important; } .bg-white { background: none !important; box-shadow: none !important; }

    .admin-layout { display: flex; min-height: 100vh; width: 100%; background-color: #E0E0E0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; position: absolute; top: 0; left: 0; z-index: 50; }

    /* SIDEBAR */
    .sidebar { width: 260px; background-color: #E08E21; color: white; display: flex; flex-direction: column; padding: 30px 20px; flex-shrink: 0; }
    .sidebar-logo { display: flex; align-items: center; gap: 15px; margin-bottom: 50px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2); }
    .sidebar-logo svg, .sidebar-logo img { width: 50px; height: 50px; object-fit: contain; background: white; border-radius: 50%; padding: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
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

    .custom-table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
    .custom-table thead { background-color: #E08E21; color: white; }
    .custom-table th, .custom-table td { padding: 18px 20px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
    .custom-table th { font-weight: 800; font-size: 15px; }
    .custom-table tbody tr:hover { background-color: #f9f9f9; }

    /* BUTTONS */
    .btn-action { padding: 8px 16px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: 0.2s; gap: 5px; }
    .btn-view { background-color: #17a2b8; color: white; } .btn-view:hover { background-color: #138496; }
    .btn-delete { background-color: #dc3545; color: white; } .btn-delete:hover { background-color: #c82333; }

    /* MODAL */
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; }
    .modal.active { display: flex; }
    .modal-content { background: white; border-radius: 20px; width: 100%; max-width: 600px; padding: 30px; animation: slideUp 0.3s; }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-header h2 { margin: 0 0 10px 0; color: #E08E21; border-bottom: 2px solid #eee; padding-bottom: 10px; }

    .msg-meta { display: grid; grid-template-columns: 100px 1fr; gap: 10px; margin-bottom: 15px; font-size: 14px; }
    .msg-label { font-weight: bold; color: #666; }
    .msg-body { background: #f9f9f9; padding: 15px; border-radius: 10px; border: 1px solid #eee; min-height: 100px; white-space: pre-wrap; margin-bottom: 20px; }
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

        <div class="header-section">
            <div class="header-title">
                <h1>Kotak Masuk</h1>
                <p>Pesan dari pelanggan melalui form Contact Us</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <div class="table-container">
            <h2 class="page-title">Daftar Pesan</h2>

            @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ✅ {{ session('success') }}
            </div>
            @endif

            <table class="custom-table">
                <thead>
                <tr>
                    <th width="20%">Pengirim</th>
                    <th width="20%">Subjek</th>
                    <th width="35%">Pesan (Preview)</th>
                    <th width="15%">Tanggal</th>
                    <th width="10%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($messages as $msg)
                <tr>
                    <td>
                        <strong>{{ $msg->name }}</strong><br>
                        <span style="font-size:12px; color:#666">{{ $msg->email }}</span>
                    </td>
                    <td>{{ $msg->subject ?? '(Tanpa Subjek)' }}</td>
                    <td>
                        <span style="color:#555">{{ Str::limit($msg->message, 50) }}</span>
                    </td>
                    <td>
                        <div style="font-size:13px;">{{ $msg->created_at->format('d M Y') }}</div>
                        <div style="font-size:11px; color:#888">{{ $msg->created_at->format('H:i') }}</div>
                    </td>
                    <td>
                        <div style="display:flex; gap:5px;">
                            <button class="btn-action btn-view" onclick='showModal(@json($msg))'>
                                👁️
                            </button>

                            <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding: 40px; color:#666;">📭 Belum ada pesan masuk.</td></tr>
                @endforelse
                </tbody>
            </table>

            <div style="margin-top:20px;">
                {{ $messages->links() }}
            </div>
        </div>

    </main>
</div>

<div class="modal" id="viewModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Detail Pesan</h2>
        </div>

        <div class="msg-meta">
            <div class="msg-label">Dari:</div>
            <div id="modalName"></div>

            <div class="msg-label">Email:</div>
            <div id="modalEmail"></div>

            <div class="msg-label">Telepon:</div>
            <div id="modalPhone"></div>

            <div class="msg-label">Subjek:</div>
            <div id="modalSubject" style="font-weight:bold; color:#E08E21;"></div>

            <div class="msg-label">Tanggal:</div>
            <div id="modalDate"></div>
        </div>

        <label class="msg-label" style="display:block; margin-bottom:5px;">Isi Pesan:</label>
        <div class="msg-body" id="modalMessage"></div>

        <div style="text-align: right;">
            <button onclick="closeModal()" style="background:#E08E21; color:white; border:none; padding:10px 25px; border-radius:8px; font-weight:bold; cursor:pointer;">Tutup</button>
        </div>
    </div>
</div>

<script>
    function showModal(msg) {
        document.getElementById('modalName').textContent = msg.name;
        document.getElementById('modalEmail').textContent = msg.email;
        document.getElementById('modalPhone').textContent = msg.phone || '-';
        document.getElementById('modalSubject').textContent = msg.subject || '(Tanpa Subjek)';

        // Format tanggal JS sederhana
        const date = new Date(msg.created_at);
        document.getElementById('modalDate').textContent = date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });

        document.getElementById('modalMessage').textContent = msg.message;

        document.getElementById('viewModal').classList.add('active');
    }

    function closeModal() {
        document.getElementById('viewModal').classList.remove('active');
    }

    // Close on click outside
    window.onclick = function(event) {
        const modal = document.getElementById('viewModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@include('layouts.footer')
@endsection
