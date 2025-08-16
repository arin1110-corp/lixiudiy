<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Pesanan</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        background: #ffffff;
        font-weight: bold;
        font-size: 1.1rem;
        border-bottom: 1px solid #eee;
    }

    h3 {
        font-weight: 700;
    }

    .btn-success {
        border-radius: 10px;
        padding: 12px 30px;
        font-size: 1.1rem;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    .btn-success:hover {
        transform: translateY(-2px);
    }
    </style>
</head>

<body>
    @include('partials.header')

    <div class="container mt-5 mb-5">
        <h3 class="mb-4 text-center">🛒 Rincian Pesanan</h3>

        <!-- Ringkasan Pesanan -->
        <div class="card mb-4 p-3">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('images/produk/product1.jpg') }}" class="img-fluid rounded shadow-sm"
                            alt="Produk">
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold">Nama Produk</h5>
                        <p class="text-muted mb-0">Jumlah: 2</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <h5 class="text-success fw-bold">Rp 200.000</h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col text-end">
                        <strong class="fs-5">Total: Rp 200.000</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pilih Pengiriman -->
        <div class="card mb-4">
            <div class="card-header">🚚 Pilih Pengiriman</div>
            <div class="card-body">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="shipping" id="jne" checked>
                    <label class="form-check-label" for="jne">JNE - Rp 20.000 (2-3 Hari)</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="shipping" id="jnt">
                    <label class="form-check-label" for="jnt">J&T - Rp 18.000 (2-4 Hari)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="shipping" id="sicepat">
                    <label class="form-check-label" for="sicepat">SiCepat - Rp 22.000 (1-2 Hari)</label>
                </div>
            </div>
        </div>

        <!-- Pilih Pembayaran -->
        <div class="card mb-4">
            <div class="card-header">💳 Pilih Metode Pembayaran</div>
            <div class="card-body">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment" id="transfer" checked>
                    <label class="form-check-label" for="transfer">Transfer Bank</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="payment" id="ewallet">
                    <label class="form-check-label" for="ewallet">E-Wallet (OVO, Dana, Gopay)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment" id="cod">
                    <label class="form-check-label" for="cod">COD (Bayar di Tempat)</label>
                </div>
            </div>
        </div>

        <!-- Tombol Bayar -->
        <div class="text-center mb-5">
            <button class="btn btn-success btn-lg px-5">Bayar Sekarang</button>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>