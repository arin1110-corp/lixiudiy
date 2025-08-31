<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.partials.headadmin')

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            @include('admin.partials.sidebaradmin')

            {{-- Konten Utama --}}
            <main class="col-md-10 ms-sm-auto p-4">

                {{-- Header --}}
                <div class="navbar-header mb-4 d-flex justify-content-between align-items-center">
                    <h2>Dashboard</h2>
                    <div class="d-flex align-items-center">
                        <input class="form-control me-3" type="text" placeholder="Cari...">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                                data-bs-toggle="dropdown">
                                <i class="rounded-circle me-2 bi bi-people"></i>
                                Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Profil</a></li>
                                <li><a class="dropdown-item" href="#">Keluar</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Tabel Data Bidang --}}
                <div class="card">
                    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                        <span>Data Produk</span>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="bi bi-plus-lg"></i> Tambah Data
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="tabelBidang" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produk as $no => $b)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $b->produk_nama }}</td>
                                    <td>{{ $b->kategori_nama }}</td>
                                    <td>{{ number_format($b->produk_harga, 0, ',', '.') }}</td>
                                    <td>{{ $b->produk_stok }}</td>
                                    <td>
                                        @if($b->produk_status == '1')
                                        <span class="badge bg-success">Aktif</span>
                                        @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning btnEdit" data-id="{{ $b->produk_id }}"
                                            data-nama="{{ $b->produk_nama }}" data-status="{{ $b->produk_status }}"
                                            data-deskripsi="{{ $b->produk_deskripsi }}"
                                            data-gambar="{{ $b->produk_gambar }}" data-harga="{{ $b->produk_harga }}"
                                            data-stok="{{ $b->produk_stok }}" data-kategori="{{ $b->produk_kategori }}"
                                            data-tanggalmasuk="{{ $b->produk_tanggalmasuk }}">

                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger btnHapus" data-id="{{ $b->produk_id }}"
                                            data-nama="{{ $b->produk_nama }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Footer --}}
                @include('admin.partials.footeradmin')
            </main>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.produk.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Data Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="produk_nama" required>
                        </div>
                        <div class="mb-3">
                            <label>Kategori</label>
                            <select class="form-select" name="produk_kategori" required>
                                @foreach ($kategori as $k)
                                <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="produk_deskripsi" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" class="form-control" name="produk_harga" required>
                        </div>
                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="produk_stok" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Masuk</label>
                            <input type="date" class="form-control" name="produk_tanggalmasuk" required>
                        </div>
                        <div class="mb-3">
                            <label>Gambar</label>
                            <input type="file" class="form-control" name="produk_gambar" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select class="form-select" name="produk_status" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEdit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Data Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" name="produk_nama" id="edit_nama" required>
                        </div>
                        <div class="mb-3">
                            <label>Kategori</label>
                            <select class="form-select" name="produk_kategori" id="edit_kategori" required>
                                @foreach ($kategori as $k)
                                <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="produk_deskripsi" id="edit_deskripsi"
                                rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" class="form-control" name="produk_harga" id="edit_harga" required>
                        </div>
                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" class="form-control" name="produk_stok" id="edit_stok" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Masuk</label>
                            <input type="date" class="form-control" name="produk_tanggalmasuk" id="edit_tanggalmasuk"
                                required>
                        </div>
                        <div class="mb-3">
                            <label>Gambar Lama</label><br>
                            <img id="previewGambar" src="/images/no-image.png" alt="" width="100"><br><br>
                            <input type="file" class="form-control mt-2" name="produk_gambar" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select class="form-select" name="produk_status" id="edit_status" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusLabel">Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus data <b id="hapus_nama"></b>?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- jQuery harus duluan --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Init DataTable
            $('#tabelBidang').DataTable({
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                }
            });

            // Edit Button
            $('.btnEdit').click(function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let deskripsi = $(this).data('deskripsi');
                let harga = $(this).data('harga');
                let stok = $(this).data('stok');
                let tanggalmasuk = $(this).data('tanggalmasuk'); // format sudah Y-m-d
                let status = $(this).data('status');
                let kategori = $(this).data('kategori');
                let gambar = $(this).data('gambar');

                $('#formEdit').attr('action', '/admin/produk/update/' + id);
                $('#edit_nama').val(nama);
                $('#edit_deskripsi').val(deskripsi);
                $('#edit_harga').val(Math.round(harga)); // pastikan bulat
                $('#edit_stok').val(stok);

                // langsung set ke input date
                $('#edit_tanggalmasuk').val(tanggalmasuk);

                $('#edit_status').val(status);
                $('#edit_kategori').val(kategori);

                // Preview gambar
                if (gambar) {
                    $('#previewGambar').attr('src', gambar.startsWith('/') ? gambar : '/' + gambar);
                } else {
                    $('#previewGambar').attr('src', '/images/no-image.png');
                }

                $('#modalEdit').modal('show');
            });

            // Hapus Button
            $('.btnHapus').click(function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');

                $('#formHapus').attr('action', '/admin/produk/delete/' + id);
                $('#hapus_nama').text(nama);

                let modalHapus = new bootstrap.Modal(document.getElementById('modalHapus'));
                modalHapus.show();
            });
        });
    </script>

</body>

</html>