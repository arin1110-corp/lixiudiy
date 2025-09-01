<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Pesanan</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
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
                @foreach ($pesanan as $p)
                <div class="row align-items-center mb-3">
                    <div class="col-md-2 text-center">
                        <img src="{{ asset($p->produk_gambar) }}" class="img-fluid rounded shadow-sm" alt="Produk"
                            width="100">
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold">{{ $p->produk_nama }}</h5>
                        <p class="text-muted mb-0">Jumlah: {{ $p->pesanan_jumlah }}</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <h5 class="text-success fw-bold">Rp {{ number_format($p->pesanan_total_harga, 0, ',', '.') }}
                        </h5>
                    </div>
                </div>
                @endforeach
                <hr>
                <div class="row">
                    <div class="col text-end">
                        <strong class="fs-5">Total: Rp
                            {{ number_format($pesanan->sum('pesanan_total_harga'), 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pilih Pengiriman -->
        <div class="card mb-4">
            <div class="card-header">🚚 Pilih Pengiriman</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Metode Pengiriman</label>
                    <select class="form-select" id="kurir" name="kurir">

                        @php
                        $subtotal = $pesanan->sum('pesanan_total_harga');
                        @endphp
                        @foreach ($kurir as $k)
                        <option value="{{ $k->kurir_id }}" data-ongkir="{{ $k->kurir_ongkir }}"
                            data-kurir="{{ $k->kurir_id }}">
                            {{ $k->kurir_nama }} - Rp {{ number_format($k->kurir_ongkir, 0, ',', '.') }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Pilih Pengiriman -->
        <div class="card mb-4">
            <div class="card-header">Total</div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="col text-start-0">
                        <strong class="fs-7">Total Produk: Rp
                            {{ number_format($pesanan->sum('pesanan_total_harga'), 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col text-start">
                        <strong class="fs-7">Total Ongkir : Rp. <span id="ongkir"></span></strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col text-start">
                        <strong class="fs-5">Total Bayar : Rp
                            <span id="total"></span></strong>
                    </div>
                </div>
            </div>
        </div>


        <form action="{{ route('konfirmasi.pembayaran') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @php
            $allPesananId = $pesanan->pluck('pesanan_id')->implode(';');
            @endphp
            <input type="hidden" name="kurir" id="kuririd">
            <input type="hidden" name="pesanan_id" value="{{ $allPesananId }}">
            <input type="hidden" id="totalBayar" name="pembayaran_jumlah">
            <input type="hidden" name="alamat" value="{{ $pesanan->first()->customer_alamat }}">

            <!-- Metode pembayaran -->
            <div class="card mb-4">
                <div class="card-header">💳 Pilih Metode Pembayaran</div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="pembayaran_metode" id="transfer" value="1"
                            checked>
                        <label class="form-check-label" for="transfer">Transfer Bank</label>
                    </div>
                    <div id="transferStep" class="payment-step mt-2">
                        <!-- detail step transfer -->
                        <ol>
                            <li>Pilih bank tujuan (BCA, BRI, Mandiri, dll).</li>
                            <li>Masukkan nomor rekening yang ditampilkan.</li>
                            <li>Transfer sesuai total pesanan.</li>
                            <li>Upload bukti transfer pada halaman konfirmasi.</li>
                            <li>Tunggu verifikasi admin sebelum pesanan diproses.</li>
                        </ol>
                        <div class="mt-3">
                            <strong>Nomor Rekening Bank:</strong>
                            <ul>
                                <li><b>BCA</b> - 1234567890 a.n PT. Contoh Shop</li>
                                <li><b>Mandiri</b> - 9876543210 a.n PT. Contoh Shop</li>
                                <li><b>BRI</b> - 555666777 a.n PT. Contoh Shop</li>
                            </ul>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="bukti" class="form-label">Upload Bukti Transfer (JPG)</label>
                            <input type="file" class="form-control" name="bukti" id="bukti" accept=".jpg,.jpeg"
                                required>
                            <small class="text-muted">File harus JPG.</small>
                        </div>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="pembayaran_metode" id="ewallet" value="2">
                        <label class="form-check-label" for="ewallet">E-Wallet / QRIS</label>
                    </div>
                    <div id="ewalletStep" class="payment-step mt-2" style="display: none;">
                        <!-- detail step qris -->
                        <ol>
                            <li>Scan QRIS yang ditampilkan di layar.</li>
                            <li>Pilih aplikasi pembayaran (OVO, Dana, GoPay, ShopeePay, dll).</li>
                            <li>Pastikan jumlah pembayaran sesuai dengan tagihan.</li>
                            <li>Setelah berhasil, simpan bukti transaksi.</li>
                            <li>Pembayaran otomatis terverifikasi dalam beberapa menit.</li>
                        </ol>
                        <div class="mt-2">
                            <center><img src="{{ asset('images/qris.jpeg') }}" alt="QRIS" style="max-width:300px;">
                            </center>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pembayaran_metode" id="cod" value="3">
                        <label class="form-check-label" for="cod">COD (Bayar di Tempat)</label>
                    </div>
                    <div id="codStep" class="payment-step mt-2" style="display: none;">
                        <!-- detail step cod -->
                        <ol>
                            <li>Kami akan mengirim pesanan ke alamat Anda.</li>
                            <li>Bayar sesuai total pesanan kepada kurir.
                            </li>
                            <li>Pastikan uang pas untuk mempermudah proses.</li>
                            <li>Setelah pembayaran, kurir menyerahkan barang.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Tombol Bayar -->
            <div class="text-center mb-5">
                <button type="submit" class="btn btn-success btn-lg px-5">Bayar Sekarang</button>
            </div>
        </form>
    </div>

    @include('partials.footer')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // pastikan angka mentah (tanpa pemisah ribuan) masuk ke JS
            const subtotal = Number("{{ (float) $subtotal }}");
            console.log(subtotal);
            const kurirSelect = document.getElementById("kurir");
            const ongkirEl = document.getElementById("ongkir");
            const kurir = document.getElementById("kurir");
            const kurirInput = document.getElementById("kuririd");
            const totalEl = document.getElementById("total");
            const totalBayarInput = document.getElementById("totalBayar");

            const rupiah = (n) => n.toLocaleString("id-ID");

            function updateTotal() {
                const opt = kurirSelect?.options[kurirSelect.selectedIndex];
                const ongkir = Number(opt?.dataset.ongkir ?? 0);
                const total = subtotal + ongkir;

                ongkirEl.textContent = rupiah(ongkir);
                totalEl.textContent = rupiah(total);

                // simpan nilai mentah ke form (biar masuk DB)
                totalBayarInput.value = total;
                kurirInput.value = kurir.value;
            }

            if (kurirSelect) {
                // hitung saat halaman pertama kali load
                updateTotal();
                // hitung ulang saat kurir diganti
                kurirSelect.addEventListener("change", updateTotal);
            }
        });
    </script>
    <script>
        // Perbaikan: pakai name="pembayaran_metode"
        document.querySelectorAll('input[name="pembayaran_metode"]').forEach((radio) => {
            radio.addEventListener("change", function() {
                document.querySelectorAll(".payment-step").forEach((step) => step.style.display = "none");

                if (this.value === "1") {
                    document.getElementById("transferStep").style.display = "block";
                } else if (this.value === "2") {
                    document.getElementById("ewalletStep").style.display = "block";
                } else if (this.value === "3") {
                    document.getElementById("codStep").style.display = "block";
                }
            });
        });
    </script>\
</body>

</html>