<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministratorKontrol;
use App\Http\Controllers\HomepageKontrol;
use Google\Service\Dfareporting\Ad;

Route::get('/', [HomepageKontrol::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomepageKontrol::class, 'about'])->name('tentangkami');
Route::get('/kontak-kami', [HomepageKontrol::class, 'contact'])->name('kontak');
Route::get('/produk', function () {
    return view('daftarproduk');
})->name('produk');
Route::get('/home', function () {
    return view('homepage');
})->name('home');
Route::get('/akun-customer', function () {
    return view('akuncustomer');
})->name('akun.customer');
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register', function () {
    return view('daftarakun');
})->name('register');
Route::get('/logout', function () {
    // Logic for logout can be added here
    return redirect()->route('home');
})->name('logout');
Route::get('/customer-login', function () {
    return view('login');
})->name('customer.login');
Route::get('/customer-register', function () {
    return view('daftarakun');
})->name('customer.register');
Route::get('/tentang-kami', function () {
    return view('tentangkami');
})->name('tentangkami');
Route::get('/produk', function () {
    return view('daftarproduk');
})->name('produk');
Route::get('/kontak-kami', function () {
    return view('kontakkami');
})->name('kontak');
Route::get('/detailproduk', function () {
    return view('detailproduk');
})->name('detailproduk');
Route::post('/tambah-keranjang', function () {
    return view('keranjang');
})->name('keranjang');
Route::get('/keranjang', function () {
    return view('keranjang');
})->name('keranjang');
Route::get('/pemesanan', function () {
    return view('pemesanan');
})->name('pemesanan');
Route::get('/konfirmasi-pembayaran', function () {
    return view('pembayaran');
})->name('konfirmasipembayaran');
Route::get('/admin-login', function () {
    return view('loginadmin');
})->name('admin.login');
Route::get('/admin-dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
Route::get('/admin-login-submit', function () {
    // Logic for admin login can be added here
    return redirect()->route('admin.dashboard');
})->name('admin.login.submit');


//ADMIN SECTION
Route::get('/dashboard', [AdministratorKontrol::class, 'index'])->name('dashboard');
Route::get('/admin-login', [AdministratorKontrol::class, 'login'])->name('admin.login');
Route::post('/admin-login-submit', [AdministratorKontrol::class, 'loginSubmit'])->name('admin.login.submit');
Route::get('/admin-logout', [AdministratorKontrol::class, 'logout'])->name('admin.logout');


Route::get('/admin/produk', [AdministratorKontrol::class, 'produk'])->name('admin.produk');
Route::post('/admin/produk/simpan', [AdministratorKontrol::class, 'simpanProduk'])->name('admin.produk.simpan');
Route::put('/admin/produk/update/{id}', [AdministratorKontrol::class, 'updateProduk'])->name('admin.produk.update');
Route::delete('/admin/produk/delete/{id}', [AdministratorKontrol::class, 'hapusProduk'])->name('admin.produk.hapus');



Route::get('/admin/kategori', [AdministratorKontrol::class, 'kategori'])->name('admin.kategori');
Route::post('/admin/kategori/simpan', [AdministratorKontrol::class, 'simpanKategori'])->name('admin.kategori.simpan');
Route::put('/admin/kategori/update/{id}', [AdministratorKontrol::class, 'updateKategori'])->name('admin.kategori.update');
Route::delete('/admin/kategori/delete/{id}', [AdministratorKontrol::class, 'hapusKategori'])->name('admin.kategori.hapus');

Route::get('/admin/customer', [AdministratorKontrol::class, 'customer'])->name('admin.customer');
Route::get('/admin/rekomendasi', [AdministratorKontrol::class, 'rekomendasi'])->name('admin.rekomendasi');
Route::get('/admin/pengiriman', [AdministratorKontrol::class, 'pengiriman'])->name('admin.pengiriman');
