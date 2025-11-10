@extends('master')
@section('isi')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan</h1>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cetakPdfModal">
            Cetak PDF
        </button>
    </div>

    <!-- Modal Cetak PDF (Bootstrap 4) -->
    <div class="modal fade" id="cetakPdfModal" tabindex="-1" role="dialog" aria-labelledby="cetakPdfLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('laporan.cetak') }}" method="GET" target="_blank">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cetakPdfLabel">Cetak Laporan PDF</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Filter keterangan -->
                        <div class="form-group">
                            <label for="keterangan">Pilih Keterangan</label>
                            <select class="form-control" name="keterangan" id="keterangan">
                                <option value="">Semua</option>
                                <option value="Proses">Proses</option>
                                <option value="Siap Di Ambil">Siap Di Ambil</option>
                                <option value="Sudah Di Ambil">Sudah Di Ambil</option>
                            </select>
                            <small class="text-muted">Kosongkan untuk mencetak semua data.</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Cetak PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><strong>Laporan Laundry</strong></span>
            <select id="filterKeterangan" class="form-select w-auto">
                <option value="">Semua</option>
                <option value="Proses">Proses</option>
                <option value="Siap Di Ambil">Siap Di Ambil</option>
                <option value="Sudah Di Ambil">Sudah Di Ambil</option>
            </select>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Layanan</th>
                            <th>Berat (Kg)</th>
                            <th>Harga Per Kg</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $data)
                        @php
                        $layanan = $data->layanan ?? $data->transaksi->layanan ?? null;
                        $harga = $layanan->harga ?? 0;
                        $berat = $data->berat ?? $data->transaksi->berat ?? 0;
                        $total_harga = $harga * $berat;
                        $keterangan = $data->keterangan ?? $data->transaksi->keterangan ?? '-';
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->nama_pelanggan ?? $data->transaksi->nama_pelanggan ?? '-' }}</td>
                            <td>{{ $layanan->nama ?? '-' }}</td>
                            <td>{{ $berat }}</td>
                            <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($total_harga, 0, ',', '.') }}</td>
                            <td>
                                @php $ket = strtolower(trim($keterangan)); @endphp

                                @if($ket === 'proses')
                                <span class="badge badge-warning">{{ $keterangan }}</span>
                                @elseif($ket === 'siap di ambil' || $ket === 'siap diambil')
                                <span class="badge badge-info">{{ $keterangan }}</span>
                                @elseif($ket === 'sudah di ambil' || $ket === 'sudah diambil')
                                <span class="badge badge-success">{{ $keterangan }}</span>
                                @else
                                <span class="badge badge-secondary">{{ $keterangan }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('filterKeterangan').addEventListener('change', function() {
        const filter = this.value.toLowerCase().trim();
        let nomor = 1;

        document.querySelectorAll('tbody tr').forEach(row => {
            const badge = row.querySelector('td:last-child .badge');
            const keterangan = badge ? badge.textContent.toLowerCase().trim() : '';

            if (filter === '' || keterangan === filter) {
                row.style.display = '';
                row.querySelector('td:first-child').textContent = nomor++;
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection