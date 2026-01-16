<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\DistribusiKorlap;
use App\Models\StokCek;
use App\Models\MasterKorlap;
use App\Models\SetorKorlap;
use App\Models\StokGudangJadi;

class PerakitanController extends Controller
{
    public function index()
    {
        $korlaps = MasterKorlap::all();
        
        // Ambil Stok Cek yang tersedia
        $stok_ready = StokCek::with(['produk', 'warna'])
                        ->where('jumlah_stok', '>', 0)
                        ->get();

        // Riwayat Distribusi
        $riwayat = DistribusiKorlap::with(['korlap', 'produk', 'warna', 'setoran']) // Pastikan load 'setoran'
                    ->latest()
                    ->paginate(20);

        return view('produksi.perakitan.index', compact('korlaps', 'stok_ready', 'riwayat'));
    }

    // --- PERUBAHAN DI SINI (LOGIKA KODI) ---
    public function store(Request $request)
    {
        $request->validate([
            'korlap_id'   => 'required|exists:master_korlap,id',
            'produk_id'   => 'required',
            'warna_id'    => 'required',
            // Kita ganti 'jumlah' tunggal menjadi dua input
            'jumlah_kodi' => 'nullable|integer|min:0',
            'jumlah_pcs'  => 'nullable|integer|min:0',
            'tanggal'     => 'required|date',
        ]);

        // 1. RUMUS KONVERSI KODI -> PCS
        $kodi = $request->jumlah_kodi ?? 0;
        $pcs  = $request->jumlah_pcs ?? 0;
        $total_target_pcs = ($kodi * 20) + $pcs;

        if ($total_target_pcs <= 0) {
            return back()->with('error', 'Jumlah barang tidak boleh kosong!');
        }

        // Cek Stok Cek
        $stok = StokCek::where('produk_id', $request->produk_id)
                       ->where('warna_id', $request->warna_id)
                       ->first();

        if (!$stok || $stok->jumlah_stok < $total_target_pcs) {
            return back()->with('error', 'Stok Cek tidak cukup! Sisa: ' . ($stok->jumlah_stok ?? 0));
        }

        DB::transaction(function () use ($request, $stok, $total_target_pcs) {
            $no_nota = 'NJ-' . date('dm') . '-' . strtoupper(Str::random(3));

            DistribusiKorlap::create([
                'no_nota'           => $no_nota,
                'korlap_id'         => $request->korlap_id,
                'produk_id'         => $request->produk_id,
                'warna_id'          => $request->warna_id,
                'jumlah_cek_keluar' => $total_target_pcs, // Simpan HASIL HITUNGAN (Pcs)
                'tanggal_distribusi'=> $request->tanggal,
                'status'            => 'sedang_dikerjakan'
            ]);

            // Kurangi stok
            StokCek::where('produk_id', $stok->produk_id)
                   ->where('warna_id', $stok->warna_id)
                   ->decrement('jumlah_stok', $total_target_pcs);
        });

        // Pesan sukses menampilkan detail Kodi
        return back()->with('success', "Diserahkan ke Korlap: $kodi Kodi + $pcs Pcs.");
    }

    // Fungsi QC (Tetap Pcs sesuai request)
    public function storeSetor(Request $request)
    {
        $request->validate([
            'distribusi_id' => 'required|exists:distribusi_korlap,id',
            'tanggal'       => 'required|date',
            'jumlah_jadi'   => 'required|integer|min:0',
            'jumlah_afkir'  => 'required|integer|min:0',
            'jumlah_pending'=> 'required|integer|min:0',
            'catatan'       => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $nota = DistribusiKorlap::findOrFail($request->distribusi_id);

            SetorKorlap::create([
                'distribusi_korlap_id' => $nota->id,
                'korlap_id'            => $nota->korlap_id,
                'jumlah_pcs_jadi'      => $request->jumlah_jadi,
                'jumlah_afkir'         => $request->jumlah_afkir,
                'jumlah_pending'       => $request->jumlah_pending,
                'catatan'              => $request->catatan,
                'tanggal_setor'        => $request->tanggal,
            ]);

            if ($request->jumlah_jadi > 0) {
                $stokJadi = StokGudangJadi::firstOrNew([
                    'produk_id' => $nota->produk_id,
                    'warna_id'  => $nota->warna_id
                ]);
                $stokJadi->jumlah_stok = ($stokJadi->jumlah_stok ?? 0) + $request->jumlah_jadi;
                $stokJadi->save();
            }

            if ($request->jumlah_pending == 0) {
                $nota->update(['status' => 'selesai']);
            } 
        });

        return back()->with('success', 'Setoran Korlap diterima.');
    }
}