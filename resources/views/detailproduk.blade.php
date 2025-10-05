<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <title>Detail Produk - MyShop</title>
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

                <!-- Rekomendasi Produk Slider -->
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

            <!-- Detail Produk -->
            <main class="col-md-9">
                <div class="row">
                    <!-- Gambar Produk -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="{{asset($produk->produk_gambar)}}" class="card-img-top"
                                alt="{{$produk->produk_nama}}" style="object-fit: cover; height: 400px;">
                        </div>
                    </div>

                    <!-- Info Produk -->
                    <div class="col-md-6">
                        <h2 class="fw-bold mb-3">{{$produk->produk_nama}}</h2>
                        <p class="text-muted">Kategori: <span class="fw-semibold">{{$produk->kategori_nama}}</span></p>
                        <h4 class="text-danger fw-bold mb-4">Rp {{ number_format($produk->produk_harga, 0, ',', '.') }}
                        </h4>

                        <p class="mb-4">
                            {{ $produk->produk_deskripsi }}
                        </p>
                        <p class="mb-4">
                            Stok tersedia: <span class="fw-semibold">{{ $produk->produk_stok }}</span>
                        </p>

                        <form action="{{route('tambah.keranjang')}}" method="POST">
                            @csrf
                            <div class="d-flex align-items-center mb-3">
                                <label class="me-2 fw-semibold">Jumlah:</label>
                                <input type="number" value="1" min="1" name="jumlah" class="form-control w-25">
                                <input type="hidden" name="produk_id" value="{{ $produk->produk_id }}">
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
                        @foreach ($produklain as $produkb) <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="{{asset($produkb->produk_gambar)}}" class="card-img-top"
                                    alt="{{$produkb->produk_nama}}" height="200" style="object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $produkb->produk_nama }}</h6>
                                    <p class="text-danger fw-bold">Rp
                                        {{ number_format($produkb->produk_harga, 0, ',', '.') }}
                                    </p>
                                    <a href="{{ route('detailproduk', ['id' => $produkb->produk_id]) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </main>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>