<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-shield text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Admin Dashboard</h1>
                        <p class="text-xs text-blue-200">Sistem Kemahasiswaan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('admin')->user()->name }}</p>
                        <p class="text-xs text-blue-200">Administrator</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition duration-200 flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg p-8 mb-8 text-white">
            <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->guard('admin')->user()->name }}! 👋</h2>
            <p class="text-blue-100">Kelola data kemahasiswaan dengan mudah dan efisien.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Mahasiswa -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Mahasiswa</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ number_format($totalMahasiswa) }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Program Studi -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Program Studi</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ number_format($totalProgramStudi) }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Mahasiswa per Tahun -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Tahun Aktif</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ $mahasiswaPerTahun->count() }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Menu Cepat</p>
                        <h3 class="text-lg font-bold text-gray-800">Aksi</h3>
                    </div>
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-orange-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Detail Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Mahasiswa per Program Studi -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-pie text-blue-600"></i>
                    Mahasiswa per Program Studi
                </h3>
                <div class="space-y-3">
                    @forelse($mahasiswaPerProdi as $data)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">{{ substr($data->programStudi->nama ?? 'N/A', 0, 2) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $data->programStudi->nama ?? 'Tidak Ada Prodi' }}</p>
                                    <p class="text-xs text-gray-500">{{ $data->programStudi->singkatan ?? '-' }}</p>
                                </div>
                            </div>
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $data->total }} Mhs
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada data mahasiswa.</p>
                    @endforelse
                </div>
            </div>

            <!-- Mahasiswa per Tahun Masuk -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-green-600"></i>
                    Mahasiswa per Tahun Masuk
                </h3>
                <div class="space-y-3">
                    @forelse($mahasiswaPerTahun as $data)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Angkatan {{ $data->tahun_masuk }}</p>
                                    <p class="text-xs text-gray-500">Tahun Akademik</p>
                                </div>
                            </div>
                            <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $data->total }} Mhs
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada data mahasiswa.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Menu Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('admin.profile') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                        <i class="fas fa-user-circle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition">Profil Saya</h3>
                        <p class="text-sm text-gray-500">Kelola akun Anda</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.program-studi.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-purple-600 transition">Program Studi</h3>
                        <p class="text-sm text-gray-500">Kelola prodi</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.mahasiswa.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-green-600 transition">Mahasiswa</h3>
                        <p class="text-sm text-gray-500">Kelola data mhs</p>
                    </div>
                </div>
            </a>

            <a href="#" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100 opacity-50">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Kegiatan</h3>
                        <p class="text-sm text-gray-500">Segera hadir</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
