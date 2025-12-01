<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order {{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        header, footer {
            text-align: center;
            margin: 10px 0;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .summary {
            margin-top: 20px;
            text-align: right;
        }

        hr {
            margin: 1cm 0;
            height: 0;
            border: 0;
            border-top: 1mm solid #60D0E4;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <img src="https://i.ibb.co/jyk0jjT/Logo-Iprint-1.png" alt="Logo IPrint" style="width: 100px; height: auto;">
            <h1>IPrint Indonesia</h1>
        </div>
        <div>
            <!-- Invoice details -->
            <h2>No. Pesanan: {{ $order->order_number }}</h2>
            <p>{{ $order->created_at->translatedFormat('d F Y') }}</p>
        </div>
        <hr />
        <div>
            <!-- Client details -->
            <h3>Struk Pembelian untuk</h3>
            <p>
                <b>{{ $order->name }}</b><br />
                {{ $order->address }}<br />
                {{ $order->postcode }}<br />
                <a>{{ $order->email }}</a><br />
                {{ $order->phone }}
            </p>
        </div>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga Produk</th>
                    <th>Kuantitas</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    <tr>
                        <td><b>{{ $product->title }}</b></td>
                        <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>Rp{{ number_format($product->price * $product->pivot->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary">
            <tr class="total">
                <th>Total Pembayaran</th>
                <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </main>

    <footer>
        <a href="https://iprintindonesia.dnaphotocapture.com/">IPrint Indonesia</a>
        <a href="mailto:iprintindonesia@gmail.com">iprintindonesia@gmail.com</a>
        <span>08123456789</span>
        <span>Surabaya</span>
    </footer>
</body>
</html>
