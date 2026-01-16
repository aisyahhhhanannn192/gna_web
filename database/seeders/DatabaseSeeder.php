<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Admin Default
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@gna.com'],
            [
                'name' => 'Admin GNA',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Master Warna (15 warna lengkap)
        $warnas = [
            ['nama' => 'Merah Maroon', 'kode' => '#800000'],
            ['nama' => 'Biru Dongker', 'kode' => '#003366'],
            ['nama' => 'Hitam', 'kode' => '#000000'],
            ['nama' => 'Hijau Army', 'kode' => '#556B2F'],
            ['nama' => 'Kuning Mustard', 'kode' => '#FFDB58'],
            ['nama' => 'Pink', 'kode' => '#FF69B4'],
            ['nama' => 'Putih', 'kode' => '#FFFFFF'],
            ['nama' => 'Abu-abu', 'kode' => '#808080'],
            ['nama' => 'Biru Muda', 'kode' => '#87CEEB'],
            ['nama' => 'Ungu', 'kode' => '#800080'],
            ['nama' => 'Coklat', 'kode' => '#8B4513'],
            ['nama' => 'Merah Cerah', 'kode' => '#FF0000'],
            ['nama' => 'Hijau Muda', 'kode' => '#90EE90'],
            ['nama' => 'Biru Langit', 'kode' => '#1E90FF'],
            ['nama' => 'Orange', 'kode' => '#FFA500'],
        ];
        foreach ($warnas as $w) {
            \App\Models\MasterWarna::create(['nama_warna' => $w['nama'], 'kode_warna' => $w['kode']]);
        }

        // 3. Master Produk (5 produk)
        $produk_data = [
            ['nama' => 'Jas Hujan Ponco', 'kode' => 'PONCO', 'pcs_per_gulung' => 50],
            ['nama' => 'Jas Hujan Setelan', 'kode' => 'SETELAN', 'pcs_per_gulung' => 40],
            ['nama' => 'Jas Hujan Anak', 'kode' => 'ANAK', 'pcs_per_gulung' => 80],
            ['nama' => 'Jaket Waterproof', 'kode' => 'JAKET', 'pcs_per_gulung' => 35],
            ['nama' => 'Mantel Hujan Premium', 'kode' => 'PREMIUM', 'pcs_per_gulung' => 30],
        ];
        $produks = [];
        foreach ($produk_data as $p) {
            $produks[] = \App\Models\MasterProduk::create([
                'nama_produk' => $p['nama'],
                'kode_produk' => $p['kode'],
                'estimasi_pcs_per_gulung' => $p['pcs_per_gulung']
            ])->id;
        }

        // 4. Master Supplier (5 supplier)
        $supplier_data = [
            ['nama' => 'PT Tekstil Jaya', 'kontak' => '08123456789'],
            ['nama' => 'CV Bahan Berkah', 'kontak' => '08234567890'],
            ['nama' => 'PT Kain Indonesia', 'kontak' => '08345678901'],
            ['nama' => 'UD Suplai Kain', 'kontak' => '08456789012'],
            ['nama' => 'Toko Bahan Makmur', 'kontak' => '08567890123'],
        ];
        $suppliers = [];
        foreach ($supplier_data as $s) {
            $suppliers[] = \App\Models\MasterSupplier::create([
                'nama_supplier' => $s['nama'],
                'kontak' => $s['kontak']
            ])->id;
        }

        // 5. Master Pemotong (6 pemotong)
        $pemotong_data = [
            ['nama' => 'Pak Yanto Potong', 'no_hp' => '08987654321', 'alamat' => 'Jl. Merdeka No. 10, Kebumen'],
            ['nama' => 'Pak Budi Cutter', 'no_hp' => '08876543210', 'alamat' => 'Jl. Ahmad Yani No. 5, Kebumen'],
            ['nama' => 'Pak Hari Potong', 'no_hp' => '08765432109', 'alamat' => 'Jl. Diponegoro No. 12, Kebumen'],
            ['nama' => 'Pak Slamet Cutting', 'no_hp' => '08654321098', 'alamat' => 'Jl. Gajah Mada No. 8, Kebumen'],
            ['nama' => 'Pak Joko Potong', 'no_hp' => '08543210987', 'alamat' => 'Jl. Sudirman No. 15, Kebumen'],
            ['nama' => 'Pak Warto Cutter', 'no_hp' => '08432109876', 'alamat' => 'Jl. Kartini No. 7, Kebumen'],
        ];
        $pemotongs = [];
        foreach ($pemotong_data as $p) {
            $pemotongs[] = \App\Models\MasterPemotong::create([
                'nama_pemotong' => $p['nama'],
                'no_hp' => $p['no_hp'],
                'alamat' => $p['alamat']
            ])->id;
        }

        // 6. Master Korlap/Penjahit (7 korlap)
        $korlap_data = [
            ['nama' => 'Bu Susi Jahit', 'no_hp' => '08567891234', 'alamat' => 'Jl. Veteran No. 20, Kebumen'],
            ['nama' => 'Bu Ani Sewing', 'no_hp' => '08456780123', 'alamat' => 'Jl. Harapan No. 9, Kebumen'],
            ['nama' => 'Bu Wati Jahit', 'no_hp' => '08345679012', 'alamat' => 'Jl. Pendidikan No. 3, Kebumen'],
            ['nama' => 'Bu Mirna Sewing', 'no_hp' => '08234568901', 'alamat' => 'Jl. Teuku Umar No. 14, Kebumen'],
            ['nama' => 'Bu Endang Jahit', 'no_hp' => '08123457890', 'alamat' => 'Jl. Suprapto No. 6, Kebumen'],
            ['nama' => 'Bu Tinah Sewing', 'no_hp' => '08012346789', 'alamat' => 'Jl. Gunung Merapi No. 11, Kebumen'],
            ['nama' => 'Bu Sri Jahit', 'no_hp' => '08901235678', 'alamat' => 'Jl. Letjend Suprapto No. 4, Kebumen'],
        ];
        $korlaps = [];
        foreach ($korlap_data as $k) {
            $korlaps[] = \App\Models\MasterKorlap::create([
                'nama_korlap' => $k['nama'],
                'no_hp' => $k['no_hp'],
                'alamat' => $k['alamat']
            ])->id;
        }

        // 7. Master Reseller (8 reseller)
        $reseller_data = [
            ['nama' => 'Toko Tiga Putra', 'no_hp' => '08111111111', 'wilayah' => 'Kebumen'],
            ['nama' => 'Toko Maju Jaya', 'no_hp' => '08222222222', 'wilayah' => 'Wonosobo'],
            ['nama' => 'CV Bintang Merah', 'no_hp' => '08333333333', 'wilayah' => 'Purworejo'],
            ['nama' => 'Toko Sinar Abadi', 'no_hp' => '08444444444', 'wilayah' => 'Yogyakarta'],
            ['nama' => 'UD Citra Niaga', 'no_hp' => '08555555555', 'wilayah' => 'Bandung'],
            ['nama' => 'Toko Mitra Sukses', 'no_hp' => '08666666666', 'wilayah' => 'Semarang'],
            ['nama' => 'CV Rezeki Melimpah', 'no_hp' => '08777777777', 'wilayah' => 'Solo'],
            ['nama' => 'Toko Berlian Utama', 'no_hp' => '08888888888', 'wilayah' => 'Jakarta'],
        ];
        $resellers = [];
        foreach ($reseller_data as $r) {
            $resellers[] = \App\Models\MasterReseller::create([
                'nama_reseller' => $r['nama'],
                'no_hp' => $r['no_hp'],
                'area_wilayah' => $r['wilayah']
            ])->id;
        }

        // 8. Master Karyawan (10 karyawan)
        $karyawan_data = [
            ['nama' => 'Ahmad Riyadi', 'posisi' => 'Packing', 'no_hp' => '08211111111', 'alamat' => 'Jl. Mawar No. 1'],
            ['nama' => 'Budi Santoso', 'posisi' => 'Packing', 'no_hp' => '08212222222', 'alamat' => 'Jl. Melati No. 2'],
            ['nama' => 'Citra Dewi', 'posisi' => 'Gudang', 'no_hp' => '08213333333', 'alamat' => 'Jl. Anggrek No. 3'],
            ['nama' => 'Dedi Supriyanto', 'posisi' => 'Gudang', 'no_hp' => '08214444444', 'alamat' => 'Jl. Dahlia No. 4'],
            ['nama' => 'Eka Putri', 'posisi' => 'Admin', 'no_hp' => '08215555555', 'alamat' => 'Jl. Bunga No. 5'],
            ['nama' => 'Fahmi Rizki', 'posisi' => 'Admin', 'no_hp' => '08216666666', 'alamat' => 'Jl. Tulip No. 6'],
            ['nama' => 'Gita Sari', 'posisi' => 'Supir', 'no_hp' => '08217777777', 'alamat' => 'Jl. Masjid No. 7'],
            ['nama' => 'Haris Gunawan', 'posisi' => 'Supir', 'no_hp' => '08218888888', 'alamat' => 'Jl. Sekolah No. 8'],
            ['nama' => 'Intan Sari', 'posisi' => 'Packing', 'no_hp' => '08219999999', 'alamat' => 'Jl. Taman No. 9'],
            ['nama' => 'Joko Wardana', 'posisi' => 'Gudang', 'no_hp' => '08210000000', 'alamat' => 'Jl. Pasar No. 10'],
        ];
        $karyawans = [];
        foreach ($karyawan_data as $k) {
            $karyawans[] = \App\Models\MasterKaryawan::create([
                'nama_karyawan' => $k['nama'],
                'posisi' => $k['posisi'],
                'no_hp' => $k['no_hp'],
                'alamat' => $k['alamat']
            ])->id;
        }

        // 9. Stok Bahan Kain (Initial Stock)
        $warna_ids = range(1, 15);
        foreach ($warna_ids as $warna_id) {
            \App\Models\StokBahanKain::create([
                'warna_id' => $warna_id,
                'jumlah_gulungan' => rand(50, 200)
            ]);
        }

        // 10. Bahan Masuk (5 transaksi)
        $bahan_masuk_data = [
            ['supplier_id' => $suppliers[0], 'warna_id' => 1, 'jumlah' => 100, 'tanggal' => '2025-01-05', 'no_nota' => 'SM-001/2025'],
            ['supplier_id' => $suppliers[1], 'warna_id' => 2, 'jumlah' => 80, 'tanggal' => '2025-01-06', 'no_nota' => 'SM-002/2025'],
            ['supplier_id' => $suppliers[2], 'warna_id' => 3, 'jumlah' => 120, 'tanggal' => '2025-01-07', 'no_nota' => 'SM-003/2025'],
            ['supplier_id' => $suppliers[3], 'warna_id' => 4, 'jumlah' => 90, 'tanggal' => '2025-01-08', 'no_nota' => 'SM-004/2025'],
            ['supplier_id' => $suppliers[4], 'warna_id' => 5, 'jumlah' => 110, 'tanggal' => '2025-01-09', 'no_nota' => 'SM-005/2025'],
        ];
        foreach ($bahan_masuk_data as $bm) {
            \App\Models\BahanMasuk::create([
                'supplier_id' => $bm['supplier_id'],
                'warna_id' => $bm['warna_id'],
                'jumlah_gulungan_masuk' => $bm['jumlah'],
                'tanggal_masuk' => $bm['tanggal'],
                'no_nota_supplier' => $bm['no_nota']
            ]);
        }

        // 11. Distribusi Pemotong (6 distribusi)
        $distribusi_pemotong_data = [
            ['no_sj' => 'SJ-20250110-001', 'pemotong_id' => $pemotongs[0], 'produk_id' => $produks[0], 'warna_id' => 1, 'jumlah' => 30, 'tanggal' => '2025-01-10', 'status' => 'proses'],
            ['no_sj' => 'SJ-20250111-002', 'pemotong_id' => $pemotongs[1], 'produk_id' => $produks[1], 'warna_id' => 2, 'jumlah' => 25, 'tanggal' => '2025-01-11', 'status' => 'proses'],
            ['no_sj' => 'SJ-20250112-003', 'pemotong_id' => $pemotongs[2], 'produk_id' => $produks[2], 'warna_id' => 3, 'jumlah' => 40, 'tanggal' => '2025-01-12', 'status' => 'proses'],
            ['no_sj' => 'SJ-20250113-004', 'pemotong_id' => $pemotongs[3], 'produk_id' => $produks[0], 'warna_id' => 4, 'jumlah' => 35, 'tanggal' => '2025-01-13', 'status' => 'selesai'],
            ['no_sj' => 'SJ-20250114-005', 'pemotong_id' => $pemotongs[4], 'produk_id' => $produks[1], 'warna_id' => 5, 'jumlah' => 28, 'tanggal' => '2025-01-14', 'status' => 'proses'],
            ['no_sj' => 'SJ-20250115-006', 'pemotong_id' => $pemotongs[5], 'produk_id' => $produks[3], 'warna_id' => 6, 'jumlah' => 32, 'tanggal' => '2025-01-15', 'status' => 'proses'],
        ];
        $dist_pemotongs = [];
        foreach ($distribusi_pemotong_data as $dp) {
            $dist_pemotongs[] = \App\Models\DistribusiPemotong::create([
                'no_surat_jalan' => $dp['no_sj'],
                'pemotong_id' => $dp['pemotong_id'],
                'produk_id' => $dp['produk_id'],
                'warna_id' => $dp['warna_id'],
                'jumlah_gulungan_keluar' => $dp['jumlah'],
                'tanggal_distribusi' => $dp['tanggal'],
                'status' => $dp['status']
            ])->id;
        }

        // 12. Setor Pemotong (5 setor)
        $setor_pemotong_data = [
            ['dist_id' => $dist_pemotongs[0], 'jumlah_cek' => 1500, 'limbah' => 5.2, 'tanggal' => '2025-01-11'],
            ['dist_id' => $dist_pemotongs[1], 'jumlah_cek' => 1000, 'limbah' => 3.5, 'tanggal' => '2025-01-12'],
            ['dist_id' => $dist_pemotongs[2], 'jumlah_cek' => 3200, 'limbah' => 7.8, 'tanggal' => '2025-01-13'],
            ['dist_id' => $dist_pemotongs[3], 'jumlah_cek' => 1750, 'limbah' => 4.1, 'tanggal' => '2025-01-14'],
            ['dist_id' => $dist_pemotongs[4], 'jumlah_cek' => 1400, 'limbah' => 3.9, 'tanggal' => '2025-01-15'],
        ];
        foreach ($setor_pemotong_data as $sp) {
            \App\Models\SetorPemotong::create([
                'distribusi_pemotong_id' => $sp['dist_id'],
                'jumlah_cek_jadi' => $sp['jumlah_cek'],
                'berat_limbah_kg' => $sp['limbah'],
                'tanggal_setor' => $sp['tanggal']
            ]);
        }

        // 13. Stok CEK (Generated from Setor Pemotong)
        $stok_cek_data = [
            ['produk_id' => $produks[0], 'warna_id' => 1, 'stok' => 1500],
            ['produk_id' => $produks[1], 'warna_id' => 2, 'stok' => 1000],
            ['produk_id' => $produks[2], 'warna_id' => 3, 'stok' => 3200],
            ['produk_id' => $produks[0], 'warna_id' => 4, 'stok' => 1750],
            ['produk_id' => $produks[1], 'warna_id' => 5, 'stok' => 1400],
        ];
        foreach ($stok_cek_data as $sc) {
            DB::table('stok_cek')->insert([
                'produk_id' => $sc['produk_id'],
                'warna_id' => $sc['warna_id'],
                'jumlah_stok' => $sc['stok'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 14. Distribusi Korlap (6 distribusi)
        $distribusi_korlap_data = [
            ['no_nota' => 'NOT-20250112-001', 'korlap_id' => $korlaps[0], 'produk_id' => $produks[0], 'warna_id' => 1, 'jumlah_cek' => 500, 'tanggal' => '2025-01-12', 'status' => 'sedang_dikerjakan'],
            ['no_nota' => 'NOT-20250113-002', 'korlap_id' => $korlaps[1], 'produk_id' => $produks[1], 'warna_id' => 2, 'jumlah_cek' => 350, 'tanggal' => '2025-01-13', 'status' => 'sedang_dikerjakan'],
            ['no_nota' => 'NOT-20250114-003', 'korlap_id' => $korlaps[2], 'produk_id' => $produks[2], 'warna_id' => 3, 'jumlah_cek' => 800, 'tanggal' => '2025-01-14', 'status' => 'sedang_dikerjakan'],
            ['no_nota' => 'NOT-20250115-004', 'korlap_id' => $korlaps[3], 'produk_id' => $produks[0], 'warna_id' => 4, 'jumlah_cek' => 600, 'tanggal' => '2025-01-15', 'status' => 'selesai'],
            ['no_nota' => 'NOT-20250116-005', 'korlap_id' => $korlaps[4], 'produk_id' => $produks[1], 'warna_id' => 5, 'jumlah_cek' => 400, 'tanggal' => '2025-01-16', 'status' => 'sedang_dikerjakan'],
            ['no_nota' => 'NOT-20250117-006', 'korlap_id' => $korlaps[5], 'produk_id' => $produks[3], 'warna_id' => 6, 'jumlah_cek' => 450, 'tanggal' => '2025-01-17', 'status' => 'sedang_dikerjakan'],
        ];
        $dist_korlaps = [];
        foreach ($distribusi_korlap_data as $dk) {
            $dist_korlaps[] = \App\Models\DistribusiKorlap::create([
                'no_nota' => $dk['no_nota'],
                'korlap_id' => $dk['korlap_id'],
                'produk_id' => $dk['produk_id'],
                'warna_id' => $dk['warna_id'],
                'jumlah_cek_keluar' => $dk['jumlah_cek'],
                'tanggal_distribusi' => $dk['tanggal'],
                'status' => $dk['status']
            ])->id;
        }

        // 15. Setor Korlap (5 setor)
        $setor_korlap_data = [
            ['dist_korlap_id' => $dist_korlaps[0], 'korlap_id' => $korlaps[0], 'jadi' => 480, 'afkir' => 10, 'pending' => 10, 'catatan' => 'Semua rapi, siap distribusi', 'tanggal' => '2025-01-13'],
            ['dist_korlap_id' => $dist_korlaps[1], 'korlap_id' => $korlaps[1], 'jadi' => 330, 'afkir' => 15, 'pending' => 5, 'catatan' => 'Ada beberapa jahitan miring', 'tanggal' => '2025-01-14'],
            ['dist_korlap_id' => $dist_korlaps[2], 'korlap_id' => $korlaps[2], 'jadi' => 770, 'afkir' => 20, 'pending' => 10, 'catatan' => 'Kualitas bagus', 'tanggal' => '2025-01-15'],
            ['dist_korlap_id' => $dist_korlaps[3], 'korlap_id' => $korlaps[3], 'jadi' => 580, 'afkir' => 15, 'pending' => 5, 'catatan' => 'Sempurna', 'tanggal' => '2025-01-16'],
            ['dist_korlap_id' => $dist_korlaps[4], 'korlap_id' => $korlaps[4], 'jadi' => 380, 'afkir' => 15, 'pending' => 5, 'catatan' => 'Ada kurang kancing', 'tanggal' => '2025-01-17'],
        ];
        foreach ($setor_korlap_data as $sk) {
            \App\Models\SetorKorlap::create([
                'distribusi_korlap_id' => $sk['dist_korlap_id'],
                'korlap_id' => $sk['korlap_id'],
                'jumlah_pcs_jadi' => $sk['jadi'],
                'jumlah_afkir' => $sk['afkir'],
                'jumlah_pending' => $sk['pending'],
                'catatan' => $sk['catatan'],
                'tanggal_setor' => $sk['tanggal']
            ]);
        }

        // 16. Stok Gudang Jadi (Generated from Setor Korlap)
        $stok_jadi_data = [
            ['produk_id' => $produks[0], 'warna_id' => 1, 'stok' => 480],
            ['produk_id' => $produks[1], 'warna_id' => 2, 'stok' => 330],
            ['produk_id' => $produks[2], 'warna_id' => 3, 'stok' => 770],
            ['produk_id' => $produks[0], 'warna_id' => 4, 'stok' => 580],
            ['produk_id' => $produks[1], 'warna_id' => 5, 'stok' => 380],
        ];
        foreach ($stok_jadi_data as $sj) {
            DB::table('stok_gudang_jadi')->insert([
                'produk_id' => $sj['produk_id'],
                'warna_id' => $sj['warna_id'],
                'jumlah_stok' => $sj['stok'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 17. Transaksi Reseller (8 transaksi)
        $transaksi_reseller_data = [
            ['no_inv' => 'INV-20250110-001', 'reseller_id' => $resellers[0], 'produk_id' => $produks[0], 'warna_id' => 1, 'qty' => 50, 'harga' => 85000, 'tanggal' => '2025-01-10'],
            ['no_inv' => 'INV-20250111-002', 'reseller_id' => $resellers[1], 'produk_id' => $produks[1], 'warna_id' => 2, 'qty' => 40, 'harga' => 95000, 'tanggal' => '2025-01-11'],
            ['no_inv' => 'INV-20250112-003', 'reseller_id' => $resellers[2], 'produk_id' => $produks[2], 'warna_id' => 3, 'qty' => 100, 'harga' => 75000, 'tanggal' => '2025-01-12'],
            ['no_inv' => 'INV-20250113-004', 'reseller_id' => $resellers[3], 'produk_id' => $produks[0], 'warna_id' => 4, 'qty' => 60, 'harga' => 90000, 'tanggal' => '2025-01-13'],
            ['no_inv' => 'INV-20250114-005', 'reseller_id' => $resellers[4], 'produk_id' => $produks[1], 'warna_id' => 5, 'qty' => 75, 'harga' => 92000, 'tanggal' => '2025-01-14'],
            ['no_inv' => 'INV-20250115-006', 'reseller_id' => $resellers[5], 'produk_id' => $produks[3], 'warna_id' => 6, 'qty' => 45, 'harga' => 120000, 'tanggal' => '2025-01-15'],
            ['no_inv' => 'INV-20250116-007', 'reseller_id' => $resellers[6], 'produk_id' => $produks[4], 'warna_id' => 7, 'qty' => 30, 'harga' => 150000, 'tanggal' => '2025-01-16'],
            ['no_inv' => 'INV-20250117-008', 'reseller_id' => $resellers[7], 'produk_id' => $produks[0], 'warna_id' => 8, 'qty' => 55, 'harga' => 88000, 'tanggal' => '2025-01-17'],
        ];
        foreach ($transaksi_reseller_data as $tr) {
            $total = $tr['qty'] * $tr['harga'];
            \App\Models\TransaksiReseller::create([
                'no_invoice' => $tr['no_inv'],
                'reseller_id' => $tr['reseller_id'],
                'produk_id' => $tr['produk_id'],
                'warna_id' => $tr['warna_id'],
                'jumlah_keluar' => $tr['qty'],
                'harga_satuan' => $tr['harga'],
                'total_harga' => $total,
                'tanggal_transaksi' => $tr['tanggal']
            ]);
        }
    }
}