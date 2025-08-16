<header class="header shadow">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Toko">
    </div>
    @include('partials.menu')
    <div class="icons">
        <a href="#"><i class="fas fa-shopping-cart"></i></a>
        <a href="#"><i class="fas fa-user"></i></a>
    </div>
    <div class="menu-toggle" id="menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
</header>