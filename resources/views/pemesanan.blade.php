<!-- resources/views/checkout.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checkout - MyShop</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    @include('partials.header')

    <div class="container my-5">
        <h2 class="mb-4">Checkout</h2>

        <div class="row">
            <!-- Form Alamat Pengiriman -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-bold">Alamat Pengiriman</div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" class="form-control" value="{{$datacustomer->customer_nama}}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" rows="3"
                                    readonly>{{$datacustomer->customer_alamat}}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" value="{{$datacustomer->customer_telepon}}"
                                    readonly>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Ringkasan Produk -->
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Produk Dipesan</div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $subtotal = $pesanan->sum('pesanan_total_harga');
                                @endphp
                                @foreach ($pesanan as $k)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $k->produk_gambar }}" class="me-3 rounded"
                                                alt="{{ $k->produk_nama }}" width="60" height="60">
                                            <div>
                                                <h6 class="mb-0">{{ $k->produk_nama }}</h6>
                                                <small class="text-muted">{{$k->kategori_nama }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $k->pesanan_jumlah }}</td>
                                    <td>Rp {{ number_format($k->produk_harga, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($k->pesanan_total_harga, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Belanja -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Belanja</h5>

                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total:</span>
                            <strong>Rp <span
                                    id="total">{{ number_format($pesanan->sum('pesanan_total_harga'), 0, ',', '.') }}</span></strong>
                        </div>
                        <a href="{{route('pembayaran.form')}}"><button class="btn btn-success w-100">Bayar
                                Sekarang</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>