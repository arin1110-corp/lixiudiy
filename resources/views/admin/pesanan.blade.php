<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.partials.headadmin')

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        td.details-control {
            background: url('https://cdn.datatables.net/1.13.7/images/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://cdn.datatables.net/1.13.7/images/details_close.png') no-repeat center center;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            @include('admin.partials.sidebaradmin')

            <main class="col-md-10 ms-sm-auto p-4">

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

                <div class="card">
                    <div class="card-header bg-white fw-bold">Data Pesanan</div>
                    <div class="card-body">
                        <table id="tabelBidang"
                            class="table table-bordered table-striped table-hover dt-responsive nowrap"
                            style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th></th> {{-- Expand button --}}
                                    <th>Kode Bayar</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Total Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembayaran as $p)
                                <tr>
                                    <td class="details-control"></td>
                                    <td>BYR{{ $p->pembayaran_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->pembayaran_tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ $p->customer_nama }}</td>
                                    <td>{{ $p->pembayaran_metode == '1' ? 'Transfer Bank' : ($p->pembayaran_metode == '2' ? 'E-Wallet' : 'COD') }}
                                    </td>
                                    <td>Rp {{ number_format($p->total_bayar,0,',','.') }}</td>
                                    <td>
                                        @if($p->pembayaran_status == '0')
                                        <button class="btn btn-sm btn-success btnVerif"
                                            data-id="{{ $p->pembayaran_id }}">Verifikasi</button>
                                        @else
                                        <button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Sudah
                                            Verifikasi</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal fade" id="verifModal" tabindex="-1" aria-labelledby="verifModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verifModalLabel">Verifikasi Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="verifForm" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Verifikasi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.partials.footeradmin')
            </main>
        </div>
    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        // Format child row untuk rincian pesanan
        function formatPesanan(pembayaran) {
            let html = '<table class="table table-sm table-bordered mb-0">';
            html +=
                '<thead class="table-secondary"><tr><th>Produk</th><th>Jumlah</th><th>Harga</th><th>Total</th></tr></thead><tbody>';
            pembayaran.pesanan.forEach(item => {
                html += '<tr>';
                html += '<td>' + item.produk_nama + '</td>';
                html += '<td>' + item.pesanan_jumlah + '</td>';
                html += '<td>Rp ' + Number(item.produk_harga).toLocaleString('id-ID') + '</td>';
                html += '<td>Rp ' + Number(item.total).toLocaleString('id-ID') + '</td>';
                html += '</tr>';
            });
            html += '</tbody></table>';
            return html;
        }

        $(document).ready(function() {
            var table = $('#tabelBidang').DataTable({
                responsive: true,
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: [0, 6]
                }],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                }
            });

            // Expand/Collapse row
            var pembayaranData = @json($pembayaran);
            $('#tabelBidang tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var id = tr.find('td:eq(1)').text().replace('BYR', '');
                var data = pembayaranData.find(p => p.pembayaran_id == id);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(formatPesanan(data)).show();
                    tr.addClass('shown');
                }
            });

            // Verifikasi button
            const verifModal = new bootstrap.Modal(document.getElementById('verifModal'));
            const verifForm = document.getElementById('verifForm');
            $('.btnVerif').click(function() {
                let id = $(this).data('id');
                verifForm.setAttribute('action', `/admin/pembayaran/verifikasi/${id}`);
                verifModal.show();
            });
        });
    </script>
</body>

</html>