<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Antrian Verifikasi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.antrian-verifikasi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-plus-circle mr-2"></i>
                Tambah Antrian Verifikasi
            </h2>
            <p class="text-purple-100 text-sm">Buat antrian verifikasi kegiatan baru</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.antrian-verifikasi.store') }}" method="POST">
                @csrf

                <!-- Nama -->
                <div class="mb-6">
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Antrian Verifikasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nama') border-red-500 @enderror"
                           placeholder="Contoh: Verifikasi Kegiatan Semester Genap 2025/2026"
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
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                              placeholder="Deskripsi antrian verifikasi (opsional)">{{ old('deskripsi') }}</textarea>
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
                               value="{{ old('tanggal_mulai_pendaftaran') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_mulai_pendaftaran') border-red-500 @enderror"
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
                               value="{{ old('tanggal_selesai_pendaftaran') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_selesai_pendaftaran') border-red-500 @enderror"
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
                               value="{{ old('tanggal_mulai_verifikasi') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_mulai_verifikasi') border-red-500 @enderror"
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
                               value="{{ old('tanggal_selesai_verifikasi') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_selesai_verifikasi') border-red-500 @enderror"
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
                           value="{{ old('kuota_per_hari', 5) }}"
                           min="1"
                           class="w-full md:w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('kuota_per_hari') border-red-500 @enderror"
                           required>
                    <p class="text-gray-500 text-xs mt-1">Contoh: 5 (berarti setiap hari maksimal 5 mahasiswa)</p>
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
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500">
                        <span class="text-sm font-semibold text-gray-700">Aktif</span>
                    </label>
                    <p class="text-gray-500 text-xs mt-1">Jika tidak dicentang, antrian verifikasi tidak akan ditampilkan</p>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-purple-600 hover:to-indigo-700 transition duration-200 shadow-md flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan
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
</body>
</html>
