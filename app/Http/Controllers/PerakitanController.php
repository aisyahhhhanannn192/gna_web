<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// Import semua model yang terlibat
use App\Models\DistribusiKorlap;
use App\Models\StokCek;
use App\Models\MasterKorlap;
use App\Models\SetorKorlap;     // <--- Wajib ada
use App\Models\StokGudangJadi;  // <--- Wajib ada (Pastikan Model ini juga sudah dibuat)

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
        $riwayat = DistribusiKorlap::with(['korlap', 'produk', 'warna'])
                    ->latest()
                    ->paginate(20);

        return view('produksi.perakitan.index', compact('korlaps', 'stok_ready', 'riwayat'));
    }

    // Fungsi 1: Buat Nota Jahit (Barang Keluar ke Korlap)
    public function store(Request $request)
    {
        $request->validate([
            'korlap_id' => 'required|exists:master_korlap,id',
            'produk_id' => 'required',
            'warna_id'  => 'required',
            'jumlah'    => 'required|integer|min:1',
            'tanggal'   => 'required|date',
        ]);

        // Cek Stok Cek dengan composite key
        $stok = StokCek::where('produk_id', $request->produk_id)
                       ->where('warna_id', $request->warna_id)
                       ->first();

        if (!$stok || $stok->jumlah_stok < $request->jumlah) {
            return back()->with('error', 'Stok Cek tidak cukup! Sisa: ' . ($stok->jumlah_stok ?? 0));
        }

        DB::transaction(function () use ($request, $stok) {
            $no_nota = 'NJ-' . date('dm') . '-' . strtoupper(Str::random(3));

            DistribusiKorlap::create([
                'no_nota'       => $no_nota,
                'korlap_id'     => $request->korlap_id,
                'produk_id'     => $request->produk_id,
                'warna_id'      => $request->warna_id,
                'jumlah_cek_keluar' => $request->jumlah,
                'tanggal_distribusi'=> $request->tanggal,
                'status'        => 'sedang_dikerjakan'
            ]);

            // Update stok menggunakan query yang explicit untuk composite key
            StokCek::where('produk_id', $stok->produk_id)
                   ->where('warna_id', $stok->warna_id)
                   ->decrement('jumlah_stok', $request->jumlah);
        });

        return back()->with('success', 'Pekerjaan berhasil diserahkan ke Korlap.');
    }

    // Fungsi 2: Terima Setoran / QC (Barang Jadi Masuk)
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
            // 1. Ambil Info Nota Asli
            $nota = DistribusiKorlap::findOrFail($request->distribusi_id);

            // 2. Simpan Log Setoran QC
            SetorKorlap::create([
                'distribusi_korlap_id' => $nota->id,
                'korlap_id'            => $nota->korlap_id,
                'jumlah_pcs_jadi'      => $request->jumlah_jadi,
                'jumlah_afkir'         => $request->jumlah_afkir,
                'jumlah_pending'       => $request->jumlah_pending,
                'catatan'              => $request->catatan,
                'tanggal_setor'        => $request->tanggal,
            ]);

            // 3. Tambah Stok Gudang Jadi (Hanya yang lolos QC)
            if ($request->jumlah_jadi > 0) {
                // Cari stok existing, atau buat baru jika belum ada
                $stokJadi = StokGudangJadi::firstOrNew([
                    'produk_id' => $nota->produk_id,
                    'warna_id'  => $nota->warna_id
                ]);
                $stokJadi->jumlah_stok = ($stokJadi->jumlah_stok ?? 0) + $request->jumlah_jadi;
                $stokJadi->save();
            }

            // 4. Update Status Nota
            // Jika Pending = 0, berarti lunas/selesai.
            // Jika Pending > 0, status tetap 'sedang_dikerjakan' agar tombol 'Terima Jahitan' masih muncul besok.
            if ($request->jumlah_pending == 0) {
                $nota->update(['status' => 'selesai']);
            } 
        });

        return back()->with('success', 'Setoran Korlap diterima. Stok Gudang Jadi bertambah.');
    }
}