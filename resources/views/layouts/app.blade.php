<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-shield text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Admin Dashboard</h1>
                            <p class="text-xs text-blue-200">Sistem Kemahasiswaan</p>
                        </div>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden xl:flex items-center space-x-1">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- Master Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2">
                            <i class="fas fa-database"></i>
                            <span>Master</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute left-0 mt-1 w-64 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left z-50">
                            <div class="py-2">
                                <a href="{{ route('admin.profile') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.profile') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                    <i class="fas fa-user-circle w-5 text-center"></i>
                                    <span>Profil</span>
                                </a>
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <a href="{{ route('admin.program-studi.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.program-studi.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                    <i class="fas fa-graduation-cap w-5 text-center"></i>
                                    <span>Program Studi</span>
                                </a>

                                <a href="{{ route('admin.tahun-ajar.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.tahun-ajar.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                    <i class="fas fa-calendar-alt w-5 text-center"></i>
                                    <span>Tahun Ajar</span>
                                </a>

                                <div class="border-t border-gray-100 my-1"></div>

                                <a href="{{ route('admin.beasiswa.tipe.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.beasiswa.tipe.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                    <i class="fas fa-award w-5 text-center"></i>
                                    <span>Tipe Beasiswa</span>
                                </a>

                                <div class="border-t border-gray-100 my-2"></div>

                                <!-- Nested Dropdown: Kegiatan -->
                                <div class="relative group/kegiatan">
                                    <button class="w-full px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center justify-between gap-3 text-gray-700">
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-calendar-alt w-5 text-center"></i>
                                            <span>Kegiatan</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </button>
                                    <!-- Nested Dropdown Menu -->
                                    <div class="absolute left-full top-0 ml-1 w-56 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover/kegiatan:opacity-100 group-hover/kegiatan:visible transition-all duration-200 transform origin-top-left z-50">
                                        <div class="py-2">
                                            <a href="{{ route('admin.master-kegiatan.jenis.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.master-kegiatan.jenis.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-list w-5 text-center"></i>
                                                <span>Jenis Kegiatan</span>
                                            </a>

                                            <a href="{{ route('admin.master-kegiatan.ruang-lingkup.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.master-kegiatan.ruang-lingkup.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-globe w-5 text-center"></i>
                                                <span>Ruang Lingkup</span>
                                            </a>

                                            <a href="{{ route('admin.master-kegiatan.detail.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.master-kegiatan.detail.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-info-circle w-5 text-center"></i>
                                                <span>Detail Kegiatan</span>
                                            </a>

                                            <a href="{{ route('admin.master-kegiatan.nilai.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.master-kegiatan.nilai.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-star w-5 text-center"></i>
                                                <span>Nilai Kegiatan</span>
                                            </a>

                                            <a href="{{ route('admin.lomba-kategori.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.lomba-kategori.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-trophy w-5 text-center"></i>
                                                <span>Kategori Lomba</span>
                                            </a>

                                            <a href="{{ route('admin.jenis-rekognisi.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.jenis-rekognisi.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-certificate w-5 text-center"></i>
                                                <span>Jenis Rekognisi</span>
                                            </a>

                                            <div class="border-t border-gray-100 my-2"></div>

                                            <a href="{{ route('admin.kategori-kegiatan-umum.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.kategori-kegiatan-umum.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-folder w-5 text-center"></i>
                                                <span>Kategori Kegiatan Umum</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2">
                            <i class="fas fa-database"></i>
                            <span>Data</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute left-0 mt-1 w-64 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left z-50">
                            <div class="py-2">
                                <a href="{{ route('admin.mahasiswa.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                    <i class="fas fa-users w-5 text-center"></i>
                                    <span>Mahasiswa</span>
                                </a>

                                <a href="{{ route('admin.dosen.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.dosen.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                    <i class="fas fa-chalkboard-teacher w-5 text-center"></i>
                                    <span>Dosen</span>
                                </a>

                                <div class="border-t border-gray-100 my-2"></div>

                                <!-- Nested Dropdown: Kegiatan -->
                                <div class="relative group/kegiatan-data">
                                    <button class="w-full px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center justify-between gap-3 text-gray-700">
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-calendar-alt w-5 text-center"></i>
                                            <span>Kegiatan</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </button>
                                    <div class="absolute left-full top-0 ml-1 w-56 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover/kegiatan-data:opacity-100 group-hover/kegiatan-data:visible transition-all duration-200 transform origin-top-left z-50">
                                        <div class="py-2">
                                            <a href="{{ route('admin.antrian-verifikasi.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.antrian-verifikasi.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-list-ol w-5 text-center"></i>
                                                <span>Antrian Verifikasi</span>
                                            </a>

                                            <a href="{{ route('admin.kompetisi.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.kompetisi.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-medal w-5 text-center"></i>
                                                <span>Kompetisi</span>
                                            </a>

                                            <a href="{{ route('admin.rekognisi.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.rekognisi.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-award w-5 text-center"></i>
                                                <span>Rekognisi</span>
                                            </a>

                                            <a href="{{ route('admin.sertifikasi.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.sertifikasi.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-certificate w-5 text-center"></i>
                                                <span>Sertifikasi</span>
                                            </a>

                                            <div class="border-t border-gray-100 my-2"></div>

                                            <a href="{{ route('admin.kegiatan-umum.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.kegiatan-umum.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-folder-open w-5 text-center"></i>
                                                <span>Kegiatan Umum</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-100 my-2"></div>

                                <!-- Nested Dropdown: Beasiswa -->
                                <div class="relative group/beasiswa-data">
                                    <button class="w-full px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center justify-between gap-3 text-gray-700">
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-graduation-cap w-5 text-center"></i>
                                            <span>Beasiswa</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </button>
                                    <div class="absolute left-full top-0 ml-1 w-56 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover/beasiswa-data:opacity-100 group-hover/beasiswa-data:visible transition-all duration-200 transform origin-top-left z-50">
                                        <div class="py-2">
                                            <a href="{{ route('admin.beasiswa.data.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.beasiswa.data.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-list w-5 text-center"></i>
                                                <span>List Data</span>
                                            </a>

                                            <a href="{{ route('admin.laporan.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-file-alt w-5 text-center"></i>
                                                <span>Laporan</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-100 my-2"></div>

                                <!-- Nested Dropdown: Magang -->
                                <div class="relative group/magang-data">
                                    <button class="w-full px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center justify-between gap-3 text-gray-700">
                                        <div class="flex items-center gap-3">
                                            <i class="fas fa-briefcase w-5 text-center"></i>
                                            <span>Magang</span>
                                        </div>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </button>
                                    <div class="absolute left-full top-0 ml-1 w-56 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover/magang-data:opacity-100 group-hover/magang-data:visible transition-all duration-200 transform origin-top-left z-50">
                                        <div class="py-2">
                                            <a href="{{ route('admin.magang.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.magang.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-list w-5 text-center"></i>
                                                <span>List Data</span>
                                            </a>

                                            <a href="{{ route('admin.laporan-magang.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.laporan-magang.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                                <i class="fas fa-file-contract w-5 text-center"></i>
                                                <span>Laporan</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Umum Dropdown -->
                    <div class="relative group">
                        <button class="px-4 py-2 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2">
                            <i class="fas fa-bullhorn"></i>
                            <span>Umum</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute left-0 mt-1 w-56 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left z-50">
                            <div class="py-2">
                                <a href="{{ route('admin.pengumuman.index') }}" class="block px-4 py-3 hover:bg-blue-50 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.pengumuman.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                                    <i class="fas fa-bullhorn w-5 text-center"></i>
                                    <span>Pengumuman</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('admin')->user()->name }}</p>
                        <p class="text-xs text-blue-200">Administrator</p>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button id="mobileMenuBtn" class="xl:hidden bg-white/20 hover:bg-white/30 p-2 rounded-lg transition duration-200">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Logout Button -->
                    <form action="{{ route('admin.logout') }}" method="POST" class="hidden xl:inline">
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
        <div id="mobileMenu" class="hidden xl:hidden border-t border-white/20">
            <div class="px-4 py-2 space-y-2 max-h-[70vh] overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <!-- Master Section -->
                <div class="pt-2 border-t border-white/20">
                    <div class="flex items-center gap-3 px-4 py-2 text-blue-200 font-semibold">
                        <i class="fas fa-database w-5"></i>
                        <span>Master</span>
                    </div>
                    <div class="ml-4 space-y-1">
                        <a href="{{ route('admin.profile') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.profile') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-user-circle w-5"></i>
                            <span>Profil</span>
                        </a>

                        <a href="{{ route('admin.program-studi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.program-studi.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-graduation-cap w-5"></i>
                            <span>Program Studi</span>
                        </a>

                        <a href="{{ route('admin.tahun-ajar.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.tahun-ajar.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-calendar-alt w-5"></i>
                            <span>Tahun Ajar</span>
                        </a>

                        <a href="{{ route('admin.beasiswa.tipe.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.beasiswa.tipe.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-award w-5"></i>
                            <span>Tipe Beasiswa</span>
                        </a>

                        <!-- Collapsible Kegiatan Submenu -->
                        <div>
                            <button onclick="toggleKegiatanSubmenu()" class="w-full px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-calendar-alt w-5"></i>
                                    <span>Kegiatan</span>
                                </div>
                                <i id="kegiatanArrow" class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                            </button>
                            <div id="kegiatanSubmenu" class="hidden ml-4 space-y-1">
                                <a href="{{ route('admin.master-kegiatan.jenis.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.master-kegiatan.jenis.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-list w-5"></i>
                                    <span>Jenis Kegiatan</span>
                                </a>

                                <a href="{{ route('admin.master-kegiatan.ruang-lingkup.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.master-kegiatan.ruang-lingkup.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-globe w-5"></i>
                                    <span>Ruang Lingkup</span>
                                </a>

                                <a href="{{ route('admin.master-kegiatan.detail.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.master-kegiatan.detail.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-info-circle w-5"></i>
                                    <span>Detail Kegiatan</span>
                                </a>

                                <a href="{{ route('admin.master-kegiatan.nilai.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.master-kegiatan.nilai.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-star w-5"></i>
                                    <span>Nilai Kegiatan</span>
                                </a>

                                <a href="{{ route('admin.lomba-kategori.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.lomba-kategori.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-trophy w-5"></i>
                                    <span>Kategori Lomba</span>
                                </a>

                                <a href="{{ route('admin.jenis-rekognisi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.jenis-rekognisi.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-certificate w-5"></i>
                                    <span>Jenis Rekognisi</span>
                                </a>

                                <div class="border-t border-white/20 my-2"></div>

                                <a href="{{ route('admin.kategori-kegiatan-umum.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.kategori-kegiatan-umum.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-folder w-5"></i>
                                    <span>Kategori Kegiatan Umum</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Section -->
                <div class="pt-2 border-t border-white/20">
                    <div class="flex items-center gap-3 px-4 py-2 text-blue-200 font-semibold">
                        <i class="fas fa-database w-5"></i>
                        <span>Data</span>
                    </div>
                    <div class="ml-4 space-y-1">
                        <a href="{{ route('admin.mahasiswa.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-users w-5"></i>
                            <span>Mahasiswa</span>
                        </a>

                        <a href="{{ route('admin.dosen.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.dosen.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-chalkboard-teacher w-5"></i>
                            <span>Dosen</span>
                        </a>

                        <!-- Collapsible Kegiatan Submenu -->
                        <div>
                            <button onclick="toggleKegiatanDataSubmenu()" class="w-full px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-calendar-alt w-5"></i>
                                    <span>Kegiatan</span>
                                </div>
                                <i id="kegiatanDataArrow" class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                            </button>
                            <div id="kegiatanDataSubmenu" class="hidden ml-4 space-y-1">
                                <a href="{{ route('admin.antrian-verifikasi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.antrian-verifikasi.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-list-ol w-5"></i>
                                    <span>Antrian Verifikasi</span>
                                </a>

                                <a href="{{ route('admin.kompetisi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.kompetisi.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-medal w-5"></i>
                                    <span>Kompetisi</span>
                                </a>

                                <a href="{{ route('admin.rekognisi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.rekognisi.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-award w-5"></i>
                                    <span>Rekognisi</span>
                                </a>

                                <a href="{{ route('admin.sertifikasi.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.sertifikasi.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-certificate w-5"></i>
                                    <span>Sertifikasi</span>
                                </a>

                                <div class="border-t border-white/20 my-2"></div>

                                <a href="{{ route('admin.kegiatan-umum.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.kegiatan-umum.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-folder-open w-5"></i>
                                    <span>Kegiatan Umum</span>
                                </a>
                            </div>
                        </div>

                        <!-- Collapsible Beasiswa Submenu -->
                        <div>
                            <button onclick="toggleBeasiswaSubmenu()" class="w-full px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-graduation-cap w-5"></i>
                                    <span>Beasiswa</span>
                                </div>
                                <i id="beasiswaArrow" class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                            </button>
                            <div id="beasiswaSubmenu" class="hidden ml-4 space-y-1">
                                <a href="{{ route('admin.beasiswa.data.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.beasiswa.data.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-list w-5"></i>
                                    <span>List Data</span>
                                </a>

                                <a href="{{ route('admin.laporan.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.laporan.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-file-alt w-5"></i>
                                    <span>Laporan</span>
                                </a>
                            </div>
                        </div>

                        <!-- Collapsible Magang Submenu -->
                        <div>
                            <button onclick="toggleMagangSubmenu()" class="w-full px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-briefcase w-5"></i>
                                    <span>Magang</span>
                                </div>
                                <i id="magangArrow" class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                            </button>
                            <div id="magangSubmenu" class="hidden ml-4 space-y-1">
                                <a href="{{ route('admin.magang.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.magang.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-list w-5"></i>
                                    <span>List Data</span>
                                </a>

                                <a href="{{ route('admin.laporan-magang.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.laporan-magang.*') ? 'bg-white/20' : '' }}">
                                    <i class="fas fa-file-contract w-5"></i>
                                    <span>Laporan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Umum Section -->
                <div class="pt-2 border-t border-white/20">
                    <div class="flex items-center gap-3 px-4 py-2 text-blue-200 font-semibold">
                        <i class="fas fa-bullhorn w-5"></i>
                        <span>Umum</span>
                    </div>
                    <div class="ml-4 space-y-1">
                        <a href="{{ route('admin.pengumuman.index') }}" class="block px-4 py-3 rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-3 {{ request()->routeIs('admin.pengumuman.*') ? 'bg-white/20' : '' }}">
                            <i class="fas fa-bullhorn w-5"></i>
                            <span>Pengumuman</span>
                        </a>
                    </div>
                </div>
                
                <form action="{{ route('admin.logout') }}" method="POST" class="pt-2 border-t border-white/20 mt-2">
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
    <footer class="bg-white border-t mt-12 py-6">
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

        // Toggle Kegiatan submenu on mobile
        function toggleKegiatanSubmenu() {
            const submenu = document.getElementById('kegiatanSubmenu');
            const arrow = document.getElementById('kegiatanArrow');
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        // Toggle Kegiatan Data submenu on mobile
        function toggleKegiatanDataSubmenu() {
            const submenu = document.getElementById('kegiatanDataSubmenu');
            const arrow = document.getElementById('kegiatanDataArrow');
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        // Toggle Beasiswa submenu on mobile
        function toggleBeasiswaSubmenu() {
            const submenu = document.getElementById('beasiswaSubmenu');
            const arrow = document.getElementById('beasiswaArrow');
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        // Toggle Magang submenu on mobile
        function toggleMagangSubmenu() {
            const submenu = document.getElementById('magangSubmenu');
            const arrow = document.getElementById('magangArrow');
            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>
    @stack('scripts')
</body>
</html>
