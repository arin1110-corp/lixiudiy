<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.partials.headadmin')

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style type="text/css">
        a {
            text-decoration: none;
            color: black;
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

                {{-- Statistik --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <a href="{{ route('admin.rekomendasi') }}">
                                <div class="card-body">
                                    <h5>Total Rekomendasi Produk</h5>
                                    <p class="display-6 text-warning">{{ @$totalRekomendasi }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <a href="{{ route('admin.produk') }}">
                                <div class="card-body">
                                    <h5>Total Produk</h5>
                                    <p class="display-6 text-success">{{ @$totalproduk }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <a href="{{ route('admin.kategori') }}">
                                <div class="card-body">
                                    <h5>Total Kategori</h5>
                                    <p class="display-6 text-primary">{{ @$totalKategori }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card text-center">
                            <a href="{{ route('admin.customer') }}">
                                <div class="card-body">
                                    <h5>Total Customer</h5>
                                    <p class="display-6 text-warning">{{ @$totalCust }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card text-center">
                            <a href="{{ route('admin.pesanan') }}">
                                <div class="card-body">
                                    <h5>Total Transaksi</h5>
                                    <p class="display-6 text-success">{{ @$totalPesanan }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Grafik Pendapatan & Komposisi --}}
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                        Grafik Pendapatan per Tahun
                        <select id="filterTahun" class="form-select w-auto">
                            @foreach ($listTahun as $th)
                                <option value="{{ $th }}" {{ $th == $tahun ? 'selected' : '' }}>{{ $th }}</option>
                            @endforeach
                        </select>
                    </div>
                            <div class="card-header bg-white fw-bold">Grafik Pendapatan per Periode</div>
                            <div class="card-body">
                                <canvas id="grafikPendapatan" height="120"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                @include('admin.partials.footeradmin')
            </main>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    {{-- Inisialisasi DataTables --}}
    <script>
        $(document).ready(function() {
            $('#tableAll').DataTable();
            $('#tablePns').DataTable();
            $('#tablePppk').DataTable();
        });
    </script>

    {{-- Grafik Pendapatan & Pie --}}
    <script>
    const ctxBar = document.getElementById('grafikPendapatan').getContext('2d');

    const chartData = {
        labels: @json($chartLabels ?? []),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: @json($chartData ?? []),
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    const grafikPendapatan = new Chart(ctxBar, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // === Dropdown filter tahun ===
    $('#filterTahun').on('change', function() {
        const tahun = $(this).val();
        $.ajax({
            url: "{{ route('dashboard') }}",
            data: { tahun: tahun },
            success: function(res) {
                grafikPendapatan.data.labels = res.labels;
                grafikPendapatan.data.datasets[0].data = res.data;
                grafikPendapatan.update();
            }
        });
    });
</script>


</body>

</html>
