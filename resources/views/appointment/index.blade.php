<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmed</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #FFF5EB 0%, #FFE5D9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .confirmation-container {
            background: white;
            border-radius: 30px;
            padding: 60px 50px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-icon svg {
            width: 60px;
            height: 60px;
            stroke: white;
            stroke-width: 3;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 15px;
            font-weight: 800;
        }

        .subtitle {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .info-box {
            background: #FFF5EB;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #FFE5D9;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row label {
            color: #666;
            font-weight: 600;
        }

        .info-row span {
            color: #333;
            font-weight: 700;
        }

        .alert-warning {
            background: #FFF3CD;
            border-left: 4px solid #FFC107;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: left;
        }

        .alert-warning strong {
            color: #856404;
            display: block;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .alert-warning p {
            color: #856404;
            line-height: 1.6;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 18px;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 140, 66, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #FF8C42;
            border: 2px solid #FF8C42;
        }

        .btn-secondary:hover {
            background: #FFF5EB;
        }

        @media (max-width: 768px) {
            .confirmation-container {
                padding: 40px 30px;
            }

            h1 {
                font-size: 2em;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <h1>Appointment Confirmed!</h1>
        <p class="subtitle">Your appointment has been successfully submitted and is waiting for admin confirmation.</p>

        @if(session('appointment'))
        <div class="info-box">
            <div class="info-row">
                <label>Pet Name:</label>
                <span>{{ session('appointment.pet_name') }}</span>
            </div>
            <div class="info-row">
                <label>Date:</label>
                <span>{{ session('appointment.appointment_date') }}</span>
            </div>
            <div class="info-row">
                <label>Time:</label>
                <span>{{ session('appointment.appointment_time') }}</span>
            </div>
            <div class="info-row">
                <label>Service:</label>
                <span>{{ session('appointment.services') }}</span>
            </div>
            <div class="info-row">
                <label>Total Price:</label>
                <span>Rp {{ number_format(session('appointment.total_price'), 0, ',', '.') }}</span>
            </div>
        </div>
        @endif

        <div class="alert-warning">
            <strong>⏳ Waiting for Confirmation</strong>
            <p>Please wait for admin confirmation. You will be notified once your appointment is confirmed. Check your appointment status regularly.</p>
        </div>

        <div class="button-group">
            <a href="/dashboard" class="btn btn-secondary">Back to Dashboard</a>
            <a href="/appointment/create" class="btn btn-primary">Book Another</a>
        </div>
    </div>
</body>
</html>