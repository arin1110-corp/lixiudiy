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
                        <span>Data Pesanan</span>

                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Laporan</th>
                                    <th>Tanggal</th>
                                    <th>Periode</th>
                                    <th>Total Produk</th>
                                    <th>Total Pesanan</th>
                                    <th>Total Pendapatan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporans as $lap)
                                <tr class="table-primary">
                                    <td>{{ $lap->laporan_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lap->laporan_tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($lap->laporan_periode_mulai)->translatedFormat('d F Y') }}
                                        s/d
                                        {{ \Carbon\Carbon::parse($lap->laporan_periode_selesai)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ $lap->laporan_total_produk }}</td>
                                    <td>{{ $lap->laporan_total_pesanan }}</td>
                                    <td>Rp {{ number_format($lap->laporan_total_pendapatan, 0, ',', '.') }}</td>
                                    <td>{{ $lap->laporan_keterangan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-3">
                            {{ $laporans->links('pagination::bootstrap-5') }}
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = new bootstrap.Modal(document.getElementById('buktiModal'));
            const buktiImage = document.getElementById('buktiImage');
            const buktiEmpty = document.getElementById('buktiEmpty');

            document.querySelectorAll('.btnBukti').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.getAttribute('data-id');

                    // Path file bukti (misal: public/bukti/BYR1.jpg)
                    let url = `/bukti/BYR${id}.jpg`;

                    // Coba load image
                    fetch(url, {
                            method: 'HEAD'
                        })
                        .then(res => {
                            if (res.ok) {
                                buktiImage.src = url;
                                buktiImage.classList.remove("d-none");
                                buktiEmpty.classList.add("d-none");
                            } else {
                                buktiImage.classList.add("d-none");
                                buktiEmpty.classList.remove("d-none");
                            }
                        })
                        .catch(() => {
                            buktiImage.classList.add("d-none");
                            buktiEmpty.classList.remove("d-none");
                        });

                    modal.show();
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const verifModal = new bootstrap.Modal(document.getElementById('verifModal'));
            const verifForm = document.getElementById('verifForm');

            document.querySelectorAll('.btnVerif').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.getAttribute('data-id');

                    // set action form
                    verifForm.setAttribute('action', `/admin/pembayaran/verifikasi/${id}`);

                    // show modal
                    verifModal.show();
                });
            });
        });
    </script>

</body>

</html>