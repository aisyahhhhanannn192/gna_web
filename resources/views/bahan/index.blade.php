@extends('layouts.app')
@section('title', 'Manajemen Bahan') @section('content')

<div x-data="{ showModalMasuk: false }">
    
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Bahan Baku</h1>
            <p class="text-gray-600">Inventory stok kain gulungan</p>
        </div>
        <button @click="showModalMasuk = true" class="bg-gna-primary hover:bg-gna-dark text-white px-5 py-2.5 rounded-lg font-medium shadow-sm flex items-center transition-all">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Input Bahan Masuk
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 shadow-sm rounded-r">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gna-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Sisa Stok Gudang
                </h3>
                
                <div class="space-y-3">
                    @forelse($stok as $item)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center space-x-3">
                            <div 
                                class="w-8 h-8 rounded-full border-2 border-gray-300 shadow-sm flex-shrink-0" 
                                style="background-color: {{ $item->warna?->kode_warna ?? '#e5e7eb' }}"
                                title="{{ $item->warna?->nama_warna ?? 'Warna Tidak Tersedia' }}"
                            ></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">{{ $item->warna?->nama_warna ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-400">Kode: {{ $item->warna?->kode_warna ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block text-xl font-bold text-gna-primary">{{ $item->jumlah_gulungan }}</span>
                            <span class="text-xs text-gray-500">Gulung</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-lg">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p>Gudang Kosong</p>
                        <p class="text-xs mt-1">Belum ada kain masuk dari supplier</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Riwayat Bahan Masuk (Terbaru)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Supplier</th>
                                <th class="px-6 py-3">Warna</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                                <th class="px-6 py-3">Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $log)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($log->tanggal_masuk)->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $log->supplier->nama_supplier }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <span class="w-2 h-2 mr-1 rounded-full" style="background-color: {{ $log->warna->kode_warna ?? '#000' }}"></span>
                                        {{ $log->warna->nama_warna }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-green-600">+ {{ $log->jumlah_gulungan_masuk }}</td>
                                <td class="px-6 py-4 text-xs font-mono">{{ $log->no_nota_supplier ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada riwayat transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div x-show="showModalMasuk" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showModalMasuk = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg transform transition-all">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Input Kain Masuk</h3>
                    <button @click="showModalMasuk = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('bahan.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                            <select name="supplier_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gna-primary focus:ring focus:ring-gna-primary p-2 border bg-white">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Warna Kain</label>
                            <select name="warna_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gna-primary focus:ring focus:ring-gna-primary p-2 border bg-white">
                                <option value="">-- Pilih Warna --</option>
                                @foreach($warnas as $w)
                                    <option value="{{ $w->id }}">{{ $w->nama_warna }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Gulungan)</label>
                                <input type="number" name="jumlah" min="1" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gna-primary focus:ring focus:ring-gna-primary p-2 border" placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                                <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gna-primary focus:ring focus:ring-gna-primary p-2 border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Nota (Opsional)</label>
                            <input type="text" name="no_nota" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gna-primary focus:ring focus:ring-gna-primary p-2 border" placeholder="Contoh: INV-001/SUP/2025">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" @click="showModalMasuk = false" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-gna-primary text-white rounded-lg hover:bg-gna-dark font-medium shadow-sm">Simpan Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection