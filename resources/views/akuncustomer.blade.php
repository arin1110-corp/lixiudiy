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
                    <a href="#pesanan" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                        <i class="fa fa-box me-2"></i> Pesanan Saya
                    </a>
                    <a href="#profil" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fa fa-user me-2"></i> Profil Saya
                    </a>
                    <a href="#pengiriman" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fa fa-map-marker-alt me-2"></i> Pengiriman
                    </a>
                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger">
                        <i class="fa fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="tab-content">

                    {{-- PESANAN --}}
                    <div class="tab-pane fade show active" id="pesanan">
                        <div class="card shadow-sm p-4 rounded-4">
                            <h4 class="mb-4">Pesanan Saya</h4>

                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if(empty($pesanan))
                            <p>Belum ada pesanan.</p>
                            @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Status Pembayaran</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanan as $pembayaranId => $group)
                                    @php
                                    $pay = $group['pembayaran']; // bisa null
                                    $items = $group['items'];
                                    $status = $group['status_bayar'];
                                    $action = $group['action'];
                                    $totalBayar = $items->sum(fn($i) => $i->pesanan_jumlah * $i->produk_harga);
                                    $collapseId = 'detail-' . $pembayaranId;
                                    @endphp

                                    <tr>
                                        <td data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                            style="cursor:pointer;">
                                            #ORD{{ $pembayaranId }}
                                        </td>
                                        <td data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                            style="cursor:pointer;">
                                            @if ($pay)
                                            {{ $pay->pembayaran_tanggal }}
                                            @else
                                            <span class="text-danger">Belum ada pembayaran</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($status == 'Belum Dibayar')
                                            <span class="badge bg-danger">{{ $status }}</span>
                                            @elseif($status == 'Menunggu Konfirmasi')
                                            <span class="badge bg-warning">{{ $status }}</span>
                                            @elseif($status == 'Sudah Dikonfirmasi')
                                            <span class="badge bg-success">{{ $status }}</span>
                                            @else
                                            <span class="badge bg-secondary">{{ $status }}</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                                        <td>
                                            @if($action === 'bayar')
                                            <a href="{{ route('pembayaran.form', $pembayaranId) }}"
                                                class="btn btn-sm btn-success"
                                                onclick="event.stopPropagation()">Bayar</a>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr class="collapse bg-light" id="{{ $collapseId }}">
                                        <td colspan="5">
                                            <strong>Produk Dibeli:</strong>
                                            <ul class="mb-0">
                                                @foreach($items as $it)
                                                <li class="mb-2 d-flex align-items-center">
                                                    <img src="{{ $it->produk_gambar }}" width="60" class="me-2 rounded">
                                                    {{ $it->produk_nama }}
                                                    ({{ $it->pesanan_jumlah }} x Rp
                                                    {{ number_format($it->produk_harga,0,',','.') }})
                                                    = <strong>Rp
                                                        {{ number_format($it->pesanan_jumlah * $it->produk_harga,0,',','.') }}</strong>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>

                    {{-- PROFIL --}}
                    <div class="tab-pane fade show" id="profil">
                        <div class="card shadow-sm p-4 rounded-4">
                            <h4 class="mb-4">Profil Saya</h4>
                            <form method="POST" action="{{ route('update.customer', $customer->customer_id) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="customer_nama"
                                        value="{{ $customer->customer_nama }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control" name="customer_email"
                                        value="{{ $customer->customer_email }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nomor Telepon</label>
                                    <input type="text" class="form-control" name="customer_telepon"
                                        value="{{ $customer->customer_telepon }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Alamat</label>
                                    <textarea class="form-control" name="customer_alamat"
                                        rows="3">{{ $customer->customer_alamat }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="customer_tanggallahir"
                                        value="{{ $customer->customer_tanggallahir }}">
                                </div>
                                <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>

                    {{-- PENGIRIMAN --}}
                    <div class="tab-pane fade" id="pengiriman">
                        <div class="card shadow-sm p-4 rounded-4">
                            <h4 class="mb-4">Pengiriman</h4>

                            @if(empty($pengirimanindex))
                            <p>Belum ada pengiriman.</p>
                            @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Pengiriman</th>
                                        <th>Alamat</th>
                                        <th>Nomor Resi</th>
                                        <th>Status</th>
                                        <th>Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengirimanindex as $pengirimanId => $group)
                                    @php
                                    $kirim = $group['pengiriman'];
                                    $items = $group['items'];
                                    $status = $group['status_kirim'];
                                    $collapseId = 'kirim-' . $pengirimanId;
                                    @endphp

                                    <tr data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                        style="cursor:pointer;">
                                        <td>#SHP{{ $pengirimanId }}</td>
                                        <td>{{ $group['alamat'] }}</td>
                                        <td>{{ $group['nomor'] }}</td>
                                        <td>
                                            @if($status == 'Belum Dikirim')
                                            <span class="badge bg-danger">{{ $status }}</span>
                                            @elseif($status == 'Sudah Dikirim')
                                            <span class="badge bg-warning">{{ $status }}</span>
                                            @elseif($status == 'Diterima Customer')
                                            <span class="badge bg-success">{{ $status }}</span>
                                            @else
                                            <span class="badge bg-secondary">{{ $status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $items->count() }} Produk</td>
                                    </tr>

                                    <tr class="collapse bg-light" id="{{ $collapseId }}">
                                        <td colspan="5">
                                            <strong>Produk:</strong>
                                            <ul class="mb-0">
                                                @foreach($items as $it)
                                                <li class="mb-2 d-flex align-items-center">
                                                    <img src="{{ $it->produk_gambar }}" width="60" class="me-2 rounded">
                                                    {{ $it->produk_nama }} ({{ $it->pesanan_jumlah }} x Rp
                                                    {{ number_format($it->produk_harga,0,',','.') }})
                                                </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
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