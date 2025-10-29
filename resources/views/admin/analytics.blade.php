@extends('layouts.app2')
@include('include.navbar')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 flex items-center gap-3">
                        <i class="fas fa-chart-line text-blue-600"></i>
                        Analytics Dashboard
                    </h1>
                    <p class="mt-2 text-gray-600">Statistik dan analisis sistem pengumpulan HP</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Date Range -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('admin.analytics') }}" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                    <select name="range" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="toggleCustomDate(this.value)">
                        <option value="today" {{ $dateRange == 'today' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="week" {{ $dateRange == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="month" {{ $dateRange == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="custom" {{ $dateRange == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>

                <div id="customDateRange" class="flex gap-4" style="display: {{ $dateRange == 'custom' ? 'flex' : 'none' }};">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dari</label>
                        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampai</label>
                        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
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

            <!-- Pengumpulan -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Sudah Kumpul</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $totalPengumpulan }}</h3>
                        <p class="text-sm text-green-100 mt-1">{{ $pengumpulanRate }}% dari total</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-mobile-alt text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Pengambilan -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Sudah Ambil</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $totalPengambilan }}</h3>
                        <p class="text-sm text-purple-100 mt-1">{{ $pengambilanRate }}% dari total</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-hand-holding text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Late Collection -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Terlambat</p>
                        <h3 class="text-4xl font-bold mt-2">{{ $lateCollection }}</h3>
                        <p class="text-sm text-orange-100 mt-1">{{ $lateRate }}% telat > 08:00</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-clock text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <!-- Left Column - Charts -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Daily Activity Chart -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4">
                        <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
                            Aktivitas 7 Hari
                        </h3>
                        <div style="height: 180px;">
                            <canvas id="dailyActivityChart"></canvas>
                        </div>
                    </div>

                    <!-- Metode Input Chart -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4">
                        <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-chart-pie text-green-600 mr-2"></i>
                            Metode Input
                        </h3>
                        <div style="height: 180px;">
                            <canvas id="metodeChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Stats by Class - Compact Table -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4">
                    <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-school text-teal-600 mr-2"></i>
                        Statistik Per Kelas
                    </h3>
                    <div class="overflow-x-auto max-h-64 overflow-y-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Kumpul</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Ambil</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($statsByKelas as $stat)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2">
                                        <span class="font-semibold text-gray-900 text-sm">{{ $stat->kelas }}</span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $stat->kumpul_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                            {{ $stat->ambil_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        @if($stat->kumpul_count > 0 && $stat->ambil_count > 0)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <i class="fas fa-check-circle"></i>
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                <i class="fas fa-minus-circle"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column - Device Stats & Top Students -->
            <div class="space-y-6">
                <!-- Additional Info Cards -->
                <div class="grid grid-cols-1 gap-4">
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-500 rounded-full p-3">
                                <i class="fas fa-user-slash text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-red-600">Belum Pernah</p>
                                <h4 class="text-2xl font-bold text-red-700">{{ $siswaBelumPernah }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-yellow-500 rounded-full p-3">
                                <i class="fas fa-clock text-white text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-yellow-600">Avg Waktu</p>
                                <h4 class="text-2xl font-bold text-yellow-700">
                                    {{ $avgWaktuKumpul->avg_hour ? number_format($avgWaktuKumpul->avg_hour, 0) : '0' }}:00
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Device Stats -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4">
                    <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-mobile-alt text-purple-600 mr-2"></i>
                        Device & Browser
                    </h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach($deviceStats as $device)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="{{ \App\Helpers\DeviceDetector::getDeviceIcon($device->last_device) }} text-lg text-blue-600"></i>
                                <span class="text-sm font-medium text-gray-700">{{ $device->last_device }}</span>
                            </div>
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                {{ $device->total }}
                            </span>
                        </div>
                        @endforeach

                        @foreach($browserStats as $browser)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-2">
                                <i class="{{ \App\Helpers\DeviceDetector::getBrowserIcon($browser->last_browser) }} text-lg text-indigo-600"></i>
                                <span class="text-sm font-medium text-gray-700">{{ $browser->last_browser }}</span>
                            </div>
                            <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                                {{ $browser->total }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Top Students -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4">
                    <h3 class="text-base font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                        Top Siswa
                    </h3>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($topSiswa->take(5) as $index => $siswa)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex-shrink-0">
                                @if($index < 3)
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $siswa->name }}</p>
                                <p class="text-xs text-gray-500">{{ $siswa->kelas }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    {{ $siswa->pengumpulan_count }}x
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function toggleCustomDate(value) {
    const customRange = document.getElementById('customDateRange');
    customRange.style.display = value === 'custom' ? 'flex' : 'none';
}

// Daily Activity Chart
const dailyCtx = document.getElementById('dailyActivityChart').getContext('2d');
const dailyLabels = @json($dailyActivity->keys());
const kumpulData = dailyLabels.map(date => {
    const data = @json($dailyActivity);
    return data[date]?.find(item => item.status === 'dikumpulkan')?.total || 0;
});
const ambilData = dailyLabels.map(date => {
    const data = @json($dailyActivity);
    return data[date]?.find(item => item.status === 'diambil')?.total || 0;
});

new Chart(dailyCtx, {
    type: 'bar',
    data: {
        labels: dailyLabels,
        datasets: [{
            label: 'Kumpul',
            data: kumpulData,
            backgroundColor: 'rgba(34, 197, 94, 0.8)',
            borderColor: 'rgb(34, 197, 94)',
            borderWidth: 1
        }, {
            label: 'Ambil',
            data: ambilData,
            backgroundColor: 'rgba(168, 85, 247, 0.8)',
            borderColor: 'rgb(168, 85, 247)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    boxWidth: 12,
                    font: {
                        size: 11
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    font: {
                        size: 10
                    }
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        size: 10
                    }
                }
            }
        }
    }
});

// Metode Chart
const metodeCtx = document.getElementById('metodeChart').getContext('2d');
const metodeData = @json($metodeStats);
new Chart(metodeCtx, {
    type: 'doughnut',
    data: {
        labels: metodeData.map(item => item.metode.toUpperCase()),
        datasets: [{
            data: metodeData.map(item => item.total),
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',
                'rgba(249, 115, 22, 0.8)',
            ],
            borderColor: [
                'rgb(59, 130, 246)',
                'rgb(249, 115, 22)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12,
                    font: {
                        size: 11
                    },
                    padding: 10
                }
            }
        },
        cutout: '60%'
    }
});
</script>
@endsection
