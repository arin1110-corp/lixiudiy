<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.partials.headadmin')

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
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
                            <a href="{{ route('logout') }}" class="d-flex align-items-center text-dark text-decoration-none">
                                <i class="rounded-circle me-2 bi bi-dash-circle-fill"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tombol Cetak PDF --}}
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('admin.laporan.cetak', [
                        'bulan_mulai' => request('bulan_mulai'),
                        'bulan_selesai' => request('bulan_selesai'),
                        'tahun' => request('tahun')
                    ]) }}" 
                    target="_blank" 
                    class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
                    </a>
                </div>

                {{-- Card Tabel --}}
                <div class="card mb-4">
                    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                        <span>Data Laporan Penjualan</span>
                    </div>

                    <div class="card-body">
                        {{-- FORM: Proses Laporan (tetap ada, POST) --}}
                        <!-- <form action="{{ route('admin.laporan.proses') }}" method="POST" class="d-flex flex-wrap gap-2 mb-3">
                            @csrf
                            <select name="bulan" class="form-select w-auto" required>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == now()->subMonth()->month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate(now()->year, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>

                            <select name="tahun" class="form-select w-auto" required>
                                @for ($y = now()->year; $y >= now()->year - 2; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>

                            <button type="submit" class="btn btn-primary">Proses Laporan</button>
                        </form> -->

                        {{-- FORM: Filter Periode Bulan Mulai - Bulan Selesai (GET) --}}
                        @php
                            // **PENTING**: cast ke (int) agar Carbon tidak menerima string
                            $bulanMulai = (int) request('bulan_mulai', now()->month);
                            $bulanSelesai = (int) request('bulan_selesai', now()->month);
                            $tahunFilter = (int) request('tahun', now()->year);
                        @endphp

                        <form method="GET" class="d-flex flex-wrap gap-2 mb-3">
                            <label class="form-label mt-2">Dari Bulan</label>
                            <select name="bulan_mulai" class="form-select w-auto" required>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $bulanMulai == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate($tahunFilter, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>

                            <label class="form-label mt-2">Sampai Bulan</label>
                            <select name="bulan_selesai" class="form-select w-auto" required>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $bulanSelesai == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate($tahunFilter, $m, 1)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>

                            <label class="form-label mt-2">Tahun</label>
                            <select name="tahun" class="form-select w-auto" required>
                                @for ($y = now()->year; $y >= now()->year - 2; $y--)
                                    <option value="{{ $y }}" {{ $tahunFilter == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>

                            <button type="submit" class="btn btn-success">Filter Periode</button>
                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary ms-2">Reset</a>
                        </form>

                        {{-- Info filter aktif --}}
                        @if(request()->filled(['bulan_mulai', 'bulan_selesai', 'tahun']))
                            <div class="alert alert-info py-2">
                                Menampilkan laporan dari 
                                <strong>{{ \Carbon\Carbon::createFromDate($tahunFilter, $bulanMulai, 1)->translatedFormat('F') }}</strong>
                                sampai 
                                <strong>{{ \Carbon\Carbon::createFromDate($tahunFilter, $bulanSelesai, 1)->translatedFormat('F') }}</strong>
                                tahun 
                                <strong>{{ $tahunFilter }}</strong>.
                            </div>
                        @endif

                        {{-- Logika Filter (pakai Collection filter di Blade) --}}
                        @php
                            $laporansFiltered = $laporans;

                            if (request()->filled(['bulan_mulai', 'bulan_selesai', 'tahun'])) {
                                // Pastikan integer dan urutan benar
                                $bMulai = (int) request('bulan_mulai');
                                $bSelesai = (int) request('bulan_selesai');
                                $t = (int) request('tahun');

                                if ($bMulai > $bSelesai) {
                                    [$bMulai, $bSelesai] = [$bSelesai, $bMulai];
                                }

                                $tanggalMulai = \Carbon\Carbon::createFromDate($t, $bMulai, 1)->startOfMonth();
                                $tanggalSelesai = \Carbon\Carbon::createFromDate($t, $bSelesai, 1)->endOfMonth();

                                $laporansFiltered = $laporans->filter(function ($lap) use ($tanggalMulai, $tanggalSelesai) {
                                    if (empty($lap->laporan_periode_mulai)) return false;
                                    $tLap = \Carbon\Carbon::parse($lap->laporan_periode_mulai);
                                    return $tLap->between($tanggalMulai, $tanggalSelesai);
                                })
                                ->sortByDesc(function ($lap) {
                                    return \Carbon\Carbon::parse($lap->laporan_tanggal)->timestamp; // ✅ urut berdasarkan waktu sebenarnya
                                })
                                ->values();
                            }
                        @endphp

                        {{-- Tabel Data --}}
                        <table class="table table-bordered align-middle text-center" id="tabelBidang" style="width:100%;">
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
                                @forelse($laporansFiltered as $lap)
                                    <tr>
                                        <td>LAP#{{ $lap->laporan_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($lap->laporan_tanggal)->translatedFormat('d F Y') }}</td>
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
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-muted">Tidak ada data untuk periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Footer --}}
                @include('admin.partials.footeradmin')
            </main>
        </div>
    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabelBidang').DataTable({
                responsive: true,
                pageLength: 10,
                order: [],
                language: { url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" }
            });
        });
    </script>
</body>
</html>
