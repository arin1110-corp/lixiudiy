<!-- resources/views/keranjang.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <title>Keranjang - MyShop</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    @include('partials.header')

    <div class="container my-5">
        <h2 class="mb-4">Keranjang Belanja</h2>

        <div class="row">
            <!-- Tabel Keranjang -->
            <div class="col-md-8">
                <div class="table-responsive shadow-sm">
                    <table class="table align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keranjang as $k) <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $k->produk_gambar }}" class="me-3 rounded"
                                            alt="{{ $k->produk_nama }}" width="60" height="60">
                                        <div>
                                            <h6 class="mb-0">{{ $k->produk_nama }}</h6>
                                            <small class="text-muted">{{$k->kategori_nama }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($k->produk_harga, 0, ',', '.') }}</td>

                                <td>
                                    <form action="{{ route('update.keranjang', $k->keranjang_id) }}" method="POST"
                                        class="d-flex">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="jumlah" class="form-control me-2"
                                            value="{{ $k->keranjang_jumlah }}" min="1" style="width: 80px;">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fa fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>Rp {{ number_format($k->keranjang_total_harga, 0, ',', '.') }}</td>

                                <td>
                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#hapusModal{{ $k->keranjang_id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <!-- Modal Konfirmasi -->
                                    <div class="modal fade" id="hapusModal{{ $k->keranjang_id }}" tabindex="-1"
                                        aria-labelledby="hapusLabel{{ $k->keranjang_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="hapusLabel{{ $k->keranjang_id }}">
                                                        Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus
                                                    <strong>{{ $k->produk_nama }}</strong> dari keranjang?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('hapus.keranjang', $k->keranjang_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Ringkasan Belanja -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Belanja</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Produk:</span>
                            <strong>{{ $rinciantotalharga->total_produk ?? 0}}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Harga:</span>
                            <strong>Rp {{ number_format($rinciantotalharga->total_harga, 0, ',', '.') }}</strong>
                        </div>
                        <a href="{{route('pesanan.submit')}}" class="btn btn-primary w-100">Lanjutkan ke Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>