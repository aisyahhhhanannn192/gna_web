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
        <button @click="showModal = true" class="bg-gna-primary hover:bg-gna-dark text-white px-5 py-2.5 rounded-lg shadow-sm font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Surat Jalan
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-green-700">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">No. Surat</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Mitra Pemotong</th>
                    <th class="px-6 py-3">Target Produk</th>
                    <th class="px-6 py-3">Bahan Keluar</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $d)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-mono font-bold">{{ $d->no_surat_jalan }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($d->tanggal_distribusi)->format('d M Y') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $d->pemotong->nama_pemotong }}</td>
                    <td class="px-6 py-4">
                        {{ $d->produk->nama_produk }}
                        <div class="text-xs text-gray-400">{{ $d->produk->kode_produk }}</div>
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
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Sedang Dipotong</span>
                        @else
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai</span>
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
                                class="text-blue-600 hover:text-blue-900 font-medium text-xs border border-blue-200 bg-blue-50 px-3 py-1 rounded transition-colors"
                            >
                                Input Setor
                            </button>
                        @else
                            <span class="text-gray-400 text-xs italic">Sudah Disetor</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada distribusi kain.</td></tr>
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
                <h3 class="text-lg font-bold mb-4">Buat Surat Jalan Baru</h3>
                
                <form action="{{ route('produksi.pemotongan.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Distribusi</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border p-2 rounded bg-gray-50">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mitra Pemotong</label>
                            <select name="pemotong_id" required class="w-full border p-2 rounded">
                                <option value="">-- Pilih Mitra --</option>
                                @foreach($pemotongs as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pemotong }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rencana Target Produk</label>
                            <select name="produk_id" required class="w-full border p-2 rounded">
                                <option value="">-- Kain ini mau dijadikan apa? --</option>
                                @foreach($produks as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-yellow-50 p-3 rounded border border-yellow-200">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ambil Stok Kain</label>
                            <select name="warna_id" required class="w-full border p-2 rounded mb-2">
                                <option value="">-- Pilih Warna (Sisa Stok) --</option>
                                @foreach($stok_kain as $stok)
                                    <option value="{{ $stok->warna_id }}">
                                        {{ $stok->warna->nama_warna }} (Sisa: {{ $stok->jumlah_gulungan }})
                                    </option>
                                @endforeach
                            </select>
                            
                            <label class="block text-sm font-medium text-gray-700">Jumlah Keluar (Gulungan)</label>
                            <input type="number" name="jumlah" min="1" required class="w-full border p-2 rounded" placeholder="0">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-gray-100 rounded text-gray-600">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-gna-primary text-white rounded hover:bg-gna-dark">Simpan & Cetak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="showModalSetor" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalSetor = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Input Hasil Potongan</h3>
                    <p class="text-sm text-gray-500">No. Surat: <span class="font-mono font-bold text-gray-800" x-text="selectedNoSurat"></span></p>
                </div>
                
                <form action="{{ route('produksi.pemotongan.setor') }}" method="POST">
                    @csrf
                    <input type="hidden" name="distribusi_id" :value="selectedId">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Terima</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border p-2 rounded bg-gray-50">
                        </div>

                        <div class="bg-green-50 p-3 rounded border border-green-200">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Potongan Jadi (Pcs)</label>
                            <input type="number" name="jumlah_jadi" min="1" required class="w-full border p-2 rounded focus:ring-green-500 focus:border-green-500" placeholder="Contoh: 500">
                            <p class="text-xs text-gray-500 mt-1">Stok Cek akan bertambah sesuai angka ini.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Berat Limbah/Sisa (Kg) - Opsional</label>
                            <input type="number" step="0.1" name="berat_limbah" class="w-full border p-2 rounded" placeholder="0.0">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showModalSetor = false" class="px-4 py-2 bg-gray-100 rounded text-gray-600">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-gna-primary text-white rounded hover:bg-gna-dark">Simpan Hasil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection