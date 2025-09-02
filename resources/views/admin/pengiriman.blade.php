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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Pengiriman</th>
                                    <th>Pesanan</th>
                                    <th>Status Bayar</th>
                                    <th>Resi</th>
                                    <th>Status Pengiriman</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengiriman as $p)
                                <tr>
                                    <td>{{ $p->pengiriman_id }}</td>
                                    <td>
                                        <ul>
                                            @foreach($p->pesanan as $psn)
                                            <li>
                                                {{ $psn->produk_nama }}
                                                (Pesanan #{{ $psn->pesanan_id }})
                                            </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        @if($p->status_bayar)
                                        ✅ Sudah Bayar
                                        @else
                                        ❌ Belum Bayar
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->pengiriman_nomor_resi == '-')
                                        <form action="{{ route('pengiriman.resi', $p->pengiriman_id) }}" method="POST">
                                            @csrf
                                            <input type="text" name="resi" placeholder="Input Resi" required>
                                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                        </form>
                                        @else

                                        {{ $p->pengiriman_nomor_resi }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->pengiriman_status == 1)
                                        🚚 Dikirim
                                        @else
                                        ⏳ Menunggu
                                        @endif
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
                let produk = $(this).data('produk');
                let status = $(this).data('status');
                let tanggal = $(this).data('tanggal');
                let ket = $(this).data('ket');

                $('#formEdit').attr('action', '/admin/rekomendasi/update/' + id);
                $('#edit_nama').val(nama);
                $('#edit_produk').val(produk);
                $('#edit_status').val(status);
                $('#edit_tanggalmasuk').val(tanggal);
                $('#edit_ket').val(ket);

                let modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
                modalEdit.show();
            });

            // Hapus Button
            $('.btnHapus').click(function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');

                $('#formHapus').attr('action', '/admin/rekomendasi/delete/' + id);
                $('#hapus_nama').text(nama);

                let modalHapus = new bootstrap.Modal(document.getElementById('modalHapus'));
                modalHapus.show();
            });
        });
    </script>

</body>

</html>