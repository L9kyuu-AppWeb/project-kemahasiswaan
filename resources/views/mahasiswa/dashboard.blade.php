@extends('mahasiswa.layouts.app')

@section('title', 'Mahasiswa Dashboard')

@section('content')
        <!-- Profile Card -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-lg p-8 mb-8 text-white">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-user-circle text-5xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-3xl font-bold mb-2">{{ $mahasiswa->name }}</h2>
                    <div class="flex flex-wrap gap-4 text-green-100">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-id-card"></i>
                            {{ $mahasiswa->nim }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-envelope"></i>
                            {{ $mahasiswa->email }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            Angkatan {{ $mahasiswa->tahun_masuk }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('mahasiswa.profile') }}" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-lg transition duration-200 flex items-center gap-2 backdrop-blur-sm">
                    <i class="fas fa-edit"></i>
                    <span class="hidden md:inline">Edit Profil</span>
                </a>
            </div>
        </div>

        <!-- Status Beasiswa Card -->
        @if($beasiswaAktif)
            <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl shadow-lg p-6 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-1">Status Beasiswa Aktif</h3>
                            <p class="text-blue-100 text-lg">{{ $beasiswaAktif->beasiswaTipe->nama }}</p>
                            <p class="text-blue-200 text-sm mt-1">
                                <i class="fas fa-file-alt mr-1"></i> SK: {{ $beasiswaAktif->nomor_sk }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="bg-white/20 px-4 py-2 rounded-full text-sm font-semibold">
                            <i class="fas fa-check-circle mr-1"></i> Aktif
                        </span>
                        <p class="text-blue-200 text-xs mt-2">
                            <i class="fas fa-calendar mr-1"></i> Mulai: {{ $beasiswaAktif->tanggal_mulai->format('d M Y') }}
                        </p>
                        @if($beasiswaAktif->tanggal_berakhir)
                            <p class="text-blue-200 text-xs">
                                <i class="fas fa-calendar-check mr-1"></i> Berakhir: {{ $beasiswaAktif->tanggal_berakhir->format('d M Y') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-md p-6 mb-8 border-l-4 border-gray-300">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-3xl text-gray-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Tidak Ada Beasiswa Aktif</h3>
                        <p class="text-gray-500">Anda saat ini tidak terdaftar dalam program beasiswa.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Status</p>
                        <h3 class="text-xl font-bold text-gray-800">Aktif</h3>
                    </div>
                </div>
            </div>

            <!-- Kegiatan Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Kegiatan</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $totalKegiatan }}</h3>
                    </div>
                </div>
            </div>
        </div>
@endsection
