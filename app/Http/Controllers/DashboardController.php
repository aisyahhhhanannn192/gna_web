<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\StokBahanKain;
use App\Models\StokGudangJadi;
use App\Models\TransaksiReseller;
use App\Models\DistribusiKorlap;
use App\Models\DistribusiPemotong;
use App\Models\SetorKorlap;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== KPI CARDS (Ringkasan Angka) =====

        // Total Penjualan
        $total_penjualan = TransaksiReseller::count();
        $total_nilai_jual = TransaksiReseller::sum('total_harga');

        // Stok
        $stok_bahan = StokBahanKain::sum('jumlah_gulungan');
        $stok_jadi = StokGudangJadi::sum('jumlah_stok');

        // Distribusi Aktif
        $dist_pemotong_proses = DistribusiPemotong::where('status', 'proses')->count();
        $dist_korlap_proses = DistribusiKorlap::where('status', 'sedang_dikerjakan')->count();
        $distribusi_aktif = $dist_pemotong_proses + $dist_korlap_proses;

        // ===== DATA CHART - Top 5 Warna Terlaris =====
        $warna_data_raw = TransaksiReseller::select('warna_id', DB::raw('sum(jumlah_keluar) as total_penjualan'))
            ->with('warna')
            ->groupBy('warna_id')
            ->orderByDesc('total_penjualan')
            ->limit(5)
            ->get();

        $warna_labels = $warna_data_raw->map(fn($item) => $item->warna->nama_warna ?? 'Unknown')->toArray();
        $warna_data = $warna_data_raw->map(fn($item) => $item->total_penjualan)->toArray();

        // ===== ALERT SYSTEM - Stok Kain Menipis =====
        $stok_kritis = StokBahanKain::with('warna')
            ->where('jumlah_gulungan', '<', 5)
            ->orderBy('jumlah_gulungan', 'asc')
            ->limit(5)
            ->get();

        // ===== TOP PRODUCTS (Produk Terlaris) =====
        $top_produk = TransaksiReseller::select(
            'produk_id',
            DB::raw('count(*) as total_jual'),
            DB::raw('sum(total_harga) as revenue')
        )
            ->with('produk')
            ->groupBy('produk_id')
            ->orderByDesc('total_jual')
            ->limit(10)
            ->get();

        // ===== RECENT DISTRIBUTIONS =====
        // Distribusi Pemotong Recent
        $dist_pemotong_recent = DistribusiPemotong::with(['pemotong', 'produk', 'warna'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Distribusi Korlap Recent
        $dist_korlap_recent = DistribusiKorlap::with(['korlap', 'produk', 'warna'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'total_penjualan',
            'total_nilai_jual',
            'stok_bahan',
            'stok_jadi',
            'distribusi_aktif',
            'dist_pemotong_proses',
            'dist_korlap_proses',
            'warna_labels',
            'warna_data',
            'stok_kritis',
            'top_produk',
            'dist_pemotong_recent',
            'dist_korlap_recent'
        ));
    }
}
