{{-- Navbar --}}
<nav class="bg-gradient-to-r from-blue-600 to-purple-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo + Nama Sekolah --}}
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-3 text-white font-semibold hover:text-gray-200 transition-colors">
                    <img src="{{ asset('images/yasfat.png') }}" alt="Logo Sekolah" class="w-9 h-9 object-contain">
                    <span class="text-base leading-tight">Sistem Pengumpulan HP</span>
                </a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center space-x-4">
                {{-- Jika user belum login --}}
                @guest
                    <a href="{{ url()->previous() }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        <i class="fa fa-arrow-left mr-2"></i>Kembali
                    </a>
                @endguest

                {{-- Jika user login --}}
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fa fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.analytics') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fa fa-chart-line mr-2"></i>Analytics
                        </a>
                    @elseif(auth()->user()->isGuru())
                        <a href="{{ route('guru.dashboard') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fa fa-chalkboard-teacher mr-2"></i>Dashboard Guru
                        </a>
                        <a href="{{ route('guru.monitoring') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fa fa-eye mr-2"></i>Monitoring
                        </a>
                    @else
                        {{-- Menu siswa --}}
                        <a href="{{ route('siswa.dashboard') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fa fa-user-graduate mr-2"></i>Dashboard Siswa
                        </a>
                        <a href="{{ route('siswa.riwayat') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fa fa-history mr-2"></i>Riwayat
                        </a>
                    @endif

                    {{-- Dropdown User --}}
                    <div class="relative ml-3">
                        <button id="user-menu-button" class="flex items-center text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-purple-700" onclick="toggleDropdown()">
                            <i class="fa fa-user-circle mr-2"></i>
                            {{ Auth::user()->name }}
                            <i class="fa fa-chevron-down ml-2 text-xs"></i>
                        </button>

                        <div id="user-menu" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <i class="fa fa-sign-out-alt mr-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-white hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-white p-2" onclick="toggleMobileMenu()">
                    <i class="fa fa-bars text-lg"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-purple-600">
                @guest
                    <a href="{{ url()->previous() }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium">
                        <i class="fa fa-arrow-left mr-2"></i>Kembali
                    </a>
                @endguest

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fa fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('admin.analytics') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fa fa-chart-line mr-2"></i>Analytics
                        </a>
                    @elseif(auth()->user()->isGuru())
                        <a href="{{ route('guru.dashboard') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fa fa-chalkboard-teacher mr-2"></i>Dashboard Guru
                        </a>
                        <a href="{{ route('guru.monitoring') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fa fa-eye mr-2"></i>Monitoring
                        </a>
                    @else
                        <a href="{{ route('siswa.dashboard') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fa fa-user-graduate mr-2"></i>Dashboard Siswa
                        </a>
                        <a href="{{ route('siswa.riwayat') }}" class="text-white hover:text-gray-200 block px-3 py-2 rounded-md text-base font-medium">
                            <i class="fa fa-history mr-2"></i>Riwayat
                        </a>
                    @endif

                    {{-- Mobile User Info & Logout --}}
                    <div class="border-t border-purple-600 pt-4 pb-3">
                        <div class="flex items-center px-3">
                            <i class="fa fa-user-circle text-white text-lg mr-3"></i>
                            <span class="text-white font-medium">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="mt-3 px-2">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                               class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-gray-200 hover:bg-purple-600">
                                <i class="fa fa-sign-out-alt mr-2"></i>Logout
                            </a>
                            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
function toggleDropdown() {
    const menu = document.getElementById('user-menu');
    menu.classList.toggle('hidden');
}

function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const button = document.getElementById('user-menu-button');
    const menu = document.getElementById('user-menu');

    if (!button?.contains(event.target) && !menu?.contains(event.target)) {
        menu?.classList.add('hidden');
    }
});
</script>
