<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.partials.headadmin')

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* kecil saja agar tabel tidak mepet */
        .card-body {
            overflow-x: auto;
        }
    </style>
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
                        <div class="dropdown">
                                <a
                                    href="{{ route('logout') }}"
                                    class="d-flex align-items-center text-dark text-decoration-none">
                                    <i class="rounded-circle me-2 bi bi-dash-circle-fill"></i>
                                    Logout
                                </a>
                            </div>
                    </div>
                </div>

                {{-- Card Tabel --}}
                <div class="card mb-4">
                    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                        <span>Data Laporan Penjualan</span>
                    </div>

                    <div class="card-body">
                        {{-- Filter (opsional) --}}
                        <form action="{{ route('admin.laporan.proses') }}" method="POST" class="d-flex gap-2 mb-3">
                            @csrf
                            <select name="bulan" class="form-select w-auto" required>
                                @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}"
                                    {{ $m == now()->subMonth()->month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                    @endfor
                            </select>

                            <select name="tahun" class="form-select w-auto" required>
                                @for ($y = now()->year; $y >= now()->year - 2; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>

                            <button type="submit" class="btn btn-primary">Proses Laporan</button>
                        </form>

                        <table class="table table-bordered" id="tabelBidang" style="width:100%;">
                            <thead class="table-light">
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
                                <tr>
                                    <td>{{ $lap->laporan_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lap->laporan_tanggal)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($lap->laporan_periode_mulai)->translatedFormat('d F Y') }}
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

                        {{-- Jika Anda menggunakan Laravel pagination sebelumnya dan ingin DataTables mengatur client-side pagination,
                             pastikan controller mengirim semua baris (->get()) bukan paginated; jika tetap pakai paginator,
                             Anda bisa tampilkan links di bawah (opsional). --}}
                        {{-- {{-- {{ $laporans->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>

                {{-- Footer --}}
                @include('admin.partials.footeradmin')
            </main>
        </div>
    </div>

    {{-- jQuery duluan --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>


    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable client-side
            $('#tabelBidang').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 50, 100],
                    [10, 20, 50, 100]
                ],
                order: [[1, 'desc']], // <== kolom ke-2 (Tanggal) urut DESC
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                }
            });
        });
    </script>
</body>

</html>