@extends('layouts.app')

@section('title', 'Tambah Tahun Ajar')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-plus-circle mr-2"></i>
                Tambah Tahun Ajar
            </h2>
            <p class="text-orange-100 text-sm">Form untuk menambahkan tahun ajaran baru</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <form action="{{ route('admin.tahun-ajar.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Nama Tahun Ajar -->
                    <div>
                        <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Tahun Ajar <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                               placeholder="Contoh: 2024/2025"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('nama') border-red-500 @enderror"
                               required>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun Mulai dan Selesai -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tahun_mulai" class="block text-gray-700 font-medium mb-2">Tahun Mulai <span class="text-red-500">*</span></label>
                            <input type="text" name="tahun_mulai" id="tahun_mulai" value="{{ old('tahun_mulai') }}"
                                   placeholder="Contoh: 2024" maxlength="4"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('tahun_mulai') border-red-500 @enderror"
                                   required>
                            @error('tahun_mulai')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tahun_selesai" class="block text-gray-700 font-medium mb-2">Tahun Selesai <span class="text-red-500">*</span></label>
                            <input type="text" name="tahun_selesai" id="tahun_selesai" value="{{ old('tahun_selesai') }}"
                                   placeholder="Contoh: 2025" maxlength="4"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('tahun_selesai') border-red-500 @enderror"
                                   required>
                            @error('tahun_selesai')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Semester -->
                    <div>
                        <label for="semester" class="block text-gray-700 font-medium mb-2">Semester <span class="text-red-500">*</span></label>
                        <select name="semester" id="semester"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('semester') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Semester</option>
                            <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Aktif -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                                   class="w-5 h-5 text-orange-600 rounded focus:ring-2 focus:ring-orange-500">
                            <span class="text-gray-700 font-medium">Set sebagai tahun ajar aktif</span>
                        </label>
                        <p class="text-gray-500 text-sm mt-1 ml-8">
                            <i class="fas fa-info-circle text-orange-500 mr-1"></i>
                            Jika dicentang, tahun ajar aktif lainnya akan menjadi tidak aktif.
                        </p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-3 pt-4 border-t">
                        <button type="submit"
                                class="flex-1 bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition duration-200 font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                        <a href="{{ route('admin.tahun-ajar.index') }}"
                           class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
