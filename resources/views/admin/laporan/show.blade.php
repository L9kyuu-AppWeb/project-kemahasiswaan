<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Beasiswa - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <i class="fas fa-file-alt mr-2"></i>
                        Detail Laporan Beasiswa
                    </h2>
                    <p class="text-purple-100 text-sm">{{ $laporan->mahasiswa->name }} - {{ $laporan->mahasiswa->nim }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.laporan.download-pdf', $laporan->id) }}"
                       class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition duration-200 font-semibold flex items-center gap-2">
                        <i class="fas fa-file-pdf"></i>
                        Download PDF
                    </a>
                    @if($laporan->status === 'approved')
                        <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i> Approved
                        </span>
                    @elseif($laporan->status === 'rejected')
                        <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-times-circle mr-1"></i> Rejected
                        </span>
                    @elseif($laporan->status === 'submitted')
                        <span class="bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-clock mr-1"></i> Submitted
                        </span>
                    @else
                        <span class="bg-gray-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-file mr-1"></i> Draft
                        </span>
                    @endif
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Info Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Laporan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Mahasiswa</p>
                    <p class="font-medium text-gray-800">{{ $laporan->mahasiswa->name }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">NIM</p>
                    <p class="font-medium text-gray-800">{{ $laporan->mahasiswa->nim }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Program Studi</p>
                    <p class="font-medium text-gray-800">{{ $laporan->mahasiswa->programStudi->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Jenis Beasiswa</p>
                    <p class="font-medium text-gray-800">{{ $laporan->beasiswaTipe->nama }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tahun Ajar</p>
                    <p class="font-medium text-gray-800">{{ $laporan->tahunAjar->nama ?? $laporan->tahunAjar->tahun_mulai . '/' . $laporan->tahunAjar->tahun_akhir }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Semester</p>
                    <p class="font-medium text-gray-800">Semester {{ $laporan->semester }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tanggal Submit</p>
                    <p class="font-medium text-gray-800">{{ $laporan->submitted_at ? $laporan->submitted_at->format('d M Y, H:i') : '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tanggal Approve</p>
                    <p class="font-medium text-gray-800">{{ $laporan->approved_at ? $laporan->approved_at->format('d M Y, H:i') : '-' }}</p>
                </div>
            </div>
        </div>

        <!-- 1. Akademik -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                <i class="fas fa-graduation-cap text-purple-600"></i>
                1. Akademik
            </h3>
            @if($laporan->laporanAkademik)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-gray-500 text-sm">SKS</p>
                        <p class="font-medium text-gray-800">{{ $laporan->laporanAkademik->sks }} SKS</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Indeks Prestasi</p>
                        <p class="font-medium text-gray-800">{{ number_format($laporan->laporanAkademik->indeks_prestasi, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">File KHS</p>
                        @if($laporan->laporanAkademik->file_khs)
                            <a href="{{ Storage::url($laporan->laporanAkademik->file_khs) }}" target="_blank"
                               class="text-purple-600 hover:underline inline-flex items-center gap-1">
                                <i class="fas fa-file-pdf"></i>
                                Download KHS
                            </a>
                        @else
                            <p class="text-gray-400">-</p>
                        @endif
                    </div>
                </div>
            @else
                <p class="text-gray-400">Data akademik belum diisi.</p>
            @endif
        </div>

        <!-- 2. Referal -->
        @if($laporan->laporanReferals && $laporan->laporanReferals->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                    <i class="fas fa-user-friends text-purple-600"></i>
                    2. Referal ({{ $laporan->laporanReferals->count() }})
                </h3>
                <div class="space-y-4">
                    @foreach($laporan->laporanReferals as $referal)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 text-sm">Nama</p>
                                    <p class="font-medium text-gray-800">{{ $referal->nama }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">No. Telp</p>
                                    <p class="font-medium text-gray-800">{{ $referal->no_telp }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Program Studi</p>
                                    <p class="font-medium text-gray-800">{{ $referal->program_studi }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 3. Pendanaan -->
        @if($laporan->laporanPendanaans && $laporan->laporanPendanaans->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                    <i class="fas fa-money-bill-wave text-purple-600"></i>
                    3. Pendanaan ({{ $laporan->laporanPendanaans->count() }})
                </h3>
                <div class="space-y-4">
                    @foreach($laporan->laporanPendanaans as $pendanaan)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <p class="text-gray-500 text-sm">Nama Pendanaan</p>
                                    <p class="font-medium text-gray-800">{{ $pendanaan->nama_pendanaan }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Judul</p>
                                    <p class="font-medium text-gray-800">{{ $pendanaan->judul }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 text-sm">Keterangan</p>
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $pendanaan->keterangan === 'lolos' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $pendanaan->keterangan }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Posisi</p>
                                    <span class="inline-block bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ ucfirst($pendanaan->posisi) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Bukti</p>
                                    @if($pendanaan->file_bukti)
                                        <a href="{{ Storage::url($pendanaan->file_bukti) }}" target="_blank"
                                           class="text-purple-600 hover:underline inline-flex items-center gap-1">
                                            <i class="fas fa-file-pdf"></i>
                                            Download
                                        </a>
                                    @else
                                        <p class="text-gray-400">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 4. Kompetisi -->
        @if($laporan->laporanKompetisis && $laporan->laporanKompetisis->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                    <i class="fas fa-trophy text-purple-600"></i>
                    4. Kompetisi ({{ $laporan->laporanKompetisis->count() }})
                </h3>
                <div class="space-y-4">
                    @foreach($laporan->laporanKompetisis as $kompetisi)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <p class="text-gray-500 text-sm">Nama Kompetisi</p>
                                    <p class="font-medium text-gray-800">{{ $kompetisi->nama_kompetisi }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Judul</p>
                                    <p class="font-medium text-gray-800">{{ $kompetisi->judul }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-gray-500 text-sm">Juara</p>
                                    @if($kompetisi->juara)
                                        <span class="inline-block bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $kompetisi->juara }}
                                        </span>
                                    @else
                                        <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Tidak Juara
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Posisi</p>
                                    <span class="inline-block bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ ucfirst($kompetisi->posisi) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Bukti</p>
                                    @if($kompetisi->file_bukti)
                                        <a href="{{ Storage::url($kompetisi->file_bukti) }}" target="_blank"
                                           class="text-purple-600 hover:underline inline-flex items-center gap-1">
                                            <i class="fas fa-file-pdf"></i>
                                            Download
                                        </a>
                                    @else
                                        <p class="text-gray-400">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- 5. Publikasi -->
        @if($laporan->laporanPublikasis && $laporan->laporanPublikasis->count() > 0)
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                    <i class="fas fa-book text-purple-600"></i>
                    5. Publikasi ({{ $laporan->laporanPublikasis->count() }})
                </h3>
                <div class="space-y-4">
                    @foreach($laporan->laporanPublikasis as $publikasi)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <p class="text-gray-500 text-sm">Judul</p>
                                    <p class="font-medium text-gray-800">{{ $publikasi->judul }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Tempat Publikasi</p>
                                    <p class="font-medium text-gray-800">{{ $publikasi->nama_tempat }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-500 text-sm">Kategori</p>
                                    <span class="inline-block bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $publikasi->kategori }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Link Jurnal</p>
                                    @if($publikasi->link_jurnal)
                                        <a href="{{ $publikasi->link_jurnal }}" target="_blank"
                                           class="text-purple-600 hover:underline inline-flex items-center gap-1">
                                            <i class="fas fa-external-link-alt"></i>
                                            Buka Link
                                        </a>
                                    @else
                                        <p class="text-gray-400">-</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Catatan Admin & Aksi -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Verifikasi Laporan</h3>
            
            @if($laporan->catatan_admin)
                <div class="mb-6">
                    <p class="text-gray-500 text-sm mb-2">Catatan Admin:</p>
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-700">
                        {{ $laporan->catatan_admin }}
                    </div>
                </div>
            @endif

            @if($laporan->status === 'submitted')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Approve Button -->
                    <div>
                        <button onclick="document.getElementById('approveModal').classList.remove('hidden')"
                                class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            Setujui Laporan
                        </button>
                    </div>
                    <!-- Reject Button -->
                    <div>
                        <button onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                                class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition duration-200 font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-times-circle"></i>
                            Tolak Laporan
                        </button>
                    </div>
                </div>
            @elseif($laporan->status === 'approved')
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <p class="text-green-700 font-semibold">
                        <i class="fas fa-check-circle mr-2"></i>
                        Laporan ini telah disetujui pada {{ $laporan->approved_at->format('d M Y, H:i') }}
                    </p>
                </div>
            @elseif($laporan->status === 'rejected')
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                    <p class="text-red-700 font-semibold">
                        <i class="fas fa-times-circle mr-2"></i>
                        Laporan ini ditolak pada {{ $laporan->approved_at ? $laporan->approved_at->format('d M Y, H:i') : '-' }}
                    </p>
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                    <p class="text-gray-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        Laporan ini masih dalam status draft dan belum dapat diverifikasi.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600"></i>
                Setujui Laporan
            </h3>
            <form action="{{ route('admin.laporan.approve', $laporan->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="approve_catatan" class="block text-gray-700 font-medium mb-2 text-sm">Catatan (Opsional)</label>
                    <textarea name="catatan_admin" id="approve_catatan" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                              placeholder="Tambahkan catatan untuk mahasiswa..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 font-semibold">
                        <i class="fas fa-check mr-1"></i>
                        Setujui
                    </button>
                    <button type="button" onclick="document.getElementById('approveModal').classList.add('hidden')"
                            class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-times-circle text-red-600"></i>
                Tolak Laporan
            </h3>
            <form action="{{ route('admin.laporan.reject', $laporan->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reject_catatan" class="block text-gray-700 font-medium mb-2 text-sm">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="catatan_admin" id="reject_catatan" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                              placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 font-semibold">
                        <i class="fas fa-times mr-1"></i>
                        Tolak
                    </button>
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                            class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold">
                        Batal
                    </button>
                </div>
            </form>
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
