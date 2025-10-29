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

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-indigo-50 py-8 no-underline">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full mb-4">
                        <i class="fas fa-chart-line text-2xl text-white no-underline"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2 no-underline">Monitoring Status Siswa</h1>
                    <p class="text-gray-600 no-underline">
                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                    </p>
                    <div class="w-24 h-1 bg-gradient-to-r from-purple-400 to-indigo-400 mt-4 rounded-full"></div>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <!-- Export Dropdown -->
                    <div class="relative group">
                        <button class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 no-underline" onclick="toggleDropdown('export-dropdown')" style="text-decoration: none !important;">
                            <i class="fas fa-file-export mr-2 no-underline"></i>
                            <span class="no-underline">Export</span>
                            <i class="fas fa-chevron-down ml-2 no-underline"></i>
                        </button>
                        <div id="export-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                            <div class="py-1">
                                <a href="{{ route('guru.export-excel') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors no-underline" style="text-decoration: none !important;">
                                    <i class="fas fa-file-excel text-green-600 mr-3 no-underline"></i>
                                    <span class="no-underline">Export Excel</span>
                                </a>
                                <a href="{{ route('guru.export-pdf') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors no-underline" style="text-decoration: none !important;">
                                    <i class="fas fa-file-pdf text-red-600 mr-3 no-underline"></i>
                                    <span class="no-underline">Export PDF</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Search -->
                    <form action="{{ route('guru.monitoring') }}" method="GET" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 no-underline"
                               placeholder="Cari NIS / Nama..."
                               style="text-decoration: none !important;">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 no-underline">
                            <i class="fas fa-search no-underline"></i>
                        </button>
                    </form>
                    
                    <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg shadow-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200 no-underline" style="text-decoration: none !important;">
                        <i class="fas fa-arrow-left mr-2 no-underline"></i><span class="no-underline">Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 rounded-lg p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-xl no-underline"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-800 font-medium no-underline">{{ session('success') }}</p>
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="text-green-400 hover:text-green-600 no-underline" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                            <i class="fas fa-times no-underline"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 rounded-lg p-4 shadow-sm">
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

        <!-- Data Table -->
        <div class="bg-white rounded-2xl shadow-xl border-0 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                <h3 class="text-white font-bold text-xl flex items-center no-underline">
                    <i class="fas fa-table mr-3 no-underline"></i>
                    <span class="no-underline">Data Status Siswa</span>
                </h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-underline">No</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-underline">NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-underline">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-underline">Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-underline">Jam Kumpul</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-underline">Jam Ambil</th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider no-underline">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($statusSiswa as $index => $data)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 no-underline">{{ ($siswa->currentPage() - 1) * $siswa->perPage() + $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 no-underline">{{ $data['siswa']->nis }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 no-underline">{{ $data['siswa']->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 no-underline">{{ $data['siswa']->kelas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 no-underline">
                                @if($data['kumpul'])
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-green-600 no-underline">{{ $data['kumpul']->waktu_input->format('H:i:s') }}</span>
                                        <span class="text-xs text-gray-500 no-underline">
                                            <i class="fas fa-hand-paper mr-1 no-underline"></i>{{ ucfirst($data['kumpul']->metode) }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-gray-400 no-underline">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 no-underline">
                                @if($data['ambil'])
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-blue-600 no-underline">{{ $data['ambil']->waktu_input->format('H:i:s') }}</span>
                                        <span class="text-xs text-gray-500 no-underline">
                                            <i class="fas fa-hand-holding mr-1 no-underline"></i>{{ ucfirst($data['ambil']->metode) }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-gray-400 no-underline">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($data['status'] === 'selesai')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 no-underline">
                                        <i class="fas fa-check-circle mr-1 no-underline"></i><span class="no-underline">Selesai</span>
                                    </span>
                                @elseif($data['status'] === 'kumpul_belum_ambil')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 no-underline">
                                        <i class="fas fa-hourglass-half mr-1 no-underline"></i><span class="no-underline">Belum Diambil</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 no-underline">
                                        <i class="fas fa-times-circle mr-1 no-underline"></i><span class="no-underline">Belum Dikumpulkan</span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500 no-underline">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-info-circle text-4xl mb-4 text-gray-400 no-underline"></i>
                                    <span class="text-lg font-medium no-underline">Data tidak ditemukan</span>
                                    <span class="text-sm no-underline">Coba ubah kata kunci pencarian Anda</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($siswa->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-center">
                    <nav class="flex items-center space-x-1">
                        {{-- Previous Page Link --}}
                        @if ($siswa->onFirstPage())
                            <span class="px-3 py-2 text-gray-400 bg-white border border-gray-300 rounded-md cursor-not-allowed no-underline">
                                <i class="fas fa-chevron-left no-underline"></i>
                            </span>
                        @else
                            <a href="{{ $siswa->previousPageUrl() }}" class="px-3 py-2 text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors no-underline" style="text-decoration: none !important;">
                                <i class="fas fa-chevron-left no-underline"></i>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($siswa->getUrlRange(1, $siswa->lastPage()) as $page => $url)
                            @if ($page == $siswa->currentPage())
                                <span class="px-3 py-2 text-white bg-purple-600 border border-purple-600 rounded-md font-semibold no-underline">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-2 text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors no-underline" style="text-decoration: none !important;">
                                    <span class="no-underline">{{ $page }}</span>
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($siswa->hasMorePages())
                            <a href="{{ $siswa->nextPageUrl() }}" class="px-3 py-2 text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors no-underline" style="text-decoration: none !important;">
                                <i class="fas fa-chevron-right no-underline"></i>
                            </a>
                        @else
                            <span class="px-3 py-2 text-gray-400 bg-white border border-gray-300 rounded-md cursor-not-allowed no-underline">
                                <i class="fas fa-chevron-right no-underline"></i>
                            </span>
                        @endif
                    </nav>
                </div>
                
                {{-- Pagination Info --}}
                <div class="flex justify-center mt-3">
                    <span class="text-sm text-gray-600 no-underline">
                        Menampilkan {{ $siswa->firstItem() }} sampai {{ $siswa->lastItem() }} dari {{ $siswa->total() }} data
                    </span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden');
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!dropdown.contains(event.target) && !event.target.closest('button')) {
            dropdown.classList.add('hidden');
        }
    });
}

// Close dropdown with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        document.getElementById('export-dropdown').classList.add('hidden');
    }
});
</script>
@endsection
