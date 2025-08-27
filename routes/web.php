<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministratorKontrol;
use App\Http\Controllers\HomepageKontrol;
use Google\Service\Dfareporting\Ad;

Route::get('/', [HomepageKontrol::class, 'index'])->name('home.page');
Route::get('/homepage', [HomepageKontrol::class, 'index'])->name('home.page');
Route::get('/tentang-kami', [HomepageKontrol::class, 'about'])->name('tentangkami');
Route::get('/kontak-kami', [HomepageKontrol::class, 'contact'])->name('kontak');

Route::get('/produk', [HomepageKontrol::class, 'produk'])->name('produk');

Route::get('/detailproduk/{id}', [HomepageKontrol::class, 'detailProduk'])->name('detailproduk');
Route::get('/daftarproduk/kategori/{id}', [HomepageKontrol::class, 'daftarprodukkategori'])->name('daftarprodukkategori');


Route::get('/keranjang', [HomepageKontrol::class, 'keranjang'])->name('keranjang');
Route::post('/tambah-keranjang', [HomepageKontrol::class, 'keranjang'])->name('keranjang');
Route::get('/pemesanan', [HomepageKontrol::class, 'pemesanan'])->name('pemesanan');
Route::get('/konfirmasi-pembayaran', [HomepageKontrol::class, 'konfirmasiPembayaran'])->name('konfirmasipembayaran');
Route::get('/admin-login', [AdministratorKontrol::class, 'login'])->name('admin.login');
Route::post('/admin-login-submit', [AdministratorKontrol::class, 'loginSubmit'])->name('admin.login.submit');
Route::get('/admin-logout', [AdministratorKontrol::class, 'logout'])->name('admin.logout');
Route::get('/login', [HomepageKontrol::class, 'login'])->name('login');
Route::get('/register', [HomepageKontrol::class, 'register'])->name('register');
Route::get('/logout', [HomepageKontrol::class, 'logout'])->name('logout');


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
Route::post('/admin/rekomendasi/simpan', [AdministratorKontrol::class, 'simpanRekomendasi'])->name('admin.rekomendasi.simpan');
Route::delete('/admin/rekomendasi/delete/{id}', [AdministratorKontrol::class, 'hapusRekomendasi'])->name('admin.rekomendasi.hapus');
Route::put('/admin/rekomendasi/update/{id}', [AdministratorKontrol::class, 'updateRekomendasi'])->name('admin.rekomendasi.update');

Route::get('/admin/pengiriman', [AdministratorKontrol::class, 'pengiriman'])->name('admin.pengiriman');