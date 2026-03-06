<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sertifikasi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4"><div class="flex justify-between items-center">
            <a href="{{ route('mahasiswa.sertifikasi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition"><i class="fas fa-arrow-left"></i><span class="font-semibold">Kembali</span></a>
            <div class="flex items-center space-x-4"><div class="text-right hidden md:block"><p class="font-medium">{{ auth()->guard('mahasiswa')->user()->name }}</p><p class="text-xs text-blue-200">{{ auth()->guard('mahasiswa')->user()->nim }}</p></div>
            <form action="{{ route('mahasiswa.logout') }}" method="POST" class="inline">@csrf<button type="submit" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition"><i class="fas fa-sign-out-alt"></i></button></form></div>
        </div></div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6 pb-4 border-b">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center"><i class="fas fa-certificate text-white text-2xl"></i></div>
                    <div><h2 class="text-2xl font-bold text-gray-800">{{ $sertifikasi->nama_sertifikasi }}</h2><p class="text-gray-500 text-sm">{{ $sertifikasi->nama_penyelenggara }}</p></div>
                </div>
                <div>
                    @if($sertifikasi->status === 'pending')<span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold"><i class="fas fa-clock mr-1"></i>Pending</span>
                    @elseif($sertifikasi->status === 'approved')<span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold"><i class="fas fa-check-circle mr-1"></i>Disetujui</span>
                    @else<span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold"><i class="fas fa-times-circle mr-1"></i>Ditolak</span>@endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-info-circle text-indigo-600"></i>Informasi Sertifikasi</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Level</span><span class="font-medium">{{ $sertifikasi->level }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Penyelenggara</span><span class="font-medium">{{ $sertifikasi->nama_penyelenggara }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Tanggal Sertifikat</span><span class="font-medium">{{ $sertifikasi->tanggal_sertifikat?->format('d M Y') ?? '-' }}</span></div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-users text-indigo-600"></i>Data Peserta</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">NIM</span><span class="font-medium">{{ $sertifikasi->nim }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Nama Mahasiswa</span><span class="font-medium">{{ $sertifikasi->nama_mahasiswa }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">NIDN/NUPTK</span><span class="font-medium">{{ $sertifikasi->nidn_nuptk ?? '-' }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Nama Dosen</span><span class="font-medium">{{ $sertifikasi->nama_dosen ?? '-' }}</span></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-link text-indigo-600"></i>Tautan</h3>
                    <div class="space-y-2 text-sm">
                        @if($sertifikasi->url_sertifikasi)<a href="{{ $sertifikasi->url_sertifikasi }}" target="_blank" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700"><i class="fas fa-globe"></i><span>URL Sertifikasi</span></a>@endif
                        @if($sertifikasi->url_surat_tugas)<a href="{{ $sertifikasi->url_surat_tugas }}" target="_blank" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700"><i class="fas fa-file-alt"></i><span>Surat Tugas</span></a>@endif
                        @if(!$sertifikasi->url_sertifikasi && !$sertifikasi->url_surat_tugas)<p class="text-gray-400">Tidak ada tautan</p>@endif
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2"><i class="fas fa-file text-indigo-600"></i>Dokumen</h3>
                    <div class="space-y-2 text-sm">
                        @if($sertifikasi->dokumen_sertifikat)<a href="{{ Storage::url($sertifikasi->dokumen_sertifikat) }}" target="_blank" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700"><i class="fas fa-file-pdf"></i><span>Sertifikat</span></a>@endif
                        @if($sertifikasi->foto_kegiatan)<a href="{{ Storage::url($sertifikasi->foto_kegiatan) }}" target="_blank" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700"><i class="fas fa-image"></i><span>Foto Kegiatan</span></a>@endif
                        @if($sertifikasi->dokumen_bukti)<a href="{{ Storage::url($sertifikasi->dokumen_bukti) }}" target="_blank" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700"><i class="fas fa-file"></i><span>Dokumen Bukti</span></a>@endif
                    </div>
                </div>
            </div>

            @if($sertifikasi->keterangan_verifikasi)<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6"><h3 class="font-bold text-gray-800 mb-2"><i class="fas fa-comment-alt text-yellow-600"></i>Keterangan Verifikasi</h3><p class="text-gray-700">{{ $sertifikasi->keterangan_verifikasi }}</p></div>@endif

            <div class="flex gap-3 pt-4 border-t">
                @if($sertifikasi->status === 'pending')
                <a href="{{ route('mahasiswa.sertifikasi.edit', $sertifikasi->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold"><i class="fas fa-edit mr-2"></i>Edit</a>
                <form action="{{ route('mahasiswa.sertifikasi.destroy', $sertifikasi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">@csrf @method('DELETE')<button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold"><i class="fas fa-trash mr-2"></i>Hapus</button></form>
                @endif
                <a href="{{ route('mahasiswa.sertifikasi.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
