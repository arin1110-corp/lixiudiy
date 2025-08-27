<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Customer</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    .list-group-item.active {
        background-color: #198754;
        border-color: #198754;
    }

    .card {
        min-height: 350px;
    }
    </style>
</head>

<body>
    {{-- HEADER --}}
    @include('partials.header')

    <div class="container my-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="list-group shadow-sm">
                    <a href="#profil" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                        <i class="fa fa-user me-2"></i> Profil Saya
                    </a>
                    <a href="#pesanan" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fa fa-box me-2"></i> Pesanan Saya
                    </a>
                    <a href="#alamat" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fa fa-map-marker-alt me-2"></i> Alamat Pengiriman
                    </a>
                    <a href="#kartu" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fa fa-credit-card me-2"></i> Kartu Pembayaran
                    </a>
                    <a href="#riwayat" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fa fa-history me-2"></i> Riwayat Pesanan
                    </a>
                    <a href="#" class="list-group-item list-group-item-action text-danger">
                        <i class="fa fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="tab-content">

                    {{-- PROFIL --}}
                    <div class="tab-pane fade show active" id="profil">
                        <div class="card shadow-sm p-4 rounded-4">
                            <h4 class="mb-4">Profil Saya</h4>
                            <form method="POST" action="#">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('name', Auth::user()->name ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control"
                                        value="{{ old('email', Auth::user()->email ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nomor Telepon</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('phone', Auth::user()->phone ?? '') }}">
                                </div>
                                <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>

                    {{-- PESANAN --}}
                    <div class="tab-pane fade" id="pesanan">
                        <div class="card shadow-sm p-4 rounded-4">
                            <h4 class="mb-4">Pesanan Saya</h4>
                            <p>Daftar pesanan aktif Anda akan muncul di sini.</p>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD123</td>
                                        <td>15-08-2025</td>
                                        <td><span class="badge bg-warning">Menunggu</span></td>
                                        <td>Rp 250.000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ALAMAT --}}
                    <div class="tab-pane fade" id="alamat">
                        <div class="card shadow-sm p-4 rounded-4">
                            <h4 class="mb-4">Alamat Pengiriman</h4>
                            <div class="mb-3">
                                <p><strong>Alamat Utama:</strong><br>
                                    Jl. Contoh No.123, Jakarta</p>
                                <button class="btn btn-outline-primary btn-sm">Ubah Alamat</button>
                            </div>
                        </div>
                    </div>

                    {{-- KARTU --}}
                    <div class="tab-pane fade" id="kartu">
                        <div class="card shadow-sm p-4 rounded-4">
                            <h4 class="mb-4">Kartu Pembayaran</h4>
                            <p>Tambahkan atau kelola metode pembayaran Anda.</p>
                            <button class="btn btn-success"><i class="fa fa-plus me-2"></i> Tambah Kartu</button>
                        </div>
                    </div>

                    {{-- RIWAYAT --}}
                    <div class="tab-pane fade" id="riwayat">
                        <div class="card shadow-sm p-4 rounded-4">
                            <h4 class="mb-4">Riwayat Pesanan</h4>
                            <ul>
                                <li>Pesanan #ORD111 - Selesai</li>
                                <li>Pesanan #ORD112 - Selesai</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>