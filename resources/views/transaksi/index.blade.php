@extends('master')
@section('isi')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-transaksi">
            <i class="fas fa-upload fa-sm text-white-50"></i>
            Tambah Transaksi
        </button>
    </div>
    <div class="card">
        <div class="card-header">Daftar Transaksi</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Layanan</th>
                            <th>Berat</th>
                            <th>Nama Pelanggan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->layanan->nama ?? '-' }}</td>
                            <td>{{ $item->berat }} Kg</td>
                            <td>{{ $item->nama_pelanggan }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <button type="button"
                                    class="btn btn-warning btn-sm btn-ubah"
                                    data-id="{{ $item->id_transaksi }}"
                                    data-tanggal="{{ $item->tanggal }}"
                                    data-layanan="{{ $item->id_layanan }}"
                                    data-berat="{{ $item->berat}}"
                                    data-nama_pelanggan="{{ $item->nama_pelanggan}}"
                                    data-keterangan="{{ $item->keterangan}}"
                                    data-toggle="modal"
                                    data-target="#ubah-transaksi">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button"
                                    class="btn btn-info btn-sm btn-struk"
                                    data-id="{{ $item->id_transaksi }}"
                                    data-tanggal="{{ $item->tanggal }}"
                                    data-layanan="{{ $item->layanan->nama ?? '-' }}"
                                    data-berat="{{ $item->berat }}"
                                    data-pelanggan="{{ $item->nama_pelanggan }}"
                                    data-keterangan="{{ $item->keterangan }}"
                                    data-harga="{{ $item->layanan->harga ?? 0 }}"
                                    data-toggle="modal"
                                    data-target="#modal-struk">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button
                                    class="btn btn-danger btn-sm btn-delete"
                                    data-id="{{ $item->id_transaksi }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Ubah -->
                        <div class="modal fade" id="ubah-transaksi" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form-ubah" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ubah Transaksi</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="date" name="tanggal" id="ubah-tanggal" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Layanan</label>
                                                <select name="id_layanan" id="ubah-layanan" class="form-control" required>
                                                    <option value="" disabled hidden>--Pilih Layanan--</option>
                                                    @foreach($layanan as $lay)
                                                    <option value="{{ $lay->id_layanan }}">{{ $lay->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Berat (Kg)</label>
                                                <input type="number" name="berat" id="ubah-berat" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Pelanggan</label>
                                                <input type="text" name="nama_pelanggan" id="ubah-nama_pelanggan" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <select name="keterangan" id="ubah-keterangan" class="form-control" required>
                                                    <option value="Proses">Proses</option>
                                                    <option value="Siap Di Ambil">Siap Di Ambil</option>
                                                    <option value="Sudah Di Ambil">Sudah Di Ambil</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambah-transaksi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Layanan</label>
                        <select name="id_layanan" class="form-control" required>
                            <option value="" disabled selected hidden>--Pilih Layanan--</option>
                            @foreach($layanan as $lay)
                            <option value="{{ $lay->id_layanan }}">{{ $lay->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Berat (Kg)</label>
                        <input type="number" name="berat" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <select name="keterangan" class="form-control" required>
                            <option value="" disabled selected hidden>--Keterangan--</option>
                            <option value="Proses">Proses</option>
                            <option value="Siap Di Ambil">Siap Di Ambil</option>
                            <option value="Sudah Di Ambil">Sudah Di Ambil</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Struk -->
<div class="modal fade" id="modal-struk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:80mm;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Struk Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="printArea"></div>
            <div class="modal-footer">
                <button type="button" id="btn-print" class="btn btn-success btn-sm">
                    <i class="fas fa-print"></i> Cetak
                </button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<!-- SweetAlert untuk hapus -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('click', '.btn-ubah', function() {
        let id = $(this).data('id');
        let tanggal = $(this).data('tanggal');
        let layanan = $(this).data('layanan');
        let berat = $(this).data('berat');
        let nama = $(this).data('nama_pelanggan');
        let keterangan = $(this).data('keterangan');
        let harga = $(this).data('harga');

        $('#ubah-tanggal').val(tanggal);
        $('#ubah-layanan').val(layanan);
        $('#ubah-berat').val(berat);
        $('#ubah-nama_pelanggan').val(nama);
        $('#ubah-keterangan').val(keterangan);

        // Set action form untuk route update
        let actionUrl = "{{ url('transaksi') }}/" + id;
        $('#form-ubah').attr('action', actionUrl);
    });


    $(document).on('click', '.btn-delete', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');

        Swal.fire({
            title: 'Yakin?',
            text: "Data " + nama + " akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/transaksi/" + id,
                    type: "POST",
                    data: {
                        "_method": "DELETE",
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success')
                            .then(() => location.reload());
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                    }
                });
            }
        });
    });

    // struk
    $(document).on('click', '.btn-struk', function() {
        let tanggal = $(this).data('tanggal');
        let pelanggan = $(this).data('pelanggan');
        let layanan = $(this).data('layanan');
        let berat = $(this).data('berat');
        let keterangan = $(this).data('keterangan');
        let harga = $(this).data('harga');

        let total = berat * harga;

        let html = `
    <div style="text-align:center; font-size:12px;">
        <strong>SILAUNDRY</strong><br>
        Jl. Durian No. 47, Pandean<br>
        Telp: 0895366226085
        <hr style="border:1px dotted #000;">
    </div>
    <p><strong>Tanggal:</strong> ${tanggal}</p>
    <p><strong>Pelanggan:</strong> ${pelanggan}</p>
    <p><strong>Layanan:</strong> ${layanan}</p>
    <p><strong>Berat:</strong> ${berat} Kg</p>
    <p><strong>Keterangan:</strong> ${keterangan}</p>
    <hr style="border:1px dotted #000;">
    <table style="width:100%; font-size:12px;">
        <tr><td>Total</td><td style="text-align:right;">Rp ${total.toLocaleString()}</td></tr>
        <tr><td>Tunai</td><td style="text-align:right;">Rp ${total.toLocaleString()}</td></tr>
        <tr><td>Kembali</td><td style="text-align:right;">Rp 0</td></tr>
    </table>
    <hr style="border:1px dotted #000;">
    <div style="text-align:center; font-size:11px;">
        Terima kasih atas kepercayaan Anda!<br>
        Anda sopan kami Hammer.
    </div>`;

        $('#printArea').html(html);
        $('#modal-struk').modal('show');
    });
    $(document).on('click', '#btn-print', function() {
        let printContents = document.getElementById('printArea').innerHTML;
        let printWindow = window.open('', '', 'width=400,height=800');
        printWindow.document.write('<html><head><title>Cetak Struk</title>');
        printWindow.document.write('<style>body{font-family:monospace; font-size:12px;}</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
</script>
@endsection