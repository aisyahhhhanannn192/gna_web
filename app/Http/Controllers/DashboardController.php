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

        // Menghitung jumlah pekerjaan aktif (Nota yang belum selesai)
        $proses_jahit = DistribusiKorlap::where('status', 'sedang_dikerjakan')->count();
        $proses_potong = DistribusiPemotong::where('status', 'proses')->count();

        // 2. DATA CHART (Tren Penjualan 7 Hari Terakhir)
        $chart_labels = [];
        $chart_data   = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->format('Y-m-d');

            // Query Omzet per hari
            $omzet_harian = TransaksiReseller::whereDate('tanggal_transaksi', $formattedDate)
                ->sum('total_harga');

            $chart_labels[] = $date->format('d M'); // Label: "29 Nov"
            $chart_data[]   = $omzet_harian;
        }

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
            'proses_jahit',
            'proses_potong',
            'chart_labels',
            'chart_data',
            'stok_kritis',
            'top_produk'
        ));
    }
}
