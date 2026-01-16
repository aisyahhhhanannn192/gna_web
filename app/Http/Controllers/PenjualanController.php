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
        $resellers = MasterReseller::all();

        // Ambil stok yang ada isinya saja
        $stok_ready = StokGudangJadi::with(['produk', 'warna'])
                        ->where('jumlah_stok', '>', 0)
                        ->get();

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
            // GANTI INPUT JUMLAH JADI DUA OPSI
            'jumlah_kodi' => 'nullable|integer|min:0',
            'jumlah_pcs'  => 'nullable|integer|min:0',
            'tanggal'     => 'required|date',
        ]);

        // 1. RUMUS KONVERSI (KODI -> PCS)
        $kodi = $request->jumlah_kodi ?? 0;
        $pcs  = $request->jumlah_pcs ?? 0;
        $total_keluar_pcs = ($kodi * 20) + $pcs;

        if ($total_keluar_pcs <= 0) {
            return back()->with('error', 'Jumlah barang dikirim tidak boleh kosong!');
        }

        // 2. Cek Stok Gudang Jadi
        $stok = StokGudangJadi::where('produk_id', $request->produk_id)
                              ->where('warna_id', $request->warna_id)
                              ->first();

        if (!$stok || $stok->jumlah_stok < $total_keluar_pcs) {
            return back()->with('error', 'Stok Gudang Jadi tidak cukup! Sisa: ' . ($stok->jumlah_stok ?? 0));
        }

        DB::transaction(function () use ($request, $stok, $total_keluar_pcs) {
            // Buat Invoice / Delivery Order
            $no_inv = 'DO-' . date('dm') . '-' . strtoupper(Str::random(4));
            
            TransaksiReseller::create([
                'no_invoice'    => $no_inv,
                'reseller_id'   => $request->reseller_id,
                'produk_id'     => $request->produk_id,
                'warna_id'      => $request->warna_id,
                'jumlah_keluar' => $total_keluar_pcs, // Simpan TOTAL PCS
                'harga_satuan'  => 0, 
                'total_harga'   => 0, 
                'tanggal_transaksi' => $request->tanggal,
            ]);

            // Kurangi Stok Gudang Jadi
            $stok->decrement('jumlah_stok', $total_keluar_pcs);
        });

        // Pesan Sukses Lebih Detail
        return back()->with('success', "Distribusi dicatat: $kodi Kodi $pcs Pcs dikirim ke Reseller.");
    }
}