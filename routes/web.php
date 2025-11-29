<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterDataController;

// 1. Rute Dashboard (Halaman Utama)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// 2. Rute Manajemen Master
Route::prefix('manajemen_master')->name('master.')->group(function () {
    Route::get('/', [MasterDataController::class, 'index'])->name('index');
    // Nanti tambah route store/update di sini
    Route::post('/korlap/store', [MasterDataController::class, 'storeKorlap'])->name('korlap.store');
    Route::post('/produk/store', [MasterDataController::class, 'storeProduk'])->name('produk.store');
    Route::post('/warna/store', [MasterDataController::class, 'storeWarna'])->name('warna.store');
    Route::post('/supplier/store', [MasterDataController::class, 'storeSupplier'])->name('supplier.store');
    Route::post('/pemotong/store', [MasterDataController::class, 'storePemotong'])->name('pemotong.store');
    Route::post('/reseller/store', [MasterDataController::class, 'storeReseller'])->name('reseller.store');
    Route::post('/karyawan/store', [MasterDataController::class, 'storeKaryawan'])->name('karyawan.store');
});

// GROUP BARU: MANAJEMEN BAHAN
Route::prefix('manajemen_bahan')->name('bahan.')->group(function () {
    Route::get('/', [App\Http\Controllers\BahanController::class, 'index'])->name('index');
    Route::post('/store', [App\Http\Controllers\BahanController::class, 'store'])->name('store');
});

// GROUP BARU: PRODUKSI
Route::prefix('produksi')->name('produksi.')->group(function () {
    
    // Sub-Group: Pemotongan
    Route::prefix('pemotongan')->name('pemotongan.')->group(function () {
        Route::get('/', [App\Http\Controllers\PemotonganController::class, 'index'])->name('index');
        Route::post('/store', [App\Http\Controllers\PemotonganController::class, 'store'])->name('store');
        Route::post('/setor', [App\Http\Controllers\PemotonganController::class, 'storeSetor'])->name('setor');
    });

    // Sub-Group: Perakitan (Jahit)
    Route::prefix('perakitan')->name('perakitan.')->group(function () {
        // Halaman Utama & Form Buat Nota
        Route::get('/', [App\Http\Controllers\PerakitanController::class, 'index'])->name('index');
        Route::post('/store', [App\Http\Controllers\PerakitanController::class, 'store'])->name('store');
        
        // PENTING: Route untuk Terima Setoran (QC)
        Route::post('/setor', [App\Http\Controllers\PerakitanController::class, 'storeSetor'])->name('setor');
    });
});

// GROUP BARU: PENJUALAN (HILIR)
Route::prefix('penjualan')->name('penjualan.')->group(function () {
    Route::get('/', [App\Http\Controllers\PenjualanController::class, 'index'])->name('index');
    Route::post('/store', [App\Http\Controllers\PenjualanController::class, 'store'])->name('store');
});