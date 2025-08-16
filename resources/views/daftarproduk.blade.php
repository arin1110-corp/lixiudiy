<!-- resources/views/produk.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Produk - MyShop</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

                <!-- Rekomendasi Produk Slider di Sidebar -->
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Rekomendasi Produk</div>
                    <div id="recommendationCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @for ($i = 1; $i <= 5; $i++) <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                                <div class="d-flex justify-content-center">
                                    <div class="card" style="width: 15rem;">
                                        <img src="https://picsum.photos/250/200?random={{ $i+10 }}" class="card-img-top"
                                            alt="Rekomendasi {{ $i }}">
                                        <div class="card-body text-center p-2">
                                            <h6 class="card-title mb-1">Rekomendasi {{ $i }}</h6>
                                            <p class="fw-bold text-danger small mb-2">
                                                Rp {{ number_format(15000 * $i, 0, ',', '.') }}
                                            </p>
                                            <a href="{{route('detailproduk')}}"
                                                class="btn btn-sm btn-outline-primary">Detail</a>
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

        <!-- Produk Grid -->
        <main class="col-md-9">
            <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                @for ($i = 1; $i <= 6; $i++) <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="https://picsum.photos/300/200?random={{ $i }}" class="card-img-top"
                            alt="Produk {{ $i }}">
                        <div class="card-body">
                            <h5 class="card-title">Produk {{ $i }}</h5>
                            <p class="card-text">Deskripsi singkat produk {{ $i }}.</p>
                            <p class="fw-bold text-danger">Rp {{ number_format(10000 * $i, 0, ',', '.') }}</p>
                            <a href="{{route('detailproduk')}}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
            </div>
            @endfor
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Berikutnya</a></li>
        </ul>
    </nav>
    </main>
    </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>