<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kompetisi - Sistem Kemahasiswaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.kompetisi.index') }}" class="flex items-center gap-2 hover:opacity-80 transition">
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
                    <h2 class="text-2xl font-bold text-gray-800">Edit Kompetisi</h2>
                    <p class="text-gray-500 text-sm">Perbarui informasi kompetisi mahasiswa</p>
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

            <form action="{{ route('admin.kompetisi.update', $kompetisi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Informasi Kompetisi -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-trophy text-emerald-600 mr-2"></i>Informasi Kompetisi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Level Kegiatan <span class="text-red-500">*</span></label>
                                <select name="level_kegiatan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                    <option value="">Pilih Level</option>
                                    <option value="Kabupaten/Kota" {{ old('level_kegiatan', $kompetisi->level_kegiatan) == 'Kabupaten/Kota' ? 'selected' : '' }}>Kabupaten/Kota</option>
                                    <option value="Provinsi/wilayah" {{ old('level_kegiatan', $kompetisi->level_kegiatan) == 'Provinsi/wilayah' ? 'selected' : '' }}>Provinsi/wilayah</option>
                                    <option value="Nasional" {{ old('level_kegiatan', $kompetisi->level_kegiatan) == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Internasional" {{ old('level_kegiatan', $kompetisi->level_kegiatan) == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                                @error('level_kegiatan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->nama }}" {{ old('kategori', $kompetisi->kategori) == $kategori->nama ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">Nama Kompetisi/Lomba <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_kompetisi" value="{{ old('nama_kompetisi', $kompetisi->nama_kompetisi) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                @error('nama_kompetisi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Cabang</label>
                                <input type="text" name="nama_cabang" value="{{ old('nama_cabang', $kompetisi->nama_cabang) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('nama_cabang')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Peringkat <span class="text-red-500">*</span></label>
                                <select name="peringkat" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                    <option value="">Pilih Peringkat</option>
                                    <option value="Juara 1" {{ old('peringkat', $kompetisi->peringkat) == 'Juara 1' ? 'selected' : '' }}>Juara 1</option>
                                    <option value="Juara 2" {{ old('peringkat', $kompetisi->peringkat) == 'Juara 2' ? 'selected' : '' }}>Juara 2</option>
                                    <option value="Juara 3" {{ old('peringkat', $kompetisi->peringkat) == 'Juara 3' ? 'selected' : '' }}>Juara 3</option>
                                    <option value="Harapan 1" {{ old('peringkat', $kompetisi->peringkat) == 'Harapan 1' ? 'selected' : '' }}>Harapan 1</option>
                                    <option value="Harapan 2" {{ old('peringkat', $kompetisi->peringkat) == 'Harapan 2' ? 'selected' : '' }}>Harapan 2</option>
                                    <option value="Harapan 3" {{ old('peringkat', $kompetisi->peringkat) == 'Harapan 3' ? 'selected' : '' }}>Harapan 3</option>
                                    <option value="Apresiasi Kejuaraan" {{ old('peringkat', $kompetisi->peringkat) == 'Apresiasi Kejuaraan' ? 'selected' : '' }}>Apresiasi Kejuaraan</option>
                                    <option value="Penghargaan Tambahan" {{ old('peringkat', $kompetisi->peringkat) == 'Penghargaan Tambahan' ? 'selected' : '' }}>Penghargaan Tambahan</option>
                                    <option value="Juara Umum" {{ old('peringkat', $kompetisi->peringkat) == 'Juara Umum' ? 'selected' : '' }}>Juara Umum</option>
                                    <option value="Peserta" {{ old('peringkat', $kompetisi->peringkat) == 'Peserta' ? 'selected' : '' }}>Peserta</option>
                                </select>
                                @error('peringkat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Penyelenggara <span class="text-red-500">*</span></label>
                                <input type="text" name="penyelenggara" value="{{ old('penyelenggara', $kompetisi->penyelenggara) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                @error('penyelenggara')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Jumlah PT/Negara Peserta</label>
                                <input type="text" name="jumlah_pt_negara_peserta" value="{{ old('jumlah_pt_negara_peserta', $kompetisi->jumlah_pt_negara_peserta) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('jumlah_pt_negara_peserta')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Kepesertaan <span class="text-red-500">*</span></label>
                                <select name="kepesertaan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                    <option value="">Pilih Kepesertaan</option>
                                    <option value="Individu" {{ old('kepesertaan', $kompetisi->kepesertaan) == 'Individu' ? 'selected' : '' }}>Individu</option>
                                    <option value="Kelompok" {{ old('kepesertaan', $kompetisi->kepesertaan) == 'Kelompok' ? 'selected' : '' }}>Kelompok</option>
                                </select>
                                @error('kepesertaan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Bentuk <span class="text-red-500">*</span></label>
                                <select name="bentuk" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                    <option value="">Pilih Bentuk</option>
                                    <option value="Luring/Hibrida" {{ old('bentuk', $kompetisi->bentuk) == 'Luring/Hibrida' ? 'selected' : '' }}>Luring/Hibrida</option>
                                    <option value="Daring" {{ old('bentuk', $kompetisi->bentuk) == 'Daring' ? 'selected' : '' }}>Daring</option>
                                </select>
                                @error('bentuk')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">URL Kompetisi</label>
                                <input type="url" name="url_kompetisi" value="{{ old('url_kompetisi', $kompetisi->url_kompetisi) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('url_kompetisi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Peserta -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-users text-emerald-600 mr-2"></i>Data Peserta
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">NIM <span class="text-red-500">*</span></label>
                                <input type="text" name="nim" value="{{ old('nim', $kompetisi->nim) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                @error('nim')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Mahasiswa <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $kompetisi->nama_mahasiswa) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                                @error('nama_mahasiswa')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">NIDN/NUPTK</label>
                                <input type="text" name="nidn_nuptk" value="{{ old('nidn_nuptk', $kompetisi->nidn_nuptk) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('nidn_nuptk')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Nama Dosen</label>
                                <input type="text" name="nama_dosen" value="{{ old('nama_dosen', $kompetisi->nama_dosen) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('nama_dosen')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-semibold mb-2">Surat Tugas (PDF)</label>
                                <input type="file" name="url_surat_tugas" accept=".pdf"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @if($kompetisi->url_surat_tugas)
                                <p class="text-xs text-gray-500 mt-1">File saat ini: {{ basename($kompetisi->url_surat_tugas) }}</p>
                                @endif
                                @error('url_surat_tugas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">
                            <i class="fas fa-file-upload text-emerald-600 mr-2"></i>Dokumen
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Dokumen Sertifikat (PDF)</label>
                                <input type="file" name="dokumen_sertifikat" accept=".pdf"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @if($kompetisi->dokumen_sertifikat)
                                <p class="text-xs text-gray-500 mt-1">File saat ini: {{ basename($kompetisi->dokumen_sertifikat) }}</p>
                                @endif
                                @error('dokumen_sertifikat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Tanggal Sertifikat</label>
                                <input type="date" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat', $kompetisi->tanggal_sertifikat?->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @error('tanggal_sertifikat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Foto UPP (JPG/PNG)</label>
                                <input type="file" name="foto_upp" accept="image/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @if($kompetisi->foto_upp)
                                <p class="text-xs text-gray-500 mt-1">File saat ini: {{ basename($kompetisi->foto_upp) }}</p>
                                @endif
                                @error('foto_upp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">Dokumen Undangan</label>
                                <input type="file" name="dokumen_undangan" accept=".pdf,image/*"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                @if($kompetisi->dokumen_undangan)
                                <p class="text-xs text-gray-500 mt-1">File saat ini: {{ basename($kompetisi->dokumen_undangan) }}</p>
                                @endif
                                @error('dokumen_undangan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 mt-6 border-t">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white px-6 py-3 rounded-lg hover:from-yellow-600 hover:to-orange-700 transition duration-200 font-semibold shadow-md">
                        <i class="fas fa-save mr-2"></i>Update Kompetisi
                    </button>
                    <a href="{{ route('admin.kompetisi.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
