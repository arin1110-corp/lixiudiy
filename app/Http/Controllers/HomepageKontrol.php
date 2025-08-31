<?php

namespace App\Http\Controllers;

use App\Models\ModelProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\ModelAdmin;
use App\Models\ModelKategori;
use App\Models\ModelCustomer;
use App\Models\ModelPengiriman;
use App\Models\ModelPembayaran;
use App\Models\ModelPesanan;
use App\Models\ModelKeranjang;
use App\Models\ModelKurir;
use App\Models\ModelLaporanPenjualan;
use App\Models\ModelRekomendasiProduk;
use App\Models\ModelAktivasiAkun;
use Illuminate\Database\Eloquent\Model;
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
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }
        $keranjang = ModelKeranjang::where('keranjang_customer', $customerId)
            ->where('keranjang_status', 0) // hanya yang belum checkout
            ->join('lixiudiy_produk', 'lixiudiy_keranjang.keranjang_produk', '=', 'lixiudiy_produk.produk_id')
            ->join('lixiudiy_kategori', 'lixiudiy_produk.produk_kategori', '=', 'lixiudiy_kategori.kategori_id')
            ->select('lixiudiy_keranjang.*', 'lixiudiy_produk.produk_nama', 'lixiudiy_kategori.*', 'lixiudiy_produk.produk_harga', 'lixiudiy_produk.produk_gambar')
            ->get();
        $rinciantotalharga = ModelKeranjang::where('keranjang_customer', $customerId)
            ->selectRaw('SUM(keranjang_total_harga) as total_harga, sum(keranjang_jumlah) as total_produk')
            ->first();
        $totalHarga = $keranjang->sum('keranjang_total_harga');
        return view('keranjang', compact('keranjang', 'totalHarga', 'rinciantotalharga'));
    }
    public function tambahkeranjang(Request $request)
    {
        if (!session('customer_id')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk menambahkan ke keranjang.');
        }

        $request->validate([
            'produk_id' => 'required|exists:lixiudiy_produk,produk_id',
            'jumlah'    => 'required|integer|min:1',
        ]);

        $customerId = session('customer_id');

        // Cek apakah produk sudah ada di keranjang
        $keranjang = ModelKeranjang::where('keranjang_customer', $customerId)
            ->where('keranjang_produk', $request->produk_id)
            ->first();
        $totalHarga = ModelProduk::where('produk_id', $request->produk_id)->value('produk_harga');
        $totalhargahitung = $totalHarga * $request->jumlah;
        // Update total harga di keranjang

        if ($keranjang) {
            // Jika sudah ada, update jumlahnya
            $keranjang->keranjang_jumlah += $request->jumlah;
            $keranjang->keranjang_total_harga += $totalhargahitung;
            $keranjang->save();
        } else {
            // Jika belum ada, buat entri baru
            ModelKeranjang::create([
                'keranjang_customer' => $customerId,
                'keranjang_produk'   => $request->produk_id,
                'keranjang_jumlah'   => $request->jumlah,
                'keranjang_total_harga' => $totalhargahitung,
                'keranjang_tanggal'  => Carbon::now()->format('Y-m-d H:i:s'),
                'keranjang_status'   => 0, // 0=belum checkout, 1=sudah checkout
            ]);
        }

        return redirect()->route('keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }
    public function updateKeranjang(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $keranjang = ModelKeranjang::findOrFail($id);
        if (!$keranjang) {
            return redirect()->route('keranjang')->with('error', 'Item keranjang tidak ditemukan.');
        }
        $produk = ModelProduk::find($keranjang->keranjang_produk);

        // Cek stok
        if ($request->jumlah > $produk->produk_stok) {
            return back()->with(
                'error',
                'Jumlah Produk ' . $produk->produk_nama . 'melebihi stok yang tersedia. Maksimal ' . $produk->produk_stok
            );
        }

        $produkHarga = ModelProduk::where('produk_id', $keranjang->keranjang_produk)->value('produk_harga');
        $keranjang->keranjang_jumlah = $request->jumlah;
        $keranjang->keranjang_total_harga = $produkHarga * $request->jumlah;
        $keranjang->save();

        return redirect()->route('keranjang')->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function hapusKeranjang($id)
    {
        $keranjang = ModelKeranjang::findOrFail($id);
        if (!$keranjang) {
            return redirect()->route('keranjang')->with('error', 'Item keranjang tidak ditemukan.');
        }

        $keranjang->delete();

        return redirect()->route('keranjang')->with('success', 'Item keranjang berhasil dihapus.');
    }
    public function checkout()
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk checkout.');
        }

        // Ambil keranjang aktif user
        $keranjang = ModelKeranjang::where('keranjang_customer', $customerId)
            ->where('keranjang_status', 0)
            ->get();

        if ($keranjang->isEmpty()) {
            // Kalau keranjang kosong, langsung arahkan ke pesanan
            return redirect()->route('pesanan')
                ->with('info', 'Keranjang kosong. Silakan cek pesanan Anda.');
        }

        // Simpan tiap item keranjang jadi pesanan
        foreach ($keranjang as $item) {
            ModelPesanan::create([
                'pesanan_produk'      => $item->keranjang_produk,
                'pesanan_customer'    => $item->keranjang_customer,
                'pesanan_keranjang'   => $item->keranjang_id,
                'pesanan_tanggal'     => now(),
                'pesanan_jumlah'      => $item->keranjang_jumlah,
                'pesanan_total_harga' => $item->keranjang_total_harga,
                'pesanan_status'      => 0,
            ]);

            // update keranjang jadi status 1
            $item->update(['keranjang_status' => 1]);
        }

        return redirect()->route('pesanan')
            ->with('success', 'Checkout berhasil. Pesanan sudah dibuat.');
    }
    public function pemesanan()
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat pesanan.');
        }

        $pesanan = ModelPesanan::where('pesanan_customer', $customerId)
            ->join('lixiudiy_customer', 'lixiudiy_pesanan.pesanan_customer', '=', 'lixiudiy_customer.customer_id')
            ->join('lixiudiy_produk', 'lixiudiy_pesanan.pesanan_produk', '=', 'lixiudiy_produk.produk_id')
            ->where('lixiudiy_pesanan.pesanan_status', '0')
            ->select('lixiudiy_pesanan.*', 'lixiudiy_produk.*', 'lixiudiy_produk.produk_gambar')
            ->orderBy('pesanan_tanggal', 'desc')
            ->get();
        $datacustomer = ModelCustomer::where('customer_id', $customerId)->first();


        return view('pemesanan', compact('pesanan', 'datacustomer'));
    }
    public function pembayaran()
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat pesanan.');
        }

        $kurir = ModelKurir::all();
        $pesanan = ModelPesanan::where('pesanan_customer', $customerId)
            ->join('lixiudiy_customer', 'lixiudiy_pesanan.pesanan_customer', '=', 'lixiudiy_customer.customer_id')
            ->join('lixiudiy_produk', 'lixiudiy_pesanan.pesanan_produk', '=', 'lixiudiy_produk.produk_id')
            ->where('lixiudiy_pesanan.pesanan_status', '0')
            ->select('lixiudiy_pesanan.*', 'lixiudiy_produk.*', 'lixiudiy_produk.produk_gambar')
            ->orderBy('pesanan_tanggal', 'desc')
            ->get();

        return view('pembayaran', compact('kurir', 'pesanan'));
    }
    public function konfirmasiPembayaran(Request $request)
    {
        $request->validate([
            'pesanan_id' => 'required',
            'pembayaran_jumlah' => 'required|numeric',
            'pembayaran_metode' => 'required|string',
            'kurir' => 'required'
        ]);

        ModelPembayaran::create([
            'pembayaran_pesanan' => $request->pesanan_id,
            'pembayaran_jumlah' => $request->pembayaran_jumlah,
            'pembayaran_tanggal' => now(),
            'pembayaran_metode' => $request->pembayaran_metode,
            'pembayaran_status' => '0',
            'pembayaran_keterangan' => $request->kurir
        ]);

        $pesananid = explode(';', $request->pesanan_id);
        // update status pesanan jadi "dibayar"
        ModelPesanan::whereIn('pesanan_id', $pesananid)
            ->update(['pesanan_status' => '1']);

        return redirect()->route('akun.customer')->with('success', 'Pembayaran berhasil dicatat!');
    }

    public function akunSaya(Request $request)
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        $customer = ModelCustomer::find($customerId);

        $pembayaran = ModelPembayaran::whereIn('pembayaran_id', function ($q) use ($customerId) {
            $q->select('pembayaran_id')
                ->from('lixiudiy_pembayaran')
                ->join('lixiudiy_kurir', 'lixiudiy_pembayaran.pembayaran_keterangan', '=', 'lixiudiy_kurir.kurir_id')
                ->join('lixiudiy_pesanan', 'lixiudiy_pesanan.pesanan_id', '=', DB::raw("SUBSTRING_INDEX(lixiudiy_pembayaran.pembayaran_pesanan, ';', 1)")) // trik ambil id pertama
                ->where('pesanan_customer', $customerId);
        })->get();

        $pesanan = collect();
        $kurir = ModelKurir::join('lixiudiy_pembayaran', 'lixiudiy_kurir.kurir_id', '=', 'lixiudiy_pembayaran.pembayaran_keterangan')
            ->join('lixiudiy_pesanan', 'lixiudiy_pesanan.pesanan_id', '=', DB::raw("SUBSTRING_INDEX(lixiudiy_pembayaran.pembayaran_pesanan, ';', 1)")) // trik ambil id pertama
            ->where('pesanan_customer', $customerId)
            ->first();

        foreach ($pembayaran as $pay) {
            // Pecah semua pesanan_id dalam string "1;2;3"
            $ids = explode(';', $pay->pembayaran_pesanan);

            $items = DB::table('lixiudiy_pesanan')
                ->join('lixiudiy_produk', 'lixiudiy_pesanan.pesanan_produk', '=', 'lixiudiy_produk.produk_id')
                ->whereIn('lixiudiy_pesanan.pesanan_id', $ids)
                ->select('lixiudiy_pesanan.*', 'lixiudiy_produk.*')
                ->get();

            $pesanan[$pay->pembayaran_id] = [
                'pembayaran' => $pay,
                'items'      => $items,
            ];
        }

        $tab = $request->query('tab', 'profil');

        return view('akuncustomer', compact('customer', 'pesanan', 'tab', 'kurir'));
    }
    public function updateCustomer(Request $request)
    {
        $request->validate([
            'customer_nama'         => 'required|string|max:150',
            'customer_email'        => 'required|email:rfc,dns',
            'customer_telepon'      => 'required|string|max:30',
            'customer_alamat'       => 'required|string|max:255',
            'customer_tanggallahir' => 'required|date', // format Y-m-d dari <input type="date">
        ]);

        $customer = ModelCustomer::find(session('customer_id'));
        $customer->customer_nama = $request->customer_nama;
        $customer->customer_email = $request->customer_email;
        $customer->customer_telepon = $request->customer_telepon;
        $customer->customer_alamat = $request->customer_alamat;
        $customer->customer_tanggallahir = $request->customer_tanggallahir;
        $customer->save();

        return redirect()->route('akun.customer')->with('success', 'Profil berhasil diubah!');
    }
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('daftarakun');
    }
    public function registerSubmit(Request $request)
    {
        // NOTE soal konfirmasi password:
        // Jika input konfirmasi masih name="password_confirmation",
        // pakai rule 'same:customer_password' di bawah.
        // Kalau mau pakai 'confirmed', ubah input konfirmasi menjadi
        // name="customer_password_confirmation".
        $request->validate([
            'customer_nama'         => 'required|string|max:150',
            'customer_email'        => 'required|email:rfc,dns|unique:lixiudiy_customer,customer_email',
            'customer_telepon'      => 'required|string|max:30',
            'customer_alamat'       => 'required|string|max:255',
            'customer_tanggallahir' => 'required|date', // format Y-m-d dari <input type="date">
            'customer_password'     => 'required|string|min:6',
            'password_confirmation' => 'required|same:customer_password', // sinkron dengan name di form-mu
        ]);

        try {
            DB::beginTransaction();

            // Simpan customer
            $customer = ModelCustomer::create([
                'customer_nama'          => $request->customer_nama,
                'customer_email'         => $request->customer_email,
                'customer_telepon'       => $request->customer_telepon,
                'customer_alamat'        => $request->customer_alamat,
                'customer_tanggallahir'  => $request->customer_tanggallahir, // pastikan kolomnya DATE
                'customer_password'      => Hash::make($request->customer_password),
                'customer_status'        => 0,                              // belum aktif
                'customer_tanggaldaftar' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            // Generate & simpan kode aktivasi
            // Generate token aktivasi (5 huruf kapital + angka)
            $token = strtoupper(Str::random(5));
            $token = preg_replace('/[^A-Z0-9]/', '', $token); // biar cuma huruf besar & angka

            ModelAktivasiAkun::create([
                'aktivasi_customer' => $customer->customer_id,  // PK di tabel customer-mu
                'aktivasi_token'     => $token,
            ]);

            DB::commit();

            // (Opsional) kirim email dengan link aktivasi
            // $link = url('/aktivasi/'.$kode);
            // Mail::to($customer->customer_email)->send(new AktivasiMail($link));

            return redirect()->route('aktivasi.form')
                ->with('success', 'Registrasi berhasil. Cek email kamu untuk aktivasi akun.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['register' => 'Gagal daftar: ' . $e->getMessage()]);
        }
    }
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = ModelCustomer::where('customer_email', $request->email)->first();

        // Email tidak ditemukan
        if (!$customer) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Password salah
        if (!Hash::check($request->password, $customer->customer_password)) {
            return back()
                ->withInput()
                ->withErrors(['password' => 'Password salah.']);
        }

        // Belum aktivasi
        if ($customer->customer_status == 0) {
            return redirect()
                ->route('aktivasi.form')
                ->with('email', $customer->customer_email)
                ->withErrors(['aktivasi' => 'Akun belum aktif, silakan masukkan kode aktivasi.']);
        }

        // Login sukses
        session([
            'customer_id'   => $customer->customer_id,
            'customer_nama' => $customer->customer_nama,
            'customer_email' => $customer->customer_email,
        ]);

        return redirect()->route('home.page')->with('success', 'Login berhasil, selamat datang ' . $customer->customer_nama . '!');
    }
    public function aktivasiForm()
    {
        return view('aktivasiakun');
    }
    public function aktivasiAkunSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string|max:10',
        ]); // sesuaikan max dengan panjang token-mu
        $customer = ModelCustomer::where('customer_email', $request->email)->first();
        if (!$customer) {
            return back()->withInput()->withErrors(['email' => 'Email tidak ditemukan.']);
        }
        if ($customer->customer_status == 1) {
            return redirect()->route('login')->with('info', 'Akun sudah aktif, silakan login.');
        }
        $aktivasi = ModelAktivasiAkun::where('aktivasi_customer', $customer->customer_id)
            ->where('aktivasi_token', $request->token)
            ->first();
        if (!$aktivasi) {
            return back()->withInput()->withErrors(['token' => 'Token aktivasi salah.']);
        }
        // Aktivasi sukses
        $customer->customer_status = 1; // aktif
        $customer->save();
        // Hapus data aktivasi
        $aktivasi->delete();
        return redirect()->route('login')->with('success', 'Akun berhasil diaktivasi, silakan login.');
    }
    public function logout()
    {
        // Logic for customer logout can be added here
        return redirect()->route('home');
    }
    public function loginadmin()
    {
        return view('loginadmin');
    }
    public function loginadminSubmit(Request $request)
    {
        // Logic for admin login submission can be added here
        return redirect()->route('admin.dashboard');
    }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }
    }
}
