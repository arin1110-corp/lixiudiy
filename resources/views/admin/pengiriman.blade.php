<!DOCTYPE html>
<html lang="id">
    <head>
        @include('admin.partials.headadmin')

        {{-- DataTables CSS --}}
        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"
        />
        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css"
        />

        <style>
            td.details-control {
                background: url("https://cdn.datatables.net/1.13.7/images/details_open.png")
                    no-repeat center center;
                cursor: pointer;
            }

            tr.shown td.details-control {
                background: url("https://cdn.datatables.net/1.13.7/images/details_close.png")
                    no-repeat center center;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                @include('admin.partials.sidebaradmin')

                <main class="col-md-10 ms-sm-auto p-4">
                    <div
                        class="navbar-header mb-4 d-flex justify-content-between align-items-center"
                    >
                        <h2>Dashboard</h2>
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <a
                                    href="{{ route('logout') }}"
                                    class="d-flex align-items-center text-dark text-decoration-none"
                                >
                                    <i
                                        class="rounded-circle me-2 bi bi-dash-circle-fill"
                                    ></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div
                            class="card-header bg-white fw-bold d-flex justify-content-between align-items-center"
                        >
                            <span>Data Pengiriman</span>
                        </div>
                        <div class="card-body">
                            <table
                                id="tabelPengiriman"
                                class="table table-bordered table-striped dt-responsive nowrap"
                                style="width: 100%"
                            >
                                <thead class="table-dark">
                                    <tr>
                                        <th></th>
                                        {{-- Expand button --}}
                                        <th>ID Pengiriman</th>
                                        <th>Status Bayar</th>
                                        <th>Resi</th>
                                        <th>Status Pengiriman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengiriman as $p)
                                    <tr>
                                        <td class="details-control"></td>
                                        <td
                                            class="pengiriman-id"
                                            data-id="{{ $p->pengiriman_id }}"
                                        >
                                            KRM{{ $p->pengiriman_id }}
                                        </td>
                                        <td>
                                            @if($p->status_bayar) ✅ Sudah Bayar
                                            @else ❌ Belum Bayar @endif
                                        </td>
                                        <td>
                                            @if($p->pengiriman_nomor_resi ==
                                            '-')
                                            <form
                                                action="{{ route('pengiriman.resi', $p->pengiriman_id) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                <input
                                                    type="text"
                                                    name="resi"
                                                    placeholder="Input Resi"
                                                    required
                                                />
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary btn-sm"
                                                >
                                                    Simpan
                                                </button>
                                            </form>
                                            @else
                                            {{ $p->pengiriman_nomor_resi }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->pengiriman_status == 1) 🚚
                                            Dikirim @else ⏳ Menunggu @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            function formatPesanan(pengiriman) {
                let html = '<ul class="mb-0">';
                pengiriman.pesanan.forEach(psn => {
                    html += '<li>' + psn.produk_nama + ' (Pesanan #' + psn.pesanan_id + ')</li>';
                });
                html += '</ul>';
                return html;
            }

            $(document).ready(function() {
                var table = $('#tabelPengiriman').DataTable({
                    responsive: true,
                    pageLength: 10,
                    columnDefs: [{
                        orderable: false,
                        targets: [0]
                    }],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                    }
                });

                var pengirimanData = @json($pengiriman);

                $('#tabelPengiriman tbody').on('click', 'td.details-control', function() {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);
                    var id = tr.find('td.pengiriman-id').data('id');
                    var data = pengirimanData.find(p => p.pengiriman_id == id);

                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        row.child(formatPesanan(data)).show();
                        tr.addClass('shown');
                    }
                });
            });
        </script>
    </body>
</html>
