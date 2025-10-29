@extends('layouts.app-tailwind')
@include('include.navbar')
@section('content')

<style>
/* Additional safety for text decorations */
.no-underline * {
    text-decoration: none !important;
    border-bottom: none !important;
}
</style>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 no-underline">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-500 to-blue-500 rounded-full mb-4">
                <i class="fas fa-user-graduate text-3xl text-white no-underline"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2 no-underline">Dashboard Siswa</h1>
            <p class="text-gray-600 text-lg no-underline">Selamat datang, <span class="font-semibold no-underline">{{ auth()->user()->name }}</span></p>
            <div class="w-24 h-1 bg-gradient-to-r from-green-400 to-blue-400 mx-auto mt-4 rounded-full"></div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="text-green-400 hover:text-green-600" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="text-red-400 hover:text-red-600" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Device Info Card --}}
        <div class="bg-white rounded-2xl shadow-xl border-0 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h3 class="text-white font-bold text-xl flex items-center no-underline">
                    <i class="fas fa-info-circle mr-3 no-underline"></i>
                    <span class="no-underline">Informasi Login</span>
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="{{ \App\Helpers\DeviceDetector::getDeviceIcon(auth()->user()->last_device ?? 'Unknown') }} text-blue-600 text-2xl no-underline"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1 no-underline">Device</h4>
                        <p class="text-gray-600 no-underline">{{ auth()->user()->last_device ?? 'Unknown' }}</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="{{ \App\Helpers\DeviceDetector::getBrowserIcon(auth()->user()->last_browser ?? 'Unknown') }} text-purple-600 text-2xl no-underline"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1 no-underline">Browser</h4>
                        <p class="text-gray-600 no-underline">{{ auth()->user()->last_browser ?? 'Unknown' }}</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-clock text-green-600 text-2xl no-underline"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 mb-1 no-underline">Last Login</h4>
                        <p class="text-gray-600 text-sm no-underline">{{ auth()->user()->last_login ? auth()->user()->last_login->format('d/m/Y H:i:s') : 'Unknown' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Pengumpulan & Pengambilan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Status Pengumpulan -->
            <div class="bg-white rounded-xl shadow-lg border-l-4 {{ $kumpulHariIni ? 'border-green-500' : 'border-red-500' }} p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center no-underline">
                        <i class="fas fa-mobile-alt {{ $kumpulHariIni ? 'text-green-600' : 'text-red-600' }} mr-2 no-underline"></i>
                        <span class="no-underline">Status Pengumpulan HP</span>
                    </h3>
                    @if($kumpulHariIni)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold no-underline">
                            <i class="fas fa-check-circle mr-1 no-underline"></i><span class="no-underline">Selesai</span>
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold no-underline">
                            <i class="fas fa-times-circle mr-1 no-underline"></i><span class="no-underline">Belum</span>
                        </span>
                    @endif
                </div>

                @if($kumpulHariIni)
                    <div class="space-y-2">
                        <div class="flex items-center text-green-700">
                            <i class="fas fa-check-circle mr-2 no-underline"></i>
                            <span class="font-semibold no-underline">Sudah Dikumpulkan</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p class="no-underline"><span class="font-medium no-underline">Waktu:</span> {{ $kumpulHariIni->waktu_input->format('H:i:s') }}</p>
                            <p class="no-underline"><span class="font-medium no-underline">Metode:</span> {{ ucfirst($kumpulHariIni->metode) }}</p>
                        </div>
                    </div>
                @else
                    <div class="space-y-2">
                        <div class="flex items-center text-red-700">
                            <i class="fas fa-times-circle mr-2 no-underline"></i>
                            <span class="font-semibold no-underline">Belum Dikumpulkan</span>
                        </div>
                        <p class="text-sm text-gray-600 no-underline">HP belum dikumpulkan hari ini</p>
                    </div>
                @endif
            </div>

            <!-- Status Pengambilan -->
            <div class="bg-white rounded-xl shadow-lg border-l-4 {{ $ambilHariIni ? 'border-green-500' : 'border-yellow-500' }} p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center no-underline">
                        <i class="fas fa-hand-holding {{ $ambilHariIni ? 'text-green-600' : 'text-yellow-600' }} mr-2 no-underline"></i>
                        <span class="no-underline">Status Pengambilan HP</span>
                    </h3>
                    @if($ambilHariIni)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold no-underline">
                            <i class="fas fa-check-circle mr-1 no-underline"></i><span class="no-underline">Selesai</span>
                        </span>
                    @else
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold no-underline">
                            <i class="fas fa-hourglass-half mr-1 no-underline"></i><span class="no-underline">Menunggu</span>
                        </span>
                    @endif
                </div>

                @if($ambilHariIni)
                    <div class="space-y-2">
                        <div class="flex items-center text-green-700">
                            <i class="fas fa-check-circle mr-2 no-underline"></i>
                            <span class="font-semibold no-underline">Sudah Diambil</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p class="no-underline"><span class="font-medium no-underline">Waktu:</span> {{ $ambilHariIni->waktu_input->format('H:i:s') }}</p>
                            <p class="no-underline"><span class="font-medium no-underline">Metode:</span> {{ ucfirst($ambilHariIni->metode) }}</p>
                        </div>
                    </div>
                @else
                    <div class="space-y-2">
                        <div class="flex items-center text-yellow-700">
                            <i class="fas fa-hourglass-half mr-2 no-underline"></i>
                            <span class="font-semibold no-underline">Belum Diambil</span>
                        </div>
                        <p class="text-sm text-gray-600 no-underline">HP belum diambil hari ini</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Input Kode --}}
        <div class="bg-white rounded-2xl shadow-xl border-0 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4">
                <h3 class="text-white font-bold text-xl flex items-center no-underline">
                    <i class="fas fa-keyboard mr-3 no-underline"></i>
                    <span class="no-underline">Input Kode HP</span>
                </h3>
            </div>
            <div class="p-8">
                <form method="POST" action="{{ route('siswa.inputqr') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="code" class="block text-lg font-semibold text-gray-700 mb-3 text-center no-underline">
                            Masukkan Kode HP Anda
                        </label>
                        <input type="text"
                               id="code"
                               name="code"
                               class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl focus:border-green-500 focus:ring-0 transition-all duration-200 text-center text-2xl font-mono tracking-widest bg-gray-50 hover:bg-white no-underline"
                               placeholder="••••••••"
                               required
                               autocomplete="off"
                               maxlength="8"
                               style="text-decoration: none !important; border-bottom: none !important;">
                    </div>
                    <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center no-underline">
                        <i class="fas fa-paper-plane mr-3 no-underline"></i>
                        <span class="no-underline">Submit Kode</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="text-center space-y-4">
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('siswa.riwayat') }}"
                   class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 no-underline"
                   style="text-decoration: none !important;">
                    <i class="fas fa-history mr-2 no-underline"></i>
                    <span class="no-underline">Lihat Riwayat</span>
                </a>
                <button onclick="window.location.reload()"
                        class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 no-underline"
                        style="text-decoration: none !important;">
                    <i class="fas fa-sync-alt mr-2 no-underline"></i>
                    <span class="no-underline">Refresh</span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
