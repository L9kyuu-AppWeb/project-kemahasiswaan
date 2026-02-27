<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Magang - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-orange-50 to-amber-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-orange-600 to-amber-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Dashboard</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p>
                        <p class="text-xs text-orange-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p>
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
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-briefcase mr-2"></i>
                        Laporan Magang
                    </h2>
                    <p class="text-orange-100 text-sm">Kelola laporan kegiatan magang Anda</p>
                </div>
                <a href="{{ route('mahasiswa.laporan-magang.create') }}"
                   class="bg-white text-orange-600 hover:bg-orange-50 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center gap-2 shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    Buat Laporan Baru
                </a>
            </div>
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

        <!-- Info Card -->
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="text-orange-600 text-2xl">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-orange-800 mb-2">Informasi Magang Aktif</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-orange-700">
                        <div>
                            <p class="text-orange-500">Perusahaan</p>
                            <p class="font-medium">{{ $magangAktif->nama_perusahaan }}</p>
                        </div>
                        <div>
                            <p class="text-orange-500">Lokasi</p>
                            <p class="font-medium">{{ $magangAktif->lokasi_perusahaan }}</p>
                        </div>
                        <div>
                            <p class="text-orange-500">Periode</p>
                            <p class="font-medium">{{ $magangAktif->tanggal_mulai->format('d M Y') }} - {{ $magangAktif->tanggal_selesai->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-orange-500">Dosen Pembimbing</p>
                            <p class="font-medium">{{ $magangAktif->dosen_pembimbing_nama ?? '-' }} {{ $magangAktif->dosen_pembimbing_nik ? '(' . $magangAktif->dosen_pembimbing_nik . ')' : '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan List -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-orange-50 to-amber-50">
                        <tr>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul Laporan</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Log Kegiatan</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($laporans as $laporan)
                            <tr class="hover:bg-orange-50 transition duration-150">
                                <td class="py-4 px-6">
                                    <p class="font-semibold text-gray-800">{{ $laporan->judul_laporan }}</p>
                                    <p class="text-sm text-gray-500">{{ Str::limit($laporan->deskripsi, 50) }}</p>
                                </td>
                                <td class="py-4 px-6 text-gray-600">
                                    {{ $laporan->tanggal_kegiatan->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-list mr-1"></i> {{ $laporan->logKegiatans->count() }} Log
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($laporan->status === 'draft')
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-file mr-1"></i> Draft
                                        </span>
                                    @elseif($laporan->status === 'submitted')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-clock mr-1"></i> Submitted
                                        </span>
                                    @elseif($laporan->status === 'approved')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i> Approved
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-times-circle mr-1"></i> Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        <a href="{{ route('mahasiswa.laporan-magang.show', $laporan->id) }}"
                                           class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                            <i class="fas fa-eye"></i>
                                            Detail
                                        </a>
                                        @if($laporan->status === 'draft')
                                            <form action="{{ route('mahasiswa.laporan-magang.destroy', $laporan->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-1">
                                                    <i class="fas fa-trash"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada laporan magang.</p>
                                    <a href="{{ route('mahasiswa.laporan-magang.create') }}" class="text-orange-600 hover:underline mt-2 inline-block">
                                        Buat laporan pertama Anda
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($laporans->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $laporans->links() }}
                </div>
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
