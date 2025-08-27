<!-- resources/views/keranjang.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <title>Keranjang - MyShop</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    @include('partials.header')

    <div class="container my-5">
        <h2 class="mb-4">Keranjang Belanja</h2>

        <div class="row">
            <!-- Tabel Keranjang -->
            <div class="col-md-8">
                <div class="table-responsive shadow-sm">
                    <table class="table align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 2; $i++) <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://picsum.photos/80/80?random={{ $i+20 }}" class="me-3 rounded"
                                            alt="Produk {{ $i }}">
                                        <div>
                                            <h6 class="mb-0">Produk {{ $i }}</h6>
                                            <small class="text-muted">Kategori X</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format(25000 * $i, 0, ',', '.') }}</td>
                                <td>
                                    <input type="number" class="form-control" value="1" min="1" style="width: 80px;">
                                </td>
                                <td>Rp {{ number_format(25000 * $i, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ringkasan Belanja -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Belanja</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Produk:</span>
                            <strong>2</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Harga:</span>
                            <strong>Rp 75.000</strong>
                        </div>
                        <a href="#" class="btn btn-primary w-100">Lanjutkan ke Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>