<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cetak Struk</title>
  <style>
    body { font-family: monospace; font-size: 12px; width: 80mm; margin: auto; }
    hr { border: 1px dotted #000; }
    .center { text-align: center; }
  </style>
</head>
<body onload="window.print()">
  <div class="center">
    <strong>SILAUNDRY</strong><br>
    Jl. Durian No. 47, Pandean<br>
    Telp: 0895366226085
  </div>
  <hr>
  <p><strong>Tanggal:</strong> {{ $transaksi->tanggal }}</p>
  <p><strong>Pelanggan:</strong> {{ $transaksi->nama_pelanggan }}</p>
  <p><strong>Layanan:</strong> {{ $transaksi->layanan->nama ?? '-' }}</p>
  <p><strong>Berat:</strong> {{ $transaksi->berat }} Kg</p>
  <hr>
  @php $total = $transaksi->berat * ($transaksi->layanan->harga ?? 0); @endphp
  <table width="100%">
    <tr><td>Total</td><td align="right">Rp {{ number_format($total, 0, ',', '.') }}</td></tr>
    <tr><td>Tunai</td><td align="right">Rp {{ number_format($total, 0, ',', '.') }}</td></tr>
    <tr><td>Kembali</td><td align="right">Rp 0</td></tr>
  </table>
  <hr>
  <div class="center">
    Terima kasih atas kepercayaan Anda!<br>
    Anda sopan kami Hammer.
  </div>
</body>
</html>
