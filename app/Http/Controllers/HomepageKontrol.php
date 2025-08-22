<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageKontrol extends Controller
{
    //
    public function index()
    {
        return view('homepage');
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
        return view('daftarproduk');
    }
    public function detailProduk()
    {
        return view('detailproduk');
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
