<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penerima Beasiswa - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.beasiswa.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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
                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-plus text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Penerima Beasiswa</h2>
                    <p class="text-gray-500 text-sm">Tambahkan mahasiswa penerima beasiswa</p>
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

            <form action="{{ route('admin.beasiswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="mahasiswa_id" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user mr-2 text-teal-600"></i>
                            Mahasiswa
                        </label>
                        <select name="mahasiswa_id" id="mahasiswa_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('mahasiswa_id') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Mahasiswa --</option>
                            @foreach($mahasiswaList as $mhs)
                                <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                    {{ $mhs->name }} ({{ $mhs->nim }})
                                </option>
                            @endforeach
                        </select>
                        @error('mahasiswa_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="beasiswa_tipe_id" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-graduation-cap mr-2 text-teal-600"></i>
                            Jenis Beasiswa
                        </label>
                        <select name="beasiswa_tipe_id" id="beasiswa_tipe_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('beasiswa_tipe_id') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Jenis Beasiswa --</option>
                            @foreach($beasiswaTipeList as $tipe)
                                <option value="{{ $tipe->id }}" {{ old('beasiswa_tipe_id') == $tipe->id ? 'selected' : '' }}>
                                    {{ $tipe->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('beasiswa_tipe_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="nomor_sk" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-file-alt mr-2 text-teal-600"></i>
                        Nomor SK
                    </label>
                    <input type="text" name="nomor_sk" id="nomor_sk" value="{{ old('nomor_sk') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('nomor_sk') border-red-500 @enderror"
                           placeholder="Contoh: SK/123/2024" required>
                    @error('nomor_sk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="tanggal_mulai" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar-alt mr-2 text-teal-600"></i>
                            Tanggal Mulai
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('tanggal_mulai') border-red-500 @enderror"
                               required>
                        @error('tanggal_mulai')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_berakhir" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar-check mr-2 text-teal-600"></i>
                            Tanggal Berakhir <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('tanggal_berakhir') border-red-500 @enderror">
                        <p class="text-gray-500 text-xs mt-1">Akan terisi otomatis jika status tidak aktif</p>
                        @error('tanggal_berakhir')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="file_sk" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-upload mr-2 text-teal-600"></i>
                        Upload File SK <span class="text-gray-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="file" name="file_sk" id="file_sk" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('file_sk') border-red-500 @enderror">
                    <p class="text-gray-500 text-xs mt-1">Format: PDF, JPG, PNG. Max: 2MB</p>
                    @error('file_sk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="status" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-toggle-on mr-2 text-teal-600"></i>
                        Status
                    </label>
                    <select name="status" id="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('status') border-red-500 @enderror"
                            required onchange="toggleAlasan()">
                        <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4 hidden" id="alasanContainer">
                    <label for="alasan_tidak_aktif" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-comment-alt mr-2 text-teal-600"></i>
                        Alasan Tidak Aktif
                    </label>
                    <textarea name="alasan_tidak_aktif" id="alasan_tidak_aktif" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('alasan_tidak_aktif') border-red-500 @enderror"
                              placeholder="Jelaskan alasan tidak aktif...">{{ old('alasan_tidak_aktif') }}</textarea>
                    @error('alasan_tidak_aktif')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-6 mt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-6 py-3 rounded-lg hover:from-teal-700 hover:to-cyan-700 transition duration-200 font-semibold shadow-md">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data Beasiswa
                    </button>
                    <a href="{{ route('admin.beasiswa.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleAlasan() {
            const status = document.getElementById('status').value;
            const alasanContainer = document.getElementById('alasanContainer');
            if (status === 'tidak_aktif') {
                alasanContainer.classList.remove('hidden');
            } else {
                alasanContainer.classList.add('hidden');
            }
        }
        // Run on page load
        toggleAlasan();
    </script>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
