<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #E08E21; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #E08E21; color: white; }
        .total { background-color: #ffeeba; font-weight: bold; }
        .footer { position: fixed; bottom: 20px; width: 100%; text-align: center; font-size: 10px; color: #888; }
    </style>
</head>
<body>
<div class="header">
    <h1>Petshop Lala</h1>
    <p>Laporan Pendapatan Bulanan</p>
    <p><strong>Periode: {{ $monthName }} {{ $year }}</strong></p>
</div>

<table>
    <thead>
    <tr>
        <th>Tanggal</th>
        <th>No. Order</th>
        <th>Pelanggan</th>
        <th>Item</th>
        <th>Total (Rp)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $trx)
    <tr>
        <td>{{ $trx->created_at->format('d/m/Y') }}</td>
        <td>#TRX-{{ $trx->transaction_id }}</td>
        <td>{{ $trx->receiver_name ?? $trx->user->name }}</td>
        <td>
            @foreach($trx->transactionDetails as $item)
            {{ $item->product->name }} (x{{ $item->quantity }})<br>
            @endforeach
        </td>
        <td>{{ number_format($trx->total_price, 0, ',', '.') }}</td>
    </tr>
    @endforeach
    <tr class="total">
        <td colspan="4" style="text-align: right;">TOTAL PENDAPATAN</td>
        <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
    </tr>
    </tbody>
</table>

<div class="footer">
    Dicetak pada: {{ date('d M Y H:i') }} oleh Admin
</div>
</body>
</html>
