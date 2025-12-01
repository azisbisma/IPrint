<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #60D0E4;
            color: white;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 16px;
        }

        .content {
            width: 90%;
            margin: 20px auto;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            font-size: 22px;
            border-bottom: 2px solid #60D0E4;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #60D0E4;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .summary {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Order - {{ now()->translatedFormat('F Y') }}</h1>
        <p>Produk Terlaris, Pendapatan, dan Total Order Bulanan</p>
    </div>

    <div class="content">
        <div class="section">
            <h2>Produk Terlaris</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mostSoldProducts as $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Pendapatan Bulanan</h2>
            <p class="summary">Rp{{ number_format($monthlyIncome, 0, ',', '.') }}</p>
        </div>

        <div class="section">
            <h2>Total Order Bulan Ini</h2>
            <p class="summary">{{ $totalOrdersThisMonth }} Pesanan</p>
        </div>
    </div>
</body>
</html>
