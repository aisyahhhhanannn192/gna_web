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
        \App\Models\User::create([
            'name' => 'Admin GNA',
            'email' => 'admin@gna.com',
            'password' => Hash::make('password'), // Password default
        ]);

        // 2. Master Warna
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
        ];
        foreach ($warnas as $w) {
            \App\Models\MasterWarna::create(['nama_warna' => $w['nama'], 'kode_warna' => $w['kode']]);
        }

        // 3. Master Produk
        \App\Models\MasterProduk::create(['nama_produk' => 'Jas Hujan Ponco', 'kode_produk' => 'PONCO', 'estimasi_pcs_per_gulung' => 50]);
        \App\Models\MasterProduk::create(['nama_produk' => 'Jas Hujan Setelan', 'kode_produk' => 'SETELAN', 'estimasi_pcs_per_gulung' => 40]);
        \App\Models\MasterProduk::create(['nama_produk' => 'Jas Hujan Anak', 'kode_produk' => 'ANAK', 'estimasi_pcs_per_gulung' => 80]);

        // 4. Master Mitra (Contoh)
        \App\Models\MasterSupplier::create(['nama_supplier' => 'PT Tekstil Jaya', 'kontak' => '08123456789']);
        \App\Models\MasterPemotong::create(['nama_pemotong' => 'Pak Yanto Potong', 'no_hp' => '08987654321']);
        \App\Models\MasterKorlap::create(['nama_korlap' => 'Bu Susi Jahit', 'no_hp' => '08567891234']);
        \App\Models\MasterReseller::create(['nama_reseller' => 'Toko Abadi', 'area_wilayah' => 'Pasar Besar', 'no_hp' => '08111222333']);
    }
}