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
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.311205304852!2d113.70866627575523!3d-8.171369481897127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6943274ac3921%3A0xfc4510ffe97c1c55!2sJl.%20Nias%20No.10%2C%20Tegal%20Boto%20Lor%2C%20Sumbersari%2C%20Kec.%20Sumbersari%2C%20Kabupaten%20Jember%2C%20Jawa%20Timur%2068121!5e0!3m2!1sid!2sid!4v1756359677155!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

                <div class="alamat">
                    <h3>Alamat Kami</h3>
                    <p>Jl. Nias No.10, Tegal Boto Lor, Sumbersari, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121
                    </p>
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