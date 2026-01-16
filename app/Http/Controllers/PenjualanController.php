<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\TransaksiReseller;
use App\Models\StokGudangJadi;
use App\Models\MasterReseller;

class PenjualanController extends Controller
{
    public function index()
    {
        // 1. Data Reseller
        $resellers = MasterReseller::all();

        // 2. Stok Siap Jual
        $stok_ready = StokGudangJadi::with(['produk', 'warna'])
                        ->where('jumlah_stok', '>', 0)
                        ->get();

        // 3. Riwayat Distribusi (Tanpa Uang)
        $riwayat = TransaksiReseller::with(['reseller', 'produk', 'warna'])
                    ->latest()
                    ->paginate(20);

        return view('penjualan.index', compact('resellers', 'stok_ready', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reseller_id' => 'required|exists:master_reseller,id',
            'produk_id'   => 'required',
            'warna_id'    => 'required',
            'jumlah'      => 'required|integer|min:1',
            'tanggal'     => 'required|date',
            // 'harga' => 'required' <-- KITA HAPUS INI
        ]);

        // 1. Cek Stok Gudang Jadi
        $stok = StokGudangJadi::where('produk_id', $request->produk_id)
                              ->where('warna_id', $request->warna_id)
                              ->first();

        if (!$stok || $stok->jumlah_stok < $request->jumlah) {
            return back()->with('error', 'Stok Barang Jadi tidak cukup! Sisa: ' . ($stok->jumlah_stok ?? 0));
        }

        DB::transaction(function () use ($request, $stok) {
            // 2. Buat Invoice Distribusi
            $no_inv = 'DO-' . date('dm') . '-' . strtoupper(Str::random(4)); // Ganti INV jadi DO (Delivery Order)
            
            TransaksiReseller::create([
                'no_invoice'    => $no_inv,
                'reseller_id'   => $request->reseller_id,
                'produk_id'     => $request->produk_id,
                'warna_id'      => $request->warna_id,
                'jumlah_keluar' => $request->jumlah,
                
                // MATA UANG KITA MATIKAN
                'harga_satuan'  => 0, 
                'total_harga'   => 0, 
                
                'tanggal_transaksi' => $request->tanggal,
            ]);

            // 3. Kurangi Stok Gudang Jadi
            $stok->decrement('jumlah_stok', $request->jumlah);
        });

        return back()->with('success', 'Distribusi barang berhasil dicatat.');
    }
}