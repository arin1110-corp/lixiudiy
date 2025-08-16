<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Produk - MyShop</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('partials.header')

    <div class="container my-5">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-3 mb-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header fw-bold">Kategori</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="#">Minuman</a></li>
                        <li class="list-group-item"><a href="#">Makanan</a></li>
                        <li class="list-group-item"><a href="#">Snack</a></li>
                        <li class="list-group-item"><a href="#">Special</a></li>
                    </ul>
                </div>

                <!-- Rekomendasi Produk Slider -->
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Rekomendasi</div>
                    <div id="recommendationCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @for ($i = 1; $i <= 5; $i++) <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                                <div class="d-flex justify-content-center">
                                    <div class="card" style="width: 15rem;">
                                        <img src="https://picsum.photos/250/160?random={{ $i+20 }}" class="card-img-top"
                                            alt="Rekomendasi {{ $i }}">
                                        <div class="card-body text-center p-2">
                                            <h6 class="card-title mb-1">Rekomendasi {{ $i }}</h6>
                                            <p class="fw-bold text-danger small mb-2">
                                                Rp {{ number_format(20000 * $i, 0, ',', '.') }}
                                            </p>
                                            <a href="/detail-produk" class="btn btn-sm btn-outline-primary">Detail</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @endfor
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#recommendationCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#recommendationCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
        </div>
        </aside>

        <!-- Detail Produk -->
        <main class="col-md-9">
            <div class="row">
                <!-- Gambar Produk -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <img src="https://picsum.photos/600/400?random=99" class="card-img-top" alt="Nama Produk">
                    </div>
                </div>

                <!-- Info Produk -->
                <div class="col-md-6">
                    <h2 class="fw-bold mb-3">Nama Produk</h2>
                    <p class="text-muted">Kategori: <span class="fw-semibold">Kategori A</span></p>
                    <h4 class="text-danger fw-bold mb-4">Rp 150.000</h4>

                    <p class="mb-4">
                        Deskripsi lengkap produk ini menjelaskan fitur, manfaat, dan detail penting.
                        Nantinya ini bisa diambil dari database.
                    </p>

                    <form action="tambah-keranjang" method="POST">
                        <div class="d-flex align-items-center mb-3">
                            <label class="me-2 fw-semibold">Jumlah:</label>
                            <input type="number" value="1" min="1" class="form-control w-25">
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Tambah ke Keranjang</button>
                        <a href="/produk" class="btn btn-outline-secondary">Kembali</a>
                    </form>
                </div>
            </div>

            <!-- Produk Terkait -->
            <div class="mt-5">
                <h4 class="fw-bold mb-4">Produk Terkait</h4>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @for ($i = 1; $i <= 4; $i++) <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="https://picsum.photos/300/200?random={{ $i+50 }}" class="card-img-top"
                                alt="Produk {{ $i }}">
                            <div class="card-body">
                                <h6 class="card-title">Produk {{ $i }}</h6>
                                <p class="text-danger fw-bold">Rp {{ number_format(12000 * $i, 0, ',', '.') }}</p>
                                <a href="/detail-produk" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            </div>
                        </div>
                </div>
                @endfor
            </div>
    </div>
    </main>
    </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>