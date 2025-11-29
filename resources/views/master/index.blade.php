@extends('layouts.app')
@section('title', 'Manajemen Master') @section('content')


    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Master</h1>
        <p class="text-gray-600">Kelola data master sistem</p>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div x-data="{ 
        activeTabMitra: 'korlap', 
        showModalKorlap: false,
        showModalReseller: false,
        showModalSupplier: false,
        showModalPemotong: false,
        showModalKaryawan: false 
    }" class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
        
        <div class="p-6 border-b border-gray-100 flex items-start space-x-4">
            <div class="p-3 bg-gna-light rounded-lg text-gna-primary">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Master Karyawan & Mitra</h2>
                <p class="text-sm text-gray-500">Kelola data Korlap, Reseller, Supplier, Pemotong, dan Karyawan Internal</p>
            </div>
        </div>

        <div class="p-6">
            <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg mb-6 overflow-x-auto">
                <button @click="activeTabMitra = 'korlap'" :class="{ 'bg-white text-gray-800 shadow-sm': activeTabMitra === 'korlap', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTabMitra !== 'korlap' }" class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap focus:outline-none">Korlap</button>
                <button @click="activeTabMitra = 'reseller'" :class="{ 'bg-white text-gray-800 shadow-sm': activeTabMitra === 'reseller', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTabMitra !== 'reseller' }" class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap focus:outline-none">Reseller</button>
                <button @click="activeTabMitra = 'supplier'" :class="{ 'bg-white text-gray-800 shadow-sm': activeTabMitra === 'supplier', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTabMitra !== 'supplier' }" class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap focus:outline-none">Supplier</button>
                <button @click="activeTabMitra = 'pemotong'" :class="{ 'bg-white text-gray-800 shadow-sm': activeTabMitra === 'pemotong', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTabMitra !== 'pemotong' }" class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap focus:outline-none">Pemotong</button>
                <button @click="activeTabMitra = 'packing'" :class="{ 'bg-white text-gray-800 shadow-sm': activeTabMitra === 'packing', 'text-gray-500 hover:text-gray-700 hover:bg-gray-50': activeTabMitra !== 'packing' }" class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 whitespace-nowrap focus:outline-none">Karyawan/Packing</button>
            </div>

            <div x-show="activeTabMitra === 'korlap'" x-cloak>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-gray-700 font-medium">Data Koordinator Lapangan</h3>
                    <button @click="showModalKorlap = true" class="bg-gna-primary hover:bg-gna-dark text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">Tambah Korlap</button>
                </div>
                <table class="w-full text-sm text-left text-gray-500 border rounded-lg">
                    <thead class="bg-gray-50"><tr><th class="px-4 py-2">Nama</th><th class="px-4 py-2">Kontak</th><th class="px-4 py-2">Alamat</th></tr></thead>
                    <tbody>
                        @forelse($korlaps as $k)
                        <tr class="border-b"><td class="px-4 py-2 font-medium text-gray-900">{{ $k->nama_korlap }}</td><td class="px-4 py-2">{{ $k->no_hp }}</td><td class="px-4 py-2">{{ $k->alamat }}</td></tr>
                        @empty <tr><td colspan="3" class="px-4 py-4 text-center">Kosong</td></tr> @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="activeTabMitra === 'reseller'" x-cloak>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-gray-700 font-medium">Data Reseller / Agen</h3>
                    <button @click="showModalReseller = true" class="bg-gna-primary hover:bg-gna-dark text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">Tambah Reseller</button>
                </div>
                <table class="w-full text-sm text-left text-gray-500 border rounded-lg">
                    <thead class="bg-gray-50"><tr><th class="px-4 py-2">Nama</th><th class="px-4 py-2">Area</th><th class="px-4 py-2">Kontak</th></tr></thead>
                    <tbody>
                        @forelse($resellers as $r)
                        <tr class="border-b"><td class="px-4 py-2 font-medium text-gray-900">{{ $r->nama_reseller }}</td><td class="px-4 py-2">{{ $r->area_wilayah }}</td><td class="px-4 py-2">{{ $r->no_hp }}</td></tr>
                        @empty <tr><td colspan="3" class="px-4 py-4 text-center">Kosong</td></tr> @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="activeTabMitra === 'supplier'" x-cloak>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-gray-700 font-medium">Data Supplier Kain</h3>
                    <button @click="showModalSupplier = true" class="bg-gna-primary hover:bg-gna-dark text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">Tambah Supplier</button>
                </div>
                <table class="w-full text-sm text-left text-gray-500 border rounded-lg">
                    <thead class="bg-gray-50"><tr><th class="px-4 py-2">Nama Supplier</th><th class="px-4 py-2">Kontak/Keterangan</th></tr></thead>
                    <tbody>
                        @forelse($suppliers as $s)
                        <tr class="border-b"><td class="px-4 py-2 font-medium text-gray-900">{{ $s->nama_supplier }}</td><td class="px-4 py-2">{{ $s->kontak }}</td></tr>
                        @empty <tr><td colspan="2" class="px-4 py-4 text-center">Kosong</td></tr> @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="activeTabMitra === 'pemotong'" x-cloak>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-gray-700 font-medium">Data Mitra Pemotong</h3>
                    <button @click="showModalPemotong = true" class="bg-gna-primary hover:bg-gna-dark text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">Tambah Pemotong</button>
                </div>
                <table class="w-full text-sm text-left text-gray-500 border rounded-lg">
                    <thead class="bg-gray-50"><tr><th class="px-4 py-2">Nama Pemotong</th><th class="px-4 py-2">Kontak</th><th class="px-4 py-2">Alamat</th></tr></thead>
                    <tbody>
                        @forelse($pemotongs as $p)
                        <tr class="border-b"><td class="px-4 py-2 font-medium text-gray-900">{{ $p->nama_pemotong }}</td><td class="px-4 py-2">{{ $p->no_hp }}</td><td class="px-4 py-2">{{ $p->alamat }}</td></tr>
                        @empty <tr><td colspan="3" class="px-4 py-4 text-center">Kosong</td></tr> @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="activeTabMitra === 'packing'" x-cloak>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-gray-700 font-medium">Data Karyawan Internal</h3>
                    <button @click="showModalKaryawan = true" class="bg-gna-primary hover:bg-gna-dark text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">Tambah Karyawan</button>
                </div>
                <table class="w-full text-sm text-left text-gray-500 border rounded-lg">
                    <thead class="bg-gray-50"><tr><th class="px-4 py-2">Nama</th><th class="px-4 py-2">Posisi</th><th class="px-4 py-2">Kontak</th></tr></thead>
                    <tbody>
                        @forelse($karyawans as $kry)
                        <tr class="border-b">
                            <td class="px-4 py-2 font-medium text-gray-900">{{ $kry->nama_karyawan }}</td>
                            <td class="px-4 py-2"><span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded">{{ $kry->posisi }}</span></td>
                            <td class="px-4 py-2">{{ $kry->no_hp ?? '-' }}</td>
                        </tr>
                        @empty <tr><td colspan="3" class="px-4 py-4 text-center">Kosong</td></tr> @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="showModalKorlap" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalKorlap = false"></div>
                <div class="relative min-h-screen flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl">
                        <h3 class="text-lg font-bold mb-4">Tambah Korlap</h3>
                        <form action="{{ route('master.korlap.store') }}" method="POST">@csrf
                            <input name="nama_korlap" class="w-full border p-2 mb-2 rounded" placeholder="Nama" required>
                            <input name="no_hp" class="w-full border p-2 mb-2 rounded" placeholder="No HP">
                            <textarea name="alamat" class="w-full border p-2 mb-4 rounded" placeholder="Alamat"></textarea>
                            <button type="submit" class="bg-gna-primary text-white px-4 py-2 rounded w-full">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="showModalReseller" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalReseller = false"></div>
                <div class="relative min-h-screen flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl">
                        <h3 class="text-lg font-bold mb-4">Tambah Reseller</h3>
                        <form action="{{ route('master.reseller.store') }}" method="POST">@csrf
                            <input name="nama_reseller" class="w-full border p-2 mb-2 rounded" placeholder="Nama Reseller" required>
                            <input name="area_wilayah" class="w-full border p-2 mb-2 rounded" placeholder="Area (Misal: Bandung)">
                            <input name="no_hp" class="w-full border p-2 mb-4 rounded" placeholder="Kontak">
                            <button type="submit" class="bg-gna-primary text-white px-4 py-2 rounded w-full">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="showModalSupplier" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalSupplier = false"></div>
                <div class="relative min-h-screen flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl">
                        <h3 class="text-lg font-bold mb-4">Tambah Supplier</h3>
                        <form action="{{ route('master.supplier.store') }}" method="POST">@csrf
                            <input name="nama_supplier" class="w-full border p-2 mb-2 rounded" placeholder="Nama Supplier" required>
                            <input name="kontak" class="w-full border p-2 mb-4 rounded" placeholder="Info Kontak">
                            <button type="submit" class="bg-gna-primary text-white px-4 py-2 rounded w-full">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="showModalPemotong" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalPemotong = false"></div>
                <div class="relative min-h-screen flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl">
                        <h3 class="text-lg font-bold mb-4">Tambah Mitra Pemotong</h3>
                        <form action="{{ route('master.pemotong.store') }}" method="POST">@csrf
                            <input name="nama_pemotong" class="w-full border p-2 mb-2 rounded" placeholder="Nama Pemotong" required>
                            <input name="no_hp" class="w-full border p-2 mb-2 rounded" placeholder="Kontak">
                            <textarea name="alamat" class="w-full border p-2 mb-4 rounded" placeholder="Alamat"></textarea>
                            <button type="submit" class="bg-gna-primary text-white px-4 py-2 rounded w-full">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="showModalKaryawan" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalKaryawan = false"></div>
                <div class="relative min-h-screen flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl">
                        <h3 class="text-lg font-bold mb-4">Tambah Karyawan</h3>
                        <form action="{{ route('master.karyawan.store') }}" method="POST">@csrf
                            <input name="nama_karyawan" class="w-full border p-2 mb-2 rounded" placeholder="Nama Lengkap" required>
                            <select name="posisi" class="w-full border p-2 mb-2 rounded bg-white">
                                <option value="Packing">Bagian Packing</option>
                                <option value="Gudang">Kepala Gudang</option>
                                <option value="Supir">Supir / Driver</option>
                                <option value="Admin">Admin Kantor</option>
                            </select>
                            <input name="no_hp" class="w-full border p-2 mb-4 rounded" placeholder="Kontak HP">
                            <button type="submit" class="bg-gna-primary text-white px-4 py-2 rounded w-full">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div x-data="{ activeTabProduk: 'jenis', showModalProduk: false, showModalWarna: false }" class="bg-white rounded-xl shadow-sm border border-gray-100">
        
        <div class="p-6 border-b border-gray-100 flex items-start space-x-4">
            <div class="p-3 bg-gna-light rounded-lg text-gna-primary">
                 <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Master Produk & Atribut</h2>
                <p class="text-sm text-gray-500">Data jenis produk dan varian warna bahan</p>
            </div>
        </div>

        <div class="p-6">
            <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg mb-6">
                <button @click="activeTabProduk = 'jenis'" :class="{ 'bg-white text-gray-800 shadow-sm': activeTabProduk === 'jenis', 'text-gray-500 hover:text-gray-700': activeTabProduk !== 'jenis' }" class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 focus:outline-none">
                    Jenis Produk
                </button>
                <button @click="activeTabProduk = 'warna'" :class="{ 'bg-white text-gray-800 shadow-sm': activeTabProduk === 'warna', 'text-gray-500 hover:text-gray-700': activeTabProduk !== 'warna' }" class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-all duration-200 focus:outline-none">
                    Warna
                </button>
            </div>

            <div x-show="activeTabProduk === 'jenis'" x-cloak>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-gray-700 font-medium">Daftar Jenis Produk</h3>
                    <button @click="showModalProduk = true" class="bg-gna-primary hover:bg-gna-dark text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-colors">Tambah Jenis Produk</button>
                </div>

                <div class="overflow-x-auto relative sm:rounded-lg border border-gray-100">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50"><tr><th class="px-6 py-3">No</th><th class="px-6 py-3">Nama Jenis</th><th class="px-6 py-3">Estimasi</th><th class="px-6 py-3 text-right">Aksi</th></tr></thead>
                        <tbody>
                          @forelse($produks as $index => $p)
                          <tr class="bg-white border-b hover:bg-gray-50">
                              <td class="px-6 py-4">{{ $index + 1 }}</td>
                              <td class="px-6 py-4 font-medium text-gray-900">
                                  {{ $p->nama_produk }}
                                  <span class="ml-2 bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded font-mono">{{ $p->kode_produk }}</span>
                              </td>
                              <td class="px-6 py-4">{{ $p->estimasi_pcs_per_gulung }} pcs/gulung</td>
                              <td class="px-6 py-4 text-right"><button class="text-red-600 hover:text-red-900">Hapus</button></td>
                          </tr>
                          @empty <tr><td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada jenis produk.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="activeTabProduk === 'warna'" x-cloak>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-gray-700 font-medium">Daftar Pilihan Warna</h3>
                    <button @click="showModalWarna = true" class="bg-gna-primary hover:bg-gna-dark text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center transition-colors">Tambah Warna</button>
                </div>

                <div class="overflow-x-auto relative sm:rounded-lg border border-gray-100">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50"><tr><th class="px-6 py-3">No</th><th class="px-6 py-3">Nama Warna</th><th class="px-6 py-3">Kode Hex</th><th class="px-6 py-3 text-right">Aksi</th></tr></thead>
                        <tbody>
                          @forelse($warnas as $index => $w)
                          <tr class="bg-white border-b hover:bg-gray-50">
                              <td class="px-6 py-4">{{ $index + 1 }}</td>
                              <td class="px-6 py-4 font-medium text-gray-900 flex items-center gap-2">
                                  <span class="w-4 h-4 rounded-full border border-gray-200" style="background-color: {{ $w->kode_warna ?? '#eeeeee' }};"></span>
                                  {{ $w->nama_warna }}
                              </td>
                              <td class="px-6 py-4 font-mono text-xs">{{ $w->kode_warna ?? '-' }}</td>
                              <td class="px-6 py-4 text-right"><button class="text-red-600 hover:text-red-900">Hapus</button></td>
                          </tr>
                          @empty <tr><td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada data warna.</td></tr> @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div x-show="showModalProduk" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalProduk = false"></div>
                <div class="relative min-h-screen flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl">
                        <h3 class="text-lg font-bold mb-4">Tambah Jenis Produk</h3>
                        <form action="{{ route('master.produk.store') }}" method="POST">@csrf
                            <input name="nama_produk" class="w-full border p-2 mb-2 rounded" placeholder="Nama Produk (e.g. Jas Hujan Ponco)" required>
                            <input name="kode_produk" class="w-full border p-2 mb-2 rounded uppercase" placeholder="KODE SINGKAT (e.g. PONCO)" required>
                            <input type="number" name="estimasi_pcs_per_gulung" class="w-full border p-2 mb-4 rounded" value="50" placeholder="Estimasi Pcs">
                            <button type="submit" class="bg-gna-primary text-white px-4 py-2 rounded w-full">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="showModalWarna" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
                <div class="fixed inset-0 bg-black bg-opacity-50" @click="showModalWarna = false"></div>
                <div class="relative min-h-screen flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-xl">
                        <h3 class="text-lg font-bold mb-4">Tambah Warna</h3>
                        <form action="{{ route('master.warna.store') }}" method="POST">@csrf
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Warna</label>
                            <input name="nama_warna" class="w-full border p-2 mb-4 rounded" placeholder="Contoh: Merah Maroon, Biru Dongker" required>
                            
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Hex (Opsional - Untuk Visual)</label>
                            <div class="flex items-center gap-2 mb-6">
                                <input type="color" x-ref="colorPicker" class="h-10 w-10 p-0 border-0 rounded cursor-pointer" onchange="document.getElementById('hexInput').value = this.value">
                                <input id="hexInput" name="kode_warna" class="w-full border p-2 rounded font-mono uppercase" placeholder="#000000">
                            </div>

                            <button type="submit" class="bg-gna-primary text-white px-4 py-2 rounded w-full">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection