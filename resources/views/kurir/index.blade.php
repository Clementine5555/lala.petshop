<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Courier Dashboard - Petshop Lala</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }

        .courier-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-section {
            background: white;
            border-radius: 25px;
            padding: 35px 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .courier-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            color: white;
            font-weight: 700;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
        }

        .header-info h1 {
            font-size: 2em;
            color: #333;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .header-info p {
            color: #666;
            font-size: 1.1em;
        }

        .header-stats {
            display: flex;
            gap: 30px;
        }

        .stat-item {
            text-align: center;
            padding: 15px 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: 800;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
            font-weight: 600;
        }

        .filters-section {
            background: white;
            border-radius: 20px;
            padding: 25px 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-group label {
            font-weight: 600;
            color: #333;
            font-size: 0.95em;
        }

        .filter-select {
            padding: 10px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }

        .filter-select:focus {
            outline: none;
            border-color: #FF8C42;
            box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1);
        }

        .search-box {
            flex: 1;
            padding: 12px 20px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 1em;
            transition: all 0.3s;
            background: white;
            position: relative;
            min-width: 250px;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2em;
        }

        .search-box:focus {
            outline: none;
            border-color: #FF8C42;
            box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1);
        }

        .orders-grid {
            display: grid;
            gap: 25px;
            margin-bottom: 30px;
        }

        .order-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .order-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f5f5f5;
        }

        .order-id {
            font-size: 1.5em;
            font-weight: 800;
            color: #333;
        }

        .order-status {
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9em;
        }

        .status-pending {
            background: #fff3e0;
            color: #f57c00;
        }

        .status-pickup {
            background: #e3f2fd;
            color: #1976d2;
        }

        .status-delivering {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .order-body {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 20px;
        }

        .customer-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon svg {
            width: 20px;
            height: 20px;
            color: #FF8C42;
        }

        .info-content h4 {
            font-size: 0.85em;
            color: #999;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-content p {
            font-size: 1.05em;
            color: #333;
            font-weight: 600;
        }

        .order-summary {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-radius: 15px;
        }

        .order-summary h4 {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .order-items {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 15px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            color: #666;
            font-size: 0.95em;
        }

        .item-name {
            font-weight: 600;
        }

        .order-total {
            padding-top: 15px;
            border-top: 2px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            font-size: 1.3em;
            font-weight: 800;
            color: #FF8C42;
        }

        .order-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            padding: 14px 25px;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 150px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 66, 0.5);
        }

        .btn-success {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.5);
        }

        .btn-info {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.5);
        }

        .btn-secondary {
            background: white;
            color: #666;
            border: 2px solid #e0e0e0;
        }

        .btn-secondary:hover {
            background: #f5f5f5;
            border-color: #ccc;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .empty-state svg {
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #666;
            font-size: 1.1em;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 25px;
            width: 100%;
            max-width: 500px;
            padding: 35px;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .modal-header h2 {
            color: #333;
            font-size: 1.8em;
            margin-bottom: 10px;
        }

        .modal-header p {
            color: #666;
        }

        .modal-body {
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1em;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #FF8C42;
            box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
        }

        @media (max-width: 992px) {
            .order-body {
                grid-template-columns: 1fr;
            }

            .header-stats {
                width: 100%;
                justify-content: space-around;
            }
        }

        @media (max-width: 768px) {
            .header-section {
                padding: 25px 20px;
            }

            .header-info h1 {
                font-size: 1.5em;
            }

            .filters-section {
                padding: 20px;
            }

            .order-card {
                padding: 20px;
            }

            .order-actions {
                flex-direction: column;
            }

            .btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="courier-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-left">
                <div class="courier-avatar">🚚</div>
                <div class="header-info">
                    <h1>Selamat Datang, Kurir!</h1>
                    <p>Anda memiliki pesanan yang menunggu untuk dikirim</p>
                </div>
            </div>
            <div class="header-stats">
                <div class="stat-item">
                    <div class="stat-number" id="pendingCount">8</div>
                    <div class="stat-label">Menunggu Pickup</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="deliveringCount">3</div>
                    <div class="stat-label">Sedang Dikirim</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="completedCount">24</div>
                    <div class="stat-label">Selesai Hari Ini</div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <div class="filter-group">
                <label>Status:</label>
                <select class="filter-select" id="statusFilter">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu Pickup</option>
                    <option value="pickup">Siap Diambil</option>
                    <option value="delivering">Sedang Dikirim</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Area:</label>
                <select class="filter-select" id="areaFilter">
                    <option value="all">Semua Area</option>
                    <option value="medan-utara">Medan Utara</option>
                    <option value="medan-selatan">Medan Selatan</option>
                    <option value="medan-timur">Medan Timur</option>
                    <option value="medan-barat">Medan Barat</option>
                </select>
            </div>
            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" class="search-box" id="searchBox" placeholder="Cari berdasarkan order ID atau nama customer...">
            </div>
        </div>

        <!-- Orders Grid -->
        <div class="orders-grid" id="ordersGrid">
            <!-- Orders akan dimuat di sini -->
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal" id="detailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detail Pesanan</h2>
                <p id="modalOrderId"></p>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content loaded dynamically -->
            </div>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal" id="statusModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Update Status Pengiriman</h2>
                <p id="statusModalOrderId"></p>
            </div>
            <div class="modal-body">
                <form id="statusForm">
                    <div class="form-group">
                        <label>Catatan (Opsional)</label>
                        <textarea class="form-control" id="statusNote" placeholder="Tambahkan catatan pengiriman..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeStatusModal()">Batal</button>
                <button class="btn btn-primary" id="confirmStatusBtn">Konfirmasi</button>
            </div>
        </div>
    </div>

    <script>
        // Sample orders data
        let ordersData = [
            {
                id: 'ORD-2025-001',
                customer: 'Tachyang Cutesy',
                phone: '0812-3456-7890',
                address: 'Jl. Setia Budi No. 123, Medan Utara',
                area: 'medan-utara',
                items: [
                    { name: 'Whiskas 1kg', qty: 2, price: 130000 },
                    { name: 'Royal Canin 500g', qty: 1, price: 99000 }
                ],
                total: 359000,
                status: 'pending',
                orderDate: '21 Nov 2025, 09:30'
            },
            {
                id: 'ORD-2025-002',
                customer: 'Budi Santoso',
                phone: '0813-5678-9012',
                address: 'Jl. Gatot Subroto No. 45, Medan Selatan',
                area: 'medan-selatan',
                items: [
                    { name: 'Premium Dry Dog Food 5kg', qty: 1, price: 350000 },
                    { name: 'Pedigree Adult 3kg', qty: 1, price: 285000 }
                ],
                total: 635000,
                status: 'pickup',
                orderDate: '21 Nov 2025, 08:15'
            },
            {
                id: 'ORD-2025-003',
                customer: 'Siti Aminah',
                phone: '0821-9876-5432',
                address: 'Jl. Imam Bonjol No. 78, Medan Timur',
                area: 'medan-timur',
                items: [
                    { name: 'Me-O 1.2kg', qty: 3, price: 99000 }
                ],
                total: 297000,
                status: 'delivering',
                orderDate: '21 Nov 2025, 07:45'
            },
            {
                id: 'ORD-2025-004',
                customer: 'Ahmad Yani',
                phone: '0822-3456-1234',
                address: 'Jl. Sudirman No. 99, Medan Barat',
                area: 'medan-barat',
                items: [
                    { name: 'Purina Pro Plan 2kg', qty: 1, price: 425000 }
                ],
                total: 425000,
                status: 'pending',
                orderDate: '21 Nov 2025, 10:00'
            },
            {
                id: 'ORD-2025-005',
                customer: 'Linda Wijaya',
                phone: '0813-7890-5678',
                address: 'Jl. Veteran No. 56, Medan Utara',
                area: 'medan-utara',
                items: [
                    { name: 'Cat Choize 2kg', qty: 1, price: 210000 },
                    { name: 'Friskies 1kg', qty: 2, price: 75000 }
                ],
                total: 360000,
                status: 'pickup',
                orderDate: '21 Nov 2025, 09:00'
            }
        ];

        // Render orders
        function renderOrders(orders = ordersData) {
            const grid = document.getElementById('ordersGrid');
            
            if (orders.length === 0) {
                grid.innerHTML = `
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3>Tidak Ada Pesanan</h3>
                        <p>Belum ada pesanan yang sesuai dengan filter Anda</p>
                    </div>
                `;
                return;
            }

            grid.innerHTML = orders.map(order => {
                const statusClass = `status-${order.status}`;
                const statusText = {
                    'pending': 'Menunggu Pickup',
                    'pickup': 'Siap Diambil',
                    'delivering': 'Sedang Dikirim'
                }[order.status];

                const itemsList = order.items.map(item => 
                    `<div class="order-item">
                        <span class="item-name">${item.qty}x ${item.name}</span>
                        <span>Rp ${item.price.toLocaleString('id-ID')}</span>
                    </div>`
                ).join('');

                let actionButtons = '';
                if (order.status === 'pending' || order.status === 'pickup') {
                    actionButtons = `
                        <button class="btn btn-primary" onclick="updateStatus('${order.id}', 'delivering')">
                            🚚 Mulai Pengiriman
                        </button>
                    `;
                } else if (order.status === 'delivering') {
                    actionButtons = `
                        <button class="btn btn-success" onclick="updateStatus('${order.id}', 'delivered')">
                            ✓ Selesai Dikirim
                        </button>
                    `;
                }

                return `
                    <div class="order-card" data-id="${order.id}" data-status="${order.status}" data-area="${order.area}">
                        <div class="order-header">
                            <div class="order-id">${order.id}</div>
                            <div class="order-status ${statusClass}">${statusText}</div>
                        </div>
                        <div class="order-body">
                            <div class="customer-info">
                                <div class="info-row">
                                    <div class="info-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="info-content">
                                        <h4>Customer</h4>
                                        <p>${order.customer}</p>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div class="info-content">
                                        <h4>Telepon</h4>
                                        <p>${order.phone}</p>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="info-content">
                                        <h4>Alamat Pengiriman</h4>
                                        <p>${order.address}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="order-summary">
                                <h4>Ringkasan Pesanan</h4>
                                <div class="order-items">
                                    ${itemsList}
                                </div>
                                <div class="order-total">
                                    <span>Total:</span>
                                    <span>Rp ${order.total.toLocaleString('id-ID')}</span>
                                </div>
                            </div>
                        </div>
                        <div class="order-actions">
                            <button class="btn btn-info" onclick="showDetail('${order.id}')">
                                📋 Detail
                            </button>
                            ${actionButtons}
                            <button class="btn btn-secondary" onclick="callCustomer('${order.phone}')">
                                📞 Hubungi
                            </button>
                        </div>
                    </div>
                `;
            }).join('');

            updateStats();
        }

        // Update statistics
        function updateStats() {
            const pending = ordersData.filter(o => o.status === 'pending' || o.status === 'pickup').length;
            const delivering = ordersData.filter(o => o.status === 'delivering').length;
            
            document.getElementById('pendingCount').textContent = pending;
            document.getElementById('deliveringCount').textContent = delivering;
        }

        // Filter functionality
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('areaFilter').addEventListener('change', applyFilters);
        document.getElementById('searchBox').addEventListener('input', applyFilters);

        function applyFilters() {
            const statusFilter = document.getElementById('statusFilter').value;
            const areaFilter = document.getElementById('areaFilter').value;
            const searchTerm = document.getElementById('searchBox').value.toLowerCase();

            let filtered = ordersData;

            if (statusFilter !== 'all') {
                filtered = filtered.filter(order => order.status === statusFilter);
            }

            if (areaFilter !== 'all') {
                filtered = filtered.filter(order => order.area === areaFilter);
            }

            if (searchTerm) {
                filtered = filtered.filter(order => 
                    order.id.toLowerCase().includes(searchTerm) ||
                    order.customer.toLowerCase().includes(searchTerm)
                );
            }

            renderOrders(filtered);
        }

        // Show detail modal
        function showDetail(orderId) {
            const order = ordersData.find(o => o.id === orderId);
            if (!order) return;

            document.getElementById('modalOrderId').textContent = `Order ID: ${order.id}`;
            
            const itemsList = order.items.map(item => 
                `<div class="order-item">
                    <span class="item-name">${item.qty}x ${item.name}</span>
                    <span>Rp ${item.price.toLocaleString('id-ID')}</span>
                </div>`
            ).join('');

            document.getElementById('modalBody').innerHTML = `
                <div class="form-group">
                    <label>Customer</label>
                    <div class="form-control" style="background: #f5f5f5;">${order.customer}</div>
                </div>
                <div class="form-group">
                    <label>Telepon</label>
                    <div class="form-control" style="background: #f5f5f5;">${order.phone}</div>
                </div>
                <div class="form-group">
                    <label>Alamat Pengiriman</label>
                    <div class="form-control" style="background: #f5f5f5;">${order.address}</div>
                </div>
                <div class="form-group">
                    <label>Tanggal Order</label>
                    <div class="form-control" style="background: #f5f5f5;">${order.orderDate}</div>
                </div>
                <div class="form-group">
                    <label>Items</label>
                    <div style="background: #f9f9f9; padding: 15px; border-radius: 10px;">
                        ${itemsList}
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #dee2e6; display: flex; justify-content: space-between; font-weight: 700; font-size: 1.2em; color: #FF8C42;">
                            <span>Total:</span>
                            <span>Rp ${order.total.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('detailModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Update status
        let currentOrderUpdate = null;
        let currentStatusUpdate = null;

        function updateStatus(orderId, newStatus) {
            currentOrderUpdate = orderId;
            currentStatusUpdate = newStatus;

            const order = ordersData.find(o => o.id === orderId);
            if (!order) return;

            const statusText = {
                'delivering': 'Mulai Pengiriman',
                'delivered': 'Selesai Dikirim'
            }[newStatus];

            document.getElementById('statusModalOrderId').textContent = `${order.id} - ${statusText}`;
            document.getElementById('statusNote').value = '';
            
            const confirmBtn = document.getElementById('confirmStatusBtn');
            confirmBtn.onclick = () => confirmStatusUpdate();

            document.getElementById('statusModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function confirmStatusUpdate() {
            const note = document.getElementById('statusNote').value;
            const order = ordersData.find(o => o.id === currentOrderUpdate);
            
            if (order) {
                if (currentStatusUpdate === 'delivered') {
                    // Remove from list when delivered
                    ordersData = ordersData.filter(o => o.id !== currentOrderUpdate);
                    const completedCount = document.getElementById('completedCount');
                    completedCount.textContent = parseInt(completedCount.textContent) + 1;
                } else {
                    order.status = currentStatusUpdate;
                }

                const statusText = {
                    'delivering': 'dimulai',
                    'delivered': 'diselesaikan'
                }[currentStatusUpdate];

                alert(`✅ Pengiriman berhasil ${statusText}!\n${note ? 'Catatan: ' + note : ''}`);
                
                closeStatusModal();
                applyFilters();
            }
        }

        // Call customer
        function callCustomer(phone) {
            if (confirm(`Hubungi customer di ${phone}?`)) {
                window.location.href = `tel:${phone}`;
            }
        }

        // Modal functions
        function closeModal() {
            document.getElementById('detailModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.remove('active');
            document.body.style.overflow = 'auto';
            currentOrderUpdate = null;
            currentStatusUpdate = null;
        }

        // Close modals when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('statusModal').addEventListener('click', function(e) {
            if (e.target === this) closeStatusModal();
        });

        // Initialize
        renderOrders();