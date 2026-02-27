<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Beasiswa - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-green-600 to-emerald-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.laporan.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Kembali</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p>
                        <p class="text-xs text-green-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p>
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

    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-file-alt mr-2"></i>
                        Detail Laporan Beasiswa
                    </h2>
                    <p class="text-purple-100 text-sm">Informasi lengkap laporan Anda</p>
                </div>
                <div class="text-right">
                    @if($laporan->status === 'draft')
                        <span class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-file mr-1"></i> Draft
                        </span>
                    @elseif($laporan->status === 'submitted')
                        <span class="bg-yellow-200 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-clock mr-1"></i> Submitted
                        </span>
                    @elseif($laporan->status === 'approved')
                        <span class="bg-green-200 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i> Approved
                        </span>
                    @else
                        <span class="bg-red-200 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-times-circle mr-1"></i> Rejected
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-medium">Tahun Ajar</p>
                        <p class="text-gray-800 font-bold">{{ $laporan->tahunAjar->nama }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-medium">Semester</p>
                        <p class="text-gray-800 font-bold">Semester {{ $laporan->semester }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-medium">Beasiswa</p>
                        <p class="text-gray-800 font-bold text-sm">{{ $laporan->beasiswaTipe->nama }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Data Akademik -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-graduation-cap text-blue-600"></i>
                1. Data Akademik
            </h3>
            @if($laporan->laporanAkademik)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-gray-500 text-xs mb-1">SKS</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $laporan->laporanAkademik->sks }}</p>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-gray-500 text-xs mb-1">Indeks Prestasi</p>
                        <p class="text-2xl font-bold text-blue-700">{{ number_format($laporan->laporanAkademik->indeks_prestasi, 2) }}</p>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-gray-500 text-xs mb-1">File KHS</p>
                        @if($laporan->laporanAkademik->file_khs)
                            <a href="{{ Storage::url($laporan->laporanAkademik->file_khs) }}" target="_blank" 
                               class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                <i class="fas fa-file-pdf"></i>
                                Lihat KHS
                            </a>
                        @else
                            <p class="text-gray-400 text-sm">-</p>
                        @endif
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada data akademik.</p>
            @endif
        </div>

        <!-- 2. Referal -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-user-friends text-green-600"></i>
                2. Referal
            </h3>
            @if($laporan->laporanReferals && $laporan->laporanReferals->count() > 0)
                <div class="space-y-3">
                    @foreach($laporan->laporanReferals as $referal)
                        <div class="p-4 bg-green-50 rounded-lg grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-gray-500 text-xs">Nama</p>
                                <p class="font-semibold text-gray-800">{{ $referal->nama }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">No. Telepon</p>
                                <p class="font-semibold text-gray-800">{{ $referal->no_telp }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">Program Studi</p>
                                <p class="font-semibold text-gray-800">{{ $referal->program_studi }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada data referal.</p>
            @endif
        </div>

        <!-- 3. Pendanaan -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-money-bill-wave text-orange-600"></i>
                3. Pendanaan
            </h3>
            @if($laporan->laporanPendanaans && $laporan->laporanPendanaans->count() > 0)
                <div class="space-y-3">
                    @foreach($laporan->laporanPendanaans as $pendanaan)
                        <div class="p-4 bg-orange-50 rounded-lg space-y-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-500 text-xs">Nama Pendanaan</p>
                                    <p class="font-semibold text-gray-800">{{ $pendanaan->nama_pendanaan }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Judul</p>
                                    <p class="font-semibold text-gray-800">{{ $pendanaan->judul }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 text-xs">Keterangan</p>
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $pendanaan->keterangan === 'lolos' ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                                        {{ ucfirst($pendanaan->keterangan) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Posisi</p>
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-gray-200 text-gray-700">
                                        {{ ucfirst($pendanaan->posisi) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">File Bukti</p>
                                    @if($pendanaan->file_bukti)
                                        <a href="{{ Storage::url($pendanaan->file_bukti) }}" target="_blank" 
                                           class="text-orange-600 hover:underline text-sm flex items-center gap-1">
                                            <i class="fas fa-file-pdf"></i>
                                            Lihat
                                        </a>
                                    @else
                                        <p class="text-gray-400 text-sm">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada data pendanaan.</p>
            @endif
        </div>

        <!-- 4. Kompetisi -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-trophy text-yellow-600"></i>
                4. Kompetisi
            </h3>
            @if($laporan->laporanKompetisis && $laporan->laporanKompetisis->count() > 0)
                <div class="space-y-3">
                    @foreach($laporan->laporanKompetisis as $kompetisi)
                        <div class="p-4 bg-yellow-50 rounded-lg space-y-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-500 text-xs">Nama Kompetisi</p>
                                    <p class="font-semibold text-gray-800">{{ $kompetisi->nama_kompetisi }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Judul</p>
                                    <p class="font-semibold text-gray-800">{{ $kompetisi->judul }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 text-xs">Juara</p>
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-yellow-200 text-yellow-700">
                                        {{ $kompetisi->juara ?? '-' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Posisi</p>
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-gray-200 text-gray-700">
                                        {{ ucfirst($kompetisi->posisi) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">File Bukti</p>
                                    @if($kompetisi->file_bukti)
                                        <a href="{{ Storage::url($kompetisi->file_bukti) }}" target="_blank" 
                                           class="text-yellow-600 hover:underline text-sm flex items-center gap-1">
                                            <i class="fas fa-file-pdf"></i>
                                            Lihat
                                        </a>
                                    @else
                                        <p class="text-gray-400 text-sm">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada data kompetisi.</p>
            @endif
        </div>

        <!-- 5. Publikasi -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-newspaper text-red-600"></i>
                5. Publikasi
            </h3>
            @if($laporan->laporanPublikasis && $laporan->laporanPublikasis->count() > 0)
                <div class="space-y-3">
                    @foreach($laporan->laporanPublikasis as $publikasi)
                        <div class="p-4 bg-red-50 rounded-lg space-y-2">
                            <div>
                                <p class="text-gray-500 text-xs">Judul Publikasi</p>
                                <p class="font-semibold text-gray-800">{{ $publikasi->judul }}</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 text-xs">Nama Tempat</p>
                                    <p class="font-semibold text-gray-800">{{ $publikasi->nama_tempat }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Kategori</p>
                                    <span class="px-2 py-1 rounded text-xs font-semibold bg-red-200 text-red-700">
                                        {{ $publikasi->kategori ?? '-' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-xs">Link Jurnal</p>
                                    @if($publikasi->link_jurnal)
                                        <a href="{{ $publikasi->link_jurnal }}" target="_blank" 
                                           class="text-red-600 hover:underline text-sm flex items-center gap-1">
                                            <i class="fas fa-external-link-alt"></i>
                                            Buka Link
                                        </a>
                                    @else
                                        <p class="text-gray-400 text-sm">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tidak ada data publikasi.</p>
            @endif
        </div>

        <!-- Timeline Status -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-history text-purple-600"></i>
                Timeline Status
            </h3>
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ $laporan->created_at ? 'bg-gray-600' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="fas fa-file text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Dibuat</p>
                            <p class="text-gray-500 text-xs">{{ $laporan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ $laporan->submitted_at ? 'bg-yellow-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Submitted</p>
                            <p class="text-gray-500 text-xs">{{ $laporan->submitted_at ? $laporan->submitted_at->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ $laporan->approved_at ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Approved</p>
                            <p class="text-gray-500 text-xs">{{ $laporan->approved_at ? $laporan->approved_at->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pb-8">
            @if($laporan->status === 'draft')
                <a href="{{ route('mahasiswa.laporan.edit', $laporan->id) }}"
                   class="flex-1 bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition duration-200 font-semibold shadow-md text-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Laporan
                </a>
            @endif
            <a href="{{ route('mahasiswa.laporan.index') }}"
               class="flex-1 bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-200 font-semibold shadow-md text-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar
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
