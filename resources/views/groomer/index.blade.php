<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groomer Dashboard - Pet Care</title>
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
            padding: 20px;
        }

        .navbar {
            background: white;
            padding: 15px 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .logo {
            display: none;
        }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: color 0.3s;
        }

        .nav-links a.active {
            color: #FF8C42;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #FF8C42;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .header h1 {
            color: #FF8C42;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1em;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-card .number {
            font-size: 2.5em;
            font-weight: 700;
            color: #FF8C42;
        }

        .appointments-section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 {
            color: #333;
            font-size: 1.8em;
        }

        .filter-tabs {
            display: flex;
            gap: 10px;
        }

        .filter-tab {
            padding: 10px 20px;
            background: #f5f5f5;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .filter-tab.active {
            background: #FF8C42;
            color: white;
        }

        .appointments-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .appointment-card {
            background: #FFF5EB;
            padding: 20px;
            border-radius: 15px;
            border-left: 5px solid #FF8C42;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 20px;
            align-items: center;
            transition: all 0.3s;
        }

        .appointment-card:hover {
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.2);
        }

        .appointment-card.completed {
            opacity: 0.7;
            border-left-color: #4CAF50;
        }

        .appointment-info h4 {
            color: #333;
            margin-bottom: 5px;
        }

        .appointment-info p {
            color: #666;
            font-size: 0.9em;
        }

        .pet-details {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pet-tag {
            display: inline-block;
            padding: 3px 10px;
            background: white;
            border-radius: 12px;
            font-size: 0.85em;
            color: #666;
            width: fit-content;
        }

        .service-list {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .service-item {
            font-size: 0.9em;
            color: #666;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-complete {
            background: #4CAF50;
            color: white;
        }

        .btn-complete:hover {
            background: #45a049;
        }

        .btn-view {
            background: #2196F3;
            color: white;
        }

        .btn-view:hover {
            background: #0b7dda;
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending {
            background: #FFF3CD;
            color: #856404;
        }

        .status-inprogress {
            background: #D1ECF1;
            color: #0C5460;
        }

        .status-completed {
            background: #D4EDDA;
            color: #155724;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @media (max-width: 1024px) {
            .appointment-card {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                justify-content: flex-start;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            .nav-left {
                flex-direction: column;
                gap: 15px;
            }

            .header h1 {
                font-size: 1.8em;
            }

            .filter-tabs {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-left">
            <div class="logo"></div>
            <ul class="nav-links">
                <li><a href="/" class="active">Dashboard</a></li>
                <li><a href="/schedule">Schedule</a></li>
                <li><a href="/history">History</a></li>
            </ul>
        </div>
        <div class="user-info">
            <div class="user-avatar">G</div>
            <span style="font-weight: 600; color: #333;">Groomer Name</span>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Welcome Back, Groomer!</h1>
            <p>Here's your schedule for today</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Today's Appointments</h3>
                <div class="number">5</div>
            </div>
            <div class="stat-card">
                <h3>Pending</h3>
                <div class="number">3</div>
            </div>
            <div class="stat-card">
                <h3>In Progress</h3>
                <div class="number">1</div>
            </div>
            <div class="stat-card">
                <h3>Completed</h3>
                <div class="number">1</div>
            </div>
        </div>

        <div class="appointments-section">
            <div class="section-header">
                <h2>Today's Appointments</h2>
                <div class="filter-tabs">
                    <button class="filter-tab active" onclick="filterAppointments('all')">All</button>
                    <button class="filter-tab" onclick="filterAppointments('pending')">Pending</button>
                    <button class="filter-tab" onclick="filterAppointments('inprogress')">In Progress</button>
                    <button class="filter-tab" onclick="filterAppointments('completed')">Completed</button>
                </div>
            </div>

            <div class="appointments-list" id="appointmentsList">
                <!-- Appointment 1 -->
                <div class="appointment-card" data-status="pending">
                    <div class="appointment-info">
                        <h4>09:00 AM</h4>
                        <p>Customer: John Doe</p>
                        <p style="color: #FF8C42; font-weight: 600;">Payment: Cash</p>
                    </div>
                    <div class="pet-details">
                        <h4 style="color: #333;">Max</h4>
                        <div class="pet-tag">🐕 Dog - Golden Retriever</div>
                        <div class="pet-tag">⚖️ 25 kg - Male</div>
                    </div>
                    <div class="service-list">
                        <div class="service-item">✓ Full Grooming</div>
                        <div class="service-item" style="color: #999; font-style: italic;">Note: Sensitive to loud noises</div>
                    </div>
                    <div class="action-buttons">
                        <span class="status-badge status-pending">Pending</span>
                        <button class="btn btn-complete" onclick="markComplete(this)">Start</button>
                    </div>
                </div>

                <!-- Appointment 2 -->
                <div class="appointment-card" data-status="inprogress">
                    <div class="appointment-info">
                        <h4>10:30 AM</h4>
                        <p>Customer: Sarah Smith</p>
                        <p style="color: #FF8C42; font-weight: 600;">Payment: Bank Transfer (Paid)</p>
                    </div>
                    <div class="pet-details">
                        <h4 style="color: #333;">Luna</h4>
                        <div class="pet-tag">🐱 Cat - Persian</div>
                        <div class="pet-tag">⚖️ 4 kg - Female</div>
                    </div>
                    <div class="service-list">
                        <div class="service-item">✓ Bath Only</div>
                    </div>
                    <div class="action-buttons">
                        <span class="status-badge status-inprogress">In Progress</span>
                        <button class="btn btn-complete" onclick="markComplete(this)">Complete</button>
                    </div>
                </div>

                <!-- Appointment 3 -->
                <div class="appointment-card completed" data-status="completed">
                    <div class="appointment-info">
                        <h4>08:00 AM</h4>
                        <p>Customer: Mike Johnson</p>
                        <p style="color: #FF8C42; font-weight: 600;">Payment: GoPay (Paid)</p>
                    </div>
                    <div class="pet-details">
                        <h4 style="color: #333;">Buddy</h4>
                        <div class="pet-tag">🐕 Dog - Beagle</div>
                        <div class="pet-tag">⚖️ 12 kg - Male</div>
                    </div>
                    <div class="service-list">
                        <div class="service-item">✓ Full Grooming</div>
                    </div>
                    <div class="action-buttons">
                        <span class="status-badge status-completed">Completed</span>
                        <button class="btn btn-view" onclick="viewDetails(this)">View</button>
                    </div>
                </div>

                <!-- Appointment 4 -->
                <div class="appointment-card" data-status="pending">
                    <div class="appointment-info">
                        <h4>01:00 PM</h4>
                        <p>Customer: Emily Brown</p>
                        <p style="color: #FF8C42; font-weight: 600;">Payment: Cash</p>
                    </div>
                    <div class="pet-details">
                        <h4 style="color: #333;">Bella</h4>
                        <div class="pet-tag">🐕 Dog - Poodle</div>
                        <div class="pet-tag">⚖️ 8 kg - Female</div>
                    </div>
                    <div class="service-list">
                        <div class="service-item">✓ Bath Only</div>
                        <div class="service-item" style="color: #999; font-style: italic;">Note: Use warm water</div>
                    </div>
                    <div class="action-buttons">
                        <span class="status-badge status-pending">Pending</span>
                        <button class="btn btn-complete" onclick="markComplete(this)">Start</button>
                    </div>
                </div>

                <!-- Appointment 5 -->
                <div class="appointment-card" data-status="pending">
                    <div class="appointment-info">
                        <h4>03:00 PM</h4>
                        <p>Customer: David Lee</p>
                        <p style="color: #FF8C42; font-weight: 600;">Payment: Bank Transfer (Paid)</p>
                    </div>
                    <div class="pet-details">
                        <h4 style="color: #333;">Charlie</h4>
                        <div class="pet-tag">🐱 Cat - Siamese</div>
                        <div class="pet-tag">⚖️ 5 kg - Male</div>
                    </div>
                    <div class="service-list">
                        <div class="service-item">✓ Full Grooming</div>
                    </div>
                    <div class="action-buttons">
                        <span class="status-badge status-pending">Pending</span>
                        <button class="btn btn-complete" onclick="markComplete(this)">Start</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterAppointments(status) {
            const tabs = document.querySelectorAll('.filter-tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');

            const appointments = document.querySelectorAll('.appointment-card');
            
            appointments.forEach(card => {
                if (status === 'all') {
                    card.style.display = 'grid';
                } else {
                    if (card.dataset.status === status) {
                        card.style.display = 'grid';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        }

        function markComplete(button) {
            const card = button.closest('.appointment-card');
            const statusBadge = card.querySelector('.status-badge');
            
            if (statusBadge.textContent === 'Pending') {
                // Change to In Progress
                statusBadge.textContent = 'In Progress';
                statusBadge.className = 'status-badge status-inprogress';
                button.textContent = 'Complete';
                card.dataset.status = 'inprogress';
            } else if (statusBadge.textContent === 'In Progress') {
                // Change to Completed
                statusBadge.textContent = 'Completed';
                statusBadge.className = 'status-badge status-completed';
                button.textContent = 'View';
                button.className = 'btn btn-view';
                button.onclick = function() { viewDetails(this); };
                card.classList.add('completed');
                card.dataset.status = 'completed';
                
                // Update stats
                updateStats();
            }
        }

        function viewDetails(button) {
            alert('View appointment details (functionality to be implemented)');
        }

        function updateStats() {
            const pending = document.querySelectorAll('[data-status="pending"]').length;
            const inprogress = document.querySelectorAll('[data-status="inprogress"]').length;
            const completed = document.querySelectorAll('[data-status="completed"]').length;
            
            document.querySelectorAll('.stat-card')[1].querySelector('.number').textContent = pending;
            document.querySelectorAll('.stat-card')[2].querySelector('.number').textContent = inprogress;
            document.querySelectorAll('.stat-card')[3].querySelector('.number').textContent = completed;
        }
    </script>
</body>
</html>