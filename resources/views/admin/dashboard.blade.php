@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg p-8 mb-8 text-white">
            <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->guard('admin')->user()->name }}! 👋</h2>
            <p class="text-blue-100">Kelola data kemahasiswaan dengan mudah dan efisien.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Mahasiswa -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Mahasiswa</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ number_format($totalMahasiswa) }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Program Studi -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Program Studi</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ number_format($totalProgramStudi) }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Mahasiswa per Tahun -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Tahun Aktif</p>
                        <h3 class="text-4xl font-bold text-gray-800">{{ $mahasiswaPerTahun->count() }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Menu Cepat</p>
                        <h3 class="text-lg font-bold text-gray-800">Aksi</h3>
                    </div>
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-orange-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Detail Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Mahasiswa per Program Studi -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-pie text-blue-600"></i>
                    Mahasiswa per Program Studi
                </h3>
                <div class="space-y-3">
                    @forelse($mahasiswaPerProdi as $data)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">{{ substr($data->programStudi->nama ?? 'N/A', 0, 2) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $data->programStudi->nama ?? 'Tidak Ada Prodi' }}</p>
                                    <p class="text-xs text-gray-500">{{ $data->programStudi->singkatan ?? '-' }}</p>
                                </div>
                            </div>
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $data->total }} Mhs
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada data mahasiswa.</p>
                    @endforelse
                </div>
            </div>

            <!-- Mahasiswa per Tahun Masuk -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-green-600"></i>
                    Mahasiswa per Tahun Masuk
                </h3>
                <div class="space-y-3">
                    @forelse($mahasiswaPerTahun as $data)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Angkatan {{ $data->tahun_masuk }}</p>
                                    <p class="text-xs text-gray-500">Tahun Akademik</p>
                                </div>
                            </div>
                            <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $data->total }} Mhs
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada data mahasiswa.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Menu Cards -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-database text-blue-600"></i>
                Data Master
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('admin.profile') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-user-circle text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-blue-600 transition">Profil Saya</h3>
                            <p class="text-sm text-gray-500">Kelola akun Anda</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.program-studi.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-graduation-cap text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-purple-600 transition">Program Studi</h3>
                            <p class="text-sm text-gray-500">Kelola prodi</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.mahasiswa.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-green-600 transition">Mahasiswa</h3>
                            <p class="text-sm text-gray-500">Kelola data mhs</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.tahun-ajar.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-calendar-alt text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-amber-600 transition">Tahun Ajar</h3>
                            <p class="text-sm text-gray-500">Kelola tahun ajar</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Transaksi & Laporan -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-exchange-alt text-orange-600"></i>
                Transaksi & Laporan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('admin.beasiswa.data.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-graduation-cap text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-teal-600 transition">Beasiswa</h3>
                            <p class="text-sm text-gray-500">Kelola beasiswa</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.magang.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-briefcase text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-emerald-600 transition">Mahasiswa Magang</h3>
                            <p class="text-sm text-gray-500">Kelola mhs magang</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.laporan.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-file-alt text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-indigo-600 transition">Laporan Beasiswa</h3>
                            <p class="text-sm text-gray-500">Verifikasi laporan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.laporan-magang.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-file-contract text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-orange-600 transition">Laporan Magang</h3>
                            <p class="text-sm text-gray-500">Verifikasi laporan</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Informasi & Pengumuman -->
        <div>
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-bullhorn text-red-600"></i>
                Informasi & Pengumuman
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('admin.pengumuman.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-bullhorn text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-orange-600 transition">Pengumuman</h3>
                            <p class="text-sm text-gray-500">Kelola pengumuman</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.antrian-verifikasi.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-list-ol text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-indigo-600 transition">Antrian Verifikasi</h3>
                            <p class="text-sm text-gray-500">Kelola antrian</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.lomba-kategori.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-trophy text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-pink-600 transition">Kategori Lomba</h3>
                            <p class="text-sm text-gray-500">Kelola kategori lomba</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.jenis-rekognisi.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-certificate text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-cyan-600 transition">Jenis Rekognisi</h3>
                            <p class="text-sm text-gray-500">Kelola jenis rekognisi</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.kompetisi.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-medal text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-emerald-600 transition">Kompetisi Mahasiswa</h3>
                            <p class="text-sm text-gray-500">Verifikasi prestasi</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.rekognisi.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-award text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-indigo-600 transition">Rekognisi</h3>
                            <p class="text-sm text-gray-500">Verifikasi rekognisi</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.sertifikasi.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-certificate text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-violet-600 transition">Sertifikasi</h3>
                            <p class="text-sm text-gray-500">Verifikasi sertifikasi</p>
                        </div>
                    </div>
                </a>

                <div class="col-span-full">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-database text-indigo-600"></i>
                        Master Data Kegiatan
                    </h3>
                </div>

                <a href="{{ route('admin.master-kegiatan.jenis.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-list text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-indigo-600 transition">Jenis Kegiatan</h3>
                            <p class="text-sm text-gray-500">Kelola jenis kegiatan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.master-kegiatan.ruang-lingkup.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-globe text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-cyan-600 transition">Ruang Lingkup</h3>
                            <p class="text-sm text-gray-500">Kelola ruang lingkup</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.master-kegiatan.detail.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-tasks text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-teal-600 transition">Detail Kegiatan</h3>
                            <p class="text-sm text-gray-500">Kelola detail kegiatan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.master-kegiatan.nilai.index') }}" class="group bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition duration-200 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition duration-200">
                            <i class="fas fa-star text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 group-hover:text-orange-600 transition">Nilai Kegiatan</h3>
                            <p class="text-sm text-gray-500">Kelola nilai/point</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
@endsection
