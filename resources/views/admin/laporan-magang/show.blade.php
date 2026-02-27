<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Magang - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.laporan-magang.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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

    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">
                        <i class="fas fa-briefcase mr-2"></i>
                        Detail Laporan Magang
                    </h2>
                    <p class="text-orange-100 text-sm">{{ $laporanMagang->judul_laporan }}</p>
                </div>
                @if($laporanMagang->status === 'draft')
                    <span class="bg-white/20 text-white px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-file mr-1"></i> Draft
                    </span>
                @elseif($laporanMagang->status === 'submitted')
                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-clock mr-1"></i> Submitted
                    </span>
                @elseif($laporanMagang->status === 'approved')
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-check-circle mr-1"></i> Approved
                    </span>
                @else
                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-times-circle mr-1"></i> Rejected
                    </span>
                @endif
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Laporan -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-file-alt text-orange-600"></i>
                        Informasi Laporan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Judul Laporan</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->judul_laporan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tahun Ajar</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->tahunAjar->nama }} ({{ ucfirst($laporanMagang->tahunAjar->semester) }})</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Kegiatan</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->tanggal_kegiatan->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Lokasi</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->lokasi_kegiatan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Waktu</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->waktu_mulai }} - {{ $laporanMagang->waktu_selesai }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Deskripsi</p>
                            <p class="text-gray-800">{{ $laporanMagang->deskripsi }}</p>
                        </div>
                    </div>
                </div>

                <!-- Log Kegiatan -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-list-check text-orange-600"></i>
                        Log Kegiatan Harian
                    </h3>
                    
                    @forelse($laporanMagang->logKegiatans as $index => $log)
                        <div class="border border-gray-200 rounded-xl p-6 mb-4 {{ $index % 2 == 0 ? 'bg-orange-50' : 'bg-white' }}">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="font-bold text-gray-800">
                                    <i class="fas fa-calendar-day text-orange-600 mr-2"></i>
                                    {{ $log->tanggal->format('d M Y') }}
                                </h4>
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $log->jam_mulai }} - {{ $log->jam_selesai }}
                                </span>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">Uraian Kegiatan</p>
                                    <p class="text-gray-800">{{ $log->uraian_kegiatan }}</p>
                                </div>
                                
                                @if($log->hasil_kegiatan)
                                    <div>
                                        <p class="text-sm text-gray-500">Hasil Kegiatan</p>
                                        <p class="text-gray-800">{{ $log->hasil_kegiatan }}</p>
                                    </div>
                                @endif
                                
                                @if($log->kendala)
                                    <div>
                                        <p class="text-sm text-gray-500">Kendala</p>
                                        <p class="text-gray-800">{{ $log->kendala }}</p>
                                    </div>
                                @endif
                                
                                @if($log->buktiKegiatans->count() > 0)
                                    <div class="mt-4 pt-4 border-t">
                                        <p class="text-sm text-gray-500 mb-2">
                                            <i class="fas fa-paperclip mr-1"></i>
                                            Bukti Kegiatan ({{ $log->buktiKegiatans->count() }} file)
                                        </p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($log->buktiKegiatans as $bukti)
                                                <a href="{{ Storage::url($bukti->file_bukti) }}" target="_blank"
                                                   class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-2 rounded-lg transition duration-200 text-sm font-medium flex items-center gap-2">
                                                    <i class="fas fa-file-pdf"></i>
                                                    {{ Str::limit($bukti->file_name, 25) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Belum ada log kegiatan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Mahasiswa -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-graduate text-orange-600"></i>
                        Mahasiswa
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->mahasiswa->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIM</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->mahasiswa->nim }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Program Studi</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->mahasiswa->programStudi->nama ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Info Perusahaan -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-building text-orange-600"></i>
                        Perusahaan
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama Perusahaan</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->mahasiswaMagang->nama_perusahaan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Lokasi</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->mahasiswaMagang->lokasi_perusahaan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pembimbing Lapangan</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->mahasiswaMagang->pembimbing_lapangan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Dosen Pembimbing</p>
                            <p class="font-medium text-gray-800">{{ $laporanMagang->mahasiswaMagang->dosen_pembimbing_nama ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Verifikasi Section -->
                @if($laporanMagang->status === 'submitted')
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-clipboard-check text-orange-600"></i>
                            Verifikasi
                        </h3>
                        
                        <!-- Approve Form -->
                        <form action="{{ route('admin.laporan-magang.approve', $laporanMagang->id) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="catatan_admin" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                          placeholder="Catatan untuk mahasiswa"></textarea>
                            </div>
                            <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                Setujui Laporan
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <form action="{{ route('admin.laporan-magang.reject', $laporanMagang->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menolak laporan ini?');">
                            @csrf
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                                <textarea name="catatan_admin" rows="2" required
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                          placeholder="Jelaskan alasan penolakan"></textarea>
                            </div>
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2">
                                <i class="fas fa-times-circle"></i>
                                Tolak Laporan
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Catatan Admin -->
                @if($laporanMagang->catatan_admin)
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-blue-800 mb-2 flex items-center gap-2">
                            <i class="fas fa-comment-dots"></i>
                            Catatan Admin
                        </h3>
                        <p class="text-blue-700">{{ $laporanMagang->catatan_admin }}</p>
                    </div>
                @endif

                <!-- Download PDF -->
                <a href="{{ route('admin.laporan-magang.download-pdf', $laporanMagang->id) }}"
                   class="block bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg text-center">
                    <i class="fas fa-file-pdf"></i>
                    Download PDF
                </a>
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
