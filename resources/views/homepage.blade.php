<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Crochet Lixiu DIY</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Pastikan wrapper tidak overflow */
        .slider-wrapper {
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .product-grid,
        .kategori-grid {
            display: flex;
            transition: transform 0.4s ease-in-out;
            gap: 1rem;
        }

        .product-card,
        .kategori-card {
            min-width: 200px;
            flex-shrink: 0;
        }

        .prev,
        .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 10px;
            cursor: pointer;
            z-index: 2;
        }

        .prev {
            left: 0;
        }

        .next {
            right: 0;
        }
    </style>
</head>

<body>
    {{-- HEADER --}}
    @include('partials.header')

    {{-- SLIDER HERO --}}
    <section class="slider">
        <div class="slides fade">
            <img src="{{ asset('images/slide/slider1.png') }}" alt="Slide 1">
            <img src="{{ asset('images/slide/slider2.jpg') }}" alt="Slide 2">
            <img src="{{ asset('images/slide/slider3.jpg') }}" alt="Slide 3">
        </div>
    </section>

    {{-- REKOMENDASI PRODUK --}}
    <section class="rekomendasi" id="produk">
        <h2>Rekomendasi Produk</h2>
        <div class="slider-wrapper">
            <button class="prev" onclick="slideProduk(-1)">&#10094;</button>
            <div class="product-grid" id="product-slider">
                @foreach ($rekomendasi as $rekomendasip)
                <div class="product-card">
                    <img src="{{ $rekomendasip->produk_gambar }}" alt="{{ $rekomendasip->produk_nama }}">
                    <h3>{{ $rekomendasip->rekomendasi_nama }}</h3>
                    <p>{{ \Illuminate\Support\Str::words($rekomendasip->produk_deskripsi, 20, '...') }}</p>
                    <a href="{{ route('detailproduk', ['id' => $rekomendasip->rekomendasi_produk]) }}">More</a>
                    <div class="harga">Rp {{ number_format($rekomendasip->produk_harga, 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>
            <button class="next" onclick="slideProduk(1)">&#10095;</button>
        </div>
    </section>

    {{-- KATEGORI PRODUK --}}
    <section class="kategori">
        <h2>Kategori Produk</h2>
        <div class="slider-wrapper">
            <button class="prev" onclick="slideKategori(-1)">&#10094;</button>
            <div class="kategori-grid" id="kategori-slider">
                @foreach ($kategori as $kategorip)
                <div class="kategori-card">
                    <a href="{{ route('daftarprodukkategori', ['id' => $kategorip->kategori_id]) }}">
                        <img src="{{ $kategorip->kategori_gambar}}" alt="{{ $kategorip->kategori_nama }}">
                        <h3>{{ $kategorip->kategori_nama }}</h3>
                    </a>
                </div>
                @endforeach
            </div>
            <button class="next" onclick="slideKategori(1)">&#10095;</button>
        </div>
    </section>

    {{-- FOOTER --}}
    @include('partials.footer')

    <script>
        let produkIndex = 0;
        let kategoriIndex = 0;

        const produkGrid = document.getElementById("product-slider");
        const kategoriGrid = document.getElementById("kategori-slider");
        const produkItems = produkGrid.children;
        const kategoriItems = kategoriGrid.children;

        function slide(grid, items, step, indexVar) {
            const itemWidth = items[0].offsetWidth + 16; // +16px kira² gap
            const visible = Math.floor(grid.parentElement.offsetWidth / itemWidth);
            const maxIndex = Math.max(items.length - visible, 0);

            if (indexVar === "produkIndex") {
                produkIndex = Math.min(Math.max(produkIndex + step, 0), maxIndex);
                grid.style.transform = `translateX(-${produkIndex * itemWidth}px)`;
            } else {
                kategoriIndex = Math.min(Math.max(kategoriIndex + step, 0), maxIndex);
                grid.style.transform = `translateX(-${kategoriIndex * itemWidth}px)`;
            }
        }

        function slideProduk(step) {
            slide(produkGrid, produkItems, step, "produkIndex");
        }

        function slideKategori(step) {
            slide(kategoriGrid, kategoriItems, step, "kategoriIndex");
        }

        // Auto slide
        setInterval(() => slideProduk(1), 4000);
        setInterval(() => slideKategori(1), 5000);

        // Resize
        window.addEventListener("resize", () => {
            slideProduk(0);
            slideKategori(0);
        });

        // SLIDER HERO
        let slideIndex = 0;
        const slides = document.querySelectorAll(".slider img");

        function showSlides() {
            slides.forEach(slide => slide.classList.remove("active"));
            slideIndex = (slideIndex + 1) > slides.length ? 1 : slideIndex + 1;
            slides[slideIndex - 1].classList.add("active");
        }

        slides[0].classList.add("active");
        setInterval(showSlides, 4000);
    </script>
</body>

</html>