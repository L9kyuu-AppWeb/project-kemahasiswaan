<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mahasiswa Magang - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.magang.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Kembali</span>
                    </a>
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

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-briefcase mr-2"></i>
                Detail Mahasiswa Magang
            </h2>
            <p class="text-emerald-100 text-sm">Informasi lengkap mahasiswa magang</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Detail Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Status Badge -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white">
                        {{ $magang->mahasiswa->name }}
                    </h3>
                    @if($magang->status === 'aktif')
                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-circle text-[8px] mr-1"></i> Aktif
                        </span>
                    @elseif($magang->status === 'selesai')
                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i> Selesai
                        </span>
                    @else
                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-times-circle mr-1"></i> Tidak Aktif
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mahasiswa Info -->
                    <div class="space-y-3">
                        <h4 class="font-semibold text-gray-700 border-b pb-2">
                            <i class="fas fa-user-graduate mr-2 text-emerald-600"></i>
                            Informasi Mahasiswa
                        </h4>
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-medium text-gray-800">{{ $magang->mahasiswa->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIM</p>
                            <p class="font-medium text-gray-800">{{ $magang->mahasiswa->nim }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Program Studi</p>
                            <p class="font-medium text-gray-800">{{ $magang->mahasiswa->programStudi->nama ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Akademik Info -->
                    <div class="space-y-3">
                        <h4 class="font-semibold text-gray-700 border-b pb-2">
                            <i class="fas fa-graduation-cap mr-2 text-emerald-600"></i>
                            Informasi Akademik
                        </h4>
                        <div>
                            <p class="text-sm text-gray-500">Tahun Ajar</p>
                            <p class="font-medium text-gray-800">{{ $magang->tahunAjar->nama }} ({{ ucfirst($magang->tahunAjar->semester) }})</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Semester</p>
                            <p class="font-medium text-gray-800">Semester {{ $magang->semester }}</p>
                        </div>
                    </div>

                    <!-- Perusahaan Info -->
                    <div class="space-y-3 md:col-span-2">
                        <h4 class="font-semibold text-gray-700 border-b pb-2">
                            <i class="fas fa-building mr-2 text-emerald-600"></i>
                            Informasi Perusahaan
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama Perusahaan</p>
                                <p class="font-medium text-gray-800">{{ $magang->nama_perusahaan }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Lokasi</p>
                                <p class="font-medium text-gray-800">{{ $magang->lokasi_perusahaan }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pembimbing Info -->
                    <div class="space-y-3 md:col-span-2">
                        <h4 class="font-semibold text-gray-700 border-b pb-2">
                            <i class="fas fa-user-tie mr-2 text-emerald-600"></i>
                            Informasi Pembimbing
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Pembimbing Lapangan</p>
                                <p class="font-medium text-gray-800">{{ $magang->pembimbing_lapangan ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">No. Telp</p>
                                <p class="font-medium text-gray-800">{{ $magang->no_telp_pembimbing ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Dosen Pembimbing</p>
                                <p class="font-medium text-gray-800">{{ $magang->dosen_pembimbing_nama ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">NIK Dosen Pembimbing</p>
                                <p class="font-medium text-gray-800">{{ $magang->dosen_pembimbing_nik ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Periode Info -->
                    <div class="space-y-3 md:col-span-2">
                        <h4 class="font-semibold text-gray-700 border-b pb-2">
                            <i class="fas fa-calendar-alt mr-2 text-emerald-600"></i>
                            Periode Magang
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Mulai</p>
                                <p class="font-medium text-gray-800">{{ $magang->tanggal_mulai->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Selesai</p>
                                <p class="font-medium text-gray-800">{{ $magang->tanggal_selesai->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    @if($magang->catatan)
                        <div class="space-y-3 md:col-span-2">
                            <h4 class="font-semibold text-gray-700 border-b pb-2">
                                <i class="fas fa-sticky-note mr-2 text-emerald-600"></i>
                                Catatan
                            </h4>
                            <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $magang->catatan }}</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 mt-8 pt-6 border-t">
                    <a href="{{ route('admin.magang.edit', $magang->id) }}"
                       class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <form action="{{ route('admin.magang.destroy', $magang->id) }}" method="POST" class="flex-1"
                          onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg">
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
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
