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
                            <i class="fas fa-calendar-alt"></i>
                            Angkatan {{ $mahasiswa->tahun_masuk }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('mahasiswa.profile') }}" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-lg transition duration-200 flex items-center gap-2 backdrop-blur-sm">
                    <i class="fas fa-edit"></i>
                    <span class="hidden md:inline">Edit Profil</span>
                </a>
            </div>
        </div>

        <!-- Status Beasiswa Card -->
        @if($beasiswaAktif)
            <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl shadow-lg p-6 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-1">Status Beasiswa Aktif</h3>
                            <p class="text-blue-100 text-lg">{{ $beasiswaAktif->beasiswaTipe->nama }}</p>
                            <p class="text-blue-200 text-sm mt-1">
                                <i class="fas fa-file-alt mr-1"></i> SK: {{ $beasiswaAktif->nomor_sk }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="bg-white/20 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i> Aktif
                        </span>
                        <p class="text-blue-200 text-xs mt-2">
                            <i class="fas fa-calendar mr-1"></i> Mulai: {{ $beasiswaAktif->tanggal_mulai->format('d M Y') }}
                        </p>
                        @if($beasiswaAktif->tanggal_berakhir)
                            <p class="text-blue-200 text-xs">
                                <i class="fas fa-calendar-check mr-1"></i> Berakhir: {{ $beasiswaAktif->tanggal_berakhir->format('d M Y') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8 border-l-4 border-gray-300">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-3xl text-gray-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Tidak Ada Beasiswa Aktif</h3>
                        <p class="text-gray-500">Anda saat ini tidak terdaftar dalam program beasiswa.</p>
                    </div>
                </div>
            </div>
        @endif

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

            <!-- Kegiatan Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Kegiatan</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $totalKegiatan }}</h3>
                    </div>
                </div>
            </div>

            <!-- Pengumuman Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pengumuman Baru</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $pengumumanTerbaru->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengumuman Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-bullhorn text-orange-600"></i>
                    Pengumuman Terbaru
                </h3>
                <a href="{{ route('mahasiswa.pengumuman.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-4">
                @forelse($pengumumanTerbaru as $pengumuman)
                    <a href="{{ route('mahasiswa.pengumuman.show', $pengumuman->id) }}" class="block">
                        <div class="border-l-4 {{ $pengumuman->prioritas === 'tinggi' ? 'border-red-500 bg-red-50' : ($pengumuman->kategori === 'beasiswa' ? 'border-blue-500 bg-blue-50' : 'border-green-500 bg-green-50') }} p-4 rounded-r-lg hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-semibold px-2 py-1 rounded {{ $pengumuman->kategori === 'beasiswa' ? 'bg-blue-200 text-blue-700' : ($pengumuman->kategori === 'akademik' ? 'bg-purple-200 text-purple-700' : 'bg-green-200 text-green-700') }}">
                                            {{ ucfirst($pengumuman->kategori) }}
                                        </span>
                                        @if($pengumuman->prioritas === 'tinggi')
                                            <span class="text-xs font-semibold px-2 py-1 rounded bg-red-200 text-red-700">
                                                <i class="fas fa-exclamation-triangle mr-1"></i> Penting
                                            </span>
                                        @endif
                                    </div>
                                    <h4 class="font-semibold text-gray-800 mb-1">{{ $pengumuman->judul }}</h4>
                                    <p class="text-gray-600 text-sm">{{ Str::limit($pengumuman->konten, 100) }}</p>
                                    <p class="text-gray-400 text-xs mt-2">
                                        <i class="fas fa-clock mr-1"></i>{{ $pengumuman->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="ml-4">
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                        <p>Belum ada pengumuman.</p>
                    </div>
                @endforelse
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

            <a href="{{ route('mahasiswa.antrian-verifikasi.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-list-ol text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-indigo-600 transition mb-1">Antrian Verifikasi</h3>
                        <p class="text-sm text-gray-500">Daftar antrian verifikasi</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('mahasiswa.laporan.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-file-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-purple-600 transition mb-1">Laporan Beasiswa</h3>
                        <p class="text-sm text-gray-500">Kelola laporan beasiswa</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('mahasiswa.laporan-magang.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-briefcase text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-orange-600 transition mb-1">Laporan Magang</h3>
                        <p class="text-sm text-gray-500">Kelola laporan magang</p>
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
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200 shrink-0">
                        <i class="fas fa-certificate text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-red-600 transition mb-1">Sertifikat</h3>
                        <p class="text-sm text-gray-500">Sertifikat kegiatan</p>
                    </div>
                </div>
            </a>
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
