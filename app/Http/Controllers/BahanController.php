<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BahanMasuk;
use App\Models\StokBahanKain;
use App\Models\MasterSupplier;
use App\Models\MasterWarna;

class BahanController extends Controller
{
    public function index()
    {
        // Kita butuh 3 data untuk tampilan:
        // 1. Stok Saat Ini (Group by Warna)
        // 2. Riwayat Transaksi Masuk (Log)
        // 3. Data Master untuk Dropdown Form (Supplier & Warna)
        
        $stok       = StokBahanKain::with('warna')->get(); 
        $riwayat    = BahanMasuk::with(['supplier', 'warna'])->latest()->limit(50)->get();
        $suppliers  = MasterSupplier::all();
        $warnas     = MasterWarna::orderBy('nama_warna')->get();

        return view('bahan.index', compact('stok', 'riwayat', 'suppliers', 'warnas'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'supplier_id'   => 'required|exists:master_supplier,id',
            'warna_id'      => 'required|exists:master_warna,id',
            'jumlah'        => 'required|integer|min:1',
            'tanggal'       => 'required|date',
            'no_nota'       => 'nullable|string|max:50',
        ]);

        // 2. Eksekusi Database (Pakai Transaction biar aman)
        DB::transaction(function () use ($request) {
            
            // A. Catat Riwayat Transaksi (Log)
            BahanMasuk::create([
                'supplier_id'           => $request->supplier_id,
                'warna_id'              => $request->warna_id,
                'jumlah_gulungan_masuk' => $request->jumlah,
                'tanggal_masuk'         => $request->tanggal,
                'no_nota_supplier'      => $request->no_nota,
            ]);

            // B. Update/Tambah Stok (Inventory)
            // Cek apakah stok warna ini sudah ada? Kalau ada update, kalau belum buat baru.
            $stok = StokBahanKain::firstOrNew(['warna_id' => $request->warna_id]);
            $stok->jumlah_gulungan = ($stok->jumlah_gulungan ?? 0) + $request->jumlah;
            $stok->save();
            
        });

        return redirect()->back()->with('success', 'Stok Kain berhasil ditambahkan!');
    }
}
