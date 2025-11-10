<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .center {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="center">
        <h2>Laporan Laundry</h2>
        <p>SILAUNDRY - Jl. Durian No.47, Pandean - Telp: 0895366226085</p>
        @if(request('keterangan'))
            <p>Filter Keterangan: <strong>{{ request('keterangan') }}</strong></p>
        @endif
    </div>

    @if($laporan->isEmpty())
        <p>Tidak ada transaksi untuk filter ini.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Berat (Kg)</th>
                    <th>Keterangan</th>
                    <th>Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $index => $transaksi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $transaksi->tanggal }}</td>
                        <td>{{ $transaksi->nama_pelanggan }}</td>
                        <td>{{ $transaksi->layanan->nama ?? '-' }}</td>
                        <td>{{ $transaksi->berat }}</td>
                        <td>{{ $transaksi->keterangan }}</td>
                        <td class="right">Rp {{ number_format($transaksi->berat * ($transaksi->layanan->harga ?? 0), 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div style="margin-top: 30px;">
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>
