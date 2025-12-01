<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministratorKontrol;
use App\Http\Controllers\HomepageKontrol;
use Google\Service\AndroidEnterprise\Administrator;
use Google\Service\Dfareporting\Ad;

//homepage
Route::get('/', [HomepageKontrol::class, 'index'])->name('home.page');
Route::get('/homepage', [HomepageKontrol::class, 'index'])->name('home.page');
Route::get('/tentang-kami', [HomepageKontrol::class, 'about'])->name('tentangkami');
Route::get('/kontak-kami', [HomepageKontrol::class, 'contact'])->name('kontak');
Route::get('/produk', [HomepageKontrol::class, 'produk'])->name('produk');
Route::get('/detailproduk/{id}', [HomepageKontrol::class, 'detailProduk'])->name('detailproduk');
Route::get('/daftarproduk/kategori/{id}', [HomepageKontrol::class, 'daftarprodukkategori'])->name('daftarprodukkategori');
Route::get('/login', [HomepageKontrol::class, 'login'])->name('login');
Route::get('/lupa-password', [HomepageKontrol::class, 'lupaPassword'])->name('customer.lupa_pw');
Route::post('/lupa-password-submit', [HomepageKontrol::class, 'lupaPasswordSubmit'])->name('customer.proses_lupapassword');
Route::post('/login-submit', [HomepageKontrol::class, 'loginSubmit'])->name('customer.login');
Route::get('/register', [HomepageKontrol::class, 'register'])->name('customer.register');
Route::post('/register-submit', [HomepageKontrol::class, 'registerSubmit'])->name('customer.register.submit');
Route::get('/logout', [HomepageKontrol::class, 'logout'])->name('logout');
Route::get('/aktivasi-akun', [HomepageKontrol::class, 'aktivasiForm'])->name('aktivasi.form');
Route::post('/aktivasi-akun-submit', [HomepageKontrol::class, 'aktivasiAkunSubmit'])->name('customer.aktivasi');
Route::put('/update/customer/{id}', [HomepageKontrol::class, 'updateCustomer'])->name('update.customer');


//customer
Route::get('/keranjang', [HomepageKontrol::class, 'keranjang'])->name('keranjang');
Route::post('/tambah-keranjang', [HomepageKontrol::class, 'tambahkeranjang'])->name('tambah.keranjang');
Route::put('/update/keranjang/{id}', [HomepageKontrol::class, 'updateKeranjang'])->name('update.keranjang');
Route::delete('/hapus/keranjang/{id}', [HomepageKontrol::class, 'hapusKeranjang'])->name('hapus.keranjang');
Route::get('/akun-saya', [HomepageKontrol::class, 'akunSaya'])->name('akun.customer');
Route::post('/akun-saya-update', [HomepageKontrol::class, 'akunSayaUpdate'])->name('akun.customer.update')->middleware('auth');

Route::get('/pemesanan', [HomepageKontrol::class, 'pemesanan'])->name('pesanan');
Route::get('/pemesanan-submit', [HomepageKontrol::class, 'checkout'])->name('pesanan.submit');
Route::get('/lanjut/bayar', [HomepageKontrol::class, 'pembayaran'])->name('pembayaran.form');
Route::post('/konfirmasi-pembayaran', [HomepageKontrol::class, 'konfirmasiPembayaran'])->name('konfirmasi.pembayaran');
Route::get('/pengiriman', [HomepageKontrol::class, 'pengiriman'])->name('pengiriman');



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
Route::get('/admin/laporan/cetak', [AdministratorKontrol::class, 'cetakPDF'])->name('admin.laporan.cetak');

Route::get('/admin/rekomendasi', [AdministratorKontrol::class, 'rekomendasi'])->name('admin.rekomendasi');
Route::post('/admin/rekomendasi/simpan', [AdministratorKontrol::class, 'simpanRekomendasi'])->name('admin.rekomendasi.simpan');
Route::delete('/admin/rekomendasi/delete/{id}', [AdministratorKontrol::class, 'hapusRekomendasi'])->name('admin.rekomendasi.hapus');
Route::put('/admin/rekomendasi/update/{id}', [AdministratorKontrol::class, 'updateRekomendasi'])->name('admin.rekomendasi.update');

Route::get('/admin/pengiriman', [AdministratorKontrol::class, 'pengiriman'])->name('admin.pengiriman');
Route::post('/admin/pengiriman/resi/{id}', [AdministratorKontrol::class, 'pengirimanResi'])->name('pengiriman.resi');

Route::get('/admin/pesanan', [AdministratorKontrol::class, 'pesanan'])->name('admin.pesanan'); // web.php
Route::post('/admin/pembayaran/verifikasi/{id}', [AdministratorKontrol::class, 'verifikasi'])->name('admin.pembayaran.verifikasi');

Route::post('/admin/laporan/proses', [AdministratorKontrol::class, 'laporanProses'])->name('admin.laporan.proses');

Route::get('/admin/laporan', [AdministratorKontrol::class, 'laporan'])->name('admin.laporan');