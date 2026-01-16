@extends('layouts.app')
@section('title', 'Distribusi Reseller')

@section('content')
<div x-data="{ showModal: false }">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Distribusi Reseller</h1>
            <p class="text-gray-600">Pencatatan barang keluar ke mitra (Logistik)</p>
        </div>
        <button @click="showModal = true" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow-sm font-medium flex items-center transition-transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Input Distribusi
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                    Stok Gudang Jadi
                </h3>
                
                <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($stok_ready as $s)
                    <div class="p-4 bg-green-50 rounded-lg border border-green-100 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $s->produk->nama_produk }}</p>
                                <div class="flex items-center mt-1">
                                    <span class="w-3 h-3 rounded-full border border-gray-300 mr-2" style="background-color: {{ $s->warna->kode_warna }}"></span>
                                    <span class="text-xs text-gray-600">{{ $s->warna->nama_warna }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block text-xl font-bold text-green-700">{{ $s->jumlah_stok }}</span>
                                <span class="text-[10px] uppercase font-bold text-green-500">Pcs</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-lg">
                        <p>Gudang Kosong.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">Riwayat Pengiriman</h3>
                    <span class="text-xs text-gray-500">20 Transaksi Terakhir</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">No. Surat / Tgl</th>
                                <th class="px-6 py-3">Reseller</th>
                                <th class="px-6 py-3">Item</th>
                                <th class="px-6 py-3 text-right">Jumlah Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $t)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-mono font-bold text-gray-800">{{ $t->no_invoice }}</div>
                                    <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/y') }}</div>
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $t->reseller->nama_reseller }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900">{{ $t->produk->nama_produk }}</div>
                                    <div class="text-xs text-gray-500">{{ $t->warna->nama_warna }}</div>
                                </td>
                                
                                {{-- TAMPILAN KODI DI TABEL --}}
                                <td class="px-6 py-4 text-right">
                                    @php
                                        $kodi = floor($t->jumlah_keluar / 20);
                                        $sisa = $t->jumlah_keluar % 20;
                                    @endphp
                                    <div class="font-bold text-red-600">
                                        {{ $kodi }} Kodi
                                        @if($sisa > 0) + {{ $sisa }} Pcs @endif
                                    </div>
                                    <div class="text-[10px] text-gray-400">Total: {{ $t->jumlah_keluar }} Pcs</div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada pengiriman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">
                    {{ $riwayat->links() }}
                </div>
            </div>
        </div>
    </div>

    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModal = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg">
                <h3 class="text-lg font-bold mb-4">Input Pengiriman Barang</h3>
                
                <form action="{{ route('penjualan.store') }}" method="POST" x-data="{ stokSelected: '' }">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pengiriman</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border p-2 rounded bg-gray-50">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pilih Reseller</label>
                            <select name="reseller_id" required class="w-full border p-2 rounded">
                                <option value="">-- Pilih Reseller --</option>
                                @foreach($resellers as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_reseller }} ({{ $r->area_wilayah }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                            <label class="block text-sm font-bold text-green-800 mb-2">Ambil Stok Barang Jadi</label>
                            
                            <select x-model="stokSelected" class="w-full border p-2 rounded mb-3 bg-white" 
                                @change="
                                    let parts = stokSelected.split('|');
                                    document.getElementById('p_id').value = parts[0];
                                    document.getElementById('w_id').value = parts[1];
                                ">
                                <option value="">-- Pilih Barang Siap Kirim --</option>
                                @foreach($stok_ready as $s)
                                    <option value="{{ $s->produk_id }}|{{ $s->warna_id }}">
                                        {{ $s->produk->nama_produk }} - {{ $s->warna->nama_warna }} (Stok: {{ $s->jumlah_stok }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="produk_id" id="p_id">
                            <input type="hidden" name="warna_id" id="w_id">
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Jumlah Kodi (Iketan)</label>
                                    <div class="relative">
                                        <input type="number" name="jumlah_kodi" min="0" placeholder="0" 
                                               class="w-full border p-2 rounded text-lg font-bold text-green-800 text-center">
                                        <span class="absolute right-3 top-3 text-gray-300 text-[10px]">x20</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 mt-1 text-center">1 Kodi = 20 Pcs</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Lebihan (Pcs)</label>
                                    <div class="relative">
                                        <input type="number" name="jumlah_pcs" min="0" max="19" placeholder="0" 
                                               class="w-full border p-2 rounded text-lg font-bold text-gray-700 text-center">
                                        <span class="absolute right-3 top-2.5 text-gray-400 text-xs font-bold">Pcs</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 mt-1 text-center">Sisa satuan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-100 rounded text-gray-600">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 shadow-md">Kirim Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection