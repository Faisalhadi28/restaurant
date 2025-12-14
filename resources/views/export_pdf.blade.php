<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PDF Pesanan</title>
</head>
<body>

    <h2>Detail Pesanan #{{ $pemesanan->id }}</h2>
    <p>Tanggal: {{ $pemesanan->tanggal_pesanan }}</p>

    <table width="100%" border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>

        @foreach ($pemesanan->orderDetail as $detail)
        <tr>
            <td>{{ $detail->menu->name }}</td>
            <td>{{ $detail->jumlah }}</td>
            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <h3>Total: Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</h3>

</body>
</html>
