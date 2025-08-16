<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Crochet Lixiu DIY</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    {{-- HEADER --}}
    @include('partials.header')

    {{-- SECTION HERO --}}

    {{-- SLIDER --}}
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
                @for ($i = 1; $i <= 8; $i++) <div class="product-card">
                    <img src="{{ asset("images/produk/product$i.jpg") }}" alt="Produk {{ $i }}">
                    <h3>Produk {{ $i }}</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <a href="#">More</a>
                    <div class="harga">Rp {{ number_format(50000 * $i, 0, ',', '.') }}</div>
            </div>
            @endfor
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
                @foreach (['Tas', 'Baju', 'Aksesori','Sepatu','Topi','Sweater'] as $kategori)
                <div class="kategori-card">
                    <img src="{{ asset('images/kategori/kategori-' . strtolower($kategori) . '.jpg') }}"
                        alt="{{ $kategori }}">
                    <h3>{{ $kategori }}</h3>
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

        function getVisibleCount(gridElement) {
            const wrapperWidth = gridElement.parentElement.offsetWidth; // lebar viewport
            const itemWidth = gridElement.children[0].offsetWidth; // lebar 1 item
            return Math.floor(wrapperWidth / itemWidth) || 1;
        }

        function slideProduk(step) {
            const visible = getVisibleCount(produkGrid);
            const maxIndex = Math.max(produkItems.length - visible, 0);
            produkIndex = (produkIndex + step + (maxIndex + 1)) % (maxIndex + 1);
            produkGrid.style.transform = `translateX(-${produkIndex * (100 / visible)}%)`;
        }

        function slideKategori(step) {
            const visible = getVisibleCount(kategoriGrid);
            const maxIndex = Math.max(kategoriItems.length - visible, 0);
            kategoriIndex = (kategoriIndex + step + (maxIndex + 1)) % (maxIndex + 1);
            kategoriGrid.style.transform = `translateX(-${kategoriIndex * (100 / visible)}%)`;
        }

        // Auto slide
        setInterval(() => slideProduk(1), 4000);
        setInterval(() => slideKategori(1), 5000);

        // Resize
        window.addEventListener("resize", () => {
            slideProduk(0);
            slideKategori(0);
        });
    </script>