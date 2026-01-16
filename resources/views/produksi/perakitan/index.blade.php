@extends('layouts.app')
@section('title', 'Distribusi Jahit (Korlap)')

@section('content')
<div x-data="{ showModal: false, showModalSetor: false, selectedId: null, selectedNoNota: '' }">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Distribusi Ke Korlap</h1>
            <p class="text-gray-600">Manajemen pengerjaan jahit (Assembly)</p>
        </div>
        <button @click="showModal = true" class="bg-gna-primary hover:bg-gna-dark text-white px-5 py-2.5 rounded-lg shadow-sm font-medium flex items-center transition-transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Nota Jahit
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
                    <svg class="w-5 h-5 mr-2 text-gna-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    Stok Cek (Siap Jahit)
                </h3>
                <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($stok_ready as $s)
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-100 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $s->produk->nama_produk }}</p>
                                <div class="flex items-center mt-1">
                                    <span class="w-3 h-3 rounded-full border border-gray-300 mr-2" style="background-color: {{ $s->warna->kode_warna }}"></span>
                                    <span class="text-xs text-gray-600">{{ $s->warna->nama_warna }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="block text-xl font-bold text-blue-700">{{ $s->jumlah_stok }}</span>
                                <span class="text-[10px] uppercase font-bold text-blue-400">Pcs</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-400 text-sm border-2 border-dashed border-gray-200 rounded-lg">
                        <p>Tidak ada stok cek.</p>
                        <p class="text-xs mt-1">Tunggu pemotong setor barang.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-sm text-yellow-800">
                <p><strong>Tips:</strong> Stok di atas adalah akumulasi dari setoran pemotong yang belum dibagikan ke penjahit.</p>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Riwayat Pekerjaan Berjalan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">Nota / Tgl</th>
                                <th class="px-6 py-3">Korlap</th>
                                <th class="px-6 py-3">Detail Barang</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                              @forelse($riwayat as $d)
                              
                              @php
                                  // Hitung Progres
                                  $total_jadi  = $d->setoran->sum('jumlah_pcs_jadi');
                                  $total_afkir = $d->setoran->sum('jumlah_afkir');
                                  $total_proses = $total_jadi + $total_afkir;
                                  $sisa_pending = $d->jumlah_cek_keluar - $total_proses;
                                  $persen = $d->jumlah_cek_keluar > 0 ? round(($total_proses / $d->jumlah_cek_keluar) * 100) : 0;
                                  
                                  // Konversi Tampilan Kodi
                                  $t_kodi = floor($d->jumlah_cek_keluar / 20);
                                  $t_sisa = $d->jumlah_cek_keluar % 20;
                              @endphp

                              <tr class="border-b hover:bg-gray-50 transition-colors">
                                  <td class="px-6 py-4">
                                      <div class="font-mono font-bold text-gray-800">{{ $d->no_nota }}</div>
                                      <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($d->tanggal_distribusi)->format('d/m/y') }}</div>
                                  </td>
                                  <td class="px-6 py-4 font-medium">{{ $d->korlap->nama_korlap }}</td>
                                  <td class="px-6 py-4">
                                      <div class="text-gray-900 font-medium">{{ $d->produk->nama_produk }}</div>
                                      <div class="flex items-center gap-2 mt-1 mb-2 text-xs text-gray-500">
                                          <span class="w-2 h-2 rounded-full border" style="background-color: {{ $d->warna->kode_warna }}"></span>
                                          {{ $d->warna->nama_warna }}
                                      </div>

                                      <div class="mb-2 bg-blue-50 px-2 py-1 rounded w-fit text-xs text-blue-800 border border-blue-100">
                                          <strong>Target:</strong> {{ $t_kodi }} Kodi 
                                          @if($t_sisa > 0) + {{ $t_sisa }} Pcs @endif
                                      </div>

                                      <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1">
                                          <div class="bg-gna-primary h-1.5 rounded-full" style="width: {{ $persen }}%"></div>
                                      </div>
                                      <div class="flex text-[10px] gap-2 font-medium">
                                          <span class="text-green-600">Jadi: {{ $total_jadi }}</span>
                                          <span class="text-red-600">Afkir: {{ $total_afkir }}</span>
                                          <span class="text-yellow-600 bg-yellow-50 px-1 rounded">Pending: {{ $sisa_pending }}</span>
                                      </div>
                                  </td>
                                  <td class="px-6 py-4 text-center">
                                      @if($d->status == 'sedang_dikerjakan')
                                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                              Proses ({{ $persen }}%)
                                          </span>
                                      @else
                                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                                      @endif
                                  </td>
                                  <td class="px-6 py-4 text-right">
                                      @if($d->status == 'sedang_dikerjakan')
                                          <button 
                                              @click="
                                                  selectedId = {{ $d->id }}; 
                                                  selectedNoNota = '{{ $d->no_nota }}'; 
                                                  showModalSetor = true
                                              "
                                              class="text-white bg-blue-600 hover:bg-blue-700 font-medium text-xs px-3 py-1.5 rounded shadow-sm transition-colors"
                                          >
                                              Terima QC
                                          </button>
                                      @endif
                                  </td>
                              </tr>
                              @empty
                              <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada distribusi.</td></tr>
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
                <h3 class="text-lg font-bold mb-4">Buat Nota Jahit Baru</h3>
                <form action="{{ route('produksi.perakitan.store') }}" method="POST" x-data="{ stokSelected: '' }">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border p-2 rounded bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pilih Korlap</label>
                            <select name="korlap_id" required class="w-full border p-2 rounded">
                                <option value="">-- Pilih Korlap --</option>
                                @foreach($korlaps as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_korlap }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <label class="block text-sm font-bold text-blue-800 mb-2">Ambil Stok Cek</label>
                            <select x-model="stokSelected" class="w-full border p-2 rounded mb-3 bg-white" 
                                @change="
                                    let parts = stokSelected.split('|');
                                    document.getElementById('p_id').value = parts[0];
                                    document.getElementById('w_id').value = parts[1];
                                ">
                                <option value="">-- Pilih Barang Siap Jahit --</option>
                                @foreach($stok_ready as $s)
                                    <option value="{{ $s->produk_id }}|{{ $s->warna_id }}">
                                        {{ $s->produk->nama_produk }} - {{ $s->warna->nama_warna }} (Sisa: {{ $s->jumlah_stok }})
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
                                               class="w-full border p-2 rounded text-lg font-bold text-blue-900 text-center">
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
                        <button type="submit" class="px-4 py-2 bg-gna-primary text-white rounded hover:bg-gna-dark shadow-md">Terbitkan Nota</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="showModalSetor" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalSetor = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-lg">
                <div class="mb-5 border-b pb-3">
                    <h3 class="text-lg font-bold text-gray-900">QC Hasil Jahitan</h3>
                    <p class="text-sm text-gray-500">Nota: <span class="font-mono font-bold text-gray-800" x-text="selectedNoNota"></span></p>
                </div>
                
                <form action="{{ route('produksi.perakitan.setor') }}" method="POST">
                    @csrf
                    <input type="hidden" name="distribusi_id" :value="selectedId">

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Terima</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border p-2 rounded bg-gray-50">
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div class="bg-green-50 p-3 rounded-lg border border-green-200 text-center">
                                <label class="block text-xs font-bold text-green-700 uppercase mb-2">Lolos QC</label>
                                <input type="number" name="jumlah_jadi" value="0" min="0" required class="w-full text-center border-gray-300 rounded focus:ring-green-500 focus:border-green-500 font-bold text-xl text-green-700 h-12">
                            </div>
                            <div class="bg-red-50 p-3 rounded-lg border border-red-200 text-center">
                                <label class="block text-xs font-bold text-red-700 uppercase mb-2">Afkir</label>
                                <input type="number" name="jumlah_afkir" value="0" min="0" required class="w-full text-center border-gray-300 rounded focus:ring-red-500 focus:border-red-500 font-bold text-xl text-red-700 h-12">
                            </div>
                            <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200 text-center">
                                <label class="block text-xs font-bold text-yellow-700 uppercase mb-2">Pending</label>
                                <input type="number" name="jumlah_pending" value="0" min="0" required class="w-full text-center border-gray-300 rounded focus:ring-yellow-500 focus:border-yellow-500 font-bold text-xl text-yellow-700 h-12">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan QC</label>
                            <textarea name="catatan" rows="2" class="w-full border p-2 rounded bg-gray-50" placeholder="Keterangan reject atau pending..."></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="showModalSetor = false" class="px-4 py-2 bg-gray-100 rounded text-gray-600">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-gna-primary text-white rounded hover:bg-gna-dark shadow-md">Simpan QC</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection