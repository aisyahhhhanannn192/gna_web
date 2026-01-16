@extends('layouts.app')
@section('title', 'Distribusi Pemotongan')

@section('content')
<div x-data="{ 
    showModal: false, 
    showModalSetor: false, 
    selectedId: null, 
    selectedNoSurat: '' 
}">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Distribusi Pemotongan</h1>
            <p class="text-gray-600">Kelola pengiriman kain ke mitra potong</p>
        </div>
        <button @click="showModal = true" class="bg-gna-primary hover:bg-gna-dark text-white px-5 py-2.5 rounded-lg shadow-sm font-medium flex items-center transition-transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Surat Jalan
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700 font-medium">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700 font-medium">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">No. Surat / Tgl</th>
                    <th class="px-6 py-3">Mitra Pemotong</th>
                    <th class="px-6 py-3">Bahan Keluar</th>
                    <th class="px-6 py-3">Status / Hasil</th> <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $d)
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-mono font-bold text-gray-800">{{ $d->no_surat_jalan }}</div>
                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($d->tanggal_distribusi)->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $d->pemotong->nama_pemotong }}
                        <div class="text-xs text-gray-500 mt-1">Target: {{ $d->produk->nama_produk }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full border" style="background-color: {{ $d->warna->kode_warna }}"></span>
                            {{ $d->warna->nama_warna }}
                        </span>
                        <span class="text-xs font-bold text-red-600 block mt-1">- {{ $d->jumlah_gulungan_keluar }} Gulung</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($d->status == 'proses')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-200">Sedang Dipotong</span>
                        @else
                            <div class="flex flex-col">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-200 w-fit mb-1">Selesai</span>
                                
                                {{-- MENAMPILKAN HASIL DALAM KODI --}}
                                @if($d->setoran)
                                    @php
                                        $total = $d->setoran->jumlah_cek_jadi;
                                        $kodi  = floor($total / 20);
                                        $sisa  = $total % 20;
                                    @endphp
                                    <span class="text-xs font-bold text-gray-700">
                                        Hasil: {{ $kodi }} Kodi 
                                        @if($sisa > 0) + {{ $sisa }} Pcs @endif
                                    </span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($d->status == 'proses')
                            <button 
                                @click="
                                    selectedId = {{ $d->id }}; 
                                    selectedNoSurat = '{{ $d->no_surat_jalan }}'; 
                                    showModalSetor = true
                                "
                                class="text-white bg-blue-600 hover:bg-blue-700 font-medium text-xs px-3 py-1.5 rounded shadow-sm transition-colors"
                            >
                                Input Hasil
                            </button>
                        @else
                            <span class="text-gray-400 text-xs italic flex justify-end items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Disetor
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada distribusi kain.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $riwayat->links() }}
        </div>
    </div>

    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModal = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Buat Surat Jalan Baru</h3>
                
                <form action="{{ route('produksi.pemotongan.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Distribusi</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border p-2 rounded bg-gray-50 focus:ring-2 focus:ring-green-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mitra Pemotong</label>
                            <select name="pemotong_id" required class="w-full border p-2 rounded focus:ring-2 focus:ring-green-500">
                                <option value="">-- Pilih Mitra --</option>
                                @foreach($pemotongs as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pemotong }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rencana Target Produk</label>
                            <select name="produk_id" required class="w-full border p-2 rounded focus:ring-2 focus:ring-green-500">
                                <option value="">-- Kain ini mau dijadikan apa? --</option>
                                @foreach($produks as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <label class="block text-sm font-bold text-yellow-800 mb-2">Ambil Stok Kain</label>
                            <select name="warna_id" required class="w-full border p-2 rounded mb-3 bg-white">
                                <option value="">-- Pilih Warna (Sisa Stok) --</option>
                                @foreach($stok_kain as $stok)
                                    <option value="{{ $stok->warna_id }}">
                                        {{ $stok->warna->nama_warna }} (Sisa: {{ $stok->jumlah_gulungan }})
                                    </option>
                                @endforeach
                            </select>
                            
                            <label class="block text-xs font-medium text-gray-700 mb-1">Jumlah Keluar (Gulungan)</label>
                            <input type="number" name="jumlah" min="1" required class="w-full border p-2 rounded text-lg font-bold" placeholder="0">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-100 rounded text-gray-600 hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 shadow-lg">Simpan & Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="showModalSetor" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalSetor = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg">
                <div class="mb-5 border-b pb-4">
                    <h3 class="text-xl font-bold text-gray-900">Input Hasil Potongan</h3>
                    <p class="text-sm text-gray-500">No. Surat: <span class="font-mono font-bold text-blue-600" x-text="selectedNoSurat"></span></p>
                </div>
                
                <form action="{{ route('produksi.pemotongan.setor') }}" method="POST">
                    @csrf
                    <input type="hidden" name="distribusi_id" :value="selectedId">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Terima</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border p-2 rounded bg-gray-50">
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <label class="block text-sm font-bold text-blue-800 mb-2">Jumlah Barang Jadi (Cek)</label>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Jumlah Kodi (Iketan)</label>
                                    <div class="relative">
                                        <input type="number" name="jumlah_kodi" min="0" placeholder="0" 
                                               class="w-full border p-2 rounded text-lg font-bold text-blue-900 focus:ring-2 focus:ring-blue-500 text-center">
                                        <span class="absolute right-8 top-3 text-gray-300 text-[10px]">x20</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 mt-1 text-center">1 Kodi = 20 Pcs</p>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Lebihan (Ecer)</label>
                                    <div class="relative">
                                        <input type="number" name="jumlah_pcs" min="0" max="19" placeholder="0" 
                                               class="w-full border p-2 rounded text-lg font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 text-center">
                                        <span class="absolute right-3 top-2.5 text-gray-400 text-xs font-bold">Pcs</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 mt-1 text-center">Sisa satuan</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Berat Limbah/Sisa (Kg) - Opsional</label>
                            <input type="number" step="0.1" name="berat_limbah" class="w-full border p-2 rounded" placeholder="0.0">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showModalSetor = false" class="px-4 py-2 bg-gray-100 rounded text-gray-600 hover:bg-gray-200">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 shadow-lg">Simpan Hasil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection