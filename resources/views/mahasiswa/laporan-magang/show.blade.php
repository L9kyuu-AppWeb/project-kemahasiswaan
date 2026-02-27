<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Magang - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-orange-50 to-amber-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-orange-600 to-amber-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('mahasiswa.laporan-magang.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="font-semibold">Kembali</span>
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

    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">
                        <i class="fas fa-briefcase mr-2"></i>
                        Detail Laporan Magang
                    </h2>
                    <p class="text-orange-100 text-sm">{{ $laporan->judul_laporan }}</p>
                </div>
                @if($laporan->status === 'draft')
                    <span class="bg-white/20 text-white px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-file mr-1"></i> Draft
                    </span>
                @elseif($laporan->status === 'submitted')
                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-lg font-semibold">
                        <i class="fas fa-clock mr-1"></i> Submitted
                    </span>
                @elseif($laporan->status === 'approved')
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

        <!-- Info Laporan -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-file-alt text-orange-600"></i>
                Informasi Laporan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Judul Laporan</p>
                    <p class="font-medium text-gray-800">{{ $laporan->judul_laporan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tahun Ajar</p>
                    <p class="font-medium text-gray-800">{{ $laporan->tahunAjar->nama }} ({{ ucfirst($laporan->tahunAjar->semester) }})</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Kegiatan</p>
                    <p class="font-medium text-gray-800">{{ $laporan->tanggal_kegiatan->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Lokasi</p>
                    <p class="font-medium text-gray-800">{{ $laporan->lokasi_kegiatan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Waktu</p>
                    <p class="font-medium text-gray-800">{{ $laporan->waktu_mulai }} - {{ $laporan->waktu_selesai }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Deskripsi</p>
                    <p class="font-medium text-gray-800">{{ $laporan->deskripsi }}</p>
                </div>
            </div>
        </div>

        <!-- Log Kegiatan -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-list-check text-orange-600"></i>
                Log Kegiatan Harian
            </h3>
            
            @forelse($laporan->logKegiatans as $index => $log)
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

        <!-- Catatan Admin -->
        @if($laporan->catatan_admin)
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                <h3 class="text-lg font-bold text-blue-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-comment-dots"></i>
                    Catatan Admin
                </h3>
                <p class="text-blue-700">{{ $laporan->catatan_admin }}</p>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex gap-4">
            @if($laporan->status === 'draft')
                <a href="{{ route('mahasiswa.laporan-magang.edit', $laporan->id) }}"
                   class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg">
                    <i class="fas fa-edit"></i>
                    Edit Laporan
                </a>
                <form action="{{ route('mahasiswa.laporan-magang.submit', $laporan->id) }}" method="POST" class="flex-1"
                      onsubmit="return confirm('Yakin ingin mengirim laporan untuk direview?');">
                    @csrf
                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Laporan
                    </button>
                </form>
                <form action="{{ route('mahasiswa.laporan-magang.destroy', $laporan->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                </form>
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
