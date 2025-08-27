<?php

namespace App\Http\Controllers;

use App\Models\ModelProduk;
use App\Models\ModelAdmin;
use App\Models\ModelKategori;
use App\Models\ModelCustomer;
use App\Models\ModelPengiriman;
use App\Models\ModelPembayaran;
use App\Models\ModelPesanan;
use App\Models\ModelKeranjang;
use App\Models\ModelLaporanPenjualan;
use App\Models\ModelRekomendasiProduk;
use Illuminate\Http\Request;

class HomepageKontrol extends Controller
{
    //
    public function index()
    {
        $produk = ModelProduk::join('lixiudiy_kategori', 'lixiudiy_produk.produk_kategori', '=', 'lixiudiy_kategori.kategori_id')
            ->select('lixiudiy_produk.*', 'lixiudiy_kategori.kategori_nama')
            ->get();
        $kategori = ModelKategori::all();
        $rekomendasi = ModelRekomendasiProduk::join('lixiudiy_produk', 'lixiudiy_rekomendasi_produk.rekomendasi_produk', '=', 'lixiudiy_produk.produk_id')
            ->select('lixiudiy_rekomendasi_produk.*', 'lixiudiy_produk.produk_nama', 'lixiudiy_produk.*', 'lixiudiy_produk.produk_harga', 'lixiudiy_produk.produk_gambar')
            ->get();
        return view('homepage', [
            'produk' => $produk,
            'kategori' => $kategori,
            'rekomendasi' => $rekomendasi,
        ]);
    }
    public function about()
    {
        return view('tentangkami');
    }
    public function contact()
    {
        return view('kontakkami');
    }
    public function produk()
    {
        $produk = ModelProduk::join('lixiudiy_kategori', 'lixiudiy_produk.produk_kategori', '=', 'lixiudiy_kategori.kategori_id')
            ->select('lixiudiy_produk.*', 'lixiudiy_kategori.kategori_nama')
            ->paginate(12);
        $kategori = ModelKategori::all();
        $rekomendasi = ModelRekomendasiProduk::join('lixiudiy_produk', 'lixiudiy_rekomendasi_produk.rekomendasi_produk', '=', 'lixiudiy_produk.produk_id')
            ->select('lixiudiy_rekomendasi_produk.*', 'lixiudiy_produk.produk_nama', 'lixiudiy_produk.*', 'lixiudiy_produk.produk_harga', 'lixiudiy_produk.produk_gambar')
            ->get();
        return view('daftarproduk', compact('produk', 'kategori', 'rekomendasi'));
    }
    public function detailProduk($id)
    {
        $produk = ModelProduk::findOrFail($id)
            ->join('lixiudiy_kategori', 'lixiudiy_produk.produk_kategori', '=', 'lixiudiy_kategori.kategori_id')
            ->select('lixiudiy_produk.*', 'lixiudiy_kategori.kategori_nama')
            ->where('lixiudiy_produk.produk_id', $id)
            ->first();
        $produklain = ModelProduk::join('lixiudiy_kategori', 'lixiudiy_produk.produk_kategori', '=', 'lixiudiy_kategori.kategori_id')
            ->select('lixiudiy_produk.*', 'lixiudiy_kategori.kategori_nama')
            ->paginate(12);
        $kategori = ModelKategori::all();
        $rekomendasi = ModelRekomendasiProduk::join('lixiudiy_produk', 'lixiudiy_rekomendasi_produk.rekomendasi_produk', '=', 'lixiudiy_produk.produk_id')
            ->select('lixiudiy_rekomendasi_produk.*', 'lixiudiy_produk.produk_nama', 'lixiudiy_produk.*', 'lixiudiy_produk.produk_harga', 'lixiudiy_produk.produk_gambar')
            ->get();
        return view('detailproduk', compact('produk', 'kategori', 'rekomendasi', 'produklain'));
    }
    public function daftarprodukkategori($id)
    {
        $produk = ModelProduk::join('lixiudiy_kategori', 'lixiudiy_produk.produk_kategori', '=', 'lixiudiy_kategori.kategori_id')
            ->select('lixiudiy_produk.*', 'lixiudiy_kategori.kategori_nama')
            ->where('lixiudiy_kategori.kategori_id', $id)
            ->paginate(6);

        $kategori = ModelKategori::all();
        $rekomendasi = ModelRekomendasiProduk::join('lixiudiy_produk', 'lixiudiy_rekomendasi_produk.rekomendasi_produk', '=', 'lixiudiy_produk.produk_id')
            ->select('lixiudiy_rekomendasi_produk.*', 'lixiudiy_produk.produk_nama', 'lixiudiy_produk.*', 'lixiudiy_produk.produk_harga', 'lixiudiy_produk.produk_gambar')
            ->get();
        return view('daftarproduk', compact('produk', 'kategori', 'rekomendasi'));
    }
    public function keranjang()
    {
        return view('keranjang');
    }
    public function pemesanan()
    {
        return view('pemesanan');
    }
    public function konfirmasiPembayaran()
    {
        return view('pembayaran');
    }
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('daftarakun');
    }
    public function logout()
    {
        // Logic for customer logout can be added here
        return redirect()->route('home');
    }
}