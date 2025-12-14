@extends('layouts.app')
@section('title', 'Edit Profil')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Edit Profil</h1>
            <p class="text-gray-600 mt-2">Kelola informasi akun dan pengaturan keamanan Anda</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-start">
            <svg class="h-5 w-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-gna-primary to-gna-dark p-8 text-white">
                <div class="flex items-center gap-6">
                    <img class="h-20 w-20 rounded-full border-4 border-white shadow-lg" 
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0d9488&color=fff&size=128" 
                         alt="">
                    <div>
                        <h2 class="text-2xl font-bold">{{ auth()->user()->name }}</h2>
                        <p class="text-gna-light">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="p-8 space-y-8">
                
                <!-- Tab 1: Informasi Pribadi -->
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-6 pb-4 border-b border-gray-200">
                            Informasi Pribadi
                        </h3>

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name"
                                value="{{ old('name', auth()->user()->name) }}"
                                class="w-full px-4 py-2 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-gna-primary"
                                required
                            >
                            @error('name')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                value="{{ old('email', auth()->user()->email) }}"
                                class="w-full px-4 py-2 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-gna-primary"
                                required
                            >
                            @error('email')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200"></div>

                    <!-- Tab 2: Keamanan -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-6 pb-4 border-b border-gray-200">
                            Ubah Password
                        </h3>

                        <p class="text-sm text-gray-600 mb-6">
                            Kosongkan form password jika tidak ingin mengubah password
                        </p>

                        <!-- Current Password -->
                        <div class="mb-6">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Saat Ini
                            </label>
                            <input 
                                type="password" 
                                name="current_password" 
                                id="current_password"
                                class="w-full px-4 py-2 border {{ $errors->has('current_password') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-gna-primary"
                                placeholder="Masukkan password saat ini"
                            >
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                class="w-full px-4 py-2 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:outline-none focus:ring-2 focus:ring-gna-primary"
                                placeholder="Masukkan password baru"
                            >
                            @error('password')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gna-primary"
                                placeholder="Konfirmasi password baru"
                            >
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-6 border-t border-gray-200">
                        <button 
                            type="submit"
                            class="px-6 py-2 bg-gna-primary hover:bg-gna-dark text-white font-medium rounded-lg transition duration-200 flex items-center"
                        >
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a 
                            href="{{ route('dashboard') }}"
                            class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-200"
                        >
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
