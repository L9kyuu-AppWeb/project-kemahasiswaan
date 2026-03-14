@php
    $mahasiswa = auth()->guard('mahasiswa')->user();
    $beasiswaAktif = null;
    $magangAktif = null;
    if ($mahasiswa) {
        $today = now()->format('Y-m-d');
        $beasiswaAktif = \App\Models\MahasiswaBeasiswa::with('beasiswaTipe')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'aktif')
            ->where('tanggal_mulai', '<=', $today)
            ->where(function($query) use ($today) {
                $query->whereNull('tanggal_berakhir')
                      ->orWhere('tanggal_berakhir', '>=', $today);
            })
            ->first();
        $magangAktif = \App\Models\MahasiswaMagang::where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'aktif')
            ->where('tanggal_mulai', '<=', $today)
            ->where(function($query) use ($today) {
                $query->whereNull('tanggal_selesai')
                      ->orWhere('tanggal_selesai', '>=', $today);
            })
            ->get();

        // Debug untuk development
        // dd('Mahasiswa ID:', $mahasiswa->id, 'Magang Aktif:', $magangAktif);
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mahasiswa Dashboard') - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-green-600 to-emerald-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-graduate text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Mahasiswa Dashboard</h1>
                            <p class="text-xs text-green-200">Sistem Kemahasiswaan</p>
                        </div>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2 {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- Data Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2">
                            <i class="fas fa-database"></i>
                            <span>Data</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute left-0 mt-1 w-56 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left z-50">
                            <div class="py-2">
                                <a href="{{ route('mahasiswa.profile') }}" class="block px-4 py-3 hover:bg-green-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.profile') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                                    <i class="fas fa-user w-5 text-center"></i>
                                    <span>Profil</span>
                                </a>

                                @if($beasiswaAktif ?? null)
                                <a href="{{ route('mahasiswa.laporan.index') }}" class="block px-4 py-3 hover:bg-green-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.laporan.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                                    <i class="fas fa-file-alt w-5 text-center"></i>
                                    <span>Laporan Beasiswa</span>
                                </a>
                                @endif

                                @if(($magangAktif ?? null) && count($magangAktif) > 0)
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="{{ route('mahasiswa.magang.index') }}" class="block px-4 py-3 hover:bg-green-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.magang.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                                    <i class="fas fa-briefcase w-5 text-center"></i>
                                    <span>Magang</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kegiatan Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Kegiatan</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute left-0 mt-1 w-56 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left z-50">
                            <div class="py-2">
                                <a href="{{ route('mahasiswa.antrian-verifikasi.index') }}" class="block px-4 py-3 hover:bg-green-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.antrian-verifikasi.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                                    <i class="fas fa-list-ol w-5 text-center"></i>
                                    <span>Antrian Verifikasi</span>
                                </a>
                                
                                <a href="{{ route('mahasiswa.kompetisi.index') }}" class="block px-4 py-3 hover:bg-green-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.kompetisi.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                                    <i class="fas fa-medal w-5 text-center"></i>
                                    <span>Kompetisi</span>
                                </a>
                                
                                <a href="{{ route('mahasiswa.rekognisi.index') }}" class="block px-4 py-3 hover:bg-green-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.rekognisi.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                                    <i class="fas fa-award w-5 text-center"></i>
                                    <span>Rekognisi</span>
                                </a>
                                
                                <a href="{{ route('mahasiswa.sertifikasi.index') }}" class="block px-4 py-3 hover:bg-green-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.sertifikasi.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                                    <i class="fas fa-certificate w-5 text-center"></i>
                                    <span>Sertifikasi</span>
                                </a>

                                <div class="border-t border-gray-100 my-2"></div>

                                <a href="{{ route('mahasiswa.kegiatan-umum.index') }}" class="block px-4 py-3 hover:bg-green-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.kegiatan-umum.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                                    <i class="fas fa-folder-open w-5 text-center"></i>
                                    <span>Kegiatan Umum</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ $mahasiswa->name }}</p>
                        <p class="text-xs text-green-200">{{ $mahasiswa->nim }}</p>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuBtn" class="lg:hidden bg-white/20 hover:bg-white/30 p-2 rounded-lg transition duration-200">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Logout Button -->
                    <form action="{{ route('mahasiswa.logout') }}" method="POST" class="hidden lg:inline">
                        @csrf
                        <button type="submit" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden lg:hidden border-t border-white/20">
            <div class="px-4 py-2 space-y-2 max-h-[70vh] overflow-y-auto">
                <a href="{{ route('mahasiswa.dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <!-- Data Section -->
                <div class="pt-2 border-t border-white/20">
                    <div class="flex items-center gap-3 px-4 py-2 text-green-200 font-semibold">
                        <i class="fas fa-database w-5"></i>
                        <span>Data</span>
                    </div>
                    <div class="ml-4 space-y-1">
                        <a href="{{ route('mahasiswa.profile') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.profile') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-user w-5"></i>
                            <span>Profil</span>
                        </a>

                        @if($beasiswaAktif ?? null)
                        <a href="{{ route('mahasiswa.laporan.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.laporan.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-file-alt w-5"></i>
                            <span>Laporan Beasiswa</span>
                        </a>
                        @endif

                        @if(($magangAktif ?? null) && count($magangAktif) > 0)
                        <div class="border-t border-white/20 my-1"></div>
                        <a href="{{ route('mahasiswa.magang.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.magang.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-briefcase w-5"></i>
                            <span>Magang</span>
                        </a>
                        @endif
                    </div>
                </div>
                
                <!-- Kegiatan Section -->
                <div class="pt-2 border-t border-white/20">
                    <div class="flex items-center gap-3 px-4 py-2 text-green-200 font-semibold">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span>Kegiatan</span>
                    </div>
                    <div class="ml-4 space-y-1">
                        <a href="{{ route('mahasiswa.antrian-verifikasi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.antrian-verifikasi.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-list-ol w-5"></i>
                            <span>Antrian Verifikasi</span>
                        </a>
                        
                        <a href="{{ route('mahasiswa.kompetisi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.kompetisi.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-medal w-5"></i>
                            <span>Kompetisi</span>
                        </a>
                        
                        <a href="{{ route('mahasiswa.rekognisi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.rekognisi.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-award w-5"></i>
                            <span>Rekognisi</span>
                        </a>
                        
                        <a href="{{ route('mahasiswa.sertifikasi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.sertifikasi.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-certificate w-5"></i>
                            <span>Sertifikasi</span>
                        </a>

                        <div class="border-t border-white/20 my-2"></div>

                        <a href="{{ route('mahasiswa.kegiatan-umum.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('mahasiswa.kegiatan-umum.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-folder-open w-5"></i>
                            <span>Kegiatan Umum</span>
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('mahasiswa.logout') }}" method="POST" class="pt-2 border-t border-white/20 mt-2">
                    @csrf
                    <button type="submit" class="w-full px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 text-red-200 hover:text-red-100">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-sm border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
