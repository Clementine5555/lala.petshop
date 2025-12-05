<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            padding: 50px;
            border-radius: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            max-width: 450px;
            width: 90%;
        }
        .icon-container {
            width: 80px;
            height: 80px;
            background: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }
        .icon-check {
            color: #2e7d32;
            font-size: 40px;
            font-weight: bold;
        }
        h1 { color: #333; margin-bottom: 10px; font-size: 24px; }
        p { color: #666; line-height: 1.6; margin-bottom: 30px; }
        
        .btn-home {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            display: inline-block;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }
        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 140, 66, 0.4);
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="icon-container">
            <span class="icon-check">✓</span>
        </div>
        <h1>Pesanan Berhasil!</h1>
        <p>
            Terima kasih telah berbelanja di Petshop Lala.<br>
            Pesanan kamu sedang kami proses.
        </p>
        
        <a href="{{ route('products.shop') }}" class="btn-home">
            Kembali Belanja
        </a>
    </div>

</body>
</html>