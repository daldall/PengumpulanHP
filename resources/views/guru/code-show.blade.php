@extends('layouts.app-tailwind')
@include('include.navbar')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-4xl font-bold text-blue-600">Kode {{ ucfirst($code->jenis) }}</h2>
            <p class="text-gray-600 mt-2">{{ $code->tanggal->format('d M Y') }}</p>
        </div>        {{-- Card utama --}}
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 p-8 text-center transform hover:scale-105 transition-transform duration-300">
            {{-- QR Code dengan URL endpoint khusus --}}
            <div class="mb-6">
                <div class="inline-block p-4 bg-gray-50 rounded-xl">
                    {!! QrCode::size(220)->generate(url("/scan-code/{$code->kode}/{$code->jenis}")) !!}
                </div>
            </div>

            {{-- Kode teks --}}
            <p class="text-5xl font-bold text-gray-800 tracking-wider mb-4">
                {{ $code->kode }}
            </p>
        </div>        {{-- Info waktu aktif --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mt-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <h5 class="text-xl font-bold text-blue-600 mb-4">Informasi Aktivasi</h5>
                    <p class="text-gray-700">
                        <span class="font-semibold">Status:</span>
                        <span class="inline-block ml-2 px-4 py-2 rounded-full text-white font-medium {{ $code->status === 'aktif' ? 'bg-green-500' : 'bg-gray-500' }}">
                            {{ ucfirst($code->status) }}
                        </span>
                    </p>
                </div>

                {{-- Tombol toggle kode --}}
                <form method="POST" action="{{ route('guru.toggle-code', $code->id) }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 rounded-full font-bold text-white shadow-lg transform hover:scale-105 transition-all duration-300 {{ $code->status === 'aktif' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                        <i class="fas {{ $code->status === 'aktif' ? 'fa-ban' : 'fa-check-circle' }} mr-2"></i>
                        {{ $code->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
            </div>
        </div>        {{-- Tombol kembali --}}
        <div class="text-center mt-8">
            <a href="{{ route('guru.dashboard') }}"
               class="inline-flex items-center px-8 py-3 border-2 border-gray-400 text-gray-700 font-bold rounded-full hover:bg-gray-400 hover:text-white transform hover:scale-105 transition-all duration-300 shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
