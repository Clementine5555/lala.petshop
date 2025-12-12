<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groomer Profile - {{ $groomer->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #FF8C42; /* Warna background sama dengan index */
            min-height: 100vh;
            padding: 40px 20px;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* --- Tombol Kembali --- */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 30px;
            backdrop-filter: blur(5px);
            transition: all 0.3s;
        }
        .btn-back:hover {
            background: white;
            color: #F57C00;
            transform: translateX(-5px);
        }

        /* --- Layout Grid --- */
        .profile-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
        }

        /* --- Kartu Umum (Style mirip index) --- */
        .card {
            background: rgba(255,255,255,0.95);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
        }

        /* --- Kartu Profil (Kiri) --- */
        .profile-card {
            text-align: center;
            height: fit-content;
        }
        .profile-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 120px;
            background: linear-gradient(135deg, #FF9800, #F57C00);
            border-radius: 30px 30px 50% 50%;
        }
        .avatar-container {
            position: relative;
            margin-bottom: 20px;
            margin-top: 40px;
        }
        .avatar {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            border: 5px solid white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 3em;
            font-weight: 800;
            color: #F57C00;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .profile-name {
            font-size: 1.8em;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        .profile-role {
            display: inline-block;
            padding: 6px 18px;
            background: #fff3e0;
            color: #F57C00;
            border-radius: 50px;
            font-size: 0.9em;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .profile-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .btn-action {
            flex: 1;
            padding: 12px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s;
            border: none;
            cursor: pointer;
            text-align: center;
        }
        .btn-edit {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
            box-shadow: 0 5px 15px rgba(245, 124, 0, 0.3);
        }
        .btn-edit:hover { transform: translateY(-3px); }

        /* --- Kartu Detail (Kanan) --- */
        .details-section h2 {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .info-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        .info-item label {
            display: block;
            font-size: 0.85em;
            color: #888;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-item p {
            font-size: 1.1em;
            font-weight: 600;
            color: #333;
            background: #fff8f4;
            padding: 12px 15px;
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* --- Stats Mini --- */
        .mini-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        .stat-box {
            background: linear-gradient(135deg, #fff, #fff8f0);
            padding: 15px;
            border-radius: 15px;
            text-align: center;
            border: 1px solid #ffe0b2;
        }
        .stat-value {
            font-size: 1.5em;
            font-weight: 800;
            color: #F57C00;
        }
        .stat-label {
            font-size: 0.8em;
            color: #666;
        }

        @media (max-width: 850px) {
            .profile-grid { grid-template-columns: 1fr; }
            .profile-card::before { height: 100px; }
        }
    </style>
</head>
<body>

<div class="container">
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('groomers.index') }}" class="btn-back">← Back to List</a>
    @else
    <a href="{{ route('groomer.index') }}" class="btn-back">← Back to Dashboard</a>
    @endif

    <div class="profile-grid">

        <div class="card profile-card">
            <div class="avatar-container">
                <div class="avatar">
                    {{ strtoupper(substr($groomer->name, 0, 1)) }}
                </div>
            </div>
            <h1 class="profile-name">{{ $groomer->name }}</h1>
            <span class="profile-role">
                    {{ ucfirst($groomer->role) }} Staff
                </span>

            <div style="margin: 20px 0; color: #666; font-size: 0.95em;">
                <p>Joined {{ $groomer->created_at->format('d M Y') }}</p>
            </div>

            @if(auth()->user()->role === 'admin')
            <div class="profile-actions">
                <a href="{{ route('groomers.edit', $groomer->user_id) }}" class="btn-action btn-edit">Edit Profile</a>
            </div>
            @endif
        </div>

        <div class="card details-section">
            <h2>👤 Personal Information</h2>

            <div class="info-group">
                <div class="info-item">
                    <label>Full Name</label>
                    <p>{{ $groomer->name }}</p>
                </div>
                <div class="info-item">
                    <label>Phone Number</label>
                    <p>{{ $groomer->phone ?? '-' }}</p>
                </div>
                <div class="info-item">
                    <label>Email Address</label>
                    <p>{{ $groomer->email }}</p>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <p style="color: #2e7d32; background: #e8f5e9;">Active</p>
                </div>
            </div>

            @if(isset($groomer->address))
            <div class="info-item" style="margin-bottom: 30px;">
                <label>Address</label>
                <p>{{ $groomer->address }}</p>
            </div>
            @endif

            @if(isset($groomer->total_appointments_completed))
            <h2>📊 Performance Stats</h2>
            <div class="mini-stats">
                <div class="stat-box">
                    <div class="stat-value">{{ $groomer->total_appointments_completed ?? 0 }}</div>
                    <div class="stat-label">Completed</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $groomer->total_hours_worked ?? 0 }}</div>
                    <div class="stat-label">Hours</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">5.0</div>
                    <div class="stat-label">Rating</div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

</body>
</html>
