<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
</head>
<body>
    <div style="font-family: monospace; width: 300px; margin: 0 auto;">
        <div style="text-align: center;">
            <h2>Toko Sederhana</h2>
            <p>Alamat: Jl. Contoh No. 123</p>
            <p>Telp: 0812-3456-7890</p>
            <p>------------------------------------</p>
        </div>
        
        <p>No. Invoice: {{ $transactions->invoice }}</p>
        <p>Tanggal: {{ \Carbon\Carbon::parse($transactions->date)->format('d-m-Y H:i:s') }}</p>
        <p>Kasir: {{ $transactions->user['name'] ?? 'Admin' }}</p>
        <p>------------------------------------</p>
        
        <table style="width: 100%; font-size: 14px;">
            <thead>
                <tr>
                    <th style="text-align: left;">Produk</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($details as $row)
                <tr>
                    <td>{{ $row->product['name'] }}</td>
                    <td style="text-align: right;">{{ $row['qty'] }}</td>
                    <td style="text-align: right;">{{ number_format($row->product['price'], 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($row['qty'] * $row['price'], 0, ',', '.') }}</td>
                </tr>
                @php $total += $row['qty'] * $row['price']; @endphp
                @endforeach
            </tbody>
        </table>
        <p>------------------------------------</p>
        
        <div style="text-align: right;">
            <p>Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
            <p>------------------------------------</p>
            <p>Terima kasih telah berbelanja!</p>
            <p>Selamat datang kembali.</p>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
