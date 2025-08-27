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
                                <input type="text" class="form-control" placeholder="Nama Lengkap">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" rows="3" placeholder="Alamat lengkap"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Metode Pengiriman</label>
                                <select class="form-select">
                                    <option>JNE</option>
                                    <option>SiCepat</option>
                                    <option>POS Indonesia</option>
                                </select>
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
                                <tr>
                                    <td>Produk A</td>
                                    <td>2</td>
                                    <td>Rp 50.000</td>
                                    <td>Rp 100.000</td>
                                </tr>
                                <tr>
                                    <td>Produk B</td>
                                    <td>1</td>
                                    <td>Rp 75.000</td>
                                    <td>Rp 75.000</td>
                                </tr>
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
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>Rp 175.000</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkir:</span>
                            <strong>Rp 20.000</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total:</span>
                            <strong>Rp 195.000</strong>
                        </div>
                        <button class="btn btn-success w-100">Bayar Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>