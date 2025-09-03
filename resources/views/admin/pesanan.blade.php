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
                                    <th>Kode Bayar</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Total Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembayaran as $p)
                                <tr class="table-primary">
                                    <td>BYR{{ $p->pembayaran_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->pembayaran_tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ $p->customer_nama }}</td>
                                    <td>Rp {{ number_format($p->total_bayar,0,',','.') }}</td>
                                    <td>
                                        @if($p->pembayaran_status == '0')

                                        <button class="btn btn-sm btn-success btnVerif"
                                            data-id="{{ $p->pembayaran_id }}">
                                            Verifikasi
                                        </button>
                                        @elseif($p->pembayaran_status == '1')
                                        <button class="btn btn-sm btn-success">
                                            <i class="fa fa-check">Sudah Verifikasi</i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>

                                @foreach($p->pesanan as $item)
                                <tr>
                                    <td></td>
                                    <td colspan="2">{{ $item->produk_nama }}</td>
                                    <td>{{ $item->pesanan_jumlah }} x Rp
                                        {{ number_format($item->produk_harga,0,',','.') }}
                                    </td>
                                    <td>Rp {{ number_format($item->total,0,',','.') }}</td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Modal Verifikasi Pembayaran-->
                        <div class="modal fade" id="verifModal" tabindex="-1" aria-labelledby="verifModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="verifModalLabel">Verifikasi Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin memverifikasi pembayaran ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <form action="" method="POST" id="verifForm">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary">Ya, Verifikasi</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Bukti Pembayaran -->
                        <div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="buktiModalLabel">Bukti Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img id="buktiImage" src="" class="img-fluid rounded shadow"
                                            alt="Bukti pembayaran tidak tersedia">
                                        <div id="buktiEmpty" class="alert alert-warning mt-3 d-none">
                                            Bukti pembayaran belum tersedia untuk pesanan ini.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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