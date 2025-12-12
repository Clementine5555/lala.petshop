<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Saya - Petshop Lala</title>
    <style>
        /* Reusing exact same style as My Orders */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #FF8C42; min-height: 100vh; padding: 20px; padding-top: 80px; }

        .container { max-width: 1000px; margin: 0 auto; }

        /* Header */
        .page-header { background: white; border-radius: 20px; padding: 30px; margin-bottom: 25px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); display: flex; justify-content: space-between; align-items: center; }
        .header-title h1 { font-size: 1.8em; color: #333; margin-bottom: 5px; }
        .header-title p { color: #666; }

        /* Filter */
        .filter-bar { background: white; padding: 15px 25px; border-radius: 15px; margin-bottom: 25px; display: flex; gap: 15px; align-items: center; }
        .filter-btn { background: none; border: none; padding: 8px 16px; border-radius: 20px; cursor: pointer; font-weight: 600; color: #666; transition: all 0.3s; }
        .filter-btn:hover { background: #fff3e0; color: #FF8C42; }
        .filter-btn.active { background: #FF8C42; color: white; }

        /* Card List */
        .orders-list { display: flex; flex-direction: column; gap: 20px; }
        .order-card { background: white; border-radius: 18px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; border-left: 5px solid #FF8C42; transition: transform 0.3s; }
        .order-card:hover { transform: translateY(-3px); }

        .card-header { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; }
        .order-id { font-weight: 800; font-size: 1.1em; color: #333; }
        .order-date { font-size: 0.9em; color: #999; }

        .status-pill { padding: 6px 14px; border-radius: 20px; font-size: 0.85em; font-weight: 700; }
        .st-pending { background: #fff3cd; color: #856404; }
        .st-confirmed { background: #d1ecf1; color: #0c5460; }
        .st-completed { background: #d4edda; color: #155724; }
        .st-cancelled { background: #f8d7da; color: #721c24; }

        .card-body { display: grid; grid-template-columns: 1fr auto; gap: 20px; }
        .info-row { font-size: 0.95em; color: #555; margin-bottom: 5px; }
        .info-row strong { color: #333; }

        .price-val { font-size: 1.2em; font-weight: 800; color: #FF8C42; text-align: right; }

        .card-footer { margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee; display: flex; justify-content: flex-end; }
        .btn-detail { padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; background: #e3f2fd; color: #1976d2; text-decoration: none; }
        .btn-detail:hover { background: #bbdefb; }

        .empty-state { text-align: center; padding: 50px; background: white; border-radius: 20px; }
    </style>
</head>
<body>

@include('components.navbar')

<div class="container">

    <div class="page-header">
        <div class="header-title">
            <h1>📅 Appointment Saya</h1>
            <p>Riwayat booking grooming dan perawatan hewan</p>
        </div>
    </div>

    <div class="filter-bar">
        <button class="filter-btn active" onclick="filterData('all', this)">Semua</button>
        <button class="filter-btn" onclick="filterData('pending', this)">Menunggu</button>
        <button class="filter-btn" onclick="filterData('confirmed', this)">Disetujui</button>
        <button class="filter-btn" onclick="filterData('completed', this)">Selesai</button>
    </div>

    <div class="orders-list" id="listContainer"></div>

</div>

<script>
    const appointments = {!! json_encode($appointmentsForJs ?? []) !!};

    const statusConfig = {
        'pending':   { text: 'Menunggu Konfirmasi', class: 'st-pending' },
        'confirmed': { text: 'Disetujui',           class: 'st-confirmed' },
        'completed': { text: 'Selesai',             class: 'st-completed' },
        'cancelled': { text: 'Dibatalkan',          class: 'st-cancelled' }
    };

    function renderList(filter = 'all') {
        const list = document.getElementById('listContainer');
        let html = '';

        let filtered = appointments;
        if (filter !== 'all') {
            filtered = appointments.filter(a => a.status === filter);
        }

        if (filtered.length === 0) {
            list.innerHTML = `<div class="empty-state"><h3>Belum ada appointment</h3><p>Yuk booking perawatan untuk anabulmu!</p><a href="{{ route('appointment.create') }}" style="display:inline-block; margin-top:10px; color:#FF8C42; font-weight:bold;">Booking Sekarang &rarr;</a></div>`;
            return;
        }

        filtered.forEach(a => {
            const config = statusConfig[a.status] || { text: a.status, class: 'st-pending' };

            html += `
            <div class="order-card">
                <div class="card-header">
                    <div>
                        <div class="order-id">${a.id}</div>
                        <div class="order-date">${a.date} • ${a.time}</div>
                    </div>
                    <span class="status-pill ${config.class}">${config.text}</span>
                </div>
                <div class="card-body">
                    <div class="info-section">
                        <div class="info-row"><strong>Pet:</strong> ${a.pet_name} (${a.pet_type})</div>
                        <div class="info-row"><strong>Layanan:</strong> ${a.service}</div>
                        <div class="info-row"><strong>Groomer:</strong> ${a.groomer}</div>
                        ${a.notes ? `<div class="info-row" style="color:#888; font-style:italic; margin-top:5px;">"${a.notes}"</div>` : ''}
                    </div>
                    <div class="price-val">Rp ${parseInt(a.price).toLocaleString('id-ID')}</div>
                </div>
            </div>`;
        });

        list.innerHTML = html;
    }

    function filterData(status, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        renderList(status);
    }

    // Init
    renderList();
</script>

@include('layouts.footer')

</body>
</html>
