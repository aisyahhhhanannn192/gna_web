<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GNA Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <!-- Left Side - Branding -->
                <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-gna-primary to-gna-dark text-white flex-col justify-between p-12 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>

        <!-- Logo & Branding -->
        <div class="relative z-10">
            <div class="inline-block p-3 bg-white bg-opacity-20 rounded-lg mb-6 backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-3">Sistem Manajemen GNA</h1>
            <p class="text-gna-light text-lg">Kelola Bahan & Distribusi dengan Efisien</p>
        </div>

        <!-- Features List -->
        <div class="relative z-10 space-y-4">
            <div class="flex items-start gap-4">
                <div class="p-2 bg-white bg-opacity-20 rounded-lg flex-shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Manajemen Bahan</h3>
                    <p class="text-gna-light text-sm">Kelola stok bahan kain dengan mudah</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="p-2 bg-white bg-opacity-20 rounded-lg flex-shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Distribusi Produksi</h3>
                    <p class="text-gna-light text-sm">Pantau distribusi ke pemotong & korlap</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="p-2 bg-white bg-opacity-20 rounded-lg flex-shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-lg">Laporan Real-time</h3>
                    <p class="text-gna-light text-sm">Dashboard dengan analisis mendalam</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="relative z-10 border-t border-white border-opacity-20 pt-6">
            <p class="text-sm text-gna-light">© 2025 Sistem Manajemen GNA</p>
        </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="w-full lg:w-1/2 flex items-center justify-center p-10">
                    <div class="w-full max-w-md">
            <!-- Mobile Header (visible on small screens) -->
            <div class="lg:hidden text-center mb-8">
                <div class="inline-block p-3 bg-gna-light rounded-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gna-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">GNA Dashboard</h1>
                <p class="text-gray-600 mt-2">Sistem Manajemen Bahan & Distribusi</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Masuk</h2>
                    <p class="text-gray-600 text-sm mt-2">Gunakan akun Anda untuk mengakses sistem</p>
                </div>

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2.5 border {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-gna-primary' }} rounded-lg focus:outline-none focus:ring-2 transition"
                            placeholder="nama@email.com"
                            required
                        >
                        @error('email')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="w-full px-4 py-2.5 border {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-gna-primary' }} rounded-lg focus:outline-none focus:ring-2 transition"
                            placeholder="••••••••"
                            required
                        >
                        @error('password')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            id="remember"
                            class="h-4 w-4 text-gna-primary focus:ring-gna-primary border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Button Login -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-gna-primary to-gna-dark hover:from-gna-dark hover:to-gna-primary text-white font-bold py-2.5 rounded-lg transition duration-200 shadow-md hover:shadow-lg"
                    >
                        Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-500">Akun Demo</span>
                    </div>
                </div>

                <!-- Demo Credentials -->
                <div class="p-4 bg-gna-light border border-gna-primary border-opacity-20 rounded-lg text-sm text-gray-700 space-y-1">
                    <div><span class="font-semibold">Email:</span> <code class="text-xs bg-white px-2 py-1 rounded">admin@gna.com</code></div>
                    <div><span class="font-semibold">Password:</span> <code class="text-xs bg-white px-2 py-1 rounded">password</code></div>
                </div>
            </div>

            <!-- Footer -->
                        <p class="text-center text-xs text-gray-500 mt-6">
                                Sistem v1.0 • © 2025 GNA
                        </p>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
