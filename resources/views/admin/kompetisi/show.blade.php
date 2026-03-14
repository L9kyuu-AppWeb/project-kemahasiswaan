<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kompetisi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.kompetisi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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

    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-trophy text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $kompetisi->nama_kompetisi }}</h2>
                        <p class="text-gray-500 text-sm">{{ $kompetisi->kategori }}</p>
                    </div>
                </div>
                <div>
                    @if($kompetisi->status === 'pending')
                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold">
                        <i class="fas fa-clock mr-1"></i>Pending
                    </span>
                    @elseif($kompetisi->status === 'approved')
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                        <i class="fas fa-check-circle mr-1"></i>Disetujui
                    </span>
                    @else
                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">
                        <i class="fas fa-times-circle mr-1"></i>Ditolak
                    </span>
                    @endif
                </div>
            </div>

            <!-- Detail Sections -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Informasi Kompetisi -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-emerald-600"></i>
                        Informasi Kompetisi
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Kategori</span>
                            <span class="font-medium text-gray-800">{{ $kompetisi->kategori }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama Cabang</span>
                            <span class="font-medium text-gray-800">{{ $kompetisi->nama_cabang ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Peringkat</span>
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium">{{ $kompetisi->peringkat }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Penyelenggara</span>
                            <span class="font-medium text-gray-800">{{ $kompetisi->penyelenggara }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jumlah PT/Negara</span>
                            <span class="font-medium text-gray-800">{{ $kompetisi->jumlah_pt_negara_peserta ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Kepesertaan</span>
                            <span class="font-medium text-gray-800">{{ $kompetisi->kepesertaan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Bentuk</span>
                            <span class="font-medium text-gray-800">{{ $kompetisi->bentuk }}</span>
                        </div>
                    </div>
                </div>

                <!-- Data Peserta -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-users text-emerald-600"></i>
                        Data Peserta
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">NIM</span>
                            <span class="font-medium text-gray-800">{{ $kompetisi->nim }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Nama Mahasiswa</span>
                            <span class="font-medium text-gray-800">{{ $kompetisi->nama_mahasiswa }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Dosen Pembimbing</span>
                            <span class="font-medium text-gray-800">{{ $kompetisi->dosen->nama ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tautan & Dokumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Tautan -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-link text-emerald-600"></i>
                        Tautan
                    </h3>
                    <div class="space-y-2 text-sm">
                        @if($kompetisi->url_kompetisi)
                        <a href="{{ $kompetisi->url_kompetisi }}" target="_blank"
                           class="flex items-center gap-2 text-emerald-600 hover:text-emerald-700">
                            <i class="fas fa-globe"></i>
                            <span>URL Kompetisi</span>
                        </a>
                        @endif
                        @if($kompetisi->url_surat_tugas)
                        <a href="{{ Storage::url($kompetisi->url_surat_tugas) }}" target="_blank"
                           class="flex items-center gap-2 text-emerald-600 hover:text-emerald-700">
                            <i class="fas fa-file-pdf"></i>
                            <span>Surat Tugas</span>
                        </a>
                        @endif
                        @if(!$kompetisi->url_kompetisi && !$kompetisi->url_surat_tugas)
                        <p class="text-gray-400">Tidak ada tautan</p>
                        @endif
                    </div>
                </div>

                <!-- Dokumen -->
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-file text-emerald-600"></i>
                        Dokumen
                    </h3>
                    <div class="space-y-2 text-sm">
                        @if($kompetisi->dokumen_sertifikat)
                        <a href="{{ Storage::url($kompetisi->dokumen_sertifikat) }}" target="_blank"
                           class="flex items-center gap-2 text-emerald-600 hover:text-emerald-700">
                            <i class="fas fa-file-pdf"></i>
                            <span>Sertifikat</span>
                        </a>
                        @endif
                        @if($kompetisi->foto_upp)
                        <a href="{{ Storage::url($kompetisi->foto_upp) }}" target="_blank"
                           class="flex items-center gap-2 text-emerald-600 hover:text-emerald-700">
                            <i class="fas fa-image"></i>
                            <span>Foto UPP</span>
                        </a>
                        @endif
                        @if($kompetisi->dokumen_undangan)
                        <a href="{{ Storage::url($kompetisi->dokumen_undangan) }}" target="_blank"
                           class="flex items-center gap-2 text-emerald-600 hover:text-emerald-700">
                            <i class="fas fa-file"></i>
                            <span>Undangan</span>
                        </a>
                        @endif
                        @if(!$kompetisi->dokumen_sertifikat && !$kompetisi->foto_upp && !$kompetisi->dokumen_undangan)
                        <p class="text-gray-400">Tidak ada dokumen</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Keterangan Verifikasi -->
            @if($kompetisi->keterangan_verifikasi)
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
                <h3 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-comment-alt text-yellow-600"></i>
                    Keterangan Verifikasi
                </h3>
                <p class="text-gray-700">{{ $kompetisi->keterangan_verifikasi }}</p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4 border-t">
                @if($kompetisi->status === 'pending')
                <form action="{{ route('admin.kompetisi.approve', $kompetisi->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="status" value="approved">
                    <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition font-semibold">
                        <i class="fas fa-check mr-2"></i>Setujui
                    </button>
                </form>
                <button onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition font-semibold">
                    <i class="fas fa-times mr-2"></i>Tolak
                </button>
                @endif
                <a href="{{ route('admin.kompetisi.edit', $kompetisi->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition font-semibold">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.kompetisi.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-times-circle text-red-600 mr-2"></i>Tolak Kompetisi
            </h3>
            <form action="{{ route('admin.kompetisi.approve', $kompetisi->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="rejected">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Alasan Penolakan</label>
                    <textarea name="keterangan_verifikasi" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                              required></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                        Tolak
                    </button>
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                            class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition font-semibold">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
