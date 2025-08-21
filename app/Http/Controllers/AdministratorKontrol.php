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

class AdministratorKontrol extends Controller
{
    //
    public function index()
    {
        $produk = ModelProduk::count();
        $customer = ModelCustomer::count();
        $pengiriman = ModelPengiriman::count();
        $pembayaran = ModelPembayaran::count();
        $pesanan = ModelPesanan::count();
        $keranjang = ModelKeranjang::count();
        $datapesanan = ModelPesanan::all();
        $datapengiriman = ModelPengiriman::all();
        $datapembayaran = ModelPembayaran::all();
        return view('admin.dashboard', [
            'totalproduk' => $produk,
            'totalCust' => $customer,
            'datapesanan' => $datapesanan,
            'datapengiriman' => $datapengiriman,
            'datapembayaran' => $datapembayaran,
            'totalPengiriman' => $pengiriman,
            'totalPembayaran' => $pembayaran,
            'totalPesanan' => $pesanan,
            'totalKeranjang' => $keranjang,
        ]);
    }
    public function login()
    {
        return view('loginadmin');
    }
    public function loginSubmit(Request $request)
    {
        // Logic for admin login submission can be added here
        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        // Logic for admin logout can be added here
        return redirect()->route('home');
    }

    // Kelola Data Kategori
    public function kategori()
    {
        $kategori = ModelKategori::all();
        return view('admin.kategori', compact('kategori'));
    }
    public function simpanKategori(Request $request)
    {
        $request->validate([
            'kategori_nama' => 'required|string|max:255',
            'kategori_deskripsi' => 'nullable|string|max:500',
            'kategori_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori_status' => 'required|integer',
        ]);

        $gambarPath = null;

        if ($request->hasFile('kategori_gambar')) {
            $gambar = $request->file('kategori_gambar');
            $namaFile = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('images/kategori'), $namaFile);
            $gambarPath = 'images/kategori/' . $namaFile;
        }

        ModelKategori::create([
            'kategori_nama' => $request->kategori_nama,
            'kategori_deskripsi' => $request->kategori_deskripsi,
            'kategori_gambar' => $gambarPath,
            'kategori_status' => $request->kategori_status ? 1 : 0,
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }
    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'kategori_nama' => 'required|string|max:255',
            'kategori_deskripsi' => 'nullable|string|max:500',
            'kategori_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori_status' => 'required|integer',
        ]);

        $kategori = ModelKategori::findOrFail($id);
        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->kategori_deskripsi = $request->kategori_deskripsi;
        // Kalau ada gambar baru, simpan
        if ($request->hasFile('kategori_gambar')) {
            // hapus gambar lama kalau ada
            if ($kategori->kategori_gambar && file_exists(public_path($kategori->kategori_gambar))) {
                unlink(public_path($kategori->kategori_gambar));
            }

            // simpan gambar baru di public/images/kategori
            $gambar = $request->file('kategori_gambar');
            $namaFile = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('images/kategori'), $namaFile);
            $kategori->kategori_gambar = 'images/kategori/' . $namaFile;
        }
        $kategori->kategori_status = $request->kategori_status ? 1 : 0;
        $kategori->save();

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui.');
    }
    public function hapusKategori($id)
    {
        $kategori = ModelKategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
