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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



use Illuminate\Http\Request;

class AdministratorKontrol extends Controller
{
    //
    public function login()
    {
        return view('loginadmin');
    }
    public function loginSubmit(Request $request)
    {

        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = ModelAdmin::where('admin_email', $request->email)->first();

        // Email tidak ditemukan
        if (!$admin) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Password salah
        if (!Hash::check($request->password, $admin->admin_password)) {
            return back()
                ->withInput()
                ->withErrors(['password' => 'Password salah.']);
        }


        // Login sukses
        session([
            'admin_id'   => $admin->admin_id,
            'admin_nama' => $admin->admin_nama,
            'admin_email' => $admin->admin_email,
        ]);
        return redirect()->route('dashboard');
    }
    public function index()
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $produk = ModelProduk::count();
        $customer = ModelCustomer::count();
        $pengiriman = ModelPengiriman::count();
        $pembayaran = ModelPembayaran::count();
        $pesanan = ModelPesanan::count();
        $keranjang = ModelKeranjang::count();
        $datapesanan = ModelPesanan::all();
        $totaltrx = ModelLaporanPenjualan::sum('laporan_total_pendapatan');
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
            'totaltrx' => $totaltrx,
            'totalKeranjang' => $keranjang,
        ]);
    }


    // Kelola Data Kategori
    public function kategori()
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $kategori = ModelKategori::all();
        return view('admin.kategori', compact('kategori'));
    }
    public function simpanKategori(Request $request)
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $request->validate([
            'kategori_nama' => 'required|string|max:255',
            'kategori_deskripsi' => 'nullable|string',
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
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $request->validate([
            'kategori_nama' => 'required|string|max:255',
            'kategori_deskripsi' => 'nullable|string',
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
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $kategori = ModelKategori::findOrFail($id);

        // Hapus file gambar kalau ada
        if ($kategori->kategori_gambar && file_exists(public_path($kategori->kategori_gambar))) {
            unlink(public_path($kategori->kategori_gambar));
        }

        // Hapus data dari database
        $kategori->delete();

        return redirect()->back()->with('success', 'Data kategori berhasil dihapus beserta gambarnya.');
    }

    //Akhir Kelola Data Kategori

    // Kelola Data Produk
    public function produk()
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $produk = ModelProduk::join('lixiudiy_kategori', 'lixiudiy_produk.produk_kategori', '=', 'lixiudiy_kategori.kategori_id')
            ->select('lixiudiy_produk.*', 'lixiudiy_kategori.kategori_nama')
            ->get();
        $kategori = ModelKategori::all();
        return view('admin.produk', compact('produk', 'kategori'));
    }
    public function simpanProduk(Request $request)
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $request->validate([
            'produk_nama' => 'required|string|max:255',
            'produk_deskripsi' => 'nullable|string',
            'produk_harga' => 'required|numeric',
            'produk_tanggalmasuk' => 'nullable|date',
            'produk_stok' => 'required|integer',
            'produk_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'produk_kategori' => 'required',
            'produk_status' => 'required|integer',
        ]);
        $produktanggalmasuk = $request->produk_tanggalmasuk ? date('Y-m-d', strtotime($request->produk_tanggalmasuk)) : null;

        $gambarPath = null;

        if ($request->hasFile('produk_gambar')) {
            $gambar = $request->file('produk_gambar');
            $namaFile = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('images/produk'), $namaFile);
            $gambarPath = 'images/produk/' . $namaFile;
        }

        ModelProduk::create([
            'produk_nama' => $request->produk_nama,
            'produk_deskripsi' => $request->produk_deskripsi,
            'produk_harga' => $request->produk_harga,
            'produk_tanggalmasuk' => $produktanggalmasuk,
            'produk_stok' => $request->produk_stok,
            'produk_gambar' => $gambarPath,
            'produk_kategori' => $request->produk_kategori,
            'produk_status' => $request->produk_status ? 1 : 0,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan.');
    }
    public function updateProduk(Request $request, $id)
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $request->validate([
            'produk_nama' => 'required|string|max:255',
            'produk_deskripsi' => 'nullable|string',
            'produk_harga' => 'required|numeric',
            'produk_tanggalmasuk' => 'nullable|date',
            'produk_stok' => 'required|integer',
            'produk_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'produk_kategori' => 'required',
            'produk_status' => 'required|integer',
        ]);
        $produktanggalmasuk = $request->produk_tanggalmasuk ? date('Y-m-d', strtotime($request->produk_tanggalmasuk)) : null;
        $produk = ModelProduk::findOrFail($id);
        $produk->produk_nama = $request->produk_nama;
        $produk->produk_deskripsi = $request->produk_deskripsi;
        $produk->produk_harga = $request->produk_harga;
        $produk->produk_tanggalmasuk = $produktanggalmasuk;
        $produk->produk_stok = $request->produk_stok;
        $produk->produk_kategori = $request->produk_kategori;
        $produk->produk_status = $request->produk_status ? 1 : 0;
        // Kalau ada gambar baru, simpan
        if ($request->hasFile('produk_gambar')) {
            // hapus gambar lama kalau ada
            if ($produk->produk_gambar && file_exists(public_path($produk->produk_gambar))) {
                unlink(public_path($produk->produk_gambar));
            }
            // simpan gambar baru di public/images/produk
            $gambar = $request->file('produk_gambar');
            $namaFile = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('images/produk'), $namaFile);
            $produk->produk_gambar = 'images/produk/' . $namaFile;
        }
        $produk->save();
        return redirect()->route('admin.produk')->with('success', 'Produk berhasil diperbarui.');
    }
    public function hapusProduk($id)
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $produk = ModelProduk::findOrFail($id);

        // Hapus file gambar kalau ada
        if ($produk->produk_gambar && file_exists(public_path($produk->produk_gambar))) {
            unlink(public_path($produk->produk_gambar));
        }

        // Hapus data dari database
        $produk->delete();

        return redirect()->back()->with('success', 'Data produk berhasil dihapus beserta gambarnya.');
    }

    //Akhir Kelola Data Produk

    // Kelola Data Rekomendasi Produk
    public function rekomendasi()
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $rekomendasi = ModelRekomendasiProduk::join('lixiudiy_produk', 'lixiudiy_rekomendasi_produk.rekomendasi_produk', '=', 'lixiudiy_produk.produk_id')
            ->join('lixiudiy_kategori', 'lixiudiy_produk.produk_kategori', '=', 'lixiudiy_kategori.kategori_id')
            ->select('lixiudiy_rekomendasi_produk.*', 'lixiudiy_produk.produk_nama', 'lixiudiy_produk.produk_harga', 'lixiudiy_produk.produk_stok', 'lixiudiy_kategori.kategori_nama')
            ->get();
        $produk = ModelProduk::all();
        return view('admin.rekomendasi', compact('rekomendasi', 'produk'));
    }
    public function simpanRekomendasi(Request $request)
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $request->validate([
            'rekomendasi_nama' => 'required|string|max:255',
            'rekomendasi_tanggal' => 'nullable|date',
            'rekomendasi_produk' => 'required',
            'rekomendasi_status' => 'required|integer',
            'rekomendasi_keterangan' => 'nullable|string',
        ]);
        ModelRekomendasiProduk::create([
            'rekomendasi_nama' => $request->rekomendasi_nama,
            'rekomendasi_tanggal' => $request->rekomendasi_tanggal ? date('Y-m-d', strtotime($request->rekomendasi_tanggal)) : null,
            'rekomendasi_produk' => $request->rekomendasi_produk,
            'rekomendasi_status' => $request->rekomendasi_status ? 1 : 0,
            'rekomendasi_keterangan' => $request->rekomendasi_keterangan,
        ]);
        return redirect()->route('admin.rekomendasi')->with('success', 'Rekomendasi produk berhasil ditambahkan.');
    }
    public function updateRekomendasi(Request $request, $id)
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $request->validate([
            'rekomendasi_nama' => 'required|string|max:255',
            'rekomendasi_produk' => 'required',
            'rekomendasi_status' => 'required|integer',
        ]);
        $rekomendasi = ModelRekomendasiProduk::findOrFail($id);
        $rekomendasi->rekomendasi_nama = $request->rekomendasi_nama;
        $rekomendasi->rekomendasi_produk = $request->rekomendasi_produk;
        $rekomendasi->rekomendasi_status = $request->rekomendasi_status ? 1 : 0;
        $rekomendasi->save();
        return redirect()->route('admin.rekomendasi')->with('success', 'Rekomendasi produk berhasil diperbarui.');
    }
    public function hapusRekomendasi($id)
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $rekomendasi = ModelRekomendasiProduk::findOrFail($id);
        // Hapus data dari database
        $rekomendasi->delete();
        return redirect()->back()->with('success', 'Data rekomendasi produk berhasil dihapus.');
    }

    //Akhir Kelola Data Rekomendasi Produk

    // Kelola Data Customer
    public function customer()
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $customer = ModelCustomer::all();
        return view('admin.customer', compact('customer'));
    }
    //Akhir Kelola Data Customer

    // Kelola Data Pesanan
    public function pesanan()
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $pembayaran = DB::table('lixiudiy_pembayaran')
            ->select(
                'lixiudiy_pembayaran.*',
                DB::raw('(SELECT customer_nama 
                  FROM lixiudiy_customer 
                  JOIN lixiudiy_pesanan 
                    ON lixiudiy_customer.customer_id = lixiudiy_pesanan.pesanan_customer
                  WHERE FIND_IN_SET(lixiudiy_pesanan.pesanan_id, REPLACE(lixiudiy_pembayaran.pembayaran_pesanan,";",",")) 
                  LIMIT 1) as customer_nama')
            )
            ->orderBy('pembayaran_id', 'desc')
            ->get();

        foreach ($pembayaran as $p) {
            $ids = explode(';', trim($p->pembayaran_pesanan, ';'));
            $p->pesanan = DB::table('lixiudiy_pesanan')
                ->join('lixiudiy_produk', 'lixiudiy_pesanan.pesanan_produk', '=', 'lixiudiy_produk.produk_id')
                ->whereIn('pesanan_id', $ids)
                ->select(
                    'lixiudiy_produk.produk_nama',
                    'lixiudiy_produk.produk_harga',
                    'lixiudiy_pesanan.pesanan_jumlah',
                    DB::raw('(lixiudiy_produk.produk_harga * lixiudiy_pesanan.pesanan_jumlah) as total')
                )
                ->get();

            $p->total_bayar = $p->pesanan->sum('total');
        }

        return view('admin.pesanan', compact('pembayaran'));
    }
    public function verifikasi($id)
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $pembayaran = ModelPembayaran::find($id);
        $pembayaran->pembayaran_status = 1;
        $pembayaran->save();
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }
    //Akhir Kelola Data Pesanan

    // Kelola Data Pengiriman
    public function pengiriman()
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $pengiriman = ModelPengiriman::all()->map(function ($p) {
            // Ambil array pesanan dari pengiriman_pesanan
            $pesananIds = explode(';', $p->pengiriman_pesanan);

            // Ambil data pesanan
            $pesanan = ModelPesanan::whereIn('pesanan_id', $pesananIds)
                ->leftJoin('lixiudiy_produk', 'lixiudiy_pesanan.pesanan_produk', '=', 'lixiudiy_produk.produk_id')
                ->select('lixiudiy_pesanan.*', 'lixiudiy_produk.produk_nama')
                ->get();

            // Ambil pembayaran yang terkait dengan pesanan ini
            $pembayaran = ModelPembayaran::all()->mapWithKeys(function ($bayar) {
                $ids = explode(';', $bayar->pembayaran_pesanan);
                return [$bayar->pembayaran_id => $ids];
            });

            // Tambahkan info pembayaran ke setiap pesanan
            $pesanan->transform(function ($item) use ($pembayaran) {
                foreach ($pembayaran as $pembayaran_id => $pesanan_ids) {
                    if (in_array($item->pesanan_id, $pesanan_ids)) {
                        $item->pembayaran_id = $pembayaran_id;
                        $item->pembayaran_status = ModelPembayaran::find($pembayaran_id)->pembayaran_status;
                        break; // stop di pembayaran pertama yang ketemu
                    }
                }
                return $item;
            });

            // Assign pesanan ke pengiriman
            $p->pesanan = $pesanan;

            // Jika semua pesanan sudah diverifikasi bayar
            $p->status_bayar = $pesanan->every(fn($x) => $x->pembayaran_status == 1);

            return $p;
        });

        return view('admin.pengiriman', compact('pengiriman'));
    }
    public function pengirimanResi(Request $request, $id)
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('home.page')
                ->with('error', 'Hanya Untuk Admin');
        }
        $request->validate([
            'resi' => 'required|string|max:255',
        ]);

        $request->validate([
            'resi' => 'required|string|max:255',
        ]);

        $pengiriman = ModelPengiriman::findOrFail($id);
        $pengiriman->pengiriman_nomor_resi = $request->resi;
        $pengiriman->pengiriman_status = 1;
        $pengiriman->save();

        return redirect()->back()->with('success', 'Nomor resi berhasil diperbarui!');
    }
}
