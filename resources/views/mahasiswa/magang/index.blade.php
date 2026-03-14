@extends('mahasiswa.layouts.app')

@section('title', 'Data Magang Saya')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold"><i class="fas fa-briefcase mr-2"></i>Data Magang Saya</h2>
                <p class="text-emerald-100 text-sm">Kelola kegiatan magang Anda</p>
            </div>
            <a href="{{ route('mahasiswa.magang.create') }}" class="bg-white text-emerald-600 hover:bg-emerald-50 px-6 py-3 rounded-lg transition font-semibold flex items-center gap-2">
                <i class="fas fa-plus-circle"></i>Tambah Magang
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
        <i class="fas fa-check-circle"></i>{{ session('success') }}
    </div>
    @endif

    @if($magangs && count($magangs) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($magangs as $m)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-4 text-white">
                <h3 class="font-bold text-lg">{{ $m->nama_perusahaan }}</h3>
                <p class="text-sm text-emerald-100"><i class="fas fa-map-marker-alt mr-1"></i>{{ $m->lokasi_perusahaan }}</p>
            </div>
            <div class="p-4">
                <div class="space-y-2 text-sm mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Periode</span>
                        <span class="font-medium text-gray-800">{{ $m->tanggal_mulai->format('d M Y') }} - {{ $m->tanggal_selesai->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Semester</span>
                        <span class="font-medium text-gray-800">{{ $m->semester }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Pembimbing</span>
                        <span class="font-medium text-gray-800">{{ $m->pembimbing_lapangan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Status</span>
                        @if($m->status === 'aktif')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Aktif
                        </span>
                        @elseif($m->status === 'selesai')
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-flag-checkered mr-1"></i>Selesai
                        </span>
                        @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-times-circle mr-1"></i>Tidak Aktif
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="flex gap-2 pt-3 border-t">
                    <a href="{{ route('mahasiswa.magang.show', $m->id) }}" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg transition text-sm font-semibold text-center">
                        <i class="fas fa-eye mr-1"></i>Detail
                    </a>
                    <a href="{{ route('mahasiswa.laporan-magang.index', ['magang_id' => $m->id]) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition text-sm font-semibold text-center">
                        <i class="fas fa-file-contract mr-1"></i>Laporan
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl shadow-lg p-6 text-center">
        <i class="fas fa-briefcase text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Magang</h3>
        <p class="text-gray-500 mb-6">Anda belum menambahkan data magang. Silakan tambahkan data magang Anda.</p>
        <a href="{{ route('mahasiswa.magang.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-lg transition font-semibold inline-flex items-center gap-2">
            <i class="fas fa-plus-circle"></i>Tambah Magang
        </a>
    </div>
    @endif
</div>
@endsection
