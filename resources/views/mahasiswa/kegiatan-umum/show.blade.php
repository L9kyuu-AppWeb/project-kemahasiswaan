@extends('mahasiswa.layouts.app')

@section('title', 'Detail Kegiatan Umum')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 pb-4 border-b">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-folder-open text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $kegiatanUmum->nama_kompetisi }}</h2>
                    <p class="text-gray-500 text-sm">{{ $kegiatanUmum->penyelenggara }}</p>
                </div>
            </div>
            <div>
                @if($kegiatanUmum->status === 'pending')
                <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-clock mr-1"></i>Pending
                </span>
                @elseif($kegiatanUmum->status === 'approved')
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
            <!-- Informasi Kegiatan -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle text-purple-600"></i>Informasi Kegiatan
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Kategori</span>
                        <span class="font-medium text-gray-800">{{ $kegiatanUmum->kategori }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Jenis Kegiatan</span>
                        <span class="font-medium text-gray-800">{{ $kegiatanUmum->jenisKegiatan->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Detail Kegiatan</span>
                        <span class="font-medium text-gray-800">{{ $kegiatanUmum->detailKegiatan->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Ruang Lingkup</span>
                        <span class="font-medium text-gray-800">{{ $kegiatanUmum->ruangLingkup->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nilai</span>
                        <span class="font-medium text-purple-600 font-bold">{{ $kegiatanUmum->nilai }}</span>
                    </div>
                </div>
            </div>

            <!-- Dosen Pembimbing -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-chalkboard-teacher text-purple-600"></i>Dosen Pembimbing
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nama</span>
                        <span class="font-medium text-gray-800">{{ $kegiatanUmum->dosen->nama ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen & Tautan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-link text-purple-600"></i>Tautan
                </h3>
                <div class="space-y-2 text-sm">
                    @if($kegiatanUmum->url_kegiatan)
                    <a href="{{ $kegiatanUmum->url_kegiatan }}" target="_blank" class="flex items-center gap-2 text-purple-600 hover:text-purple-700">
                        <i class="fas fa-globe"></i><span>URL Kegiatan</span>
                    </a>
                    @endif
                    @if($kegiatanUmum->url_surat_tugas)
                    <a href="{{ Storage::url($kegiatanUmum->url_surat_tugas) }}" target="_blank" class="flex items-center gap-2 text-purple-600 hover:text-purple-700">
                        <i class="fas fa-file-alt"></i><span>Surat Tugas</span>
                    </a>
                    @endif
                    @if(!$kegiatanUmum->url_kegiatan && !$kegiatanUmum->url_surat_tugas)
                    <p class="text-gray-400">Tidak ada tautan</p>
                    @endif
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-file text-purple-600"></i>Dokumen
                </h3>
                <div class="space-y-2 text-sm">
                    @if($kegiatanUmum->dokumen_sertifikat)
                    <a href="{{ Storage::url($kegiatanUmum->dokumen_sertifikat) }}" target="_blank" class="flex items-center gap-2 text-purple-600 hover:text-purple-700">
                        <i class="fas fa-file-pdf"></i><span>Sertifikat</span>
                    </a>
                    @endif
                    @if(!$kegiatanUmum->dokumen_sertifikat)
                    <p class="text-gray-400">Tidak ada dokumen</p>
                    @endif
                </div>
            </div>
        </div>

        @if($kegiatanUmum->keterangan_verifikasi)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
            <h3 class="font-bold text-gray-800 mb-2"><i class="fas fa-comment-alt text-yellow-600"></i>Keterangan Verifikasi</h3>
            <p class="text-gray-700">{{ $kegiatanUmum->keterangan_verifikasi }}</p>
        </div>
        @endif

        <!-- Actions -->
        <div class="flex gap-3 pt-4 border-t">
            @if($kegiatanUmum->status === 'pending')
            <a href="{{ route('mahasiswa.kegiatan-umum.edit', $kegiatanUmum->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition font-semibold">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('mahasiswa.kegiatan-umum.destroy', $kegiatanUmum->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition font-semibold">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </form>
            @endif
            <a href="{{ route('mahasiswa.kegiatan-umum.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection
