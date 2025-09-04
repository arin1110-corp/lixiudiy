<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.partials.headadmin')

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
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

                {{-- Statistik --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <a href="{{ route('admin.rekomendasi') }}">
                                <div class="card-body">
                                    <h5>Total Rekomendasi Produk</h5>
                                    <p class="display-6 text-warning">{{ @$totalRekomendasi }}</p>
                                </div>
                        </div>
                        </a>
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
                </div>{{-- Statistik --}}
                <div class="row mb-6">
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

    <script>
        $(document).ready(function() {
            $('#tableAll').DataTable();
            $('#tablePns').DataTable();
            $('#tablePppk').DataTable();
        });
    </script>
</body>

</html>