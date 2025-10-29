@extends('layouts.app-tailwind')

@section('content')

<style>
/* Additional safety for text decorations */
.no-underline * {
    text-decoration: none !important;
    border-bottom: none !important;
}
</style>

<div class="min-h-screen bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 flex items-center justify-center py-8 px-4 no-underline">
    <div class="max-w-6xl mx-auto w-full">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-12 text-center">
                <img src="{{ asset('images/yasfat.png') }}" alt="Logo SMK Fatahillah" class="w-24 h-24 mx-auto mb-6 object-contain">
                <h1 class="text-4xl font-bold text-white mb-2 no-underline">Sistem Pengumpulan Handphone</h1>
                <p class="text-xl text-blue-100 no-underline">SMK Fatahillah Cileungsi</p>
            </div>

            <!-- Main Content -->
            <div class="px-8 py-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Features Section -->
                    <div class="space-y-8">
                        <div class="text-center lg:text-left">
                            <h2 class="text-3xl font-bold text-gray-800 mb-4 no-underline">Cara Penggunaan</h2>
                            <p class="text-lg text-gray-600 no-underline">Panduan singkat cara menggunakan sistem pengumpulan dan pengambilan HP di SMK Fatahillah.</p>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt text-blue-600 text-xl no-underline"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2 no-underline">Login Sistem</h3>
                                    <p class="text-gray-600 no-underline">Masuk menggunakan NIS untuk akses sistem</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-mobile-alt text-green-600 text-xl no-underline"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2 no-underline">Serahkan/Ambil HP</h3>
                                    <p class="text-gray-600 no-underline">Scan QR code untuk menyerahkan atau mengambil HP</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-history text-purple-600 text-xl no-underline"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2 no-underline">Cek Riwayat</h3>
                                    <p class="text-gray-600 no-underline">Lihat histori pengumpulan dan pengambilan HP</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Login Form -->
                    <div class="w-full">
                        <div class="bg-gray-50 rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                            <div class="text-center mb-8">
                                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-lock text-white text-xl no-underline"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 no-underline">Login Sistem</h3>
                            </div>

                            @if(session('error'))
                                <div class="mb-6 bg-red-50 border-l-4 border-red-400 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-circle text-red-500 text-xl no-underline"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-red-800 font-medium no-underline">{{ session('error') }}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <button type="button" class="text-red-400 hover:text-red-600 no-underline" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                                                <i class="fas fa-times no-underline"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                                @csrf
                                
                                <div>
                                    <label for="login_id" class="block text-sm font-semibold text-gray-700 mb-2 no-underline">NIS / Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400 no-underline"></i>
                                        </div>
                                        <input id="login_id" type="text" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('login_id') border-red-500 @enderror no-underline"
                                               name="login_id" value="{{ old('login_id') }}" required autofocus
                                               placeholder="Masukkan NIS / Email"
                                               style="text-decoration: none !important;">
                                    </div>
                                    @error('login_id')
                                        <p class="mt-1 text-sm text-red-600 no-underline">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 no-underline">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400 no-underline"></i>
                                        </div>
                                        <input id="password" type="password" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror no-underline"
                                               name="password" required placeholder="Masukkan password"
                                               style="text-decoration: none !important;">
                                    </div>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600 no-underline">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" id="remember" name="remember">
                                    <label for="remember" class="ml-2 text-sm text-gray-700 no-underline">Ingat Saya</label>
                                </div>

                                <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold text-lg rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center no-underline">
                                    <i class="fas fa-sign-in-alt mr-3 no-underline"></i>
                                    <span class="no-underline">Masuk</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-100 px-8 py-6 text-center border-t border-gray-200">
                <p class="text-gray-600 no-underline">© {{ date('Y') }} <span class="font-semibold text-gray-800 no-underline">SMK Fatahillah</span> - Sistem Pengumpulan HP</p>
            </div>
        </div>
    </div>
</div>
@endsection
