<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groomer Dashboard - Pet Care Pro</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #FF8C42;
            min-height: 100vh;
            padding: 20px;
        }
        .logout-btn {
            position: fixed;
            top: 30px;
            left: 30px;
            background: rgba(255,255,255,0.95);
            padding: 12px 28px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-weight: 700;
            color: #F57C00;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }
        .logout-btn:hover {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
            transform: translateY(-3px);
        }
        .container { max-width: 1400px; margin: 80px auto 0; }
        .header {
            background: rgba(255,255,255,0.95);
            padding: 45px;
            border-radius: 30px;
            margin-bottom: 35px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
        }
        .header-content { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; }
        .header-left h1 {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .header-left p { color: #666; font-size: 1.2em; }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 30px 12px 12px;
            background: linear-gradient(135deg, #FF9800, #F57C00);
            border-radius: 50px;
            color: white;
        }
        .user-avatar {
            width: 55px;
            height: 55px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #F57C00;
            font-weight: 700;
            font-size: 1.4em;
        }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px; margin-bottom: 35px; }
        .stat-card {
            background: rgba(255,255,255,0.95);
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #FF9800, #F57C00);
        }
        .stat-card:hover { transform: translateY(-10px); }
        .stat-card h3 { color: #888; font-size: 0.9em; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px; }
        .stat-card .number {
            font-size: 3em;
            font-weight: 800;
            background: linear-gradient(135deg, #FF9800, #F57C00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .stat-card .icon { position: absolute; right: 20px; bottom: 20px; font-size: 3em; opacity: 0.1; }
        .appointments-section {
            background: rgba(255,255,255,0.95);
            padding: 45px;
            border-radius: 30px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.2);
        }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; flex-wrap: wrap; gap: 20px; }
        .section-header h2 { color: #333; font-size: 2em; }
        .filter-tabs { display: flex; gap: 10px; background: #f5f5f5; padding: 6px; border-radius: 50px; flex-wrap: wrap; }
        .filter-tab {
            padding: 12px 24px;
            background: transparent;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            color: #666;
            transition: all 0.3s;
        }
        .filter-tab.active {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
        }
        .appointments-list { display: flex; flex-direction: column; gap: 20px; }
        .appointment-card {
            background: linear-gradient(135deg, #fff, #fff8f0);
            padding: 25px;
            border-radius: 20px;
            border-left: 6px solid;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 25px;
            align-items: center;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        .appointment-card:hover { transform: translateX(10px); box-shadow: 0 12px 35px rgba(255,152,0,0.25); }
        .appointment-card[data-status="pending"] { border-left-color: #FFA726; }
        .appointment-card[data-status="inprogress"] { border-left-color: #42A5F5; }
        .appointment-card[data-status="completed"] { border-left-color: #66BB6A; opacity: 0.8; }
        .appointment-card.hidden { display: none; }
        .appointment-info h4 { color: #333; margin-bottom: 8px; font-size: 1.2em; }
        .appointment-info p { color: #666; font-size: 0.95em; margin-bottom: 4px; }
        .pet-details h4 { color: #333; margin-bottom: 10px; font-size: 1.1em; }
        .pet-tag { display: inline-block; padding: 6px 14px; background: white; border-radius: 20px; font-size: 0.85em; color: #666; margin: 4px 4px 4px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .service-item { font-size: 0.95em; color: #666; margin-bottom: 5px; }
        .action-buttons { display: flex; flex-direction: column; gap: 10px; }
        .btn {
            padding: 12px 22px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 0.9em;
        }
        .btn-start { background: linear-gradient(135deg, #FF9800, #F57C00); color: white; }
        .btn-complete { background: linear-gradient(135deg, #66BB6A, #43A047); color: white; }
        .btn-view { background: linear-gradient(135deg, #42A5F5, #1E88E5); color: white; }
        .btn:hover { transform: translateY(-2px); }
        .status-badge { padding: 10px 18px; border-radius: 25px; font-size: 0.8em; font-weight: 700; text-transform: uppercase; text-align: center; }
        .status-pending { background: linear-gradient(135deg, #FFE082, #FFD54F); color: #F57F17; }
        .status-inprogress { background: linear-gradient(135deg, #81D4FA, #4FC3F7); color: #01579B; }
        .status-completed { background: linear-gradient(135deg, #A5D6A7, #81C784); color: #1B5E20; }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: white;
            border-radius: 30px;
            padding: 40px;
            max-width: 550px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease-out;
        }
        @keyframes slideUp { from { opacity: 0; transform: translateY(50px); } to { opacity: 1; transform: translateY(0); } }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0; }
        .modal-header h2 {
            font-size: 1.6em;
            background: linear-gradient(135deg, #FF9800, #F57C00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .close-modal {
            background: #f5f5f5;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.3em;
            transition: all 0.3s;
        }
        .close-modal:hover { background: #FF9800; color: white; transform: rotate(90deg); }
        .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
        .info-label { font-weight: 600; color: #666; }
        .info-value { font-weight: 700; color: #333; }
        .checklist { margin: 20px 0; }
        .checklist h3 { color: #333; margin-bottom: 15px; font-size: 1.2em; }
        .checklist-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #fff8f0;
            border-radius: 12px;
            margin-bottom: 10px;
        }
        .checklist-item input { width: 22px; height: 22px; accent-color: #FF9800; cursor: pointer; }
        .checklist-item label { flex: 1; cursor: pointer; }
        .modal-footer { display: flex; gap: 12px; justify-content: flex-end; margin-top: 25px; }
        .btn-modal { padding: 14px 30px; border: none; border-radius: 12px; cursor: pointer; font-weight: 600; transition: all 0.3s; }
        .btn-cancel { background: #f5f5f5; color: #666; }
        .btn-finish { background: linear-gradient(135deg, #66BB6A, #43A047); color: white; }
        .btn-finish:hover { transform: translateY(-2px); }
        .progress-section { margin: 20px 0; }
        .progress-bar { width: 100%; height: 10px; background: #e0e0e0; border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #FF9800, #F57C00); transition: width 0.3s; }
        .timer { text-align: center; font-size: 2em; font-weight: 700; color: #FF9800; margin: 15px 0; }
        @media (max-width: 1024px) {
            .appointment-card { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: row; flex-wrap: wrap; }
        }
        @media (max-width: 768px) {
            .logout-btn { top: 15px; left: 15px; padding: 10px 20px; font-size: 0.85em; }
            .container { margin-top: 70px; }
            .header { padding: 25px; }
            .header-left h1 { font-size: 1.8em; }
            .appointments-section { padding: 25px; }
            .modal-footer { flex-direction: column; }
            .btn-modal { width: 100%; }
        }
    </style>
</head>
<body>
    <button class="logout-btn" onclick="logout()">
        <span>🚪</span>
        <span>Logout</span>
    </button>
    <div class="container">
        @isset($groomers)
        <!-- Simple Groomers Listing (rendered when controller provides $groomers) -->
        <div style="background: white; padding: 30px; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.08); margin-bottom:24px;">
            <h2 style="font-size:1.6em; color:#333; margin-bottom:12px;">Groomers</h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:16px;">
                @foreach($groomers as $g)
                    <div style="padding:14px; border-radius:12px; background:#fff8f4; border:1px solid rgba(0,0,0,0.03);">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                            <div style="width:48px;height:48px;border-radius:50%;background:#fff;color:#F57C00;display:flex;align-items:center;justify-content:center;font-weight:700;">{{ strtoupper(substr($g->name,0,1)) }}</div>
                            <div>
                                <div style="font-weight:700;color:#333">{{ $g->name }}</div>
                                <div style="font-size:0.9em;color:#666">{{ $g->email }}</div>
                            </div>
                        </div>
                        <div style="font-size:0.9em;color:#666;margin-bottom:10px">{{ $g->address ?? '-' }}</div>
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('groomers.show', $g->groomer_id) }}" style="padding:8px 12px;border-radius:10px;background:#FF8C42;color:white;text-decoration:none;font-weight:700">View</a>
                            @can('update', $g)
                                <a href="{{ route('groomers.edit', $g->groomer_id) }}" style="padding:8px 12px;border-radius:10px;background:#eee;color:#333;text-decoration:none;font-weight:700">Edit</a>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
            <div style="margin-top:16px">{{ $groomers->links() }}</div>
        </div>
        @endisset
        <div class="header">
            <div class="header-content">
                <div class="header-left">
                    <h1>Welcome Back! 👋</h1>
                    <p>Ready to make some pets look amazing today?</p>
                </div>
                <div class="user-info">
                    <div class="user-avatar">G</div>
                    <span class="user-name">Groomer Pro</span>
                </div>
            </div>
        </div>
        <div class="stats-grid">
            <div class="stat-card"><h3>Today's Appointments</h3><div class="number" id="totalCount">{{ $todayCount ?? 0 }}</div><div class="icon">📅</div></div>
            <div class="stat-card"><h3>Pending</h3><div class="number" id="pendingCount">{{ $pendingCount ?? 0 }}</div><div class="icon">⏳</div></div>
            <div class="stat-card"><h3>In Progress</h3><div class="number" id="progressCount">{{ $inprogressCount ?? 0 }}</div><div class="icon">🔄</div></div>
            <div class="stat-card"><h3>Completed</h3><div class="number" id="completedCount">{{ $completedCount ?? 0 }}</div><div class="icon">✅</div></div>
        </div>
        <div class="appointments-section">
            <div class="section-header">
                <h2>📋 Today's Schedule</h2>
                <div class="filter-tabs">
                    <button class="filter-tab active" onclick="filterAppointments(event, 'all')">All</button>
                    <button class="filter-tab" onclick="filterAppointments(event, 'pending')">Pending</button>
                    <button class="filter-tab" onclick="filterAppointments(event, 'inprogress')">In Progress</button>
                    <button class="filter-tab" onclick="filterAppointments(event, 'completed')">Completed</button>
                </div>
            </div>
            <div class="appointments-list" id="appointmentsList"></div>
        </div>
    </div>
    <div class="modal" id="progressModal">
        <div class="modal-content">
            <div class="modal-header"><h2>🐾 Grooming in Progress</h2><button class="close-modal" onclick="closeModal('progressModal')">×</button></div>
            <div class="modal-body">
                <div class="info-row"><span class="info-label">Pet Name</span><span class="info-value" id="progPetName">-</span></div>
                <div class="info-row"><span class="info-label">Service</span><span class="info-value" id="progService">-</span></div>
                <div class="progress-section"><h3>Progress</h3><div class="timer" id="timerDisplay">00:00</div><div class="progress-bar"><div class="progress-fill" id="progressFill" style="width:0%"></div></div></div>
                <div class="checklist"><h3>✅ Checklist</h3><div id="checklistItems"></div></div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal btn-cancel" onclick="closeModal('progressModal')">Cancel</button>
                <button class="btn-modal btn-finish" onclick="finishGrooming()">✓ Complete Grooming</button>
            </div>
        </div>
    </div>
    <div class="modal" id="viewModal">
        <div class="modal-content">
            <div class="modal-header"><h2>📋 Appointment Details</h2><button class="close-modal" onclick="closeModal('viewModal')">×</button></div>
            <div class="modal-body" id="viewDetails"></div>
            <div class="modal-footer"><button class="btn-modal btn-cancel" onclick="closeModal('viewModal')">Close</button></div>
        </div>
    </div>
<script>
const appointments = @json($appointmentsForJs ?? []);
let currentAppointment = null, timerInterval = null, seconds = 0;
const checklists = {
    "Full Grooming": ["Brushing","Bathing","Drying","Hair Cutting","Nail Trimming","Ear Cleaning","Perfume"],
    "Bath Only": ["Brushing","Bathing","Drying","Perfume"]
};
function renderAppointments() {
    const list = document.getElementById('appointmentsList');
    list.innerHTML = appointments.map(a => `
        <div class="appointment-card" data-status="${a.status}" data-id="${a.id}">
            <div class="appointment-info">
                <h4>🕐 ${a.time}</h4>
                <p>👤 ${a.customer}</p>
                <p style="color:#F57C00;font-weight:600">💰 ${a.payment}</p>
            </div>
            <div class="pet-details">
                <h4>${a.petName} ${a.petIcon}</h4>
                <div class="pet-tag">${a.petType}</div>
                <div class="pet-tag">⚖️ ${a.weight}</div>
                <div class="pet-tag">${a.gender === 'Male' ? '♂️' : '♀️'} ${a.gender}</div>
            </div>
            <div class="service-list">
                <div class="service-item">✨ ${a.service}</div>
                ${a.notes ? `<div class="service-item" style="color:#999;font-style:italic">📝 ${a.notes}</div>` : ''}
            </div>
            <div class="action-buttons">
                <span class="status-badge status-${a.status}">${a.status === 'inprogress' ? 'In Progress' : a.status.charAt(0).toUpperCase() + a.status.slice(1)}</span>
                ${a.status === 'pending' ? `<button class="btn btn-start" onclick="startGrooming(${a.id})">▶️ Start</button>` : ''}
                ${a.status === 'inprogress' ? `<button class="btn btn-complete" onclick="openProgressModal(${a.id})">✓ Complete</button>` : ''}
                ${a.status === 'completed' ? `<button class="btn btn-view" onclick="viewDetails(${a.id})">👁️ View</button>` : ''}
            </div>
        </div>
    `).join('');
    updateStats();
}
function updateStats() {
    // keep UI in sync if appointments are manipulated client-side; otherwise server counts are authoritative
    const total = appointments.length;
    if (total === 0) {
        // show friendly empty state
        document.getElementById('appointmentsList').innerHTML = '<div style="padding:28px;border-radius:12px;background:#fff8f0;color:#666">No appointments found for the selected period.</div>';
    }
    // Only update the numeric badges if they exist in the DOM
    const t = document.getElementById('totalCount'); if (t) t.textContent = total;
    const p = document.getElementById('pendingCount'); if (p) p.textContent = appointments.filter(a => a.status === 'pending').length;
    const pr = document.getElementById('progressCount'); if (pr) pr.textContent = appointments.filter(a => a.status === 'inprogress').length;
    const c = document.getElementById('completedCount'); if (c) c.textContent = appointments.filter(a => a.status === 'completed').length;
}
function filterAppointments(ev, filter) {
    try { document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active')); } catch(e){}
    if (ev && ev.target) ev.target.classList.add('active');
    document.querySelectorAll('.appointment-card').forEach(c => {
        c.classList.toggle('hidden', filter !== 'all' && c.dataset.status !== filter);
    });
}
function startGrooming(id) {
    const a = appointments.find(x => x.id === id);
    if (a) { a.status = 'inprogress'; renderAppointments(); openProgressModal(id); }
}
function openProgressModal(id) {
    currentAppointment = appointments.find(a => a.id === id);
    if (!currentAppointment) return;
    document.getElementById('progPetName').textContent = currentAppointment.petName;
    document.getElementById('progService').textContent = currentAppointment.service;
    const items = checklists[currentAppointment.service] || checklists["Bath Only"];
    document.getElementById('checklistItems').innerHTML = items.map((item, i) => `
        <div class="checklist-item"><input type="checkbox" id="check${i}" onchange="updateProgress()"><label for="check${i}">${item}</label></div>
    `).join('');
    seconds = 0; updateTimer();
    if (timerInterval) clearInterval(timerInterval);
    timerInterval = setInterval(() => { seconds++; updateTimer(); }, 1000);
    document.getElementById('progressModal').classList.add('active');
}
function updateTimer() {
    const m = Math.floor(seconds / 60), s = seconds % 60;
    document.getElementById('timerDisplay').textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
}
function updateProgress() {
    const checks = document.querySelectorAll('#checklistItems input');
    const done = Array.from(checks).filter(c => c.checked).length;
    document.getElementById('progressFill').style.width = `${(done / checks.length) * 100}%`;
}
function finishGrooming() {
    if (!currentAppointment) return;
    const checks = document.querySelectorAll('#checklistItems input');
    if (Array.from(checks).some(c => !c.checked)) { alert('Please complete all checklist items!'); return; }
    currentAppointment.status = 'completed';
    currentAppointment.completedAt = new Date().toLocaleTimeString('en-US', {hour:'2-digit',minute:'2-digit'});
    currentAppointment.duration = document.getElementById('timerDisplay').textContent;
    clearInterval(timerInterval);
    closeModal('progressModal');
    renderAppointments();
}
function viewDetails(id) {
    const a = appointments.find(x => x.id === id);
    if (!a) return;
    document.getElementById('viewDetails').innerHTML = `
        <div class="info-row"><span class="info-label">Time</span><span class="info-value">${a.time}</span></div>
        <div class="info-row"><span class="info-label">Customer</span><span class="info-value">${a.customer}</span></div>
        <div class="info-row"><span class="info-label">Payment</span><span class="info-value">${a.payment}</span></div>
        <div class="info-row"><span class="info-label">Pet Name</span><span class="info-value">${a.petName} ${a.petIcon}</span></div>
        <div class="info-row"><span class="info-label">Pet Type</span><span class="info-value">${a.petType}</span></div>
        <div class="info-row"><span class="info-label">Weight</span><span class="info-value">${a.weight}</span></div>
        <div class="info-row"><span class="info-label">Gender</span><span class="info-value">${a.gender}</span></div>
        <div class="info-row"><span class="info-label">Service</span><span class="info-value">${a.service}</span></div>
        ${a.notes ? `<div class="info-row"><span class="info-label">Notes</span><span class="info-value">${a.notes}</span></div>` : ''}
        ${a.completedAt ? `<div class="info-row"><span class="info-label">Completed At</span><span class="info-value">${a.completedAt}</span></div>` : ''}
        ${a.duration ? `<div class="info-row"><span class="info-label">Duration</span><span class="info-value">${a.duration}</span></div>` : ''}
    `;
    document.getElementById('viewModal').classList.add('active');
}
function closeModal(id) { document.getElementById(id).classList.remove('active'); if (id === 'progressModal') clearInterval(timerInterval); }
function logout() { alert('Logging out...'); }
renderAppointments();
</script>
</body>
</html>