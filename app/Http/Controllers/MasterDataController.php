<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Panggil semua Model yang mau ditampilkan
use App\Models\MasterKorlap;
use App\Models\MasterReseller;
use App\Models\MasterSupplier;
use App\Models\MasterPemotong;
use App\Models\MasterProduk;
use App\Models\MasterWarna;

class MasterDataController extends Controller
{
    public function index()
    {
        // Peringatan Data Science: 
        // Menggunakan all() berbahaya jika data > 1000 baris (memori bengkak).
        // Tapi untuk tahap awal/sederhana, ini valid. Nanti ganti pagination jika lemot.
        
        $data = [
            'korlaps'   => \App\Models\MasterKorlap::latest()->get(),
            'resellers' => \App\Models\MasterReseller::latest()->get(),
            'suppliers' => \App\Models\MasterSupplier::latest()->get(),
            'pemotongs' => \App\Models\MasterPemotong::latest()->get(),
            'produks'   => \App\Models\MasterProduk::latest()->get(),
            'warnas'    => \App\Models\MasterWarna::orderBy('nama_warna')->get(),
            'karyawans' => \App\Models\MasterKaryawan::latest()->get(),
        ];

        return view('master.index', $data);
    }

    // ... pastikan import MasterKorlap sudah ada

    public function storeKorlap(Request $request)
    {
        // 1. Validasi Input (Data Science Rule: Garbage In, Garbage Out)
        $request->validate([
            'nama_korlap' => 'required|string|max:255',
            'no_hp'       => 'nullable|string|max:20',
            'alamat'      => 'nullable|string',
        ]);

        // 2. Simpan ke Database
        MasterKorlap::create([
            'nama_korlap' => $request->nama_korlap,
            'no_hp'       => $request->no_hp,
            'alamat'      => $request->alamat,
        ]);

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data Korlap berhasil ditambahkan!');
    }

    public function storeProduk(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            // Kode wajib unik di tabel master_produk
            'kode_produk' => 'required|string|max:10|unique:master_produk,kode_produk', 
            'estimasi_pcs_per_gulung' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        // 2. Simpan
        \App\Models\MasterProduk::create([
            'nama_produk' => $request->nama_produk,
            'kode_produk' => strtoupper($request->kode_produk), // Paksa jadi HURUF BESAR
            'estimasi_pcs_per_gulung' => $request->estimasi_pcs_per_gulung,
            // Di tabel migrasi kita tidak buat kolom deskripsi, tapi di form ada. 
            // Jika mau simpan deskripsi, pastikan migrasi master_produk punya kolom 'deskripsi'
            // Jika tidak, abaikan field ini atau tambahkan migrasi baru.
            // Untuk sekarang, kita asumsikan simpan yang inti saja:
        ]);

        return redirect()->back()->with('success', 'Jenis Produk berhasil ditambahkan!');
    }

    // --- MASTER WARNA ---
    public function storeWarna(Request $request)
    {
        $request->validate(['nama_warna' => 'required|string|max:50']);

        \App\Models\MasterWarna::create([
            'nama_warna' => $request->nama_warna,
            'kode_warna' => $request->kode_warna, // Opsional (Hex code)
        ]);

        return redirect()->back()->with('success', 'Data Warna berhasil ditambahkan!');
    }

    // --- MASTER SUPPLIER ---
    public function storeSupplier(Request $request)
    {
        $request->validate(['nama_supplier' => 'required|string|max:255']);

        \App\Models\MasterSupplier::create([
            'nama_supplier' => $request->nama_supplier,
            'kontak'        => $request->kontak,
        ]);

        return redirect()->back()->with('success', 'Supplier berhasil ditambahkan!');
    }

    // --- MASTER PEMOTONG ---
    public function storePemotong(Request $request)
    {
        $request->validate(['nama_pemotong' => 'required|string|max:255']);

        \App\Models\MasterPemotong::create([
            'nama_pemotong' => $request->nama_pemotong,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Mitra Pemotong berhasil ditambahkan!');
    }

    // --- MASTER RESELLER ---
    public function storeReseller(Request $request)
    {
        $request->validate(['nama_reseller' => 'required|string|max:255']);

        \App\Models\MasterReseller::create([
            'nama_reseller' => $request->nama_reseller,
            'no_hp'         => $request->no_hp,
            'area_wilayah'  => $request->area_wilayah,
        ]);

        return redirect()->back()->with('success', 'Reseller berhasil ditambahkan!');
    }
    
    public function storeKaryawan(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'posisi'        => 'required|string',
        ]);

        \App\Models\MasterKaryawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'posisi'        => $request->posisi,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Data Karyawan berhasil ditambahkan!');
    }

}
