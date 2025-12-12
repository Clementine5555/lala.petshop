@extends('layouts.app')

@section('content')
<style>
    /* COPY STYLE DARI HALAMAN ADMIN LAIN AGAR KONSISTEN */
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

    /* TABLE CONTAINER */
    .table-container { background-color: #C0C0C0; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); min-height: 500px; }
    .page-title { font-size: 24px; font-weight: 800; color: #222; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 3px solid #E08E21; display: inline-block; width: 100%; }

    .custom-table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; }
    .custom-table thead { background-color: #E08E21; color: white; }
    .custom-table th, .custom-table td { padding: 18px 20px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
    .custom-table th { font-weight: 800; font-size: 15px; }
    .custom-table tbody tr:hover { background-color: #f9f9f9; }

    /* STATUS BADGES (Sesuai Request: Warna-warni) */
    .badge { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge-pending { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .badge-confirmed { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .badge-completed { background: #cce5ff; color: #004085; border: 1px solid #b8daff; }
    .badge-cancelled { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    /* ACTION BUTTONS */
    .btn-action { padding: 8px 16px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; transition: 0.2s; }
    .btn-edit { background-color: #ffc107; color: #333; } .btn-edit:hover { background-color: #e0a800; }

    /* MODAL STYLE (Mirip dengan Admin lainnya) */
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; }
    .modal.active { display: flex; }
    .modal-content { background: white; border-radius: 20px; width: 100%; max-width: 600px; padding: 30px; animation: slideUp 0.3s; }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-header h2 { margin: 0 0 20px 0; color: #E08E21; border-bottom: 2px solid #eee; padding-bottom: 10px; }

    .form-group { margin-bottom: 15px; }
    .form-label { display: block; font-weight: 600; margin-bottom: 5px; color: #555; }
    .form-input { width: 100%; padding: 10px; border: 2px solid #eee; border-radius: 8px; background: #f9f9f9; }
    .form-input:focus { border-color: #E08E21; outline: none; }
    .info-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 10px; }
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
    </aside>

    <main class="main-content">

        <div class="header-section">
            <div class="header-title">
                <h1>Daftar Appointment</h1>
                <p>Kelola jadwal grooming dan status booking</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <div class="table-container">
            <h2 class="page-title">Jadwal Grooming</h2>

            @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ✅ {{ session('success') }}
            </div>
            @endif

            <table class="custom-table">
                <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Nama Pet</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($appointments as $apt)
                <tr>
                    <td>
                        <div style="font-weight:bold">{{ $apt->detail->date ?? $apt->appointment_date ? \Carbon\Carbon::parse($apt->detail->date ?? $apt->appointment_date)->format('d M Y') : '-' }}</div>
                        <div style="font-size:12px; color:#666">{{ $apt->detail->time ?? '-' }}</div>
                    </td>
                    <td>{{ $apt->customer_name }}</td>
                    <td>
                        {{ $apt->pet_name }} <span style="font-size:12px">({{ $apt->pet_type }})</span>
                    </td>
                    <td>{{ $apt->service_type }}</td>
                    <td>
                        @php
                        $statusClass = [
                        'pending' => 'badge-pending',
                        'confirmed' => 'badge-confirmed',
                        'completed' => 'badge-completed',
                        'cancelled' => 'badge-cancelled'
                        ][$apt->status] ?? 'badge-pending';
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($apt->status) }}</span>
                    </td>
                    <td>
                        <button class="btn-action btn-edit" onclick="openEditModal({{ json_encode($apt) }}, '{{ $apt->detail->time ?? '' }}', '{{ $apt->detail->date ?? '' }}')">
                            ✏️ Update
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center; padding: 40px; color:#666;">Belum ada appointment.</td></tr>
                @endforelse
                </tbody>
            </table>

            <div style="margin-top:20px;">
                {{ $appointments->links() }}
            </div>
        </div>

    </main>
</div>

<div class="modal" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Appointment</h2>
        </div>
        <form id="editForm" method="POST">
            @csrf

            <div class="info-row">
                <div class="form-group">
                    <label class="form-label">Nama Customer</label>
                    <input type="text" class="form-input" id="modalCustomer" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Pet</label>
                    <input type="text" class="form-input" id="modalPet" readonly>
                </div>
            </div>

            <div class="info-row">
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="text" class="form-input" id="modalDate" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Waktu</label>
                    <input type="text" class="form-input" id="modalTime" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Layanan</label>
                <input type="text" class="form-input" id="modalService" readonly>
            </div>

            <hr style="margin: 20px 0; border:0; border-top:1px dashed #ccc;">

            <div class="form-group">
                <label class="form-label">Status Appointment</label>
                <select name="status" id="modalStatus" class="form-input" style="background: white; border-color: #E08E21;">
                    <option value="pending">Pending (Menunggu)</option>
                    <option value="confirmed">Confirmed (Disetujui)</option>
                    <option value="completed">Completed (Selesai)</option>
                    <option value="cancelled">Cancelled (Dibatalkan)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" id="modalNotes" class="form-input" rows="3"></textarea>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button type="button" onclick="closeEditModal()" style="background:#ccc; border:none; padding:10px 20px; border-radius:8px; font-weight:bold; cursor:pointer; margin-right:10px;">Batal</button>
                <button type="submit" style="background:#E08E21; color:white; border:none; padding:10px 20px; border-radius:8px; font-weight:bold; cursor:pointer;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(apt, time, date) {
        // Set Action URL
        document.getElementById('editForm').action = `/admin/appointments/${apt.appointment_id}/update`;

        // Isi Data Readonly
        document.getElementById('modalCustomer').value = apt.customer_name;
        document.getElementById('modalPet').value = apt.pet_name + ' (' + apt.pet_type + ')';
        document.getElementById('modalService').value = apt.service_type;
        document.getElementById('modalDate').value = date;
        document.getElementById('modalTime').value = time;

        // Isi Form Input
        document.getElementById('modalStatus').value = apt.status;
        document.getElementById('modalNotes').value = apt.notes || '';

        // Tampilkan Modal
        document.getElementById('editModal').classList.add('active');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    // Close on click outside
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            closeEditModal();
        }
    }
</script>
@include('layouts.footer')
@endsection
