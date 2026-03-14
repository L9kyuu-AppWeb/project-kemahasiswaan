@extends('layouts.app')

@section('title', 'Edit Antrian Verifikasi')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-yellow-500 to-orange-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-edit mr-2"></i>
                Edit Antrian Verifikasi
            </h2>
            <p class="text-yellow-100 text-sm">{{ $antrianVerifikasi->nama }}</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.antrian-verifikasi.update', $antrianVerifikasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-6">
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Antrian Verifikasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama', $antrianVerifikasi->nama) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('nama') border-red-500 @enderror"
                           required>
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" 
                              id="deskripsi" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $antrianVerifikasi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Periode Pendaftaran -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="tanggal_mulai_pendaftaran" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Mulai Pendaftaran <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="tanggal_mulai_pendaftaran" 
                               id="tanggal_mulai_pendaftaran" 
                               value="{{ old('tanggal_mulai_pendaftaran', $antrianVerifikasi->tanggal_mulai_pendaftaran->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tanggal_mulai_pendaftaran') border-red-500 @enderror"
                               required>
                        @error('tanggal_mulai_pendaftaran')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_selesai_pendaftaran" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Selesai Pendaftaran <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="tanggal_selesai_pendaftaran" 
                               id="tanggal_selesai_pendaftaran" 
                               value="{{ old('tanggal_selesai_pendaftaran', $antrianVerifikasi->tanggal_selesai_pendaftaran->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tanggal_selesai_pendaftaran') border-red-500 @enderror"
                               required>
                        @error('tanggal_selesai_pendaftaran')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Periode Verifikasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="tanggal_mulai_verifikasi" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Mulai Verifikasi <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="tanggal_mulai_verifikasi" 
                               id="tanggal_mulai_verifikasi" 
                               value="{{ old('tanggal_mulai_verifikasi', $antrianVerifikasi->tanggal_mulai_verifikasi->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tanggal_mulai_verifikasi') border-red-500 @enderror"
                               required>
                        @error('tanggal_mulai_verifikasi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_selesai_verifikasi" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Selesai Verifikasi <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               name="tanggal_selesai_verifikasi" 
                               id="tanggal_selesai_verifikasi" 
                               value="{{ old('tanggal_selesai_verifikasi', $antrianVerifikasi->tanggal_selesai_verifikasi->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tanggal_selesai_verifikasi') border-red-500 @enderror"
                               required>
                        @error('tanggal_selesai_verifikasi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kuota Per Hari -->
                <div class="mb-6">
                    <label for="kuota_per_hari" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kuota Mahasiswa Per Hari <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="kuota_per_hari" 
                           id="kuota_per_hari" 
                           value="{{ old('kuota_per_hari', $antrianVerifikasi->kuota_per_hari) }}"
                           min="1"
                           class="w-full md:w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('kuota_per_hari') border-red-500 @enderror"
                           required>
                    @error('kuota_per_hari')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="mb-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $antrianVerifikasi->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 text-yellow-600 rounded focus:ring-yellow-500">
                        <span class="text-sm font-semibold text-gray-700">Aktif</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-yellow-600 hover:to-orange-700 transition duration-200 shadow-md flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.antrian-verifikasi.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-8 py-3 rounded-lg font-semibold transition duration-200 flex items-center gap-2">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
