<nav class="col-md-2 d-none d-md-block sidebar p-3">
    <h4 class="mb-3"><img src="{{ asset('images/logo.png') }}" width="100"></h4>
    <h4>LIXIU DIY
    </h4>
    <h4>Admin</h4>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{route('dashboard')}}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{route('admin.produk')}}"><i class="bi bi-clipboard-check-fill"></i> Produk</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{route('admin.kategori')}}"><i class="bi bi-list-columns-reverse"></i> Kategori
                Produk</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{route('admin.customer')}}"><i class="bi bi-people"></i> Customer</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{route('admin.rekomendasi')}}"><i class="bi bi-collection-fill"></i>Rekomendasi
                Produk</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="{{route('admin.pengiriman')}}"><i class="bi bi-truck"></i>
                Pengiriman</a>
        </li>
    </ul>
</nav>