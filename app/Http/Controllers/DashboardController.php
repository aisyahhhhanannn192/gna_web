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

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KPI CARDS (Ringkasan Angka)
        $total_omzet = TransaksiReseller::sum('total_harga');
        $stok_kain   = StokBahanKain::sum('jumlah_gulungan');
        $stok_jadi   = StokGudangJadi::sum('jumlah_stok');
        $total_pesanan = TransaksiReseller::count(); // Total pesanan

        // Menghitung jumlah pekerjaan aktif (Nota yang belum selesai)
        $proses_jahit = DistribusiKorlap::where('status', 'sedang_dikerjakan')->count();
        $proses_potong = DistribusiPemotong::where('status', 'proses')->count();

        // 2. DATA CHART - Top 5 Warna Terlaris
        $warna_data_raw = TransaksiReseller::select('warna_id', DB::raw('sum(jumlah_keluar) as total_penjualan'))
            ->with('warna')
            ->groupBy('warna_id')
            ->orderByDesc('total_penjualan')
            ->limit(5)
            ->get();

        $warna_labels = $warna_data_raw->map(fn($item) => $item->warna->nama_warna ?? 'Unknown')->toArray();
        $warna_data = $warna_data_raw->map(fn($item) => $item->total_penjualan)->toArray();

        // 3. ALERT SYSTEM (Stok Kain Menipis < 5 Gulung)
        $stok_kritis = StokBahanKain::with('warna')
            ->where('jumlah_gulungan', '<', 5) // Ambang batas
            ->limit(5)
            ->get();

        // 4. TOP PRODUCT (Produk Terlaris)
        // Query agak advanced: Group by produk, sum quantity, order desc
        $top_produk = TransaksiReseller::select('produk_id', DB::raw('sum(jumlah_keluar) as total_jual'))
            ->with('produk')
            ->groupBy('produk_id')
            ->orderByDesc('total_jual')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'total_omzet',
            'stok_kain',
            'stok_jadi',
            'total_pesanan',
            'proses_jahit',
            'proses_potong',
            'warna_labels',
            'warna_data',
            'stok_kritis',
            'top_produk'
        ));
    }
}
