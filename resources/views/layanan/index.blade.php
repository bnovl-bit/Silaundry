@extends('master')
@section('isi')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Layanan</h1>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalTambah">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Tambah Layanan
        </button>
    </div>

    <div class="card">
        <div class="card-header">Layanan Yang Tersedia</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Layanan</th>
                            <th>Deskripsi</th>
                            <th>Harga per-KG</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($layanan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>
                                <button type="button"
                                    class="btn btn-warning btn-sm btn-ubah"
                                    title="Ubah Layanan"
                                    data-id="{{ $item->id_layanan }}"
                                    data-nama="{{ $item->nama }}"
                                    data-deskripsi="{{ $item->deskripsi }}"
                                    data-harga="{{ $item->harga }}"
                                    data-toggle="modal"
                                    data-target="#modalUbah">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="button"
                                    class="btn btn-danger btn-sm btn-delete"
                                    title="Hapus Layanan"
                                    data-id="{{ $item->id_layanan }}"
                                    data-nama="{{ $item->nama }}">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="exampleModalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('layanan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Layanan</label>
                        <input name="nama" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Harga Satuan</label>
                        <div class="input-group">
                            <input name="harga" type="number" class="form-control" required>
                            <div class="input-group-append">
                                <span class="input-group-text">Kg</span>
                            </div>
                        </div>
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

<!-- Modal Ubah -->
<div class="modal fade" id="modalUbah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-ubah" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Layanan</label>
                        <input type="text" name="nama" id="ubah-nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" id="ubah-deskripsi" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" id="ubah-harga" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery, Bootstrap, SweetAlert -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // tombol ubah 
    $(document).on('click', '.btn-ubah', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');
        let deskripsi = $(this).data('deskripsi');
        let harga = $(this).data('harga');

        // Set nilai input form
        $('#ubah-nama').val(nama);
        $('#ubah-deskripsi').val(deskripsi);
        $('#ubah-harga').val(harga);

        let actionUrl = `/layanan/${id}`;
        $('#form-ubah').attr('action', actionUrl);

        if ($('#form-ubah input[name="_method"]').length === 0) {
            $('#form-ubah').append('<input type="hidden" name="_method" value="PUT">');
        } else {
            $('#form-ubah input[name="_method"]').val('PUT');
        }

        $('#modalUbah').modal('show');
    });

    // Submit Form Ubah Layanan via AJAX
    $('#form-ubah').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        const url = form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        showConfirmButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#modalUbah').modal('hide');
                            location.href = '/layanan';
                        }
                    });
                }
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


    // tombol hapus 
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
                    url: "/layanan/" + id,
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
</script>
@endsection