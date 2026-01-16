<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen GNA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gna: {
                            primary: '#0d9488', // Warna teal/cyan utama
                            light: '#ccfbf1',   // Warna latar tab aktif
                            dark: '#115e59',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; } /* Menyembunyikan elemen Alpine sebelum dimuat */
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:block fixed h-full">
            <div class="p-6">
                <div class="flex items-center space-x-2">
                    <div class="p-2 bg-gna-primary rounded-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight">Sistem Manajemen</h1>
                        <p class="text-xs text-gray-500">Bahan & Distribusi</p>
                    </div>
                </div>
            </div>

            <nav class="mt-6 px-4 space-y-1">
                
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                class="flex items-center px-4 py-3 rounded-lg group transition-colors {{ request()->routeIs('dashboard') ? 'bg-gna-light text-gna-primary font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-gna-primary' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>

                <!-- Manajemen Bahan -->
                <a href="{{ route('bahan.index') }}" 
                class="flex items-center px-4 py-3 rounded-lg group transition-colors {{ request()->routeIs('bahan.*') ? 'bg-gna-light text-gna-primary font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('bahan.*') ? 'text-gna-primary' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Manajemen Bahan
                </a>

                <!-- Distribusi Pemotong -->
                <a href="{{ route('produksi.pemotongan.index') }}" 
                class="flex items-center px-4 py-3 rounded-lg group transition-colors {{ request()->routeIs('produksi.pemotongan.*') ? 'bg-gna-light text-gna-primary font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('produksi.pemotongan.*') ? 'text-gna-primary' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Distribusi Pemotong
                </a>

                <!-- Distribusi Korlap -->
                <a href="{{ route('produksi.perakitan.index') }}" 
                class="flex items-center px-4 py-3 rounded-lg group transition-colors {{ request()->routeIs('produksi.perakitan.*') ? 'bg-gna-light text-gna-primary font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('produksi.perakitan.*') ? 'text-gna-primary' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Distribusi Korlap
                </a>

                <!-- Distribusi Reseller -->
                <a href="{{ route('penjualan.index') }}" 
                class="flex items-center px-4 py-3 rounded-lg group transition-colors {{ request()->routeIs('penjualan.*') ? 'bg-gna-light text-gna-primary font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('penjualan.*') ? 'text-gna-primary' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Distribusi Reseller
                </a>

                <!-- Manajemen Master -->
                <a href="{{ route('master.index') }}" 
                class="flex items-center px-4 py-3 rounded-lg group transition-colors {{ request()->routeIs('master.*') ? 'bg-gna-light text-gna-primary font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('master.*') ? 'text-gna-primary' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Manajemen Master
                </a>

            </nav>
            
            <div class="absolute bottom-0 w-full p-6 text-xs text-gray-400">
                <p>Sistem v1.0</p>
                <p>© 2025 Manajemen Bahan</p>
            </div>
        </aside>

        <main class="flex-1 md:ml-64">
             <header class="bg-white shadow-sm border-b border-gray-200 px-8 py-4 flex justify-between items-center">
                 <div class="flex items-center text-gray-800">
                    <svg class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <h2 class="text-xl font-semibold">@yield('title', 'Sistem GNA')</h2>
                 </div>
                 <div class="flex items-center gap-4">
                     <div class="text-right text-sm">
                        <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                     </div>
                     <div class="relative group">
                        <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0d9488&color=fff" alt="">
                        </button>
                        <div class="absolute right-0 mt-0 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <!-- Edit Profile -->
                            <a href="{{ route('profile.edit') }}" class="px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100 flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Profil
                            </a>
                            
                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                     </div>
                 </div>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>