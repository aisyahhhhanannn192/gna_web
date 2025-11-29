<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Untuk generate nomor surat
use App\Models\DistribusiPemotong;
use App\Models\StokBahanKain;
use App\Models\MasterPemotong;
use App\Models\MasterProduk;
use App\Models\MasterWarna;
use App\Models\SetorPemotong; 
use App\Models\StokCek;

class PemotonganController extends Controller
{
    public function index()
    {
        // Data untuk Dropdown Form
        $pemotongs = MasterPemotong::all();
        $produks   = MasterProduk::all(); // Target barang jadinya apa?
        
        // Kita hanya ambil stok yang > 0 agar dropdown tidak penuh sampah
        $stok_kain = StokBahanKain::with('warna')
                        ->where('jumlah_gulungan', '>', 0)
                        ->get();

        // Data Riwayat Surat Jalan (Surat Jalan yg belum 'selesai' harus dipantau)
        $riwayat = DistribusiPemotong::with(['pemotong', 'produk', 'warna'])
                    ->latest()
                    ->paginate(20);

        return view('produksi.pemotongan.index', compact('pemotongs', 'produks', 'stok_kain', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemotong_id' => 'required|exists:master_pemotong,id',
            'warna_id'    => 'required|exists:master_warna,id',
            'produk_id'   => 'required|exists:master_produk,id',
            'jumlah'      => 'required|integer|min:1',
            'tanggal'     => 'required|date',
        ]);

        // 1. CEK STOK DULU (Skeptisisme Sistem)
        $stok_gudang = StokBahanKain::where('warna_id', $request->warna_id)->first();

        if (!$stok_gudang || $stok_gudang->jumlah_gulungan < $request->jumlah) {
            return back()->with('error', 'Stok kain tidak cukup! Sisa stok: ' . ($stok_gudang->jumlah_gulungan ?? 0));
        }

        DB::transaction(function () use ($request, $stok_gudang) {
            // 2. Buat Surat Jalan
            // Format No: SJ-TGL-RANDOM (Contoh: SJ-2811-A1B)
            $no_surat = 'SJ-' . date('dm') . '-' . strtoupper(Str::random(3));

            DistribusiPemotong::create([
                'no_surat_jalan' => $no_surat,
                'pemotong_id'    => $request->pemotong_id,
                'produk_id'      => $request->produk_id, // Target Produk
                'warna_id'       => $request->warna_id,
                'jumlah_gulungan_keluar' => $request->jumlah,
                'tanggal_distribusi'     => $request->tanggal,
                'status'         => 'proses'
            ]);

            // 3. Kurangi Stok Gudang
            $stok_gudang->decrement('jumlah_gulungan', $request->jumlah);
        });

        return back()->with('success', 'Surat Jalan berhasil dibuat & Stok dikurangi.');
    }

    public function storeSetor(Request $request)
    {
        $request->validate([
            'distribusi_id' => 'required|exists:distribusi_pemotong,id',
            'jumlah_jadi'   => 'required|integer|min:1',
            'tanggal'       => 'required|date',
            'berat_limbah'  => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Ambil Data Surat Jalan Asli (Untuk tahu Produk & Warna apa)
            $distribusi = DistribusiPemotong::findOrFail($request->distribusi_id);

            // 2. Simpan Data Setoran
            SetorPemotong::create([
                'distribusi_pemotong_id' => $distribusi->id,
                'jumlah_cek_jadi'        => $request->jumlah_jadi,
                'berat_limbah_kg'        => $request->berat_limbah,
                'tanggal_setor'          => $request->tanggal,
            ]);

            // 3. Tambah Stok Cek (Barang Setengah Jadi)
            // Logika: Cari stok berdasarkan Produk & Warna. Kalau belum ada, buat baru.
            $stokCek = StokCek::firstOrNew([
                'produk_id' => $distribusi->produk_id,
                'warna_id'  => $distribusi->warna_id
            ]);
            
            $stokCek->jumlah_stok = ($stokCek->jumlah_stok ?? 0) + $request->jumlah_jadi;
            $stokCek->save();

            // 4. Update Status Surat Jalan jadi 'selesai'
            $distribusi->update(['status' => 'selesai']);
        });

        return back()->with('success', 'Hasil potongan diterima & Stok Cek bertambah.');
    }

}