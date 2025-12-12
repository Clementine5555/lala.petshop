<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - Petshop Lala</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #FF8C42; min-height: 100vh; padding: 20px; padding-top: 80px; }

        /* Navigation */
        nav { position: fixed; top: 0; left: 0; width: 100%; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000; padding: 5px 0; }
        .nav-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 30px; gap: 30px; }
        .logo { display: flex; align-items: center; gap: 10px; flex-shrink: 0; text-decoration: none; }
        .logo img { width: 32px; height: 32px; object-fit: contain; }
        .logo span { font-weight: 900; color: #FF8C42; font-size: 1.2em; white-space: nowrap; }

        .nav-links { display: flex; gap: 35px; list-style: none; align-items: center; flex-grow: 1; justify-content: center; }
        .nav-links a { text-decoration: none; color: #333; font-size: 1.15em; letter-spacing: 0.3px; transition: color 0.3s, transform 0.3s; cursor: pointer; white-space: nowrap; padding: 6px 10px; border-radius: 8px; }
        .nav-links a:hover, .nav-links a.active { color: #FF8C42; background: rgba(255, 140, 66, 0.1); transform: translateY(-2px); }

        .nav-right { display: flex; align-items: center; gap: 18px; flex-shrink: 0; }
        .cart-icon { position: relative; cursor: pointer; }
        .cart-icon svg { width: 26px; height: 26px; transition: transform 0.3s; color: #333; }
        .cart-icon:hover svg { transform: scale(1.1); color: #FF8C42; }
        .cart-badge { position: absolute; top: -6px; right: -6px; background: #FF8C42; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 0.65em; font-weight: 700; }

        /* Profile Dropdown */
        .profile-dropdown { position: relative; }
        .profile-trigger { display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 6px 12px; border-radius: 50px; transition: background 0.3s; border: 2px solid transparent; }
        .profile-trigger:hover { background: rgba(255, 140, 66, 0.1); border-color: rgba(255, 140, 66, 0.3); }

        /* Default Avatar Style */
        .profile-avatar { width: 34px; height: 34px; border-radius: 50%; background-color: #FF8C42; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2em; border: 2px solid #FF8C42; flex-shrink: 0; }

        .profile-name { font-weight: 600; color: #333; font-size: 0.9em; max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .dropdown-arrow { width: 16px; height: 16px; transition: transform 0.3s; flex-shrink: 0; color: #666; }
        .profile-dropdown.active .dropdown-arrow { transform: rotate(180deg); color: #FF8C42; }

        .dropdown-menu { position: absolute; top: calc(100% + 15px); right: 0; background: white; border-radius: 14px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); min-width: 240px; opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s; z-index: 1001; }
        .profile-dropdown.active .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }

        .dropdown-item { padding: 12px 18px; display: flex; align-items: center; gap: 10px; text-decoration: none; color: #333; transition: background 0.3s; border-bottom: 1px solid #f5f5f5; font-size: 0.9em; }
        .dropdown-item:last-child { border-bottom: none; border-radius: 0 0 14px 14px; }
        .dropdown-item:first-child { border-radius: 14px 14px 0 0; }
        .dropdown-item:hover { background: rgba(255, 140, 66, 0.1); }
        .dropdown-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .dropdown-item.logout { color: #dc2626; }
        .dropdown-item.logout:hover { background: rgba(220, 38, 38, 0.1); }

        /* Auth Buttons */
        .auth-buttons { display: flex; gap: 10px; align-items: center; }
        .btn-login, .btn-register { padding: 8px 20px; border-radius: 50px; font-weight: 600; font-size: 0.9em; text-decoration: none; transition: all 0.3s; white-space: nowrap; }
        .btn-login { color: #FF8C42; background: white; border: 2px solid #FF8C42; }
        .btn-login:hover { background: rgba(255, 140, 66, 0.1); transform: translateY(-2px); }
        .btn-register { color: white; background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%); border: none; box-shadow: 0 2px 8px rgba(255, 140, 66, 0.3); }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(255, 140, 66, 0.4); }

        .container { max-width: 1000px; margin: 0 auto; }

        /* HEADER & STATS */
        .page-header { background: white; border-radius: 20px; padding: 30px; margin-bottom: 25px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .header-title h1 { font-size: 1.8em; color: #333; margin-bottom: 5px; }
        .header-title p { color: #666; }

        .stats-row { display: flex; gap: 15px; }
        .stat-badge { text-align: center; padding: 10px 20px; background: #f8f9fa; border-radius: 12px; border: 1px solid #eee; }
        .stat-val { font-size: 1.5em; font-weight: 800; color: #FF8C42; }
        .stat-lbl { font-size: 0.8em; color: #666; font-weight: 600; }

        /* FILTER BAR */
        .filter-bar { background: white; padding: 15px 25px; border-radius: 15px; margin-bottom: 25px; display: flex; gap: 15px; align-items: center; }
        .filter-btn { background: none; border: none; padding: 8px 16px; border-radius: 20px; cursor: pointer; font-weight: 600; color: #666; transition: all 0.3s; }
        .filter-btn:hover { background: #fff3e0; color: #FF8C42; }
        .filter-btn.active { background: #FF8C42; color: white; }

        /* ORDER CARD */
        .orders-list { display: flex; flex-direction: column; gap: 20px; }
        .order-card { background: white; border-radius: 18px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; border-left: 5px solid #FF8C42; transition: transform 0.3s; }
        .order-card:hover { transform: translateY(-3px); }
        .order-card.hidden { display: none; }

        .card-header { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; }
        .order-id { font-weight: 800; font-size: 1.1em; color: #333; }
        .order-date { font-size: 0.9em; color: #999; }

        .status-pill { padding: 6px 14px; border-radius: 20px; font-size: 0.85em; font-weight: 700; }
        .st-pending { background: #fff3cd; color: #856404; }
        .st-confirmed { background: #d1ecf1; color: #0c5460; }
        .st-shipped { background: #e2e3e5; color: #383d41; }
        .st-delivered { background: #d4edda; color: #155724; }

        .card-body { display: grid; grid-template-columns: 1fr auto; gap: 20px; }
        .item-preview { display: flex; flex-direction: column; gap: 5px; }
        .item-row { font-size: 0.95em; color: #555; }
        .item-qty { font-weight: 700; color: #FF8C42; margin-right: 5px; }

        .price-section { text-align: right; }
        .total-lbl { font-size: 0.85em; color: #888; }
        .total-val { font-size: 1.2em; font-weight: 800; color: #FF8C42; }

        .card-footer { margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; display: flex; justify-content: flex-end; gap: 10px; }

        .btn { padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer; text-decoration: none; font-size: 0.9em; border: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-detail { background: #e3f2fd; color: #1976d2; }
        .btn-contact { background: #25D366; color: white; }
        .btn-pay { background: #FF8C42; color: white; }
        .btn:hover { opacity: 0.9; transform: translateY(-2px); transition: 0.3s; }

        /* MODAL */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 2000; align-items: center; justify-content: center; }
        .modal.active { display: flex; }
        .modal-content { background: white; padding: 30px; border-radius: 20px; width: 90%; max-width: 500px; animation: slideUp 0.3s; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.95em; }
        .detail-row span:last-child { font-weight: 700; color: #333; text-align: right; }
        .courier-info { background: #f0fdf4; padding: 15px; border-radius: 10px; margin-top: 15px; border: 1px solid #bbf7d0; }

        .empty-state { text-align: center; padding: 50px; background: white; border-radius: 20px; }
    </style>
</head>
<body>

@include('components.navbar')

@auth
<div class="modal" id="editProfileModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Profile</h2>
            <svg class="close-modal" onclick="closeEditProfile()" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </div>
        <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PATCH')
            <div class="form-group"><label>Full Name</label><input type="text" name="name" id="userName" value="{{ Auth::user()->name }}" placeholder="Enter your name"></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" id="userEmail" value="{{ Auth::user()->email }}" placeholder="Enter your email"></div>
            <div class="form-group"><label>Phone Number</label><input type="tel" name="phone" id="userPhone" value="{{ Auth::user()->phone ?? '' }}" placeholder="Enter your phone"></div>
            <button type="submit" class="btn-register" style="width: 100%; padding: 12px; margin-top: 20px;">Save Changes</button>
        </form>
    </div>
</div>
@endauth

<div class="container">

    <div class="page-header">
        <div class="header-title">
            <h1>📦 Pesanan Saya</h1>
            <p>Riwayat belanja dan status pengiriman Anda</p>
        </div>
        <div class="stats-row">
            <div class="stat-badge">
                <div class="stat-val" id="countPending">0</div>
                <div class="stat-lbl">Proses</div>
            </div>
            <div class="stat-badge">
                <div class="stat-val" id="countShipped">0</div>
                <div class="stat-lbl">Dikirim</div>
            </div>
        </div>
    </div>

    <div class="filter-bar">
        <button class="filter-btn active" onclick="filterOrders('all', this)">Semua</button>
        <button class="filter-btn" onclick="filterOrders('pending', this)">Menunggu</button>
        <button class="filter-btn" onclick="filterOrders('shipped', this)">Sedang Dikirim</button>
        <button class="filter-btn" onclick="filterOrders('delivered', this)">Selesai</button>
    </div>

    <div class="orders-list" id="ordersList"></div>

</div>

<div class="modal" id="detailModal">
    <div class="modal-content">
        <h2 style="margin-bottom: 15px; color:#333;">📋 Detail Transaksi</h2>
        <div id="modalBody"></div>
        <div style="margin-top:20px; text-align:right;">
            <button class="btn btn-detail" onclick="document.getElementById('detailModal').classList.remove('active')" style="background:#eee; color:#333;">Tutup</button>
        </div>
    </div>
</div>

<script>
    // DATA DARI CONTROLLER
    const orders = {!! json_encode($ordersForJs ?? []) !!};

    // MAPPING STATUS (Backend -> Frontend Teks & Class)
    const statusConfig = {
        'waiting_confirmation': { text: 'Menunggu Konfirmasi', class: 'st-pending', group: 'pending' },
        'confirmed':            { text: 'Diproses Admin',      class: 'st-confirmed', group: 'pending' },
        'shipped':              { text: 'Sedang Dikirim',      class: 'st-shipped',   group: 'shipped' },
        'delivered':            { text: 'Pesanan Selesai',     class: 'st-delivered', group: 'delivered' },
        'completed':            { text: 'Selesai',             class: 'st-delivered', group: 'delivered' },
        'cancelled':            { text: 'Dibatalkan',          class: 'st-pending',   group: 'all' }
    };

    function renderOrders(filterGroup = 'all') {
        const list = document.getElementById('ordersList');
        let html = '';

        let filtered = orders;
        if (filterGroup !== 'all') {
            filtered = orders.filter(o => {
                const config = statusConfig[o.status] || { group: 'other' };
                return config.group === filterGroup;
            });
        }

        if (filtered.length === 0) {
            list.innerHTML = `<div class="empty-state"><h3>Belum ada pesanan di kategori ini</h3><p>Yuk belanja kebutuhan anabulmu sekarang!</p><a href="/products" class="btn btn-pay" style="margin-top:15px">Belanja Sekarang</a></div>`;
            return;
        }

        filtered.forEach(o => {
            const config = statusConfig[o.status] || { text: o.status, class: 'st-pending' };

            // Render Items (Max 2 baris, sisanya +X more)
            let itemsHtml = o.items.map(i =>
                `<div class="item-row"><span class="item-qty">${i.qty}x</span> ${i.name}</div>`
            ).join('');

            // Tombol Aksi
            let buttons = `<button class="btn btn-detail" onclick="showDetail('${o.id}')">📄 Detail</button>`;

            // Jika sedang dikirim dan ada data kurir -> Tombol WA
            if ((o.status === 'shipped') && o.courier_phone) {
                buttons += `<button class="btn btn-contact" onclick="contactCourier('${o.courier_phone}')">💬 Hubungi Kurir</button>`;
            }

            // Jika status completed, mungkin tombol Beli Lagi (optional)

            html += `
            <div class="order-card">
                <div class="card-header">
                    <div>
                        <div class="order-id">${o.id}</div>
                        <div class="order-date">${o.date}</div>
                    </div>
                    <span class="status-pill ${config.class}">${config.text}</span>
                </div>
                <div class="card-body">
                    <div class="item-preview">
                        ${itemsHtml}
                    </div>
                    <div class="price-section">
                        <div class="total-lbl">Total Belanja</div>
                        <div class="total-val">Rp ${parseInt(o.total).toLocaleString('id-ID')}</div>
                    </div>
                </div>
                <div class="card-footer">
                    ${buttons}
                </div>
            </div>`;
        });

        list.innerHTML = html;
        updateStats();
    }

    function showDetail(id) {
        const o = orders.find(x => x.id === id);
        if(!o) return;

        const config = statusConfig[o.status] || { text: o.status };

        let content = `
            <div class="detail-row"><span>Status</span><span style="color:#FF8C42">${config.text}</span></div>
            <div class="detail-row"><span>Tanggal</span><span>${o.date}</span></div>
            <div class="detail-row"><span>Alamat</span><span>${o.address}</span></div>
            <div class="detail-row"><span>Metode Bayar</span><span>${o.payment_method} (${o.payment_status})</span></div>
            <hr style="margin:15px 0; border:0; border-top:1px dashed #ddd;">
            <div style="margin-bottom:10px; font-weight:bold; color:#666;">Produk:</div>
        `;

        o.items.forEach(i => {
            content += `<div class="detail-row"><span>${i.qty}x ${i.name}</span><span>Rp ${parseInt(i.price).toLocaleString('id-ID')}</span></div>`;
        });

        content += `<div class="detail-row" style="font-size:1.2em; margin-top:10px;"><span>Total</span><span>Rp ${parseInt(o.total).toLocaleString('id-ID')}</span></div>`;

        // Info Kurir jika ada
        if(o.courier_name && o.courier_name !== '-') {
            content += `
            <div class="courier-info">
                <div style="font-size:0.9em; color:#15803d; font-weight:bold; margin-bottom:5px;">🚚 Info Pengiriman</div>
                <div class="detail-row" style="border:none; padding:2px 0;"><span>Kurir</span><span>${o.courier_name}</span></div>
                <div class="detail-row" style="border:none; padding:2px 0;"><span>Catatan</span><span>${o.notes}</span></div>
            </div>`;
        }

        document.getElementById('modalBody').innerHTML = content;
        document.getElementById('detailModal').classList.add('active');
    }

    function contactCourier(phone) {
        let cleanPhone = phone.replace(/\D/g, '');
        if (cleanPhone.startsWith('0')) cleanPhone = '62' + cleanPhone.substring(1);
        window.open(`https://wa.me/${cleanPhone}`, '_blank');
    }

    function filterOrders(group, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        renderOrders(group);
    }

    function updateStats() {
        // Hitung manual dari data orders
        const pending = orders.filter(o => ['waiting_confirmation', 'confirmed'].includes(o.status)).length;
        const shipped = orders.filter(o => o.status === 'shipped').length;

        document.getElementById('countPending').textContent = pending;
        document.getElementById('countShipped').textContent = shipped;
    }

    // Modal logic
    function toggleDropdown(event) {
        event.stopPropagation();
        document.getElementById('profileDropdown').classList.toggle('active');
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('profileDropdown');
        if (dropdown && dropdown.classList.contains('active')) {
            if (!dropdown.contains(event.target)) dropdown.classList.remove('active');
        }
    });

    function openEditProfile(event) {
        event.preventDefault();
        document.getElementById('editProfileModal').classList.add('active');
        document.getElementById('profileDropdown').classList.remove('active');
    }
    function closeEditProfile() { document.getElementById('editProfileModal').classList.remove('active'); }
    const modal = document.getElementById('editProfileModal');
    if (modal) { modal.addEventListener('click', function(event) { if (event.target === this) closeEditProfile(); }); }

    // Close Modal on Outside Click
    window.onclick = function(event) {
        const modal = document.getElementById('detailModal');
        if (event.target == modal) modal.classList.remove('active');
    }

    // Init
    renderOrders();
</script>

</body>
</html>
