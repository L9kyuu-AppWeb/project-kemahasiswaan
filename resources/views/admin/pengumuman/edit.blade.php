<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengumuman - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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

    <div class="max-w-3xl mx-auto px-4 py-8">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Edit Pengumuman</h2>
                    <p class="text-gray-500 text-sm">Perbarui informasi pengumuman</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                        <div>
                            <h4 class="font-semibold text-red-800 mb-2">Terdapat {{ count($errors) }} kesalahan:</h4>
                            <ul class="list-disc list-inside space-y-1 text-red-700 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="judul" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-heading mr-2 text-orange-600"></i>
                        Judul Pengumuman
                    </label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $pengumuman->judul) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('judul') border-red-500 @enderror"
                           required>
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="kategori" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-tags mr-2 text-orange-600"></i>
                            Kategori
                        </label>
                        <select name="kategori" id="kategori"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('kategori') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="umum" {{ old('kategori', $pengumuman->kategori) === 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="akademik" {{ old('kategori', $pengumuman->kategori) === 'akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="kemahasiswaan" {{ old('kategori', $pengumuman->kategori) === 'kemahasiswaan' ? 'selected' : '' }}>Kemahasiswaan</option>
                            <option value="beasiswa" {{ old('kategori', $pengumuman->kategori) === 'beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                        </select>
                        @error('kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prioritas" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-exclamation-triangle mr-2 text-orange-600"></i>
                            Prioritas
                        </label>
                        <select name="prioritas" id="prioritas"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('prioritas') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="rendah" {{ old('prioritas', $pengumuman->prioritas) === 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ old('prioritas', $pengumuman->prioritas) === 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ old('prioritas', $pengumuman->prioritas) === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                        @error('prioritas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="konten" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-align-left mr-2 text-orange-600"></i>
                        Konten Pengumuman
                    </label>
                    <textarea name="konten" id="konten" rows="6"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('konten') border-red-500 @enderror"
                              required>{{ old('konten', $pengumuman->konten) }}</textarea>
                    @error('konten')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="tanggal_publish" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar-alt mr-2 text-orange-600"></i>
                            Tanggal Publish
                        </label>
                        <input type="date" name="tanggal_publish" id="tanggal_publish" value="{{ old('tanggal_publish', $pengumuman->tanggal_publish?->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('tanggal_publish') border-red-500 @enderror">
                        @error('tanggal_publish')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_expire" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar-times mr-2 text-orange-600"></i>
                            Tanggal Expire <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="date" name="tanggal_expire" id="tanggal_expire" value="{{ old('tanggal_expire', $pengumuman->tanggal_expire?->format('Y-m-d')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('tanggal_expire') border-red-500 @enderror">
                        @error('tanggal_expire')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $pengumuman->is_published) ? 'checked' : '' }}
                               class="w-5 h-5 text-orange-600 rounded focus:ring-orange-500">
                        <span class="text-gray-700 font-semibold">
                            <i class="fas fa-eye mr-2 text-orange-600"></i>
                            Publish
                        </span>
                    </label>
                    <p class="text-gray-500 text-xs mt-1 ml-7">Centang untuk mempublikasikan pengumuman</p>
                </div>

                <div class="flex gap-3 pt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-6 py-3 rounded-lg hover:from-yellow-600 hover:to-orange-700 transition duration-200 font-semibold shadow-md">
                        <i class="fas fa-save mr-2"></i>
                        Update Pengumuman
                    </button>
                    <a href="{{ route('admin.pengumuman.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
