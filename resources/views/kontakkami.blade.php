<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami - Crochet Lixiu DIY</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    {{-- Header --}}
    @include('partials.header')

    <main class="container">
        <h2 class="page-title">Kontak Kami</h2>

        <div class="contact-container">
            {{-- Kiri: Map + Alamat --}}
            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.1177686903063!2d115.22979807419809!3d-8.67268188826337!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2471abcfad18d%3A0x19f3945cc74d77bb!2sLapangan%20Puputan%20Niti%20Mandala%20Renon!5e0!3m2!1sid!2sid!4v1691813130521!5m2!1sid!2sid"
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>

                <div class="alamat">
                    <h3>Alamat Kami</h3>
                    <p>Jl. Raya Puputan, Niti Mandala, Renon,<br>
                        Denpasar, Bali 80235</p>
                </div>
            </div>

            {{-- Kanan: Form Kontak --}}
            <div class="form-container">
                <h3>Kirim Pesan</h3>
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required>
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea name="pesan" id="pesan" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Kirim</button>
                </form>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    @include('partials.footer')
</body>

</html>