@extends('layouts.app-tailwind')
@include('include.navbar')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 flex items-center justify-center gap-3">
                <i class="fas fa-chalkboard-teacher text-blue-600"></i>
                Dashboard Guru
            </h1>
            <p class="mt-2 text-gray-600">Kelola sistem pengumpulan HP siswa</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Siswa</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $totalSiswa }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-user-graduate text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Sudah Kumpul</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $sudahKumpul }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-mobile-alt text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Sudah Ambil</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $sudahAmbil }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-hand-holding text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Kode Kumpul --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-center text-gray-800 mb-6 flex items-center justify-center gap-2">
                    <i class="fas fa-qrcode text-blue-600"></i>
                    Kode Pengumpulan HP
                </h3>
                <div class="text-center">
                    @if($kodeKumpul)
                        @if($kodeKumpul->status === 'aktif')
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Kode pengumpulan sedang aktif
                                </span>
                            </div>
                            <div class="space-y-3">
                                <a href="{{ route('guru.show-code', $kodeKumpul->id) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    <i class="fas fa-eye mr-2"></i>
                                    Lihat Kode
                                </a>

                                {{-- Tutup Kode --}}
                                <form method="POST" action="{{ route('guru.toggle-code', $kodeKumpul->id) }}" class="inline-block ml-2">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                                        <i class="fas fa-times mr-2"></i>
                                        Tutup Kode
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-2"></i>
                                    Kode pengumpulan sudah ditutup
                                </span>
                            </div>
                            <form method="POST" action="{{ route('guru.generate-code') }}">
                                @csrf
                                <input type="hidden" name="jenis" value="kumpul">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    Generate Kode Baru
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Kode Kumpul belum dibuat
                            </span>
                        </div>
                        <form method="POST" action="{{ route('guru.generate-code') }}">
                            @csrf
                            <input type="hidden" name="jenis" value="kumpul">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                <i class="fas fa-plus mr-2"></i>
                                Generate Kode Kumpul
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Kode Pengembalian --}}
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-center text-gray-800 mb-6 flex items-center justify-center gap-2">
                    <i class="fas fa-hand-holding text-green-600"></i>
                    Kode Pengembalian HP
                </h3>
                <div class="text-center">
                    @if($kodePengembalian)
                        @if($kodePengembalian->status === 'aktif')
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Kode pengembalian sedang aktif
                                </span>
                            </div>
                            <div class="space-y-3">
                                <a href="{{ route('guru.show-code', $kodePengembalian->id) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    <i class="fas fa-eye mr-2"></i>
                                    Lihat Kode
                                </a>

                                {{-- Tutup Kode --}}
                                <form method="POST" action="{{ route('guru.toggle-code', $kodePengembalian->id) }}" class="inline-block ml-2">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                                        <i class="fas fa-times mr-2"></i>
                                        Tutup Kode
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-2"></i>
                                    Kode pengembalian sudah ditutup
                                </span>
                            </div>
                            <form method="POST" action="{{ route('guru.generate-code') }}">
                                @csrf
                                <input type="hidden" name="jenis" value="pengembalian">
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                    <i class="fas fa-plus mr-2"></i>
                                    Generate Kode Baru
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Kode Pengembalian belum dibuat
                            </span>
                        </div>
                        <form method="POST" action="{{ route('guru.generate-code') }}">
                            @csrf
                            <input type="hidden" name="jenis" value="pengembalian">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                <i class="fas fa-plus mr-2"></i>
                                Generate Kode Pengembalian
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center">
            <a href="{{ route('guru.monitoring') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="fas fa-eye mr-3"></i>
                Monitoring Real-time
            </a>
        </div>
    </div>
</div>
@endsection
