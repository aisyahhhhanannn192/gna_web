@extends('layouts.app')
@section('title', 'Executive Dashboard')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="space-y-6">
        
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Executive</h1>
                <p class="text-gray-600 mt-1">Ringkasan performa produksi & penjualan secara real-time</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                <p class="text-xs text-gray-400 mt-1">Update terakhir: Sekarang</p>
            </div>
        </div>

        <!-- KPI Cards Row 1 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Total Transaksi Penjualan -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl shadow-sm border border-blue-200 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total Penjualan</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $total_penjualan ?? 0 }} <span class="text-xs font-normal text-gray-500">Transaksi</span></h3>
                        <p class="text-xs text-gray-500 mt-1">Periode Aktif</p>
                    </div>
                    <div class="p-3 bg-blue-600 text-white rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Stok Barang Jadi -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl shadow-sm border border-purple-200 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Stok Barang Jadi</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $stok_jadi ?? 0 }} <span class="text-xs font-normal text-gray-500">Pcs</span></h3>
                        <p class="text-xs text-gray-500 mt-1">Siap Distribusi</p>
                    </div>
                    <div class="p-3 bg-purple-600 text-white rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Stok Bahan Kain -->
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl shadow-sm border border-yellow-200 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Stok Bahan Kain</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $stok_bahan ?? 0 }} <span class="text-xs font-normal text-gray-500">Gulung</span></h3>
                        <p class="text-xs text-gray-500 mt-1">Baku Produksi</p>
                    </div>
                    <div class="p-3 bg-yellow-600 text-white rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10M8 7l4 2m8 0l-4-2M8 7l4 2m0 0l4-2M12 11v6m0 0l4-2m-4 2l-4-2"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Total Distribusi Pemotong -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl shadow-sm border border-green-200 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Produksi Berjalan</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $distribusi_aktif ?? 0 }} <span class="text-xs font-normal text-gray-500">Proses</span></h3>
                        <p class="text-xs text-gray-500 mt-1">Pemotong & Korlap</p>
                    </div>
                    <div class="p-3 bg-green-600 text-white rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
            </div>
        </div>


        <!-- Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Chart Warna Terlaris -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-900">Top 5 Warna Terlaris</h3>
                    <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Periode Aktif</span>
                </div>
                <div id="chartWarna"></div>
            </div>

            <!-- Status Produksi & Alert -->
            <div class="space-y-4">
                <!-- Alert Stok Kritis -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold mb-4 flex items-center text-red-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Stok Kain Menipis
                    </h3>
                    
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @forelse($stok_kritis as $kritis)
                        <div class="flex justify-between items-center p-3 bg-red-50 rounded border border-red-100 hover:bg-red-100 transition">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full" style="background-color: {{ $kritis->warna->kode_warna ?? '#ccc' }}; border: 1px solid #999;"></span>
                                <span class="text-sm font-medium text-gray-700">{{ $kritis->warna->nama_warna }}</span>
                            </div>
                            <span class="font-bold text-red-700 text-sm">{{ $kritis->jumlah_gulungan }} Gl</span>
                        </div>
                        @empty
                        <div class="text-center py-6 text-green-600">
                            <svg class="w-10 h-10 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-sm font-medium">Semua stok aman ✓</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Status Ringkas -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-sm space-y-2">
                    <div class="flex justify-between items-center py-2 border-b">
                        <span class="text-gray-600">Distribusi Pemotong</span>
                        <span class="font-bold text-gray-900">{{ $dist_pemotong_proses ?? 0 }} 🔄</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Distribusi Korlap</span>
                        <span class="font-bold text-gray-900">{{ $dist_korlap_proses ?? 0 }} 🧵</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg text-gray-900">Produk Terlaris</h3>
                    <p class="text-xs text-gray-500 mt-1">Top 10 produk berdasarkan volume penjualan</p>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua →</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-900">#</th>
                            <th class="px-6 py-4 font-semibold text-gray-900">Nama Produk</th>
                            <th class="px-6 py-4 font-semibold text-gray-900">Kode</th>
                            <th class="px-6 py-4 font-semibold text-gray-900 text-right">Total Terjual</th>
                            <th class="px-6 py-4 font-semibold text-gray-900 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($top_produk as $index => $top)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-700 rounded-full font-semibold text-xs">{{ $index + 1 }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $top->produk->nama_produk ?? '-' }}</td>
                            <td class="px-6 py-4 font-mono text-gray-700">{{ $top->produk->kode_produk ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    {{ $top->total_jual ?? 0 }} Pcs
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    ✓ Aktif
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                Belum ada data penjualan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Distribusi & Setor Status -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Distribusi Pemotong -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-bold text-lg text-gray-900">Distribusi Pemotong</h3>
                    <p class="text-xs text-gray-500 mt-1">Status produksi potong terkini</p>
                </div>
                
                <div class="divide-y max-h-64 overflow-y-auto">
                    @forelse($dist_pemotong_recent as $dist)
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $dist->no_surat_jalan }}</p>
                                <p class="text-xs text-gray-500">{{ $dist->pemotong->nama_pemotong ?? '-' }}</p>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $dist->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($dist->status) }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ $dist->produk->nama_produk }} • {{ $dist->jumlah_gulungan_keluar }} Gulung
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">
                        <p class="text-sm">Tidak ada distribusi pemotong</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Distribusi Korlap -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-bold text-lg text-gray-900">Distribusi Korlap</h3>
                    <p class="text-xs text-gray-500 mt-1">Status produksi jahit terkini</p>
                </div>
                
                <div class="divide-y max-h-64 overflow-y-auto">
                    @forelse($dist_korlap_recent as $dist)
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $dist->no_nota }}</p>
                                <p class="text-xs text-gray-500">{{ $dist->korlap->nama_korlap ?? '-' }}</p>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $dist->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst(str_replace('_', ' ', $dist->status)) }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ $dist->produk->nama_produk }} • {{ $dist->jumlah_cek_keluar }} Pcs
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">
                        <p class="text-sm">Tidak ada distribusi korlap</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <script>
        // Chart Warna Terlaris
        var options = {
            series: [{
                name: 'Total Terjual',
                data: @json($warna_data ?? [])
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    borderRadius: 8,
                    dataLabels: { position: 'top' }
                }
            },
            dataLabels: { 
                enabled: true,
                formatter: function (val) {
                    return val + " Pcs";
                },
                offsetY: -20,
                style: {
                    fontSize: '11px',
                    fontWeight: 600,
                    colors: ["#374151"]
                }
            },
            stroke: { 
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($warna_labels ?? []),
                labels: { 
                    style: { 
                        fontSize: '12px', 
                        colors: '#6B7280',
                        fontWeight: 500
                    }
                }
            },
            yaxis: {
                title: { 
                    text: 'Jumlah Terjual (Pcs)', 
                    style: { 
                        fontSize: '13px',
                        fontWeight: 600,
                        color: '#374151'
                    }
                },
                labels: { 
                    style: { 
                        fontSize: '12px', 
                        colors: '#6B7280' 
                    },
                    formatter: function (val) {
                        return Math.round(val);
                    }
                }
            },
            fill: { 
                opacity: 1,
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.2,
                    opacityFrom: 0.95,
                    opacityTo: 0.85,
                    stops: [0, 100]
                }
            },
            colors: ['#0d9488'],
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return val + " Pcs";
                    }
                },
                style: {
                    fontSize: '12px'
                }
            },
            grid: { 
                borderColor: '#E5E7EB',
                strokeDashArray: 3,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } }
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    plotOptions: {
                        bar: {
                            columnWidth: '70%'
                        }
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chartWarna"), options);
        chart.render();
    </script>
@endsection
