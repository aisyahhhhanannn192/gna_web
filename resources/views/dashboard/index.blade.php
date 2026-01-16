@extends('layouts.app')
@section('title', 'Executive Dashboard')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="space-y-6">
        
        <div class="flex justify-between items-end">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
                <p class="text-gray-600">Ringkasan performa produksi & penjualan hari ini.</p>
            </div>
            <div class="text-right">
                <span class="text-sm text-gray-500 block">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-orange-100 text-orange-600 rounded-lg mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $total_pesanan ?? 0 }} <span class="text-xs font-normal text-gray-500">Order</span></h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-purple-100 text-purple-600 rounded-lg mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Stok Barang Jadi</p>
                    <h3 class="text-xl font-bold text-gray-800">{{ $stok_jadi }} <span class="text-xs font-normal text-gray-500">Pcs</span></h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-4">Top 5 Warna Terlaris</h3>
                <div id="chartWarna"></div>
            </div>

            <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold mb-4 flex items-center text-red-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Stok Kain Menipis
                </h3>
                
                <div class="space-y-3">
                    @forelse($stok_kritis as $kritis)
                    <div class="flex justify-between items-center p-3 bg-red-50 rounded border border-red-100">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full border" style="background-color: {{ $kritis->warna->kode_warna }}"></span>
                            <span class="text-sm font-medium text-gray-700">{{ $kritis->warna->nama_warna }}</span>
                        </div>
                        <span class="font-bold text-red-700">{{ $kritis->jumlah_gulungan }} Gulung</span>
                    </div>
                    @empty
                    <div class="text-center py-8 text-green-600">
                        <svg class="w-10 h-10 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm">Semua stok aman.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4">Produk Terlaris</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Peringkat</th>
                            <th class="px-6 py-3">Nama Produk</th>
                            <th class="px-6 py-3">Kode</th>
                            <th class="px-6 py-3 text-right">Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($top_produk as $index => $top)
                        <tr class="border-b">
                            <td class="px-6 py-4 font-bold text-gray-900">#{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $top->produk->nama_produk }}</td>
                            <td class="px-6 py-4 font-mono">{{ $top->produk->kode_produk }}</td>
                            <td class="px-6 py-4 text-right font-bold text-gna-primary">{{ $top->total_jual }} Pcs</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-4 text-center">Belum ada data penjualan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        var options = {
            series: [@json($warna_data ?? [])],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 4
                }
            },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: {
                categories: @json($warna_labels ?? []),
            },
            yaxis: {
                title: { text: 'Jumlah Terjual (Pcs)' }
            },
            fill: { opacity: 1 },
            colors: ['#0d9488', '#06b6d4', '#f59e0b', '#ef4444', '#8b5cf6'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " Pcs"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartWarna"), options);
        chart.render();
    </script>
@endsection
