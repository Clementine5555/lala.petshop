<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kurir Dashboard - Petshop Lala</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #FF8C42; min-height: 100vh; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; }

        /* Logout */
        .logout-form-container { position: fixed; top: 20px; left: 20px; z-index: 1000; }
        .logout-btn { background: white; padding: 12px 24px; border-radius: 50px; border: none; cursor: pointer; font-weight: 700; color: #FF8C42; box-shadow: 0 4px 15px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 8px; transition: all 0.3s; }
        .logout-btn:hover { background: #FF8C42; color: white; transform: translateY(-2px); }

        /* Header */
        .header { background: white; border-radius: 20px; padding: 30px; margin: 60px 0 25px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .header-left { display: flex; align-items: center; gap: 18px; }
        .avatar { width: 65px; height: 65px; border-radius: 50%; background: linear-gradient(135deg, #FF8C42, #FF6B35); display: flex; align-items: center; justify-content: center; font-size: 1.8em; color: white; box-shadow: 0 4px 15px rgba(255,140,66,0.4); }
        .header-info h1 { font-size: 1.8em; color: #333; margin-bottom: 4px; }
        .header-info p { color: #666; font-size: 1em; }

        .header-stats { display: flex; gap: 20px; flex-wrap: wrap; }
        .stat-box { text-align: center; padding: 15px 25px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 15px; min-width: 120px; }
        .stat-num { font-size: 2.2em; font-weight: 800; background: linear-gradient(135deg, #FF8C42, #FF6B35); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .stat-label { color: #666; font-size: 0.85em; margin-top: 4px; font-weight: 600; }

        /* Filters */
        .filters { background: white; border-radius: 15px; padding: 20px 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); display: flex; gap: 15px; align-items: center; flex-wrap: wrap; }
        .filter-group { display: flex; align-items: center; gap: 10px; }
        .filter-group label { font-weight: 600; color: #333; font-size: 0.9em; }
        .filter-select { padding: 10px 18px; border: 2px solid #e0e0e0; border-radius: 25px; font-size: 0.95em; cursor: pointer; transition: all 0.3s; background: white; }
        .filter-select:focus { outline: none; border-color: #FF8C42; }
        .search-wrap { position: relative; flex: 1; min-width: 220px; }
        .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); }
        .search-box { width: 100%; padding: 10px 18px 10px 42px; border: 2px solid #e0e0e0; border-radius: 25px; font-size: 0.95em; transition: all 0.3s; }
        .search-box:focus { outline: none; border-color: #FF8C42; }

        /* Grid */
        .orders-grid { display: flex; flex-direction: column; gap: 20px; }
        .order-card { background: white; border-radius: 18px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s; position: relative; border-left: 5px solid #FF8C42; }
        .order-card:hover { transform: translateY(-4px); box-shadow: 0 12px 35px rgba(0,0,0,0.12); }

        .order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 15px; border-bottom: 2px solid #f5f5f5; }
        .order-id { font-size: 1.3em; font-weight: 800; color: #333; }
        .order-date { font-size: 0.85em; color: #999; margin-top: 4px; }
        .status-badge { padding: 8px 18px; border-radius: 20px; font-weight: 600; font-size: 0.85em; }
        .status-pending { background: #fff3e0; color: #f57c00; }
        .status-pickup { background: #e3f2fd; color: #1976d2; }
        .status-delivering { background: #f3e5f5; color: #7b1fa2; }
        .status-delivered { background: #e8f5e9; color: #388e3c; }

        .order-body { display: grid; grid-template-columns: 1.5fr 1fr; gap: 25px; margin-bottom: 18px; }
        .customer-info { display: flex; flex-direction: column; gap: 14px; }
        .info-row { display: flex; align-items: flex-start; gap: 12px; }
        .info-icon { width: 38px; height: 38px; background: linear-gradient(135deg, #fff5ee, #ffe8d6); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.1em; }
        .info-content h4 { font-size: 0.8em; color: #999; margin-bottom: 3px; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-content p { font-size: 0.95em; color: #333; font-weight: 600; }

        .order-summary { background: linear-gradient(135deg, #f8f9fa, #f0f0f0); padding: 18px; border-radius: 14px; }
        .order-summary h4 { font-size: 1em; color: #333; margin-bottom: 12px; font-weight: 700; }
        .order-items { display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px; }
        .order-item { display: flex; justify-content: space-between; color: #555; font-size: 0.9em; }
        .item-name { font-weight: 600; }
        .order-total { padding-top: 12px; border-top: 2px solid #dee2e6; display: flex; justify-content: space-between; font-size: 1.15em; font-weight: 800; color: #FF8C42; }

        .order-notes { background: #fff8f0; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; border-left: 3px solid #FF8C42; }
        .order-notes h5 { font-size: 0.8em; color: #FF8C42; margin-bottom: 5px; text-transform: uppercase; }
        .order-notes p { font-size: 0.9em; color: #666; }

        .order-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn { flex: 1; padding: 12px 20px; border: none; border-radius: 12px; font-weight: 700; font-size: 0.9em; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; min-width: 130px; }
        .btn-primary { background: linear-gradient(135deg, #FF8C42, #FF6B35); color: white; }
        .btn-success { background: linear-gradient(135deg, #4caf50, #45a049); color: white; }
        .btn-info { background: linear-gradient(135deg, #2196F3, #1976D2); color: white; }
        .btn-secondary { background: white; color: #666; border: 2px solid #e0e0e0; }
        .btn-call { background: linear-gradient(135deg, #00bcd4, #0097a7); color: white; }
        .btn-map { background: linear-gradient(135deg, #9c27b0, #7b1fa2); color: white; }
        .btn:hover { transform: translateY(-2px); opacity: 0.95; }

        .empty-state { text-align: center; padding: 60px 20px; background: white; border-radius: 18px; }
        .empty-state h3 { font-size: 1.5em; color: #333; margin: 15px 0 8px; }
        .empty-state p { color: #666; }

        /* Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 2000; align-items: center; justify-content: center; padding: 20px; }
        .modal.active { display: flex; }
        .modal-content { background: white; border-radius: 20px; width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto; padding: 30px; animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { text-align: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0; }
        .modal-header h2 { color: #333; font-size: 1.5em; margin-bottom: 5px; }
        .modal-header p { color: #666; font-size: 0.95em; }

        .detail-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: #666; font-size: 0.9em; }
        .detail-value { font-weight: 700; color: #333; font-size: 0.95em; text-align: right; max-width: 60%; }
        .detail-section { margin: 20px 0; }
        .detail-section h4 { font-size: 1em; color: #333; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 2px solid #FF8C42; }

        .items-list { background: #f9f9f9; padding: 15px; border-radius: 12px; }
        .items-list .order-item { padding: 8px 0; }
        .items-total { margin-top: 12px; padding-top: 12px; border-top: 2px solid #ddd; font-size: 1.2em; font-weight: 800; color: #FF8C42; display: flex; justify-content: space-between; }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; color: #333; font-weight: 600; margin-bottom: 8px; font-size: 0.9em; }
        .form-control { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 12px; font-size: 0.95em; transition: all 0.3s; }
        .form-control:focus { outline: none; border-color: #FF8C42; }
        textarea.form-control { resize: vertical; min-height: 80px; }
        .modal-actions { display: flex; gap: 12px; margin-top: 20px; }

        /* Timeline */
        .timeline { margin: 15px 0; }
        .timeline-item { display: flex; gap: 12px; padding: 10px 0; position: relative; }
        .timeline-item:not(:last-child)::before { content: ''; position: absolute; left: 14px; top: 35px; width: 2px; height: calc(100% - 10px); background: #e0e0e0; }
        .timeline-dot { width: 30px; height: 30px; border-radius: 50%; background: #FF8C42; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.8em; flex-shrink: 0; }
        .timeline-dot.inactive { background: #e0e0e0; color: #999; }
        .timeline-content h5 { font-size: 0.9em; color: #333; }
        .timeline-content p { font-size: 0.8em; color: #999; }

        @media (max-width: 900px) {
            .order-body { grid-template-columns: 1fr; }
            .header-stats { width: 100%; justify-content: center; }
        }
        @media (max-width: 600px) {
            .header { padding: 20px; }
            .header-info h1 { font-size: 1.4em; }
            .order-actions { flex-direction: column; }
            .btn { min-width: 100%; }
            .modal-actions { flex-direction: column; }
        }
    </style>
</head>
<body>

<div class="logout-form-container">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
            <span>🚪</span>
            <span>Logout</span>
        </button>
    </form>
</div>

<div class="container">
    <div class="header">
        <div class="header-left">
            <div class="avatar">🚚</div>
            <div class="header-info">
                <h1>Dashboard Kurir</h1>
                <p>Petshop Lala - Pengiriman Hari Ini</p>
            </div>
        </div>
        <div class="header-stats">
            <div class="stat-box">
                <div class="stat-num" id="pendingCount">0</div>
                <div class="stat-label">Menunggu</div>
            </div>
            <div class="stat-box">
                <div class="stat-num" id="deliveringCount">0</div>
                <div class="stat-label">Dikirim</div>
            </div>
            <div class="stat-box">
                <div class="stat-num" id="completedCount">0</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
    </div>

    <div class="filters">
        <div class="filter-group">
            <label>Status:</label>
            <select class="filter-select" id="statusFilter" onchange="applyFilters()">
                <option value="all">Semua</option>
                <option value="pending">Menunggu</option>
                <option value="delivering">Dikirim</option>
                <option value="delivered">Selesai</option>
            </select>
        </div>
        <div class="search-wrap">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-box" id="searchBox" placeholder="Cari order ID atau nama..." oninput="applyFilters()">
        </div>
    </div>

    <div class="orders-grid" id="ordersGrid"></div>
</div>

<div class="modal" id="detailModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>📋 Detail Pesanan</h2>
            <p id="modalOrderId"></p>
        </div>
        <div class="modal-body" id="modalBody"></div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeModal('detailModal')">Tutup</button>
        </div>
    </div>
</div>

<div class="modal" id="statusModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="statusModalTitle">Update Status</h2>
            <p id="statusModalOrderId"></p>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Catatan Pengiriman (Opsional)</label>
                <textarea class="form-control" id="statusNote" placeholder="Contoh: Diterima oleh satpam..."></textarea>
            </div>
            <div class="form-group" id="photoUploadGroup" style="display:none;">
                <label>Bukti Pengiriman (Opsional)</label>
                <input type="file" class="form-control" id="proofPhoto" accept="image/*">
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeModal('statusModal')">Batal</button>
            <button class="btn btn-success" id="confirmBtn" onclick="confirmStatus()">Konfirmasi</button>
        </div>
    </div>
</div>

<script>
    const orders = {!! json_encode($ordersForJs ?? []) !!};
    let currentOrder = null, currentAction = null;

    const statusMap = {
        'pending': 'Menunggu Pickup',
        'pickup': 'Siap Diambil',
        'delivering': 'Sedang Dikirim',
        'shipped': 'Sedang Dikirim',
        'delivered': 'Selesai'
    };

    const statusClass = {
        'pending': 'status-pending',
        'pickup': 'status-pickup',
        'delivering': 'status-delivering',
        'shipped': 'status-delivering',
        'delivered': 'status-delivered'
    };

    function render(data = orders) {
        const grid = document.getElementById('ordersGrid');

        if (data.length === 0) {
            grid.innerHTML = `<div class="empty-state"><div style="font-size:4em;opacity:0.3">📦</div><h3>Tidak Ada Pesanan</h3><p>Belum ada tugas pengiriman.</p></div>`;
        } else {
            grid.innerHTML = data.map(o => {
                const items = o.items.map(i => `<div class="order-item"><span class="item-name">${i.qty}x ${i.name}</span><span>Rp ${i.price.toLocaleString('id-ID')}</span></div>`).join('');

                let actions = '';
                if (o.status === 'pending') {
                    actions = `<button class="btn btn-primary" onclick="updateStatus('${o.id}','pickup')">📦 Ambil Pesanan</button>`;
                } else if (o.status === 'shipped' || o.status === 'delivering') {
                    actions = `<button class="btn btn-success" onclick="updateStatus('${o.id}','delivered')">✅ Selesai</button>`;
                }

                return `
                <div class="order-card" data-status="${o.status}">
                    <div class="order-header">
                        <div>
                            <div class="order-id">${o.order_id_display}</div>
                            <div class="order-date">📅 ${o.date}</div>
                        </div>
                        <span class="status-badge ${statusClass[o.status] || 'status-pending'}">${statusMap[o.status] || o.status}</span>
                    </div>
                    <div class="order-body">
                        <div class="customer-info">
                            <div class="info-row"><div class="info-icon">👤</div><div class="info-content"><h4>Customer</h4><p>${o.customer}</p></div></div>
                            <div class="info-row"><div class="info-icon">📞</div><div class="info-content"><h4>Telepon</h4><p>${o.phone}</p></div></div>
                            <div class="info-row"><div class="info-icon">📍</div><div class="info-content"><h4>Alamat</h4><p>${o.address}</p></div></div>
                            <div class="info-row"><div class="info-icon">💳</div><div class="info-content"><h4>Pembayaran</h4><p>${o.paymentMethod}</p></div></div>
                        </div>
                        <div class="order-summary">
                            <h4>🛒 Pesanan</h4>
                            <div class="order-items">${items}</div>
                            <div class="order-total"><span>Total</span><span>Rp ${o.total.toLocaleString('id-ID')}</span></div>
                        </div>
                    </div>
                    ${o.notes ? `<div class="order-notes"><h5>📝 Catatan</h5><p>${o.notes}</p></div>` : ''}
                    <div class="order-actions">
                        <button class="btn btn-info" onclick="showDetail('${o.id}')">📋 Detail</button>
                        ${actions}
                        <button class="btn btn-call" onclick="callCustomer('${o.phone}')">📞 Hubungi</button>
                        <button class="btn btn-map" onclick="openMap('${encodeURIComponent(o.address)}')">🗺️ Peta</button>
                    </div>
                </div>`;
            }).join('');
        }
        updateStats();
    }

    function updateStats() {
        document.getElementById('pendingCount').textContent = orders.filter(o => o.status === 'pending').length;
        document.getElementById('deliveringCount').textContent = orders.filter(o => o.status === 'shipped' || o.status === 'delivering').length;
        document.getElementById('completedCount').textContent = orders.filter(o => o.status === 'delivered').length;
    }

    function applyFilters() {
        let filtered = [...orders];
        const status = document.getElementById('statusFilter').value;
        const search = document.getElementById('searchBox').value.toLowerCase();

        if (status !== 'all') {
            if (status === 'delivering') filtered = filtered.filter(o => o.status === 'shipped' || o.status === 'delivering');
            else filtered = filtered.filter(o => o.status === status);
        }

        if (search) {
            filtered = filtered.filter(o => o.order_id_display.toLowerCase().includes(search) || o.customer.toLowerCase().includes(search));
        }
        render(filtered);
    }

    function showDetail(id) {
        const o = orders.find(x => x.id == id);
        if (!o) return;

        const items = o.items.map(i => `<div class="order-item"><span class="item-name">${i.qty}x ${i.name}</span><span>Rp ${i.price.toLocaleString('id-ID')}</span></div>`).join('');

        const timeline = `
        <div class="timeline">
            <div class="timeline-item"><div class="timeline-dot">1</div><div class="timeline-content"><h5>Pesanan Masuk</h5><p>${o.date}</p></div></div>
            <div class="timeline-item"><div class="timeline-dot ${o.status!=='pending'?'':'inactive'}">2</div><div class="timeline-content"><h5>Diambil Kurir</h5><p>${o.status!=='pending'?'Sudah diambil':'-'}</p></div></div>
            <div class="timeline-item"><div class="timeline-dot ${o.status==='delivered'?'':'inactive'}">3</div><div class="timeline-content"><h5>Selesai</h5><p>${o.completedAt||'-'}</p></div></div>
        </div>`;

        document.getElementById('modalOrderId').textContent = o.order_id_display;
        document.getElementById('modalBody').innerHTML = `
        <div class="detail-section"><h4>📦 Informasi Pesanan</h4>
            <div class="detail-row"><span class="detail-label">Status</span><span class="detail-value"><span class="status-badge ${statusClass[o.status] || 'status-pending'}">${statusMap[o.status] || o.status}</span></span></div>
        </div>
        <div class="detail-section"><h4>👤 Informasi Customer</h4>
            <div class="detail-row"><span class="detail-label">Nama</span><span class="detail-value">${o.customer}</span></div>
            <div class="detail-row"><span class="detail-label">Alamat</span><span class="detail-value">${o.address}</span></div>
        </div>
        <div class="detail-section"><h4>🛒 Item Pesanan</h4>
            <div class="items-list">${items}<div class="items-total"><span>Total</span><span>Rp ${o.total.toLocaleString('id-ID')}</span></div></div>
        </div>
        ${o.notes ? `<div class="detail-section"><h4>📝 Catatan</h4><p style="color:#666">${o.notes}</p></div>` : ''}
        <div class="detail-section"><h4>📍 Status Pengiriman</h4>${timeline}</div>`;

        document.getElementById('detailModal').classList.add('active');
    }

    function updateStatus(id, newStatus) {
        currentOrder = id;
        currentAction = newStatus;
        const o = orders.find(x => x.id == id);

        const titles = {'pickup':'📦 Ambil Pesanan', 'delivered':'✅ Selesaikan Pengiriman'};
        document.getElementById('statusModalTitle').textContent = titles[newStatus] || 'Update Status';
        document.getElementById('statusModalOrderId').textContent = `${o.order_id_display} - ${o.customer}`;
        document.getElementById('statusNote').value = '';
        document.getElementById('photoUploadGroup').style.display = newStatus === 'delivered' ? 'block' : 'none';
        document.getElementById('confirmBtn').className = newStatus === 'delivered' ? 'btn btn-success' : 'btn btn-primary';
        document.getElementById('statusModal').classList.add('active');
    }

    // --- FUNGSI CONFIRM STATUS (FIXED with Error Handling) ---
    function confirmStatus() {
        if (!currentOrder) return;

        const note = document.getElementById('statusNote').value;
        const token = document.querySelector('meta[name="csrf-token"]').content;

        const btn = document.getElementById('confirmBtn');
        const originalText = btn.textContent;
        btn.textContent = 'Memproses...';
        btn.disabled = true;

        fetch(`/courier/delivery/${currentOrder}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: currentAction,
                note: note
            })
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.message || 'Server Error'); });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(`✅ Berhasil! Status diperbarui.`);
                    closeModal('statusModal');
                    window.location.reload();
                } else {
                    alert('Gagal: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Gagal: ' + error.message);
            })
            .finally(() => {
                btn.textContent = originalText;
                btn.disabled = false;
            });
    }

    // --- FUNGSI CALL CUSTOMER (FIXED Phone Format) ---
    function callCustomer(phone) {
        let cleanPhone = phone.replace(/\D/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }

        if(confirm(`Hubungi ${phone}? \nKlik OK untuk WhatsApp, Cancel untuk Telepon Biasa.`)) {
            window.open(`https://wa.me/${cleanPhone}`, '_blank');
        } else {
            window.location.href = `tel:+${cleanPhone}`;
        }
    }

    function openMap(addr) { window.open('https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(addr), '_blank'); }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    document.querySelectorAll('.modal').forEach(m => m.addEventListener('click', e => { if(e.target === m) m.classList.remove('active'); }));

    render();
</script>

@include('layouts.footer')

</body>
</html>
