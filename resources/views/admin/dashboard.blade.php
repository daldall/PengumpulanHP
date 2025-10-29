@extends('layouts.app-tailwind')
@include('include.navbar')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-8">Dashboard Admin</h2>

        <!-- Quick Action Buttons -->
        <div class="flex justify-center gap-4 mb-8">
            <a href="{{ route('admin.analytics') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                <i class="fas fa-chart-line mr-2"></i>Analytics Dashboard
            </a>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Guru</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $totalGuru }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-chalkboard-teacher text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Siswa</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $totalSiswa }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-user-graduate text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-100 text-sm font-medium">Total Admin</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $totalAdmin }}</h3>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-user-shield text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex">
                    <button class="tab-button active flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm focus:outline-none transition-colors" data-target="#guru">
                        <i class="fas fa-chalkboard-teacher mr-2"></i> Guru
                    </button>
                    <button class="tab-button flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm focus:outline-none transition-colors" data-target="#siswa">
                        <i class="fas fa-user-graduate mr-2"></i> Siswa
                    </button>
                </nav>
            </div>

            <div class="tab-content p-6">

                <!-- GURU -->
                <div class="tab-pane" id="guru" style="display: none;">
                    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                        <h4 class="text-lg font-bold text-gray-800 mb-0">Daftar Guru</h4>
                        <div class="flex flex-wrap gap-3">
                            <!-- Dropdown Export -->
                            <div class="relative dropdown-container">
                                <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors dropdown-toggle" onclick="toggleDropdown(this)">
                                    <i class="fas fa-file-export mr-2"></i> Export
                                    <i class="fas fa-chevron-down ml-2 text-sm"></i>
                                </button>
                                <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                    <a class="flex items-center px-4 py-2 hover:bg-gray-100 rounded-t-lg" href="{{ route('admin.guru.export-excel') }}">
                                        <i class="fas fa-file-excel text-green-600 mr-2"></i> Excel
                                    </a>
                                    <a class="flex items-center px-4 py-2 hover:bg-gray-100 rounded-b-lg" href="{{ route('admin.guru.export-pdf') }}">
                                        <i class="fas fa-file-pdf text-red-600 mr-2"></i> PDF
                                    </a>
                                </div>
                            </div>

                            <!-- Tombol Tambah -->
                            <button class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors" onclick="openModal('modalAddGuru')">
                                <i class="fas fa-plus mr-2"></i> Tambah Guru
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($gurus as $guru)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $guru->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $guru->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.guru.edit', $guru->id) }}" class="inline-flex items-center p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.guru.delete', $guru->id) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button class="inline-flex items-center p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors" onclick="return confirm('Yakin hapus guru ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                            <i class="fas fa-user-times text-4xl mb-2"></i>
                                            <p>Belum ada guru terdaftar</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Pagination Guru -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $gurus->appends(['tab' => 'guru'])->links('pagination.tailwind') }}
                        </div>
                    </div>
                </div>

                <!-- SISWA -->
                <div class="tab-pane" id="siswa" style="display: none;">
                    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                        <h4 class="text-lg font-bold text-gray-800 mb-0">Daftar Siswa</h4>
                        <div class="flex flex-wrap gap-3">
                            <!-- Pencarian -->
                            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex gap-2">
                                <input type="hidden" name="tab" value="siswa">
                                <input type="text" name="search" value="{{ request('search') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Cari siswa...">
                                <button class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>

                            <!-- Dropdown Export -->
                            <div class="relative dropdown-container">
                                <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors dropdown-toggle" onclick="toggleDropdown(this)">
                                    <i class="fas fa-file-export mr-2"></i> Export
                                    <i class="fas fa-chevron-down ml-2 text-sm"></i>
                                </button>
                                <div class="dropdown-menu hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                    <a class="flex items-center px-4 py-2 hover:bg-gray-100 rounded-t-lg" href="{{ route('admin.siswa.export-excel') }}">
                                        <i class="fas fa-file-excel text-green-600 mr-2"></i> Excel
                                    </a>
                                    <a class="flex items-center px-4 py-2 hover:bg-gray-100 rounded-b-lg" href="{{ route('admin.siswa.export-pdf') }}">
                                        <i class="fas fa-file-pdf text-red-600 mr-2"></i> PDF
                                    </a>
                                </div>
                            </div>

                            <!-- Tombol Tambah -->
                            <button class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors" onclick="openModal('modalAddSiswa')">
                                <i class="fas fa-plus mr-2"></i> Tambah Siswa
                            </button>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device Info</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($siswas as $siswa)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->nis }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $siswa->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->kelas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($siswa->last_device)
                                                <div class="space-y-1">
                                                    <div class="flex items-center gap-2">
                                                        <i class="{{ \App\Helpers\DeviceDetector::getDeviceIcon($siswa->last_device) }} text-blue-600"></i>
                                                        <span>{{ $siswa->last_device }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <i class="{{ \App\Helpers\DeviceDetector::getBrowserIcon($siswa->last_browser) }} text-purple-600"></i>
                                                        <span>{{ $siswa->last_browser }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($siswa->last_login)
                                                {{ $siswa->last_login->format('d/m/Y H:i') }}
                                            @else
                                                <span class="text-gray-400">Belum login</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="inline-flex items-center p-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.siswa.delete', $siswa->id) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button class="inline-flex items-center p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors" onclick="return confirm('Yakin hapus siswa ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            <i class="fas fa-users text-4xl mb-2"></i>
                                            <p>Belum ada siswa terdaftar</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Pagination Siswa -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $siswas->appends(['tab' => 'siswa', 'search' => request('search')])->links('pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Guru -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" id="modalAddGuru">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-screen overflow-y-auto">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-t-xl p-6 flex justify-between items-center">
                    <h5 class="font-bold text-lg">
                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                        Tambah Guru
                    </h5>
                    <button type="button" class="text-white hover:text-gray-200" onclick="closeModal('modalAddGuru')">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form action="{{ route('admin.guru.store') }}" method="POST">
                    @csrf
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Guru</label>
                                <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-0 flex gap-3 justify-end">
                        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors" onclick="closeModal('modalAddGuru')">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" id="modalAddSiswa">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-screen overflow-y-auto">
                <div class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-t-xl p-6 flex justify-between items-center">
                    <h5 class="font-bold text-lg">
                        <i class="fas fa-user-graduate mr-2"></i>
                        Tambah Siswa
                    </h5>
                    <button type="button" class="text-white hover:text-gray-200" onclick="closeModal('modalAddSiswa')">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form action="{{ route('admin.siswa.store') }}" method="POST">
                    @csrf
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIS</label>
                                <input type="text" name="nis" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Siswa</label>
                                <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                                <input type="text" name="kelas" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-0 flex gap-3 justify-end">
                        <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors" onclick="closeModal('modalAddSiswa')">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');

    // Check URL parameter for active tab
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab') || 'guru';

    // Function to show tab
    function showTab(targetId) {
        // Hide all tab panes
        tabPanes.forEach(pane => {
            pane.style.display = 'none';
        });

        // Remove active state from all buttons
        tabButtons.forEach(button => {
            button.classList.remove('active');
            button.classList.add('text-gray-500', 'border-transparent');
            button.classList.remove('text-blue-600', 'border-blue-500');
        });

        // Show target tab pane
        const targetPane = document.querySelector(targetId);
        if (targetPane) {
            targetPane.style.display = 'block';
        }

        // Activate target button
        const targetButton = document.querySelector(`[data-target="${targetId}"]`);
        if (targetButton) {
            targetButton.classList.add('active', 'text-blue-600', 'border-blue-500');
            targetButton.classList.remove('text-gray-500', 'border-transparent');
        }
    }

    // Initialize with active tab
    showTab(`#${activeTab}`);

    // Add click handlers
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            showTab(targetId);

            // Update URL parameter
            const url = new URL(window.location);
            url.searchParams.set('tab', targetId.replace('#', ''));
            history.replaceState(null, '', url);
        });
    });

    // Initial styles for tabs
    tabButtons.forEach(button => {
        if (!button.classList.contains('active')) {
            button.classList.add('text-gray-500', 'border-transparent');
        } else {
            button.classList.add('text-blue-600', 'border-blue-500');
        }
    });
});

// Modal functions
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = 'auto';

    // Reset form if exists
    const form = document.querySelector(`#${modalId} form`);
    if (form) {
        form.reset();
    }
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('bg-black') && e.target.classList.contains('bg-opacity-50')) {
        const modals = document.querySelectorAll('.fixed.inset-0.z-50');
        modals.forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                closeModal(modal.id);
            }
        });
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.fixed.inset-0.z-50');
        modals.forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                closeModal(modal.id);
            }
        });
    }
});

// Dropdown functionality
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    const allDropdowns = document.querySelectorAll('.dropdown-menu');

    // Close all other dropdowns
    allDropdowns.forEach(menu => {
        if (menu !== dropdown) {
            menu.classList.add('hidden');
        }
    });

    // Toggle current dropdown
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-container')) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});
</script>
@endsection
