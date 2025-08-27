<!-- resources/views/produk.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
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
                        @foreach ($kategori as $kategorip)
                        <li class="list-group-item">
                            <a href="{{ route('daftarprodukkategori',['id' => $kategorip->kategori_id]) }}"
                                class="text-decoration-none">{{ $kategorip->kategori_nama }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Rekomendasi Produk Slider di Sidebar -->
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Rekomendasi Produk</div>
                    <div id="recommendationCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($rekomendasi as $i => $rekomendasip)
                            <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                                <div class="d-flex justify-content-center">
                                    <div class="card" style="width: 15rem;">
                                        <img src="{{ asset($rekomendasip->produk_gambar)}}" class="card-img-top"
                                            alt="{{ $rekomendasip->produk_nama}}" height="250">
                                        <div class="card-body text-center p-2">
                                            <h6 class="card-title mb-1">{{ $rekomendasip->rekomendasi_nama}}</h6>
                                            <p class="fw-bold text-danger small mb-2">
                                                Rp {{ number_format($rekomendasip->produk_harga, 0, ',', '.') }}
                                            </p>
                                            <a href="{{ route('detailproduk', ['id' => $rekomendasip->rekomendasi_produk]) }}"
                                                class="btn btn-sm btn-outline-primary">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
                    @foreach($produk as $produkp)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="{{asset($produkp->produk_gambar)}}" class="card-img-top"
                                alt="{{$produkp->produk_nama}}" height="200" style="object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $produkp->produk_nama }}</h5>
                                <p class="card-text">
                                    {{ \Illuminate\Support\Str::words($produkp->produk_deskripsi, 15, '...') }}
                                </p>
                                <p class="fw-bold text-danger">Rp
                                    {{ number_format($produkp->produk_harga, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('detailproduk', ['id' => $produkp->produk_id]) }}"
                                    class="btn btn-sm btn-outline-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                {{-- 🔽 Paging --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $produk->links('pagination::bootstrap-5') }}
                </div>
            </main>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>