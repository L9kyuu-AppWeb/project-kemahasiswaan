@extends('mahasiswa.layouts.app')

@section('title', 'Detail Magang')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6 pb-4 border-b">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-briefcase text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $magang->nama_perusahaan }}</h2>
                    <p class="text-gray-500 text-sm">{{ $magang->lokasi_perusahaan }}</p>
                </div>
            </div>
            <div>
                @if($magang->status === 'aktif')
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-check-circle mr-1"></i>Aktif
                </span>
                @elseif($magang->status === 'selesai')
                <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-flag-checkered mr-1"></i>Selesai
                </span>
                @else
                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-times-circle mr-1"></i>Tidak Aktif
                </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Informasi Magang -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle text-emerald-600"></i>Informasi Magang
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Semester</span>
                        <span class="font-medium text-gray-800">{{ $magang->semester }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal Mulai</span>
                        <span class="font-medium text-gray-800">{{ $magang->tanggal_mulai->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal Selesai</span>
                        <span class="font-medium text-gray-800">{{ $magang->tanggal_selesai->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Durasi</span>
                        <span class="font-medium text-gray-800">{{ $magang->tanggal_mulai->diffInDays($magang->tanggal_selesai) }} hari</span>
                    </div>
                </div>
            </div>

            <!-- Tahun Ajar -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-graduation-cap text-emerald-600"></i>Tahun Ajar
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tahun</span>
                        <span class="font-medium text-gray-800">{{ $magang->tahunAjar->tahun_mulai ?? '-' }}/{{ $magang->tahunAjar->tahun_selesai ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Semester</span>
                        <span class="font-medium text-gray-800">{{ ucfirst($magang->tahunAjar->semester ?? '-') }}</span>
                    </div>
                </div>
            </div>

            <!-- Pembimbing Lapangan -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-user-tie text-emerald-600"></i>Pembimbing Lapangan
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nama</span>
                        <span class="font-medium text-gray-800">{{ $magang->pembimbing_lapangan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">No. Telp</span>
                        <span class="font-medium text-gray-800">{{ $magang->no_telp_pembimbing ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Dosen Pembimbing -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-chalkboard-teacher text-emerald-600"></i>Dosen Pembimbing
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nama</span>
                        <span class="font-medium text-gray-800">{{ $magang->dosen_pembimbing_nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">NIK</span>
                        <span class="font-medium text-gray-800">{{ $magang->dosen_pembimbing_nik ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Status & Progress -->
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-chart-line text-emerald-600"></i>Status & Progress
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status</span>
                        @if($magang->status === 'aktif')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                        @elseif($magang->status === 'selesai')
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-flag-checkered mr-1"></i>Selesai
                        </span>
                        @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-times-circle mr-1"></i>Tidak Aktif
                        </span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total Laporan</span>
                        <span class="font-medium text-gray-800">{{ $magang->laporanMagangs->count() }} Laporan</span>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if($magang->catatan)
            <div class="bg-gray-50 rounded-xl p-4 lg:col-span-3">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-comment-alt text-emerald-600"></i>Catatan
                </h3>
                <p class="text-gray-700 text-sm">{{ $magang->catatan }}</p>
            </div>
            @endif
        </div>

        <div class="flex gap-3 pt-4 border-t">
            <a href="{{ route('mahasiswa.laporan-magang.index', ['magang_id' => $magang->id]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-lg transition font-semibold">
                <i class="fas fa-file-contract mr-2"></i>Laporan Magang
            </a>
            <a href="{{ route('mahasiswa.magang.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition font-semibold">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
</div>
@endsection
