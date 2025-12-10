<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Summary - Petshop Lala</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            /* Ganti url ini dengan gambar background anjing kamu jika ada */
            background: url('https://source.unsplash.com/1600x900/?dog,pet') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 40px 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Overlay putih tipis supaya tulisan terbaca */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.4);
            z-index: -1;
        }

        .payment-container {
            background: white;
            width: 100%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
        }

        .header-title {
            text-align: center;
            color: #FF8C42;
            font-size: 24px;
            font-weight: bold;
            padding: 25px 0 10px;
        }

        .content {
            padding: 20px 40px 40px;
        }

        /* Styling baris label: value */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
        }
        .info-label { font-weight: 500; color: #666; }
        .info-value { font-weight: 600; text-align: right; }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            margin-top: 10px;
            font-size: 1.1em;
            border-bottom: none;
        }
        .total-value { color: #333; font-weight: bold; }

        /* Bagian Payment Method */
        .section-title {
            margin-top: 25px;
            margin-bottom: 15px;
            font-weight: 600;
            color: #333;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .radio-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 0.95em;
        }
        .radio-label input {
            margin-right: 8px;
            accent-color: #FF8C42; /* Warna oranye untuk bulatan radio */
            transform: scale(1.2);
        }

        /* Kotak Oranye Informasi Transfer */
        .transfer-info-box {
            background: #FFF3E0; /* Warna oranye muda pudar */
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            color: #555;
        }
        .transfer-dest {
            color: #FF8C42;
            font-weight: bold;
            font-size: 1.1em;
            margin-top: 5px;
            display: block;
        }

        /* Upload File */
        .upload-section { margin-bottom: 30px; }
        .upload-desc { font-size: 0.8em; color: #888; margin-bottom: 10px; display: block; }

        /* Custom File Input (Biar mirip tombol oranye 'Choose File') */
        input[type="file"]::file-selector-button {
            background-color: #FF8C42;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            margin-right: 15px;
            transition: 0.3s;
        }
        input[type="file"]::file-selector-button:hover {
            background-color: #e67e3b;
        }

        /* Tombol Bawah */
        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        .btn {
            flex: 1;
            padding: 12px;
            border-radius: 25px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
            border: 2px solid transparent;
        }
        .btn-back {
            background: white;
            color: #FF8C42;
            border-color: #FF8C42;
        }
        .btn-back:hover { background: #fff3e0; }

        .btn-submit {
            background: #FF8C42;
            color: white;
            border: none;
            font-size: 16px;
        }
        .btn-submit:hover { background: #e67e3b; }

    </style>
</head>
<body>

<div class="payment-container">
    <div class="header-title">Payment Summary</div>

    <div class="content">
        <div class="info-row">
            <span class="info-label">Customer Name:</span>
            <span class="info-value">{{ Auth::user()->name }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Transaction ID:</span>
            <span class="info-value">#{{ $transaction->transaction_id }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Receiver Name:</span>
            <span class="info-value">{{ $transaction->receiver_name }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Address:</span>
            <span class="info-value" style="font-size:0.9em; max-width: 60%;">{{ Str::limit($transaction->receiver_address, 30) }}</span>
        </div>

        <div class="total-row">
            <span class="info-label">Total Price:</span>
            <span class="total-value">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
        </div>

        <form action="{{ route('payment.process', $transaction->transaction_id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section-title">Payment Method</div>
            <div class="radio-group">
                <label class="radio-label">
                    <input type="radio" name="payment_method" value="cash" onclick="updatePaymentInfo('cash')">
                    Cash
                </label>
                <label class="radio-label">
                    <input type="radio" name="payment_method" value="bank_transfer" onclick="updatePaymentInfo('bank')">
                    Bank Transfer
                </label>
                <label class="radio-label">
                    <input type="radio" name="payment_method" value="e_wallet" onclick="updatePaymentInfo('ewallet')" checked>
                    E-Wallet (GoPay)
                </label>
            </div>

            <div class="transfer-info-box" id="infoBox">
                Transfer to:
                <span class="transfer-dest" id="infoText">GoPay - 081260968298</span>
            </div>

            <div class="upload-section" id="uploadSection">
                <div class="section-title" style="margin-top:0;">Upload Proof of Payment:</div>
                <span class="upload-desc">Support file types: JPG, JPEG, PNG (max. 2MB)</span>
                <input type="file" name="proof_of_payment" accept="image/*">
            </div>

            <div class="btn-group">
                <a href="{{ route('products.shop') }}" class="btn btn-back">Back</a>
                <button type="submit" class="btn btn-submit">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    function updatePaymentInfo(method) {
        const infoBox = document.getElementById('infoBox');
        const infoText = document.getElementById('infoText');
        const uploadSection = document.getElementById('uploadSection');

        if (method === 'ewallet') {
            infoBox.style.display = 'block';
            infoBox.innerHTML = 'Transfer to:<br><span class="transfer-dest">GoPay - 081260968298</span>';
            uploadSection.style.display = 'block';
        } else if (method === 'bank') {
            infoBox.style.display = 'block';
            infoBox.innerHTML = 'Transfer to:<br><span class="transfer-dest">BCA - 123 456 7890 (Petshop Lala)</span>';
            uploadSection.style.display = 'block';
        } else if (method === 'cash') {
            infoBox.style.display = 'block';
            infoBox.innerHTML = 'Instruction:<br><span class="transfer-dest">Please pay at the cashier upon arrival.</span>';
            // Sembunyikan upload file kalau bayar tunai/COD
            uploadSection.style.display = 'none';
        }
    }

    // Jalankan sekali saat loading biar sesuai default (checked)
    updatePaymentInfo('ewallet');
</script>

</body>
</html>
