<?php

namespace App\Http\Controllers;

use App\Models\ModelProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
use App\Models\ModelLaporanPenjualan;
use App\Models\ModelRekomendasiProduk;
use App\Models\ModelAktivasiAkun;
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

            return redirect()->route('login')
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
}
