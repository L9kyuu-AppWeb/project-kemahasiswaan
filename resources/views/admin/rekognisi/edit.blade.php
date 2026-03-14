<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rekognisi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.rekognisi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Edit Rekognisi</h2>
                    <p class="text-gray-500 text-sm">Perbarui informasi rekognisi</p>
                </div>
            </div>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
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

            <form action="{{ route('admin.rekognisi.update', $rekognisi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Informasi Rekognisi -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-certificate text-cyan-600 mr-2"></i>Informasi Rekognisi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Jenis Rekognisi <span class="text-red-500">*</span></label>
                                <select name="jenis_rekognisi_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
                                    <option value="">Pilih Jenis</option>
                                    @foreach($jenisRekognisiList as $jenis)
                                    <option value="{{ $jenis->id }}" {{ old('jenis_rekognisi_id', $rekognisi->jenis_rekognisi_id) == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('jenis_rekognisi_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">Nama Rekognisi <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_rekognisi" value="{{ old('nama_rekognisi', $rekognisi->nama_rekognisi) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
                                @error('nama_rekognisi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Penyelenggara <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_penyelenggara" value="{{ old('nama_penyelenggara', $rekognisi->nama_penyelenggara) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
                                @error('nama_penyelenggara')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Tanggal Sertifikat</label>
                                <input type="date" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat', $rekognisi->tanggal_sertifikat?->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                @error('tanggal_sertifikat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">URL Rekognisi</label>
                                <input type="url" name="url_rekognisi" value="{{ old('url_rekognisi', $rekognisi->url_rekognisi) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                @error('url_rekognisi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Peserta -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-users text-cyan-600 mr-2"></i>Data Peserta
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">NIM <span class="text-red-500">*</span></label>
                                <input type="text" name="nim" value="{{ old('nim', $rekognisi->nim) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
                                @error('nim')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Mahasiswa <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $rekognisi->nama_mahasiswa) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
                                @error('nama_mahasiswa')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">NIDN/NUPTK</label>
                                <input type="text" name="nidn_nuptk" value="{{ old('nidn_nuptk', $rekognisi->nidn_nuptk) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                @error('nidn_nuptk')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Dosen</label>
                                <input type="text" name="nama_dosen" value="{{ old('nama_dosen', $rekognisi->nama_dosen) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                @error('nama_dosen')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-file-upload text-cyan-600 mr-2"></i>Dokumen
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Dokumen Sertifikat (PDF)</label>
                                <input type="file" name="dokumen_sertifikat" accept=".pdf"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                @if($rekognisi->dokumen_sertifikat)
                                <p class="text-xs text-gray-500 mt-1">File saat ini: {{ basename($rekognisi->dokumen_sertifikat) }}</p>
                                @endif
                                @error('dokumen_sertifikat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Foto Kegiatan (JPG/PNG)</label>
                                <input type="file" name="foto_kegiatan" accept="image/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                @if($rekognisi->foto_kegiatan)
                                <p class="text-xs text-gray-500 mt-1">File saat ini: {{ basename($rekognisi->foto_kegiatan) }}</p>
                                @endif
                                @error('foto_kegiatan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Dokumen Bukti (PDF/Image)</label>
                                <input type="file" name="dokumen_bukti" accept=".pdf,image/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                @if($rekognisi->dokumen_bukti)
                                <p class="text-xs text-gray-500 mt-1">File saat ini: {{ basename($rekognisi->dokumen_bukti) }}</p>
                                @endif
                                @error('dokumen_bukti')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Surat Tugas (PDF)</label>
                                <input type="file" name="surat_tugas" accept=".pdf"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                @if($rekognisi->surat_tugas)
                                <p class="text-xs text-gray-500 mt-1">File saat ini: {{ basename($rekognisi->surat_tugas) }}</p>
                                @endif
                                @error('surat_tugas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 mt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-6 py-3 rounded-lg hover:from-yellow-600 hover:to-orange-700 transition duration-200 font-semibold shadow-md">
                        <i class="fas fa-save mr-2"></i>Update Rekognisi
                    </button>
                    <a href="{{ route('admin.rekognisi.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
