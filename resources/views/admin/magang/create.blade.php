<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa Magang - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.magang.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">
                <i class="fas fa-plus-circle mr-2"></i>
                Tambah Mahasiswa Magang
            </h2>
            <p class="text-emerald-100 text-sm">Formulir penambahan mahasiswa magang</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <p class="font-semibold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Validasi Gagal</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.magang.store') }}" method="POST" class="bg-white rounded-xl shadow-md p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Mahasiswa -->
                <div class="md:col-span-2">
                    <label for="mahasiswa_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Mahasiswa <span class="text-red-500">*</span>
                    </label>
                    <select id="mahasiswa_id" name="mahasiswa_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('mahasiswa_id') border-red-500 @enderror">
                        <option value="">Pilih Mahasiswa</option>
                        @foreach($mahasiswas as $mhs)
                            <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->name }} - {{ $mhs->nim }} ({{ $mhs->programStudi->nama ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Ajar -->
                <div>
                    <label for="tahun_ajar_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun Ajar <span class="text-red-500">*</span>
                    </label>
                    <select id="tahun_ajar_id" name="tahun_ajar_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tahun_ajar_id') border-red-500 @enderror">
                        @foreach($tahunAjarList as $ta)
                            <option value="{{ $ta->id }}" 
                                {{ old('tahun_ajar_id', $ta->id == $tahunAjarAktif->id ? $ta->id : '') == $ta->id ? 'selected' : '' }}>
                                {{ $ta->nama }} ({{ ucfirst($ta->semester) }})
                                @if($ta->is_active)
                                    - Aktif
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('tahun_ajar_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Semester -->
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                        Semester <span class="text-red-500">*</span>
                    </label>
                    <select id="semester" name="semester" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('semester') border-red-500 @enderror">
                        <option value="">Pilih Semester</option>
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>
                                Semester {{ $i }}
                            </option>
                        @endfor
                    </select>
                    @error('semester')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Perusahaan -->
                <div class="md:col-span-2">
                    <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Perusahaan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_perusahaan" name="nama_perusahaan"
                           value="{{ old('nama_perusahaan') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama_perusahaan') border-red-500 @enderror">
                    @error('nama_perusahaan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi Perusahaan -->
                <div class="md:col-span-2">
                    <label for="lokasi_perusahaan" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi Perusahaan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="lokasi_perusahaan" name="lokasi_perusahaan"
                           value="{{ old('lokasi_perusahaan') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_perusahaan') border-red-500 @enderror">
                    @error('lokasi_perusahaan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pembimbing Lapangan -->
                <div>
                    <label for="pembimbing_lapangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Pembimbing Lapangan
                    </label>
                    <input type="text" id="pembimbing_lapangan" name="pembimbing_lapangan"
                           value="{{ old('pembimbing_lapangan') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('pembimbing_lapangan') border-red-500 @enderror">
                    @error('pembimbing_lapangan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telp Pembimbing -->
                <div>
                    <label for="no_telp_pembimbing" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telp Pembimbing
                    </label>
                    <input type="text" id="no_telp_pembimbing" name="no_telp_pembimbing"
                           value="{{ old('no_telp_pembimbing') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('no_telp_pembimbing') border-red-500 @enderror">
                    @error('no_telp_pembimbing')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dosen Pembimbing Nama -->
                <div>
                    <label for="dosen_pembimbing_nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Dosen Pembimbing
                    </label>
                    <input type="text" id="dosen_pembimbing_nama" name="dosen_pembimbing_nama"
                           value="{{ old('dosen_pembimbing_nama') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('dosen_pembimbing_nama') border-red-500 @enderror">
                    @error('dosen_pembimbing_nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dosen Pembimbing NIK -->
                <div>
                    <label for="dosen_pembimbing_nik" class="block text-sm font-medium text-gray-700 mb-2">
                        NIK Dosen Pembimbing
                    </label>
                    <input type="text" id="dosen_pembimbing_nik" name="dosen_pembimbing_nik"
                           value="{{ old('dosen_pembimbing_nik') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('dosen_pembimbing_nik') border-red-500 @enderror">
                    @error('dosen_pembimbing_nik')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Mulai -->
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                           value="{{ old('tanggal_mulai') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tanggal_mulai') border-red-500 @enderror">
                    @error('tanggal_mulai')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                           value="{{ old('tanggal_selesai') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tanggal_selesai') border-red-500 @enderror">
                    @error('tanggal_selesai')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status') border-red-500 @enderror">
                        <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="tidak_aktif" {{ old('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan -->
                <div class="md:col-span-2">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea id="catatan" name="catatan" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 mt-8 pt-6 border-t">
                <button type="submit"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2 shadow-lg">
                    <i class="fas fa-save"></i>
                    Simpan
                </button>
                <a href="{{ route('admin.magang.index') }}"
                   class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg transition duration-200 font-semibold flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-sm border-t mt-12 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Sistem Kemahasiswaan. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
