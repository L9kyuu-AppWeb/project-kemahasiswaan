<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Dashboard - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-green-600 to-emerald-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-graduate text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Mahasiswa Dashboard</h1>
                        <p class="text-xs text-green-200">Sistem Kemahasiswaan</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ $mahasiswa->name }}</p>
                        <p class="text-xs text-green-200">{{ $mahasiswa->nim }}</p>
                    </div>
                    <form action="{{ route('mahasiswa.logout') }}" method="POST" class="inline">
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
        <!-- Profile Card -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-8 mb-8 text-white">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-user-circle text-5xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-3xl font-bold mb-2">{{ $mahasiswa->name }}</h2>
                    <div class="flex flex-wrap gap-4 text-green-100">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-id-card"></i>
                            {{ $mahasiswa->nim }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-envelope"></i>
                            {{ $mahasiswa->email }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-graduation-cap"></i>
                            Angkatan {{ $mahasiswa->tahun_masuk }}
                        </span>
                        @if($mahasiswa->programStudi)
                            <span class="flex items-center gap-2">
                                <i class="fas fa-university"></i>
                                {{ $mahasiswa->programStudi->nama }}
                            </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('mahasiswa.profile') }}" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-lg transition duration-200 flex items-center gap-2 backdrop-blur-sm">
                    <i class="fas fa-edit"></i>
                    <span class="hidden md:inline">Edit Profil</span>
                </a>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Status</p>
                        <h3 class="text-xl font-bold text-gray-800">Aktif</h3>
                    </div>
                </div>
            </div>

            <!-- Semester Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-book text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Semester</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ date('Y') - $mahasiswa->tahun_masuk }} (Estimasi)</h3>
                    </div>
                </div>
            </div>

            <!-- SKS Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-award text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">SKS Diambil</p>
                        <h3 class="text-xl font-bold text-gray-800">-</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('mahasiswa.profile') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-green-600 transition mb-1">Profil Saya</h3>
                        <p class="text-sm text-gray-500">Lihat dan edit profil pribadi</p>
                    </div>
                </div>
            </a>

            <a href="#" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100 opacity-60">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition mb-1">Kegiatan</h3>
                        <p class="text-sm text-gray-500">Daftar kegiatan kemahasiswaan</p>
                    </div>
                </div>
            </a>

            <a href="#" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100 opacity-60">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-history text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-purple-600 transition mb-1">Riwayat</h3>
                        <p class="text-sm text-gray-500">Riwayat kegiatan dan prestasi</p>
                    </div>
                </div>
            </a>

            <a href="#" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100 opacity-60">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-orange-600 transition mb-1">Transkrip</h3>
                        <p class="text-sm text-gray-500">Lihat transkrip nilai</p>
                    </div>
                </div>
            </a>

            <a href="#" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100 opacity-60">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-certificate text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-red-600 transition mb-1">Sertifikat</h3>
                        <p class="text-sm text-gray-500">Sertifikat kegiatan</p>
                    </div>
                </div>
            </a>

            <a href="#" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100 opacity-60">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-teal-600 transition mb-1">Pengumuman</h3>
                        <p class="text-sm text-gray-500">Pengumuman terbaru</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Info Section -->
        <div class="mt-8 bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-green-600"></i>
                Informasi Program Studi
            </h3>
            @if($mahasiswa->programStudi)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Program Studi</p>
                        <p class="font-semibold text-gray-800">{{ $mahasiswa->programStudi->nama }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Kode Prodi</p>
                        <p class="font-semibold text-gray-800">{{ $mahasiswa->programStudi->kode }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Singkatan</p>
                        <p class="font-semibold text-gray-800">{{ $mahasiswa->programStudi->singkatan ?? '-' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
                        <p class="font-semibold text-gray-800">{{ Str::limit($mahasiswa->programStudi->deskripsi ?? 'Tidak ada deskripsi', 50) }}</p>
                    </div>
                </div>
            @else
                <p class="text-gray-500">Belum ada program studi yang ditetapkan.</p>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-sm border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
