<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Crochet Lixiu DIY</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    {{-- HEADER --}}
    @include('partials.header')

    {{-- SECTION TENTANG KAMI --}}
    <section class="tentang-kami">
        <div class="container">
            <h1>Tentang Kami</h1>
            <p>
                Crochet Lixiu DIY berdiri dengan semangat untuk menghadirkan kerajinan tangan berkualitas
                dengan sentuhan kreatif dan penuh cinta. Kami percaya setiap rajutan memiliki cerita,
                dan melalui produk-produk kami, kami ingin menghadirkan kehangatan dalam kehidupan sehari-hari.
            </p>

            <p>
                Semua produk kami dibuat dengan detail, menggunakan bahan pilihan, dan dikerjakan
                langsung oleh pengrajin lokal. Dengan membeli produk Crochet Lixiu DIY, Anda tidak hanya
                mendapatkan barang unik, tetapi juga mendukung karya UMKM Indonesia.
            </p>

            <div class="visi-misi">
                <h2>Visi & Misi</h2>
                <ul>
                    <li>🌱 Menjadi brand crochet yang dipercaya dan dicintai masyarakat.</li>
                    <li>🧶 Memberdayakan pengrajin lokal untuk terus berkarya.</li>
                    <li>💖 Menghadirkan produk handmade yang berkualitas dan bernilai seni tinggi.</li>
                </ul>
            </div>

        </div>
    </section>

    {{-- FOOTER --}}
    @include('partials.footer')



</body>

</html>