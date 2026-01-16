<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        // Data untuk Dropdown
        $pemotongs = MasterPemotong::all();
        $produks   = MasterProduk::all();
        $stok_kain = StokBahanKain::with('warna')->where('jumlah_gulungan', '>', 0)->get();

        // Data Riwayat
        // PERUBAHAN 1: Tambahkan 'setoran' agar bisa tampil di tabel
        $riwayat = DistribusiPemotong::with(['pemotong', 'produk', 'warna', 'setoran'])
                    ->latest()
                    ->paginate(20);

        return view('produksi.pemotongan.index', compact('pemotongs', 'produks', 'stok_kain', 'riwayat'));
    }

    // Method store (Buat Surat Jalan) biarkan tetap sama (karena inputnya Gulungan)
    public function store(Request $request)
    {
        // ... (Kode store kamu yang lama, tidak perlu diubah) ...
        $request->validate([
            'pemotong_id' => 'required',
            'warna_id'    => 'required',
            'produk_id'   => 'required',
            'jumlah'      => 'required|integer|min:1',
            'tanggal'     => 'required|date',
        ]);

        $stok_gudang = StokBahanKain::where('warna_id', $request->warna_id)->first();
        if (!$stok_gudang || $stok_gudang->jumlah_gulungan < $request->jumlah) {
            return back()->with('error', 'Stok kain tidak cukup! Sisa stok: ' . ($stok_gudang->jumlah_gulungan ?? 0));
        }

        DB::transaction(function () use ($request, $stok_gudang) {
            $no_surat = 'SJ-' . date('dm') . '-' . strtoupper(Str::random(3));
            DistribusiPemotong::create([
                'no_surat_jalan' => $no_surat,
                'pemotong_id'    => $request->pemotong_id,
                'produk_id'      => $request->produk_id,
                'warna_id'       => $request->warna_id,
                'jumlah_gulungan_keluar' => $request->jumlah,
                'tanggal_distribusi'     => $request->tanggal,
                'status'         => 'proses'
            ]);
            $stok_gudang->decrement('jumlah_gulungan', $request->jumlah);
        });

        return back()->with('success', 'Surat Jalan berhasil dibuat.');
    }

    // PERUBAHAN 2: Method storeSetor (Logika Kodi)
    public function storeSetor(Request $request)
    {
        $request->validate([
            'distribusi_id' => 'required|exists:distribusi_pemotong,id',
            // Kita ganti validasi jumlah_jadi menjadi kodi & pcs
            'jumlah_kodi'   => 'nullable|integer|min:0',
            'jumlah_pcs'    => 'nullable|integer|min:0',
            'tanggal'       => 'required|date',
            'berat_limbah'  => 'nullable|numeric',
        ]);

        // LOGIKA KONVERSI: (Kodi * 20) + Pcs Eceran
        $kodi = $request->jumlah_kodi ?? 0;
        $pcs  = $request->jumlah_pcs ?? 0;
        $total_jadi = ($kodi * 20) + $pcs;

        if ($total_jadi <= 0) {
            return back()->with('error', 'Jumlah setoran tidak boleh kosong!');
        }

        DB::transaction(function () use ($request, $total_jadi) {
            $distribusi = DistribusiPemotong::findOrFail($request->distribusi_id);

            SetorPemotong::create([
                'distribusi_pemotong_id' => $distribusi->id,
                'jumlah_cek_jadi'        => $total_jadi, // Simpan TOTAL PCS di database
                'berat_limbah_kg'        => $request->berat_limbah,
                'tanggal_setor'          => $request->tanggal,
            ]);

            // Tambah Stok Cek (WIP)
            $stokCek = StokCek::firstOrNew([
                'produk_id' => $distribusi->produk_id,
                'warna_id'  => $distribusi->warna_id
            ]);
            $stokCek->jumlah_stok = ($stokCek->jumlah_stok ?? 0) + $total_jadi;
            $stokCek->save();

            $distribusi->update(['status' => 'selesai']);
        });

        return back()->with('success', 'Hasil diterima. Total: ' . $total_jadi . ' Pcs masuk Stok Cek.');
    }
}