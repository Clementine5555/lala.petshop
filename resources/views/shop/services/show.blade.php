<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->service_name }} - Petshop Lala</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding-top: 80px;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            padding: 10px 0;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            gap: 30px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo img {
            width: 32px;
            height: 32px;
        }

        .logo span {
            font-weight: 900;
            color: #FF8C42;
            font-size: 1.2em;
        }

        /* Service Detail */
        .service-detail {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .detail-header {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .detail-header h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 15px;
            font-weight: 800;
        }

        .detail-meta {
            display: flex;
            gap: 30px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            color: #999;
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .meta-value {
            font-size: 1.3em;
            font-weight: 700;
            color: #333;
        }

        .meta-value.price {
            color: #FF8C42;
        }

        .detail-description {
            color: #666;
            font-size: 1.1em;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 15px 40px;
            border: none;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
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

        .btn-secondary {
            background: white;
            color: #FF8C42;
            border: 2px solid #FF8C42;
        }

        .btn-secondary:hover {
            background: #FF8C42;
            color: white;
        }

        @media (max-width: 768px) {
            .detail-header {
                padding: 30px;
            }

            .detail-header h1 {
                font-size: 2em;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="/images/logoo.png" alt="Petshop Lala">
                <span>Petshop Lala</span>
            </a>
        </div>
    </nav>

    <!-- Service Detail -->
    <div class="service-detail">
        <div class="detail-header">
            <h1>{{ $service->service_name }}</h1>

            <div class="detail-meta">
                <div class="meta-item">
                    <span class="meta-label">Duration</span>
                    <span class="meta-value">{{ $service->duration_minutes }} minutes</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Price</span>
                    <span class="meta-value price">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="detail-description">
                {{ $service->description }}
            </div>

            <div class="action-buttons">
                <a href="{{ route('appointment.create') }}?service_id={{ $service->service_id }}" class="btn btn-primary">
                    📅 Book This Service
                </a>
                <a href="{{ route('appointment.create') }}" class="btn btn-secondary">
                    View All Services
                </a>
            </div>
        </div>
    </div>

</body>
</html>
