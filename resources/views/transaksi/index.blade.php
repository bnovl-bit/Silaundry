@extends('master')
@section('isi')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah-transaksi">
            <i class="fas fa-plus fa-sm text-white-50"></i>
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
                                    title="Ubah Transaksi"
                                    data-id="{{ $item->id_transaksi }}"
                                    data-tanggal="{{ $item->tanggal }}"
                                    data-layanan="{{ $item->id_layanan }}"
                                    data-berat="{{ $item->berat }}"
                                    data-nama_pelanggan="{{ $item->nama_pelanggan }}"
                                    data-keterangan="{{ $item->keterangan }}"
                                    data-toggle="modal"
                                    data-target="#ubah-transaksi">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button"
                                    class="btn btn-info btn-sm btn-struk"
                                    title="Cetak Transaksi"
                                    data-id="{{ $item->id_transaksi }}"
                                    data-tanggal="{{ $item->tanggal }}"
                                    data-layanan="{{ $item->layanan->nama ?? '-' }}"
                                    data-berat="{{ $item->berat }}"
                                    data-pelanggan="{{ $item->nama_pelanggan }}"
                                    data-harga="{{ $item->layanan->harga ?? 0 }}"
                                    data-toggle="modal"
                                    data-target="#modal-struk">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button
                                    class="btn btn-danger btn-sm btn-delete"
                                    title="Hapus Transaksi"
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

<!-- Modal Cetak Struk -->
<div class="modal fade" id="modal-struk" tabindex="-1" role="dialog" aria-labelledby="modalStrukLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="formCetakStruk" action="{{ route('transaksi.cetak') }}" method="GET" target="_blank">
                <input type="hidden" name="id_transaksi" id="id_transaksi">

                <div class="modal-header">
                    <h5 class="modal-title">Struk Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="previewStruk" style="font-family: monospace; font-size: 12px;">
                    <div class="text-center">
                        <strong>SILAUNDRY</strong><br>
                        Jl. Durian No.47, Pandean<br>
                        Telp: 0895366226085
                    </div>
                    <hr>
                    <p><strong>Tanggal:</strong> <span id="viewTanggal"></span></p>
                    <p><strong>Pelanggan:</strong> <span id="viewNama"></span></p>
                    <p><strong>Layanan:</strong> <span id="viewLayanan"></span></p>
                    <p><strong>Berat:</strong> <span id="viewBerat"></span> Kg</p>
                    <hr>
                    <p><strong>Total:</strong> Rp <span id="viewTotal"></span></p>
                    <hr>
                    <div class="text-center">
                        Terima kasih atas kepercayaan Anda!<br>
                        Anda sopan kami Hammer.
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert untuk hapus -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {

        // Tombol Ubah
        $(document).on('click', '.btn-ubah', function() {
            const id = $(this).data('id');
            const tanggal = $(this).data('tanggal');
            const layanan = $(this).data('layanan');
            const berat = $(this).data('berat');
            const nama = $(this).data('nama_pelanggan');
            const keterangan = $(this).data('keterangan');

            // Set value ke modal
            $('#ubah-tanggal').val(tanggal);
            $('#ubah-layanan').val(layanan);
            $('#ubah-berat').val(berat);
            $('#ubah-nama_pelanggan').val(nama);
            $('#ubah-keterangan').val(keterangan);

            // Set action form
            const actionUrl = "{{ url('transaksi') }}/" + id;
            $('#form-ubah').attr('action', actionUrl);

            // Pastikan ada _method PUT
            if ($('#form-ubah input[name="_method"]').length === 0) {
                $('#form-ubah').append('<input type="hidden" name="_method" value="PUT">');
            }
        });

        // Submit Form Ubah via AJAX
        $('#form-ubah').submit(function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data transaksi berhasil diperbarui.',
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        if ($.fn.DataTable.isDataTable('#tabel-transaksi')) {
                            $('#tabel-transaksi').DataTable().ajax.reload(null, false); 
                        } else {
                            location.href = '/transaksi'; 
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menyimpan data.'
                    });
                    console.error(xhr.responseText);
                }
            });
        });

        // Tombol Hapus
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama') || 'Transaksi ini';

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
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                        }
                    });
                }
            });
        });

        // Tombol Struk
        $(document).on('click', '.btn-struk', function() {
            const id = $(this).data('id');
            const tanggal = $(this).data('tanggal');
            const layanan = $(this).data('layanan');
            const berat = $(this).data('berat');
            const nama = $(this).data('pelanggan');
            const harga = $(this).data('harga') || 0;
            const total = berat * harga;

            // Set value modal struk
            $('#id_transaksi').val(id);
            $('#viewTanggal').text(tanggal);
            $('#viewNama').text(nama);
            $('#viewLayanan').text(layanan);
            $('#viewBerat').text(berat);
            $('#viewTotal').text(total.toLocaleString('id-ID'));
        });

    });
</script>

@endsection